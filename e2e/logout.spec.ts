import test, { expect } from "@playwright/test";

test("logout", async ({ page }) => {
    await page.goto("http://127.0.0.1:8000/");

    await page.getByRole("button", { name: "Keluar" }).first().click();
    await page.getByRole("button", { name: "Ya, Keluar" }).click();
    await expect(page).toHaveURL(/\/login$/);

    await page.goto("http://127.0.0.1:8000/reservasi");
    await expect(page).toHaveURL(/\/login$/);
});
