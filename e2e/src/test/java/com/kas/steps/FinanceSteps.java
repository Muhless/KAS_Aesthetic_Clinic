package com.kas.steps;

import static org.junit.jupiter.api.Assertions.assertEquals;
import static org.junit.jupiter.api.Assertions.assertFalse;
import static org.junit.jupiter.api.Assertions.assertTrue;

import java.util.List;

import com.kas.api.CatalogApi;
import com.kas.api.VisitApi;
import com.kas.config.Config;
import com.kas.hooks.DriverManager;
import com.kas.pages.FinancePage;
import com.kas.support.ScenarioContext;

import io.cucumber.java.en.Given;
import io.cucumber.java.en.Then;
import io.cucumber.java.en.When;

/**
 * Skenario halaman keuangan admin (/keuangan): daftar pembayaran, detail,
 * tandai lunas, statistik, ringkasan, dan riwayat transaksi.
 */
public class FinanceSteps {

    private static final String TREATMENT = "Treatment E2E";
    private static final String PRODUK = "Produk E2E";

    private FinancePage financePage;
    private String lastPaymentId;
    private long lastPaymentTotal;

    private FinancePage page() {
        if (financePage == null) {
            financePage = new FinancePage(DriverManager.get());
        }
        return financePage;
    }

    @Given("an unpaid payment for patient {string} exists")
    public void an_unpaid_payment_for_patient_exists(String patient) {
        VisitApi.createExamined(
                patient,
                Config.DOCTOR_USERNAME,
                "Kontrol rutin",
                CatalogApi.treatmentId(TREATMENT),
                List.of(CatalogApi.productId(PRODUK)));
    }

    @When("admin opens the finance page")
    public void admin_opens_the_finance_page() {
        financePage = page().goTo();
        ScenarioContext.setNotifiable(financePage);

        assertTrue(financePage.isOnPage(), "Halaman Keuangan tidak tampil");
    }

    @Then("finance income today is {long}")
    public void finance_income_today_is(long amount) {
        assertEquals(amount, page().incomeToday(), "Pemasukan hari ini tidak sesuai");
    }

    @Then("finance income this month is {long}")
    public void finance_income_this_month_is(long amount) {
        assertEquals(amount, page().incomeThisMonth(), "Pemasukan bulan ini tidak sesuai");
    }

    @Then("finance transaction count is {int}")
    public void finance_transaction_count_is(int count) {
        assertEquals(count, page().transactionCount(), "Jumlah transaksi tidak sesuai");
    }

    @Then("finance unpaid count is {int}")
    public void finance_unpaid_count_is(int count) {
        assertEquals(count, page().unpaidCount(), "Jumlah pembayaran belum bayar tidak sesuai");
    }

    @Then("payment table is empty")
    public void payment_table_is_empty() {
        assertEquals(0, page().paymentCount(), "Tabel pembayaran harus kosong");
        assertTrue(page().hasEmptyState(), "Empty state tabel pembayaran tidak tampil");
    }

    @Then("payment table shows {int} payments")
    public void payment_table_shows_payments(int count) {
        assertEquals(count, page().paymentCount(), "Jumlah baris pembayaran tidak sesuai");
    }

    @Then("transaction history is empty")
    public void transaction_history_is_empty() {
        assertEquals(0, page().historyCount(), "Riwayat transaksi harus kosong");
        assertTrue(page().hasHistoryEmptyState(), "Empty state riwayat tidak tampil");
    }

    @Then("payment summary total is {long}")
    public void payment_summary_total_is(long amount) {
        assertEquals(amount, page().summaryTotal(), "Total ringkasan tidak sesuai");
    }

    @Then("payment summary total equals the payment total")
    public void payment_summary_total_equals_the_payment_total() {
        assertEquals(lastPaymentTotal, page().summaryTotal(), "Total ringkasan tidak sesuai");
    }

    @Then("payment summary count is {int}")
    public void payment_summary_count_is(int count) {
        assertEquals(count, page().summaryCount(), "Jumlah ringkasan tidak sesuai");
    }

    @Then("the print PDF button is shown")
    public void the_print_pdf_button_is_shown() {
        assertTrue(page().hasCetakPdf(), "Tombol Cetak PDF tidak tampil");
    }

    @Then("payment for {string} appears with status {string}")
    public void payment_for_appears_with_status(String patient, String status) {
        page().waitForPayment(patient);

        assertTrue(page().hasPayment(patient), "Baris pembayaran tidak muncul");
        assertTrue(Long.parseLong(page().paymentId(patient)) > 0, "ID pembayaran tidak valid");
        assertEquals(status, page().paymentStatus(patient), "Status pembayaran tidak sesuai");
    }

    @Then("payment total for {string} is greater than {int}")
    public void payment_total_for_is_greater_than(String patient, int minimum) {
        assertTrue(page().paymentTotal(patient) > minimum, "Total pembayaran tidak sesuai");
    }

    @When("admin opens the payment detail for {string}")
    public void admin_opens_the_payment_detail_for(String patient) {
        financePage = page().goTo();
        financePage.waitForPayment(patient);

        lastPaymentId = financePage.paymentId(patient);
        lastPaymentTotal = financePage.paymentTotal(patient);

        financePage.clickDetail(patient);
    }

    @Then("payment detail is shown for {string}")
    public void payment_detail_is_shown_for(String patient) {
        assertTrue(page().isOnDetailPage(), "Halaman detail pembayaran tidak terbuka");
        assertTrue(DriverManager.get().getCurrentUrl().matches(".*/keuangan/" + lastPaymentId + "$"),
                "URL detail tidak sesuai: " + DriverManager.get().getCurrentUrl());
        assertEquals(patient, page().detailPatient(), "Pasien di detail tidak sesuai");
    }

    @Then("payment detail total equals the payment total")
    public void payment_detail_total_equals_the_payment_total() {
        assertEquals(lastPaymentTotal, page().detailTotal(),
                "Total di detail harus sama dengan tabel");
    }

    @Then("payment detail status is {string}")
    public void payment_detail_status_is(String status) {
        assertEquals(status, page().detailStatus(), "Status pembayaran di detail tidak sesuai");
    }

    @Then("the receipt button is not shown")
    public void the_receipt_button_is_not_shown() {
        assertFalse(page().hasCetakStruk(), "Cetak struk hanya muncul untuk pembayaran lunas");
    }

    @When("admin fills the payment note {string} and marks it as paid")
    public void admin_fills_the_payment_note_and_marks_it_as_paid(String note) {
        financePage.fillCatatan(note);
        financePage.markAsLunas();

        ScenarioContext.setNotifiable(financePage);
    }

    @When("admin marks the payment for {string} as paid")
    public void admin_marks_the_payment_for_as_paid(String patient) {
        financePage = page().goTo();
        financePage.waitForPayment(patient);

        lastPaymentId = financePage.paymentId(patient);
        lastPaymentTotal = financePage.paymentTotal(patient);

        financePage.clickDetail(patient);
        financePage.markAsLunas();

        financePage.goTo();
    }

    @Then("payment detail method is {string}")
    public void payment_detail_method_is(String method) {
        assertEquals(method, page().detailMetode(), "Metode pembayaran tidak sesuai");
    }

    @Then("the receipt button is shown")
    public void the_receipt_button_is_shown() {
        assertTrue(page().hasCetakStruk(), "Tombol Cetak Struk tidak muncul setelah lunas");
    }

    @Then("payment note is {string}")
    public void payment_note_is(String note) {
        assertEquals(note, page().detailCatatan(), "Catatan pembayaran tidak tersimpan");
    }

    @Then("finance income today equals the payment total")
    public void finance_income_today_equals_the_payment_total() {
        assertEquals(lastPaymentTotal, page().incomeToday(),
                "Pemasukan hari ini harus bertambah");
    }

    @Then("finance income this month equals the payment total")
    public void finance_income_this_month_equals_the_payment_total() {
        assertEquals(lastPaymentTotal, page().incomeThisMonth(),
                "Pemasukan bulan ini harus bertambah");
    }

    @Then("finance income this month equals the total of {string}")
    public void finance_income_this_month_equals_the_total_of(String patient) {
        assertEquals(page().incomeThisMonth(), page().paymentTotal(patient),
                "Pemasukan bulan ini harus sama dengan total pembayaran");
    }

    @Then("payment summary average equals the payment total")
    public void payment_summary_average_equals_the_payment_total() {
        assertEquals(lastPaymentTotal, page().summaryAverage(), "Rata-rata ringkasan tidak sesuai");
    }

    @Then("transaction history shows {string} with method {string} and the payment total")
    public void transaction_history_shows(String patient, String method) {
        page().goTo();
        page().waitForHistory(patient);

        assertEquals(method, page().historyMethod(patient), "Metode bayar di riwayat tidak sesuai");
        assertEquals(lastPaymentTotal, page().historyTotal(patient),
                "Total riwayat harus sama dengan pembayaran");
    }
}
