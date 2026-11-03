package com.kas.hooks;

import java.io.File;
import java.io.IOException;
import java.nio.charset.StandardCharsets;

import com.kas.config.Config;

/**
 * Reset database e2e lewat proses terpisah, karena test Selenium berjalan
 * di luar proses Laravel sehingga RefreshDatabase/DatabaseTransactions
 * tidak berpengaruh.
 */
public final class DatabaseReset {

    private DatabaseReset() {
    }

    public static void reset() {
        if (!Config.RESET_DB) {
            return;
        }

        try {
            ProcessBuilder processBuilder = new ProcessBuilder(
                    "php", "artisan", "e2e:reset", "--env=testing");
            processBuilder.directory(findProjectRoot());
            processBuilder.redirectErrorStream(true);

            Process process = processBuilder.start();
            String output = new String(process.getInputStream().readAllBytes(), StandardCharsets.UTF_8);

            if (process.waitFor() != 0) {
                throw new IllegalStateException("Reset database e2e gagal:\n" + output);
            }
        } catch (IOException e) {
            throw new IllegalStateException("Gagal menjalankan php artisan e2e:reset", e);
        } catch (InterruptedException e) {
            Thread.currentThread().interrupt();
            throw new IllegalStateException("Reset database e2e terinterupsi", e);
        }
    }

    /**
     * Cari root project Laravel (folder yang punya file artisan), supaya
     * perintah tetap jalan baik dijalankan dari folder e2e maupun root.
     */
    private static File findProjectRoot() {
        File dir = new File(System.getProperty("user.dir")).getAbsoluteFile();

        while (dir != null && !new File(dir, "artisan").isFile()) {
            dir = dir.getParentFile();
        }

        if (dir == null) {
            throw new IllegalStateException("Root project Laravel (artisan) tidak ditemukan");
        }

        return dir;
    }
}
