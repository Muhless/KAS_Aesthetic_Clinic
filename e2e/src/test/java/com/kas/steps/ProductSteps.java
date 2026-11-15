package com.kas.steps;

import static org.junit.jupiter.api.Assertions.assertEquals;
import static org.junit.jupiter.api.Assertions.assertFalse;
import static org.junit.jupiter.api.Assertions.assertTrue;

import java.util.List;

import com.kas.hooks.DriverManager;
import com.kas.pages.ProductPage;
import com.kas.support.ScenarioContext;

import io.cucumber.java.en.Then;
import io.cucumber.java.en.When;

/**
 * Skenario halaman Produk (/produk): CRUD dan filter daftar produk.
 */
public class ProductSteps {

    private ProductPage productPage;

    private ProductPage page() {
        if (productPage == null) {
            productPage = new ProductPage(DriverManager.get());
        }
        return productPage;
    }

    @When("admin opens the product page")
    public void admin_opens_the_product_page() {
        productPage = page().goTo();
        ScenarioContext.setNotifiable(productPage);

        assertTrue(productPage.isOnProductPage(), "Halaman Produk tidak tampil");
    }

    @Then("product list is shown")
    public void product_list_is_shown() {
        assertTrue(page().productCount() > 0 || page().hasEmptyState(),
                "Daftar produk tidak tampil (tidak ada kartu produk maupun empty state)");
    }

    @When("admin adds a new product")
    public void admin_adds_a_new_product() {
        productPage = page().goTo();
        productPage.clickAdd()
                .fillProduct("Produk Baru", "Perawatan", "Produk e2e", "50000", "5")
                .selectStatus("tersedia")
                .submit();

        ScenarioContext.setNotifiable(productPage);
    }

    @When("admin opens the add product form and submits it empty")
    public void admin_opens_the_add_product_form_and_submits_it_empty() {
        productPage = page().goTo();
        productPage.clickAdd().submit();

        ScenarioContext.setNotifiable(productPage);
    }

    @When("admin adds a low stock product {string}")
    public void admin_adds_a_low_stock_product(String name) {
        productPage = page().goTo();
        productPage.clickAdd()
                .fillProduct(name, "Perawatan", "Produk e2e", "10000", "3")
                .selectStatus("tersedia")
                .submit();

        ScenarioContext.setNotifiable(productPage);
    }

    @When("admin renames the product {string} to {string}")
    public void admin_renames_the_product(String oldName, String newName) {
        productPage = page().goTo();
        productPage.clickEdit(oldName)
                .fillName(newName)
                .submit();

        ScenarioContext.setNotifiable(productPage);
    }

    @When("admin deletes the product {string}")
    public void admin_deletes_the_product(String name) {
        productPage = page().goTo();
        productPage.deleteProduct(name);

        ScenarioContext.setNotifiable(productPage);
    }

    @Then("product {string} appears in the list")
    public void product_appears_in_the_list(String name) {
        page().waitForProduct(name);
        assertTrue(page().hasProduct(name), "Produk " + name + " tidak ada di daftar");
    }

    @Then("product {string} is no longer in the list")
    public void product_is_no_longer_in_the_list(String name) {
        page().waitForProductGone(name);
        assertFalse(page().hasProduct(name), "Produk masih ada setelah dihapus");
    }

    @When("admin filters products by name {string}")
    public void admin_filters_products_by_name(String name) {
        productPage = page().goTo();
        productPage.filterByName(name);
    }

    @Then("only product {string} is shown")
    public void only_product_is_shown(String name) {
        assertEquals(List.of(name), page().productNames(), "Hasil filter produk tidak sesuai");
    }

    @Then("product empty state is shown")
    public void product_empty_state_is_shown() {
        assertTrue(page().hasEmptyState(), "Empty state produk tidak tampil");
    }

    @When("admin filters products with low stock")
    public void admin_filters_products_with_low_stock() {
        page().filterStokMenipis();
    }
}
