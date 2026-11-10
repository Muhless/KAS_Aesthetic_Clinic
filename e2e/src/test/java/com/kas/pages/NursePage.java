package com.kas.pages;

import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.ElementNotInteractableException;
import org.openqa.selenium.UnhandledAlertException;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.ExpectedConditions;

import com.kas.components.FormModal;
import com.kas.components.Notification;
import com.kas.components.RecordList;

public class NursePage extends BasePage {

    private final By pageTitle = By.xpath("(//h1[normalize-space()='Perawat'])");
    private final RecordList nurses = new RecordList(driver, wait, "nurse-name", "nurse-card");
    private final By emptyState = By.xpath("(//h3[normalize-space()='Belum ada perawat'])");

    private final By addButton = By.cssSelector("[data-testid='add-nurse']");
    private final By modalRoot = By.cssSelector("[data-testid='nurse-modal']");
    private final FormModal modal = new FormModal(driver, wait, modalRoot, By.cssSelector("[data-testid='nurse-modal'] h5"));

    private final Notification notification = new Notification(driver, wait);

    private final By nameInput = By.cssSelector("[data-testid='nurse-modal'] input[name='nama']");
    private final By phoneInput = By.cssSelector("[data-testid='nurse-modal'] input[name='no_telepon']");
    private final By emailInput = By.cssSelector("[data-testid='nurse-modal'] input[name='email']");
    private final By photoInput = By.cssSelector("[data-testid='nurse-modal'] input[type='file'][name='foto']");

    private final By usernameInput = By.id("username_perawat");
    private final By passwordInput = By.id("password_perawat");

    public NursePage(WebDriver driver) {
        super(driver);
    }

    public NursePage goTo() {
        open("/perawat");
        return this;
    }

    public boolean isOnNursePage() {
        return isVisible(pageTitle);
    }

    public int nurseCount() {
        return nurses.count();
    }

    public List<String> nurseNames() {
        return nurses.names();
    }

    public boolean hasNurse(String nama) {
        return nurses.has(nama);
    }

    public boolean hasEmptyState() {
        return isElementPresent(emptyState);
    }

    public NursePage waitForNurse(String nama) {
        nurses.waitFor(nama);
        return this;
    }

    public NursePage waitForNurseGone(String nama) {
        nurses.waitForGone(nama);
        return this;
    }

    public NursePage clickAdd() {
        click(addButton);
        modal.waitUntilOpen();
        return this;
    }

    public boolean isModalOpen() {
        return modal.isOpen();
    }

    public NursePage fillNurse(String name, String phoneNumber, String email, String username, String password) {
        if (name != null) {
            type(nameInput, name);
        }
        if (email != null) {
            type(emailInput, email);
        }
        if (phoneNumber != null) {
            type(phoneInput, phoneNumber);
        }
        if (username != null) {
            type(usernameInput, username);
        }
        if (password != null) {
            type(passwordInput, password);
        }
        return this;
    }

    public NursePage fillNurseName(String name) {
        type(nameInput, name);
        return this;
    }

    public NursePage selectBirthDate(String isoDate) {
        executeScript(
                "document.getElementById('tanggal_lahir_perawat')._flatpickr.setDate(arguments[0], true);",
                isoDate);
        return this;
    }

    /**
     * Melampirkan file foto ke input file di modal.
     *
     * Input foto disembunyikan dengan class "hidden", jadi tidak memakai type()
     * yang menunggu elemen visible. Kalau Chrome menolak karena elemen tidak
     * interactable, class hidden dilepas sementara lalu dipasang lagi.
     *
     * @param absolutePath path absolut file gambar (jpg/png/webp, maks. 2MB)
     */
    public NursePage uploadPhoto(String absolutePath) {
        WebElement input = wait.until(ExpectedConditions.presenceOfElementLocated(photoInput));
        try {
            input.sendKeys(absolutePath);
        } catch (ElementNotInteractableException e) {
            executeScript("arguments[0].classList.remove('hidden');", input);
            input.sendKeys(absolutePath);
            executeScript("arguments[0].classList.add('hidden');", input);
        }
        return this;
    }

    /** URL foto yang dirender pada kartu perawat dengan nama tersebut. */
    public String nursePhotoSrc(String nama) {
        return nurses.item(nama)
                .findElement(By.cssSelector("[data-testid='nurse-photo']"))
                .getAttribute("src");
    }

    public NursePage submit() {
        modal.submit();
        notification.waitForResult();
        modal.waitUntilClosed();
        return this;
    }

    public NursePage clickEdit(String nama) {
        nurses.item(nama).findElement(By.cssSelector("[data-testid='edit-nurse']")).click();
        modal.waitUntilOpen();
        return this;
    }

    public NursePage deleteNurse(String nama) {
        try {
            nurses.item(nama).findElement(By.cssSelector("[data-testid='delete-nurse']")).click();
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
}
