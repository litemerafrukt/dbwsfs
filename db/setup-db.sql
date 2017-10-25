-- SET NAMES utf8;

DROP TABLE IF EXISTS users;
CREATE TABLE users
(
    `id`            INTEGER PRIMARY KEY NOT NULL,
    username        VARCHAR(100) NOT NULL UNIQUE,
    password        VARCHAR(255) NOT NULL,
    email           VARCHAR(100) NOT NULL UNIQUE,
    userlevel       INT NOT NULL,
    cred            INT DEFAULT 0,
    `created`       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `deleted`       DATETIME DEFAULT NULL
);

INSERT INTO users
  (username, password, email, cred, userlevel)
VALUES
  ('admin', '$2y$10$RCFw4V8duXyBzT2Ti5X7ae.YofcFAMyP40ZNrU3hbEhAOJE0tKhEW', 'noone@nonexistant.io', 5, 1),
  ('doe', '$2y$10$OcmC0aLKQLCcszlnF4pd.ebFzH87oxkR2Gx7difCeT1g6UogIiUqO', 'jane@doe.io', 10, 2),
  ('litemerafrukt', '$2y$10$0J5Zto0Cxix1z8o1DH0SuOGTf7sPue2rCmqBPd52QkpVo/Bkgq.B.', 'litemerafrukt@gmail.com', 9, 1)
;

INSERT INTO users
  (username, password, email, cred, userlevel, deleted)
VALUES
  ('deadjoe', '$2y$10$OcmC0aLKQLCcszlnF4pd.ebFzH87oxkR2Gx7difCeT1g6UogIiUqO', 'joe@doe.io', 5, 2, datetime('now'))
;

SELECT * FROM users;

--
-- Table posts
--
DROP TABLE IF EXISTS posts;
CREATE TABLE posts (
    `id`            INTEGER PRIMARY KEY NOT NULL,
    `subject`       VARCHAR(100) NOT NULL,
    `author`        VARCHAR(100) NOT NULL,
    `authorId`      INT NOT NULL,
    `authorEmail`   VARCHAR(100) NOT NULL,
    `rawText`       TEXT NOT NULL,
    `points`        INT DEFAULT 0,
    `type`          VARCHAR(1) DEFAULT 'p' NOT NULL,
    `created`       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated`       DATETIME DEFAULT NULL
);

INSERT INTO posts
  (subject, points, author, authorId, authorEmail, rawText)
VALUES
  ('First!', -1, 'litemerafrukt', 3, 'litemerafrukt@gmail.com', 'Direkt från `setup-db.sql`!'),
  ('Second', 0, 'doe', 2, 'jane@doe.io', 'with two comments'),
  ('Ramda', 5, 'admin', 1, 'admin@admin.io', 'Just check it out already!'),
  ('Monad', 1, 'deadjoe', 4, 'deadjoe@oldmail.com', 'A monad is a burrito.'),
  ('Funktor', 2, 'doe', 2, 'jane@doe.io', 'En funktor är nått du kan map:a över.')
;

SELECT * FROM posts;

--
-- Table comments
--
DROP TABLE IF EXISTS comments;
CREATE TABLE comments (
    `id`          INTEGER PRIMARY KEY NOT NULL,
    `postId`      INT NOT NULL,
    `parentId`    INT DEFAULT 0,
    `authorId`    INT NOT NULL,
    `authorName`  VARCHAR(100) DEFAULT 'unknown',
    `text`        TEXT NOT NULL,
    `points`      INT DEFAULT 0,
    `marked`      INT DEFAULT 0,
    `created`     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated`     DATETIME DEFAULT NULL
);

INSERT INTO comments
  (postId, parentId, points, authorId, authorName,`text`)
VALUES
  (2, 0, 0, 3, 'litemerafrukt', 'whatever'),
  (3, 0, 1 ,1, 'admin', 'whatnot???'),
  (3, 2, 3, 4, 'deadjoe', 'hear hear'),
  (2, 0, 1, 4, 'deadjoe', 'chim in')
;

select * from comments;

--
-- Tags
--

DROP TABLE IF EXISTS tags;
CREATE TABLE tags (
  `id`    INTEGER PRIMARY KEY NOT NULL,
  `tag`   VARCHAR(50) NOT NULL UNIQUE
);

INSERT INTO tags
  (tag)
VALUES
  ('javascript'),
  ('haskell'),
  ('kategoriteori'),
  ('monad'),
  ('funktor'),
  ('php')
;

SELECT * FROM tags;

DROP TABLE IF EXISTS postTagLinks;
CREATE TABLE postTagLinks (
  `id`     INTEGER PRIMARY KEY NOT NULL,
  `postId` INT NOT NULL,
  `tagId`  INT NOT NULL,

	FOREIGN KEY (`postId`) REFERENCES `posts` (`id`),
	FOREIGN KEY (`tagId`) REFERENCES `tags` (`id`)
);

INSERT INTO postTagLinks
  (postId, tagId)
VALUES
  (4, 3),
  (4, 4),
  (5, 3),
  (5, 5),
  (3, 1)
;
