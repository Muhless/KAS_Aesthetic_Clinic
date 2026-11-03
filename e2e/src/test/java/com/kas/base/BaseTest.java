package com.kas.base;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;
import org.testng.annotations.AfterMethod;
import org.testng.annotations.BeforeMethod;

import com.kas.config.Config;
import com.kas.hooks.DatabaseReset;

public class BaseTest {

    protected WebDriver driver;

    @BeforeMethod
    public void setUp() {
        DatabaseReset.reset();

        ChromeOptions options = new ChromeOptions();
        options.addArguments("--window-size=1366,768", "--no-sandbox", "--disable-dev-shm-usage");

        if (Config.HEADLESS) {
            options.addArguments("--headless=new");
        }

        driver = new ChromeDriver(options);
    }

    @AfterMethod(alwaysRun = true)
    public void tearDown() {
        if (driver != null) {
            driver.quit();
        }
    }
}
