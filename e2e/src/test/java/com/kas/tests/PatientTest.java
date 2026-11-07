package com.kas.tests;

import org.testng.Assert;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;

import com.kas.base.BaseTest;
import com.kas.config.Config;
import com.kas.pages.LoginPage;
import com.kas.pages.PatientPage;

public class PatientTest extends BaseTest {

    private static final String BIRTH_DATE = "1990-01-15";
    private static final String PHONE = "081234567890";

    private PatientPage patientPage;

    @BeforeMethod(alwaysRun = true)
    public void loginAndOpenPatientPage() {
        LoginPage loginPage = new LoginPage(driver).goTo();
        loginPage.login(Config.ADMIN_USERNAME, Config.ADMIN_PASSWORD);
        loginPage.waitForUrlNotContains("/login");

        patientPage = new PatientPage(driver).goTo();
        Assert.assertTrue(patientPage.isOnPatientPage(), "Halaman Pasien tidak dapat dibuka");
    }

    @Test
    public void daftarPasienTampil() {
        Assert.assertTrue(patientPage.patientCount() > 0 || patientPage.hasEmptyState(),
                "Daftar pasien tidak tampil (tidak ada baris pasien maupun empty state)");
    }

    @Test
    public void tambahPasienBerhasil() {
        String nama = uniqueName("Pasien Baru");

        patientPage.clickAdd()
                .fillPatient(nama, PHONE)
                .selectGender("laki-laki")
                .setBirthDate(BIRTH_DATE)
                .submit();

        Assert.assertTrue(patientPage.hasSuccessMessage(), "Pesan sukses tambah pasien tidak muncul");
        Assert.assertEquals(patientPage.getSuccessMessage(), "Pasien berhasil ditambahkan.");

        patientPage.waitForPatient(nama);
        Assert.assertTrue(patientPage.patientNames().contains(nama), "Pasien baru tidak ada di daftar");
    }

    @Test
    public void editPasienBerhasil() {
        String nama = uniqueName("Pasien Edit");
        String namaBaru = nama + " Updated";
        createPatient(nama);

        patientPage.goTo()
                .openPatient(nama)
                .clickEdit()
                .fillPatientName(namaBaru)
                .submit();

        Assert.assertTrue(patientPage.hasSuccessMessage(), "Pesan sukses edit pasien tidak muncul");
        Assert.assertEquals(patientPage.getSuccessMessage(), "Data pasien berhasil diperbarui.");

        patientPage.waitForPatient(namaBaru);
        Assert.assertTrue(patientPage.patientNames().contains(namaBaru), "Nama pasien tidak berubah");
    }

    @Test
    public void hapusPasienBerhasil() {
        String nama = uniqueName("Pasien Hapus");
        createPatient(nama);

        patientPage.goTo().deletePatient(nama);

        Assert.assertTrue(patientPage.hasSuccessMessage(), "Pesan sukses hapus pasien tidak muncul");
        Assert.assertEquals(patientPage.getSuccessMessage(), "Data pasien berhasil dihapus.");

        patientPage.waitForPatientGone(nama);
        Assert.assertFalse(patientPage.patientNames().contains(nama), "Pasien masih ada setelah dihapus");
    }

    private void createPatient(String nama) {
        patientPage.goTo()
                .clickAdd()
                .fillPatient(nama, PHONE)
                .selectGender("laki-laki")
                .setBirthDate(BIRTH_DATE)
                .submit();

        patientPage.waitForPatient(nama);
    }

    private static String uniqueName(String prefix) {
        return prefix + " " + System.nanoTime();
    }
}
