package com.kas.steps;

import static org.junit.jupiter.api.Assertions.assertEquals;
import static org.junit.jupiter.api.Assertions.assertFalse;
import static org.junit.jupiter.api.Assertions.assertTrue;

import com.kas.api.TreatmentApi;
import com.kas.hooks.DriverManager;
import com.kas.pages.TreatmentPage;
import com.kas.support.ScenarioContext;

import io.cucumber.java.en.Given;
import io.cucumber.java.en.Then;
import io.cucumber.java.en.When;

/**
 * Skenario CRUD halaman Treatment (/treatment).
 *
 * Data untuk skenario edit/hapus disiapkan lewat API supaya tidak bergantung
 * pada record seeder yang dipakai bersama.
 */
public class TreatmentSteps {

    private TreatmentPage treatmentPage;

    private TreatmentPage page() {
        if (treatmentPage == null) {
            treatmentPage = new TreatmentPage(DriverManager.get());
        }
        return treatmentPage;
    }

    @When("admin opens the treatment page")
    public void admin_opens_the_treatment_page() {
        treatmentPage = page().goTo();
        ScenarioContext.setNotifiable(treatmentPage);

        assertTrue(treatmentPage.isOnTreatmentPage(), "Halaman Treatment tidak tampil");
    }

    @Then("treatment list is shown")
    public void treatment_list_is_shown() {
        assertTrue(page().treatmentCount() > 0 || page().hasEmptyState(),
                "Daftar treatment tidak tampil (tidak ada kartu treatment maupun empty state)");
    }

    @When("admin adds a new treatment")
    public void admin_adds_a_new_treatment() {
        treatmentPage = page().goTo();
        treatmentPage.clickAdd()
                .fillTreatment("New Treatment", "Treatment for whitening skin", "200000", "60")
                .selectStatus("tersedia")
                .submit();

        ScenarioContext.setNotifiable(treatmentPage);
    }

    @Given("a treatment named {string} exists")
    public void a_treatment_named_exists(String name) {
        TreatmentApi.create(name, "Treatment untuk test e2e", 150000, 60, "tersedia");
        treatmentPage = page().goTo();
    }

    @When("admin renames the treatment {string} to {string}")
    public void admin_renames_the_treatment(String oldName, String newName) {
        treatmentPage = page().goTo();
        treatmentPage.clickEdit(oldName)
                .fillTreatmentName(newName)
                .submit();

        ScenarioContext.setNotifiable(treatmentPage);
    }

    @When("admin deletes the treatment {string}")
    public void admin_deletes_the_treatment(String name) {
        treatmentPage = page().goTo();
        treatmentPage.deleteTreatment(name);

        ScenarioContext.setNotifiable(treatmentPage);
    }

    @Then("treatment {string} appears in the list")
    public void treatment_appears_in_the_list(String name) {
        page().waitForTreatment(name);
        assertTrue(page().hasTreatment(name), "Treatment " + name + " tidak ada di daftar");
    }

    @Then("treatment {string} is no longer in the list")
    public void treatment_is_no_longer_in_the_list(String name) {
        page().waitForTreatmentGone(name);
        assertFalse(page().hasTreatment(name), "Treatment masih tampil setelah dihapus");
    }
}
