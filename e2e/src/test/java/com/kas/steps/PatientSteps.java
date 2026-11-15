package com.kas.steps;

import static org.junit.jupiter.api.Assertions.assertEquals;
import static org.junit.jupiter.api.Assertions.assertFalse;
import static org.junit.jupiter.api.Assertions.assertTrue;

import com.kas.hooks.DriverManager;
import com.kas.pages.PatientPage;
import com.kas.support.ScenarioContext;

import io.cucumber.java.en.Given;
import io.cucumber.java.en.Then;
import io.cucumber.java.en.When;

/**
 * Skenario CRUD halaman Pasien (/pasien).
 */
public class PatientSteps {

    private static final String BIRTH_DATE = "1990-01-15";
    private static final String PHONE = "081234567890";

    private PatientPage patientPage;
    private String createdPatient;

    private PatientPage page() {
        if (patientPage == null) {
            patientPage = new PatientPage(DriverManager.get());
        }
        return patientPage;
    }

    @When("admin opens the patient page")
    public void admin_opens_the_patient_page() {
        patientPage = page().goTo();
        ScenarioContext.setNotifiable(patientPage);

        assertTrue(patientPage.isOnPatientPage(), "Halaman Pasien tidak dapat dibuka");
    }

    @Then("patient list is shown")
    public void patient_list_is_shown() {
        assertTrue(page().patientCount() > 0 || page().hasEmptyState(),
                "Daftar pasien tidak tampil (tidak ada baris pasien maupun empty state)");
    }

    @When("admin adds a patient with valid data")
    public void admin_adds_a_patient_with_valid_data() {
        createdPatient = uniqueName("Pasien Baru");
        patientPage = page().goTo();

        patientPage.clickAdd()
                .fillPatient(createdPatient, PHONE)
                .selectGender("laki-laki")
                .setBirthDate(BIRTH_DATE)
                .submit();

        ScenarioContext.setNotifiable(patientPage);
    }

    @Then("the new patient appears in the list")
    public void the_new_patient_appears_in_the_list() {
        page().waitForPatient(createdPatient);
        assertTrue(page().patientNames().contains(createdPatient), "Pasien baru tidak ada di daftar");
    }

    @Given("a patient named {string} exists")
    public void a_patient_named_exists(String name) {
        createdPatient = name;
        patientPage = page().goTo();

        patientPage.clickAdd()
                .fillPatient(name, PHONE)
                .selectGender("laki-laki")
                .setBirthDate(BIRTH_DATE)
                .submit();

        patientPage.waitForPatient(name);
        assertEquals("Pasien berhasil ditambahkan.", patientPage.getSuccessMessage(),
                "Gagal menyiapkan data pasien");

        ScenarioContext.setNotifiable(patientPage);
    }

    @When("admin renames the patient {string} to {string}")
    public void admin_renames_the_patient(String oldName, String newName) {
        patientPage = page().goTo();
        patientPage.openPatient(oldName)
                .clickEdit()
                .fillPatientName(newName)
                .submit();

        ScenarioContext.setNotifiable(patientPage);
    }

    @Then("patient {string} appears in the list")
    public void patient_appears_in_the_list(String name) {
        page().waitForPatient(name);
        assertTrue(page().patientNames().contains(name), "Pasien " + name + " tidak ada di daftar");
    }

    @When("admin deletes the patient {string}")
    public void admin_deletes_the_patient(String name) {
        patientPage = page().goTo();
        patientPage.deletePatient(name);

        ScenarioContext.setNotifiable(patientPage);
    }

    @Then("patient {string} is no longer in the list")
    public void patient_is_no_longer_in_the_list(String name) {
        page().waitForPatientGone(name);
        assertFalse(page().patientNames().contains(name), "Pasien masih ada setelah dihapus");
    }

    private static String uniqueName(String prefix) {
        return prefix + " " + System.nanoTime();
    }
}
