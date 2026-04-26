 <dialog id="crearServidorModal">
    <form action="">
        <div class="form-header">
            <h2 class="font-size-5">Crear servidor</h2>
            <button type="button" class="boton-cerrar-crear-servidor" onclick="crearServidorModal.close()">
                <?php include PUBLIC_ROOT . 'assets/iconos/x.svg'; ?>
            </button>
        </div>
        <div class="form-contenido">
            <div>
                <h3>General</h3>
                <div class="form-seccion">
                    <?php 
                    renderizarInput([
                        'clave' => 'nombre',
                        'etiqueta' => 'Nombre',
                        'tipo' => 'text',
                        'default' => '',
                    ]); 
                    ?>

                    <div class="input-misma-linea">
                        <?php 
                        renderizarInput([
                            'clave' => 'juego',
                            'etiqueta' => 'Juego',
                            'tipo' => 'select',
                            'opciones' => ['Minecraft', 'CS2', 'Terraria', 'Rust'],
                            'default' => 'Minecraft',
                        ]);
                        renderizarInput([
                            'clave' => 'version',
                            'etiqueta' => 'Versiones',
                            'tipo' => 'select',
                            'opciones' => ['1.21.11', '1.21.1', '1.20', '1.19.1', '1.18'],
                            'default' => '1.21.11',
                        ]);
                        ?>
                    </div>
                    <?php 
                    renderizarInput([
                        'clave' => 'descripcion',
                        'etiqueta' => 'Descripcion',
                        'tipo' => 'text',
                        'default' => '',
                    ]);
                    ?>
                </div>
                <h3>Plan y rendimiento</h3>
                <div class="form-seccion">
                    <div class="plan-actual">
                        <p>Plan activo: <b>Voxel Premium</b></p>
                        <div class="caracteristicas-plan">
                            <div class="caracteristica">
                                <div></div>
                                <span>8GB RAM</span>
                            </div>
                            <div class="caracteristica">
                                <div></div>
                                <span>100GB disco</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <span>Cantidad de jugadores</span>
                        <div class="seccion-rendimiento">
                            <div class="input-number-group">
                                <div class="input-contenedor">
                                    <button type="button" class="boton-menos">
                                        <?php include PUBLIC_ROOT . 'assets/iconos/minus.svg'; ?>
                                    </button>
                                    <input type="text" id="jugadores" inputmode="numeric" maxlength="3" value="20" size="2">
                                    <button type="button" class="boton-mas">
                                        <?php include PUBLIC_ROOT . 'assets/iconos/plus.svg'; ?>
                                    </button>
                                </div>
                                <span>jugadores</span>
                            </div>
                            <div class="indicador-rendimiento">
                                <div class="barra-rendimiento">
                                    <div class="relleno-barra"></div>
                                </div>
                                <small>Rendimiento optimo</small>
                            </div>
                        </div>
                        <p class="tooltip-rendimiento">Dentro del rango recomendado para tu plan.</p>
                    </div>
                </div>
            </div>
            <div>
                <div class="seccion-regiones">
                    <h3>Regiones disponibles</h3>
                    <input id="region_local" class="region-radio" type="radio" name="region" value="local" checked>
                    <label for="region_local" class="contenedor-region">
                        <div>
                            <span class="region">Local <span class="tag-recomendado">óptimo</span></span>
                            <span class="localidad-servidor">Montevideo, Uruguay</span>
                        </div>
                        <span class="medidor-ping bajo">12 ms</span>
                    </label>

                    <input id="region_buenos_aires" class="region-radio" type="radio" name="region" value="buenos_aires">
                    <label for="region_buenos_aires" class="contenedor-region">
                        <div>
                            <span class="region">Sudamerica</span>
                            <span class="localidad-servidor">Buenos Aires, Argentina</span>
                        </div>
                        <span class="medidor-ping bajo">24 ms</span>
                    </label>

                    <input id="region_sao_paulo" class="region-radio" type="radio" name="region" value="sao_paulo">
                    <label for="region_sao_paulo" class="contenedor-region">
                        <div>
                            <span class="region">Sudamerica</span>
                            <span class="localidad-servidor">Sao Paulo, Brasil</span>
                        </div>
                        <span class="medidor-ping bajo">32 ms</span>
                    </label>

                    <input id="region_miami" class="region-radio" type="radio" name="region" value="miami">
                    <label for="region_miami" class="contenedor-region">
                        <div>
                            <span class="region">Norteamérica</span>
                            <span class="localidad-servidor">Miami, Estados Unidos</span>
                        </div>
                        <span class="medidor-ping medio">78 ms</span>
                    </label>

                    <input id="region_madrid" class="region-radio" type="radio" name="region" value="madrid">
                    <label for="region_madrid" class="contenedor-region">
                        <div>
                            <span class="region">Europa</span>
                            <span class="localidad-servidor">Madrid, España</span>
                        </div>
                        <span class="medidor-ping alto">145 ms</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-footer">
            <p>Rellena los datos para crear el servidor</p>
            <div>
                <button type="submit" class="boton-cancelar-servidor">Cancelar</button>
                <button type="submit" class="boton-crear-servidor" disabled>Crear</button>
            </div>
        </div>
    </form>
</dialog>