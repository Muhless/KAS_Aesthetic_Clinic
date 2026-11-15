package com.kas.steps;

import static org.junit.jupiter.api.Assertions.assertEquals;
import static org.junit.jupiter.api.Assertions.assertFalse;
import static org.junit.jupiter.api.Assertions.assertTrue;

import com.kas.hooks.DriverManager;
import com.kas.pages.DoctorPage;
import com.kas.support.ScenarioContext;

import io.cucumber.java.en.Given;
import io.cucumber.java.en.Then;
import io.cucumber.java.en.When;

/**
 * Skenario CRUD halaman Dokter (/dokter).
 */
public class DoctorSteps {

    private static final String SPECIALIZATION = "Kecantikan";
    private static final String PHONE = "01910910190";
    private static final String BIRTH_DATE = "1990-01-05";
    private static final String COST = "150000";
    private static final String PASSWORD = "dokter123";

    private DoctorPage doctorPage;
    private String createdDoctor;

    private DoctorPage page() {
        if (doctorPage == null) {
            doctorPage = new DoctorPage(DriverManager.get());
        }
        return doctorPage;
    }

    @When("admin opens the doctor page")
    public void admin_opens_the_doctor_page() {
        doctorPage = page().goTo();
        ScenarioContext.setNotifiable(doctorPage);

        assertTrue(doctorPage.isOnDoctorPage(), "Halaman Dokter tidak dapat dibuka");
    }

    @Then("doctor list is shown")
    public void doctor_list_is_shown() {
        assertTrue(page().doctorCount() > 0 || page().hasEmptyState(),
                "Daftar dokter tidak tampil (tidak ada kartu maupun empty state)");
    }

    @When("admin adds a doctor with valid data")
    public void admin_adds_a_doctor_with_valid_data() {
        createdDoctor = uniqueName("dr. Dokter Baru");
        doctorPage = page().goTo();

        doctorPage.clickAdd()
                .fillDoctor(createdDoctor, SPECIALIZATION, PHONE, uniqueEmail(), COST,
                        uniqueUsername(), PASSWORD)
                .selectBirthDate(BIRTH_DATE)
                .submit();

        ScenarioContext.setNotifiable(doctorPage);
    }

    @Then("the new doctor appears in the list")
    public void the_new_doctor_appears_in_the_list() {
        page().waitForDoctor(createdDoctor);
        assertTrue(page().doctorNames().contains(createdDoctor), "Dokter baru tidak ada di daftar");
    }

    @Given("a doctor named {string} exists")
    public void a_doctor_named_exists(String name) {
        createdDoctor = name;
        doctorPage = page().goTo();

        doctorPage.clickAdd()
                .fillDoctor(name, SPECIALIZATION, PHONE, uniqueEmail(), COST,
                        uniqueUsername(), PASSWORD)
                .selectBirthDate(BIRTH_DATE)
                .submit();

        doctorPage.waitForDoctor(name);
        assertEquals("Dokter berhasil ditambahkan.", doctorPage.getSuccessMessage(),
                "Gagal menyiapkan data dokter");

        ScenarioContext.setNotifiable(doctorPage);
    }

    @When("admin renames the doctor {string} to {string}")
    public void admin_renames_the_doctor(String oldName, String newName) {
        doctorPage = page().goTo();
        doctorPage.clickEdit(oldName)
                .fillDoctorName(newName)
                .submit();

        ScenarioContext.setNotifiable(doctorPage);
    }

    @Then("doctor {string} appears in the list")
    public void doctor_appears_in_the_list(String name) {
        page().waitForDoctor(name);
        assertTrue(page().doctorNames().contains(name), "Dokter " + name + " tidak ada di daftar");
    }

    @When("admin deletes the doctor {string}")
    public void admin_deletes_the_doctor(String name) {
        doctorPage = page().goTo();
        doctorPage.deleteDoctor(name);

        ScenarioContext.setNotifiable(doctorPage);
    }

    @Then("doctor {string} is no longer in the list")
    public void doctor_is_no_longer_in_the_list(String name) {
        page().waitForDoctorGone(name);
        assertFalse(page().doctorNames().contains(name), "Dokter masih ada setelah dihapus");
    }

    private static String uniqueName(String prefix) {
        return prefix + " " + System.nanoTime();
    }

    private static String uniqueEmail() {
        return "dokter" + System.nanoTime() + "@kas.test";
    }

    private static String uniqueUsername() {
        return "dokter" + System.nanoTime();
    }
}
