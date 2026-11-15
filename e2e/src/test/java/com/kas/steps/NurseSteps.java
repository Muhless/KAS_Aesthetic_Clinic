package com.kas.steps;

import static org.junit.jupiter.api.Assertions.assertEquals;
import static org.junit.jupiter.api.Assertions.assertFalse;
import static org.junit.jupiter.api.Assertions.assertTrue;

import java.net.URISyntaxException;
import java.nio.file.Path;
import java.nio.file.Paths;

import com.kas.hooks.DriverManager;
import com.kas.pages.NursePage;
import com.kas.support.ScenarioContext;

import io.cucumber.java.en.Given;
import io.cucumber.java.en.Then;
import io.cucumber.java.en.When;

/**
 * Skenario CRUD halaman Perawat (/perawat), termasuk upload foto.
 */
public class NurseSteps {

    private static final String PHONE = "08871165552";
    private static final String BIRTH_DATE = "2001-02-08";
    private static final String PASSWORD = "nurse12345";

    private NursePage nursePage;
    private String createdNurse;

    private NursePage page() {
        if (nursePage == null) {
            nursePage = new NursePage(DriverManager.get());
        }
        return nursePage;
    }

    @When("admin opens the nurse page")
    public void admin_opens_the_nurse_page() {
        nursePage = page().goTo();
        ScenarioContext.setNotifiable(nursePage);

        assertTrue(nursePage.isOnNursePage(), "Halaman perawat tidak dapat dibuka");
    }

    @Then("nurse list is shown")
    public void nurse_list_is_shown() {
        assertTrue(page().nurseCount() > 0 || page().hasEmptyState(),
                "Daftar perawat tidak tampil (tidak ada kartu maupun empty state)");
    }

    @When("admin adds a nurse with valid data")
    public void admin_adds_a_nurse_with_valid_data() {
        createdNurse = uniqueName("Nurse baru");
        nursePage = page().goTo();

        nursePage.clickAdd()
                .fillNurse(createdNurse, PHONE, uniqueEmail(), uniqueUsername(), PASSWORD)
                .selectBirthDate(BIRTH_DATE)
                .submit();

        ScenarioContext.setNotifiable(nursePage);
    }

    @When("admin adds a nurse with a photo")
    public void admin_adds_a_nurse_with_a_photo() {
        createdNurse = uniqueName("Nurse foto");
        nursePage = page().goTo();

        nursePage.clickAdd()
                .fillNurse(createdNurse, PHONE, uniqueEmail(), uniqueUsername(), PASSWORD)
                .selectBirthDate(BIRTH_DATE)
                .uploadPhoto(fixture("nurse.png").toString())
                .submit();

        ScenarioContext.setNotifiable(nursePage);
    }

    @Then("the new nurse appears in the list")
    public void the_new_nurse_appears_in_the_list() {
        page().waitForNurse(createdNurse);
        assertTrue(page().nurseNames().contains(createdNurse), "Perawat baru tidak ada di daftar");
    }

    @Then("the new nurse photo is shown")
    public void the_new_nurse_photo_is_shown() {
        assertTrue(page().nursePhotoSrc(createdNurse).contains("/storage/perawat/foto/"),
                "Foto hasil upload tidak dipakai pada kartu perawat");
    }

    @Given("a nurse named {string} exists")
    public void a_nurse_named_exists(String name) {
        createdNurse = name;
        nursePage = page().goTo();

        nursePage.clickAdd()
                .fillNurse(name, PHONE, uniqueEmail(), uniqueUsername(), PASSWORD)
                .selectBirthDate(BIRTH_DATE)
                .submit();

        nursePage.waitForNurse(name);
        assertEquals("Perawat berhasil ditambahkan.", nursePage.getSuccessMessage(),
                "Gagal menyiapkan data perawat");

        ScenarioContext.setNotifiable(nursePage);
    }

    @When("admin renames the nurse {string} to {string}")
    public void admin_renames_the_nurse(String oldName, String newName) {
        nursePage = page().goTo();
        nursePage.clickEdit(oldName)
                .fillNurseName(newName)
                .submit();

        ScenarioContext.setNotifiable(nursePage);
    }

    @Then("nurse {string} appears in the list")
    public void nurse_appears_in_the_list(String name) {
        page().waitForNurse(name);
        assertTrue(page().nurseNames().contains(name), "Perawat " + name + " tidak ada di daftar");
    }

    @When("admin deletes the nurse {string}")
    public void admin_deletes_the_nurse(String name) {
        nursePage = page().goTo();
        nursePage.deleteNurse(name);

        ScenarioContext.setNotifiable(nursePage);
    }

    @Then("nurse {string} is no longer in the list")
    public void nurse_is_no_longer_in_the_list(String name) {
        page().waitForNurseGone(name);
        assertFalse(page().nurseNames().contains(name), "Perawat masih ada setelah dihapus");
    }

    private static String uniqueName(String prefix) {
        return prefix + " " + System.nanoTime();
    }

    private static String uniqueEmail() {
        return "nurse" + System.nanoTime() + "@test.com";
    }

    private static String uniqueUsername() {
        return "nurse" + System.nanoTime();
    }

    private static Path fixture(String fileName) {
        try {
            return Paths.get(NurseSteps.class.getClassLoader()
                    .getResource("fixtures/" + fileName)
                    .toURI());
        } catch (URISyntaxException | NullPointerException e) {
            throw new IllegalStateException("Fixture tidak ditemukan: " + fileName, e);
        }
    }
}
