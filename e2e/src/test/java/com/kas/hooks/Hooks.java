package com.kas.hooks;

import com.kas.config.Config;
import com.kas.pages.LoginPage;

import io.cucumber.java.After;
import io.cucumber.java.Before;

public class Hooks {

    @Before(order = -10)
    public void resetDatabase() {
        DatabaseReset.reset();
    }

    @Before(order = 0)
    public void setUp() {
        DriverManager.set(DriverFactory.create());
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
