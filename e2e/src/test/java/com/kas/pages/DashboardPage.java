package com.kas.pages;

import java.time.LocalDate;
import java.time.format.DateTimeFormatter;
import java.util.Locale;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;

public class DashboardPage extends BasePage {
    private final By addButton = By.xpath("//button[normalize-space()='Tambah Reservasi']");
    private final By patientSelectBy = By.name("patient_id");
    private final By doctorSelectBy = By.name("doctor_id");
    private final By dateInputBy = By.cssSelector("input[placeholder='Pilih tanggal reservasi']");
    private final By submitButtonBy = By.cssSelector("button[type='submit']");

    public DashboardPage(WebDriver driver) {
        super(driver);
    }

    public DashboardPage goTo() {
        open("/");
        return this;
    }

    public void clickAdd() {
        wait.until(ExpectedConditions.elementToBeClickable(addButton)).click();
        wait.until(ExpectedConditions.visibilityOfElementLocated(patientSelectBy));
    }

    public void selectPatient(String patientName) {
        selectByText(patientSelectBy, patientName);
    }

    public void selectDoctor(String doctorName) {
        selectByText(doctorSelectBy, doctorName);
    }

    public void pickDate(LocalDate date) {
        wait.until(ExpectedConditions.elementToBeClickable(dateInputBy)).click();

        String label = date.format(DateTimeFormatter.ofPattern("MMMM d, yyyy", Locale.ENGLISH));
        By dayCell = By.cssSelector("span.flatpickr-day[aria-label='" + label + "']");

        wait.until(ExpectedConditions.elementToBeClickable(dayCell)).click();
    }

    public void subbmitReservation() {
        click(submitButtonBy);
    }

}
