package com.kas.tests;

import org.openqa.selenium.By;
import org.testng.Assert;
import org.testng.annotations.DataProvider;
import org.testng.annotations.Test;

import com.kas.base.BaseTest;
import com.kas.config.Config;
import com.kas.pages.LoginPage;

public class LoginTest extends BaseTest {

    @Test
    public void loginWithValidData() {
        LoginPage loginPage = new LoginPage(driver).goTo();
        loginPage.login(Config.ADMIN_USERNAME, Config.ADMIN_PASSWORD);
        loginPage.waitForUrlNotContains("/login");

        Assert.assertEquals(driver.getCurrentUrl(), Config.BASE_URL + "/");
    }

    @Test
    public void loginWithWrongPassword() {
        LoginPage loginPage = new LoginPage(driver).goTo();
        loginPage.login(Config.ADMIN_USERNAME, "password-salah");

        Assert.assertFalse(loginPage.getErrorMessage().isEmpty());
    }

    @Test
    public void loginWithUsernameNotRegistered() {
        LoginPage loginPage = new LoginPage(driver).goTo();
        loginPage.login("user-tidak-ada", Config.ADMIN_PASSWORD);

        Assert.assertFalse(loginPage.getErrorMessage().isEmpty());
    }

    @Test
    public void loginWithEmptyForm() {
        LoginPage loginPage = new LoginPage(driver).goTo();
        loginPage.login("", "");
        String validationMessage = driver.findElement(By.cssSelector("input[name='username']"))
                .getAttribute("validationMessage");

        Assert.assertFalse(validationMessage.isEmpty(), "Browser harus menolak submit form kosong");
        Assert.assertTrue(driver.getCurrentUrl().contains("/login"));
    }

    @DataProvider(name = "allRole")
    public Object[][] allRole() {
        return new Object[][]{
            {"admin", "/"},
            {"dokter", "/nakes"},
            {"perawat", "/"}
        };
    }

    @Test(dataProvider = "allRole")
    public void allRoleCanLogin(String username, String expectedRoute) {
        LoginPage loginPage = new LoginPage(driver).goTo();
        loginPage.login(username, Config.ADMIN_PASSWORD);
        loginPage.waitForUrlNotContains("/login");

        Assert.assertEquals(driver.getCurrentUrl(), Config.BASE_URL + expectedRoute);
    }

}
