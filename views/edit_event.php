<?php
include '../src/role_check.php';

if ($auth_check == 0 || $auth_check == 1){
    echo "У вас недостаточно прав для просмотра этой страницы.";
    exit;
}

$event_id = $_GET['event_id'] ?? null;

if ($event_id) {
    $stmt = $db->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $number_seats = $_POST['number_seats'];
    $date = $_POST['date'];
    $imgPath = $event['img']; // сохраняем старый путь изображения

    if (isset($_FILES['eventImg']) && $_FILES['eventImg']['error'] == 0) {
        $target_dir = "../image/";
        $target_file = $target_dir . basename($_FILES["eventImg"]["name"]);
        if (move_uploaded_file($_FILES["eventImg"]["tmp_name"], $target_file)) {
            $imgPath = basename($_FILES["eventImg"]["name"]); // обновляем путь, если загрузка успешна
        }
    }

    $updateStmt = $db->prepare("UPDATE events SET name = ?, price = ?, number_seats = ?, date = ?, img = ? WHERE id = ?");
    $updateStmt->execute([$name, $price, $number_seats, $date, $imgPath, $event_id]);

    header("Location: ../views/users_eventsShow.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"], input[type="date"], input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #5c67f2;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #5058e5;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <label for="name">Event Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($event['name']); ?>">
            <label for="price">Price:</label>
            <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($event['price']); ?>">
            <label for="number_seats">Number of Seats:</label>
            <input type="text" id="number_seats" name="number_seats" value="<?php echo htmlspecialchars($event['number_seats']); ?>">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($event['date']); ?>">
            <label for="eventImg">Change Event Image:</label>
            <input type="file" id="eventImg" name="eventImg" accept="image/*">
            <button type="submit">Update Event</button>
        </form>
    </div>
</body>
</html>
