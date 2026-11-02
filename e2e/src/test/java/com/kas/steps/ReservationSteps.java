package com.kas.steps;

import static org.junit.jupiter.api.Assertions.assertTrue;

import java.time.LocalDate;

import com.kas.hooks.DriverManager;
import com.kas.pages.ReservationPage;

import io.cucumber.java.en.Given;
import io.cucumber.java.en.Then;
import io.cucumber.java.en.When;

public class ReservationSteps {

    private String patientName;
    private String doctorName;

    private ReservationPage reservationPage() {
        return new ReservationPage(DriverManager.get());
    }

    @Given("User already in reservation pages")
    public void user_already_in_reservation_pages() {
        ReservationPage page = reservationPage().goTo();
        assertTrue(page.isOnReservationPage(), "Halaman reservasi tidak tampil");
    }

    @When("User create reservation for patient {string} with doctor {string} tomorrow")
    public void user_create_reservation(String patient, String doctor) {
        this.patientName = patient;
        this.doctorName = doctor;

        ReservationPage page = reservationPage();
        page.clickAdd();
        page.selectPatient(patient);
        page.selectDoctor(doctor);
        page.pickDate(LocalDate.now().plusDays(1));
        page.submitReservation();
    }

    @Then("successfully create reservation message appear")
    public void successfully_create_reservation_message_appear() {
        assertTrue(
                reservationPage().hasSuccessMessage(),
                "Pesan sukses pembuatan reservasi tidak muncul");
    }

    @Then("reservation appear in the table")
    public void reservation_appear_in_the_table() {
        assertTrue(
                reservationPage().hasReservationRow(patientName, doctorName),
                "Reservasi untuk " + patientName + " dengan dokter " + doctorName + " tidak ada di tabel");
    }
}
