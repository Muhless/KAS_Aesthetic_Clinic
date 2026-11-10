package com.kas.tests;

import java.net.URISyntaxException;
import java.nio.file.Path;
import java.nio.file.Paths;

import org.testng.Assert;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;

import com.kas.base.BaseTest;
import com.kas.config.Config;
import com.kas.pages.LoginPage;
import com.kas.pages.NursePage;

public class NurseTest extends BaseTest {

    private static final String PHONE = "08871165552";
    private static final String BIRTH_DATE = "2001-02-08";
    private static final String PASSWORD = "nurse12345";

    private NursePage nursePage;

    @BeforeMethod(alwaysRun = true)
    public void loginAndOpenNursePage() {
        LoginPage loginPage = new LoginPage(driver).goTo();
        loginPage.login(Config.ADMIN_USERNAME, Config.ADMIN_PASSWORD);
        loginPage.waitForUrlNotContains("/login");

        nursePage = new NursePage(driver).goTo();
        Assert.assertTrue(nursePage.isOnNursePage(), "Halaman perawat tidak dapat dibuka");
    }

    @Test
    public void nurseCardAppears() {
        Assert.assertTrue(nursePage.nurseCount() > 0 || nursePage.hasEmptyState(),
                "Daftar perawat tidak tampil (tidak ada kartu maupun empty state)");
    }

    @Test
    public void addNurseSuccessfully() {
        String name = uniqueName("Nurse baru");

        nursePage.clickAdd()
                .fillNurse(name, PHONE, uniqueEmail(), uniqueUsername(), PASSWORD)
                .selectBirthDate(BIRTH_DATE)
                .submit();

        Assert.assertTrue(nursePage.hasSuccessMessage(), "Pesan sukses tambah perawat tidak muncul");
        Assert.assertEquals(nursePage.getSuccessMessage(), "Perawat berhasil ditambahkan.");

        nursePage.waitForNurse(name);
        Assert.assertTrue(nursePage.nurseNames().contains(name), "Perawat baru tidak ada di daftar");
    }

    @Test
    public void addNurseWithPhotoSuccessfully() {
        String name = uniqueName("Nurse foto");

        nursePage.clickAdd()
                .fillNurse(name, PHONE, uniqueEmail(), uniqueUsername(), PASSWORD)
                .selectBirthDate(BIRTH_DATE)
                .uploadPhoto(fixture("nurse.png").toString())
                .submit();

        Assert.assertTrue(nursePage.hasSuccessMessage(), "Pesan sukses tambah perawat tidak muncul");
        Assert.assertEquals(nursePage.getSuccessMessage(), "Perawat berhasil ditambahkan.");

        nursePage.waitForNurse(name);
        Assert.assertTrue(nursePage.nursePhotoSrc(name).contains("/storage/perawat/foto/"),
                "Foto hasil upload tidak dipakai pada kartu perawat");
    }

    @Test
    public void editNurseSuccessfully() {
        String name = uniqueName("Nurse edit");
        String newName = name + " Updated";
        createNurse(name);

        nursePage.clickEdit(name)
                .fillNurseName(newName)
                .submit();

        Assert.assertTrue(nursePage.hasSuccessMessage(), "Pesan sukses edit perawat tidak muncul");
        Assert.assertEquals(nursePage.getSuccessMessage(), "Data perawat berhasil diperbarui.");

        nursePage.waitForNurse(newName);
        Assert.assertTrue(nursePage.nurseNames().contains(newName), "Nama perawat tidak berubah");
    }

    @Test
    public void deleteNurseSuccessfully() {
        String name = uniqueName("Nurse hapus");
        createNurse(name);

        nursePage.deleteNurse(name);

        Assert.assertTrue(nursePage.hasSuccessMessage(), "Pesan sukses hapus perawat tidak muncul");
        Assert.assertEquals(nursePage.getSuccessMessage(), "Perawat berhasil dihapus.");

        nursePage.waitForNurseGone(name);
        Assert.assertFalse(nursePage.nurseNames().contains(name), "Perawat masih ada setelah dihapus");
    }

    private void createNurse(String name) {
        nursePage.goTo()
                .clickAdd()
                .fillNurse(name, PHONE, uniqueEmail(), uniqueUsername(), PASSWORD)
                .selectBirthDate(BIRTH_DATE)
                .submit();

        Assert.assertEquals(nursePage.getSuccessMessage(), "Perawat berhasil ditambahkan.");
        nursePage.waitForNurse(name);
    }

    private static String uniqueName(String prefix) {
        return prefix + " " + System.nanoTime();
    }

    private static String uniqueEmail() {
        return "nurse" + System.nanoTime() + "@test.com";
    }

    private static String uniqueUsername() {
        return "nurse" + System.nanoTime();
    }

    private static Path fixture(String fileName) {
        try {
            return Paths.get(NurseTest.class.getClassLoader()
                    .getResource("fixtures/" + fileName)
                    .toURI());
        } catch (URISyntaxException | NullPointerException e) {
            throw new IllegalStateException("Fixture tidak ditemukan: " + fileName, e);
        }
    }
}
