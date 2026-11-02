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
        wait.until(ExpectedConditions.elementToBeClickable(locator)).click();
    }

    protected void type(By locator, String text) {
        WebElement element = find(locator);
        element.clear();
        element.sendKeys(text);
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
