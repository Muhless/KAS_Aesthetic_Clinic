package com.kas.pages;

import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.ExpectedConditions;

import com.kas.components.Notification;
import com.kas.components.RecordList;

/**
 * Dashboard dokter di /nakes: sapaan, statistik harian, dan tabel
 * "Pasien Hari Ini" milik dokter yang login.
 */
public class NakesPage extends BasePage {

    private final By greeting = By.cssSelector("[data-testid='nakes-greeting']");
    private final RecordList visits = new RecordList(driver, wait, "nakes-patient-name", "nakes-visit-row");
    private final By emptyState = By.cssSelector("[data-testid='nakes-empty-state']");

    private final By totalMenunggu = By.cssSelector("[data-testid='nakes-total-menunggu']");
    private final By totalDipanggil = By.cssSelector("[data-testid='nakes-total-dipanggil']");
    private final By totalSelesai = By.cssSelector("[data-testid='nakes-total-selesai']");

    private final By patientName = By.cssSelector("[data-testid='nakes-patient-name']");
    private final By patientKeluhan = By.cssSelector("[data-testid='nakes-keluhan']");
    private final By visitStatus = By.cssSelector("[data-testid='nakes-status']");
    private final By callButton = By.cssSelector("[data-testid='nakes-panggil']");
    private final By periksaLink = By.cssSelector("[data-testid='nakes-periksa']");
    private final By hasilLink = By.cssSelector("[data-testid='nakes-hasil']");

    private final Notification notification = new Notification(driver, wait);

    public NakesPage(WebDriver driver) {
        super(driver);
    }

    public NakesPage goTo() {
        open("/nakes");
        return this;
    }

    public boolean isOnNakesPage() {
        return isVisible(greeting);
    }

    public String greeting() {
        return getText(greeting);
    }

    // --- Tabel pasien hari ini ---
    public int visitCount() {
        return visits.count();
    }

    public List<String> patientNames() {
        return visits.names();
    }

    public boolean hasPatient(String nama) {
        return visits.has(nama);
    }

    public NakesPage waitForPatient(String nama) {
        visits.waitFor(nama);
        return this;
    }

    public boolean hasEmptyState() {
        return isElementPresent(emptyState);
    }

    public String patientName(String nama) {
        return visits.item(nama).findElement(patientName).getText().trim();
    }

    public String patientKeluhan(String nama) {
        return visits.item(nama).findElement(patientKeluhan).getText().trim();
    }

    public String patientStatus(String nama) {
        return visits.item(nama).findElement(visitStatus).getText().trim();
    }

    public NakesPage waitForPatientStatus(String nama, String status) {
        wait.until(driver -> {
            try {
                return status.equals(patientStatus(nama));
            } catch (RuntimeException e) {
                return false;
            }
        });
        return this;
    }

    /** Menekan tombol "Panggil" pada baris pasien. */
    public NakesPage callPatient(String nama) {
        click(visits.item(nama).findElement(callButton));
        waitForPatientStatus(nama, "Dipanggil");
        return this;
    }

    /** True kalau baris pasien punya tombol/link "Periksa" (status dipanggil). */
    public boolean hasPeriksaLink(String nama) {
        return !visits.item(nama).findElements(periksaLink).isEmpty();
    }

    /** True kalau baris pasien punya link "Hasil" (status selesai). */
    public boolean hasHasilLink(String nama) {
        return !visits.item(nama).findElements(hasilLink).isEmpty();
    }

    /**
     * Membuka form pemeriksaan dari baris pasien.
     *
     * Navigasi dilakukan sekali lewat href. Klik berulang (click/Actions/JS)
     * bisa memicu beberapa request sekaligus sehingga halaman ter-reload lagi
     * saat test sedang mengisi form, dan semua isian jadi hilang.
     */
    public ExaminationPage clickPeriksa(String nama) {
        WebElement link = visits.item(nama).findElement(periksaLink);
        String href = link.getAttribute("href");

        if (href == null || href.isBlank()) {
            throw new IllegalStateException("Link Periksa tidak punya href untuk pasien " + nama);
        }

        driver.get(href);
        wait.until(ExpectedConditions.urlContains("/pemeriksaan/"));

        ExaminationPage page = new ExaminationPage(driver);
        page.waitUntilReady();
        return page;
    }

    /** Membuka kembali hasil pemeriksaan dari baris pasien. */
    public ExaminationPage clickHasil(String nama) {
        click(visits.item(nama).findElement(hasilLink));

        ExaminationPage page = new ExaminationPage(driver);
        page.waitUntilReady();
        return page;
    }

    public boolean hasSuccessMessage() {
        notification.waitForResult();
        return notification.hasSuccess();
    }

    public String successMessage() {
        return notification.successMessage();
    }

    // --- Statistik ---
    public int totalMenunggu() {
        return number(totalMenunggu);
    }

    public int totalDipanggil() {
        return number(totalDipanggil);
    }

    public int totalSelesai() {
        return number(totalSelesai);
    }

    private int number(By locator) {
        return Integer.parseInt(getText(locator).trim());
    }
}
