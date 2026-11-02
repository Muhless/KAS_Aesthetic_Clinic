package com.kas.hooks;

import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;

import com.kas.config.Config;
import com.kas.pages.LoginPage;

import io.cucumber.java.After;
import io.cucumber.java.Before;

public class Hooks {

    @Before(order = 0)
    public void setUp() {
        ChromeOptions options = new ChromeOptions();
        options.addArguments("--window-size=1366,768", "--no-sandbox", "--disable-dev-shm-usage");

        if (Config.HEADLESS) {
            options.addArguments("--headless=new");
        }

        DriverManager.set(new ChromeDriver(options));
    }

    @Before(value = "@requiresLogin", order = 10)
    public void autoLogin() {
        LoginPage loginPage = new LoginPage(DriverManager.get());
        loginPage.goTo();
        loginPage.login(Config.ADMIN_USERNAME, Config.ADMIN_PASSWORD);
        loginPage.waitForUrlNotContains("/login");
    }

    @After
    public void tearDown() {
        DriverManager.quit();
    }
}
