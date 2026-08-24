import test, { expect } from "@playwright/test";

test("Create New Data", async ({ page }) => {
    const uniqueName = `Muhta Nuryadi ${Date.now()}`;
    await page.goto("http://127.0.0.1:8000/pasien");
    await page.getByRole("button", { name: "Tambah" }).click();
    await page.getByPlaceholder("Masukkan nama lengkap").fill(uniqueName);
    await page.getByLabel("Laki-laki").check();
    await expect(page.getByLabel("Laki-laki")).toBeChecked();
    await page.getByPlaceholder("08xxxxxxxxxx").fill("08871165551");
    await page.getByRole("textbox", { name: "Pilih tanggal lahir" }).click();
    await page
        .locator(".flatpickr-day:not(.prevMonthDay):not(.nextMonthDay)")
        .first()
        .click();
    await page.getByRole("button", { name: "Simpan" }).click();
    await expect(page.getByText(uniqueName)).toBeVisible();
    await page.pause()
});
