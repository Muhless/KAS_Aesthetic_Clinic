import { test as setup } from "@playwright/test";

const adminFile = "playwright/.auth/admin.json";
const nurseFile = "playwright/.auth/nurse.json";
const doctorFile = "playwright/.auth/doctor.json";

setup("login as admin", async ({ page }) => {
    await page.goto("http://127.0.0.1:8000/login");
    await page.fill('input[name="username"]', "admin");
    await page.fill('input[name="password"]', "admin123");
    await page.click('button[type="submit"]');
    await page.waitForURL("http://127.0.0.1:8000/");

    await page.context().storageState({ path: adminFile });
});

setup("login as nurse", async ({ page }) => {
    await page.goto("http://127.0.0.1:8000/login");
    await page.fill('input[name="username"]', "perawat");
    await page.fill('input[name="password"]', "perawat123");
    await page.click('button[type="submit"]');
    await page.waitForURL("http://127.0.0.1:8000/");

    await page.context().storageState({ path: nurseFile });
});

setup("login as doctor", async ({ page }) => {
    await page.goto("http://127.0.0.1:8000/login");
    await page.fill('input[name="username"]', "dokter");
    await page.fill('input[name="password"]', "dokter123");
    await page.click('button[type="submit"]');
    await page.waitForURL("http://127.0.0.1:8000/nakes");

    await page.context().storageState({ path: doctorFile });
});
