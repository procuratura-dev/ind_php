-- -------------------------------------------------------------
-- TablePlus 5.9.8(548)
--
-- https://tableplus.com/
--
-- Database: event_platform.db
-- Generation Time: 2024-04-23 11:16:38.6330
-- -------------------------------------------------------------


CREATE TABLE event_records (
    id INTEGER PRIMARY KEY,
    user_id INTEGER,
    event_id INTEGER,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (event_id) REFERENCES events(id)
);

CREATE TABLE events (
    id INTEGER PRIMARY KEY,
    name TEXT,
    price REAL,
    number_seats INTEGER,
    date TEXT
, img TEXT);

CREATE TABLE roles (
    id INTEGER PRIMARY KEY,
    name TEXT
);

CREATE TABLE users (
    id INTEGER PRIMARY KEY,
    name TEXT,
    surname TEXT,
    email TEXT UNIQUE
, role_id INTEGER, password TEXT, token TEXT);

INSERT INTO "event_records" ("id", "user_id", "event_id") VALUES
('1', '4', '4');

INSERT INTO "events" ("id", "name", "price", "number_seats", "date", "img") VALUES
('1', 'Турнир по борьбе', '10.0', '25', '2024-04-21', 'Komanda-1024x1024.jpg'),
('2', 'Футбольный матч', '25.0', '100', '2024-04-27', 'c6a78da4937b11eeb256ea706a577e15 upscaled.jpg'),
('3', 'Волейбольная эстафета', '5.0', '35', '2024-04-28', '4cc89ab2-f3f6-4801-b44d-004e209303fe.jpg'),
('4', 'Баскетбольное состязание', '80.0', '60', '2024-04-29', 'scale_1200.png');

INSERT INTO "roles" ("id", "name") VALUES
('5', 'user'),
('777', 'manager');

INSERT INTO "users" ("id", "name", "surname", "email", "role_id", "password", "token") VALUES
('1', 'vasya', 'vasya', 'vasya@mail.ru', '5', '$2y$10$XQbUWjJfRTVSx4qR6y.Ty.94La6hsBeQKO5ND6AXeqS5W3TV.5uhu', NULL),
('4', 'admin', 'admin', 'admin@mail.ru', '777', '$2y$10$jMVgvSEo/VMdMkyb7oTUQenwhv7fMp3IUOfA3Qhp7c/ZPB8k4hFIO', NULL);

