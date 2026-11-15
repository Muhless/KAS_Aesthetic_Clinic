package com.kas.tests;

import java.util.List;

import org.testng.Assert;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;

import com.kas.api.CatalogApi;
import com.kas.api.VisitApi;
import com.kas.base.BaseTest;
import com.kas.config.Config;
import com.kas.pages.FinancePage;
import com.kas.pages.LoginPage;

/**
 * Halaman keuangan admin: daftar pembayaran, detail, tandai lunas, dan
 * pengaruhnya ke statistik/riwayat.
 */
public class FinanceTest extends BaseTest {

    private static final String TREATMENT = "Treatment E2E";
    private static final String PRODUK = "Produk E2E";
    private static final String CATATAN = "Dibayar tunai di kasir";

    private FinancePage financePage;

    @BeforeMethod(alwaysRun = true)
    public void loginDanBukaHalamanKeuangan() {
        LoginPage loginPage = new LoginPage(driver).goTo();
        loginPage.login(Config.ADMIN_USERNAME, Config.ADMIN_PASSWORD);
        loginPage.waitForUrlNotContains("/login");

        financePage = new FinancePage(driver).goTo();
        Assert.assertTrue(financePage.isOnPage(), "Halaman Keuangan tidak tampil");
    }

    @Test
    public void halamanKeuanganTampilSaatBelumAdaData() {
        Assert.assertEquals(financePage.incomeToday(), 0L, "Pemasukan hari ini harus 0");
        Assert.assertEquals(financePage.incomeThisMonth(), 0L, "Pemasukan bulan ini harus 0");
        Assert.assertEquals(financePage.transactionCount(), 0, "Jumlah transaksi harus 0");
        Assert.assertEquals(financePage.unpaidCount(), 0, "Belum bayar harus 0");

        Assert.assertEquals(financePage.paymentCount(), 0, "Tabel pembayaran harus kosong");
        Assert.assertTrue(financePage.hasEmptyState(), "Empty state tabel pembayaran tidak tampil");

        Assert.assertEquals(financePage.historyCount(), 0, "Riwayat transaksi harus kosong");
        Assert.assertTrue(financePage.hasHistoryEmptyState(), "Empty state riwayat tidak tampil");

        Assert.assertEquals(financePage.summaryTotal(), 0L);
        Assert.assertEquals(financePage.summaryCount(), 0);
        Assert.assertTrue(financePage.hasCetakPdf(), "Tombol Cetak PDF tidak tampil");
    }

    @Test
    public void pembayaranBelumBayarMunculDiTabel() {
        String nama = seedPembayaran("Pasien Belum Bayar");

        financePage.goTo();
        financePage.waitForPayment(nama);

        Assert.assertTrue(financePage.hasPayment(nama), "Baris pembayaran tidak muncul");
        Assert.assertTrue(Long.parseLong(financePage.paymentId(nama)) > 0, "ID pembayaran tidak valid");
        Assert.assertEquals(financePage.paymentStatus(nama), "Belum Bayar");
        Assert.assertTrue(financePage.paymentTotal(nama) > 0, "Total pembayaran harus lebih dari 0");

        Assert.assertEquals(financePage.unpaidCount(), 1);
        Assert.assertEquals(financePage.transactionCount(), 0, "Pembayaran belum lunas tidak dihitung transaksi");
        Assert.assertEquals(financePage.incomeToday(), 0L, "Pemasukan belum bertambah sebelum lunas");

        Assert.assertEquals(financePage.historyCount(), 0, "Riwayat hanya menampilkan pembayaran lunas");
        Assert.assertTrue(financePage.hasHistoryEmptyState());
    }

    @Test
    public void membukaDetailPembayaran() {
        String nama = seedPembayaran("Pasien Detail");

        financePage.goTo();
        financePage.waitForPayment(nama);
        long total = financePage.paymentTotal(nama);
        String id = financePage.paymentId(nama);

        financePage.clickDetail(nama);

        Assert.assertTrue(financePage.isOnDetailPage(), "Halaman detail pembayaran tidak terbuka");
        Assert.assertTrue(driver.getCurrentUrl().matches(".*/keuangan/" + id + "$"),
                "URL detail tidak sesuai: " + driver.getCurrentUrl());
        Assert.assertEquals(financePage.detailPatient(), nama);
        Assert.assertEquals(financePage.detailTotal(), total, "Total di detail harus sama dengan tabel");
        Assert.assertEquals(financePage.detailStatus(), "Belum Bayar");
        Assert.assertFalse(financePage.hasCetakStruk(), "Cetak struk hanya muncul untuk pembayaran lunas");
    }

    @Test
    public void menandaiPembayaranLunas() {
        String nama = seedPembayaran("Pasien Lunas");

        financePage.goTo();
        financePage.waitForPayment(nama);
        financePage.clickDetail(nama);

        financePage.fillCatatan(CATATAN);
        financePage.markAsLunas();

        Assert.assertTrue(financePage.hasSuccessMessage(), "Notifikasi sukses tidak muncul");
        Assert.assertEquals(financePage.successMessage(), "Pembayaran berhasil diproses.");
        Assert.assertEquals(financePage.detailStatus(), "Lunas");
        Assert.assertEquals(financePage.detailMetode(), "cash");
        Assert.assertTrue(financePage.hasCetakStruk(), "Tombol Cetak Struk tidak muncul setelah lunas");
    }

    @Test
    public void catatanPembayaranTersimpan() {
        String nama = seedPembayaran("Pasien Catatan");

        financePage.goTo();
        financePage.waitForPayment(nama);
        financePage.clickDetail(nama);

        financePage.fillCatatan(CATATAN);
        financePage.markAsLunas();

        Assert.assertEquals(financePage.detailCatatan(), CATATAN, "Catatan pembayaran tidak tersimpan");
    }

    @Test
    public void statistikDanRingkasanTerupdateSetelahLunas() {
        String nama = seedPembayaran("Pasien Statistik");

        financePage.goTo();
        financePage.waitForPayment(nama);
        long total = financePage.paymentTotal(nama);

        financePage.clickDetail(nama);
        financePage.markAsLunas();

        financePage.goTo();

        Assert.assertEquals(financePage.incomeToday(), total, "Pemasukan hari ini harus bertambah");
        Assert.assertEquals(financePage.incomeThisMonth(), total, "Pemasukan bulan ini harus bertambah");
        Assert.assertEquals(financePage.transactionCount(), 1);
        Assert.assertEquals(financePage.unpaidCount(), 0);

        Assert.assertEquals(financePage.summaryTotal(), total);
        Assert.assertEquals(financePage.summaryCount(), 1);
        Assert.assertEquals(financePage.summaryAverage(), total);
    }

    @Test
    public void riwayatTransaksiMenampilkanPembayaranLunas() {
        String nama = seedPembayaran("Pasien Riwayat");

        financePage.goTo();
        financePage.waitForPayment(nama);
        long total = financePage.paymentTotal(nama);

        financePage.clickDetail(nama);
        financePage.markAsLunas();

        financePage.goTo();
        financePage.waitForHistory(nama);

        Assert.assertEquals(financePage.historyMethod(nama), "Cash", "Metode bayar di riwayat harus cash");
        Assert.assertEquals(financePage.historyTotal(nama), total, "Total riwayat harus sama dengan pembayaran");
    }

    @Test
    public void beberapaPembayaranTerhitungBenar() {
        String namaLunas = seedPembayaran("Pasien Lunas Satu");
        String namaBelumSatu = seedPembayaran("Pasien Belum Satu");
        String namaBelumDua = seedPembayaran("Pasien Belum Dua");

        financePage.goTo();
        financePage.waitForPayment(namaLunas);
        financePage.waitForPayment(namaBelumSatu);
        financePage.waitForPayment(namaBelumDua);
        long totalLunas = financePage.paymentTotal(namaLunas);

        financePage.clickDetail(namaLunas);
        financePage.markAsLunas();

        financePage.goTo();

        Assert.assertEquals(financePage.paymentCount(), 3, "Semua pembayaran harus tampil di tabel");
        Assert.assertTrue(financePage.hasPayment(namaBelumSatu));
        Assert.assertTrue(financePage.hasPayment(namaBelumDua));

        Assert.assertEquals(financePage.transactionCount(), 1, "Hanya pembayaran lunas yang dihitung");
        Assert.assertEquals(financePage.unpaidCount(), 2);
        Assert.assertEquals(financePage.incomeThisMonth(), totalLunas);
    }

    /**
     * Membuat pasien + pemeriksaan + pembayaran berstatus belum bayar lewat
     * API e2e, lalu mengembalikan nama pasien untuk dicari di tabel.
     */
    private String seedPembayaran(String prefix) {
        String nama = prefix + " " + System.nanoTime();
        VisitApi.createExamined(
                nama,
                Config.DOCTOR_USERNAME,
                "Kontrol rutin",
                CatalogApi.treatmentId(TREATMENT),
                List.of(CatalogApi.productId(PRODUK)));
        return nama;
    }
}
