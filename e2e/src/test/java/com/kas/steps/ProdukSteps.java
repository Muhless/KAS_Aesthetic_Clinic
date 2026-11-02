package com.kas.steps;

import static org.junit.jupiter.api.Assertions.assertTrue;

import com.kas.hooks.DriverManager;
import com.kas.pages.ProdukPage;

import io.cucumber.java.en.Then;
import io.cucumber.java.en.When;

public class ProdukSteps {

    private ProdukPage produkPage() {
        return new ProdukPage(DriverManager.get());
    }

    @When("User open product page")
    public void user_open_product_page() {
        ProdukPage page = produkPage().goTo();
        assertTrue(page.isPageLoaded(), "Halaman Produk tidak tampil");
    }

    @Then("Show product list")
    public void show_product_list() {
        ProdukPage page = produkPage();
        assertTrue(
                page.productCount() > 0 || page.hasEmptyState(),
                "Daftar produk tidak tampil (tidak ada kartu produk maupun empty state)");
    }
}
