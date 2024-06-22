-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------            
-- Host: localhost    Database: eventgramdb
-- ********************************************* 

USE eventgramdb;

-- Creazione delle tabelle
-- Inserimento di utenti di esempio
INSERT INTO Utenti (username, password, salt, info, profilePic) VALUES
('sajmir', 'smr', 'salt1', 'Ita', 'profile_pic1.jpg'),
('gabriele', 'gbr', 'salt2', 'Ita', 'profile_pic2.jpg');

-- Inserimento di location di esempio
INSERT INTO Locations (name) VALUES
('Cervia'),
('Cesena');

-- Inserimento di categorie di esempio
INSERT INTO Categorie (name) VALUES
('OVER 18'),
('UNDER 18');

-- Inserimento di post di esempio
INSERT INTO Post (img, title, description, eventDate, IDuser, IDlocation, price, IDcategoria, minAge) VALUES
(LOAD_FILE('/path/to/image1.jpg'), 'Post Title 1', 'Description for Post 1', '2024-07-01 10:00:00', 1, 1, 20, 1, 18),
(LOAD_FILE('/path/to/image2.jpg'), 'Post Title 2', 'Description for Post 2', '2024-08-01 12:00:00', 2, 2, 15, 2, NULL);

-- Inserimento di commenti di esempio
INSERT INTO Commenti (text, IDpost, IDuser) VALUES
('This is a comment on Post 1', 1, 2),
('This is another comment on Post 1', 1, 1);

-- Inserimento di follower di esempio
INSERT INTO Follower (IDfollower, IDfollowed) VALUES
(1, 2),
(2, 1);

-- Inserimento di notifiche di esempio
INSERT INTO Notifiche (type, IDuser, notifier, IDpost) VALUES
('Follow', 1, 2, NULL),
('Comment', 2, 1, 1);

-- Inserimento di iscrizioni di esempio
INSERT INTO Iscrizioni (IDuser, IDpost) VALUES
(1, 1),
(2, 2);

-- Inserimento di likes di esempio
INSERT INTO Likes (IDpost, IDuser) VALUES
(1, 2),
(2, 1);

-- Inserimento di tentativi di login di esempio
INSERT INTO Login_attempts (IDuser, attemptNum) VALUES
(1, '2023-06-18 10:00:00'),
(2, '2023-06-18 11:00:00');
