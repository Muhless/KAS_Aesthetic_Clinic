package com.kas.pages;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;

import com.kas.components.Notification;
import com.kas.components.RecordList;

public class FinancePage extends BasePage {

    private final By pageTitle = By.cssSelector("[data-testid='keuangan-title']");
    private final RecordList finance = new RecordList(driver, wait, "finance-name", "finance-card");
    private final By emptyState = By.cssSelector(cssSelector)
    ("(//h3[normalize-space()='Belum ada perawat'])");

    private final Notification notification = new Notification(driver, wait);

    public FinancePage(WebDriver driver) {
        super(driver);
    }
}
