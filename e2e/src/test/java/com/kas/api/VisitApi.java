package com.kas.api;

import java.net.http.HttpResponse;
import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;

import org.openqa.selenium.json.Json;

/**
 * Menyiapkan dan membersihkan data kunjungan lewat API khusus e2e
 * ({@code POST /api/e2e/visits}).
 *
 * Satu panggilan membuat Pasien + Pelayanan hari ini sekaligus, karena halaman
 * /nakes hanya menampilkan Pelayanan hari ini milik dokter yang login.
 * Kalau status bukan "menunggu", endpoint juga membuat Pemeriksaan (beserta
 * Pembayaran) sehingga skenario "Periksa" bisa disiapkan tanpa UI.
 * Endpoint ini hanya aktif saat APP_ENV=testing.
 */
public final class VisitApi {

    private static final Json JSON = new Json();

    private VisitApi() {
    }

    /** Id record yang dibuat, dipakai untuk assertion atau pembersihan. */
    public record Visit(long pasienId, long pelayananId, Long pemeriksaanId, String pemeriksaanEditUrl) {

        public boolean hasPemeriksaan() {
            return pemeriksaanId != null && pemeriksaanId > 0;
        }
    }

    /**
     * Membuat pasien beserta pelayanan hari ini (status menunggu) untuk
     * dokter tertentu.
     *
     * @param namaPasien nama pasien (sebaiknya unik per test)
     * @param usernameDokter username user dokter pemilik pelayanan
     * @param keluhan keluhan pasien, boleh {@code null}
     */
    public static Visit createForDokter(String namaPasien, String usernameDokter, String keluhan) {
        return createForDokter(namaPasien, usernameDokter, keluhan, "menunggu");
    }

    /**
     * Sama seperti {@link #createForDokter(String, String, String)}, tapi
     * status kunjungan bisa ditentukan.
     */
    public static Visit createForDokter(String namaPasien, String usernameDokter, String keluhan, String status) {
        Map<String, Object> payload = new LinkedHashMap<>();
        payload.put("nama_pasien", namaPasien);
        payload.put("username_dokter", usernameDokter);
        payload.put("keluhan", keluhan);
        payload.put("status", status);

        return create(payload);
    }

    /**
     * Membuat kunjungan yang sudah siap diperiksa: pasien + pelayanan
     * berstatus "dipanggil" + pemeriksaan kosong + produk yang dipilih.
     */
    public static Visit createExamined(String namaPasien, String usernameDokter, String keluhan,
            long treatmentId, List<Long> produkIds) {
        Map<String, Object> payload = new LinkedHashMap<>();
        payload.put("nama_pasien", namaPasien);
        payload.put("username_dokter", usernameDokter);
        payload.put("keluhan", keluhan);
        payload.put("status", "dipanggil");
        payload.put("treatment_id", treatmentId);
        payload.put("produk_ids", produkIds);

        return create(payload);
    }

    /** Menghapus pelayanan (dan pasiennya kalau tidak punya kunjungan lain). */
    public static void delete(long pelayananId) {
        ApiSession session = ApiSession.login();
        HttpResponse<String> response = session.sendJson("DELETE", "/api/e2e/visits/" + pelayananId, null);
        requireStatus(response, 200, "menghapus kunjungan " + pelayananId);
    }

    private static Visit create(Map<String, Object> payload) {
        ApiSession session = ApiSession.login();
        HttpResponse<String> response = session.sendJson("POST", "/api/e2e/visits", JSON.toJson(payload));
        requireStatus(response, 201, "membuat kunjungan");

        Map<String, Object> data = dataOf(response);
        return new Visit(
                ((Number) data.get("pasien_id")).longValue(),
                ((Number) data.get("pelayanan_id")).longValue(),
                asLong(data.get("pemeriksaan_id")),
                (String) data.get("pemeriksaan_edit_url"));
    }

    private static Long asLong(Object value) {
        return value instanceof Number number ? number.longValue() : null;
    }

    @SuppressWarnings("unchecked")
    private static Map<String, Object> dataOf(HttpResponse<String> response) {
        Map<String, Object> body = JSON.toType(response.body(), Map.class);
        Object data = body.get("data");
        if (!(data instanceof Map)) {
            throw new IllegalStateException("Response API tidak berisi data kunjungan: " + response.body());
        }
        return (Map<String, Object>) data;
    }

    private static void requireStatus(HttpResponse<String> response, int expected, String action) {
        if (response.statusCode() != expected) {
            throw new IllegalStateException("Gagal " + action
                    + " (HTTP " + response.statusCode() + "): " + response.body());
        }
    }
}
