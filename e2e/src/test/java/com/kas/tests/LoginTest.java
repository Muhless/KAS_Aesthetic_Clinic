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
    public void userValidBisaLogin() {
        LoginPage loginPage = new LoginPage(driver).goTo();
        loginPage.login(Config.ADMIN_USERNAME, Config.ADMIN_PASSWORD);
        loginPage.waitForUrlContains("/");

        Assert.assertTrue(driver.getCurrentUrl().contains("/"));
    }

    @Test
    public void passwordSalahMenampilkanError() {
        LoginPage loginPage = new LoginPage(driver).goTo();
        loginPage.login(Config.ADMIN_USERNAME, "password-salah");

        Assert.assertFalse(loginPage.getErrorMessage().isEmpty());
    }

    @Test
    public void usernameTidakTerdaftarMenampilkanError() {
        LoginPage loginPage = new LoginPage(driver).goTo();
        loginPage.login("user-tidak-ada", Config.ADMIN_PASSWORD);

        Assert.assertFalse(loginPage.getErrorMessage().isEmpty());
    }

    @Test
    public void formKosongTidakBisaLogin() {
        LoginPage loginPage = new LoginPage(driver).goTo();
        loginPage.login("", "");

        // Input punya atribut `required`, jadi browser menolak submit dan
        // validasi HTML5 yang muncul (bukan pesan error dari server).
        String validationMessage = driver.findElement(By.cssSelector("input[name='username']"))
                .getAttribute("validationMessage");

        Assert.assertFalse(validationMessage.isEmpty(), "Browser harus menolak submit form kosong");
        Assert.assertTrue(driver.getCurrentUrl().contains("/login"));
    }

    @DataProvider(name = "semuaRole")
    public Object[][] semuaRole() {
        return new Object[][] {
                { "admin" },
                { "dokter" },
                { "perawat" }
        };
    }

    @Test(dataProvider = "semuaRole")
    public void semuaRoleBisaLogin(String username) {
        LoginPage loginPage = new LoginPage(driver).goTo();
        loginPage.login(username, Config.ADMIN_PASSWORD);
        loginPage.waitForUrlNotContains("/login");

        // Dokter diarahkan ke halaman nakes, role lain ke dashboard.
        String expectedPath = username.equals("dokter") ? "/nakes" : "/";
        Assert.assertEquals(driver.getCurrentUrl(), Config.BASE_URL + expectedPath);
    }
}
