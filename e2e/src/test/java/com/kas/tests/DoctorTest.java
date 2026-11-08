package com.kas.tests;

import org.junit.jupiter.api.Test;
import org.testng.Assert;
import org.testng.annotations.BeforeMethod;

import com.kas.base.BaseTest;
import com.kas.config.Config;
import com.kas.pages.DoctorPage;
import com.kas.pages.LoginPage;

public class DoctorTest extends BaseTest {

    private DoctorPage doctorPage;

    private static final String SPECIALIZATION = "Kecantikan";
    private static final String PHONE = "01910910190";
    private static final String BIRTH_DATE = "1990-01-05";
    private static final String COST = "150000";
    private static final String PASSWORD = "dokter123";

    @BeforeMethod(alwaysRun = true)

    public void loginAndOpenDoctorPage() {
        LoginPage loginPage = new LoginPage(driver).goTo();
        loginPage.login(Config.ADMIN_USERNAME, Config.ADMIN_PASSWORD);
        loginPage.waitForUrlContains("/dokter");

        doctorPage = new DoctorPage(driver).goTo();
        Assert.assertTrue(doctorPage.isOnDoctorPage(), "Unavailable to open Doctor pages");
    }

    @Test
    public void doctorCardAppears() {
        Assert.assertTrue(doctorPage.doctorCount() > 0 || doctorPage.hasEmptyState(), "There is no doctor yet");
    }

    @Test
    public void successfullyAddDoctor() {
        String name = uniqueName("new doctor");
        String email = "dokter" + System.nanoTime() + "@kas.test";
        String username = "dokter" + System.nanoTime();

        doctorPage.clickAdd().fillDoctor(name, email, SPECIALIZATION, PHONE, COST, username, PASSWORD).selectBirthDate(BIRTH_DATE).submit();

        Assert.assertTrue(doctorPage.hasSuccessMessage(), "successfully add new doctor data message not appear");
        Assert.assertEquals(doctorPage.getSuccessMessage(), "Dokter berhasil ditambahkan.");

        doctorPage.waitForDoctor(name);
        Assert.assertTrue(doctorPage.doctorNames().contains(name), "Dokter baru tidak ada di daftar");
    }

    @Test
    public void editPasienBerhasil() {
        String nama = uniqueName("Pasien Edit");
        String namaBaru = nama + " Updated";
        createPatient(nama);

        doctorPage.goTo()
                .openDoctor(nama)
                .clickEdit()
                .fillDoctorName(namaBaru)
                .submit();

        Assert.assertTrue(doctorPage.hasSuccessMessage(), "Pesan sukses edit pasien tidak muncul");
        Assert.assertEquals(doctorPage.getSuccessMessage(), "Data pasien berhasil diperbarui.");

        doctorPage.waitForDoctor(namaBaru);
        Assert.assertTrue(doctorPage.doctorNames().contains(namaBaru), "Nama pasien tidak berubah");
    }

    @Test
    public void hapusPasienBerhasil() {
        String nama = uniqueName("Pasien Hapus");
        createPatient(nama);

        doctorPage.goTo().deleteDoctor(nama);

        Assert.assertTrue(doctorPage.hasSuccessMessage(), "Pesan sukses hapus pasien tidak muncul");
        Assert.assertEquals(doctorPage.getSuccessMessage(), "Data pasien berhasil dihapus.");

        doctorPage.waitForDoctorGone(nama);
        Assert.assertFalse(doctorPage.doctorNames().contains(nama), "Pasien masih ada setelah dihapus");
    }

    private void createPatient(String nama) {
        doctorPage.goTo()
                .clickAdd()
                .fillDoctor(nama, SPECIALIZATION, PHONE, nama, SPECIALIZATION, nama, PASSWORD)
                .selectBirthDate(BIRTH_DATE)
                .submit();

        doctorPage.waitForDoctor(nama);
    }

    private static String uniqueName(String prefix) {
        return prefix + " " + System.nanoTime();
    }
}
