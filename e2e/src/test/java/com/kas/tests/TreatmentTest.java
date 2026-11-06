package com.kas.tests;

import org.testng.Assert;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;

import com.kas.api.TreatmentApi;
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
        loginPage.waitForUrlNotContains("/login");

        treatmentPage = new TreatmentPage(driver).goTo();
        Assert.assertTrue(treatmentPage.isOnTreatmentPage(), "Halaman Treatment tidak tampil");
    }

    @Test
    public void daftarTreatmentTampil() {
        Assert.assertTrue(treatmentPage.treatmentCount() > 0 || treatmentPage.hasEmptyState(),
                "Daftar treatment tidak tampil (tidak ada kartu treatment maupun empty state)");
    }

    @Test
    public void tambahTreatmentBerhasil() {
        treatmentPage.clickAdd()
                .fillTreatment("New Treatment", "Treatment for whitening skin", "200000", "60")
                .selectStatus("tersedia")
                .submit();

        Assert.assertTrue(treatmentPage.hasSuccessMessage(), "Pesan sukses tambah treatment tidak muncul");
        Assert.assertEquals(treatmentPage.getSuccessMessage(), "Treatment berhasil ditambahkan.");

        treatmentPage.waitForTreatment("New Treatment");
        Assert.assertTrue(treatmentPage.hasTreatment("New Treatment"), "Treatment baru tidak ada di daftar");
    }

    @Test
    public void successfullyEditTreatment() {
        String nama = uniqueName("Treatment Edit");
        TreatmentApi.create(nama, "Treatment untuk test edit", 150000, 60, "tersedia");
        treatmentPage.goTo();

        treatmentPage.clickEdit(nama).fillTreatmentName(nama + " Updated").submit();

        Assert.assertTrue(treatmentPage.hasSuccessMessage(), "Pesan sukses edit treatment tidak muncul");
        Assert.assertEquals(treatmentPage.getSuccessMessage(), "Treatment berhasil diubah.");

        treatmentPage.waitForTreatment(nama + " Updated");
        Assert.assertTrue(treatmentPage.hasTreatment(nama + " Updated"), "Nama treatment tidak berubah");
    }

    @Test
    public void successfullyDeleteTreatment() {
        String nama = uniqueName("Treatment Hapus");
        TreatmentApi.create(nama, "Treatment untuk test hapus", 150000, 60, "tersedia");
        treatmentPage.goTo();

        treatmentPage.deleteTreatment(nama);

        Assert.assertTrue(treatmentPage.hasSuccessMessage(), "Pesan sukses hapus treatment tidak muncul");
        Assert.assertEquals(treatmentPage.getSuccessMessage(), "Treatment berhasil dihapus.");

        treatmentPage.waitForTreatmentGone(nama);
        Assert.assertFalse(treatmentPage.hasTreatment(nama), "Treatment masih tampil setelah dihapus");
    }

    private static String uniqueName(String prefix) {
        return prefix + " " + System.nanoTime();
    }
}
