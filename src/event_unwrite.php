<?php
include '../src/role_check.php';

if ($auth_check == 0){
    echo "У вас недостаточно прав для просмотра этой страницы. Авторизуйтесь.";
    exit;
}

$token = $_SESSION['token'] ?? '';

// Получаем user_id из базы данных
$stmt = $db->prepare("SELECT id FROM users WHERE token = ?");
$stmt->execute([$token]);
$user_id = $stmt->fetchColumn();

if (!$user_id) {
    echo "Пользователь не найден или сессия неактивна.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];

    // Удаление записи из event_records
    $stmt = $db->prepare("DELETE FROM event_records WHERE user_id = ? AND event_id = ?");
    $result = $stmt->execute([$user_id, $event_id]);

    if ($result) {
        echo "Вы успешно отписались от мероприятия!";
    } else {
        echo "Произошла ошибка при отмене регистрации.";
    }
}

header("Location: ../views/my_eventsShow.php"); // Возвращение на страницу с событиями
exit;
?>
