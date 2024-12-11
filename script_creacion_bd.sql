-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema sgsi_vetlab
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema sgsi_vetlab
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sgsi_vetlab` DEFAULT CHARACTER SET utf8 ;
USE `sgsi_vetlab` ;

-- -----------------------------------------------------
-- Table `sgsi_vetlab`.`credenciales`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sgsi_vetlab`.`credenciales` (
  `ID` INT(11) NOT NULL,
  `Usuario` VARCHAR(150) NOT NULL,
  `Contrasenha` VARCHAR(150) NOT NULL,
  `Tipo_Usuario` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sgsi_vetlab`.`administrador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sgsi_vetlab`.`administrador` (
  `ID` INT(11) NOT NULL,
  `Nombre` VARCHAR(150) NOT NULL,
  `ID_Credenciales` INT(11) NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_Administrador_Credenciales1_idx` (`ID_Credenciales` ASC) ,
  CONSTRAINT `fk_Administrador_Credenciales1`
    FOREIGN KEY (`ID_Credenciales`)
    REFERENCES `sgsi_vetlab`.`credenciales` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sgsi_vetlab`.`area`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sgsi_vetlab`.`area` (
  `ID` INT(11) NOT NULL,
  `Area` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sgsi_vetlab`.`perfil_muestra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sgsi_vetlab`.`perfil_muestra` (
  `ID` INT(11) NOT NULL,
  `Tipo_de_muestra` VARCHAR(150) NOT NULL,
  `ID_Area` INT(11) NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_Perfil_muestra_Area1_idx` (`ID_Area` ASC) ,
  CONSTRAINT `fk_Perfil_muestra_Area1`
    FOREIGN KEY (`ID_Area`)
    REFERENCES `sgsi_vetlab`.`area` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sgsi_vetlab`.`insumo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sgsi_vetlab`.`insumo` (
  `ID` INT(11) NOT NULL,
  `Nombre` VARCHAR(150) NOT NULL,
  `Cantidad` FLOAT NOT NULL,
  `Stock_minimo` FLOAT NOT NULL,
  `ID_Area` INT(11) NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_insumo_area1_idx` (`ID_Area` ASC) ,
  CONSTRAINT `fk_insumo_area1`
    FOREIGN KEY (`ID_Area`)
    REFERENCES `sgsi_vetlab`.`area` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sgsi_vetlab`.`componentes_perfil_muestra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sgsi_vetlab`.`componentes_perfil_muestra` (
  `ID_Componentes_perfil_muestra` INT(11) NOT NULL,
  `Cantidad` FLOAT NOT NULL,
  `ID_Muestra` INT(11) NOT NULL,
  `ID_Insumo` INT(11) NOT NULL,
  PRIMARY KEY (`ID_Componentes_perfil_muestra`),
  INDEX `fk_Componentes_perfil_muestra_Perfil_muestra1_idx` (`ID_Muestra` ASC) ,
  INDEX `fk_componentes_perfil_muestra_insumo1_idx` (`ID_Insumo` ASC) ,
  CONSTRAINT `fk_Componentes_perfil_muestra_Perfil_muestra1`
    FOREIGN KEY (`ID_Muestra`)
    REFERENCES `sgsi_vetlab`.`perfil_muestra` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_componentes_perfil_muestra_insumo1`
    FOREIGN KEY (`ID_Insumo`)
    REFERENCES `sgsi_vetlab`.`insumo` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sgsi_vetlab`.`empleado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sgsi_vetlab`.`empleado` (
  `ID` INT(11) NOT NULL,
  `Nombre` VARCHAR(150) NOT NULL,
  `ID_Credenciales` INT(11) NOT NULL,
  `ID_Area` INT(11) NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_Empleado_Credenciales1_idx` (`ID_Credenciales` ASC) ,
  INDEX `fk_Empleado_Area1_idx` (`ID_Area` ASC) ,
  CONSTRAINT `fk_Empleado_Area1`
    FOREIGN KEY (`ID_Area`)
    REFERENCES `sgsi_vetlab`.`area` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Empleado_Credenciales1`
    FOREIGN KEY (`ID_Credenciales`)
    REFERENCES `sgsi_vetlab`.`credenciales` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sgsi_vetlab`.`proveedor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sgsi_vetlab`.`proveedor` (
  `ID` INT(11) NOT NULL,
  `RUT` VARCHAR(150) NOT NULL,
  `Nombre` VARCHAR(150) NOT NULL,
  `Correo` VARCHAR(150) NOT NULL,
  `Telefono` VARCHAR(150) NOT NULL,
  `Direccion` VARCHAR(150) NOT NULL,
  `Comuna` VARCHAR(150) NOT NULL,
  `Ciudad` VARCHAR(150) NOT NULL,
  `Giro` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sgsi_vetlab`.`Provee`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sgsi_vetlab`.`Provee` (
  `ID_Provee` INT NOT NULL,
  `Codigo_Insumo` VARCHAR(45) NOT NULL,
  `Precio` FLOAT NOT NULL,
  `Descripcion` VARCHAR(150) NOT NULL,
  `Presentacion` VARCHAR(150) NOT NULL,
  `Cantidad` FLOAT NOT NULL,
  `ID_Area` INT(11) NOT NULL,
  `ID_Proveedor` INT(11) NOT NULL,
  `ID_Insumo` INT(11) NOT NULL,
  PRIMARY KEY (`ID_Provee`),
  INDEX `fk_Provee_area1_idx` (`ID_Area` ASC) ,
  INDEX `fk_Provee_proveedor1_idx` (`ID_Proveedor` ASC) ,
  INDEX `fk_Provee_insumo1_idx` (`ID_Insumo` ASC) ,
  CONSTRAINT `fk_Provee_area1`
    FOREIGN KEY (`ID_Area`)
    REFERENCES `sgsi_vetlab`.`area` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Provee_proveedor1`
    FOREIGN KEY (`ID_Proveedor`)
    REFERENCES `sgsi_vetlab`.`proveedor` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Provee_insumo1`
    FOREIGN KEY (`ID_Insumo`)
    REFERENCES `sgsi_vetlab`.`insumo` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgsi_vetlab`.`insumo_usado_empleado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sgsi_vetlab`.`insumo_usado_empleado` (
  `ID_Insumo_Empleado` INT(11) NOT NULL,
  `Codigo_unico` VARCHAR(45) NOT NULL,
  `Cantidad` FLOAT NOT NULL,
  `Fecha` DATE NOT NULL,
  `ID_Empleado` INT(11) NOT NULL,
  `ID_Provee` INT NOT NULL,
  PRIMARY KEY (`ID_Insumo_Empleado`),
  INDEX `fk_insumo_usado_empleado_empleado1_idx` (`ID_Empleado` ASC) ,
  INDEX `fk_insumo_usado_empleado_Provee1_idx` (`ID_Provee` ASC) ,
  CONSTRAINT `fk_insumo_usado_empleado_empleado1`
    FOREIGN KEY (`ID_Empleado`)
    REFERENCES `sgsi_vetlab`.`empleado` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_insumo_usado_empleado_Provee1`
    FOREIGN KEY (`ID_Provee`)
    REFERENCES `sgsi_vetlab`.`Provee` (`ID_Provee`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sgsi_vetlab`.`orden_de_compra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sgsi_vetlab`.`orden_de_compra` (
  `Num_Orden_de_Compra` INT(11) NOT NULL,
  `Fecha` DATE NOT NULL,
  `ID_Administrador` INT(11) NOT NULL,
  `ID_Proveedor` INT(11) NOT NULL,
  PRIMARY KEY (`Num_Orden_de_Compra`),
  INDEX `fk_Orden_de_compra_Administrador1_idx` (`ID_Administrador` ASC) ,
  INDEX `fk_Orden_de_compra_Proveedor1_idx` (`ID_Proveedor` ASC) ,
  CONSTRAINT `fk_Orden_de_compra_Administrador1`
    FOREIGN KEY (`ID_Administrador`)
    REFERENCES `sgsi_vetlab`.`administrador` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Orden_de_compra_Proveedor1`
    FOREIGN KEY (`ID_Proveedor`)
    REFERENCES `sgsi_vetlab`.`proveedor` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sgsi_vetlab`.`registro_insumo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sgsi_vetlab`.`registro_insumo` (
  `ID_Registro_Insumo` INT(11) NOT NULL,
  `Codigo_unico` VARCHAR(45) NOT NULL,
  `Numero_lote` VARCHAR(45) NOT NULL,
  `Fecha_recibo` DATE NOT NULL,
  `Fecha_vencimiento` DATE NOT NULL,
  `Cantidad` INT NOT NULL,
  `Cantidad_actual` FLOAT NOT NULL,
  `ID_Administrador` INT(11) NOT NULL,
  `ID_Provee` INT NOT NULL,
  PRIMARY KEY (`ID_Registro_Insumo`),
  INDEX `fk_Registro_de_insumo_Administrador1_idx` (`ID_Administrador` ASC) ,
  INDEX `fk_registro_insumo_Provee1_idx` (`ID_Provee` ASC) ,
  CONSTRAINT `fk_Registro_de_insumo_Administrador1`
    FOREIGN KEY (`ID_Administrador`)
    REFERENCES `sgsi_vetlab`.`administrador` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_insumo_Provee1`
    FOREIGN KEY (`ID_Provee`)
    REFERENCES `sgsi_vetlab`.`Provee` (`ID_Provee`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sgsi_vetlab`.`registro_orden_de_compra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sgsi_vetlab`.`registro_orden_de_compra` (
  `Num_Registro_Orden_de_Compra` INT(11) NOT NULL,
  `Cantidad` INT(11) NOT NULL,
  `Precio_unitario` FLOAT NOT NULL,
  `ID_Orden_Compra` INT(11) NOT NULL,
  `ID_Provee` INT NOT NULL,
  PRIMARY KEY (`Num_Registro_Orden_de_Compra`),
  INDEX `fk_Registro_orden_de_compra_Orden_de_compra1_idx` (`ID_Orden_Compra` ASC) ,
  INDEX `fk_registro_orden_de_compra_Provee1_idx` (`ID_Provee` ASC) ,
  CONSTRAINT `fk_Registro_orden_de_compra_Orden_de_compra1`
    FOREIGN KEY (`ID_Orden_Compra`)
    REFERENCES `sgsi_vetlab`.`orden_de_compra` (`Num_Orden_de_Compra`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_orden_de_compra_Provee1`
    FOREIGN KEY (`ID_Provee`)
    REFERENCES `sgsi_vetlab`.`Provee` (`ID_Provee`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sgsi_vetlab`.`Mantiene_Empleado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sgsi_vetlab`.`Mantiene_Empleado` (
  `ID_Mantener` INT NOT NULL,
  `Fecha` DATE NOT NULL,
  `Accion` VARCHAR(150) NOT NULL,
  `ID_Administrador` INT(11) NOT NULL,
  `ID_Empleado` INT(11) NOT NULL,
  PRIMARY KEY (`ID_Mantener`),
  INDEX `fk_Mantiene_Empleado_administrador1_idx` (`ID_Administrador` ASC) ,
  INDEX `fk_Mantiene_Empleado_empleado1_idx` (`ID_Empleado` ASC) ,
  CONSTRAINT `fk_Mantiene_Empleado_administrador1`
    FOREIGN KEY (`ID_Administrador`)
    REFERENCES `sgsi_vetlab`.`administrador` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Mantiene_Empleado_empleado1`
    FOREIGN KEY (`ID_Empleado`)
    REFERENCES `sgsi_vetlab`.`empleado` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgsi_vetlab`.`Mantiene_Insumo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sgsi_vetlab`.`Mantiene_Insumo` (
  `ID_Mantener` INT NOT NULL,
  `Fecha` DATE NOT NULL,
  `Accion` VARCHAR(150) NOT NULL,
  `ID_Administrador` INT(11) NOT NULL,
  `ID_Insumo` INT(11) NOT NULL,
  PRIMARY KEY (`ID_Mantener`),
  INDEX `fk_Mantiene_Insumo_administrador1_idx` (`ID_Administrador` ASC) ,
  INDEX `fk_Mantiene_Insumo_insumo1_idx` (`ID_Insumo` ASC) ,
  CONSTRAINT `fk_Mantiene_Insumo_administrador1`
    FOREIGN KEY (`ID_Administrador`)
    REFERENCES `sgsi_vetlab`.`administrador` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Mantiene_Insumo_insumo1`
    FOREIGN KEY (`ID_Insumo`)
    REFERENCES `sgsi_vetlab`.`insumo` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgsi_vetlab`.`Mantiene_Perfil_Muestra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sgsi_vetlab`.`Mantiene_Perfil_Muestra` (
  `ID_Mantener` INT NOT NULL,
  `Fecha` DATE NOT NULL,
  `Accion` VARCHAR(150) NOT NULL,
  `ID_Administrador` INT(11) NOT NULL,
  `ID_Muestra` INT(11) NOT NULL,
  PRIMARY KEY (`ID_Mantener`),
  INDEX `fk_Mantiene_Perfil_Muestra_administrador_idx` (`ID_Administrador` ASC) ,
  INDEX `fk_Mantiene_Perfil_Muestra_perfil_muestra1_idx` (`ID_Muestra` ASC) ,
  CONSTRAINT `fk_Mantiene_Perfil_Muestra_administrador`
    FOREIGN KEY (`ID_Administrador`)
    REFERENCES `sgsi_vetlab`.`administrador` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Mantiene_Perfil_Muestra_perfil_muestra1`
    FOREIGN KEY (`ID_Muestra`)
    REFERENCES `sgsi_vetlab`.`perfil_muestra` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgsi_vetlab`.`Mantiene_Proveedor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sgsi_vetlab`.`Mantiene_Proveedor` (
  `ID_Mantener` INT NOT NULL,
  `Fecha` DATE NOT NULL,
  `Accion` VARCHAR(150) NOT NULL,
  `ID_Administrador` INT(11) NOT NULL,
  `ID_Proveedor` INT(11) NOT NULL,
  PRIMARY KEY (`ID_Mantener`),
  INDEX `fk_Mantiene_Proveedor_administrador1_idx` (`ID_Administrador` ASC) ,
  INDEX `fk_Mantiene_Proveedor_proveedor1_idx` (`ID_Proveedor` ASC) ,
  CONSTRAINT `fk_Mantiene_Proveedor_administrador1`
    FOREIGN KEY (`ID_Administrador`)
    REFERENCES `sgsi_vetlab`.`administrador` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Mantiene_Proveedor_proveedor1`
    FOREIGN KEY (`ID_Proveedor`)
    REFERENCES `sgsi_vetlab`.`proveedor` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgsi_vetlab`.`Mantiene_Provee`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sgsi_vetlab`.`Mantiene_Provee` (
  `ID_Mantener` INT NOT NULL,
  `Fecha` DATE NOT NULL,
  `Accion` VARCHAR(150) NOT NULL,
  `ID_Administrador` INT(11) NOT NULL,
  `ID_Provee` INT NOT NULL,
  INDEX `fk_Mantiene_Provee_administrador1_idx` (`ID_Administrador` ASC) ,
  INDEX `fk_Mantiene_Provee_Provee1_idx` (`ID_Provee` ASC) ,
  PRIMARY KEY (`ID_Mantener`),
  CONSTRAINT `fk_Mantiene_Provee_administrador1`
    FOREIGN KEY (`ID_Administrador`)
    REFERENCES `sgsi_vetlab`.`administrador` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Mantiene_Provee_Provee1`
    FOREIGN KEY (`ID_Provee`)
    REFERENCES `sgsi_vetlab`.`Provee` (`ID_Provee`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
