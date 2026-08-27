import test, { expect } from "@playwright/test";
import path from "path";

let Treatment: string;

test("Create Treatment Data", async ({ page }) => {
    Treatment = "Facial Whitening";

    await page.goto("http://127.0.0.1:8000/treatment");
    await page.getByRole("button", { name: "Tambah" }).first().click();
    await page.setInputFiles(
        "#foto_treatment",
        path.join(import.meta.dirname, "fixtures", "treatment.jpg"),
    );
    await expect(page.locator("div.border-dashed img[src]")).toBeVisible();
    await page.getByLabel("Nama Treatment").fill(Treatment);
    await page
        .getByLabel("Deskripsi")
        .fill("Mencerahkan & meratakan warna kulit");
    await page.getByLabel("Harga").fill("150000");
    await page.getByLabel("Durasi").fill("60");
    await page.getByLabel("Tidak Tersedia", { exact: true }).check();
    await expect(
        page.getByLabel("Tidak Tersedia", { exact: true }),
    ).toBeChecked();
    await page.getByRole("button", { name: "Simpan" }).click();

    await expect(page.getByText(Treatment)).toBeVisible();
});

test.afterEach(async ({ page }) => {
    if (!Treatment) return;
    await page.goto("http://127.0.0.1:8000/treatment");

    const card = page.locator("div.bg-white.rounded-sm", {
        hasText: Treatment,
    });

    if ((await card.count()) === 0) return;

    page.once("dialog", (dialog) => dialog.accept());
    await card.locator('button[type="submit"]').click();
    await expect(card).toHaveCount(0);
});
