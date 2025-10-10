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

-- CREATE TABLE WalkIn (
--     WalkInDI INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
--     Email VARCHAR(100) NOT NULL,
--     TicketsID INT NOT NULL,
--     PRIMARY KEY (TicketsID),
--     FOREIGN KEY (TicketsID) REFERENCES TicketsID(TicketsID), 
-- )


CREATE TABLE Movie (
    MovieID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Titel VARCHAR(100),
    Decscription TEXT,
    Poster VARCHAR(255), -- URL TO IMAGE ?!?!?!?!
    ageRating INT,
    Duration INT, -- in minutes and hour (1.30 = 1 hour and 30 minutes)
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
    IsAvailable BOOLEAN DEFAULT TRUE, -- is the seat available for booking
    ShowingID INT NOT NULL,
    FOREIGN KEY (ShowingID) REFERENCES Showing(ShowingID)
);

CREATE TABLE Tickets(
    TicketsID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    PurchaseDate DATE,
    TotalPrice DECIMAL(10, 2),
    ShowingID INT NOT NULL,
    UserID INT, -- can be null if walk-in
    WalkInID INT, -- can be null if registered user
    FOREIGN KEY (ShowingID) REFERENCES Showing(ShowingID),
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (WalkInID) REFERENCES WalkIn(WalkInID)   
);

CREATE TABLE Tickets_has_a_seating (
    TicketsID INT NOT NULL,
    SeatingID INT NOT NULL,
    PRIMARY KEY (TicketsID, SeatingID),
    FOREIGN KEY (TicketsID) REFERENCES Tickets(TicketsID),
    FOREIGN KEY (SeatingID) REFERENCES Seating(SeatingID)
);