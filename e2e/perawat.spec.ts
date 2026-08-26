import test, { expect } from "@playwright/test";
import path from "path";

let nurseCreated: string;

test("add perawat data", async ({ page }) => {
    nurseCreated = "Diana Larasati";
    await page.goto("http://127.0.0.1:8000/perawat");
    await page.getByRole("button", { name: "Tambah" }).click();
    await page.setInputFiles(
        "#foto_perawat",
        path.join(import.meta.dirname, "fixtures", "nurse.png"),
    );
    await expect(page.getByAltText("Preview Foto")).toBeVisible();

    await page.getByPlaceholder("Nama Lengkap Perawat").fill(nurseCreated);
    await page.getByRole("textbox", { name: "Pilih Tanggal Lahir" }).click();
    await page
        .locator(".flatpickr-day:not(.prevMonthDay):not(.nextMonthDay)")
        .first()
        .click();
    await page.getByPlaceholder("08xxxxxxxxxx").fill("08899668664");
    await page
        .getByPlaceholder("perawat@kasclinic.com")
        .fill("diana@gmail.com");

    // username and password
    await page.getByLabel("Username").fill("diana");
    await page.getByLabel("Password").fill("diana12345");
    await page.getByRole("button", { name: "Simpan" }).click();

    await expect(page.getByText(nurseCreated)).toBeVisible();
});

test.afterEach(async ({ page }) => {
    if (!nurseCreated) return;

    await page.goto("http://127.0.0.1:8000/perawat");
    const card = page.locator("div.bg-white.rounded-sm", {
        hasText: nurseCreated,
    });
    if ((await card.count()) === 0) return;

    page.once("dialog", (dialog) => dialog.accept());
    await card.locator('button[type="submit"]').click();

    await expect(card).toHaveCount(0);
});

test("upload photo failed if size more than 2MB", async ({ page }) => {
    await page.goto("http://127.0.0.1:8000/perawat");
    await page.getByRole("button", { name: "Tambah" }).click();
    await page.setInputFiles(
        "#foto_perawat",
        path.join(import.meta.dirname, "fixtures", "big-images.jpg"),
    );
    await expect(page.getByText("Ukuran foto maksimal 2MB.")).toBeVisible();
    await expect(page.getByAltText("Preview Foto")).not.toBeVisible();
});
