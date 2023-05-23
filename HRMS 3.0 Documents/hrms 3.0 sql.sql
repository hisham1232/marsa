-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema dbhr
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema dbhr
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dbhr` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `dbhr` ;

-- -----------------------------------------------------
-- Table `dbhr`.`status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC, `name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`nationality`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`nationality` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NULL,
  `country` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`department`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`department` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `shortName` VARCHAR(45) NULL,
  `isAcademic` SMALLINT NULL,
  `managerId` SMALLINT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `idx_name` (`name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`section`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`section` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `shortName` VARCHAR(45) NULL,
  `department_id` INT NOT NULL,
  PRIMARY KEY (`id`, `department_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_section_department1_idx` (`department_id` ASC),
  CONSTRAINT `fk_section_department1`
    FOREIGN KEY (`department_id`)
    REFERENCES `dbhr`.`department` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`specialization`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`specialization` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `shortName` VARCHAR(50) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`jobtitle`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`jobtitle` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(512) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`qualification`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`qualification` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(512) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`sponsor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`sponsor` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`salarygrade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`salarygrade` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(45) NULL,
  `name` VARCHAR(45) NULL,
  `salary` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`employmenttype`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`employmenttype` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`position`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`position` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `workflowId` INT NOT NULL,
  `description` VARCHAR(500) NULL,
  PRIMARY KEY (`id`, `workflowId`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`staff`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`staff` (
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
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  UNIQUE INDEX `staffId_UNIQUE` (`staffId` ASC),
  UNIQUE INDEX `civilId_UNIQUE` (`civilId` ASC),
  UNIQUE INDEX `ministryStaffId_UNIQUE` (`ministryStaffId` ASC),
  INDEX `idx_firstName` (`firstName` ASC),
  INDEX `idx_secondName` (`secondName` ASC),
  INDEX `idx_thirdName` (`thirdName` ASC),
  INDEX `idx_lastName` (`lastName` ASC),
  INDEX `fk_staff_status_idx` (`status_id` ASC),
  INDEX `fk_staff_nationality1_idx` (`nationality_id` ASC),
  INDEX `fk_staff_department1_idx` (`department_id` ASC),
  INDEX `fk_staff_section1_idx` (`section_id` ASC),
  INDEX `fk_staff_specialization1_idx` (`specialization_id` ASC),
  INDEX `fk_staff_jobtitle1_idx` (`jobtitle_id` ASC),
  INDEX `fk_staff_qualification1_idx` (`qualification_id` ASC),
  INDEX `fk_staff_sponsor1_idx` (`sponsor_id` ASC),
  INDEX `fk_staff_salarygrade1_idx` (`salarygrade_id` ASC),
  INDEX `fk_staff_employmenttype1_idx` (`employmenttype_id` ASC),
  INDEX `fk_staff_position1_idx` (`position_id` ASC),
  CONSTRAINT `fk_staff_status`
    FOREIGN KEY (`status_id`)
    REFERENCES `dbhr`.`status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_staff_nationality1`
    FOREIGN KEY (`nationality_id`)
    REFERENCES `dbhr`.`nationality` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_staff_department1`
    FOREIGN KEY (`department_id`)
    REFERENCES `dbhr`.`department` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staff_section1`
    FOREIGN KEY (`section_id`)
    REFERENCES `dbhr`.`section` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staff_specialization1`
    FOREIGN KEY (`specialization_id`)
    REFERENCES `dbhr`.`specialization` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staff_jobtitle1`
    FOREIGN KEY (`jobtitle_id`)
    REFERENCES `dbhr`.`jobtitle` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staff_qualification1`
    FOREIGN KEY (`qualification_id`)
    REFERENCES `dbhr`.`qualification` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staff_sponsor1`
    FOREIGN KEY (`sponsor_id`)
    REFERENCES `dbhr`.`sponsor` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staff_salarygrade1`
    FOREIGN KEY (`salarygrade_id`)
    REFERENCES `dbhr`.`salarygrade` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staff_employmenttype1`
    FOREIGN KEY (`employmenttype_id`)
    REFERENCES `dbhr`.`employmenttype` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staff_position1`
    FOREIGN KEY (`position_id`)
    REFERENCES `dbhr`.`position` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`positionstaff`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`positionstaff` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `isAcademic` VARCHAR(1) NULL,
  PRIMARY KEY (`id`, `staff_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_positionstaff_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_positionstaff_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`extracertificates`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`extracertificates` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(256) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`staffextracertificate`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`staffextracertificate` (
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
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_staffextracertificate_extracertificates1_idx` (`extracertificates_id` ASC),
  INDEX `fk_staffextracertificate_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_staffextracertificate_extracertificates1`
    FOREIGN KEY (`extracertificates_id`)
    REFERENCES `dbhr`.`extracertificates` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staffextracertificate_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`certificate`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`certificate` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(250) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`degree`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`degree` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(250) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`staffqualification`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`staffqualification` (
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
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_staffqualification_degree1_idx` (`degree_id` ASC),
  INDEX `fk_staffqualification_certificate1_idx` (`certificate_id` ASC),
  INDEX `fk_staffqualification_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_staffqualification_degree1`
    FOREIGN KEY (`degree_id`)
    REFERENCES `dbhr`.`degree` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staffqualification_certificate1`
    FOREIGN KEY (`certificate_id`)
    REFERENCES `dbhr`.`certificate` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staffqualification_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`staffresearch`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`staffresearch` (
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
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_staffresearch_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_staffresearch_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`trainingtype`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`trainingtype` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`stafftraining`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`stafftraining` (
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
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_stafftraining_trainingtype1_idx` (`trainingtype_id` ASC),
  INDEX `fk_stafftraining_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_stafftraining_trainingtype1`
    FOREIGN KEY (`trainingtype_id`)
    REFERENCES `dbhr`.`trainingtype` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_stafftraining_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`staffworkhistory`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`staffworkhistory` (
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
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_staffworkhistory_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_staffworkhistory_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`employmentdetail`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`employmentdetail` (
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
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_employmentdetail_staff1_idx` (`staff_id` ASC, `status_id` ASC, `department_id` ASC, `section_id` ASC, `jobtitle_id` ASC, `sponsor_id` ASC, `salarygrade_id` ASC, `employmenttype_id` ASC))
ENGINE = INNODB;


-- -----------------------------------------------------
-- Table `dbhr`.`staffpublication`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`staffpublication` (
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
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_staffpublication_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_staffpublication_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `password` VARCHAR(500) NULL,
  `userType` INT NULL,
  `status` INT NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `staff_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_users_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_users_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`stafffamily`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`stafffamily` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `civilId` VARCHAR(500) NULL,
  `name` VARCHAR(500) NULL,
  `relationship` VARCHAR(500) NULL,
  `gender` VARCHAR(500) NULL,
  `birthdate` DATE NULL,
  PRIMARY KEY (`id`, `staff_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_stafffamily_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_stafffamily_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`passport`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`passport` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `stafffamily_id` INT NOT NULL,
  `number` VARCHAR(20) NULL,
  `issueDate` DATE NULL,
  `expiryDate` DATE NULL,
  `isFamilyMember` VARCHAR(1) NULL,
  `isCurrent` VARCHAR(1) NULL,
  PRIMARY KEY (`id`, `staff_id`, `stafffamily_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_passport_staff1_idx` (`staff_id` ASC),
  INDEX `fk_passport_stafffamily1_idx` (`stafffamily_id` ASC),
  CONSTRAINT `fk_passport_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_passport_stafffamily1`
    FOREIGN KEY (`stafffamily_id`)
    REFERENCES `dbhr`.`stafffamily` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`visa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`visa` (
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
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_visa_stafffamily1_idx` (`stafffamily_id` ASC),
  INDEX `fk_visa_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_visa_stafffamily1`
    FOREIGN KEY (`stafffamily_id`)
    REFERENCES `dbhr`.`stafffamily` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_visa_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`contacttype`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`contacttype` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(500) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`contactdetails`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`contactdetails` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `contacttype_id` INT NOT NULL,
  `stafffamily_id` INT NOT NULL,
  `date` VARCHAR(100) NULL,
  `isCurrent` VARCHAR(1) NULL,
  `isFamily` VARCHAR(1) NULL,
  PRIMARY KEY (`id`, `staff_id`, `contacttype_id`, `stafffamily_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_contactdetails_staff1_idx` (`staff_id` ASC),
  INDEX `fk_contactdetails_stafffamily1_idx` (`stafffamily_id` ASC),
  INDEX `fk_contactdetails_contacttype1_idx` (`contacttype_id` ASC),
  CONSTRAINT `fk_contactdetails_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_contactdetails_stafffamily1`
    FOREIGN KEY (`stafffamily_id`)
    REFERENCES `dbhr`.`stafffamily` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_contactdetails_contacttype1`
    FOREIGN KEY (`contacttype_id`)
    REFERENCES `dbhr`.`contacttype` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`fpuserlog`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`fpuserlog` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `recordDate` DATE NULL,
  `userid` VARCHAR(50) NULL,
  `inEvent` VARCHAR(50) NULL,
  `inTime` DATETIME NULL,
  `outEvent` VARCHAR(50) NULL,
  `outTime` DATETIME NULL,
  `synctime` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`fp_user_log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`fp_user_log` (
  `tranid` BIGINT NOT NULL AUTO_INCREMENT,
  `userid` VARCHAR(500) NULL,
  `eventid` VARCHAR(500) NULL,
  `fptimestamp` DATETIME NULL,
  `synctime` TIMESTAMP NULL,
  PRIMARY KEY (`tranid`),
  UNIQUE INDEX `tranid_UNIQUE` (`tranid` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`holiday`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`holiday` (
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
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`approver`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`approver` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `description` VARCHAR(500) NULL,
  PRIMARY KEY (`id`, `staff_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_approver_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_approver_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`approvalsequence`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`approvalsequence` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `workflowId` INT NOT NULL,
  `approver_id` INT NOT NULL,
  `sequenceNo` INT NULL,
  `condition` VARCHAR(1) NULL,
  PRIMARY KEY (`id`, `workflowId`, `approver_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_approvalsequence_position1_idx` (`workflowId` ASC),
  INDEX `fk_approvalsequence_approver1_idx` (`approver_id` ASC),
  CONSTRAINT `fk_approvalsequence_approver1`
    FOREIGN KEY (`approver_id`)
    REFERENCES `dbhr`.`approver` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = INNODB;


-- -----------------------------------------------------
-- Table `dbhr`.`leavetype`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`leavetype` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(500) NULL,
  `deductDays` TINYINT NULL,
  `deanApprovalLimit` TINYINT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`emergencyreset`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`emergencyreset` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `sponsorType` INT NULL,
  `resetBy` VARCHAR(500) NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`emergencyleavebalancedetails`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`emergencyleavebalancedetails` (
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
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_emergencyleavebalancedetails_leavetype1_idx` (`leavetype_id` ASC),
  INDEX `fk_emergencyleavebalancedetails_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_emergencyleavebalancedetails_leavetype1`
    FOREIGN KEY (`leavetype_id`)
    REFERENCES `dbhr`.`leavetype` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_emergencyleavebalancedetails_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`internalleavebalance`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`internalleavebalance` (
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
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`internalleavebalancedetails`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`internalleavebalancedetails` (
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
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_internalleavebalancedetails_internalleavebalance1_idx` (`internalleavebalance_id` ASC),
  INDEX `fk_internalleavebalancedetails_leavetype1_idx` (`leavetype_id` ASC),
  INDEX `fk_internalleavebalancedetails_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_internalleavebalancedetails_internalleavebalance1`
    FOREIGN KEY (`internalleavebalance_id`)
    REFERENCES `dbhr`.`internalleavebalance` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_internalleavebalancedetails_leavetype1`
    FOREIGN KEY (`leavetype_id`)
    REFERENCES `dbhr`.`leavetype` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_internalleavebalancedetails_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`standardleave`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`standardleave` (
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
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_standardleave_leavetype1_idx` (`leavetype_id` ASC),
  INDEX `fk_standardleave_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_standardleave_leavetype1`
    FOREIGN KEY (`leavetype_id`)
    REFERENCES `dbhr`.`leavetype` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_standardleave_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`standardleavehistory`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`standardleavehistory` (
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
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_standardleavehistory_standardleave1_idx` (`standardleave_id` ASC),
  INDEX `fk_standardleavehistory_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_standardleavehistory_standardleave1`
    FOREIGN KEY (`standardleave_id`)
    REFERENCES `dbhr`.`standardleave` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_standardleavehistory_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`shortleave`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`shortleave` (
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
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_shortleave_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_shortleave_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`shortleavehistory`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`shortleavehistory` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `shortleave_id` INT NOT NULL,
  `staff_id` INT NOT NULL,
  `status` VARCHAR(100) NULL,
  `notes` VARCHAR(500) NULL,
  `ipAddress` VARCHAR(16) NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `shortleave_id`, `staff_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_shortleavehistory_shortleave1_idx` (`shortleave_id` ASC),
  INDEX `fk_shortleavehistory_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_shortleavehistory_shortleave1`
    FOREIGN KEY (`shortleave_id`)
    REFERENCES `dbhr`.`shortleave` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_shortleavehistory_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`task`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`task` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(500) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`taskapprover`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`taskapprover` (
  `id` INT NOT NULL,
  `task_id` INT NOT NULL,
  `staff_id` INT NOT NULL,
  `department_id` INT NOT NULL,
  `status` VARCHAR(500) NULL,
  `createdBy` VARCHAR(500) NULL,
  `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `task_id`, `staff_id`, `department_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_taskapprover_task1_idx` (`task_id` ASC),
  INDEX `fk_taskapprover_department1_idx` (`department_id` ASC),
  INDEX `fk_taskapprover_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_taskapprover_task1`
    FOREIGN KEY (`task_id`)
    REFERENCES `dbhr`.`task` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_taskapprover_department1`
    FOREIGN KEY (`department_id`)
    REFERENCES `dbhr`.`department` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_taskapprover_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`taskprocess`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`taskprocess` (
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
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_taskprocess_staff1_idx` (`staff_id` ASC),
  INDEX `fk_taskprocess_department1_idx` (`department_id` ASC),
  CONSTRAINT `fk_taskprocess_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_taskprocess_department1`
    FOREIGN KEY (`department_id`)
    REFERENCES `dbhr`.`department` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbhr`.`taskprocesshistory`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbhr`.`taskprocesshistory` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `taskprocess_id` INT NOT NULL,
  `task_id` INT NOT NULL,
  `staff_id` INT NOT NULL,
  `transactionDate` DATETIME NULL,
  `status` VARCHAR(50) NULL,
  `comments` VARCHAR(500) NULL,
  PRIMARY KEY (`id`, `taskprocess_id`, `task_id`, `staff_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_taskprocesshistory_task1_idx` (`task_id` ASC),
  INDEX `fk_taskprocesshistory_taskprocess1_idx` (`taskprocess_id` ASC),
  INDEX `fk_taskprocesshistory_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_taskprocesshistory_task1`
    FOREIGN KEY (`task_id`)
    REFERENCES `dbhr`.`task` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_taskprocesshistory_taskprocess1`
    FOREIGN KEY (`taskprocess_id`)
    REFERENCES `dbhr`.`taskprocess` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_taskprocesshistory_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `dbhr`.`staff` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
