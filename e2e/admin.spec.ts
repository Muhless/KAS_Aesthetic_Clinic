import test from "@playwright/test";

test("Create Patient Queue", async ({ page }) => {
    const targetDate = new Date();
    // targetDate.setDate(targetDate.getDate() + 2);
    const targetDay = targetDate.getDate().toString();

    await page.goto("http://127.0.0.1:8000/");
    await page.getByRole("button", { name: "Tambah Antrian" }).click();

    await page.selectOption('select[name="pasien_id"]', {
        label: "Muhta Nuryadi",
    });
    await page.selectOption('select[name="dokter_id"]', {
        label: "Dr. John Doe",
    });

    await page.getByRole("textbox", { name: "Tanggal" }).click();
    await page
        .locator(".flatpickr-day:not(.prevMonthDay):not(.nextMonthDay)")
        .filter({ hasText: new RegExp(`^${targetDay}$`) })
        .click();
    await page.getByRole("button", { name: "Simpan" }).click();
});

test("Call Patient", async ({ page }) => {
    await page.goto("http://127.0.0.1:8000/");
    await page.getByRole("button", { name: "panggil" }).first().click();
    await page.getByLabel("Keluhan Pasien").fill("Kulit kusam dan berminyak");
    await page.locator("form").getByRole("button", { name: "Panggil" }).click();
});

test("Admin successfully complete the payment", async ({ page }) => {
    await page.goto("http://127.0.0.1:8000/keuangan");
    await page.getByRole("link", { name: "Detail" }).first().click();
    await page.pause()
});
