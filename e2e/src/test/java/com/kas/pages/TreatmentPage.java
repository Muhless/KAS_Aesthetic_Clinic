package com.kas.pages;

import java.util.List;
import java.util.stream.Collectors;

import org.openqa.selenium.By;
import org.openqa.selenium.UnhandledAlertException;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.ExpectedConditions;

public class TreatmentPage extends BasePage {

    private final By pageTitle = By.xpath("//h1[normalize-space()='Treatment']");
    private final By treatmentNames = By.xpath("//p[contains(@class,'truncate')]");
    private final By emptyState = By.xpath("//h3[normalize-space()='Belum ada treatment']");

    // Tombol & modal
    private final By addButton = By.xpath("(//button[normalize-space()='Tambah Treatment'])[1]");
    private final By modalForm = By.xpath("//form[@enctype='multipart/form-data']");
    private final By modalTitle = By.xpath("//h5[normalize-space()='Tambah Treatment']");
    private final By editModalTitle = By.xpath("//h5[normalize-space()='Edit Treatment']");
    private final By submitButton = By.xpath("//form[@enctype='multipart/form-data']//button[@type='submit']");

    // Field form
    private final By namaInput = By.id("nama");
    private final By deskripsiInput = By.id("deskripsi");
    private final By hargaInput = By.id("harga");
    private final By durasiInput = By.id("durasi");
    private final By statusTersedia = By.xpath(
            "//form[@enctype='multipart/form-data']//input[@name='status'][@value='tersedia']");
    private final By statusTidakTersedia = By.xpath(
            "//form[@enctype='multipart/form-data']//input[@name='status'][@value='tidak_tersedia']");

    // Notifikasi
    private final By successToast = By.xpath("//h3[normalize-space()='Berhasil!']");
    private final By successMessage = By.xpath("//h3[normalize-space()='Berhasil!']/following-sibling::p");
    private final By errorToast = By.xpath("//h3[normalize-space()='Terjadi Kesalahan']");
    private final By errorMessages = By.xpath(
            "//h3[normalize-space()='Terjadi Kesalahan']/ancestor::div[contains(@class,'z-50')]//li");

    // Filter
    private final By filterNama = By.xpath("//form[@method='GET']//input[@name='nama']");
    private final By filterStatus = By.xpath("//form[@method='GET']//select[@name='status']");
    private final By filterHargaMin = By.xpath("//form[@method='GET']//input[@name='harga_min']");
    private final By filterHargaMax = By.xpath("//form[@method='GET']//input[@name='harga_max']");
    private final By applyFilterButton = By.xpath("//form[@method='GET']//button[@type='submit']");
    private final By resetFilterLink = By.xpath("//form[@method='GET']//a[normalize-space()='Reset']");

    public TreatmentPage(WebDriver driver) {
        super(driver);
    }

    public TreatmentPage goTo() {
        open("/treatment");
        return this;
    }

    public boolean isOnTreatmentPage() {
        return isVisible(pageTitle);
    }

    public int treatmentCount() {
        return driver.findElements(treatmentNames).size();
    }

    public List<String> treatmentNames() {
        return driver.findElements(treatmentNames).stream()
                .map(element -> element.getText().trim())
                .collect(Collectors.toList());
    }

    public boolean hasEmptyState() {
        return isElementPresent(emptyState);
    }

    public boolean hasTreatment(String nama) {
        return !driver.findElements(card(nama)).isEmpty();
    }

    public TreatmentPage waitForTreatment(String nama) {
        wait.until(ExpectedConditions.visibilityOfElementLocated(card(nama)));
        return this;
    }

    public TreatmentPage waitForTreatmentGone(String nama) {
        wait.until(ExpectedConditions.invisibilityOfElementLocated(card(nama)));
        return this;
    }

    // --- Data kartu ---

    public String getPrice(String nama) {
        return find(card(nama))
                .findElement(By.xpath(".//span[contains(@class,'font-bold')]"))
                .getText()
                .trim();
    }

    public String getStatus(String nama) {
        return find(card(nama))
                .findElement(By.xpath(".//div[contains(@class,'right-2')]/span"))
                .getText()
                .trim();
    }

    public String getDuration(String nama) {
        return find(card(nama))
                .findElement(By.xpath(".//div[contains(@class,'left-2')]//span"))
                .getText()
                .trim();
    }

    // --- Tambah / edit / hapus treatment ---

    public TreatmentPage clickAdd() {
        click(addButton);
        wait.until(ExpectedConditions.visibilityOfElementLocated(modalTitle));
        return this;
    }

    public boolean isModalOpen() {
        return driver.findElements(modalForm).stream().anyMatch(WebElement::isDisplayed);
    }

    public TreatmentPage fillTreatment(String nama, String deskripsi, String harga, String durasi) {
        if (nama != null) {
            type(namaInput, nama);
        }
        if (deskripsi != null) {
            type(deskripsiInput, deskripsi);
        }
        if (harga != null) {
            type(hargaInput, harga);
        }
        if (durasi != null) {
            type(durasiInput, durasi);
        }
        return this;
    }

    public TreatmentPage fillName(String nama) {
        type(namaInput, nama);
        return this;
    }

    public TreatmentPage selectStatus(String status) {
        if ("tersedia".equalsIgnoreCase(status)) {
            click(statusTersedia);
        } else {
            click(statusTidakTersedia);
        }
        return this;
    }

    public TreatmentPage submit() {
        WebElement button = find(submitButton);
        button.click();

        // Sukses maupun gagal validasi sama-sama redirect + menampilkan notifikasi.
        wait.until(ExpectedConditions.or(
                ExpectedConditions.visibilityOfElementLocated(successToast),
                ExpectedConditions.visibilityOfElementLocated(errorToast)));
        wait.until(ExpectedConditions.invisibilityOfElementLocated(modalForm));
        return this;
    }

    public TreatmentPage clickEdit(String nama) {
        find(card(nama)).findElement(By.xpath(".//button[@title='Edit']")).click();
        wait.until(ExpectedConditions.visibilityOfElementLocated(editModalTitle));
        return this;
    }

    public TreatmentPage deleteTreatment(String nama) {
        try {
            find(card(nama)).findElement(By.xpath(".//button[@title='Hapus']")).click();
        } catch (UnhandledAlertException e) {
            // Dialog konfirmasi sudah terbuka, lanjut diterima di bawah.
        }

        wait.until(ExpectedConditions.alertIsPresent());
        driver.switchTo().alert().accept();
        return this;
    }

    // --- Notifikasi ---

    public boolean hasSuccessMessage() {
        return isVisible(successToast);
    }

    public String getSuccessMessage() {
        return getText(successMessage).trim();
    }

    public boolean hasErrorMessage() {
        return isVisible(errorToast);
    }

    public List<String> getErrorMessages() {
        return driver.findElements(errorMessages).stream()
                .map(element -> element.getText().trim())
                .collect(Collectors.toList());
    }

    // --- Filter ---

    public TreatmentPage filterByName(String nama) {
        type(filterNama, nama);
        return applyFilter("nama=");
    }

    public TreatmentPage filterByStatus(String status) {
        selectByText(filterStatus, status);
        return applyFilter("status=");
    }

    public TreatmentPage filterByPriceRange(String hargaMin, String hargaMax) {
        if (hargaMin != null) {
            type(filterHargaMin, hargaMin);
        }
        if (hargaMax != null) {
            type(filterHargaMax, hargaMax);
        }

        click(applyFilterButton);
        waitForUrlContains("harga_m");
        waitForDocumentReady();
        return this;
    }

    public TreatmentPage applyFilter(String expectedUrlPart) {
        click(applyFilterButton);
        waitForUrlContains(expectedUrlPart);
        waitForDocumentReady();
        return this;
    }

    public TreatmentPage resetFilter() {
        click(resetFilterLink);
        wait.until(ExpectedConditions.not(ExpectedConditions.urlContains("?")));
        waitForDocumentReady();
        return this;
    }

    // --- Helper ---

    private By card(String nama) {
        return By.xpath("//p[contains(@class,'truncate')][normalize-space()=" + xpathLiteral(nama)
                + "]/ancestor::div[contains(@class,'overflow-hidden')][1]");
    }

    private void waitForDocumentReady() {
        wait.until(driver -> "complete".equals(executeScript("return document.readyState")));
    }

    /**
     * Bungkus teks jadi literal XPath yang aman, termasuk nama treatment yang
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
