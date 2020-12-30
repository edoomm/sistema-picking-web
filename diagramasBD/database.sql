DROP DATABASE pickingdb;

CREATE DATABASE pickingdb;

USE pickingdb;

CREATE TABLE `Operador` (
    `num_empleado` VARCHAR(6) NOT NULL,
    `nombre` VARCHAR(50) NOT NULL,
    `correo` VARCHAR(50),
    PRIMARY KEY (`num_empleado`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Se creara un usuario para los lideres del almacen, hasta el momento solo se tiene un tipo de usuario (1:Lider), no es necesario crear usaurios por operadores

CREATE TABLE `Usuario` (
    `operador_num_empleado` VARCHAR(6) NOT NULL,
    `usuario` VARCHAR(20),
    `contrasena` VARCHAR(20),
    `tipo_usuario` INT NOT NULL, -- 1: Lider de almacen
    PRIMARY KEY (`operador_num_empleado`),
    FOREIGN KEY (`operador_num_empleado`) REFERENCES `Operador` (`num_empleado`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `Reporte` (
    `reporte_id` INT NOT NULL AUTO_INCREMENT,
    `operador_num_empleado` VARCHAR(6) NOT NULL,
    `reporte` TEXT NOT NULL,
    `fecha` DATETIME NOT NULL,
    PRIMARY KEY (`reporte_id`),
    FOREIGN KEY (`operador_num_empleado`) REFERENCES `Operador` (`num_empleado`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `Dispositivo` (
    `dispositivo_id` VARCHAR(17) NOT NULL,
    `operador_num_empleado` VARCHAR(6),
    `tipo` VARCHAR(15),
    `activo` BOOLEAN,
    PRIMARY KEY (`dispositivo_id`),
    FOREIGN KEY (`operador_num_empleado`) REFERENCES `Operador` (`num_empleado`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `Producto` (
    `sku` INT NOT NULL,
    `id_linea` VARCHAR(3) NOT NULL,
    `generico` CHAR(1) NOT NULL,
    `unidad_medida` INT NOT NULL, -- 1:Para aquellos que no tengan UM
    `descripcion` VARCHAR(50),
    PRIMARY KEY (`sku`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `Ubicacion` (
    `ubicacion` VARCHAR(11) NOT NULL,
    `sku` INT NOT NULL,
    `pasillo` CHAR(1) NOT NULL,
    `rack` TINYINT NOT NULL,
    `columna` TINYINT NOT NULL,
    `nivel` TINYINT NOT NULL,
    PRIMARY KEY (`ubicacion`),
    FOREIGN KEY (`sku`) REFERENCES `Producto` (`sku`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE Contenedor (
    `contenedor_id` INT NOT NULL,
    `medida` INT,
    `estado` BOOLEAN,
    `ubicacion` VARCHAR(15),
    PRIMARY KEY (`contenedor_id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `Control` (
    `control_id` INT NOT NULL AUTO_INCREMENT,
    `sku` INT NOT NULL,
    `numero_control` INT NOT NULL,
    `id_sucursal` INT NOT NULL,
    `apartado` INT NOT NULL, -- Cantidad que pide la sucursal del sku
    `asignado` BOOLEAN NOT NULL DEFAULT 0,
    PRIMARY KEY (`control_id`),
    FOREIGN KEY (`sku`) REFERENCES `Producto` (`sku`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `Operador_has_control` (
    `control_id` INT NOT NULL,
    `num_empleado` VARCHAR(6) NOT NULL,
    `contenedor_id` INT NOT NULL,
    `prioridad` INT NOT NULL,
    FOREIGN KEY (`control_id`) REFERENCES `Control` (`control_id`),
    FOREIGN KEY (`num_empleado`) REFERENCES `Operador` (`num_empleado`),
    FOREIGN KEY (`contenedor_id`) REFERENCES `Contenedor` (`contenedor_id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `Transaccion` (
    `transaccion_id` INT NOT NULL AUTO_INCREMENT,
    `num_empleado` VARCHAR(6) NOT NULL,
    `contenedor_id` INT NOT NULL,
    `sku` INT NOT NULL,
    `control_id` INT NOT NULL,
    `hora_realizada` DATETIME NOT NULL,
    `tipo_movimiento` CHAR(2) NOT NULL, -- P:Pickup; SA: Surte Almacen; R:Reabasto
    `cantidad` INT NOT NULL, -- cantidad > 0 : reabasto ; cabtudad < 0 p | sa
    PRIMARY KEY (`transaccion_id`),
    FOREIGN KEY (`num_empleado`) REFERENCES `Operador` (`num_empleado`),
    FOREIGN KEY (`contenedor_id`) REFERENCES `Contenedor` (`contenedor_id`),
    FOREIGN KEY (`sku`) REFERENCES `Producto` (`sku`),
    FOREIGN KEY (`control_id`) REFERENCES `Control` (`control_id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
