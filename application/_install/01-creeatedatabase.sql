SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `gymdb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `gymdb` ;

-- -----------------------------------------------------
-- Table `gymdb`.`persona`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gymdb`.`persona` ;

CREATE  TABLE IF NOT EXISTS `gymdb`.`persona` (
  `idpersona` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(100) NOT NULL ,
  `apaterno` VARCHAR(50) NOT NULL ,
  `amaterno` VARCHAR(50) NULL ,
  `direccion` TEXT NULL ,
  `telefono` VARCHAR(45) NULL ,
  `email` VARCHAR(45) NULL ,
  `contacto` VARCHAR(100) NULL ,
  `contactotelefono` VARCHAR(45) NULL ,
  `fecharegistro` DATE NOT NULL ,
  `fechainscripcion` DATE NULL ,
  `montoinscripcion` DECIMAL(10,2) NULL ,
  `inscrito` TINYINT NOT NULL DEFAULT 0 COMMENT '0=no\n1=si' ,
  `activo` TINYINT NOT NULL DEFAULT 0 COMMENT '0=no\n1=si' ,
  PRIMARY KEY (`idpersona`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gymdb`.`paquete`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gymdb`.`paquete` ;

CREATE  TABLE IF NOT EXISTS `gymdb`.`paquete` (
  `idpaquete` INT NOT NULL AUTO_INCREMENT ,
  `titulo` VARCHAR(45) NOT NULL ,
  `costo` DECIMAL(10,2) NOT NULL ,
  `descripcion` TEXT NULL ,
  PRIMARY KEY (`idpaquete`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gymdb`.`pago`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gymdb`.`pago` ;

CREATE  TABLE IF NOT EXISTS `gymdb`.`pago` (
  `idpago` INT NOT NULL AUTO_INCREMENT ,
  `idpersona` INT NOT NULL ,
  `idpaquete` INT NOT NULL ,
  `fecha` DATE NOT NULL ,
  `monto` DECIMAL(10,2) NOT NULL ,
  `descuento` INT NOT NULL ,
  `comentarios` TEXT NULL DEFAULT '' ,
  PRIMARY KEY (`idpago`) ,
  INDEX `fk_pago_persona_idx` (`idpersona` ASC) ,
  INDEX `fk_pago_paquete1_idx` (`idpaquete` ASC) ,
  CONSTRAINT `fk_pago_persona`
    FOREIGN KEY (`idpersona` )
    REFERENCES `gymdb`.`persona` (`idpersona` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pago_paquete1`
    FOREIGN KEY (`idpaquete` )
    REFERENCES `gymdb`.`paquete` (`idpaquete` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gymdb`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gymdb`.`usuario` ;

CREATE  TABLE IF NOT EXISTS `gymdb`.`usuario` (
  `idusuario` INT NOT NULL AUTO_INCREMENT ,
  `cuenta` VARCHAR(45) NOT NULL ,
  `password` VARCHAR(256) NOT NULL ,
  PRIMARY KEY (`idusuario`) )
ENGINE = InnoDB;

USE `gymdb` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
