package com.kas.tests;

import org.testng.Assert;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;

import com.kas.api.VisitApi;
import com.kas.base.BaseTest;
import com.kas.config.Config;
import com.kas.pages.LoginPage;
import com.kas.pages.NakesPage;

public class NakesTest extends BaseTest {

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
    public void doctorSeesOwnGreeting() {
        Assert.assertTrue(nakesPage.greeting().contains("John"),
                "Sapaan halaman nakes tidak memuat nama dokter: " + nakesPage.greeting());
    }

    @Test
    public void emptyStateWhenNoVisitToday() {
        Assert.assertTrue(nakesPage.hasEmptyState(), "Empty state pasien hari ini tidak tampil");
        Assert.assertEquals(nakesPage.totalMenunggu(), 0);
        Assert.assertEquals(nakesPage.totalDipanggil(), 0);
        Assert.assertEquals(nakesPage.totalSelesai(), 0);
    }

    @Test
    public void todayVisitAppearsInPatientTable() {
        String nama = uniqueName("Pasien Nakes");

        VisitApi.Visit visit = VisitApi.createForDokter(nama, Config.DOCTOR_USERNAME, "Demam");
        Assert.assertTrue(visit.pelayananId() > 0, "API tidak mengembalikan id pelayanan");

        nakesPage.goTo();
        nakesPage.waitForPatient(nama);

        Assert.assertTrue(nakesPage.patientNames().contains(nama), "Pasien baru tidak ada di tabel");
        Assert.assertEquals(nakesPage.patientName(nama), nama);
        Assert.assertEquals(nakesPage.patientKeluhan(nama), "Demam");
        Assert.assertEquals(nakesPage.patientStatus(nama), "Menunggu");
        Assert.assertEquals(nakesPage.totalMenunggu(), 1, "Statistik menunggu tidak bertambah");
    }

    @Test
    public void callPatientChangesStatus() {
        String nama = uniqueName("Pasien Panggil");

        VisitApi.createForDokter(nama, Config.DOCTOR_USERNAME, "Kontrol");
        nakesPage.goTo();
        nakesPage.waitForPatient(nama);

        nakesPage.callPatient(nama);
        nakesPage.waitForPatientStatus(nama, "Dipanggil");

        Assert.assertEquals(nakesPage.patientStatus(nama), "Dipanggil");
        Assert.assertEquals(nakesPage.totalMenunggu(), 0);
        Assert.assertEquals(nakesPage.totalDipanggil(), 1);
    }

    @Test
    public void visitWithoutDoctorDoesNotAppear() {
        String nama = uniqueName("Pasien Tanpa Dokter");

        // Admin tidak punya record Dokter, jadi pelayanan ini tidak dimiliki
        // dokter mana pun dan tidak boleh muncul di halaman nakes.
        VisitApi.createForDokter(nama, Config.ADMIN_USERNAME, "Tanpa dokter");
        nakesPage.goTo();

        Assert.assertFalse(nakesPage.patientNames().contains(nama),
                "Pelayanan tanpa dokter muncul di halaman nakes");
        Assert.assertTrue(nakesPage.hasEmptyState(), "Tabel seharusnya kosong untuk dokter ini");
    }

    private static String uniqueName(String prefix) {
        return prefix + " " + System.nanoTime();
    }
}
