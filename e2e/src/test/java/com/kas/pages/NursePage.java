package com.kas.pages;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;

import com.kas.components.FormModal;
import com.kas.components.Notification;
import com.kas.components.RecordList;

public class NursePage extends BasePage {

    private final By pageTitle = By.xpath("(//h1[normalize-space()='Dokter'])");
    private final RecordList nurses = new RecordList(driver, wait, "nurse-name", "nurse-card");
    private final By emptyState = By.xpath("(//h3[normalize-space()='Belum ada perawat'])");

    private final By addButton = By.cssSelector("[data-testid='add-nurse']");
    private final By modalRoot = By.cssSelector("[data-testid='nurse-modal']");
    private final FormModal modal = new FormModal(driver, wait, modalRoot, By.cssSelector("[data-testid='nurse-modal'] h5"));

    private final Notification notification = new Notification(driver, wait);

    private final By nameInput = By.cssSelector("[data-testid='nurse-modal'] input[name='nama']");
    private final By phoneInput = By.cssSelector("[data-testid='nurse-modal'] input[name='no_telepon']");
    private final By emailInput = By.id("email");

    private final By usernameInput = By.id("username_perawat");
    private final By passwordInput = By.id("password_perawat");

    public NursePage(WebDriver driver) {
        super(driver);
    }

    public NursePage goTo() {
        open("/nurse");
        return this;
    }
}
