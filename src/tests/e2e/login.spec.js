const { test, expect } = require('@playwright/test');

test.describe('E2E – Login', () => {
  test('Login exitoso', async ({ page }) => {
    await page.goto('/login');

    await page.fill('#input-email', 'usuario@mail.com');
    await page.fill('#input-contrasena', 'contrasenaValida');

    await page.click('button[type="submit"]');

    await expect(page).toHaveURL('/usuario/perfil');
  });

  test('Login incorrecto', async ({ page }) => {
    await page.goto('/login');

    await page.fill('#input-email', 'usuario@mail.com');
    await page.fill('#input-contrasena', 'noValida');

    await page.click('button[type="submit"]');

    await expect(page.locator('.mensaje-input')).toHaveText('Credenciales incorrectas');
  });

});
