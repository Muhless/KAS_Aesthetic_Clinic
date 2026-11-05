package com.kas.api;

import java.io.IOException;
import java.net.CookieManager;
import java.net.CookiePolicy;
import java.net.URI;
import java.net.URLEncoder;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;
import java.nio.charset.StandardCharsets;
import java.util.LinkedHashMap;
import java.util.Map;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import java.util.stream.Collectors;

import org.openqa.selenium.json.Json;

import com.kas.config.Config;

/**
 * Menyiapkan dan membersihkan data treatment lewat HTTP API, supaya test tidak
 * bergantung pada record seeder yang dipakai bersama.
 *
 * API memakai session auth (akun admin yang sama dengan UI) dan CSRF token,
 * jadi klien ini login dulu, mengambil token dari halaman treatment, lalu
 * mengirim header X-CSRF-TOKEN pada setiap request yang mengubah data.
 */
public final class TreatmentApi {

    private static final Json JSON = new Json();
    private static final Pattern LOGIN_TOKEN = Pattern.compile("name=\"_token\" value=\"([^\"]+)\"");
    private static final Pattern CSRF_META = Pattern.compile("name=\"csrf-token\" content=\"([^\"]+)\"");

    private TreatmentApi() {
    }

    /**
     * Membuat treatment baru lewat API dan mengembalikan id-nya.
     */
    public static long create(String nama, String deskripsi, int harga, int durasi, String status) {
        Session session = Session.login();

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
        Session session = Session.login();
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

    private static final class Session {

        private final HttpClient http;
        private final String csrfToken;

        private Session(HttpClient http, String csrfToken) {
            this.http = http;
            this.csrfToken = csrfToken;
        }

        static Session login() {
            CookieManager cookies = new CookieManager(null, CookiePolicy.ACCEPT_ALL);
            HttpClient http = HttpClient.newBuilder()
                    .cookieHandler(cookies)
                    .followRedirects(HttpClient.Redirect.NORMAL)
                    .build();

            String loginPage = get(http, "/login").body();
            String loginToken = extract(LOGIN_TOKEN, loginPage, "CSRF token halaman login");

            String form = formBody(Map.of(
                    "_token", loginToken,
                    "username", Config.ADMIN_USERNAME,
                    "password", Config.ADMIN_PASSWORD));

            HttpResponse<String> login = send(http, HttpRequest.newBuilder(uri("/login"))
                    .header("Content-Type", "application/x-www-form-urlencoded")
                    .header("Accept", "text/html")
                    .POST(HttpRequest.BodyPublishers.ofString(form))
                    .build());

            if (login.uri().getPath().contains("/login")) {
                throw new IllegalStateException("Login API gagal, masih di " + login.uri());
            }

            // Session di-regenerate saat login, jadi token diambil ulang setelah login.
            String csrfToken = extract(CSRF_META, get(http, "/treatment").body(), "CSRF token halaman treatment");
            return new Session(http, csrfToken);
        }

        HttpResponse<String> sendJson(String method, String path, String body) {
            HttpRequest.Builder builder = HttpRequest.newBuilder(uri(path))
                    .header("Accept", "application/json")
                    .header("Content-Type", "application/json")
                    .header("X-CSRF-TOKEN", csrfToken);

            HttpRequest request = switch (method) {
                case "POST" -> builder.POST(HttpRequest.BodyPublishers.ofString(body)).build();
                case "DELETE" -> builder.DELETE().build();
                default -> throw new IllegalArgumentException("Method tidak didukung: " + method);
            };

            return send(http, request);
        }

        private static HttpResponse<String> get(HttpClient http, String path) {
            return send(http, HttpRequest.newBuilder(uri(path))
                    .header("Accept", "text/html")
                    .GET()
                    .build());
        }
    }

    private static HttpResponse<String> send(HttpClient http, HttpRequest request) {
        try {
            return http.send(request, HttpResponse.BodyHandlers.ofString());
        } catch (InterruptedException e) {
            Thread.currentThread().interrupt();
            throw new IllegalStateException("Request API terinterupsi: " + request.uri(), e);
        } catch (IOException e) {
            throw new IllegalStateException("Request API gagal: " + request.uri(), e);
        }
    }

    private static URI uri(String path) {
        return URI.create(Config.BASE_URL + path);
    }

    private static String formBody(Map<String, String> fields) {
        return fields.entrySet().stream()
                .map(entry -> urlEncode(entry.getKey()) + "=" + urlEncode(entry.getValue()))
                .collect(Collectors.joining("&"));
    }

    private static String urlEncode(String value) {
        return URLEncoder.encode(value, StandardCharsets.UTF_8);
    }

    private static String extract(Pattern pattern, String html, String what) {
        Matcher matcher = pattern.matcher(html);
        if (!matcher.find()) {
            throw new IllegalStateException("Tidak menemukan " + what);
        }
        return matcher.group(1);
    }
}
