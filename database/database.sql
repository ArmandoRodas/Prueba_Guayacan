SET NAMES utf8mb4;
SET time_zone = "+00:00";
SET foreign_key_checks = 0;

-- ---------------------------------------------------------
-- USERS (técnicos y personal)
-- ---------------------------------------------------------
CREATE TABLE `users` (
  `id`            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID (clave primaria)',
  `name`          VARCHAR(120) NOT NULL COMMENT 'Nombre completo',
  `email`         VARCHAR(190) NULL UNIQUE COMMENT 'Correo electrónico (único)',
  `phone`         VARCHAR(30)  NULL COMMENT 'Teléfono',
  `role`          ENUM('technician','admin','frontdesk') NOT NULL DEFAULT 'technician' COMMENT 'Rol del usuario (technician= técnico, admin= administrador, frontdesk= recepción)',
  `is_active`     TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Activo (1 sí / 0 no)',
  `created_at`    TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Creado en',
  `updated_at`    TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Actualizado en',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Usuarios / Técnicos';

-- ---------------------------------------------------------
-- CLIENTS (clientes)
-- ---------------------------------------------------------
CREATE TABLE `clients` (
  `id`            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID (clave primaria)',
  `first_name`    VARCHAR(120) NOT NULL COMMENT 'Nombres',
  `last_name`     VARCHAR(120) NULL COMMENT 'Apellidos',
  `tax_id`        VARCHAR(30)  NULL COMMENT 'DPI/NIT u otro identificador fiscal',
  `phone`         VARCHAR(30)  NULL COMMENT 'Teléfono',
  `email`         VARCHAR(190) NULL COMMENT 'Correo electrónico',
  `address`       VARCHAR(255) NULL COMMENT 'Dirección',
  `created_at`    TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Creado en',
  `updated_at`    TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Actualizado en',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Clientes';

-- ---------------------------------------------------------
-- BRANDS (marcas)
-- ---------------------------------------------------------
CREATE TABLE `brands` (
  `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID (clave primaria)',
  `name`          VARCHAR(80) NOT NULL COMMENT 'Nombre de la marca',
  `created_at`    TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Creado en',
  `updated_at`    TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Actualizado en',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_brands_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Marcas';

-- ---------------------------------------------------------
-- DEVICE TYPES (tipos de equipo)
-- ---------------------------------------------------------
CREATE TABLE `device_types` (
  `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID (clave primaria)',
  `name`          VARCHAR(60) NOT NULL COMMENT 'Nombre del tipo (laptop, smartphone, PC, impresora, etc.)',
  `created_at`    TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Creado en',
  `updated_at`    TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Actualizado en',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_device_types_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Catálogo de tipos de equipo';

-- ---------------------------------------------------------
-- DEVICES (equipos del cliente)
-- ---------------------------------------------------------
CREATE TABLE `devices` (
  `id`              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID (clave primaria)',
  `client_id`       BIGINT UNSIGNED NOT NULL COMMENT 'FK al cliente propietario',
  `device_type_id`  INT UNSIGNED    NOT NULL COMMENT 'FK al tipo de equipo',
  `brand_id`        INT UNSIGNED    NULL COMMENT 'FK a la marca',
  `model`           VARCHAR(120)    NULL COMMENT 'Modelo del equipo',
  `serial_number`   VARCHAR(120)    NULL COMMENT 'Número de serie',
  `imei`            VARCHAR(20)     NULL COMMENT 'IMEI (si aplica para smartphone)',
  `accessories`     VARCHAR(255)    NULL COMMENT 'Accesorios recibidos (cargador, cable, funda, etc.)',
  `notes`           TEXT            NULL COMMENT 'Observaciones del equipo',
  `created_at`      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Creado en',
  `updated_at`      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Actualizado en',
  PRIMARY KEY (`id`),
  KEY `idx_devices_client_id` (`client_id`),
  KEY `idx_devices_device_type_id` (`device_type_id`),
  KEY `idx_devices_brand_id` (`brand_id`),
  KEY `idx_devices_serial_number` (`serial_number`),
  KEY `idx_devices_imei` (`imei`),
  CONSTRAINT `fk_devices_client`      FOREIGN KEY (`client_id`)      REFERENCES `clients` (`id`)      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_devices_device_type` FOREIGN KEY (`device_type_id`) REFERENCES `device_types` (`id`)  ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_devices_brand`       FOREIGN KEY (`brand_id`)       REFERENCES `brands` (`id`)       ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Equipos registrados por cliente';

-- ---------------------------------------------------------
-- SERVICE STATUSES (catálogo de estados de servicio)
-- ---------------------------------------------------------
CREATE TABLE `service_statuses` (
  `id`          SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID (clave primaria)',
  `code`        VARCHAR(40)  NOT NULL COMMENT 'Código del estado (RECIBEDO, DIAGNOSING, REPAIRING, FINISHED, DELIVERED, CANCELED)',
  `label`       VARCHAR(120) NOT NULL COMMENT 'Descripción del estado',
  `is_final`    TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Es un estado final (1 sí / 0 no)',
  `sort_order`  SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Orden para flujos',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_service_statuses_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Catálogo de estados del servicio';

-- ---------------------------------------------------------
-- SERVICES (órdenes / atenciones de reparación)
-- ---------------------------------------------------------
CREATE TABLE `services` (
  `id`                   BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID (clave primaria)',
  `folio`                VARCHAR(30)  NOT NULL COMMENT 'Folio / Código interno de la orden (único)',
  `client_id`            BIGINT UNSIGNED NOT NULL COMMENT 'FK al cliente',
  `device_id`            BIGINT UNSIGNED NOT NULL COMMENT 'FK al equipo atendido',
  `assigned_tech_id`     BIGINT UNSIGNED NULL COMMENT 'FK al técnico asignado',
  `received_at`          DATETIME NOT NULL COMMENT 'Fecha y hora de recepción',
  `reported_issue`       TEXT NOT NULL COMMENT 'Problema reportado por el cliente',
  `diagnosis`            TEXT NULL COMMENT 'Diagnóstico del técnico',
  `solution`             TEXT NULL COMMENT 'Solución / trabajo realizado',
  `estimated_cost`       DECIMAL(10,2) NULL COMMENT 'Costo estimado',
  `final_cost`           DECIMAL(10,2) NULL COMMENT 'Costo final',
  `warranty_days`        SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Días de garantía',
  `delivered_at`         DATETIME NULL COMMENT 'Fecha y hora de entrega',
  `current_status_id`    SMALLINT UNSIGNED NOT NULL COMMENT 'FK al estado actual',
  `notes`                TEXT NULL COMMENT 'Notas adicionales',
  `created_at`           TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Creado en',
  `updated_at`           TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Actualizado en',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_services_folio` (`folio`),
  KEY `idx_services_client_id` (`client_id`),
  KEY `idx_services_device_id` (`device_id`),
  KEY `idx_services_assigned_tech_id` (`assigned_tech_id`),
  KEY `idx_services_current_status_id` (`current_status_id`),
  KEY `idx_services_received_at` (`received_at`),
  CONSTRAINT `fk_services_client`        FOREIGN KEY (`client_id`)         REFERENCES `clients` (`id`)           ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_services_device`        FOREIGN KEY (`device_id`)         REFERENCES `devices` (`id`)           ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_services_user`          FOREIGN KEY (`assigned_tech_id`)  REFERENCES `users` (`id`)             ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT `fk_services_status`        FOREIGN KEY (`current_status_id`) REFERENCES `service_statuses` (`id`)   ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Servicios / Órdenes de reparación';

-- ---------------------------------------------------------
-- SERVICE STATUS HISTORY (bitácora de cambios de estado)
-- ---------------------------------------------------------
CREATE TABLE `service_status_history` (
  `id`            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID (clave primaria)',
  `service_id`    BIGINT UNSIGNED NOT NULL COMMENT 'FK al servicio',
  `status_id`     SMALLINT UNSIGNED NOT NULL COMMENT 'FK al estado aplicado',
  `changed_by_id` BIGINT UNSIGNED NULL COMMENT 'FK al usuario que realizó el cambio',
  `comment`       TEXT NULL COMMENT 'Comentario del cambio de estado',
  `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha/hora del cambio',
  PRIMARY KEY (`id`),
  KEY `idx_hist_service_created` (`service_id`, `created_at`),
  KEY `idx_hist_status_id` (`status_id`),
  CONSTRAINT `fk_hist_service`  FOREIGN KEY (`service_id`)  REFERENCES `services` (`id`)          ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `fk_hist_status`   FOREIGN KEY (`status_id`)   REFERENCES `service_statuses` (`id`)  ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_hist_user`     FOREIGN KEY (`changed_by_id`) REFERENCES `users` (`id`)           ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Historial de estados del servicio';

-- ---------------------------------------------------------
-- SERVICE ITEMS (piezas y mano de obra)
-- ---------------------------------------------------------
CREATE TABLE `service_items` (
  `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID (clave primaria)',
  `service_id`     BIGINT UNSIGNED NOT NULL COMMENT 'FK al servicio',
  `kind`           ENUM('part','labor','other') NOT NULL COMMENT 'Tipo de ítem (part= pieza, labor= mano de obra, other= otro)',
  `description`    VARCHAR(200) NOT NULL COMMENT 'Descripción del ítem',
  `quantity`       DECIMAL(10,2) NOT NULL DEFAULT 1 COMMENT 'Cantidad',
  `unit_price`     DECIMAL(10,2) NOT NULL DEFAULT 0 COMMENT 'Precio unitario',
  `subtotal`       DECIMAL(10,2) GENERATED ALWAYS AS (`quantity` * `unit_price`) STORED COMMENT 'Subtotal calculado',
  `created_at`     TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Creado en',
  `updated_at`     TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Actualizado en',
  PRIMARY KEY (`id`),
  KEY `idx_items_service_id` (`service_id`),
  CONSTRAINT `fk_items_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Ítems del servicio (piezas/mano de obra)';

SET foreign_key_checks = 1;
