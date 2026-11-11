package com.kas.api;

import java.net.http.HttpResponse;
import java.util.LinkedHashMap;
import java.util.Map;

import org.openqa.selenium.json.Json;

/**
 * Menyiapkan dan membersihkan data kunjungan lewat API khusus e2e
 * ({@code POST /api/e2e/visits}).
 *
 * Satu panggilan membuat Pasien + Pelayanan hari ini sekaligus, karena halaman
 * /nakes hanya menampilkan Pelayanan hari ini milik dokter yang login.
 * Endpoint ini hanya aktif saat APP_ENV=testing.
 */
public final class VisitApi {

    private static final Json JSON = new Json();

    private VisitApi() {
    }

    /** Id record yang dibuat, dipakai untuk assertion atau pembersihan. */
    public record Visit(long pasienId, long pelayananId) {
    }

    /**
     * Membuat pasien beserta pelayanan hari ini untuk dokter tertentu.
     *
     * @param namaPasien nama pasien (sebaiknya unik per test)
     * @param usernameDokter username user dokter pemilik pelayanan
     * @param keluhan keluhan pasien, boleh {@code null}
     */
    public static Visit createForDokter(String namaPasien, String usernameDokter, String keluhan) {
        ApiSession session = ApiSession.login();

        Map<String, Object> payload = new LinkedHashMap<>();
        payload.put("nama_pasien", namaPasien);
        payload.put("username_dokter", usernameDokter);
        payload.put("keluhan", keluhan);

        HttpResponse<String> response = session.sendJson("POST", "/api/e2e/visits", JSON.toJson(payload));
        requireStatus(response, 201, "membuat kunjungan");

        Map<String, Object> data = dataOf(response);
        return new Visit(
                ((Number) data.get("pasien_id")).longValue(),
                ((Number) data.get("pelayanan_id")).longValue());
    }

    /** Menghapus pelayanan (dan pasiennya kalau tidak punya kunjungan lain). */
    public static void delete(long pelayananId) {
        ApiSession session = ApiSession.login();
        HttpResponse<String> response = session.sendJson("DELETE", "/api/e2e/visits/" + pelayananId, null);
        requireStatus(response, 200, "menghapus kunjungan " + pelayananId);
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
