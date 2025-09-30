TALLER DE SERVICIOS – Laravel + AdminLTE

Sistema web para administrar un taller de reparación de equipos (laptops, smartphones, impresoras, etc.).
Permite registrar clientes y sus dispositivos, crear servicios con su estado y llevar el detalle de ítems (repuestos/mano de obra) asociados a cada servicio.

🧩 MODULOS PRINCIPALES

Clientes: alta/edición/baja y búsqueda.

Dispositivos: modelo, serie/IMEI, tipo y marca; vinculados a un cliente.

Estados de servicio: catálogo (recibido, reparando, finalizado, entregado, …).

Servicios: recepción del equipo, problema reportado, diagnóstico, solución, estado actual, técnico asignado, folio auto-generado.

Ítems del servicio: repuestos y mano de obra (cantidad, precio unitario, subtotal y total).

Algoritmos (demo): factorial, amortización y binomio (para la prueba técnica).

UI basada en AdminLTE (Laravel-AdminLTE) y assets compilados con Vite.

🛠 TECNOLOGIAS

    - PHP 8.2+ / Laravel 10–12

    - MySQL/MariaDB

    - Node.js 20.19+ (o 22+) y npm 10+

    - Laravel-AdminLTE

    - Vite
------------------
✅ REQUISITOS
-------------------
    -   PHP 8.2+ con extensiones comunes (mbstring, intl, pdo_mysql, etc.)

    -   MySQL/MariaDB en marcha y una base de datos creada (p. ej. taller).

    -   Node.js 20.19+ (ó 22.x).

        - Vite no compila con Node 18.

    -   Composer y npm instalados.

--------------------------
////////////////////////////
🚀 INSTALACION Y ARRANQUE
# 1) Clonar
git clone <URL-del-repo> taller-servicios
cd taller-servicios

# 2) Variables de entorno
cp .env.example .env
# Edita .env con tus credenciales:
# DB_DATABASE=taller
# DB_USERNAME=tu_usuario
# DB_PASSWORD=tu_password
# Sugerido para este proyecto:
# SESSION_DRIVER=database
# CACHE_DRIVER=database

# 3) Dependencias PHP
composer install

# 4) Key de la app
php artisan key:generate

# 5) Tablas para sesión y caché (si usas 'database')
php artisan session:table
php artisan cache:table

# 6) Migraciones (y, si existen, seeders)
php artisan migrate
# php artisan db:seed   # (opcional, si hay seeders)

# 7) Dependencias JS y assets
npm install
npm run dev        # entorno de desarrollo (con Vite)
# npm run build    # compilación para producción

# 8) Servidor de desarrollo
php artisan serve
Abre: http://127.0.0.1:8000


-----------------------------------
///////////////////////////////////
🧭 NAVEGACION RAPIDA (rutas útiles)

Dashboard: /

Clientes: /clients

Dispositivos: /devices

Estados: /service-statuses

Servicios: /services

Ítems del servicio: /services/{service}/items
(ej.: /services/1/items)

Algoritmos (demo):

Factorial: /algoritmos/factorial

Amortización: /algoritmos/amortizacion

Binomio: /algoritmos/binomio

El menú lateral de AdminLTE ya apunta a estos módulos (configurable en config/adminlte.php, clave menu).

------------------------------
🏃‍♂️ FLUJO DE USO RECOMENDADO
------------------------------

Crear estados de servicio (p. ej. Recibido, Reparando, Finalizado, Entregado).

Registrar clientes.

Registrar dispositivos y vincularlos a los clientes.

Crear un servicio: seleccionar cliente y dispositivo, ingresar fecha de recepción, problema reportado, estado y (opcional) técnico.

Dentro del servicio, agregar ítems (repuestos/mano de obra) para calcular costos.

Actualizar el estado a medida que avance la reparación.

------------------------------
///////////////////////////////
🗄️ ESQUEMA DE DATOS (resumen)

    - clients — datos del cliente.

    - devices — pertenece a clients; referencia a tipo y marca (según tus catálogos).

    - service_statuses — catálogo de estados.

    - services — pertenece a clients, devices, service_statuses; folio, problema, diagnóstico, solución, técnico.

    - service_items — pertenece a services; description, quantity, unit_price, notes.

    - service_status_histories — historial de cambios de estado.

    - users — técnicos/operadores (si lo usas con login y roles).

------------------------------------------------
//////////////////////////////////////////////
    ⚙️ CONFIGURACION DE ADMINLTE

Ruta de inicio (dashboard): configurada a / en routes/web.php.

Menú lateral y título del panel: config/adminlte.php (clave menu y title).

Si quieres ocultar/mostrar módulos, edita ese archivo.


----------------------
//////////////////////
ℹ️ NOTAS Y CONSEJOS

Separadores decimales: el sistema normaliza comas/puntos (24,00 ↔ 24.00) al guardar ítems.

Sesiones y caché en DB: si en .env usas SESSION_DRIVER=database y/o CACHE_DRIVER=database, recuerda crear sus tablas (paso 5).

Prod: usa npm run build y configura un servidor web (Nginx/Apache) apuntando a public/.

----------------------
🧪 Troubleshooting
----------------------

Vite/Node error: “Vite requires Node.js >=20.19 or >=22”
→ Instala Node 20.19+ o 22.x y vuelve a correr npm install && npm run dev.

419 Page Expired en formularios → verifica APP_URL en .env y limpia caché con php artisan optimize:clear.

Tabla sessions/cache no existe → ejecuta php artisan session:table && php artisan cache:table && php artisan migrate.



//////////////////////////////////////////////
" Si puedes imaginarlo, Puedes programarlo..."
/////////////////////////////////////////////