package com.kas.pages;

import java.util.List;
import java.util.stream.Collectors;

import org.openqa.selenium.By;
import org.openqa.selenium.UnhandledAlertException;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.ExpectedConditions;

public class ProductPage extends BasePage {

    private final By pageTitleBy = By.xpath("//h1[normalize-space()='Produk']");
    private final By productNamesBy = By.xpath("//h2[contains(@class,'truncate')]");
    private final By emptyStateBy = By.xpath("//h3[normalize-space()='Belum ada produk']");

    // Tombol & modal
    private final By addButtonBy = By.xpath("(//button[normalize-space()='Tambah Produk'])[1]");
    private final By modalFormBy = By.xpath("//form[@enctype='multipart/form-data']");
    private final By modalTitleBy = By.xpath("//h5[normalize-space()='Tambah Produk']");
    private final By editModalTitleBy = By.xpath("//h5[normalize-space()='Edit Produk']");
    private final By submitButtonBy = By.xpath("//form[@enctype='multipart/form-data']//button[@type='submit']");

    // Field form
    private final By nameInputBy = By.id("nama");
    private final By categoryInputBy = By.id("kategori");
    private final By descriptionInputBy = By.id("deskripsi");
    private final By priceInputBy = By.id("harga");
    private final By stockInputBy = By.id("stok");
    private final By statusTersediaBy = By.id("status_tersedia");
    private final By statusTidakTersediaBy = By.id("status_tidak_tersedia");

    // Notifikasi
    private final By successToastBy = By.xpath("//h3[normalize-space()='Berhasil!']");
    private final By successMessageBy = By.xpath("//h3[normalize-space()='Berhasil!']/following-sibling::p");
    private final By errorToastBy = By.xpath("//h3[normalize-space()='Terjadi Kesalahan']");
    private final By errorMessagesBy = By.xpath(
            "//h3[normalize-space()='Terjadi Kesalahan']/ancestor::div[contains(@class,'z-50')]//li");

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
        return driver.findElements(productNamesBy).size();
    }

    public List<String> productNames() {
        return driver.findElements(productNamesBy).stream()
                .map(element -> element.getText().trim())
                .collect(Collectors.toList());
    }

    public boolean hasEmptyState() {
        return isElementPresent(emptyStateBy);
    }

    public boolean hasProduct(String nama) {
        return !driver.findElements(card(nama)).isEmpty();
    }

    public ProductPage waitForProduct(String nama) {
        wait.until(ExpectedConditions.visibilityOfElementLocated(card(nama)));
        return this;
    }

    public ProductPage waitForProductGone(String nama) {
        wait.until(ExpectedConditions.invisibilityOfElementLocated(card(nama)));
        return this;
    }

    // --- Tambah / edit / hapus produk ---

    public ProductPage clickAdd() {
        click(addButtonBy);
        wait.until(ExpectedConditions.visibilityOfElementLocated(modalTitleBy));
        return this;
    }

    public boolean isModalOpen() {
        return driver.findElements(modalFormBy).stream().anyMatch(WebElement::isDisplayed);
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
        WebElement button = find(submitButtonBy);
        button.click();

        // Sukses maupun gagal validasi sama-sama redirect + menampilkan notifikasi.
        wait.until(ExpectedConditions.or(
                ExpectedConditions.visibilityOfElementLocated(successToastBy),
                ExpectedConditions.visibilityOfElementLocated(errorToastBy)));
        wait.until(ExpectedConditions.invisibilityOfElementLocated(modalFormBy));
        return this;
    }

    public ProductPage clickEdit(String nama) {
        find(card(nama)).findElement(By.xpath(".//button[@title='Edit']")).click();
        wait.until(ExpectedConditions.visibilityOfElementLocated(editModalTitleBy));
        return this;
    }

    public ProductPage deleteProduct(String nama) {
        try {
            find(card(nama)).findElement(By.xpath(".//button[@title='Hapus']")).click();
        } catch (UnhandledAlertException e) {
        }

        wait.until(ExpectedConditions.alertIsPresent());
        driver.switchTo().alert().accept();
        return this;
    }

    // --- Notifikasi ---

    public boolean hasSuccessMessage() {
        return isVisible(successToastBy);
    }

    public String getSuccessMessage() {
        return getText(successMessageBy).trim();
    }

    public boolean hasErrorMessage() {
        return isVisible(errorToastBy);
    }

    public List<String> getErrorMessages() {
        return driver.findElements(errorMessagesBy).stream()
                .map(element -> element.getText().trim())
                .collect(Collectors.toList());
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

    private By card(String nama) {
        return By.xpath(
                "//h2[normalize-space()=" + xpathLiteral(nama) + "]/ancestor::div[contains(@class,'h-full')][1]");
    }

    private void waitForDocumentReady() {
        wait.until(driver -> "complete".equals(executeScript("return document.readyState")));
    }

    /**
     * Bungkus teks jadi literal XPath yang aman, termasuk nama produk yang
     * mengandung tanda kutip.
     */
    private static String xpathLiteral(String value) {
        if (!value.contains("'")) {
            return "'" + value + "'";
        }
        if (!value.contains("\"")) {
            return "\"" + value + "\"";
        }

        String[] parts = value.split("'");
        StringBuilder literal = new StringBuilder("concat(");
        for (int i = 0; i < parts.length; i++) {
            if (i > 0) {
                literal.append(", \"'\", ");
            }
            literal.append("'").append(parts[i]).append("'");
        }
        return literal.append(")").toString();
    }
}
