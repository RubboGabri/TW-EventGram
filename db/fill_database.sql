USE eventgramdb;

-- Inserisci utenti
INSERT INTO Utenti (username, password, salt, info) VALUES
('user1', SHA2('password1', 256), SHA2('salt1', 256), 'Info about user1'),
('user2', SHA2('password2', 256), SHA2('salt2', 256), 'Info about user2'),
('user3', SHA2('password3', 256), SHA2('salt3', 256), 'Info about user3');

-- Inserisci location
INSERT INTO Locations (name) VALUES
('Cesena'),
('Cervia');

-- Inserisci categorie
INSERT INTO Categorie (name) VALUES
('Disco'),
('Beach Party');

-- Inserisci post (eventi)
INSERT INTO Post (title, description, eventDate, IDuser, IDlocation, price, IDcategoria, minAge) VALUES
('Serata in Discoteca', 'Una fantastica serata in discoteca con DJ set e luci spettacolari.', '2024-07-15 22:00:00', 1, 1, 20, 1, 18),
('Festa in Spiaggia', 'Una festa in spiaggia con musica dal vivo e barbecue.', '2024-07-20 18:00:00', 2, 2, 15, 2, 0);

-- Inserisci commenti
INSERT INTO Commenti (text, IDpost, IDuser) VALUES
('Ci sta!', 1, 2),
('Sembra fantastico!', 2, 1);

-- Inserisci follower
INSERT INTO Follower (IDfollower, IDfollowed) VALUES
(2, 1),
(3, 1);

-- Inserisci notifiche
INSERT INTO Notifiche (type, IDuser, notifier, IDpost) VALUES
('Follow', 1, 2, NULL),
('Follow', 1, 3, NULL),
('Comment', 1, 2, 1),
('Comment', 2, 1, 2);

-- Inserisci iscrizioni
INSERT INTO Iscrizioni (IDuser, IDpost) VALUES
(2, 1),
(3, 2);

-- Inserisci likes
INSERT INTO Likes (IDpost, IDuser) VALUES
(1, 2),
(2, 3);

-- Inserisci tentativi di login (facoltativo)
INSERT INTO Login_attempts (IDuser, attemptNum) VALUES
(1, '1'),
(2, '1');
