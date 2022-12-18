-- MySQL Workbench Synchronization
-- Generated: 2021-03-19 15:26
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Daniel Soesanto

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE TABLE IF NOT EXISTS `mahasiswas` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(45) NOT NULL,
  `nrp` VARCHAR(10) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `matakuliahs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(45) NOT NULL,
  `jurusanss_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_matakuliahs_jurusanss1_idx` (`jurusanss_id` ASC),
  CONSTRAINT `fk_matakuliahs_jurusanss1`
    FOREIGN KEY (`jurusanss_id`)
    REFERENCES `jurusanss` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `jadwals` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `hari` VARCHAR(45) NOT NULL,
  `jam_mulai` VARCHAR(45) NOT NULL,
  `jam_selesai` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `matakuliahs_buka` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `kp` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `matakuliahs_kp` (
  `matakuliahs_id` INT(11) NOT NULL,
  `matakuliahs_buka_id` INT(11) NOT NULL,
  `dosen_id` INT(11) NOT NULL,
  `kapasitas` VARCHAR(45) NOT NULL,
  `status` ENUM('Available', 'Unavailable') NOT NULL DEFAULT 'Unavailable',
  `kode` VARCHAR(8) NOT NULL,
  PRIMARY KEY (`matakuliahs_id`, `matakuliahs_buka_id`, `dosen_id`),
  INDEX `fk_matakuliahs_has_matakuliahs_buka_matakuliahs_buka1_idx` (`matakuliahs_buka_id` ASC),
  INDEX `fk_matakuliahs_has_matakuliahs_buka_matakuliahs1_idx` (`matakuliahs_id` ASC),
  INDEX `fk_matakuliahs_kp_dosen1_idx` (`dosen_id` ASC),
  CONSTRAINT `fk_matakuliahs_has_matakuliahs_buka_matakuliahs1`
    FOREIGN KEY (`matakuliahs_id`)
    REFERENCES `matakuliahs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_matakuliahs_has_matakuliahs_buka_matakuliahs_buka1`
    FOREIGN KEY (`matakuliahs_buka_id`)
    REFERENCES `matakuliahs_buka` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_matakuliahs_kp_dosen1`
    FOREIGN KEY (`dosen_id`)
    REFERENCES `dosen` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `jadwal_matakuliahs` (
  `matakuliahs_id` INT(11) NOT NULL AUTO_INCREMENT,
  `matakuliahs_buka_id` INT(11) NOT NULL,
  `jadwals_id` INT(11) NOT NULL,
  `tanggal` DATETIME NOT NULL,
  `kode` VARCHAR(8) NOT NULL,
  PRIMARY KEY (`matakuliahs_id`, `matakuliahs_buka_id`, `jadwals_id`),
  INDEX `fk_matakuliahs_has_matakuliahs_buka_has_jadwals_jadwals1_idx` (`jadwals_id` ASC),
  INDEX `fk_matakuliahs_has_matakuliahs_buka_has_jadwals_matakuliahs_idx` (`matakuliahs_id` ASC, `matakuliahs_buka_id` ASC),
  CONSTRAINT `fk_matakuliahs_has_matakuliahs_buka_has_jadwals_matakuliahs_h1`
    FOREIGN KEY (`matakuliahs_id` , `matakuliahs_buka_id`)
    REFERENCES `matakuliahs_kp` (`matakuliahs_id` , `matakuliahs_buka_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_matakuliahs_has_matakuliahs_buka_has_jadwals_jadwals1`
    FOREIGN KEY (`jadwals_id`)
    REFERENCES `jadwals` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `ambil_matakuliahs` (
  `mahasiswas_id` INT(11) NOT NULL,
  `matakuliahs_id` INT(11) NOT NULL,
  `matakuliahs_buka_id` INT(11) NOT NULL,
  PRIMARY KEY (`mahasiswas_id`, `matakuliahs_id`, `matakuliahs_buka_id`),
  INDEX `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_matakuli_idx` (`matakuliahs_id` ASC, `matakuliahs_buka_id` ASC),
  INDEX `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_mahasisw_idx` (`mahasiswas_id` ASC),
  CONSTRAINT `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_mahasiswas1`
    FOREIGN KEY (`mahasiswas_id`)
    REFERENCES `mahasiswas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_matakuliah1`
    FOREIGN KEY (`matakuliahs_id` , `matakuliahs_buka_id`)
    REFERENCES `matakuliahs_kp` (`matakuliahs_id` , `matakuliahs_buka_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `kehadirans` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `mahasiswas_id` INT(11) NOT NULL,
  `matakuliahs_id` INT(11) NOT NULL,
  `matakuliahs_buka_id` INT(11) NOT NULL,
  `jadwals_id` INT(11) NOT NULL,
  `tanggal` DATETIME NOT NULL,
  PRIMARY KEY (`id`, `mahasiswas_id`, `matakuliahs_id`, `matakuliahs_buka_id`, `jadwals_id`),
  INDEX `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_has_jadw_idx` (`matakuliahs_id` ASC, `matakuliahs_buka_id` ASC, `jadwals_id` ASC),
  INDEX `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_has_jadw_idx1` (`mahasiswas_id` ASC),
  CONSTRAINT `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_has_jadwal1`
    FOREIGN KEY (`mahasiswas_id`)
    REFERENCES `mahasiswas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_has_jadwal2`
    FOREIGN KEY (`matakuliahs_id` , `matakuliahs_buka_id` , `jadwals_id`)
    REFERENCES `jadwal_matakuliahs` (`matakuliahs_id` , `matakuliahs_buka_id` , `jadwals_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `dac_kehadiran` (
  `karyawan_id` INT(11) NOT NULL,
  `matakuliahs_id` INT(11) NOT NULL,
  `operator` VARCHAR(2) NOT NULL,
  `value` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`karyawan_id`, `matakuliahs_id`),
  INDEX `fk_karyawan_has_matakuliahs_matakuliahs1_idx` (`matakuliahs_id` ASC),
  INDEX `fk_karyawan_has_matakuliahs_karyawan1_idx` (`karyawan_id` ASC),
  CONSTRAINT `fk_karyawan_has_matakuliahs_karyawan1`
    FOREIGN KEY (`karyawan_id`)
    REFERENCES `presensi_cloud`.`karyawan` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_karyawan_has_matakuliahs_matakuliahs1`
    FOREIGN KEY (`matakuliahs_id`)
    REFERENCES `matakuliahs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
