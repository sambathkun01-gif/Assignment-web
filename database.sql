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

INSERT INTO `movies` (`id`, `title`, `description`, `genre`, `release_date`, `image`, `created_at`) VALUES
(1, 'Bumblebee', 'Crash-landing on Earth in 1987, lovable hero Bumblebee befriends a feisty teenager while battling sinister Decepticons and a secret government agency.', 'Sci-Fi', '2026-03-30', './assets/images/Image-69ca370f7f9ef.png', '2026-03-27 15:10:20'),
(2, '4 Kings 2', 'After a drug dealer schemes against them in secret, two student gangs start a bitter feud that triggers a chain of violent consequences.', 'Action', '2008-07-18', './assets/images/Image-69ca3a23a2d6d.png', '2026-03-27 15:10:20'),
(3, 'Bon Appetit, Your Majesty', 'Yeon Ji Yeong is a French chef with a cheerful yet strong personality. On the day she wins the best cooking competition in France, Ji Yeong suddenly ends up in the Joseon Dynasty. Instead of the Michelin 3-star bistro in Paris where she was offered the job as head chef, she meets the worst tyrant and has to prepare fusion royal cuisine for him. Lee Heon is the king of Joseon and the owner of the restaurant where Ji Yeong works. Lee Heon, the worst tyrant who has wielded absolute power since becoming king, possesses an absolute sense of taste whose tongue is so sensitive that it can sense the changes in the taste of food depending on the weather. He accidentally meets the ghost woman, Ji Yeong, and falls in love with her food, so he lets her into the palace. Kang Mok Ju is a greedy person who has been granted the favor of Lee Heon and has risen to the position of a long-time concubine, adding tension to the relationship between Yeon Ji Yeong and Lee Heon. Mok Ju, who has become the king\'s concubine due to her beauty and talent, is someone who hides her endless ambition for power. Prince Je Seon is a member of the royal family of Joseon. Prince Je Seon, the most powerful political enemy of King Lee Heon, has a cruel nature where getting rid of people he doesn\'t like is easier than drinking water. After the death of his father, he acts as a vagabond to save his life, but he is always looking for a chance to drive out Lee Heon and become king.', 'Drama', '2026-03-30', './assets/images/Image-69ca32f288c76.png', '2026-03-27 15:10:20'),
(5, 'Lovely Runner', 'In the glitzy realm of stardom, Ryu Seon Jae shines as a top-tier celebrity, captivating the spotlight since his debut. Despite the facade of a perfect life, the demanding nature of the entertainment industry has left him utterly exhausted. Im Sol, an ardent admirer, holds an affectionate love for Ryu Seon Jae. A childhood accident derailed her dreams, yet the solace found in Ryu Seon Jae\'s music on the radio transformed her into an unwavering fan. The narrative takes a poignant turn when Im Sol, reeling from the breaking news of Ryu Seon Jae\'s tragic demise, experiences a miraculous twist of fate. Transported back 15 years into the past, she confronts Ryu Seon Jae in his 19-year-old high school self. Im Sol grapples with the formidable challenge of altering the trajectory of his future, driven by an unyielding determination to avert the impending tragedy.', 'Drama', '2026-03-30', './assets/images/Image-69ca3159f333d.png', '2026-03-27 15:10:20'),
(6, 'The First Frost', 'Wen Yi Fan, a reporter, went to a bar called Jia Ban to meet with her best friend Zhong Si Qiao. While she was at the bar she meets Sang Yan, a department manager and one of the owners of Jia Ban. He was Yi Fan\'s high school deskmate, and the guy she once fell in love with. The two bump into each other and as Yi Fan pretended that she did not know who Sang Yan was, Sang Yan did the same. After some problems occurred, the two accidentally became housemates and later on, reconciled their love once again.', 'Drama', '2026-03-30', './assets/images/Image-69ca31c708745.png', '2026-03-27 15:10:20'),
(7, 'Jurassic Park', 'Science, sabotage and prehistoric DNA collide when cloned dinosaurs escape their enclosures and begin preying on the guests at a top-secret theme park.', 'Sci-Fi', '2026-03-30', './assets/images/Image-69ca36ba7c9fc.png', '2026-03-27 15:10:20'),
(8, 'King the Land', 'Heir Goo Won cannot stand fake smiles. When he meets Cheon Sa Rang, her sincere smile is at the ready. The pair seek to create happy moments where they can smile brightly at each other. King of the Land is a VVIP business lounge, a paradise catering to wealthy hoteliers. It is owned by The King Group, with hotels, distribution companies, and an airline in its portfolio. Now Goo Won has been thrown into an inheritance tug-of-war. With his brilliant mind, innate grace, and captivating charm, he has everything but lacks common sense when dating. Cheon Sa Rang makes the world brighter with just her smile. She is thrilled to land a job at the King Hotel, where she had some of her happiest times as a child. She must now put those sweet memories away and mature quickly to face the frequent workplace prejudices and misunderstandings that come her way.', 'Drama', '2026-03-30', './assets/images/Image-69ca3386a1ebd.png', '2026-03-27 15:10:20'),
(9, 'Head over Heels', 'Park Seong A is a high school student, but, at night, she is a shaman named Fairy Cheon Ji. When she works as a shaman, she covers her face partially to hide her identity. She is famous as Fairy Cheon Ji and she is busy working with her clients who come to ask about their future, fortune, illnesses, and other things. One night, Bae Gyeon U and his mother come to visit Fairy Cheon Ji. Park Seong A has a crush on him at first sight, but she sees that he is destined to die soon. The next day, Bae Gyeon U appears in front of her as a new transfer student in her class. She decides to save him from his destiny.', 'Drama', '2026-03-30', './assets/images/Image-69ca341eba5e7.png', '2026-03-30 08:28:14'),
(10, 'Chappie', 'In a futuristic society where an indestructible robot police force keeps crime at bay, a lone droid evolves to the next level of artificial intelligence.', 'Sci-Fi', '2026-03-30', './assets/images/Image-69ca375b93c9b.png', '2026-03-30 08:42:03'),
(11, 'Hulk', 'Following a fateful lab incident, mild-mannered scientist Bruce Banner struggles to control the fearsome green giant he becomes when angry or threatened.', 'Sci-Fi', '2026-03-30', './assets/images/Image-69ca37f309e9d.png', '2026-03-30 08:44:35'),
(12, 'The Flash', 'A forensics expert who wakes from a coma with amazing new powers squares off against forces threatening the city in this live-action superhero romp.', 'Sci-Fi', '2026-03-30', './assets/images/Image-69ca383190800.png', '2026-03-30 08:45:37'),
(13, 'GATAO: Like Father Like Son', 'Ambitious drug dealer Michael and his brother Scorpion find themselves drafted into their father\'s turf war as rival gangs compete in Dingzhuang.', 'Action', '2026-03-30', './assets/images/Image-69ca3a5a73888.png', '2026-03-30 08:54:50'),
(14, 'High & Low The Worst', 'The street fighters of Oya High go up against the delinquent brawlers of Housen Academy in this action-packed “High & Low,” “Crows” and \"Worst\" crossover.', 'Action', '2026-03-30', './assets/images/Image-69ca3a9bb8e37.png', '2026-03-30 08:55:55'),
(15, 'High & Low The Movie', 'The five rival gangs ruling the SWORD district unite to face off against a 500-member strong attack led by a legendary gang leader.', 'Action', '2026-03-30', './assets/images/Image-69ca3aebc2b58.png', '2026-03-30 08:57:15'),
(16, 'In Youth We Trust', 'A poor young man with a troubled childhood is sent to prison after a shooting and must fight for his place among its brutal gangs to survive.', 'Action', '2026-03-30', './assets/images/Image-69ca3b366f18b.png', '2026-03-30 08:58:30'),
(17, 'Bad Guys', 'A detective returns from suspension and pulls together an unorthodox special investigation team in order to capture a serial killer.', 'Action', '2026-03-30', './assets/images/Image-69ca3b86ba40a.png', '2026-03-30 08:59:50'),
(18, 'Goedam', 'When night falls on the city, shadows and spirits come alive in this horror anthology series centered on urban legends.', 'Horror', '2026-03-30', './assets/images/Image-69ca4717f174c.png', '2026-03-30 09:49:12'),
(19, 'The Grudge', 'An investigator follows the trail of a grisly case back to a cursed house harboring a tangled, gruesome history — and an ugly, boundless rage.', 'Horror', '2026-03-30', './assets/images/Image-69ca47a4420c8.png', '2026-03-30 09:51:32'),
(20, 'Five Nights at Freddy\'s', 'After accepting a night job at an infamous, shuttered children\'s restaurant, a struggling security guard must survive its band of possessed animatronics.', 'Horror', '2026-03-30', './assets/images/Image-69ca47fa60a82.png', '2026-03-30 09:52:58'),
(21, 'Clown of the Dead', 'Three friends investigating the deaths of local children face a killer clown, summoned by a music box, and race to stop him before he strikes again.', 'Horror', '2026-03-30', './assets/images/Image-69ca4843d644b.png', '2026-03-30 09:54:11'),
(22, 'khmer', 'ghfgfgfghggk', 'Action', '2026-04-02', './assets/images/Image-69ce073f64f75.png', '2026-04-02 06:05:51');

INSERT INTO `users` (`id`, `name`, `username`, `email`, `passwd`, `role`, `photo`, `created_at`) VALUES
(1, 'Administrator', 'admin', 'admin@movemovie.com', 'admin123', 'admin', NULL, '2026-03-27 15:10:20'),
(2, 'John Doe', 'john', 'john@example.com', 'john123', 'user', NULL, '2026-03-27 15:10:20'),
(3, 'Sara Lee', 'sara', 'sara@example.com', 'sara123', 'user', NULL, '2026-03-27 15:10:20'),
(4, 'sambathkun', 'Sambath', 'sam@gmail.com', '$2y$10$3o6hkWESX38EL8vlZYRZEOTwswcNjMlbgvXiKenuHxB0oHmxSWopm', 'user', NULL, '2026-03-28 02:24:04'),
(5, 'sam', 'sam', 'sam1@gmail.com', '$2y$10$tXrDujFQLsBv/J8U6ITZj.cMm1RMTm3p81buyF6QKdfUZaRttasaG', 'user', NULL, '2026-03-29 02:00:45'),
(6, 'sam', 'sam2', 'sam2@gmail.com', '$2y$10$taboP8t5puQJb6WKSwyvDeUFVgI8EZu0v.Z8r14jexd0t6SYfQuEe', 'user', NULL, '2026-04-02 06:00:16');
