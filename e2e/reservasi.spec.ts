import test, { expect } from "@playwright/test";

test("go to reservation pages", async ({ page }) => {
    await page.goto("http://127.0.0.1:8000/reservasi");

    await expect(page.getByText("Reservasi")).toBeVisible;
});
