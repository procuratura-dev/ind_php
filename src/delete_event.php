<?php
include '../src/role_check.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    
    // Подготовка запроса на удаление
    $stmt = $db->prepare("DELETE FROM events WHERE id = ?");
    $stmt->execute([$event_id]);

    $stmt = $db->prepare("DELETE FROM event_records WHERE event_id = ?");
    $stmt->execute([$event_id]);
    // После удаления перенаправляем обратно на список событий
    header("Location: ../public/index.php");
    exit;
}
?>
