package com.kas.steps;

import static org.junit.jupiter.api.Assertions.assertEquals;
import static org.junit.jupiter.api.Assertions.assertTrue;

import java.util.List;

import com.kas.api.CatalogApi;
import com.kas.api.VisitApi;
import com.kas.config.Config;
import com.kas.hooks.DriverManager;
import com.kas.pages.ExaminationPage;
import com.kas.pages.NakesPage;
import com.kas.support.ScenarioContext;

import io.cucumber.java.en.Given;
import io.cucumber.java.en.Then;
import io.cucumber.java.en.When;

/**
 * Skenario form pemeriksaan dokter (/pemeriksaan/{id}/edit): membuka form dari
 * antrian, menyimpan hasil pemeriksaan, dan membaca kembali hasilnya.
 */
public class ExaminationSteps {

    private static final String TREATMENT = "Treatment E2E";
    private static final String PRODUK = "Produk E2E";

    private ExaminationPage examinationPage;
    private VisitApi.Visit apiVisit;

    @Given("a complete examination for patient {string} is created through the API")
    public void a_complete_examination_is_created_through_the_api(String patient) {
        long treatmentId = CatalogApi.treatmentId(TREATMENT);
        long produkId = CatalogApi.productId(PRODUK);

        apiVisit = VisitApi.createExamined(
                patient, Config.DOCTOR_USERNAME, "Perawatan wajah", treatmentId, List.of(produkId));

        assertTrue(apiVisit.hasPemeriksaan(), "API tidak membuat data pemeriksaan");
    }

    @When("doctor opens the examination edit url")
    public void doctor_opens_the_examination_edit_url() {
        DriverManager.get().get(apiVisit.pemeriksaanEditUrl());

        examinationPage = new ExaminationPage(DriverManager.get());
        examinationPage.waitUntilReady();
    }

    @When("doctor opens the examination form for patient {string}")
    public void doctor_opens_the_examination_form_for_patient(String patient) {
        NakesPage nakesPage = new NakesPage(DriverManager.get()).goTo();
        nakesPage.waitForPatient(patient);

        examinationPage = nakesPage.clickPeriksa(patient);
    }

    @Then("examination form is shown for patient {string}")
    public void examination_form_is_shown_for_patient(String patient) {
        assertTrue(examinationPage.isOnPage(), "Form pemeriksaan tidak terbuka");
        assertTrue(examinationPage.patientLabel().contains(patient),
                "Form pemeriksaan tidak menampilkan pasien yang benar: " + examinationPage.patientLabel());
        assertTrue(DriverManager.get().getCurrentUrl().matches(".*/pemeriksaan/\\d+/edit"),
                "URL form pemeriksaan tidak sesuai: " + DriverManager.get().getCurrentUrl());
    }

    @Then("product {string} is available in the examination form")
    public void product_is_available_in_the_examination_form(String product) {
        assertTrue(examinationPage.productNames().contains(product),
                "Produk " + product + " tidak ada di form pemeriksaan");
    }

    @When("doctor fills the examination with treatment {string}, diagnosa {string}, tindakan {string}, "
            + "catatan {string}, and product {string}")
    public void doctor_fills_the_examination(String treatment, String diagnosa, String tindakan,
            String catatan, String product) {
        examinationPage.selectTreatment(treatment)
                .fillDiagnosa(diagnosa)
                .fillTindakan(tindakan)
                .fillCatatan(catatan)
                .checkProduct(product);

        assertTrue(examinationPage.isProductChecked(product), "Produk gagal dicentang");
    }

    @When("doctor saves the examination")
    public void doctor_saves_the_examination() {
        NakesPage afterSubmit = examinationPage.submit();
        ScenarioContext.setNotifiable(afterSubmit);
    }

    @When("doctor opens the examination result for patient {string}")
    public void doctor_opens_the_examination_result_for_patient(String patient) {
        NakesPage nakesPage = new NakesPage(DriverManager.get()).goTo();
        nakesPage.waitForPatient(patient);

        examinationPage = nakesPage.clickHasil(patient);
    }

    @Then("saved treatment is {string}")
    public void saved_treatment_is(String treatment) {
        assertEquals(treatment, examinationPage.selectedTreatment(), "Treatment tersimpan tidak sesuai");
    }

    @Then("saved diagnosa is {string}")
    public void saved_diagnosa_is(String diagnosa) {
        assertEquals(diagnosa, examinationPage.diagnosaValue(), "Diagnosa tersimpan tidak sesuai");
    }

    @Then("saved tindakan is {string}")
    public void saved_tindakan_is(String tindakan) {
        assertEquals(tindakan, examinationPage.tindakanValue(), "Tindakan tersimpan tidak sesuai");
    }

    @Then("saved catatan is {string}")
    public void saved_catatan_is(String catatan) {
        assertEquals(catatan, examinationPage.catatanValue(), "Catatan tersimpan tidak sesuai");
    }

    @Then("saved product {string} is checked")
    public void saved_product_is_checked(String product) {
        assertTrue(examinationPage.isProductChecked(product),
                "Produk " + product + " yang dipilih tidak tersimpan");
    }
}
