package com.kas.config;

public final class Config {

    public static final String BASE_URL = System.getProperty("baseUrl", "http://localhost:8001");
    public static final String ADMIN_USERNAME = System.getProperty("adminUsername", "admin");
    public static final String ADMIN_PASSWORD = System.getProperty("adminPassword", "password123");
    public static final boolean HEADLESS = Boolean.parseBoolean(System.getProperty("headless", "false"));
    public static final boolean RESET_DB = Boolean.parseBoolean(System.getProperty("resetDb", "true"));

    private Config() {
    }
}
