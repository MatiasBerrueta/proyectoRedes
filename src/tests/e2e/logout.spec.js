const { test, expect } = require('@playwright/test');

test.describe('E2E – Logout', () => {

  test('Logout desde la página', async ({ page }) => {
    // Login primero
    await page.goto('/login');
    await page.fill('#input-email', 'usuario@test.com');
    await page.fill('#input-contrasena', 'contrasenaValida');
    await page.click('button[type="submit"]');

    await expect(page).toHaveURL('/usuario/perfil');

    // Logout
    await page.click('text=Cerrar sesión');

    await expect(page).toHaveURL('/login');
  });

});
