DROP SCHEMA IF EXISTS assignment;

CREATE SCHEMA assignment;

USE assignment;

CREATE TABLE Users (
    UserName VARCHAR(30) NOT NULL,
    Pass VARCHAR(50) NOT NULL,
    Gender VARCHAR(1) NOT NULL,
    Age INT NOT NULL,
    Birth DATE NOT NULL,
    Email VARCHAR(20) NOT NULL,
    Phone VARCHAR(10) NOT NULL,
    PRIMARY KEY (UserName)
);

INSERT INTO
Users (UserName, Pass)
VALUES
('Ming Jian', 'abc123');

INSERT INTO
Users (UserName, Pass)
VALUES
('Foo Sen Yang', 'phpgod');

INSERT INTO
Users (UserName, Pass)
VALUES
('Daniel', 'idkmaybe123');

INSERT INTO
Users (UserName, Pass)
VALUES
('Ah Heng', 'haha');

CREATE TABLE Admin (
    AdminName VARCHAR(30) NOT NULL,
    AdminPass VARCHAR(50) NOT NULL,
    PRIMARY KEY (AdminName)
);

INSERT INTO
Admin (AdminName, AdminPass)
VALUES
('admin', 'abc123');

CREATE TABLE Events (
    EventDate DATE NOT NULL,
    EventName VARCHAR(50) NOT NULL,
    AdminName VARCHAR (30) NOT NULL,
    PRIMARY KEY (EventName),
    FOREIGN KEY (AdminName) REFERENCES Admin(AdminName)
);

CREATE TABLE EventJoin (
    UserJoined VARCHAR(30) NOT NULL,
    EventJoined VARCHAR(50) NOT NULL,
    JoinDate DATE NOT NULL,
    FOREIGN KEY (UserJoined) REFERENCES Users(UserName),
    FOREIGN KEY (EventJoined) REFERENCES Events(EventName)
);

CREATE TABLE Feedback (
    UserName VARCHAR(30) NOT NULL,
    Feedback VARCHAR(200) NOT NULL,
    FeedbackDate DATE NOT NULL,
    FOREIGN KEY (UserName) REFERENCES Users(UserName)
);