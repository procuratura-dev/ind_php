<?php 
include '../src/role_check.php';

if ($auth_check == 0 || $auth_check == 1){
    echo "У вас недостаточно прав для просмотра этой страницы.";
    exit;
}
?>

<header>
    <h1>События, на которые записаны пользователи</h1>
</header>
<link rel="stylesheet" href="../assets/css/style.css">
<?php

// Запрос к базе данных для получения всех событий и пользователей, записанных на них
$query = "SELECT e.id AS event_id, e.name, e.price, e.number_seats, e.date, e.img, 
          u.name AS user_name, u.surname, u.email, er.id AS record_id
          FROM events e 
          JOIN event_records er ON e.id = er.event_id 
          JOIN users u ON u.id = er.user_id";

$events = $db->query($query);

// Преобразование результатов запроса в массив
$eventsArray = $events->fetchAll(PDO::FETCH_ASSOC);

echo "<div class='events-section'>"; // Начало секции событий

foreach ($eventsArray as $event) {
    echo "<div class='event'>";
    echo "<h2>" . htmlspecialchars($event['name']) . "</h2>";
    echo "<p class='price'>Price: " . htmlspecialchars($event['price']) . "</p>";
    echo "<p>Seats available: " . htmlspecialchars($event['number_seats']) . "</p>";
    echo "<p class='event-date'>Date: " . htmlspecialchars($event['date']) . "</p>";
    echo "<p>Registered by: " . htmlspecialchars($event['user_name']) . " " . htmlspecialchars($event['surname']) . " (" . htmlspecialchars($event['email']) . ")</p>";
    echo "<p>Record ID: " . htmlspecialchars($event['record_id']) . "</p>";  // Выводим ID записи
    echo "<img class='event-img' src='../image/" . rawurlencode(htmlspecialchars($event['img'])) . "'>";
    
    // Форма редактирования мероприятия
    echo "<form action='../views/edit_event.php' method='get'>";
    echo "<input type='hidden' name='event_id' value='" . htmlspecialchars($event['event_id']) . "'>";
    echo "<button type='submit'>Редактировать</button>";
    echo "</form>";
    
    // Форма удаления мероприятия
    echo "<form style='margin-top: 12.5px;' action='../src/delete_event.php' method='post' onsubmit='return confirm(\"Вы уверены, что хотите удалить это мероприятие?\");'>";
    echo "<input type='hidden' name='event_id' value='" . htmlspecialchars($event['event_id']) . "'>";
    echo "<button type='submit'>Удалить</button>";
    echo "</form>";

    echo "</div>";
}

echo "</div>";
?>
