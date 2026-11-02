package com.kas.pages;

import java.time.Duration;

import org.openqa.selenium.By;
import org.openqa.selenium.TimeoutException;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

public class LoginPage extends BasePage {
    private final By usernameInput = By.cssSelector("input[name='username']");
    private final By passwordInput = By.cssSelector("input[name='password']");
    private final By submitButton = By.cssSelector("button[type='submit']");
    private final By errorMessage = By.cssSelector(".alert-danger, .invalid-feedback, .text-red-500");

    public LoginPage(WebDriver driver) {
        super(driver);
    }

    public LoginPage goTo() {
        open("/login");
        return this;
    }

    public void login(String username, String password) {
        type(usernameInput, username);
        type(passwordInput, password);
        click(submitButton);
    }


    public String getErrorMessage() {
        try {
            return new WebDriverWait(driver, Duration.ofSeconds(5))
                    .until(ExpectedConditions.visibilityOfElementLocated(errorMessage))
                    .getText()
                    .trim();
        } catch (TimeoutException e) {
            return "";
        }
    }

    public boolean isOnLoginPage() {
        return isVisible(usernameInput) && driver.getCurrentUrl().contains("/login");
    }

}
