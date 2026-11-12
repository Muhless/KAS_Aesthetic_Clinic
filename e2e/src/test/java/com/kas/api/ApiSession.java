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
import java.util.Map;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import java.util.stream.Collectors;

import com.kas.config.Config;

/**
 * Sesi HTTP untuk API e2e.
 *
 * API memakai session auth (akun yang sama dengan UI) dan CSRF token, jadi
 * kelas ini login lewat form, menyimpan cookie, lalu mengambil token dari
 * halaman yang sudah login. Token dikirim lewat header X-CSRF-TOKEN pada
 * setiap request yang mengubah data.
 */
public final class ApiSession {

    private static final Pattern LOGIN_TOKEN = Pattern.compile("name=\"_token\" value=\"([^\"]+)\"");
    private static final Pattern CSRF_META = Pattern.compile("name=\"csrf-token\" content=\"([^\"]+)\"");

    private final HttpClient http;
    private final String csrfToken;

    private ApiSession(HttpClient http, String csrfToken) {
        this.http = http;
        this.csrfToken = csrfToken;
    }

    /** Login sebagai admin, akun default untuk menyiapkan data e2e. */
    public static ApiSession login() {
        return loginAs(Config.ADMIN_USERNAME, Config.ADMIN_PASSWORD);
    }

    public static ApiSession loginAs(String username, String password) {
        CookieManager cookies = new CookieManager(null, CookiePolicy.ACCEPT_ALL);
        HttpClient http = HttpClient.newBuilder()
                .cookieHandler(cookies)
                .followRedirects(HttpClient.Redirect.NORMAL)
                .build();

        String loginPage = get(http, "/login").body();
        String loginToken = extract(LOGIN_TOKEN, loginPage, "CSRF token halaman login");

        String form = formBody(Map.of(
                "_token", loginToken,
                "username", username,
                "password", password));

        HttpResponse<String> login = send(http, HttpRequest.newBuilder(uri("/login"))
                .header("Content-Type", "application/x-www-form-urlencoded")
                .header("Accept", "text/html")
                .POST(HttpRequest.BodyPublishers.ofString(form))
                .build());

        if (login.uri().getPath().contains("/login")) {
            throw new IllegalStateException("Login API gagal untuk " + username + ", masih di " + login.uri());
        }

        // Session di-regenerate saat login, jadi token diambil ulang setelah login.
        String csrfToken = extract(CSRF_META, get(http, "/").body(), "CSRF token halaman dashboard");
        return new ApiSession(http, csrfToken);
    }

    public HttpResponse<String> sendJson(String method, String path, String body) {
        HttpRequest.Builder builder = HttpRequest.newBuilder(uri(path))
                .header("Accept", "application/json")
                .header("Content-Type", "application/json")
                .header("X-CSRF-TOKEN", csrfToken);

        HttpRequest request = switch (method) {
            case "GET" -> builder.GET().build();
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
