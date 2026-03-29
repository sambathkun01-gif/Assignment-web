-- ============================================================
--  MoveMovie Database  |  Import this in phpMyAdmin
-- ============================================================
CREATE DATABASE IF NOT EXISTS movemovie CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE movemovie;

-- Users
CREATE TABLE IF NOT EXISTS users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    username    VARCHAR(50)  NOT NULL UNIQUE,
    email       VARCHAR(100) NOT NULL UNIQUE,
    passwd      VARCHAR(255) NOT NULL,
    role        ENUM('user','admin') DEFAULT 'user',
    photo       VARCHAR(255) DEFAULT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Movies
CREATE TABLE IF NOT EXISTS movies (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    title        VARCHAR(200) NOT NULL,
    description  TEXT,
    genre        VARCHAR(100),
    release_date DATE,
    image        VARCHAR(255) DEFAULT NULL,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Reviews
CREATE TABLE IF NOT EXISTS reviews (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT NOT NULL,
    movie_id    INT NOT NULL,
    rating      TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment     TEXT,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)  REFERENCES users(id)  ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_movie (user_id, movie_id)
);

-- Review Likes
CREATE TABLE IF NOT EXISTS review_likes (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    reviews_id INT NOT NULL,
    user_id    INT NOT NULL,
    FOREIGN KEY (reviews_id) REFERENCES reviews(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id)    REFERENCES users(id)   ON DELETE CASCADE,
    UNIQUE KEY unique_like (reviews_id, user_id)
);

-- ============================================================
-- Seed Data
-- ============================================================
-- Admin  password: admin123
INSERT INTO users (name, username, email, passwd, role) VALUES
('Administrator', 'admin', 'admin@movemovie.com', 'admin123', 'admin'),
('John Doe',      'john',  'john@example.com',    'john123',  'user'),
('Sara Lee',      'sara',  'sara@example.com',    'sara123',  'user');

INSERT INTO movies (title, description, genre, release_date) VALUES
('Inception',        'A thief who steals corporate secrets through dream-sharing technology is given the inverse task of planting an idea into a CEO\'s mind.',  'Sci-Fi',   '2010-07-16'),
('The Dark Knight',  'When the Joker wreaks havoc on Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.', 'Action',   '2008-07-18'),
('Interstellar',     'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.',                                      'Sci-Fi',   '2014-11-07'),
('Parasite',         'Greed and class discrimination threaten the newly formed symbiotic relationship between the wealthy Park family and the destitute Kim clan.','Thriller', '2019-05-30'),
('The Godfather',    'An organized crime dynasty\'s aging patriarch transfers control of his clandestine empire to his reluctant son.',                           'Drama',    '1972-03-24'),
('Joker',            'A mentally troubled stand-up comedian embarks on a downward spiral that leads to the creation of an iconic villain.',                       'Drama',    '2019-10-04'),
('Dune',             'A noble family becomes embroiled in a war for control over the galaxy\'s most valuable asset while its heir is troubled by visions of a dark future.', 'Sci-Fi', '2021-10-22'),
('Avengers: Endgame','After the devastating events of Infinity War, the remaining Avengers must assemble once more to undo Thanos\' actions.',                     'Action',   '2019-04-26');

INSERT INTO reviews (user_id, movie_id, rating, comment) VALUES
(2, 1, 5, 'Mind-blowing! The layers-within-layers concept is executed perfectly.'),
(3, 1, 4, 'Brilliant concept but gets confusing on first watch. Worth multiple viewings.'),
(2, 2, 5, 'Heath Ledger\'s Joker is unmatched. The greatest superhero film ever made.'),
(3, 3, 5, 'Emotionally devastating and scientifically fascinating. Hans Zimmer\'s score is incredible.'),
(2, 4, 5, 'A masterclass in social commentary. Bong Joon-ho deserved every Oscar.');
