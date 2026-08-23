import test, { expect } from "@playwright/test";

test.use({ storageState: { cookies: [], origins: [] } });

test("login as admin", async ({ page }) => {
    await page.goto("http://127.0.0.1:8000/login");
    await page.fill('input[name="username"]', "admin");
    await page.fill('input[name="password"]', "admin123");
    await page.click('button[type="submit"]');
    await expect(page).toHaveURL("http://127.0.0.1:8000/");
});

test("login as nurse", async ({ page }) => {
    await page.goto("http://127.0.0.1:8000/login");
    await page.fill('input[name="username"]', "perawat");
    await page.fill('input[name="password"]', "perawat123");
    await page.click('button[type="submit"]');
    await expect(page).toHaveURL("http://127.0.0.1:8000/");
});

test("login as doctor", async ({ page }) => {
    await page.goto("http://127.0.0.1:8000/login");
    await page.fill('input[name="username"]', "dokter");
    await page.fill('input[name="password"]', "dokter123");
    await page.click('button[type="submit"]');
    await expect(page).toHaveURL("http://127.0.0.1:8000/nakes");
});

test("login with wrong password", async ({ page }) => {
    await page.goto("http://127.0.0.1:8000/login");
    await page.fill('input[name="username"]', "cihuy");
    await page.fill('input[name="password"]', "cihuy123");
    await page.click('button[type="submit"]');

    await expect(page).toHaveURL(/\/login$/);

    await expect(
        page.locator("text=Username atau password salah"),
    ).toBeVisible();
});
