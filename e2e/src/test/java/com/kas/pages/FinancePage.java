package com.kas.pages;

import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.UnhandledAlertException;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.ExpectedConditions;

import com.kas.components.Notification;
import com.kas.components.RecordList;

/**
 * Halaman keuangan admin: daftar pembayaran, riwayat transaksi, ringkasan
 * bulanan (/keuangan) dan detail pembayaran (/keuangan/{id}).
 */
public class FinancePage extends BasePage implements Notifiable {

    // --- Index ---
    private final By pageTitle = By.cssSelector("[data-testid='keuangan-title']");
    private final By incomeToday = By.cssSelector("[data-testid='keuangan-pemasukan-hari-ini']");
    private final By incomeThisMonth = By.cssSelector("[data-testid='keuangan-pemasukan-bulan-ini']");
    private final By transactionTotal = By.cssSelector("[data-testid='keuangan-total-transaksi']");
    private final By unpaidTotal = By.cssSelector("[data-testid='keuangan-belum-bayar']");

    // --- Tabel pembayaran ---
    private final RecordList payments = new RecordList(driver, wait, "keuangan-pasien", "keuangan-row");
    private final By paymentStatus = By.cssSelector("[data-testid='keuangan-status']");
    private final By paymentTotal = By.cssSelector("[data-testid='keuangan-total']");
    private final By paymentDetail = By.cssSelector("[data-testid='keuangan-detail']");
    private final By paymentEmptyState = By.cssSelector("[data-testid='keuangan-empty-state']");

    // --- Riwayat transaksi + filter ---
    private final RecordList history = new RecordList(driver, wait, "keuangan-riwayat-pasien", "keuangan-riwayat-row");
    private final By historyMethod = By.cssSelector("[data-testid='keuangan-riwayat-metode']");
    private final By historyTotal = By.cssSelector("[data-testid='keuangan-riwayat-total']");
    private final By historyEmptyState = By.cssSelector("[data-testid='keuangan-riwayat-empty']");
    private final By periodeFilter = By.cssSelector("[data-testid='keuangan-periode']");
    private final By tanggalFilter = By.cssSelector("[data-testid='keuangan-tanggal']");
    private final By bulanFilter = By.cssSelector("[data-testid='keuangan-bulan']");
    private final By tahunFilter = By.cssSelector("[data-testid='keuangan-tahun']");
    private final By cetakPdf = By.cssSelector("[data-testid='keuangan-cetak-pdf']");

    // --- Ringkasan ---
    private final By summaryTotal = By.cssSelector("[data-testid='keuangan-ringkasan-total']");
    private final By summaryCount = By.cssSelector("[data-testid='keuangan-ringkasan-jumlah']");
    private final By summaryAverage = By.cssSelector("[data-testid='keuangan-ringkasan-rata']");

    // --- Detail pembayaran ---
    private final By detailTitle = By.cssSelector("[data-testid='keuangan-detail-title']");
    private final By detailStatus = By.cssSelector("[data-testid='keuangan-detail-status']");
    private final By detailTotal = By.cssSelector("[data-testid='keuangan-detail-total']");
    private final By detailPatient = By.cssSelector("[data-testid='keuangan-detail-pasien']");
    private final By detailCatatan = By.cssSelector("[data-testid='keuangan-detail-catatan']");
    private final By detailCatatanNilai = By.cssSelector("[data-testid='keuangan-detail-catatan-nilai']");
    private final By detailMetode = By.cssSelector("[data-testid='keuangan-detail-metode']");
    private final By tandaiLunas = By.cssSelector("[data-testid='keuangan-tandai-lunas']");
    private final By cetakStruk = By.cssSelector("[data-testid='keuangan-cetak-struk']");

    private final Notification notification = new Notification(driver, wait);

    public FinancePage(WebDriver driver) {
        super(driver);
    }

    public FinancePage goTo() {
        open("/keuangan");
        return this;
    }

    public boolean isOnPage() {
        return isVisible(pageTitle);
    }

    // --- Statistik ---

    public String incomeTodayText() {
        return getText(incomeToday);
    }

    public long incomeToday() {
        return parseRupiah(incomeTodayText());
    }

    public String incomeThisMonthText() {
        return getText(incomeThisMonth);
    }

    public long incomeThisMonth() {
        return parseRupiah(incomeThisMonthText());
    }

    public int transactionCount() {
        return (int) parseRupiah(getText(transactionTotal));
    }

    public int unpaidCount() {
        return (int) parseRupiah(getText(unpaidTotal));
    }

    // --- Tabel pembayaran ---

    public int paymentCount() {
        return payments.count();
    }

    public List<String> paymentNames() {
        return payments.names();
    }

    public boolean hasPayment(String nama) {
        return payments.has(nama);
    }

    public FinancePage waitForPayment(String nama) {
        payments.waitFor(nama);
        return this;
    }

    /** ID pembayaran dari atribut data-id pada baris pasien. */
    public String paymentId(String nama) {
        return payments.item(nama).getAttribute("data-id");
    }

    public String paymentStatus(String nama) {
        return payments.item(nama).findElement(paymentStatus).getText().trim();
    }

    public String paymentTotalText(String nama) {
        return payments.item(nama).findElement(paymentTotal).getText().trim();
    }

    public long paymentTotal(String nama) {
        return parseRupiah(paymentTotalText(nama));
    }

    public boolean hasEmptyState() {
        return isElementPresent(paymentEmptyState);
    }

    public FinancePage clickDetail(String nama) {
        click(payments.item(nama).findElement(paymentDetail));
        wait.until(ExpectedConditions.visibilityOfElementLocated(detailTitle));
        return this;
    }

    // --- Riwayat transaksi ---

    public int historyCount() {
        return history.count();
    }

    public List<String> historyNames() {
        return history.names();
    }

    public boolean hasHistory(String nama) {
        return history.has(nama);
    }

    public FinancePage waitForHistory(String nama) {
        history.waitFor(nama);
        return this;
    }

    public String historyMethod(String nama) {
        return history.item(nama).findElement(historyMethod).getText().trim();
    }

    public String historyTotalText(String nama) {
        return history.item(nama).findElement(historyTotal).getText().trim();
    }

    public long historyTotal(String nama) {
        return parseRupiah(historyTotalText(nama));
    }

    public boolean hasHistoryEmptyState() {
        return isElementPresent(historyEmptyState);
    }

    /**
     * Memilih periode laporan. Perubahan langsung men-submit form filter,
     * jadi method ini menunggu sampai URL memuat parameter baru.
     */
    public FinancePage filterByPeriode(String periode) {
        changeFilter(periodeFilter, periode);
        waitForUrlContains("periode=" + periode);
        return this;
    }

    public FinancePage filterByTanggal(String isoDate) {
        changeFilter(tanggalFilter, isoDate);
        waitForUrlContains("tanggal=" + isoDate);
        return this;
    }

    public FinancePage filterByBulan(String bulan) {
        changeFilter(bulanFilter, bulan);
        waitForUrlContains("bulan=" + bulan);
        return this;
    }

    public FinancePage filterByTahun(String tahun) {
        changeFilter(tahunFilter, tahun);
        waitForUrlContains("tahun=" + tahun);
        return this;
    }

    public boolean hasCetakPdf() {
        return isElementPresent(cetakPdf);
    }

    // --- Ringkasan ---

    public String summaryTotalText() {
        return getText(summaryTotal);
    }

    public long summaryTotal() {
        return parseRupiah(summaryTotalText());
    }

    public int summaryCount() {
        return (int) parseRupiah(getText(summaryCount));
    }

    public String summaryAverageText() {
        return getText(summaryAverage);
    }

    public long summaryAverage() {
        return parseRupiah(summaryAverageText());
    }

    // --- Detail pembayaran ---

    public boolean isOnDetailPage() {
        return isVisible(detailTitle);
    }

    public String detailPatient() {
        return getText(detailPatient).trim();
    }

    public String detailStatus() {
        return getText(detailStatus).trim();
    }

    public String detailTotalText() {
        return getText(detailTotal);
    }

    public long detailTotal() {
        return parseRupiah(detailTotalText());
    }

    public String detailMetode() {
        return getText(detailMetode).trim();
    }

    public String detailCatatan() {
        return getText(detailCatatanNilai).trim();
    }

    public boolean hasCetakStruk() {
        return isElementPresent(cetakStruk);
    }

    public FinancePage fillCatatan(String catatan) {
        type(detailCatatan, catatan);
        return this;
    }
    public FinancePage markAsLunas() {
        try {
            click(tandaiLunas);
        } catch (UnhandledAlertException e) {
        }

        wait.until(ExpectedConditions.alertIsPresent());
        driver.switchTo().alert().accept();

        notification.waitForResult();
        return this;
    }

    // --- Notifikasi ---

    public boolean hasSuccessMessage() {
        return notification.hasSuccess();
    }

    public String successMessage() {
        return notification.successMessage();
    }

    @Override
    public String getSuccessMessage() {
        return successMessage();
    }

    @Override
    public boolean hasErrorMessage() {
        return notification.hasError();
    }

    @Override
    public List<String> getErrorMessages() {
        return notification.errorMessages();
    }

    /**
     * Mengubah nilai filter lewat DOM lalu memicu event change, karena select
     * filter langsung men-submit form sehingga klik native rawan gagal.
     */
    private void changeFilter(By locator, String value) {
        WebElement element = wait.until(ExpectedConditions.presenceOfElementLocated(locator));
        executeScript(
                "arguments[0].value = arguments[1];"
                        + "arguments[0].dispatchEvent(new Event('input', {bubbles: true}));"
                        + "arguments[0].dispatchEvent(new Event('change', {bubbles: true}));",
                element, value);
    }

    private static long parseRupiah(String text) {
        String digits = text.replaceAll("[^0-9]", "");
        return digits.isEmpty() ? 0L : Long.parseLong(digits);
    }
}
