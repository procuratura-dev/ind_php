# Общее описание

Сайт предназначен для организации и участия в спортивных событиях города. Он позволяет пользователям регистрироваться на мероприятия, просматривать предстоящие события, а также управлять собственными данными и регистрациями на события. Для администраторов сайта предоставляются дополнительные функции, такие как добавление и редактирование мероприятий, управление пользователями и просмотр статистики регистраций.

## Технологическая реализация

База данных: Используется SQLite для хранения данных о пользователях, мероприятиях и регистрациях.  
Безопасность: Реализована проверка прав доступа через сценарий role_check.php, который контролирует доступ к различным разделам сайта в зависимости от роли пользователя.  
Интерфейс: HTML и CSS используются для создания и стилизации пользовательского интерфейса.   Предусмотрена адаптивность для различных устройств.  

# Инструкция по запуску проекта

Чтобы запустить PHP-проект, нужно выполнить несколько шагов, включая настройку серверной среды, базы данных. Вот пошаговое руководство по запуску проекта:

### Шаг 1: Установка необходимого программного обеспечения

Установка PHP и sqlite3: Убедитесь, что на вашем сервере установлен PHP и sqlite3.

### Шаг 2: Настройка проекта

Клонирование или загрузка кода: Скопируйте файлы PHP-проекта в папку вашего сервера.
Импортируйте при помощи sql кода базу данных sqlite3:

```sql
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
```
### Шаг 3: Запуск проекта

Перейдите в корневую папку проекта php_ind/ и запустите там php сервер, например php -S localhost:8080

### Шаг 4: Проверка работоспособности сайта

Зайдите в любой браузер и перейдите на сайт localhost:8080

## Основные функциональные возможности

1. Регистрация и авторизация пользователей: Пользователи могут создать аккаунт и авторизоваться на сайте, чтобы участвовать в мероприятиях и получать информацию о них.
2. Просмотр мероприятий: Главная страница (index.php) отображает список доступных спортивных событий с деталями о каждом, такими как дата, стоимость участия и количество доступных мест.
3. Управление мероприятиями: Администраторы могут добавлять и редактировать события через форму (admin_menu.php), которая включает загрузку изображений и указание деталей мероприятия.
4. Регистрация на мероприятия: Пользователи могут записываться на мероприятия через форму регистрации, доступную на странице мероприятия.
5. Управление участниками: Администраторы имеют доступ к списку зарегистрированных пользователей на каждое мероприятие (users_eventsShow.php) и могут управлять их ролями или участием.
6. Личный кабинет пользователя: Пользователи могут просматривать список мероприятий, на которые они зарегистрированы (my_eventsShow.php), и отписываться от них.