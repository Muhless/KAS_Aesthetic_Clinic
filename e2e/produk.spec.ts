import test, { expect } from "@playwright/test";
import path from "path";

let Product: string;

test("Create Product Data", async ({ page }) => {
    Product = "Acne Serum";

    await page.goto("http://127.0.0.1:8000/produk");
    await page.getByRole("button", { name: "Tambah" }).first().click();

    await page.setInputFiles(
        "#foto_produk",
        path.join(import.meta.dirname, "fixtures", "product.png"),
    );
    await expect(page.locator("div.border-dashed img[src]")).toBeVisible();

    await page.getByLabel("Nama Produk").fill(Product);
    await page.getByLabel("Kategori").fill("Serum");
    await page
        .getByLabel("Deskripsi")
        .fill("Untuk memutihkan kulit kusam dan berjerawat");
    await page.getByLabel("Harga").fill("120000");
    await page.getByRole("spinbutton", { name: "Stok" }).fill("10");
    await page.getByLabel("Tersedia", { exact: true }).check();
    await expect(page.getByLabel("Tersedia", { exact: true })).toBeChecked();

    await page.getByRole("button", { name: "Simpan" }).click();
    await expect(page.getByText(Product)).toBeVisible();
});

test.afterEach(async ({ page }) => {
    if (!Product) return;
    await page.goto("http://127.0.0.1:8000/produk");
    const card = page.locator("div.bg-white.rounded-sm", {
        hasText: Product,
    });

    if ((await card.count()) === 0) return;

    page.once("dialog", (dialog) => dialog.accept());
    await card.locator('button[type="submit"]').click();
    await expect(card).toHaveCount(0);
});
