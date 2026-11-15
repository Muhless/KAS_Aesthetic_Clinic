package com.kas.steps;

import static org.junit.jupiter.api.Assertions.assertEquals;
import static org.junit.jupiter.api.Assertions.assertFalse;
import static org.junit.jupiter.api.Assertions.assertTrue;

import com.kas.pages.Notifiable;
import com.kas.support.ScenarioContext;

import io.cucumber.java.en.Then;

/**
 * Langkah generik yang dipakai lintas fitur CRUD (dokter, perawat, pasien,
 * produk, treatment, keuangan).
 */
public class CommonSteps {

    @Then("success message {string} appear")
    public void success_message_appear(String message) {
        Notifiable page = ScenarioContext.notifiable();

        assertTrue(page.hasSuccessMessage(), "Pesan sukses \"" + message + "\" tidak muncul");
        assertEquals(message, page.getSuccessMessage(), "Pesan sukses tidak sesuai");
    }

    @Then("validation error message appear")
    public void validation_error_message_appear() {
        Notifiable page = ScenarioContext.notifiable();

        assertTrue(page.hasErrorMessage(), "Pesan error validasi tidak muncul");
        assertFalse(page.getErrorMessages().isEmpty(), "Detail error validasi kosong");
    }
}
