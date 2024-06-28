-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------            
-- Host: localhost    Database: eventgramdb
-- ********************************************* 

--
-- Current Database: `eventgramdb`
--

DROP DATABASE IF EXISTS eventgramdb;

CREATE DATABASE if NOT EXISTS eventgramdb;
USE eventgramdb;


-- Tables structure for table `Utenti`

CREATE TABLE Utenti (
     IDuser int PRIMARY KEY NOT NULL AUTO_INCREMENT,
     username varchar(50) NOT NULL UNIQUE,
     password char(128) NOT NULL, 
     salt char(128) NOT NULL,
     info text,
     profilePic mediumblob,
     creationDate datetime DEFAULT CURRENT_TIMESTAMP
     );

-- Tables structure for table `Locations`

CREATE TABLE Locations (
     IDlocation int PRIMARY KEY AUTO_INCREMENT,
     name varchar(100) NOT NULL
     );

-- Tables structure for table `Categorie`

CREATE TABLE Categorie (
    IDcategory int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name varchar(30) NOT NULL 
    );

-- Tables structure for table `Post`

CREATE TABLE Post (
    IDpost int PRIMARY KEY AUTO_INCREMENT,
    img mediumblob,
    title char(50) NOT NULL,
    description text NOT NULL,
    postDate datetime DEFAULT CURRENT_TIMESTAMP,
    eventDate datetime NOT NULL,
    IDuser int NOT NULL,
    IDlocation int NOT NULL,
    price int NOT NULL,
    IDcategoria int NOT NULL,
    minAge int DEFAULT NULL,
    FOREIGN KEY (IDuser) REFERENCES Utenti(IDuser) ON DELETE CASCADE,
    FOREIGN KEY (IDlocation) REFERENCES Locations(IDlocation) ON DELETE CASCADE,
    FOREIGN KEY (IDcategoria) REFERENCES Categorie(IDcategory) ON DELETE CASCADE
);


-- Tables structure for table `Commenti`

CREATE TABLE Commenti (
     IDcomment int PRIMARY KEY NOT NULL AUTO_INCREMENT,
     text tinytext NOT NULL,
     date datetime DEFAULT CURRENT_TIMESTAMP,
     IDpost int NOT NULL,
     IDuser int NOT NULL,
     IDparent int DEFAULT NULL,
     FOREIGN KEY (IDparent) REFERENCES Commenti(IDcomment) ON DELETE CASCADE
     );

-- Tables structure for table `Follower`

CREATE TABLE Follower (
     IDfollower int NOT NULL,
     IDfollowed int NOT NULL,
     notification boolean DEFAULT TRUE,
     PRIMARY KEY (IDfollower, IDfollowed),
     FOREIGN KEY (IDfollower) REFERENCES Utenti(IDuser) ON DELETE CASCADE,
     FOREIGN KEY (IDfollowed) REFERENCES Utenti(IDuser) ON DELETE CASCADE
     );

-- Tables structure for table `Notifiche`

CREATE TABLE Notifiche (
     IDnotification int PRIMARY KEY NOT NULL AUTO_INCREMENT,
     type enum ('Follow','Comment','Post', 'Like') NOT NULL,
     IDuser int NOT NULL,  
     notifier int NOT NULL,  
     IDpost int,  
     date datetime DEFAULT CURRENT_TIMESTAMP,
     is_read tinyint NOT NULL DEFAULT 0,
     FOREIGN KEY (IDuser) REFERENCES Utenti(IDuser) ON DELETE CASCADE,
     FOREIGN KEY (notifier) REFERENCES Utenti(IDuser) ON DELETE CASCADE,
     FOREIGN KEY (IDpost) REFERENCES Post(IDpost) ON DELETE CASCADE
     );

-- Tables structure for table `Iscrizioni`

CREATE TABLE Iscrizioni (
     IDuser int NOT NULL,
     IDpost int NOT NULL,
     PRIMARY KEY (IDuser, IDpost),
     FOREIGN KEY (IDuser) REFERENCES Utenti(IDuser) ON DELETE CASCADE,
     FOREIGN KEY (IDpost) REFERENCES Post(IDpost) ON DELETE CASCADE
     );

-- Tables structure for table `Likes`

CREATE TABLE Likes (
     IDpost int NOT NULL,
     IDuser int NOT NULL,
     FOREIGN KEY (IDuser) REFERENCES Utenti(IDuser) ON DELETE CASCADE,
     FOREIGN KEY (IDpost) REFERENCES Post(IDpost) ON DELETE CASCADE,
     PRIMARY KEY(IDpost,IDuser)
     );

-- Tables structure for table `Login_attempts`

CREATE TABLE Login_attempts (
     IDuser int NOT NULL,
     attemptNum varchar(30) NOT NULL,
     FOREIGN KEY (IDuser) REFERENCES Utenti(IDuser) ON DELETE CASCADE,
     PRIMARY KEY(IDuser,attemptNum)
     );

CREATE OR REPLACE VIEW Infopost AS
     SELECT A.IDpost, A.numLikes, B.numComments
     FROM (SELECT P.IDpost, COUNT(Likes.IDuser) as numLikes
          FROM Post P
          LEFT JOIN Likes ON P.IDpost = Likes.IDpost
          GROUP BY P.IDpost) AS A,
          (SELECT P1.IDpost, COUNT(Commenti.IDcomment) as numComments
          FROM Post P1
          LEFT JOIN Commenti ON P1.IDpost = Commenti.IDpost
          GROUP BY P1.IDpost) AS B
     WHERE A.IDpost = B.IDpost;
