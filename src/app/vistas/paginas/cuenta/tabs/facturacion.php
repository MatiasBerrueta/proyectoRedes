<article>
  <section class="perfil-seccion">
      <div class="perfil-seccion__header">
          <h2 class="perfil-seccion__titulo">Plan actual</h2>
          <p class="descripcion">Tu suscripción y la próxima fecha de cobro.</p>
      </div>

      <div class="perfil-bloques">
          <div class="perfil-bloque perfil-bloque--columna">
              <div class="facturacion-plan">
                  <div class="facturacion-plan__info">
                      <div class="facturacion-plan__nombre">
                          <span class="facturacion-plan__titulo">
                              <?= htmlspecialchars($suscripcion['plan_nombre'] ?? 'Plan Fabric 4 GB', ENT_QUOTES, 'UTF-8') ?>
                          </span>
                          <?php $estado = $suscripcion['estado'] ?? 'activa'; ?>
                          <?php if ($estado === 'activa'): ?>
                              <span class="facturacion-badge facturacion-badge--ok">Activa</span>
                          <?php elseif ($estado === 'pendiente'): ?>
                              <span class="facturacion-badge facturacion-badge--warn">Pendiente</span>
                          <?php else: ?>
                              <span class="facturacion-badge facturacion-badge--mute">Cancelada</span>
                          <?php endif; ?>
                      </div>
                      <p class="descripcion">
                          <?= htmlspecialchars($suscripcion['plan_desc'] ?? '4 GB de RAM', ENT_QUOTES, 'UTF-8') ?>
                      </p>
                  </div>
                  <div class="facturacion-plan__precio">
                      <span class="facturacion-plan__monto">
                          <?= htmlspecialchars($suscripcion['precio'] ?? 'US$ 9,99', ENT_QUOTES, 'UTF-8') ?>
                          <span class="facturacion-plan__periodo">/ mes</span>
                      </span>
                      <p class="descripcion">
                          <?= htmlspecialchars($suscripcion['proxima_renovacion'] ?? 'Próximo cobro: 01 nov 2026', ENT_QUOTES, 'UTF-8') ?>
                      </p>
                  </div>
              </div>
              <div class="facturacion-plan__acciones">
                  <button type="button" class="boton boton--peligro" commandfor="facturacion-modal-cancelar" command="show-modal">
                      Cancelar suscripción
                  </button>
                  <button type="button" class="boton boton--primario" commandfor="facturacion-modal-plan" command="show-modal">
                      Cambiar de plan
                  </button>
              </div>
          </div>
      </div>
  </section>
  <section class="perfil-seccion">
      <div class="perfil-seccion__header">
          <h2 class="perfil-seccion__titulo">Método de pago</h2>
          <p class="descripcion">Con esta tarjeta se cobran las renovaciones.</p>
      </div>

      <div class="perfil-bloques">
          <?php foreach (($metodos_pago ?? [
              ['marca' => 'Visa', 'terminada' => '4242', 'vencimiento' => '08/28', 'principal' => true],
          ]) as $tarjeta): ?>
              <div class="perfil-bloque">
                  <div class="facturacion-tarjeta">
                      <div class="facturacion-tarjeta__icono">
                          <?php include PUBLIC_ROOT . "assets/iconos/credit-card.svg" ?>
                      </div>
                      <div class="perfil-bloque__texto">
                          <h3 class="perfil-bloque__titulo">
                              <?= htmlspecialchars($tarjeta['marca'] . ' terminada en ' . $tarjeta['terminada'], ENT_QUOTES, 'UTF-8') ?>
                          </h3>
                          <p class="descripcion">
                              Vence <?= htmlspecialchars($tarjeta['vencimiento'], ENT_QUOTES, 'UTF-8') ?>
                          </p>
                      </div>
                  </div>
                  <div class="perfil-bloque__control facturacion-tarjeta__acciones">
                      <?php if (!empty($tarjeta['principal'])): ?>
                          <span class="facturacion-badge facturacion-badge--mute">Principal</span>
                      <?php else: ?>
                          <button type="button" class="boton boton--secundario">
                              Hacer principal
                          </button>
                      <?php endif; ?>
                      <button
                          type="button"
                          class="boton boton--secundario"
                          commandfor="facturacion-modal-metodo"
                          command="show-modal"
                      >
                          Cambiar
                      </button>
                  </div>
              </div>
          <?php endforeach; ?>

          <div class="perfil-bloque">
              <div class="perfil-bloque__texto">
                  <h3 class="perfil-bloque__titulo">Agregar método de pago</h3>
                  <p class="descripcion">Podés guardar más de una tarjeta.</p>
              </div>
              <div class="perfil-bloque__control">
                  <button type="button" class="boton boton--secundario" commandfor="facturacion-modal-metodo" command="show-modal">
                      Agregar
                  </button>
              </div>
          </div>
      </div>
  </section>
  <section class="perfil-seccion">
      <div class="perfil-seccion__header">
          <h2 class="perfil-seccion__titulo">Historial de facturas</h2>
          <p class="descripcion">Descargá tus comprobantes en PDF.</p>
      </div>

      <div class="perfil-bloques facturacion-facturas">
          <div class="facturacion-fila facturacion-fila--encabezado">
              <span>Fecha</span>
              <span>Concepto</span>
              <span>Importe</span>
              <span>Estado</span>
              <span></span>
          </div>
          <?php foreach (($facturas ?? [
              ['fecha' => '01 oct 2026', 'concepto' => 'Plan Fabric 4 GB · octubre', 'importe' => 'US$ 9,99', 'estado' => 'Pagada'],
              ['fecha' => '01 sep 2026', 'concepto' => 'Plan Fabric 4 GB · septiembre', 'importe' => 'US$ 9,99', 'estado' => 'Pagada'],
              ['fecha' => '01 ago 2026', 'concepto' => 'Plan Fabric 4 GB · agosto', 'importe' => 'US$ 9,99', 'estado' => 'Pagada'],
              ['fecha' => '17 jul 2026', 'concepto' => 'Espacio extra de backups', 'importe' => 'US$ 2,00', 'estado' => 'Pagada'],
          ]) as $factura): ?>
              <div class="facturacion-fila perfil-bloque">
                  <span class="facturacion-fila__fecha">
                      <?= htmlspecialchars($factura['fecha'], ENT_QUOTES, 'UTF-8') ?>
                  </span>
                  <span class="facturacion-fila__concepto">
                      <?= htmlspecialchars($factura['concepto'], ENT_QUOTES, 'UTF-8') ?>
                  </span>
                  <span class="facturacion-fila__importe">
                      <?= htmlspecialchars($factura['importe'], ENT_QUOTES, 'UTF-8') ?>
                  </span>
                  <span>
                      <?php if ($factura['estado'] === 'Pagada'): ?>
                          <span class="facturacion-badge facturacion-badge--ok">Pagada</span>
                      <?php elseif ($factura['estado'] === 'Pendiente'): ?>
                          <span class="facturacion-badge facturacion-badge--warn">Pendiente</span>
                      <?php else: ?>
                          <span class="facturacion-badge facturacion-badge--mute">
                              <?= htmlspecialchars($factura['estado'], ENT_QUOTES, 'UTF-8') ?>
                          </span>
                      <?php endif; ?>
                  </span>
                  <button type="button" class="facturacion-descargar" aria-label="Descargar factura del <?= htmlspecialchars($factura['fecha'], ENT_QUOTES, 'UTF-8') ?>">
                      <?php include PUBLIC_ROOT . "assets/iconos/download.svg" ?>
                  </button>
              </div>
          <?php endforeach; ?>
      </div>
  </section>
</article>

<?php
require_once __DIR__ . '/modales/cambiar-plan.php';
require_once __DIR__ . '/modales/cancelar-suscripcion.php';
require_once __DIR__ . '/modales/metodo-pago.php';
?>
