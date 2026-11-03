package com.kas.pages;

import java.time.LocalDate;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

public class ReservationPage extends BasePage {

    private final By addButton = By.xpath("(//button[normalize-space()='Tambah Reservasi'])[1]");
    private final By patientSelect = By.name("pasien_id");
    private final By doctorSelect = By.name("dokter_id");
    private final By dateInput = By.cssSelector("input[name='tanggal']");
    private final By submitButton = By.xpath("//button[@type='submit' and normalize-space()='Simpan']");
    private final By successBox = By.xpath("//h3[normalize-space()='Berhasil!']");
    private final By tableRows = By.cssSelector("table tbody tr");

    public ReservationPage(WebDriver driver) {
        super(driver);
    }

    public ReservationPage goTo() {
        open("/reservasi");
        return this;
    }

    public boolean isOnReservationPage() {
        return isVisible(addButton);
    }

    public void clickAdd() {
        click(addButton);
        find(patientSelect);
    }

    public void selectPatient(String patientName) {
        selectByText(patientSelect, patientName);
    }

    public void selectDoctor(String doctorName) {
        selectByText(doctorSelect, doctorName);
    }

    /**
     * Flatpickr memakai input readonly + altInput, jadi nilainya diisi lewat
     * instance flatpickr agar format tanggal (Y-m-d) tetap sesuai kontrak form.
     */
    public void pickDate(LocalDate date) {
        executeScript(
                "const el = document.querySelector(\"input[name='tanggal']\");" +
                        "if (el && el._flatpickr) { el._flatpickr.setDate(arguments[0], true); }" +
                        "else if (el) { el.value = arguments[0]; }",
                date.toString());
    }

    public String getDateValue() {
        return find(dateInput).getAttribute("value");
    }

    public void submitReservation() {
        click(submitButton);
    }

    public boolean hasSuccessMessage() {
        return isVisible(successBox);
    }

    public boolean hasReservationRow(String patientName, String doctorName) {
        for (WebElement row : driver.findElements(tableRows)) {
            String text = row.getText();
            if (text.contains(patientName) && text.contains(doctorName)) {
                return true;
            }
        }
        return false;
    }
}
