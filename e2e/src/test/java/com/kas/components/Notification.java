package com.kas.components;

import java.util.List;
import java.util.stream.Collectors;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

/**
 * Notifikasi sukses/error yang tampil setelah submit form. Markup-nya sama
 * untuk semua halaman CRUD (components/notification.blade.php).
 */
public class Notification {

    private static final By SUCCESS_TITLE = By.xpath("//h3[normalize-space()='Berhasil!']");
    private static final By SUCCESS_MESSAGE = By.xpath("//h3[normalize-space()='Berhasil!']/following-sibling::p");
    private static final By ERROR_TITLE = By.xpath("//h3[normalize-space()='Terjadi Kesalahan']");
    private static final By ERROR_MESSAGES = By.xpath(
            "//h3[normalize-space()='Terjadi Kesalahan']/ancestor::div[contains(@class,'z-50')]//li");

    private final WebDriver driver;
    private final WebDriverWait wait;

    public Notification(WebDriver driver, WebDriverWait wait) {
        this.driver = driver;
        this.wait = wait;
    }

    /**
     * Submit sukses maupun gagal validasi sama-sama redirect + menampilkan
     * notifikasi.
     */
    public Notification waitForResult() {
        wait.until(ExpectedConditions.or(
                ExpectedConditions.visibilityOfElementLocated(SUCCESS_TITLE),
                ExpectedConditions.visibilityOfElementLocated(ERROR_TITLE)));
        return this;
    }

    public boolean hasSuccess() {
        return isVisible(SUCCESS_TITLE);
    }

    public String successMessage() {
        return wait.until(ExpectedConditions.visibilityOfElementLocated(SUCCESS_MESSAGE)).getText().trim();
    }

    public boolean hasError() {
        return isVisible(ERROR_TITLE);
    }

    public List<String> errorMessages() {
        return driver.findElements(ERROR_MESSAGES).stream()
                .map(element -> element.getText().trim())
                .collect(Collectors.toList());
    }

    private boolean isVisible(By locator) {
        return wait.until(ExpectedConditions.visibilityOfElementLocated(locator)).isDisplayed();
    }
}
