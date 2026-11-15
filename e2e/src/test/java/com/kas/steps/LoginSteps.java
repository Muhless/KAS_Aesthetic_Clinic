package com.kas.steps;

import static org.junit.jupiter.api.Assertions.assertEquals;
import static org.junit.jupiter.api.Assertions.assertFalse;
import static org.junit.jupiter.api.Assertions.assertTrue;

import org.openqa.selenium.By;

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

    /**
     * Login memakai akun bawaan seeder (admin/dokter/perawat), supaya fitur
     * yang butuh role tertentu tidak menuliskan username & password manual.
     */
    @Given("user already login as {string}")
    public void user_already_login_as(String role) {
        String username = switch (role.toLowerCase()) {
            case "admin" -> Config.ADMIN_USERNAME;
            case "dokter", "doctor" -> Config.DOCTOR_USERNAME;
            case "perawat", "nurse" -> Config.NURSE_USERNAME;
            default -> role;
        };

        loginPage = new LoginPage(DriverManager.get()).goTo();
        loginPage.login(username, Config.ADMIN_PASSWORD);
        loginPage.waitForUrlNotContains("/login");
    }

    @When("user login as admin")
    public void user_login_as_admin() {
        if (loginPage == null) {
            loginPage = new LoginPage(DriverManager.get()).goTo();
        }
        loginPage.login(Config.ADMIN_USERNAME, Config.ADMIN_PASSWORD);
    }

    @When("user login as the {string} account")
    public void user_login_as_the_account(String role) {
        if (loginPage == null) {
            loginPage = new LoginPage(DriverManager.get()).goTo();
        }

        String username = switch (role.toLowerCase()) {
            case "admin" -> Config.ADMIN_USERNAME;
            case "dokter", "doctor" -> Config.DOCTOR_USERNAME;
            case "perawat", "nurse" -> Config.NURSE_USERNAME;
            default -> role;
        };

        loginPage.login(username, Config.ADMIN_PASSWORD);
    }

    @Then("user redirected to dashboard pages")
    public void user_redirected_to_dashboard_pages() {
        loginPage.waitForUrlNotContains("/login");
        assertFalse(DriverManager.get().getCurrentUrl().contains("/login"));
    }

    @Then("user is redirected to the {string} page")
    public void user_is_redirected_to_the_page(String route) {
        loginPage.waitForUrlNotContains("/login");
        assertEquals(Config.BASE_URL + route, DriverManager.get().getCurrentUrl(),
                "URL setelah login tidak sesuai");
    }

    @When("user login as {string} with password {string}")
    public void user_login_as_with_password(String username, String password) {
        if (loginPage == null) {
            loginPage = new LoginPage(DriverManager.get()).goTo();
        }
        loginPage.login(username, password);
    }

    @When("user submits the login form with empty credentials")
    public void user_submits_the_login_form_with_empty_credentials() {
        if (loginPage == null) {
            loginPage = new LoginPage(DriverManager.get()).goTo();
        }
        loginPage.login("", "");
    }

    @Then("error message {string} appear")
    public void error_message_appear(String errorMessage) {
        assertEquals(errorMessage, loginPage.getErrorMessage());
    }

    @Then("an error message appear")
    public void an_error_message_appear() {
        assertFalse(loginPage.getErrorMessage().isEmpty(), "Pesan error login tidak muncul");
    }

    @Then("browser blocks the empty login form")
    public void browser_blocks_the_empty_login_form() {
        String validationMessage = DriverManager.get()
                .findElement(By.cssSelector("input[name='username']"))
                .getAttribute("validationMessage");

        assertFalse(validationMessage.isEmpty(), "Browser harus menolak submit form kosong");
    }

    @Then("user still in the login page")
    public void user_still_in_the_login_page() {
        assertTrue(loginPage.isOnLoginPage());
    }
}
