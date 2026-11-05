package com.kas.hooks;

import java.io.File;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeDriverService;
import org.openqa.selenium.chrome.ChromeOptions;

import com.kas.config.Config;

/**
 * Membuat WebDriver Chrome memakai binary dan chromedriver dari cache Selenium,
 * supaya Selenium Manager tidak perlu mengakses jaringan saat test berjalan.
 */
public final class DriverFactory {

    private DriverFactory() {
    }

    public static WebDriver create() {
        ChromeOptions options = new ChromeOptions();
        if (!Config.CHROME_BINARY.isEmpty()) {
            options.setBinary(Config.CHROME_BINARY);
        }
        options.addArguments("--window-size=1366,768", "--no-sandbox", "--disable-dev-shm-usage");

        if (Config.HEADLESS) {
            options.addArguments("--headless=new");
        }

        return new ChromeDriver(chromeDriverService(), options);
    }

    private static ChromeDriverService chromeDriverService() {
        if (Config.CHROME_DRIVER.isEmpty()) {
            return new ChromeDriverService.Builder().build();
        }

        return new ChromeDriverService.Builder()
                .usingDriverExecutable(new File(Config.CHROME_DRIVER))
                .build();
    }
}
