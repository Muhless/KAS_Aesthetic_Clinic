package com.kas.pages;

import java.time.Duration;

import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.Select;
import org.openqa.selenium.support.ui.WebDriverWait;

import com.kas.config.Config;

public class BasePage {

    protected final WebDriver driver;
    protected final WebDriverWait wait;

    public BasePage(WebDriver driver) {
        this.driver = driver;
        this.wait = new WebDriverWait(driver, Duration.ofSeconds(10));
    }

    public void open(String path) {
        driver.get(Config.BASE_URL + path);
    }

    protected WebElement find(By locator) {
        return wait.until(ExpectedConditions.visibilityOfElementLocated(locator));
    }

    protected void click(By locator) {
        click(wait.until(ExpectedConditions.elementToBeClickable(locator)));
    }

    protected void click(WebElement element) {
        scrollToCenter(element);

        // Di layout ini ChromeDriver kadang mengirim klik ke koordinat yang
        // salah (container konten memakai overflow-y-auto), sehingga tidak ada
        // event click sama sekali. Deteksi lalu fallback ke JS click.
        executeScript("window.__kasClickDelivered = false;"
                + "document.addEventListener('click', function handler() {"
                + "  window.__kasClickDelivered = true;"
                + "  document.removeEventListener('click', handler, true);"
                + "}, true);");

        element.click();

        boolean delivered;
        try {
            delivered = Boolean.TRUE.equals(executeScript("return window.__kasClickDelivered"));
        } catch (RuntimeException e) {
            // Dokumen sudah berganti karena klik memicu navigasi.
            delivered = true;
        }

        if (!delivered) {
            try {
                executeScript("arguments[0].click()", element);
            } catch (org.openqa.selenium.StaleElementReferenceException e) {
                // Navigasi sudah terjadi lewat klik pertama.
            }
        }
    }

    /**
     * Container konten memakai {@code overflow-y-auto}, sehingga Selenium
     * kadang menghitung posisi klik di luar viewport dan kliknya tidak
     * terkirim. Scroll eksplisit ke tengah viewport membuat klik konsisten.
     */
    protected void scrollToCenter(WebElement element) {
        executeScript("arguments[0].scrollIntoView({block: 'center', inline: 'center'});", element);
    }

    protected void type(By locator, String text) {
        WebElement element = find(locator);
        element.clear();
        element.sendKeys(text);

        if (!text.equals(element.getDomProperty("value"))) {
            executeScript(
                    "arguments[0].value = arguments[1];"
                            + "arguments[0].dispatchEvent(new Event('input', {bubbles: true}));"
                            + "arguments[0].dispatchEvent(new Event('change', {bubbles: true}));",
                    element, text);
        }
    }

    protected String getText(By locator) {
        return find(locator).getText();
    }

    public void waitForUrlContains(String part) {
        wait.until(ExpectedConditions.urlContains(part));
    }

    public void waitForUrlNotContains(String part) {
        wait.until(ExpectedConditions.not(ExpectedConditions.urlContains(part)));
    }

    public boolean isVisible(By locator) {
        return wait.until(ExpectedConditions.visibilityOfElementLocated(locator)).isDisplayed();
    }

    public boolean isElementPresent(By locator) {
        return !driver.findElements(locator).isEmpty();
    }

    public Object executeScript(String script, Object... args) {
        return ((JavascriptExecutor) driver).executeScript(script, args);
    }


    // for select input
    public void selectByText(By locator, String text) {
        WebElement element = wait.until(ExpectedConditions.visibilityOfElementLocated(locator));
        new Select(element).selectByVisibleText(text);
    }
}
