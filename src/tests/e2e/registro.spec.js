const { test, expect } = require('@playwright/test');

test.describe('E2E – Registro', () => {
  test('Registro correcto', async ({ page }) => {
    const email = `test_${Date.now()}@mail.com`;

    await page.goto('/registrarCliente');

    await page.fill('#input-nombre', 'Usuario Test');
    await page.fill('#input-email', email);
    await page.fill('#input-contrasena', 'contrasenaValida');
    await page.fill('#input-confirmar-contrasena', 'contrasenaValida');

    await page.click('button[type="submit"]');

    await expect(page).toHaveURL('/usuario/perfil');
  });

  test('Registro con error de email', async ({ page }) => {
    await page.goto('/registrarCliente');

    await page.fill('#input-nombre', 'Usuario Error');
    await page.fill('#input-email', 'usuario@');
    await page.fill('#input-contrasena', 'contrasenaValida');
    await page.fill('#input-confirmar-contrasena', 'contrasenaValida');

    await page.click('button[type="submit"]');

    await expect(page.locator('#mensaje-error-email')).toHaveText('Introduzca un email valido');
  });

  test('Registro con email duplicado', async ({ page }) => {
    await page.goto('/registrarCliente');

    await page.fill('#input-nombre', 'Usuario Duplicado');
    await page.fill('#input-email', 'usuario@test.com');
    await page.fill('#input-contrasena', 'contrasenaValida');
    await page.fill('#input-confirmar-contrasena', 'contrasenaValida');

    await page.click('button[type="submit"]');

    await expect(page.locator('#mensaje-error-email')).toHaveText('Ya existe un usuario con ese email');
  });

});
