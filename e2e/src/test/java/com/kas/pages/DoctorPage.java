package com.kas.pages;

import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.UnhandledAlertException;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;

import com.kas.components.FormModal;
import com.kas.components.Notification;
import com.kas.components.RecordList;

public class DoctorPage extends BasePage {

    private final By pageTitle = By.xpath("//h1[normalize-space()='Dokter']");
    private final RecordList doctors = new RecordList(driver, wait, "doctor-name", "doctor-card");
    private final By emptyState = By.xpath("//h3[normalize-space()='Belum ada dokter']");

    private final By addButton = By.cssSelector("[data-testid='add-doctor']");
    private final By modalRoot = By.cssSelector("[data-testid='doctor-modal']");
    private final FormModal modal = new FormModal(driver, wait, modalRoot,
            By.cssSelector("[data-testid='doctor-modal'] h5"));

    private final Notification notification = new Notification(driver, wait);

    private final By nameInput = By.cssSelector("[data-testid='doctor-modal'] input[name='nama']");
    private final By specializationInput = By.id("spesialis");
    private final By phoneInput = By.cssSelector("[data-testid='doctor-modal'] input[name='no_telepon']");
    private final By emailInput = By.id("email");
    private final By consultationCostInput = By.id("biaya_konsultasi");

    private final By usernameInput = By.id("username");
    private final By passwordInput = By.id("password");

    public DoctorPage(WebDriver driver) {
        super(driver);
    }

    public DoctorPage goTo() {
        open("/dokter");
        return this;
    }

    public boolean isOnDoctorPage() {
        return isVisible(pageTitle);
    }

    public int doctorCount() {
        return doctors.count();
    }

    public List<String> doctorNames() {
        return doctors.names();
    }

    public boolean hasDoctor(String nama) {
        return doctors.has(nama);
    }

    public boolean hasEmptyState() {
        return isElementPresent(emptyState);
    }

    public DoctorPage waitForDoctor(String nama) {
        doctors.waitFor(nama);
        return this;
    }

    public DoctorPage waitForDoctorGone(String nama) {
        doctors.waitForGone(nama);
        return this;
    }

    // --- Tambah / edit / hapus dokter ---
    public DoctorPage clickAdd() {
        click(addButton);
        modal.waitUntilOpen();
        return this;
    }

    public boolean isModalOpen() {
        return modal.isOpen();
    }

    /**
     * Mengisi field dokter di modal tambah.
     *
     * Tanggal lahir tidak termasuk karena diisi lewat
     * {@link #setBirthDate(String)} (flatpickr), dan wajib dipanggil sebelum
     * {@link #submit()} pada mode tambah. Username/password hanya terlihat saat
     * menambah, bukan saat mengedit.
     */
    public DoctorPage fillDoctor(String name, String specialization, String phoneNumber, String email,
            String consultationCost, String username, String password) {
        if (name != null) {
            type(nameInput, name);
        }
        if (specialization != null) {
            type(specializationInput, specialization);
        }
        if (email != null) {
            type(emailInput, email);
        }
        if (phoneNumber != null) {
            type(phoneInput, phoneNumber);
        }
        if (consultationCost != null) {
            type(consultationCostInput, consultationCost);
        }
        if (username != null) {
            type(usernameInput, username);
        }
        if (password != null) {
            type(passwordInput, password);
        }
        return this;
    }

    public DoctorPage fillDoctorName(String name) {
        type(nameInput, name);
        return this;
    }

    /**
     * Mengisi tanggal lahir lewat API flatpickr.
     *
     * Input yang terlihat dibuat oleh flatpickr (alt input, readonly) dan nilai
     * yang di-submit ada di input hidden, jadi sendKeys tidak dipakai.
     */
    public DoctorPage selectBirthDate(String isoDate) {
        executeScript(
                "document.getElementById('tanggal_lahir')._flatpickr.setDate(arguments[0], true);",
                isoDate);
        return this;
    }

    public DoctorPage submit() {
        modal.submit();
        notification.waitForResult();
        modal.waitUntilClosed();
        return this;
    }

    public DoctorPage clickEdit(String nama) {
        doctors.item(nama).findElement(By.cssSelector("[data-testid='edit-doctor']")).click();
        modal.waitUntilOpen();
        return this;
    }

    public DoctorPage deleteDoctor(String nama) {
        try {
            doctors.item(nama).findElement(By.cssSelector("[data-testid='delete-doctor']")).click();
        } catch (UnhandledAlertException e) {
            // Chrome melempar exception begitu confirm() muncul; alert ditangani di bawah.
        }

        wait.until(ExpectedConditions.alertIsPresent());
        driver.switchTo().alert().accept();

        notification.waitForResult();
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

    public DoctorPage openDoctor(String name) {
        doctors.item(name).click();
        waitForUrlContains("/pasien/");
        return this;
    }
}
