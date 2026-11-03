package com.kas.tests;

import java.util.List;

import org.testng.Assert;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;

import com.kas.base.BaseTest;
import com.kas.config.Config;
import com.kas.pages.LoginPage;
import com.kas.pages.ProductPage;

public class ProductTest extends BaseTest {

    private ProductPage productPage;

    @BeforeMethod(alwaysRun = true)
    public void loginDanBukaHalamanProduk() {
        LoginPage loginPage = new LoginPage(driver).goTo();
        loginPage.login(Config.ADMIN_USERNAME, Config.ADMIN_PASSWORD);
        loginPage.waitForUrlNotContains("/login");

        productPage = new ProductPage(driver).goTo();
        Assert.assertTrue(productPage.isOnProductPage(), "Halaman Produk tidak tampil");
    }

    @Test
    public void daftarProdukTampil() {
        Assert.assertTrue(
                productPage.productCount() > 0 || productPage.hasEmptyState(),
                "Daftar produk tidak tampil (tidak ada kartu produk maupun empty state)");
    }

    @Test
    public void tambahProdukBerhasil() {
        productPage.clickAdd()
                .fillProduct("Produk Baru", "Perawatan", "Produk e2e", "50000", "5")
                .selectStatus("tersedia")
                .submit();

        Assert.assertTrue(productPage.hasSuccessMessage(), "Pesan sukses tambah produk tidak muncul");
        Assert.assertEquals(productPage.getSuccessMessage(), "Produk berhasil ditambahkan.");

        productPage.waitForProduct("Produk Baru");
        Assert.assertTrue(productPage.hasProduct("Produk Baru"), "Produk baru tidak ada di daftar");
    }

    @Test
    public void tambahProdukTanpaFieldWajibMenampilkanError() {
        productPage.clickAdd().submit();

        Assert.assertTrue(productPage.hasErrorMessage(), "Pesan error validasi tidak muncul");
        Assert.assertFalse(productPage.getErrorMessages().isEmpty(), "Detail error validasi kosong");
    }

    @Test
    public void editProdukBerhasil() {
        productPage.clickEdit("Produk E2E")
                .fillName("Produk Edit")
                .submit();

        Assert.assertTrue(productPage.hasSuccessMessage(), "Pesan sukses edit produk tidak muncul");
        Assert.assertEquals(productPage.getSuccessMessage(), "Produk berhasil diperbarui.");

        productPage.waitForProduct("Produk Edit");
        Assert.assertTrue(productPage.hasProduct("Produk Edit"), "Nama produk tidak berubah");
    }

    @Test
    public void hapusProdukBerhasil() {
        productPage.deleteProduct("Produk E2E");

        Assert.assertTrue(productPage.hasSuccessMessage(), "Pesan sukses hapus produk tidak muncul");
        Assert.assertEquals(productPage.getSuccessMessage(), "Produk berhasil dihapus.");

        productPage.waitForProductGone("Produk E2E");
        Assert.assertFalse(productPage.hasProduct("Produk E2E"), "Produk masih ada setelah dihapus");
    }

    @Test
    public void filterProdukBerdasarkanNama() {
        productPage.filterByName("Produk E2E");

        Assert.assertEquals(productPage.productNames(), List.of("Produk E2E"));
    }

    @Test
    public void filterProdukTanpaHasilMenampilkanEmptyState() {
        productPage.filterByName("Produk Tidak Ada");

        Assert.assertTrue(productPage.hasEmptyState(), "Empty state produk tidak tampil");
    }

    @Test
    public void filterProdukStokMenipis() {
        productPage.clickAdd()
                .fillProduct("Produk Stok Menipis", "Perawatan", "Produk e2e", "10000", "3")
                .selectStatus("tersedia")
                .submit();

        productPage.filterStokMenipis();

        productPage.waitForProduct("Produk Stok Menipis");
        Assert.assertTrue(productPage.hasProduct("Produk Stok Menipis"),
                "Produk stok menipis tidak muncul di hasil filter");
    }
}
