package com.kas.steps;

import static org.junit.jupiter.api.Assertions.assertEquals;
import static org.junit.jupiter.api.Assertions.assertFalse;
import static org.junit.jupiter.api.Assertions.assertTrue;

import com.kas.config.Config;
import com.kas.hooks.DriverManager;
import com.kas.pages.LoginPage;

import io.cucumber.java.en.Given;
import io.cucumber.java.en.Then;
import io.cucumber.java.en.When;

public class LoginSteps {
    private LoginPage loginPage;

    @Given("user is on the login page")
    public void user_is_on_the_login_page() {
        loginPage = new LoginPage(DriverManager.get()).goTo();
    }

    @Given("user already login")
    public void user_already_login() {
        loginPage = new LoginPage(DriverManager.get()).goTo();
        loginPage.login(Config.ADMIN_USERNAME, Config.ADMIN_PASSWORD);
        loginPage.waitForUrlNotContains("/login");
    }

    @When("user login as admin")
    public void user_login_as_admin() {
        if (loginPage == null) {
            loginPage = new LoginPage(DriverManager.get()).goTo();
        }
        loginPage.login(Config.ADMIN_USERNAME, Config.ADMIN_PASSWORD);
    }

    @Then("user redirected to dashboard pages")
    public void user_redirected_to_dashboard_pages() {
        loginPage.waitForUrlNotContains("/login");
        assertFalse(DriverManager.get().getCurrentUrl().contains("/login"));
    }

    @When("user login as {string} with password {string}")
    public void user_login_as_with_password(String username, String password) {
        if (loginPage == null) {
            loginPage = new LoginPage(DriverManager.get()).goTo();
        }
        loginPage.login(username, password);
    }

    @Then("error message {string} appear")
    public void error_message_appear(String errorMessage) {
        assertEquals(errorMessage, loginPage.getErrorMessage());
    }

    @Then("user still in the login page")
    public void user_still_in_the_login_page() {
        assertTrue(loginPage.isOnLoginPage());
    }
}
