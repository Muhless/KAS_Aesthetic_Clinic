package com.kas.pages;

import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.Select;

import com.kas.components.Notification;

/**
 * Form pemeriksaan dokter di /pemeriksaan/{id}/edit: pilih treatment, isi
 * hasil pemeriksaan, centang produk, lalu simpan.
 */
public class ExaminationPage extends BasePage {

    private final By title = By.cssSelector("[data-testid='pemeriksaan-title']");
    private final By patient = By.cssSelector("[data-testid='pemeriksaan-patient']");
    private final By form = By.cssSelector("[data-testid='pemeriksaan-form']");

    private final By treatmentSelect = By.cssSelector("[data-testid='pemeriksaan-treatment']");
    private final By diagnosaInput = By.cssSelector("[data-testid='pemeriksaan-diagnosa']");
    private final By tindakanInput = By.cssSelector("[data-testid='pemeriksaan-tindakan']");
    private final By catatanInput = By.cssSelector("[data-testid='pemeriksaan-catatan']");
    private final By submitButton = By.cssSelector("[data-testid='pemeriksaan-submit']");

    private final By productItems = By.cssSelector("[data-testid='pemeriksaan-produk-item']");

    private final Notification notification = new Notification(driver, wait);

    public ExaminationPage(WebDriver driver) {
        super(driver);
    }

    public boolean isOnPage() {
        return isVisible(title) && isElementPresent(form);
    }

    public ExaminationPage waitUntilReady() {
        wait.until(driver -> {
            try {
                return "complete".equals(executeScript("return document.readyState"));
            } catch (RuntimeException e) {
                return false;
            }
        });
        wait.until(ExpectedConditions.visibilityOfElementLocated(title));
        wait.until(ExpectedConditions.visibilityOfElementLocated(form));
        return this;
    }

    public String patientLabel() {
        return getText(patient).trim();
    }

    public ExaminationPage selectTreatment(String nama) {
        selectByText(treatmentSelect, nama);
        return this;
    }

    public ExaminationPage fillDiagnosa(String diagnosa) {
        type(diagnosaInput, diagnosa);
        return this;
    }

    public ExaminationPage fillTindakan(String tindakan) {
        type(tindakanInput, tindakan);
        return this;
    }

    public ExaminationPage fillCatatan(String catatan) {
        type(catatanInput, catatan);
        return this;
    }

    public ExaminationPage checkProduct(String nama) {
        if (isProductChecked(nama)) {
            return this;
        }

        // Klik label-nya sekali. Input berada di dalam label, jadi klik pada
        // input sekaligus label bisa membuat centang tidak konsisten.
        click(productItem(nama));
        wait.until(driver -> productCheckbox(nama).isSelected());

        return this;
    }

    public boolean isProductChecked(String nama) {
        return productCheckbox(nama).isSelected();
    }

    public String selectedTreatment() {
        return new Select(find(treatmentSelect)).getFirstSelectedOption().getText().trim();
    }

    public String diagnosaValue() {
        return find(diagnosaInput).getDomProperty("value");
    }

    public String tindakanValue() {
        return find(tindakanInput).getDomProperty("value");
    }

    public String catatanValue() {
        return find(catatanInput).getDomProperty("value");
    }

    public List<String> productNames() {
        wait.until(ExpectedConditions.visibilityOfElementLocated(productItems));
        return driver.findElements(productItems).stream()
                .map(element -> element.getAttribute("data-nama"))
                .toList();
    }

    /** Menyimpan form; halaman kembali ke dashboard dokter. */
    public NakesPage submit() {
        click(submitButton);
        return new NakesPage(driver);
    }

    public boolean hasSuccessMessage() {
        notification.waitForResult();
        return notification.hasSuccess();
    }

    public String successMessage() {
        return notification.successMessage();
    }

    private WebElement productItem(String nama) {
        wait.until(ExpectedConditions.visibilityOfElementLocated(productItems));

        return driver.findElements(productItems).stream()
                .filter(element -> nama.equals(element.getAttribute("data-nama")))
                .findFirst()
                .orElseThrow(() -> new IllegalStateException("Produk tidak ditemukan di form pemeriksaan: " + nama));
    }

    private WebElement productCheckbox(String nama) {
        return productItem(nama).findElement(By.cssSelector("input[type='checkbox']"));
    }
}
