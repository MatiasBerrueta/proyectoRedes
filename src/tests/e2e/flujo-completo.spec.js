const { test, expect } = require('@playwright/test');

test.describe('E2E – Flujo Completo de Usuario', () => {

  test('Flujo completo: registro → uso → logout → login → logout final', async ({ page }) => {
    // 1- Registro
    await page.goto('/registrarCliente');

    const email = `nuevo${Date.now()}@test.com`;

    await page.fill('#input-nombre', 'Nuevo Usuario');
    await page.fill('#input-email', email);
    await page.fill('#input-contrasena', 'contrasenaValida');
    await page.fill('#input-confirmar-contrasena', 'contrasenaValida');
    await page.click('button[type="submit"]');

    await expect(page).toHaveURL('/usuario/perfil');

    // 2- Logout
    await page.click('text=Cerrar sesión');
    await expect(page).toHaveURL('/login');

    // 3- Login
    await page.fill('#input-email', email);
    await page.fill('#input-contrasena', 'contrasenaValida');
    await page.click('button[type="submit"]');

    await expect(page).toHaveURL('/usuario/perfil');

    // 4- Logout final
    await page.click('text=Cerrar sesión');
    await expect(page).toHaveURL('/login');
  });

});
