-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC, `name` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`nationality`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`nationality` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NULL,
  `country` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`department`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`department` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `shortName` VARCHAR(45) NULL,
  `isAcademic` SMALLINT NULL,
  `managerId` SMALLINT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `idx_name` (`name` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`section`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`section` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `shortName` VARCHAR(45) NULL,
  `department_id` INT NOT NULL,
  PRIMARY KEY (`id`, `department_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_section_department1_idx` (`department_id` ASC) VISIBLE,
  CONSTRAINT `fk_section_department1`
    FOREIGN KEY (`department_id`)
    REFERENCES `mydb`.`department` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`specialization`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`specialization` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `shortName` VARCHAR(50) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`jobtitle`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`jobtitle` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(512) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`qualification`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`qualification` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(512) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`sponsor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`sponsor` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`salarygrade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`salarygrade` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(45) NULL,
  `name` VARCHAR(45) NULL,
  `salary` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`employmenttype`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`employmenttype` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`position`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`position` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `workflowId` INT NOT NULL,
  `description` VARCHAR(500) NULL,
  PRIMARY KEY (`id`, `workflowId`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`staff`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`staff` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staffId` VARCHAR(45) NULL,
  `civilId` VARCHAR(45) NULL,
  `ministryStaffId` VARCHAR(45) NULL,
  `salutation` VARCHAR(45) NULL,
  `firstName` VARCHAR(45) NULL,
  `secondName` VARCHAR(45) NULL,
  `thirdName` VARCHAR(45) NULL,
  `lastName` VARCHAR(45) NULL,
  `firstNameArabic` VARCHAR(45) NULL,
  `secondNameArabic` VARCHAR(45) NULL,
  `thirdNameArabic` VARCHAR(45) NULL,
  `lastNameArabic` VARCHAR(45) NULL,
  `birthdate` DATE NULL,
  `gender` VARCHAR(45) NULL,
  `joinDate` DATE NULL,
  `maritalStatus` VARCHAR(45) NULL,
  `employmentType` SMALLINT NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status_id` INT NOT NULL,
  `nationality_id` INT NOT NULL,
  `department_id` INT NOT NULL,
  `section_id` INT NOT NULL,
  `specialization_id` INT NOT NULL,
  `jobtitle_id` INT NOT NULL,
  `qualification_id` INT NOT NULL,
  `sponsor_id` INT NOT NULL,
  `salarygrade_id` INT NOT NULL,
  `employmenttype_id` INT NOT NULL,
  `position_id` INT NOT NULL,
  PRIMARY KEY (`id`, `status_id`, `nationality_id`, `department_id`, `section_id`, `specialization_id`, `jobtitle_id`, `qualification_id`, `sponsor_id`, `salarygrade_id`, `employmenttype_id`, `position_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  UNIQUE INDEX `staffId_UNIQUE` (`staffId` ASC) VISIBLE,
  UNIQUE INDEX `civilId_UNIQUE` (`civilId` ASC) INVISIBLE,
  UNIQUE INDEX `ministryStaffId_UNIQUE` (`ministryStaffId` ASC) VISIBLE,
  INDEX `idx_firstName` (`firstName` ASC) VISIBLE,
  INDEX `idx_secondName` (`secondName` ASC) INVISIBLE,
  INDEX `idx_thirdName` (`thirdName` ASC) INVISIBLE,
  INDEX `idx_lastName` (`lastName` ASC) VISIBLE,
  INDEX `fk_staff_status_idx` (`status_id` ASC) VISIBLE,
  INDEX `fk_staff_nationality1_idx` (`nationality_id` ASC) VISIBLE,
  INDEX `fk_staff_department1_idx` (`department_id` ASC) VISIBLE,
  INDEX `fk_staff_section1_idx` (`section_id` ASC) VISIBLE,
  INDEX `fk_staff_specialization1_idx` (`specialization_id` ASC) VISIBLE,
  INDEX `fk_staff_jobtitle1_idx` (`jobtitle_id` ASC) VISIBLE,
  INDEX `fk_staff_qualification1_idx` (`qualification_id` ASC) VISIBLE,
  INDEX `fk_staff_sponsor1_idx` (`sponsor_id` ASC) VISIBLE,
  INDEX `fk_staff_salarygrade1_idx` (`salarygrade_id` ASC) VISIBLE,
  INDEX `fk_staff_employmenttype1_idx` (`employmenttype_id` ASC) VISIBLE,
  INDEX `fk_staff_position1_idx` (`position_id` ASC) VISIBLE,
  CONSTRAINT `fk_staff_status`
    FOREIGN KEY (`status_id`)
    REFERENCES `mydb`.`status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_staff_nationality1`
    FOREIGN KEY (`nationality_id`)
    REFERENCES `mydb`.`nationality` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_staff_department1`
    FOREIGN KEY (`department_id`)
    REFERENCES `mydb`.`department` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staff_section1`
    FOREIGN KEY (`section_id`)
    REFERENCES `mydb`.`section` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staff_specialization1`
    FOREIGN KEY (`specialization_id`)
    REFERENCES `mydb`.`specialization` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staff_jobtitle1`
    FOREIGN KEY (`jobtitle_id`)
    REFERENCES `mydb`.`jobtitle` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staff_qualification1`
    FOREIGN KEY (`qualification_id`)
    REFERENCES `mydb`.`qualification` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staff_sponsor1`
    FOREIGN KEY (`sponsor_id`)
    REFERENCES `mydb`.`sponsor` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staff_salarygrade1`
    FOREIGN KEY (`salarygrade_id`)
    REFERENCES `mydb`.`salarygrade` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staff_employmenttype1`
    FOREIGN KEY (`employmenttype_id`)
    REFERENCES `mydb`.`employmenttype` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staff_position1`
    FOREIGN KEY (`position_id`)
    REFERENCES `mydb`.`position` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`positionstaff`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`positionstaff` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `isAcademic` VARCHAR(1) NULL,
  PRIMARY KEY (`id`, `staff_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_positionstaff_staff1_idx` (`staff_id` ASC) VISIBLE,
  CONSTRAINT `fk_positionstaff_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`extracertificates`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`extracertificates` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(256) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`staffextracertificate`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`staffextracertificate` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `extracertificates_id` INT NOT NULL,
  `certificateNo` VARCHAR(45) NULL,
  `issuedDate` DATE NULL,
  `issuedPlace` VARCHAR(512) NULL,
  `attachment` VARCHAR(512) NULL,
  `name` VARCHAR(45) NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `staff_id`, `extracertificates_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_staffextracertificate_extracertificates1_idx` (`extracertificates_id` ASC) VISIBLE,
  INDEX `fk_staffextracertificate_staff1_idx` (`staff_id` ASC) VISIBLE,
  CONSTRAINT `fk_staffextracertificate_extracertificates1`
    FOREIGN KEY (`extracertificates_id`)
    REFERENCES `mydb`.`extracertificates` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staffextracertificate_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`certificate`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`certificate` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(250) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`degree`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`degree` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(250) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`staffqualification`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`staffqualification` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `degree_id` INT NOT NULL,
  `certificate_id` INT NOT NULL,
  `graduateYear` VARCHAR(4) NULL,
  `institution` VARCHAR(500) NULL,
  `gpa` VARCHAR(10) NULL,
  `certificateNo` VARCHAR(100) NULL,
  `attachment` VARCHAR(500) NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `staff_id`, `degree_id`, `certificate_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_staffqualification_degree1_idx` (`degree_id` ASC) VISIBLE,
  INDEX `fk_staffqualification_certificate1_idx` (`certificate_id` ASC) VISIBLE,
  INDEX `fk_staffqualification_staff1_idx` (`staff_id` ASC) VISIBLE,
  CONSTRAINT `fk_staffqualification_degree1`
    FOREIGN KEY (`degree_id`)
    REFERENCES `mydb`.`degree` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staffqualification_certificate1`
    FOREIGN KEY (`certificate_id`)
    REFERENCES `mydb`.`certificate` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staffqualification_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`staffresearch`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`staffresearch` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `category` VARCHAR(45) NULL,
  `title` VARCHAR(500) NULL,
  `subject` VARCHAR(250) NULL,
  `organization` VARCHAR(500) NULL,
  `location` VARCHAR(500) NULL,
  `startDate` DATE NULL,
  `endDate` DATE NULL,
  `abstract` VARCHAR(1000) NULL,
  `attachment` VARCHAR(500) NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `staff_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_staffresearch_staff1_idx` (`staff_id` ASC) VISIBLE,
  CONSTRAINT `fk_staffresearch_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`trainingtype`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`trainingtype` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`stafftraining`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`stafftraining` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `trainingtype_id` INT NOT NULL,
  `title` VARCHAR(500) NULL,
  `startDate` DATE NULL,
  `endDate` DATE NULL,
  `place` VARCHAR(500) NULL,
  `inCollege` VARCHAR(1) NULL,
  `isSponsoredByCollege` VARCHAR(1) NULL,
  `attachment` VARCHAR(500) NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `staff_id`, `trainingtype_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_stafftraining_trainingtype1_idx` (`trainingtype_id` ASC) VISIBLE,
  INDEX `fk_stafftraining_staff1_idx` (`staff_id` ASC) VISIBLE,
  CONSTRAINT `fk_stafftraining_trainingtype1`
    FOREIGN KEY (`trainingtype_id`)
    REFERENCES `mydb`.`trainingtype` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_stafftraining_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`staffworkhistory`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`staffworkhistory` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `designation` VARCHAR(500) NULL,
  `organizationName` VARCHAR(500) NULL,
  `organizationType` VARCHAR(500) NULL,
  `startDate` DATE NULL,
  `endDate` VARCHAR(500) NULL,
  `attachment` VARCHAR(500) NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  PRIMARY KEY (`id`, `staff_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_staffworkhistory_staff1_idx` (`staff_id` ASC) VISIBLE,
  CONSTRAINT `fk_staffworkhistory_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`employmentdetail`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`employmentdetail` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `registrationCardNo` VARCHAR(10) NULL,
  `ministryStaffId` VARCHAR(15) NULL,
  `joinDate` DATE NULL,
  `isCurrent` VARCHAR(1) NULL,
  `status_id` INT NOT NULL,
  `department_id` INT NOT NULL,
  `section_id` INT NOT NULL,
  `jobtitle_id` INT NOT NULL,
  `sponsor_id` INT NOT NULL,
  `salarygrade_id` INT NOT NULL,
  `employmenttype_id` INT NOT NULL,
  PRIMARY KEY (`id`, `staff_id`, `status_id`, `department_id`, `section_id`, `jobtitle_id`, `sponsor_id`, `salarygrade_id`, `employmenttype_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_employmentdetail_staff1_idx` (`staff_id` ASC, `status_id` ASC, `department_id` ASC, `section_id` ASC, `jobtitle_id` ASC, `sponsor_id` ASC, `salarygrade_id` ASC, `employmenttype_id` ASC) VISIBLE,
  CONSTRAINT `fk_employmentdetail_staff1`
    FOREIGN KEY (`staff_id` , `status_id` , `department_id` , `section_id` , `jobtitle_id` , `sponsor_id` , `salarygrade_id` , `employmenttype_id`)
    REFERENCES `mydb`.`staff` (`id` , `status_id` , `department_id` , `section_id` , `jobtitle_id` , `sponsor_id` , `salarygrade_id` , `employmenttype_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`staffpublication`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`staffpublication` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `category` VARCHAR(500) NULL,
  `title` VARCHAR(500) NULL,
  `name` VARCHAR(500) NULL,
  `place` VARCHAR(500) NULL,
  `coAuthors` VARCHAR(500) NULL,
  `copies` INT NULL,
  `publishDate` DATE NULL,
  `abstract` VARCHAR(500) NULL,
  `attachment` VARCHAR(500) NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `staff_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_staffpublication_staff1_idx` (`staff_id` ASC) VISIBLE,
  CONSTRAINT `fk_staffpublication_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `password` VARCHAR(500) NULL,
  `userType` INT NULL,
  `status` INT NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `staff_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_users_staff1_idx` (`staff_id` ASC) VISIBLE,
  CONSTRAINT `fk_users_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`stafffamily`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`stafffamily` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `civilId` VARCHAR(500) NULL,
  `name` VARCHAR(500) NULL,
  `relationship` VARCHAR(500) NULL,
  `gender` VARCHAR(500) NULL,
  `birthdate` DATE NULL,
  PRIMARY KEY (`id`, `staff_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_stafffamily_staff1_idx` (`staff_id` ASC) VISIBLE,
  CONSTRAINT `fk_stafffamily_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`passport`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`passport` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `stafffamily_id` INT NOT NULL,
  `number` VARCHAR(20) NULL,
  `issueDate` DATE NULL,
  `expiryDate` DATE NULL,
  `isFamilyMember` VARCHAR(1) NULL,
  `isCurrent` VARCHAR(1) NULL,
  PRIMARY KEY (`id`, `staff_id`, `stafffamily_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_passport_staff1_idx` (`staff_id` ASC) VISIBLE,
  INDEX `fk_passport_stafffamily1_idx` (`stafffamily_id` ASC) VISIBLE,
  CONSTRAINT `fk_passport_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_passport_stafffamily1`
    FOREIGN KEY (`stafffamily_id`)
    REFERENCES `mydb`.`stafffamily` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`visa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`visa` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `stafffamily_id` INT NOT NULL,
  `civilId` VARCHAR(500) NULL,
  `cExpiryDate` DATE NULL,
  `number` VARCHAR(20) NULL,
  `issueDate` DATE NULL,
  `expiryDate` DATE NULL,
  `isFamilyMember` VARCHAR(1) NULL,
  `isCurrent` VARCHAR(1) NULL,
  PRIMARY KEY (`id`, `staff_id`, `stafffamily_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_visa_stafffamily1_idx` (`stafffamily_id` ASC) VISIBLE,
  INDEX `fk_visa_staff1_idx` (`staff_id` ASC) VISIBLE,
  CONSTRAINT `fk_visa_stafffamily1`
    FOREIGN KEY (`stafffamily_id`)
    REFERENCES `mydb`.`stafffamily` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_visa_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`contacttype`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`contacttype` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(500) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`contactdetails`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`contactdetails` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `contacttype_id` INT NOT NULL,
  `stafffamily_id` INT NOT NULL,
  `date` VARCHAR(100) NULL,
  `isCurrent` VARCHAR(1) NULL,
  `isFamily` VARCHAR(1) NULL,
  PRIMARY KEY (`id`, `staff_id`, `contacttype_id`, `stafffamily_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_contactdetails_staff1_idx` (`staff_id` ASC) VISIBLE,
  INDEX `fk_contactdetails_stafffamily1_idx` (`stafffamily_id` ASC) VISIBLE,
  INDEX `fk_contactdetails_contacttype1_idx` (`contacttype_id` ASC) VISIBLE,
  CONSTRAINT `fk_contactdetails_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_contactdetails_stafffamily1`
    FOREIGN KEY (`stafffamily_id`)
    REFERENCES `mydb`.`stafffamily` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_contactdetails_contacttype1`
    FOREIGN KEY (`contacttype_id`)
    REFERENCES `mydb`.`contacttype` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`fpuserlog`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`fpuserlog` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `recordDate` DATE NULL,
  `userid` VARCHAR(50) NULL,
  `inEvent` VARCHAR(50) NULL,
  `inTime` DATETIME NULL,
  `outEvent` VARCHAR(50) NULL,
  `outTime` DATETIME NULL,
  `synctime` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`fp_user_log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`fp_user_log` (
  `tranid` BIGINT NOT NULL AUTO_INCREMENT,
  `userid` VARCHAR(500) NULL,
  `eventid` VARCHAR(500) NULL,
  `fptimestamp` DATETIME NULL,
  `synctime` TIMESTAMP NULL,
  PRIMARY KEY (`tranid`),
  UNIQUE INDEX `tranid_UNIQUE` (`tranid` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`holiday`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`holiday` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(500) NULL,
  `startDate` DATE NULL,
  `endDate` DATE NULL,
  `total` INT NULL,
  `isRamadan` TINYINT NULL,
  `createdBy` VARCHAR(10) NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`approver`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`approver` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `description` VARCHAR(500) NULL,
  PRIMARY KEY (`id`, `staff_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_approver_staff1_idx` (`staff_id` ASC) VISIBLE,
  CONSTRAINT `fk_approver_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`approvalsequence`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`approvalsequence` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `workflowId` INT NOT NULL,
  `approver_id` INT NOT NULL,
  `sequenceNo` INT NULL,
  `condition` VARCHAR(1) NULL,
  PRIMARY KEY (`id`, `workflowId`, `approver_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_approvalsequence_position1_idx` (`workflowId` ASC) VISIBLE,
  INDEX `fk_approvalsequence_approver1_idx` (`approver_id` ASC) VISIBLE,
  CONSTRAINT `fk_approvalsequence_position1`
    FOREIGN KEY (`workflowId`)
    REFERENCES `mydb`.`position` (`workflowId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_approvalsequence_approver1`
    FOREIGN KEY (`approver_id`)
    REFERENCES `mydb`.`approver` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`leavetype`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`leavetype` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(500) NULL,
  `deductDays` TINYINT NULL,
  `deanApprovalLimit` TINYINT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`emergencyreset`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`emergencyreset` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `sponsorType` INT NULL,
  `resetBy` VARCHAR(500) NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`emergencyleavebalancedetails`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`emergencyleavebalancedetails` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `leavetype_id` INT NOT NULL,
  `requestNo` VARCHAR(20) NULL,
  `dateFiled` DATETIME NULL,
  `startDate` DATE NULL,
  `endDate` DATE NULL,
  `total` SMALLINT NULL,
  `status` VARCHAR(100) NULL,
  `notes` VARCHAR(500) NULL,
  `addType` TINYINT NULL,
  `createdBy` VARCHAR(10) NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `staff_id`, `leavetype_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_emergencyleavebalancedetails_leavetype1_idx` (`leavetype_id` ASC) VISIBLE,
  INDEX `fk_emergencyleavebalancedetails_staff1_idx` (`staff_id` ASC) VISIBLE,
  CONSTRAINT `fk_emergencyleavebalancedetails_leavetype1`
    FOREIGN KEY (`leavetype_id`)
    REFERENCES `mydb`.`leavetype` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_emergencyleavebalancedetails_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`internalleavebalance`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`internalleavebalance` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `requestNo` VARCHAR(10) NULL,
  `sponsorType` SMALLINT NULL,
  `dateFiled` DATETIME NULL,
  `notes` VARCHAR(500) NULL,
  `attachment` VARCHAR(500) NULL,
  `isFinalized` VARCHAR(1) NULL,
  `createdBy` VARCHAR(10) NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`internalleavebalancedetails`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`internalleavebalancedetails` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `internalleavebalance_id` INT NOT NULL,
  `leavetype_id` INT NOT NULL,
  `staff_id` INT NOT NULL,
  `startDate` DATE NULL,
  `endDate` DATE NULL,
  `total` SMALLINT NULL,
  `status` VARCHAR(100) NULL,
  `notes` VARCHAR(500) NULL,
  `addType` SMALLINT NULL,
  `createdBy` VARCHAR(100) NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `internalleavebalance_id`, `leavetype_id`, `staff_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_internalleavebalancedetails_internalleavebalance1_idx` (`internalleavebalance_id` ASC) VISIBLE,
  INDEX `fk_internalleavebalancedetails_leavetype1_idx` (`leavetype_id` ASC) VISIBLE,
  INDEX `fk_internalleavebalancedetails_staff1_idx` (`staff_id` ASC) VISIBLE,
  CONSTRAINT `fk_internalleavebalancedetails_internalleavebalance1`
    FOREIGN KEY (`internalleavebalance_id`)
    REFERENCES `mydb`.`internalleavebalance` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_internalleavebalancedetails_leavetype1`
    FOREIGN KEY (`leavetype_id`)
    REFERENCES `mydb`.`leavetype` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_internalleavebalancedetails_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`standardleave`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`standardleave` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `requestNo` VARCHAR(20) NULL,
  `staff_id` INT NOT NULL,
  `leavetype_id` INT NOT NULL,
  `currentStatus` VARCHAR(50) NULL,
  `dateFiled` DATETIME NULL,
  `startDate` DATE NULL,
  `endDate` DATE NULL,
  `total` SMALLINT NULL,
  `reason` VARCHAR(1000) NULL,
  `attachment` VARCHAR(500) NULL,
  `currentSeqNumber` SMALLINT NULL,
  `currentSeqId` SMALLINT NULL,
  `currentApproverId` SMALLINT NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `staff_id`, `leavetype_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_standardleave_leavetype1_idx` (`leavetype_id` ASC) VISIBLE,
  INDEX `fk_standardleave_staff1_idx` (`staff_id` ASC) VISIBLE,
  CONSTRAINT `fk_standardleave_leavetype1`
    FOREIGN KEY (`leavetype_id`)
    REFERENCES `mydb`.`leavetype` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_standardleave_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`standardleavehistory`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`standardleavehistory` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `standardleave_id` INT NOT NULL,
  `staff_id` INT NOT NULL,
  `filedBy` VARCHAR(10) NULL,
  `status` VARCHAR(250) NULL,
  `notes` VARCHAR(500) NULL,
  `ipAddress` VARCHAR(16) NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `standardleave_id`, `staff_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_standardleavehistory_standardleave1_idx` (`standardleave_id` ASC) VISIBLE,
  INDEX `fk_standardleavehistory_staff1_idx` (`staff_id` ASC) VISIBLE,
  CONSTRAINT `fk_standardleavehistory_standardleave1`
    FOREIGN KEY (`standardleave_id`)
    REFERENCES `mydb`.`standardleave` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_standardleavehistory_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`shortleave`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`shortleave` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `requestNo` VARCHAR(20) NULL,
  `staff_id` INT NOT NULL,
  `currentStatus` VARCHAR(500) NULL,
  `dateFile` DATETIME NULL,
  `leaveDate` DATE NULL,
  `startTime` VARCHAR(10) NULL,
  `endTime` VARCHAR(10) NULL,
  `total` VARCHAR(10) NULL,
  `currentSeqNumber` SMALLINT NULL,
  `currentSeqId` SMALLINT NULL,
  `currentApproverId` SMALLINT NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `staff_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_shortleave_staff1_idx` (`staff_id` ASC) VISIBLE,
  CONSTRAINT `fk_shortleave_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`shortleavehistory`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`shortleavehistory` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `shortleave_id` INT NOT NULL,
  `staff_id` INT NOT NULL,
  `status` VARCHAR(100) NULL,
  `notes` VARCHAR(500) NULL,
  `ipAddress` VARCHAR(16) NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `shortleave_id`, `staff_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_shortleavehistory_shortleave1_idx` (`shortleave_id` ASC) VISIBLE,
  INDEX `fk_shortleavehistory_staff1_idx` (`staff_id` ASC) VISIBLE,
  CONSTRAINT `fk_shortleavehistory_shortleave1`
    FOREIGN KEY (`shortleave_id`)
    REFERENCES `mydb`.`shortleave` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_shortleavehistory_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`task`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`task` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(500) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`taskapprover`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`taskapprover` (
  `id` INT NOT NULL,
  `task_id` INT NOT NULL,
  `staff_id` INT NOT NULL,
  `department_id` INT NOT NULL,
  `status` VARCHAR(500) NULL,
  `createdBy` VARCHAR(500) NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `task_id`, `staff_id`, `department_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_taskapprover_task1_idx` (`task_id` ASC) VISIBLE,
  INDEX `fk_taskapprover_department1_idx` (`department_id` ASC) VISIBLE,
  INDEX `fk_taskapprover_staff1_idx` (`staff_id` ASC) VISIBLE,
  CONSTRAINT `fk_taskapprover_task1`
    FOREIGN KEY (`task_id`)
    REFERENCES `mydb`.`task` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_taskapprover_department1`
    FOREIGN KEY (`department_id`)
    REFERENCES `mydb`.`department` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_taskapprover_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`taskprocess`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`taskprocess` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `requestNo` VARCHAR(25) NULL,
  `staff_id` INT NOT NULL,
  `department_id` INT NOT NULL,
  `taskProcessStatus` VARCHAR(500) NULL,
  `currentServiceId` SMALLINT NULL,
  `currentService` VARCHAR(500) NULL,
  `currentServiceStatus` VARCHAR(500) NULL,
  `started` DATETIME NULL,
  `taskType` TINYINT NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `staff_id`, `department_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_taskprocess_staff1_idx` (`staff_id` ASC) VISIBLE,
  INDEX `fk_taskprocess_department1_idx` (`department_id` ASC) VISIBLE,
  CONSTRAINT `fk_taskprocess_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_taskprocess_department1`
    FOREIGN KEY (`department_id`)
    REFERENCES `mydb`.`department` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`taskprocesshistory`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`taskprocesshistory` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `taskprocess_id` INT NOT NULL,
  `task_id` INT NOT NULL,
  `staff_id` INT NOT NULL,
  `transactionDate` DATETIME NULL,
  `status` VARCHAR(50) NULL,
  `comments` VARCHAR(500) NULL,
  PRIMARY KEY (`id`, `taskprocess_id`, `task_id`, `staff_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_taskprocesshistory_task1_idx` (`task_id` ASC) VISIBLE,
  INDEX `fk_taskprocesshistory_taskprocess1_idx` (`taskprocess_id` ASC) VISIBLE,
  INDEX `fk_taskprocesshistory_staff1_idx` (`staff_id` ASC) VISIBLE,
  CONSTRAINT `fk_taskprocesshistory_task1`
    FOREIGN KEY (`task_id`)
    REFERENCES `mydb`.`task` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_taskprocesshistory_taskprocess1`
    FOREIGN KEY (`taskprocess_id`)
    REFERENCES `mydb`.`taskprocess` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_taskprocesshistory_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `mydb`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
