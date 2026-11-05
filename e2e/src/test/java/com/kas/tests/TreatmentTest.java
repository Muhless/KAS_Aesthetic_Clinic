package com.kas.tests;

import org.testng.Assert;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;

import com.kas.base.BaseTest;
import com.kas.config.Config;
import com.kas.pages.LoginPage;
import com.kas.pages.TreatmentPage;

public class TreatmentTest extends BaseTest {

    private TreatmentPage treatmentPage;

    @BeforeMethod(alwaysRun = true)
    public void loginAndOpenTreatmentPage() {
        LoginPage loginPage = new LoginPage(driver).goTo();
        loginPage.login(Config.ADMIN_USERNAME, Config.ADMIN_PASSWORD);
        loginPage.waitForUrlContains("/login");

        treatmentPage = new TreatmentPage(driver).goTo();
        Assert.assertTrue(treatmentPage.isOnTreatmentPage(), "Halaman Treatment tidak tampil");
    }

    @Test
    public void listTreatmentAppear() {
        Assert.assertTrue(treatmentPage.treatmentCount() > 0 || treatmentPage.hasEmptyState(),
                "Daftar treatment tidak tampil (tidak ada kartu produk maupun empty state)");

    }

    @Test
    public void successfulllyAddTreatment() {
        treatmentPage.clickAdd().fillTreatment("New Treatment",
                "Treatment for whitening skin",
                "200000",
                "60"
        ).selectStatus("tersedia").submit();

        Assert.assertTrue(treatmentPage.hasSuccessMessage(), "Pesan sukses tambah treatment tidak muncul");
        Assert.assertEquals(treatmentPage.getSuccessMessage(), "Treatment berhasil ditambahkan");

        treatmentPage.waitForTreatment("Treatment Baru");
        Assert.assertTrue(treatmentPage.hasTreatment("Treatment Baru"), "Treatment baru tidak ada di daftar");
    }

}
