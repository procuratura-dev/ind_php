<?php
include '../src/role_check.php';

if ($auth_check == 0){
    echo "Вы не авторизованы.";
    exit;
}

// Проверка, авторизован ли пользователь
if (isset($_SESSION['token'])) {
    $token = $_SESSION['token'];

    // Удаление токена из базы данных для деавторизации пользователя
    $stmt = $db->prepare("UPDATE users SET token = NULL WHERE token = ?");
    $stmt->execute([$token]);

    // Очистка сессии
    $_SESSION = []; // Очищаем массив сессии
    session_destroy(); // Уничтожаем сессию

    // Перенаправление на главную страницу
    header("Location: ../public/index.php");
    exit;
} else {
    // Если пользователь не авторизован, также перенаправляем на главную
    header("Location: ../public/index.php");
    exit;
}
?>
