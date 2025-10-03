DROP DATABASE IF EXISTS Rowancinema;
CREATE DATABASE Rowancinema;
USE Rowancinema;
SET default_storage_engine=InnoDB;


CREATE TABLE User (
    UserID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Firstname VARCHAR(255),
    Lastname VARCHAR(255),
    Email VARCHAR(255) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    PRIMARY KEY (TicketsID),
    FOREIGN KEY (TicketsID) REFERENCES TicketsID(TicketsID),
    -- Role ENUM('admin', 'customer') DEFAULT 'customer', maybe?!?!?
);

CREATE TABLE WalkIn (
    WalkIn INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(255) NOT NULL,
    PRIMARY KEY (TicketsID),
    FOREIGN KEY (TicketsID) REFERENCES TicketsID(TicketsID), 
)