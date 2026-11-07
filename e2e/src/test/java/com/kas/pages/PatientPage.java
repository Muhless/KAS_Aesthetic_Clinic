package com.kas.pages;

import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;

import com.kas.components.FormModal;
import com.kas.components.Notification;
import com.kas.components.RecordList;

public class PatientPage extends BasePage {

    private final By pageTitle = By.xpath("(//h1[normalize-space()='Pasien'])");
    private final RecordList patients = new RecordList(driver, wait, "patient-name", "patient-row");
    private final By emptyState = By.xpath("//td[normalize-space()='Belum ada data pasien']");

    private final By addButton = By.cssSelector("[data-testid='add-patient']");
    private final By modalRoot = By.cssSelector("[data-testid='patient-modal']");
    private final FormModal modal = new FormModal(driver, wait, modalRoot,
            By.cssSelector("[data-testid='patient-modal'] h5"));

    private final Notification notification = new Notification(driver, wait);

    private final By nameInput = By.cssSelector("[data-testid='patient-modal'] input[name='nama']");
    private final By maleGender = By.cssSelector("[data-testid='patient-modal'] input[name='jenis_kelamin'][value='L']");
    private final By femaleGender = By.cssSelector("[data-testid='patient-modal'] input[name='jenis_kelamin'][value='P']");
    private final By phoneInput = By.cssSelector("[data-testid='patient-modal'] input[name='nomor_telepon']");
    private final By birthDateSelect = By.cssSelector("[data-testid='patient-modal'] input[type='text'][placeholder='Pilih tanggal lahir']");

    public PatientPage(WebDriver driver) {
        super(driver);
    }

    public PatientPage goTo() {
        open("/pasien");
        return this;
    }

    public boolean isOnPatientPage() {
        return isVisible(pageTitle);
    }

    public int patientCount() {
        return patients.count();
    }

    public List<String> patientNames() {
        return patients.names();
    }

    public boolean hasEmptyState() {
        return isElementPresent(emptyState);
    }

    public PatientPage waitForPatient(String nama) {
        patients.waitFor(nama);
        return this;
    }

    public PatientPage waitForPatientGone(String nama) {
        patients.waitForGone(nama);
        return this;
    }

// modal
    public PatientPage clickAdd() {
        click(addButton);
        modal.waitUntilOpen();
        return this;
    }

    public boolean isModalOpen() {
        return modal.isOpen();

    }

    public PatientPage fillPatient(String name, String phoneNumber) {
        if (name != null) {
            type(nameInput, name);
        }

        if (phoneNumber != null) {
            type(phoneInput, phoneNumber);

        }
        return this;
    }

    public PatientPage fillPatientName(String nama) {
        type(nameInput, nama);
        return this;
    }

    public PatientPage selectGender(String gender) {
        if ("laki-laki".equalsIgnoreCase(gender)) {
            click(maleGender);
        } else {
            click(femaleGender);
        }
        return this;
    }

    /**
     * Mengisi tanggal lahir lewat API flatpickr.
     *
     * Input yang terlihat dibuat oleh flatpickr (alt input, readonly) dan nilai
     * yang di-submit ada di input hidden. Karena itu sendKeys tidak dipakai.
     */
    public PatientPage setBirthDate(String isoDate) {
        executeScript(
                "const input = document.querySelector(\"[data-testid='patient-modal'] input[name='tanggal_lahir']\");"
                        + "input._flatpickr.setDate(arguments[0], true);",
                isoDate);
        return this;
    }

    public PatientPage submit() {
        modal.submit();
        notification.waitForResult();
        modal.waitUntilClosed();
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

    public PatientPage openPatient(String name) {
        patients.item(name).click();
        waitForUrlContains("/pasien/");
        return this;
    }

    public PatientPage clickEdit() {
        click(By.xpath("//button[normalize-space()='Edit']"));
        modal.waitUntilOpen();
        return this;
    }

    public PatientPage deletePatient(String nama) {
        openPatient(nama);

        click(By.xpath("//button[normalize-space()='Hapus']"));
        click(By.cssSelector(".swal2-confirm"));

        waitForUrlNotContains("/pasien/");
        notification.waitForResult();
        return this;
    }
}
