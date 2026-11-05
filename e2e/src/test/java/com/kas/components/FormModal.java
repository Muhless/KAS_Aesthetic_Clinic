package com.kas.components;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

/**
 * Komponen modal form yang dipakai ulang oleh halaman-halaman CRUD.
 *
 * Page object tetap memiliki locator root & judulnya, sedangkan kelas ini
 * menangani perilaku umum: menunggu terbuka, submit, dan menunggu tertutup.
 */
public class FormModal {

    private final WebDriver driver;
    private final WebDriverWait wait;
    private final By root;
    private final By title;

    public FormModal(WebDriver driver, WebDriverWait wait, By root, By title) {
        this.driver = driver;
        this.wait = wait;
        this.root = root;
        this.title = title;
    }

    public FormModal waitUntilOpen() {
        wait.until(ExpectedConditions.visibilityOfElementLocated(title));
        return this;
    }

    public boolean isOpen() {
        return driver.findElements(root).stream().anyMatch(WebElement::isDisplayed);
    }

    public String title() {
        return wait.until(ExpectedConditions.visibilityOfElementLocated(title)).getText().trim();
    }

    public FormModal submit() {
        driver.findElement(root).findElement(By.cssSelector("button[type='submit']")).click();
        return this;
    }

    public FormModal waitUntilClosed() {
        wait.until(ExpectedConditions.invisibilityOfElementLocated(root));
        return this;
    }
}
