package com.kas.pages;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.ExpectedConditions;

public class TreatmentPage extends BasePage {

    private final By titlePage = By.xpath("(//h1[normalize-space()='Treatment'])");
    private final By emptyState = By.xpath("(//h3[normalize-space()='Belum ada treatment'])");

    private final By addButton = By.xpath("(//button[normalize-space()='Tambah Treatment'])[1]");
    private final By modalForm = By.xpath("(//form[@enctype='multipart/form-data'])");
    private final By modalTitle = By.xpath("(//h5[normalize-space()='Tambah Treatment'])");

    private final By nameInput = By.id("nama");
    private final By descriptionInput = By.id("deskripsi");
    private final By priceInput = By.id("harga");
    private final By durationInputBy = By.id("duration");
    private final By statusAvailableBy = By.id("status_tersedia");
    private final By statusNotAvailableBy = By.id("status_tidak_tersedia");

    public TreatmentPage(WebDriver driver) {
        super(driver);
    }

    public TreatmentPage goTo() {
        open("/treatment");
        return this;
    }

    public boolean isOnTreatmentPage() {
        return isVisible(titlePage);
    }

    public boolean hasEmptyState() {
        return isElementPresent(emptyState);
    }

    public TreatmentPage clickAdd() {
        click(addButton);
        wait.until(ExpectedConditions.visibilityOfElementLocated(modalTitle));
        return this;
    }

    public boolean isModalOpen() {
        return driver.findElements(modalForm).stream().anyMatch(WebElement::isDisplayed);
    }

    public TreatmentPage fillProduct(String name, String description, String price, String duration) {
        if (name != null) {
            type(nameInput, name);
        }
        if (description != null) {
            type(descriptionInput, description);
        }
        if (price != null) {
            type(descriptionInput, price);
        }
        if (duration != null) {
            type(descriptionInput, duration);
        }
        return this;
    }
}
