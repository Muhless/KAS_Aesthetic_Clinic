package com.kas.pages;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;

import com.kas.components.FormModal;

public class PatientPage extends BasePage {

    private final By titlePage = By.xpath("(//h1[normalize-space()='Pasien'])");
    private final By emptyState = By.xpath("//td[normalize-space()='Belum ada data pasien']");

    private final By addButton = By.cssSelector("[data-testid='add-patient']");
    private final By modalRoot = By.cssSelector("[data-testid='patient-modal']");
    private final FormModal modal = new FormModal(driver, wait, modalRoot,
            By.cssSelector("[data-testid='patient-modal'] h5"));

    private final By nameInput = By.cssSelector("[data-testid='patient-modal'] input[name='nama']");
    private final By maleGender = By.cssSelector("[data-testid='patient-modal'] input[name='jenis_kelamin'][value='L']");
    private final By femaleGender = By.cssSelector("[data-testid='patient-modal'] input[name='jenis_kelamin'][value='P']");
    private final By phoneInput = By.cssSelector("[data-testid='patient-modal'] input[name='nomor_telepon']");
    private final By birthDateSelect = By.cssSelector("[data-testid='patient-modal'] input[type='text'][placeholder='Pilih tanggal lahir']");

    public PatientPage(WebDriver driver) {
        super(driver);
    }

}
