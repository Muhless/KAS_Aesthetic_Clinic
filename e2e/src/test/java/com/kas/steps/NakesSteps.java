package com.kas.steps;

import static org.junit.jupiter.api.Assertions.assertEquals;
import static org.junit.jupiter.api.Assertions.assertFalse;
import static org.junit.jupiter.api.Assertions.assertTrue;

import com.kas.api.VisitApi;
import com.kas.config.Config;
import com.kas.hooks.DriverManager;
import com.kas.pages.NakesPage;

import io.cucumber.java.en.Given;
import io.cucumber.java.en.Then;
import io.cucumber.java.en.When;

/**
 * Skenario dashboard dokter (/nakes): sapaan, statistik, dan antrian pasien
 * hari ini.
 */
public class NakesSteps {

    private NakesPage nakesPage;

    private NakesPage page() {
        if (nakesPage == null) {
            nakesPage = new NakesPage(DriverManager.get());
        }
        return nakesPage;
    }

    @Given("today's visit for patient {string} with complaint {string} is waiting for the doctor")
    public void today_visit_for_patient_is_waiting(String patient, String complaint) {
        VisitApi.Visit visit = VisitApi.createForDokter(patient, Config.DOCTOR_USERNAME, complaint);

        assertTrue(visit.pelayananId() > 0, "API tidak mengembalikan id pelayanan");
    }

    @Given("today's visit for patient {string} is registered without a doctor")
    public void today_visit_for_patient_is_registered_without_a_doctor(String patient) {
        // Admin tidak punya record Dokter, jadi pelayanan ini tidak dimiliki
        // dokter mana pun dan tidak boleh muncul di halaman nakes.
        VisitApi.createForDokter(patient, Config.ADMIN_USERNAME, "Tanpa dokter");
    }

    @When("doctor opens the nakes page")
    public void doctor_opens_the_nakes_page() {
        nakesPage = page().goTo();

        assertTrue(nakesPage.isOnNakesPage(), "Halaman nakes tidak terbuka setelah login dokter");
    }

    @Then("nakes page shows greeting for {string}")
    public void nakes_page_shows_greeting_for(String doctorName) {
        assertTrue(page().greeting().contains(doctorName),
                "Sapaan halaman nakes tidak memuat nama dokter: " + page().greeting());
    }

    @Then("no patient is waiting today")
    public void no_patient_is_waiting_today() {
        assertTrue(page().hasEmptyState(), "Empty state pasien hari ini tidak tampil");
        assertEquals(0, page().totalMenunggu(), "Jumlah pasien menunggu harus 0");
        assertEquals(0, page().totalDipanggil(), "Jumlah pasien dipanggil harus 0");
        assertEquals(0, page().totalSelesai(), "Jumlah pasien selesai harus 0");
    }

    @Then("patient {string} appears in the patient table")
    public void patient_appears_in_the_patient_table(String name) {
        page().waitForPatient(name);
        assertTrue(page().patientNames().contains(name), "Pasien " + name + " tidak ada di tabel");
    }

    @Then("patient {string} does not appear in the patient table")
    public void patient_does_not_appear_in_the_patient_table(String name) {
        assertFalse(page().patientNames().contains(name),
                "Pasien " + name + " muncul di halaman nakes");
    }

    @Then("patient {string} has complaint {string}")
    public void patient_has_complaint(String name, String complaint) {
        assertEquals(complaint, page().patientKeluhan(name), "Keluhan pasien tidak sesuai");
    }

    @Then("patient {string} has status {string}")
    public void patient_has_status(String name, String status) {
        page().waitForPatientStatus(name, status);
        assertEquals(status, page().patientStatus(name), "Status pasien tidak sesuai");
    }

    @Then("waiting patient count is {int}")
    public void waiting_patient_count_is(int count) {
        assertEquals(count, page().totalMenunggu(), "Statistik pasien menunggu tidak sesuai");
    }

    @Then("called patient count is {int}")
    public void called_patient_count_is(int count) {
        assertEquals(count, page().totalDipanggil(), "Statistik pasien dipanggil tidak sesuai");
    }

    @When("doctor calls patient {string}")
    public void doctor_calls_patient(String name) {
        page().waitForPatient(name);
        page().callPatient(name);
    }

    @Then("patient {string} has no {string} action")
    public void patient_has_no_action(String name, String action) {
        assertFalse(hasAction(name, action),
                "Aksi " + action + " muncul terlalu awal untuk pasien " + name);
    }

    @Then("patient {string} has a {string} action")
    public void patient_has_action(String name, String action) {
        page().waitForPatient(name);
        assertTrue(hasAction(name, action),
                "Aksi " + action + " tidak muncul untuk pasien " + name);
    }

    private boolean hasAction(String name, String action) {
        return switch (action.toLowerCase()) {
            case "periksa" -> page().hasPeriksaLink(name);
            case "hasil" -> page().hasHasilLink(name);
            default -> throw new IllegalArgumentException("Aksi tidak dikenal: " + action);
        };
    }
}
