<?php
require 'db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM devices WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$device = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $location = $_POST['location'];
    $floor = $_POST['floor'];
    $maintenance_desc = $_POST['maintenance_desc'];
    $notes = $_POST['notes'];

    $update = $conn->prepare("UPDATE devices SET location=?, floor=?, maintenance_desc=?, notes=? WHERE id=?");
    $update->bind_param("ssssi", $location, $floor, $maintenance_desc, $notes, $id);
    $update->execute();
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
<nav>
    <ul>
        <li><a href="dashboard.php">لوحة التحكم</a></li>
        <li><a href="logout.php">تسجيل الخروج</a></li>
    </ul>
</nav>
    <title>إضافة بيانات الجهاز</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <h2>إضافة بيانات تفصيلية للجهاز</h2>
    <form method="POST">
        <label>مكان الجهاز:</label>
        <input type="text" name="location" value="<?= $device['location'] ?? '' ?>"><br>

        <label>الطابق:</label>
        <input type="text" name="floor" value="<?= $device['floor'] ?? '' ?>"><br>

        <label>وصف آخر صيانة:</label>
        <textarea name="maintenance_desc"><?= $device['maintenance_desc'] ?? '' ?></textarea><br>

        <label>ملاحظات:</label>
        <textarea name="notes"><?= $device['notes'] ?? '' ?></textarea><br>

        <button type="submit">حفظ البيانات</button>
    </form>
</body>
</html>
