# Arquitectura CSS

## Estructura de archivos

```
src/public/css/
├── main.css              # Variables CSS, reset, tipografia, utilidades
├── layout.css            # Estructura global (header, footer, aside, breadcrumbs)
├── componentes.css       # Componentes reutilizables globales (botones, formularios, badges)
└── paginas/              # Estilos especificos por pagina
    ├── landing.css
    ├── registro.css
    ├── panel.css
    └── servidor/
        ├── servidor.css
        └── tabs/
            ├── consola.css
            ├── archivos.css
            ├── configuracion.css
            ├── mods.css
            └── monitor.css
```

## Cuando agregar una clase nueva

### 1. Agregar a `main.css` si es:

- **Variable CSS** (`--*`): colores, tamaños, sombras, transiciones
- **Utilidad de tipografia**: `font-size-*`, `texto-*`
- **Utilidad de layout**: `flex-*`, `grid-*`, `w-*`, `mb-*`, `mt-*`
- **Utilidad que se usa en 3+ paginas distintas**

```css
/* Ejemplo: utilidad reutilizable */
.flex--center {
  justify-content: center;
}
```

### 2. Agregar a `componentes.css` si es:

- **Componente reutilizable que aparece en 2+ paginas distintas**
- Botones (`.boton`, `.boton--primario`, etc.)
- Formularios (`input`, `select`, `.form-group`, `.slider`)
- Badges (`.badge-tipo`, `.badge-mod`)
- Separadores, mensajes de validacion, iconos

```css
/* Ejemplo: componente reutilizable */
.boton {
  display: flex;
  padding: 0.75rem 2rem;
  background: var(--color-fondo);
}
```

### 3. Agregar a `layout.css` si es:

- **Estructura global que se repite en todas las paginas del mismo tipo**
- Header, footer, aside/nav lateral
- Breadcrumbs
- Layouts base (`layout-panel`, `.tab-contenido`)

```css
/* Ejemplo: estructura global */
header {
  position: sticky;
  top: 0;
  width: 100%;
}
```

### 4. Agregar a `paginas/*.css` si es:

- **Estilo que SOLO pertenece a una pagina especifica**
- Grids de esa pagina, componentes unicos, modales especificos

```css
/* Ejemplo: estilos del dashboard (panel.css) */
.contenedor-servidores {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
}

.servidor {
  border: 1px solid var(--color-borde);
}
```

## Cuando crear un archivo nuevo

### Crear `paginas/{nombre-pagina}.css` cuando:

- Existe una **pagina nueva** que no tiene archivo CSS
- La pagina tiene **estilos que no se reutilizan en otras paginas**
- Tiene **2+ elementos unicos** que no encajan en `componentes.css`

**Ejemplo**: La pagina `/login` → crear `paginas/login.css`

### Crear `paginas/{pagina}/` (carpeta) cuando:

- La pagina tiene **sub-secciones o tabs** con estilos propios
- El archivo de esa pagina supera **~300 lineas**
- Hay **contextos distintos** dentro de la misma pagina

**Ejemplo**: `/servidor` tiene tabs (consola, archivos, mods) → crear `paginas/servidor/` con subarchivos

### NUNCA crear un archivo nuevo cuando:

- El estilo es reutilizable → usar `componentes.css`
- Es una variable o utilidad → usar `main.css`
- Es una estructura global (header, footer) → usar `layout.css`
- Solo cambia un color o valor existente → usar variable de `main.css`

**Regla**: Solo importar los CSS de la pagina que se esta renderizando. No importar todos los CSS de todas las paginas.

## Nomenclatura de clases (BEM)

Seguimos la metodologia **BEM** (Block, Element, Modifier) para nombrar clases CSS:

### Estructura

- **Block**: El componente principal (ej: `.boton`, `.servidor`, `.card`)
- **Element**: Parte de un block, separado con `__` (ej: `.servidor__titulo`, `.card__header`)
- **Modifier**: Variacion de un block o element, separado con `--` (ej: `.boton--primario`, `.badge-mod--fabric`)

### Ejemplos correctos

```css
/* Block */
.boton { ... }

/* Modifier */
.boton--primario { ... }
.boton--peligro { ... }
.boton--bloque { ... }

/* Block con elemento */
.servidor__informacion { ... }
.servidor__titulo { ... }

/* Modifier en elemento */
.servidor__estado--online { ... }
.servidor__estado--stopping { ... }
```

### Reglas

- Nombres en español, en minusculas, separados por `-` dentro de cada parte
- Modificadores usan `--` (dos guiones)
- Elementos usan `__` (dos guiones bajos)
- NO usar camelCase ni snake_case
- NO abreviar palabras innecesariamente

## Sistema de botones

Todo boton parte de `.boton` (`componentes.css`) y se le combinan **3 ejes
independientes**, en este orden:

| Eje | Modificadores | Efecto |
| --- | --- | --- |
| **Tamanio** | `--s`, `--l` | Padding y `font-size` (default = mediano) |
| **Jerarquia** | `--primario`, `--secundario`, `--fantasma`, `--peligro` | Nivel de protagonismo |
| **Color** | `--exito`, `--advertencia`, `--info`, `--negro` | Sustituye el color de la jerarquia |

**Utilidades** (se combinan con lo de arriba): `--bloque` (ancho completo), `--icono`
(solo icono, padding cuadrado).

**Estado**: `:disabled` es **neutro** para todas las variantes. No pintar un boton
deshabilitado a mano.

```html
<button class="boton boton--primario">Guardar</button>
<button class="boton boton--s boton--peligro">Eliminar</button>
<button class="boton boton--icono boton--fantasma">…</button>
```

### Combinar jerarquia y color

Los ejes se resuelven **por orden de aparicion** en `componentes.css`: los
modificadores de **color** van despues de los de **jerarquia**, asi que si hay
conflicto gana el color. En la practica:

- La mayoria de los casos se resuelve con **un solo modificador**: `--primario`,
  `--exito`, `--peligro`, `--advertencia`, etc.
- `--fantasma` si se combina bien con un color, porque no define color de fondo:
  `class="boton boton--fantasma boton--exito"` deja el texto verde sin relleno.
- No combinar dos jerarquias ni dos colores a la vez: no tiene sentido visual y
  solo gana el ultimo.

### Componentes derivados

Son bloques propios en `componentes.css`, resuelven **solo el aspecto**: el
posicionamiento siempre vive en el CSS de la pagina.

- `.boton-cerrar` → boton "X" para cerrar modales
- `.segmento` + `.segmento__item` / `--activo` → grupo de opciones con una sola activa
- `.chip` + `--azul` / `--violeta` / `--neutro` (color) + `--solido` (relleno) →
  chips de navegacion del header (`layout.css`, porque pertenecen al header).
  Los de color solo fijan `--color-chip`; `--solido` la pinta y va despues de ellos.

### Reglas

- Si un boton ya usa `.boton`, **no** redefinir `padding`, `border-radius`,
  `background` ni `cursor` en el CSS de la pagina. Solo se permiten ajustes de
  **layout** (`flex`, `margin`, `width`) y **color** propio de esa pagina.
- No crear clases nuevas para repetir un estilo que ya existe en el sistema.
  Antes de crear una, buscar si ya hay un modificador que sirva.

## Prohibido

- **`!important`** → Nunca usar. Si hay conflicto de especificidad, reestructurar el selector.
- **Colores hardcodeados** → Siempre usar variables de `main.css`
- **Estilos inline en HTML** → Excepto variables CSS dinamicas (ej: `style="--banner:url(...)"`)
