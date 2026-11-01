package com.kas.hooks;

import org.openqa.selenium.chrome.ChromeDriver;

import com.kas.pages.LoginPage;

import io.cucumber.java.After;
import io.cucumber.java.Before;

public class Hooks {

    @Before(order = 0)
    public void setUp() {
        DriverManager.set(new ChromeDriver());
    }

    @Before(value = "@requiresLogin", order = 10)
    public void autoLogin() {
        LoginPage loginPage = new LoginPage(DriverManager.get());
        loginPage.goTo();
        loginPage.login("admin", "password123");
        loginPage.isOnDashboard();
    }

    @After
    public void tearDown() {
        DriverManager.quit();
    }
}
