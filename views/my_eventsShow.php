<?php
include '../src/role_check.php';

if ($auth_check == 0){
    echo "У вас недостаточно прав для просмотра этой страницы. Пройдите регистрацию.";
    exit;
}
?>

<link rel="stylesheet" href="../assets/css/style.css">

<header>
    <h1>События, на которые я записан</h1>
</header>

<?php

// Получение user_id пользователя из токена
$token = $_SESSION['token'] ?? '';

// Получаем user_id из базы данных
$stmt = $db->prepare("SELECT id FROM users WHERE token = ?");
$stmt->execute([$token]);
$user_id = $stmt->fetchColumn();

if (!$user_id) {
    echo "Пользователь не найден или сессия неактивна.";
    exit;
}

// Запрос к базе данных для получения событий, на которые записан пользователь
$query = "SELECT e.id, e.name, e.price, e.number_seats, e.date, e.img 
          FROM events e 
          JOIN event_records er ON e.id = er.event_id 
          WHERE er.user_id = ?";

$events = $db->prepare($query);
$events->execute([$user_id]);

// Преобразование результатов запроса в массив
$eventsArray = $events->fetchAll(PDO::FETCH_ASSOC);

echo "<div class='events-section'>"; // Начало секции событий

foreach ($eventsArray as $event) {
    echo "<div class='event'>";
    echo "<h2>" . htmlspecialchars($event['name']) . "</h2>";
    echo "<p class='price'>Price: " . htmlspecialchars($event['price']) . "</p>";
    echo "<p>Seats available: " . htmlspecialchars($event['number_seats']) . "</p>";
    echo "<p class='event-date'>Date: " . htmlspecialchars($event['date']) . "</p>";
    echo "<form action='../src/event_unwrite.php' method='post'>";
    echo "<input type='hidden' name='event_id' value='" . htmlspecialchars($event['id']) . "'>";
    echo "<button type='submit'>Отписаться</button>";
    echo "</form>";
    echo "<img class='event-img' src='../image/" . rawurlencode(htmlspecialchars($event['img'])) . "'>";
    echo "</div>";
}

echo "</div>"; // Закрытие последней секции событий
?>
