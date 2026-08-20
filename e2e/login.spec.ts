import test, { expect } from "@playwright/test";

test("login", async ({ page }) => {
    await page.goto("http://127.0.0.1:8000/login");
    await page.fill('input[name="username"]', "admin");
    await page.fill('input[name="password"]', "admin123");
    await page.click('button[type="submit"]');
    await expect(page).toHaveURL("http://127.0.0.1:8000/");
});

test("login with wrong password", async ({ page }) => {
    await page.goto("http://127.0.0.1:8000/login");
    await page.fill('input[name="username"]', "cihuy");
    await page.fill('input[name="password"]', "cihuy123");
    await page.click('button[type="submit"]');

    pwpe

    await expect(page).toHaveURL("http://127.0.0.1:8000/");
});
