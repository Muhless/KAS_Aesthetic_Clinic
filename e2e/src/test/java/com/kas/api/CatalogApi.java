package com.kas.api;

import java.net.http.HttpResponse;
import java.util.List;
import java.util.Map;

import org.openqa.selenium.json.Json;

/**
 * Membaca katalog treatment/produk lewat API khusus e2e
 * ({@code GET /api/e2e/catalog}).
 *
 * Dipakai test untuk mendapatkan id record seeder tanpa menebak angka,
 * misalnya saat menyiapkan pemeriksaan lengkap dengan produk lewat API.
 */
public final class CatalogApi {

    private static final Json JSON = new Json();

    private CatalogApi() {
    }

    public static long treatmentId(String nama) {
        return findId("treatments", nama);
    }

    public static long productId(String nama) {
        return findId("produks", nama);
    }

    @SuppressWarnings("unchecked")
    private static long findId(String group, String nama) {
        ApiSession session = ApiSession.login();
        HttpResponse<String> response = session.sendJson("GET", "/api/e2e/catalog", null);
        requireStatus(response, 200, "membaca katalog e2e");

        Map<String, Object> body = JSON.toType(response.body(), Map.class);
        Map<String, Object> data = (Map<String, Object>) body.get("data");
        Object groupValue = data.get(group);
        if (!(groupValue instanceof List<?> items)) {
            throw new IllegalStateException("Katalog tidak berisi " + group + ": " + response.body());
        }

        for (Object item : items) {
            Map<String, Object> record = (Map<String, Object>) item;
            if (nama.equals(record.get("nama"))) {
                return ((Number) record.get("id")).longValue();
            }
        }

        throw new IllegalStateException("Tidak menemukan " + group + " bernama " + nama);
    }

    private static void requireStatus(HttpResponse<String> response, int expected, String action) {
        if (response.statusCode() != expected) {
            throw new IllegalStateException("Gagal " + action
                    + " (HTTP " + response.statusCode() + "): " + response.body());
        }
    }
}
