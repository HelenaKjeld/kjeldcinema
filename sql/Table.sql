DROP DATABASE IF EXISTS Rowancinema;
CREATE DATABASE Rowancinema;
USE Rowancinema;
SET default_storage_engine=InnoDB;

CREATE TABLE companyinfo (
    CompanyInfoID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100),
    Description TEXT,
    Email VARCHAR(100),
    PhoneNumber VARCHAR(30),
    OpeningHours VARCHAR(20),
    Address VARCHAR(100)
);

ALTER TABLE CompanyInfo ADD COLUMN Logo VARCHAR(255) NULL;


CREATE TABLE news (
    NewsID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Titel VARCHAR(100),
    Text TEXT,
    BannerImg VARCHAR(255), -- URL TO IMAGE ?!?!?!?!
    ReleaseDate DATE
    );


CREATE TABLE user (
    UserID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Firstname VARCHAR(50),
    Lastname VARCHAR(50),
    Email VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(100) NOT NULL
  
    -- Role ENUM('admin', 'customer') DEFAULT 'customer', maybe?!?!?
);

CREATE TABLE movie (
    MovieID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Titel VARCHAR(100),
    Description TEXT,
    Poster VARCHAR(255), -- URL TO IMAGE ?!?!?!?!
    ageRating INT,
    Duration INT -- in minutes and hour (90 = 1 hour and 30 minutes)
);


CREATE TABLE showing (
    ShowingID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    DATE DATE,
    Time TIME NOT NULL,
    Price DECIMAL(10, 2),
    MovieID INT NOT NULL,
    ShowroomID INT NOT NULL,
    FOREIGN KEY (ShowroomID) REFERENCES showroom(ShowroomID),
    FOREIGN KEY (MovieID) REFERENCES movie(MovieID)
);

CREATE TABLE showroom(
    ShowroomID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    IsDeleted BOOLEAN NOT NULL DEFAULT FALSE,
    ShowingID INT NOT NULL,
    FOREIGN KEY (ShowingID) REFERENCES showing(ShowingID)
     
);


CREATE TABLE ticket(
    TicketID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    PurchaseDate DATE,
    TotalPrice DECIMAL(10, 2),
    ShowingID INT NOT NULL,
    UserID INT, 
    FOREIGN KEY (ShowingID) REFERENCES showing(ShowingID),
    FOREIGN KEY (UserID) REFERENCES user(UserID)
     
);

CREATE TABLE seating (
    SeatingID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    RowLetters VARCHAR(2) NOT NULL,
    SeatNumber VARCHAR(2) NOT NULL,
    ShowroomID INT NOT NULL,
    FOREIGN KEY (ShowroomID) REFERENCES showroom(ShowroomID)
);



CREATE TABLE ticket_has_a_seating (
    TicketID INT NOT NULL,
    SeatingID INT NOT NULL,
    IsAvailable BOOLEAN DEFAULT FALSE, -- is the seat available for booking
    PRIMARY KEY (TicketID, SeatingID),
    FOREIGN KEY (TicketID) REFERENCES ticket(TicketID),
    FOREIGN KEY (SeatingID) REFERENCES seating(SeatingID)
);