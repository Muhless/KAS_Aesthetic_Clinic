package com.kas.api;

import java.net.http.HttpResponse;
import java.util.LinkedHashMap;
import java.util.Map;

import org.openqa.selenium.json.Json;

/**
 * Menyiapkan dan membersihkan data treatment lewat HTTP API, supaya test tidak
 * bergantung pada record seeder yang dipakai bersama.
 *
 * Sesi login dan CSRF token ditangani oleh {@link ApiSession}.
 */
public final class TreatmentApi {

    private static final Json JSON = new Json();

    private TreatmentApi() {
    }

    /**
     * Membuat treatment baru lewat API dan mengembalikan id-nya.
     */
    public static long create(String nama, String deskripsi, int harga, int durasi, String status) {
        ApiSession session = ApiSession.login();

        Map<String, Object> payload = new LinkedHashMap<>();
        payload.put("nama", nama);
        payload.put("deskripsi", deskripsi);
        payload.put("harga", harga);
        payload.put("durasi", durasi);
        payload.put("status", status);

        HttpResponse<String> response = session.sendJson("POST", "/api/treatment", JSON.toJson(payload));
        requireStatus(response, 201, "membuat treatment");

        Map<String, Object> data = dataOf(response);
        return ((Number) data.get("id")).longValue();
    }

    /**
     * Menghapus treatment lewat API.
     */
    public static void delete(long id) {
        ApiSession session = ApiSession.login();
        HttpResponse<String> response = session.sendJson("DELETE", "/api/treatment/" + id, null);
        requireStatus(response, 200, "menghapus treatment " + id);
    }

    @SuppressWarnings("unchecked")
    private static Map<String, Object> dataOf(HttpResponse<String> response) {
        Map<String, Object> body = JSON.toType(response.body(), Map.class);
        Object data = body.get("data");
        if (!(data instanceof Map)) {
            throw new IllegalStateException("Response API tidak berisi data treatment: " + response.body());
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
