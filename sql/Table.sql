DROP DATABASE IF EXISTS Rowancinema;
CREATE DATABASE Rowancinema;
USE Rowancinema;
SET default_storage_engine=InnoDB;

CREATE TABLE CompanyInfo (
    CompanyInfoID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100),
    Description TEXT,
    Email VARCHAR(100),
    PhoneNumber VARCHAR(30),
    OpeningHours VARCHAR(20),
    Address VARCHAR(100)
);

ALTER TABLE CompanyInfo ADD COLUMN Logo VARCHAR(255) NULL;


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
    Password VARCHAR(100) NOT NULL
  
    -- Role ENUM('admin', 'customer') DEFAULT 'customer', maybe?!?!?
);

CREATE TABLE Movie (
    MovieID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Titel VARCHAR(100),
    Description TEXT,
    Poster VARCHAR(255), -- URL TO IMAGE ?!?!?!?!
    ageRating INT,
    Duration INT -- in minutes and hour (90 = 1 hour and 30 minutes)
);


CREATE TABLE Showing (
    ShowingID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Titel VARCHAR(100),
    DATE DATE,
    Price DECIMAL(10, 2),
    MovieID INT NOT NULL,
    ShowroomID INT NOT NULL,
    FOREIGN KEY (ShowroomID) REFERENCES Showroom(ShowroomID),
    FOREIGN KEY (MovieID) REFERENCES Movie(MovieID)
);

CREATE TABLE Showroom(
    ShowroomID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    ShowingID INT NOT NULL,
    FOREIGN KEY (ShowingID) REFERENCES Showing(ShowingID)
     
);


CREATE TABLE Ticket(
    TicketID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    PurchaseDate DATE,
    TotalPrice DECIMAL(10, 2),
    ShowingID INT NOT NULL,
    UserID INT, 
    FOREIGN KEY (ShowingID) REFERENCES Showing(ShowingID),
    FOREIGN KEY (UserID) REFERENCES User(UserID)
     
);

CREATE TABLE Seating (
    SeatingID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    RowLetters VARCHAR(2) NOT NULL,
    SeatNumber VARCHAR(2) NOT NULL,
    ShowroomID INT NOT NULL,
    FOREIGN KEY (ShowroomID) REFERENCES Showroom(ShowroomID)
);



CREATE TABLE Ticket_has_a_seating (
    TicketID INT NOT NULL,
    SeatingID INT NOT NULL,
    IsAvailable BOOLEAN DEFAULT FALSE, -- is the seat available for booking
    PRIMARY KEY (TicketID, SeatingID),
    FOREIGN KEY (TicketID) REFERENCES Ticket(TicketID),
    FOREIGN KEY (SeatingID) REFERENCES Seating(SeatingID)
);