package com.kas.tests;

import java.util.List;

import org.testng.Assert;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;

import com.kas.api.CatalogApi;
import com.kas.api.VisitApi;
import com.kas.base.BaseTest;
import com.kas.config.Config;
import com.kas.pages.ExaminationPage;
import com.kas.pages.LoginPage;
import com.kas.pages.NakesPage;


public class ExaminationTest extends BaseTest {

    private static final String TREATMENT = "Treatment E2E";
    private static final String PRODUK = "Produk E2E";

    private NakesPage nakesPage;

    @BeforeMethod(alwaysRun = true)
    public void loginAsDoctor() {
        LoginPage loginPage = new LoginPage(driver).goTo();
        loginPage.login(Config.DOCTOR_USERNAME, Config.ADMIN_PASSWORD);
        loginPage.waitForUrlNotContains("/login");

        nakesPage = new NakesPage(driver);
        Assert.assertTrue(nakesPage.isOnNakesPage(), "Halaman nakes tidak terbuka setelah login dokter");
    }

    @Test
    public void memanggilPasienMemunculkanTombolPeriksa() {
        String nama = uniqueName("Pasien Periksa");
        VisitApi.createForDokter(nama, Config.DOCTOR_USERNAME, "Kontrol rutin");

        nakesPage.goTo();
        nakesPage.waitForPatient(nama);

        Assert.assertEquals(nakesPage.patientStatus(nama), "Menunggu");
        Assert.assertFalse(nakesPage.hasPeriksaLink(nama),
                "Tombol Periksa muncul sebelum pasien dipanggil");

        nakesPage.callPatient(nama);
        nakesPage.waitForPatientStatus(nama, "Dipanggil");

        Assert.assertTrue(nakesPage.hasPeriksaLink(nama),
                "Tombol Periksa tidak muncul setelah pasien dipanggil");

        ExaminationPage examinationPage = nakesPage.clickPeriksa(nama);

        Assert.assertTrue(examinationPage.isOnPage(), "Form pemeriksaan tidak terbuka");
        Assert.assertTrue(examinationPage.patientLabel().contains(nama),
                "Form pemeriksaan tidak menampilkan pasien yang benar: " + examinationPage.patientLabel());
        Assert.assertTrue(driver.getCurrentUrl().matches(".*/pemeriksaan/\\d+/edit"),
                "URL form pemeriksaan tidak sesuai: " + driver.getCurrentUrl());
    }

    @Test
    public void menyimpanPemeriksaanDenganTreatmentDanProduk() {
        String nama = uniqueName("Pasien Simpan");
        VisitApi.createForDokter(nama, Config.DOCTOR_USERNAME, "Kulit kusam");

        nakesPage.goTo();
        nakesPage.waitForPatient(nama);
        nakesPage.callPatient(nama);
        nakesPage.waitForPatientStatus(nama, "Dipanggil");

        ExaminationPage examinationPage = nakesPage.clickPeriksa(nama);
        Assert.assertTrue(examinationPage.isOnPage(), "Form pemeriksaan tidak terbuka");
        Assert.assertTrue(examinationPage.productNames().contains(PRODUK),
                "Produk " + PRODUK + " tidak ada di form pemeriksaan");

        examinationPage
                .selectTreatment(TREATMENT)
                .fillDiagnosa("Hiperpigmentasi ringan")
                .fillTindakan("Facial brightening")
                .fillCatatan("Kontrol 2 minggu lagi")
                .checkProduct(PRODUK);

        Assert.assertTrue(examinationPage.isProductChecked(PRODUK), "Produk gagal dicentang");

        NakesPage afterSubmit = examinationPage.submit();

        Assert.assertTrue(afterSubmit.hasSuccessMessage(), "Pesan sukses simpan pemeriksaan tidak muncul");
        Assert.assertEquals(afterSubmit.successMessage(), "Pemeriksaan berhasil disimpan.");

        afterSubmit.waitForPatientStatus(nama, "Selesai");
        Assert.assertTrue(afterSubmit.hasHasilLink(nama),
                "Link Hasil tidak muncul setelah pemeriksaan disimpan");

        ExaminationPage hasil = afterSubmit.clickHasil(nama);
        Assert.assertTrue(hasil.isOnPage(), "Halaman hasil pemeriksaan tidak terbuka");
        Assert.assertEquals(hasil.selectedTreatment(), TREATMENT);
        Assert.assertEquals(hasil.diagnosaValue(), "Hiperpigmentasi ringan");
        Assert.assertEquals(hasil.tindakanValue(), "Facial brightening");
        Assert.assertEquals(hasil.catatanValue(), "Kontrol 2 minggu lagi");
        Assert.assertTrue(hasil.isProductChecked(PRODUK), "Produk yang dipilih tidak tersimpan");
    }

    @Test
    public void membuatDataPemeriksaanLengkapLewatApi() {
        String nama = uniqueName("Pasien Api");

        long treatmentId = CatalogApi.treatmentId(TREATMENT);
        long produkId = CatalogApi.productId(PRODUK);

        VisitApi.Visit visit = VisitApi.createExamined(
                nama, Config.DOCTOR_USERNAME, "Perawatan wajah", treatmentId, List.of(produkId));

        Assert.assertTrue(visit.hasPemeriksaan(), "API tidak membuat data pemeriksaan");
        Assert.assertNotNull(visit.pemeriksaanEditUrl(), "API tidak mengembalikan URL form pemeriksaan");

        // Form pemeriksaan bisa langsung dibuka tanpa melewati UI /nakes.
        driver.get(visit.pemeriksaanEditUrl());
        ExaminationPage examinationPage = new ExaminationPage(driver);

        Assert.assertTrue(examinationPage.isOnPage(), "Form pemeriksaan hasil seeding API tidak terbuka");
        Assert.assertTrue(examinationPage.patientLabel().contains(nama),
                "Form pemeriksaan tidak menampilkan pasien hasil seeding API");
        Assert.assertEquals(examinationPage.selectedTreatment(), TREATMENT);
        Assert.assertTrue(examinationPage.isProductChecked(PRODUK),
                "Produk hasil seeding API tidak tercentang");

        // Dari dashboard dokter, kunjungan ini sudah siap diperiksa.
        nakesPage.goTo();
        nakesPage.waitForPatient(nama);
        Assert.assertEquals(nakesPage.patientStatus(nama), "Dipanggil");
        Assert.assertTrue(nakesPage.hasPeriksaLink(nama), "Kunjungan hasil API tidak punya tombol Periksa");
    }

    private static String uniqueName(String prefix) {
        return prefix + " " + System.nanoTime();
    }
}
