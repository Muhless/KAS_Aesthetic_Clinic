package com.kas.config;

import java.io.File;
import java.util.Arrays;
import java.util.Comparator;

public final class Config {

    public static final String BASE_URL = System.getProperty("baseUrl", "http://localhost:8001");
    public static final String ADMIN_USERNAME = System.getProperty("adminUsername", "admin");
    public static final String ADMIN_PASSWORD = System.getProperty("adminPassword", "password123");
    public static final boolean HEADLESS = Boolean.parseBoolean(System.getProperty("headless", "false"));
    public static final boolean RESET_DB = Boolean.parseBoolean(System.getProperty("resetDb", "true"));

    /**
     * Binary Chrome yang dipakai Selenium. Kalau tidak di-override lewat
     * -DchromeBinary=..., pakai Chrome for Testing yang sudah ada di cache
     * Selenium Manager supaya test tidak mengunduh browser lagi.
     */
    public static final String CHROME_BINARY = System.getProperty("chromeBinary", cachedChromeBinary());

    /**
     * Chromedriver yang dipakai Selenium. Kalau diisi, Selenium Manager tidak
     * dipanggil sama sekali sehingga test tidak menunggu akses jaringan.
     */
    public static final String CHROME_DRIVER = System.getProperty("chromeDriver", cachedChromeDriver());

    private Config() {
    }

    private static String cachedChromeBinary() {
        for (File version : cachedVersions("chrome")) {
            File binary = new File(version, "chrome");
            if (binary.canExecute()) {
                return binary.getAbsolutePath();
            }
        }

        return "";
    }

    private static String cachedChromeDriver() {
        if (!CHROME_BINARY.isEmpty()) {
            File chromeVersion = new File(CHROME_BINARY).getParentFile();
            File driver = new File(cacheDir("chromedriver"), chromeVersion.getName() + "/chromedriver");
            if (driver.canExecute()) {
                return driver.getAbsolutePath();
            }
        }

        for (File version : cachedVersions("chromedriver")) {
            File driver = new File(version, "chromedriver");
            if (driver.canExecute()) {
                return driver.getAbsolutePath();
            }
        }

        return "";
    }

    private static File[] cachedVersions(String tool) {
        File[] versions = cacheDir(tool).listFiles(File::isDirectory);
        if (versions == null) {
            return new File[0];
        }

        Arrays.sort(versions, Comparator.comparing(File::getName).reversed());
        return versions;
    }

    private static File cacheDir(String tool) {
        return new File(new File(System.getProperty("user.home"), ".cache/selenium"), tool + "/linux64");
    }
}
