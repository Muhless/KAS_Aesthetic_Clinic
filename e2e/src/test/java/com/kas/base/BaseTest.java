package com.kas.base;

import java.io.File;
import java.io.IOException;
import java.nio.charset.StandardCharsets;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;

import org.openqa.selenium.OutputType;
import org.openqa.selenium.TakesScreenshot;
import org.openqa.selenium.WebDriver;
import org.testng.ITestResult;
import org.testng.annotations.AfterMethod;
import org.testng.annotations.BeforeMethod;

import com.kas.hooks.DatabaseReset;
import com.kas.hooks.DriverFactory;

public class BaseTest {

    private static final Path FAILURE_DIR = Paths.get("target", "failure-artifacts");
    private static final DateTimeFormatter TIMESTAMP = DateTimeFormatter.ofPattern("yyyyMMdd-HHmmss");

    protected WebDriver driver;

    @BeforeMethod
    public void setUp() {
        DatabaseReset.reset();
        driver = DriverFactory.create();
    }

    @AfterMethod(alwaysRun = true)
    public void tearDown(ITestResult result) {
        if (driver == null) {
            return;
        }

        if (!result.isSuccess()) {
            captureFailure(result);
        }

        boolean keepBrowser = Boolean.parseBoolean(System.getProperty("keepBrowserOnFailure", "false"));
        if (result.isSuccess() || !keepBrowser) {
            driver.quit();
        }
    }

    /**
     * Menyimpan bukti saat test gagal: screenshot, URL terakhir, dan page source.
     * File ada di {@code target/failure-artifacts/}.
     */
    private void captureFailure(ITestResult result) {
        String name = result.getTestClass().getRealClass().getSimpleName()
                + "." + result.getMethod().getMethodName()
                + "-" + LocalDateTime.now().format(TIMESTAMP);

        try {
            Files.createDirectories(FAILURE_DIR);

            File screenshot = ((TakesScreenshot) driver).getScreenshotAs(OutputType.FILE);
            Files.copy(screenshot.toPath(), FAILURE_DIR.resolve(name + ".png"));

            String url = driver.getCurrentUrl();
            Files.writeString(FAILURE_DIR.resolve(name + ".url.txt"), url, StandardCharsets.UTF_8);
            Files.writeString(FAILURE_DIR.resolve(name + ".html"),
                    driver.getPageSource(), StandardCharsets.UTF_8);

            System.out.println("[FAILURE] " + result.getTestClass().getRealClass().getName()
                    + "." + result.getMethod().getMethodName()
                    + " | URL: " + url
                    + " | bukti: " + FAILURE_DIR.resolve(name).toAbsolutePath());
        } catch (IOException | RuntimeException e) {
            System.out.println("[FAILURE] Gagal menyimpan bukti untuk "
                    + result.getMethod().getMethodName() + ": " + e.getMessage());
        }
    }
}
