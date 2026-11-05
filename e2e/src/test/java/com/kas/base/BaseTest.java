package com.kas.base;

import org.openqa.selenium.WebDriver;
import org.testng.annotations.AfterMethod;
import org.testng.annotations.BeforeMethod;

import com.kas.hooks.DatabaseReset;
import com.kas.hooks.DriverFactory;

public class BaseTest {

    protected WebDriver driver;

    @BeforeMethod
    public void setUp() {
        DatabaseReset.reset();
        driver = DriverFactory.create();
    }

    @AfterMethod(alwaysRun = true)
    public void tearDown() {
        if (driver != null) {
            driver.quit();
        }
    }
}
