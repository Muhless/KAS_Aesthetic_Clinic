import test from "@playwright/test";

test("add perawat data", async ({ page }) => {
    await page.goto("http://127.0.0.1:8000/perawat");
    await page.getByRole("button", { name: "Tambah" }).click();
    await page.getByPlaceholder("Nama Lengkap Perawat").fill("Diana Larasati");
    await page.getByRole("textbox", { name: "Pilih Tanggal Lahir" }).click();
    await page
        .locator(".flatpickr-day:not(.prevMonthDay):not(.nextMonthDay)")
        .first()
        .click();
    await page.getByPlaceholder("08xxxxxxxxxx").fill("08899668664")
    await page.getByPlaceholder("perawat@kasclinic.com").fill("diana@gmail.com")
    await page.pause();
});
