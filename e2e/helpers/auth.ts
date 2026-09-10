import { expect, Page } from "@playwright/test";

type Role = "admin" | "perawat" | "dokter";

const credentials: Record<Role, { username: string; password: string }> = {
    admin: { username: "admin", password: "admin123" },
    perawat: { username: "perawat", password: "perawat123" },
    dokter: { username: "dokter", password: "dokter123" },
};

export async function LoginAs(page: Page, role: Role) {
    const { username, password } = credentials[role];

    await page.goto("http://127.0.0.1:8000/login");
    await page.fill('input[name="username"]', username);
    await page.fill('input[name="password"]', password);
    await page.click('button[type="submit"]');
    await expect(page).toHaveURL("http://127.0.0.1:8000/");
}

export async function Logout(page: Page) {
    await page.getByRole("button", { name: "Keluar" }).first().click();
    await page.getByRole("button", { name: "Ya, Keluar" }).click();
    await expect(page).toHaveURL(/\/login$/);
}
