-- Database setup
-- Run as MySQL root on the DigitalOcean droplet.

CREATE DATABASE IF NOT EXISTS hub
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE hub;

-- Users table
-- Password stores the output of PHP password_hash() NOT a plaintext password
-- PHP Login.php use password_verify($inputPassword, $row['Password'])

CREATE TABLE IF NOT EXISTS Users (
  ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
  FirstName VARCHAR(50) NOT NULL,
  LastName VARCHAR(50) NOT NULL,
  Login VARCHAR(255) NOT NULL,
  Password VARCHAR(255) NOT NULL,
  DateCreated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (ID),
  UNIQUE KEY uq_users_login (Login)
) ENGINE=InnoDB;

-- Contacts table
-- Each contact belongs to exactly one user.
-- ON DELETE CASCADE removes a user's contacts if that user account is deleted.

CREATE TABLE IF NOT EXISTS Contacts (
  ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
  UserID INT UNSIGNED NOT NULL,
  FirstName VARCHAR(50) NOT NULL,
  LastName VARCHAR(50) NOT NULL,
  Relationship VARCHAR(100) NULL,
  Email VARCHAR(255) NULL,
  Phone VARCHAR(40) NULL,
  Address VARCHAR(255) NULL,
  Notes TEXT NULL,
  DateCreated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  DateUpdated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (ID),
  CONSTRAINT fk_contacts_user
    FOREIGN KEY (UserID)
    REFERENCES Users(ID)
    ON DELETE CASCADE,
  KEY idx_contacts_user (UserID),
  KEY idx_contacts_user_name (UserID, LastName, FirstName),
  KEY idx_contacts_user_email (UserID, Email),
  KEY idx_contacts_updated (UserID, DateUpdated)
) ENGINE=InnoDB;

-- App database account.
CREATE USER IF NOT EXISTS 'hub_api'@'localhost'
  IDENTIFIED BY 'password123';

GRANT SELECT, INSERT, UPDATE, DELETE
ON hub.*
TO 'hub_api'@'localhost';

FLUSH PRIVILEGES;

-- Verification checks
SHOW TABLES;
DESCRIBE Users;
DESCRIBE Contacts;
