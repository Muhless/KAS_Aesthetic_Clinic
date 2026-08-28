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
    await page.selectOption('select[name="dokter_id"]', { label: "agus" });

    await page.getByRole("textbox", { name: "Tanggal" }).click();
    await page
        .locator(".flatpickr-day:not(.prevMonthDay):not(.nextMonthDay)", {
            hasText: targetDay,
        })
        .click();
await page.pause()
    await page.getByRole("button", { name: "Simpan" }).click();
});
