package com.kas.tests;

import org.testng.Assert;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;

import com.kas.base.BaseTest;
import com.kas.config.Config;
import com.kas.pages.DoctorPage;
import com.kas.pages.LoginPage;

public class DoctorTest extends BaseTest {

    private static final String SPECIALIZATION = "Kecantikan";
    private static final String PHONE = "01910910190";
    private static final String BIRTH_DATE = "1990-01-05";
    private static final String COST = "150000";
    private static final String PASSWORD = "dokter123";

    private DoctorPage doctorPage;

    @BeforeMethod(alwaysRun = true)
    public void loginAndOpenDoctorPage() {
        LoginPage loginPage = new LoginPage(driver).goTo();
        loginPage.login(Config.ADMIN_USERNAME, Config.ADMIN_PASSWORD);
        loginPage.waitForUrlNotContains("/login");

        doctorPage = new DoctorPage(driver).goTo();
        Assert.assertTrue(doctorPage.isOnDoctorPage(), "Halaman Dokter tidak dapat dibuka");
    }

    @Test
    public void doctorCardAppears() {
        Assert.assertTrue(doctorPage.doctorCount() > 0 || doctorPage.hasEmptyState(),
                "Daftar dokter tidak tampil (tidak ada kartu maupun empty state)");
    }

    @Test
    public void successfullyAddDoctor() {
        String nama = uniqueName("dr. Dokter Baru");

        doctorPage.clickAdd()
                .fillDoctor(nama, SPECIALIZATION, PHONE, uniqueEmail(), COST, uniqueUsername(), PASSWORD)
                .selectBirthDate(BIRTH_DATE)
                .submit();

        Assert.assertTrue(doctorPage.hasSuccessMessage(), "Pesan sukses tambah dokter tidak muncul");
        Assert.assertEquals(doctorPage.getSuccessMessage(), "Dokter berhasil ditambahkan.");

        doctorPage.waitForDoctor(nama);
        Assert.assertTrue(doctorPage.doctorNames().contains(nama), "Dokter baru tidak ada di daftar");
    }

    @Test
    public void editDoctorSuccessfully() {
        String nama = uniqueName("dr. Dokter Edit");
        String namaBaru = nama + " Updated";
        createDoctor(nama);

        doctorPage.goTo()
                .clickEdit(nama)
                .fillDoctorName(namaBaru)
                .submit();

        Assert.assertTrue(doctorPage.hasSuccessMessage(), "Pesan sukses edit dokter tidak muncul");
        Assert.assertEquals(doctorPage.getSuccessMessage(), "Data dokter berhasil diperbarui.");

        doctorPage.waitForDoctor(namaBaru);
        Assert.assertTrue(doctorPage.doctorNames().contains(namaBaru), "Nama dokter tidak berubah");
    }

    @Test
    public void deleteDoctorSuccessfully() {
        String nama = uniqueName("dr. Dokter Hapus");
        createDoctor(nama);

        doctorPage.deleteDoctor(nama);

        Assert.assertTrue(doctorPage.hasSuccessMessage(), "Pesan sukses hapus dokter tidak muncul");
        Assert.assertEquals(doctorPage.getSuccessMessage(), "Dokter berhasil dihapus.");

        doctorPage.waitForDoctorGone(nama);
        Assert.assertFalse(doctorPage.doctorNames().contains(nama), "Dokter masih ada setelah dihapus");
    }

    private void createDoctor(String nama) {
        doctorPage.goTo()
                .clickAdd()
                .fillDoctor(nama, SPECIALIZATION, PHONE, uniqueEmail(), COST, uniqueUsername(), PASSWORD)
                .selectBirthDate(BIRTH_DATE)
                .submit();

        doctorPage.waitForDoctor(nama);
    }

    private static String uniqueName(String prefix) {
        return prefix + " " + System.nanoTime();
    }

    private static String uniqueEmail() {
        return "dokter" + System.nanoTime() + "@kas.test";
    }

    private static String uniqueUsername() {
        return "dokter" + System.nanoTime();
    }
}
