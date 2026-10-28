<h1 align="center">Voxel Hosting</h1>

<p align="center">
  <em>Plataforma de hosting y gestión de servidores de videojuegos</em>
</p>

<p align="center">
  Proyecto Final de Grado — Tecnicatura en Redes y Software
</p>

---

## Imágenes del Proyecto

<p align="center">
  <img src="/imagenes/landing.png" alt="Landing Page" width="700"/>
</p>

<p align="center">
  <img src="/imagenes/servidores.png" alt="Panel de Servidores" width="700"/>
</p>

<p align="center">
  <img src="/imagenes/consola.png" alt="Consola en Vivo" width="700"/>
</p>

---

## ¿Qué es Voxel Hosting?

Voxel Hosting es una plataforma web que permite a los usuarios **crear, administrar y gestionar servidores de videojuegos** de forma sencilla. Funciona como una capa de interfaz por encima de [Pterodactyl Panel](https://pterodactyl.io/), ofreciendo una experiencia simplificada gestionar servidores, planes y usuarios.

### Objetivo

Este proyecto fue desarrollado como Proyecto Final de Grado. Nuestro objetivo principal es el aprendizaje práctico de la programación, la colaboración en equipo y el dominio de herramientas de desarrollo.

Con el fin de comprender los fundamentos de la programación, decidimos implementar la gran mayoría de los sistemas desde cero, reduciendo al mínimo el uso de frameworks y librerías externas. Por esta razón, el diseño del código y la arquitectura están orientados al aprendizaje pueden no representar la forma más óptima o eficiente de resolver cada problema.

### Advertencia

Dado que priorizamos el proceso de aprendizaje sobre los estándares comerciales, el sistema no cuenta con auditorías de seguridad ni protecciones robustas.
No recomendamos utilizar este software en entornos de producción, servidores expuestos ni para manejar datos reales de usuarios. Usar únicamente en entornos locales de desarrollo o pruebas.

---

## Instalación y Ejecución

### Requisitos Previos

- [Docker](https://www.docker.com/) y Docker Compose instalados
- Git

```bash
# Clonar el repositorio
git clone https://github.com/tu-usuario/proyectoRedes.git
cd proyectoRedes

# Levantar todos los servicios
docker compose up -d

# La aplicacion estara disponible en:
# http://localhost:8081
```

Cuando apenas inicia la pagina, puede aparecer un error  
`Conexion fallida: SQLSTATE[HY000] [2002] Connection refused`  
Esto es mysql cargando, despues de unos minutos reincie la pagina

---

## Comandos disponibles

(lista de comandos, sincronizar ptero, seed bd)

## Estructura del Proyecto

```
proyectoRedes/
├── docker-compose.yml
├── Dockerfile
├── 000-default.conf          # VirtualHost Apache
│
├── db/
│   ├── primario-init/        # SQL: tablas, procedimientos, roles, datos
│   └── replica-init/         # Configuración de réplica MySQL
│
├── proxysql/                 # Config + certs de ProxySQL
│
└── src/
    ├── app/
    │   ├── controladores/    # Capa de orquestacion
    │   ├── servicios/        # Lógica de negocio
    │   ├── repositorios/     # Acceso a datos BD
    │   ├── modelos/          # Entidades de dominio
    │   ├── integraciones/    # APIs externas
    │   ├── vistas/           # Templates PHP
    │   └── utils/            # Utilidades
    │
    ├── public/               # Web root (CSS, JS, assets)
    │
    └── tests/
        ├── unitarios/        # PHPUnit
        ├── integracion/      # PHPUnit
        └── e2e/              # Playwright
```

---

<p align="center">
  <sub>Tecnicatura en Redes y Software — Proyecto Final de Grado</sub>
</p>
