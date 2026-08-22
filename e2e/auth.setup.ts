import { test as setup } from "@playwright/test";

const authFile = "playwright/.auth/admin.json";

setup("login as admin", async ({ page }) => {
    await page.goto("http://127.0.0.1:8000/login");
    await page.fill('input[name="username"]', "admin");
    await page.fill('input[name="password"]', "admin123");
    await page.click('button[type="submit"]');
    await page.waitForURL("http://127.0.0.1:8000/");

    await page.context().storageState({ path: authFile });
});
