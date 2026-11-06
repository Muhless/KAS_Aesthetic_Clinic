package com.kas.tests;

import org.testng.Assert;
import org.testng.annotations.BeforeMethod;

import com.kas.base.BaseTest;
import com.kas.config.Config;
import com.kas.pages.LoginPage;
import com.kas.pages.PatientPage;

public class PatientTest extends BaseTest {

    private PatientPage patientPage;

    @BeforeMethod(alwaysRun = true)
    public void loginAndOpenPatientPage() {
        LoginPage loginPage = new LoginPage(driver).goTo();
        loginPage.login(Config.ADMIN_USERNAME, Config.ADMIN_PASSWORD);
        loginPage.waitForUrlNotContains("/login");

        patientPage = new PatientPage(driver).goTo();
        Assert.assertTrue(patientPage.isOnPatientPage(), "Halaman pasien tidak dapat dibuka");
    }

}
