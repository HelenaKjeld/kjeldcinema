DROP DATABASE IF EXISTS Rowancinema;
CREATE DATABASE Rowancinema;
USE Rowancinema;
SET default_storage_engine=InnoDB;

CREATE TABLE CompanyInfo (
    CompanyInfoID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100),
    Decscription TEXT,
    Email VARCHAR(100),
    PhoneNumber VARCHAR(30),
    OpeningHours VARCHAR(20),
    Address VARCHAR(100)
);

CREATE TABLE News (
    NewsID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Titel VARCHAR(100),
    Text TEXT,
    BannerImg VARCHAR(255), -- URL TO IMAGE ?!?!?!?!
    ReleaseDate DATE
    );


CREATE TABLE User (
    UserID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Firstname VARCHAR(50),
    Lastname VARCHAR(50),
    Email VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(100) NOT NULL,
    TicketsID INT NOT NULL 
    FOREIGN KEY (TicketsID) REFERENCES TicketsID(TicketsID),
    -- Role ENUM('admin', 'customer') DEFAULT 'customer', maybe?!?!?
);

CREATE TABLE WalkIn (
    WalkIn INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(100) NOT NULL,
    PRIMARY KEY (TicketsID),
    FOREIGN KEY (TicketsID) REFERENCES TicketsID(TicketsID), 
)


CREATE TABLE Movie (
    MovieID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Titel VARCHAR(100),
    Decscription TEXT,
    Poster VARCHAR(255), -- URL TO IMAGE ?!?!?!?!
    ageRating INT,
    Duration INT, -- in minutes
);


CREATE TABLE Showing (
    ShowingID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Titel VARCHAR(100),
    DATE DATE,
    Price DECIMAL(10, 2),
    MovieID INT NOT NULL,
    FOREIGN KEY (MovieID) REFERENCES Movie(MovieID)
);

CREATE TABLE Seating (
    SeatingID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    RowLetters VARCHAR(2) NOT NULL,
    SeatNumber VARCHAR(2) NOT NULL,
    -- IsAvailable BOOLEAN DEFAULT TRUE,
    ShowingID INT NOT NULL,
    FOREIGN KEY (ShowingID) REFERENCES Showing(ShowingID)
);