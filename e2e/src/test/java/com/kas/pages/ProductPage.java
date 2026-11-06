package com.kas.pages;

import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.UnhandledAlertException;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;

import com.kas.components.FormModal;
import com.kas.components.Notification;
import com.kas.components.RecordList;

public class ProductPage extends BasePage {

    private final By pageTitleBy = By.xpath("//h1[normalize-space()='Produk']");
    private final RecordList products = new RecordList(driver, wait, "product-name", "product-card");
    private final By emptyStateBy = By.xpath("//h3[normalize-space()='Belum ada produk']");

    // Tombol & modal
    private final By addButtonBy = By.cssSelector("[data-testid='add-product']");
    private final By modalRootBy = By.cssSelector("[data-testid='product-modal']");
    private final FormModal modal = new FormModal(driver, wait, modalRootBy,
            By.cssSelector("[data-testid='product-modal'] h5"));

    // Field form
    private final By nameInputBy = By.id("nama");
    private final By categoryInputBy = By.id("kategori");
    private final By descriptionInputBy = By.id("deskripsi");
    private final By priceInputBy = By.id("harga");
    private final By stockInputBy = By.id("stok");
    private final By statusTersediaBy = By.id("status_tersedia");
    private final By statusTidakTersediaBy = By.id("status_tidak_tersedia");

    // Notifikasi
    private final Notification notification = new Notification(driver, wait);

    // Filter
    private final By filterNameBy = By.xpath("//form[@method='GET']//input[@name='nama']");
    private final By filterCategoryBy = By.xpath("//form[@method='GET']//select[@name='kategori']");
    private final By filterStatusBy = By.xpath("//form[@method='GET']//select[@name='status']");
    private final By filterLowStockBy = By.xpath("//form[@method='GET']//input[@name='stok_menipis']");
    private final By applyFilterButtonBy = By.xpath("//form[@method='GET']//button[@type='submit']");
    private final By resetFilterLinkBy = By.xpath("//form[@method='GET']//a[normalize-space()='Reset']");

    public ProductPage(WebDriver driver) {
        super(driver);
    }

    public ProductPage goTo() {
        open("/produk");
        return this;
    }

    public boolean isOnProductPage() {
        return isVisible(pageTitleBy);
    }

    public int productCount() {
        return products.count();
    }

    public List<String> productNames() {
        return products.names();
    }

    public boolean hasEmptyState() {
        return isElementPresent(emptyStateBy);
    }

    public boolean hasProduct(String nama) {
        return products.has(nama);
    }

    public ProductPage waitForProduct(String nama) {
        products.waitFor(nama);
        return this;
    }

    public ProductPage waitForProductGone(String nama) {
        products.waitForGone(nama);
        return this;
    }

    // --- Tambah / edit / hapus produk ---

    public ProductPage clickAdd() {
        click(addButtonBy);
        modal.waitUntilOpen();
        return this;
    }

    public boolean isModalOpen() {
        return modal.isOpen();
    }

    public ProductPage fillProduct(String nama, String kategori, String deskripsi, String harga, String stok) {
        if (nama != null) {
            type(nameInputBy, nama);
        }
        if (kategori != null) {
            type(categoryInputBy, kategori);
        }
        if (deskripsi != null) {
            type(descriptionInputBy, deskripsi);
        }
        if (harga != null) {
            type(priceInputBy, harga);
        }
        if (stok != null) {
            type(stockInputBy, stok);
        }
        return this;
    }

    public ProductPage fillName(String nama) {
        type(nameInputBy, nama);
        return this;
    }

    public ProductPage selectStatus(String status) {
        if ("tersedia".equalsIgnoreCase(status)) {
            click(statusTersediaBy);
        } else {
            click(statusTidakTersediaBy);
        }
        return this;
    }

    public ProductPage submit() {
        modal.submit();

        // Sukses maupun gagal validasi sama-sama redirect + menampilkan notifikasi.
        notification.waitForResult();
        modal.waitUntilClosed();
        return this;
    }

    public ProductPage clickEdit(String nama) {
        products.item(nama).findElement(By.xpath(".//button[@title='Edit']")).click();
        modal.waitUntilOpen();
        return this;
    }

    public ProductPage deleteProduct(String nama) {
        try {
            products.item(nama).findElement(By.xpath(".//button[@title='Hapus']")).click();
        } catch (UnhandledAlertException e) {
        }

        wait.until(ExpectedConditions.alertIsPresent());
        driver.switchTo().alert().accept();
        return this;
    }

    // --- Notifikasi ---

    public boolean hasSuccessMessage() {
        return notification.hasSuccess();
    }

    public String getSuccessMessage() {
        return notification.successMessage();
    }

    public boolean hasErrorMessage() {
        return notification.hasError();
    }

    public List<String> getErrorMessages() {
        return notification.errorMessages();
    }

    // --- Filter ---

    public ProductPage filterByName(String nama) {
        type(filterNameBy, nama);
        return applyFilter("nama=");
    }

    public ProductPage filterByKategori(String kategori) {
        selectByText(filterCategoryBy, kategori);
        return applyFilter("kategori=");
    }

    public ProductPage filterByStatus(String status) {
        selectByText(filterStatusBy, status);
        return applyFilter("status=");
    }

    public ProductPage filterStokMenipis() {
        click(filterLowStockBy);
        return applyFilter("stok_menipis=");
    }

    public ProductPage applyFilter(String expectedUrlPart) {
        click(applyFilterButtonBy);
        waitForUrlContains(expectedUrlPart);
        waitForDocumentReady();
        return this;
    }

    public ProductPage resetFilter() {
        click(resetFilterLinkBy);
        wait.until(ExpectedConditions.not(ExpectedConditions.urlContains("?")));
        waitForDocumentReady();
        return this;
    }

    // --- Helper ---

    private void waitForDocumentReady() {
        wait.until(driver -> "complete".equals(executeScript("return document.readyState")));
    }
}
