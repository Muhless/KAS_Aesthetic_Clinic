import test, { expect } from "@playwright/test";
import path from "path";

let doctorCreated: string;

test("Create Doctor Data", async ({ page }) => {
    doctorCreated = "Dr. Strange S.pd M.pd";
    await page.goto("http://127.0.0.1:8000/dokter");
    await page.getByRole("button", { name: "Tambah" }).click();

    await page.setInputFiles(
        "#foto_edit",
        path.join(import.meta.dirname, "fixtures", "dokter.png"),
    );
    await expect(page.getByAltText("Preview Foto")).toBeVisible();

    await page.getByLabel("Nama Lengkap").fill(doctorCreated);
    await page.getByRole("textbox", { name: "Pilih Tanggal Lahir" }).click();
    await page
        .locator(".flatpickr-day:not(.prevMonthDay):not(.nextMonthDay)")
        .first()
        .click();
    await page.getByLabel("Spesialisasi").fill("Kecantikan alami");
    await page.getByLabel("Nomor Telepon").fill("08867161716");
    await page.getByLabel("Email").fill("strange@gmail.com");
    await page.getByLabel("Biaya Konsultasi").fill("300000");

    await page.getByLabel("Username").fill("strange");
    await page.getByLabel("Password").fill("strange123");
    await page.getByRole("button", { name: "Simpan" }).click();

    await expect(page.getByText(doctorCreated)).toBeVisible();
});

test.afterEach(async ({ page }) => {
    if (!doctorCreated) return;

    await page.goto("http://127.0.0.1:8000/dokter");
    const card = page.locator("div.bg-white.rounded-sm", {
        hasText: doctorCreated,
    });

    if ((await card.count()) === 0) return;

    page.once("dialog", (dialog) => dialog.accept());
    await card.locator('button[type="submit"]').click();
    await expect(card).toHaveCount(0);
});
