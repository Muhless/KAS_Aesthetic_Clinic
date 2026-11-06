package com.kas.components;

import java.util.List;
import java.util.stream.Collectors;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

/**
 * Daftar record yang dirender sebagai kartu atau baris tabel.
 *
 * Setiap record diasumsikan punya elemen nama dengan data-testid tertentu
 * (mis. treatment-name) dan elemen pembungkus dengan data-testid lain
 * (mis. treatment-card atau patient-row). Dengan begitu pencarian berdasarkan
 * nama bisa dipakai ulang di semua halaman tanpa locator berbasis class CSS.
 */
public class RecordList {

    private final WebDriver driver;
    private final WebDriverWait wait;
    private final String nameTestId;
    private final String containerTestId;
    private final By names;

    public RecordList(WebDriver driver, WebDriverWait wait, String nameTestId, String containerTestId) {
        this.driver = driver;
        this.wait = wait;
        this.nameTestId = nameTestId;
        this.containerTestId = containerTestId;
        this.names = By.cssSelector("[data-testid='" + nameTestId + "']");
    }

    /** Jumlah record yang ada di DOM. */
    public int count() {
        return driver.findElements(names).size();
    }

    /** Teks nama semua record, sesuai urutan DOM. */
    public List<String> names() {
        return driver.findElements(names).stream()
                .map(element -> element.getText().trim())
                .collect(Collectors.toList());
    }

    /** True kalau record dengan nama tersebut ada (tanpa menunggu). */
    public boolean has(String nama) {
        return !driver.findElements(itemLocator(nama)).isEmpty();
    }

    /** Menunggu sampai record dengan nama tersebut terlihat. */
    public RecordList waitFor(String nama) {
        wait.until(ExpectedConditions.visibilityOfElementLocated(itemLocator(nama)));
        return this;
    }

    /** Menunggu sampai record dengan nama tersebut tidak terlihat lagi. */
    public RecordList waitForGone(String nama) {
        wait.until(ExpectedConditions.invisibilityOfElementLocated(itemLocator(nama)));
        return this;
    }

    /**
     * Elemen pembungkus record (kartu/baris) untuk nama tertentu. Dipakai
     * ketika test perlu mengklik tombol di dalam record.
     */
    public WebElement item(String nama) {
        return wait.until(ExpectedConditions.visibilityOfElementLocated(itemLocator(nama)));
    }

    private By itemLocator(String nama) {
        return By.xpath("//*[@data-testid='" + nameTestId + "'][normalize-space()=" + xpathLiteral(nama)
                + "]/ancestor::*[@data-testid='" + containerTestId + "'][1]");
    }

    /**
     * Bungkus teks jadi literal XPath yang aman, termasuk nama yang mengandung
     * tanda kutip tunggal maupun ganda.
     */
    private static String xpathLiteral(String value) {
        if (!value.contains("'")) {
            return "'" + value + "'";
        }
        if (!value.contains("\"")) {
            return "\"" + value + "\"";
        }

        String[] parts = value.split("'");
        StringBuilder literal = new StringBuilder("concat(");
        for (int i = 0; i < parts.length; i++) {
            if (i > 0) {
                literal.append(", \"'\", ");
            }
            literal.append("'").append(parts[i]).append("'");
        }
        return literal.append(")").toString();
    }
}
