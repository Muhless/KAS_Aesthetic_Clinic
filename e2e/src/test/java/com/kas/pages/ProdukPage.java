package com.kas.pages;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;

public class ProdukPage extends BasePage {

    private final By pageTitle = By.xpath("//h1[normalize-space()='Produk']");
    private final By productNames = By.cssSelector("h2");
    private final By emptyState = By.xpath("//h3[normalize-space()='Belum ada produk']");

    public ProdukPage(WebDriver driver) {
        super(driver);
    }

    public ProdukPage goTo() {
        open("/produk");
        return this;
    }

    public boolean isPageLoaded() {
        return isVisible(pageTitle);
    }

    public int productCount() {
        return driver.findElements(productNames).size();
    }

    public boolean hasEmptyState() {
        return isElementPresent(emptyState);
    }

    public boolean hasProduct(String name) {
        return isElementPresent(By.xpath("//h2[normalize-space()='" + name + "']"));
    }
}
