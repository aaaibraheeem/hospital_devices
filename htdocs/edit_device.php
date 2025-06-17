<?php
require 'db.php';
$id = $_GET['id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("UPDATE devices SET name=?, type=?, model=?, serial_number=?, status=?, last_maintenance=?, supervisor=? WHERE id=?");
    $stmt->bind_param("sssssssi", $_POST['name'], $_POST['type'], $_POST['model'], $_POST['serial'], $_POST['status'], $_POST['last_maintenance'], $_POST['supervisor'], $id);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM devices WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل جهاز</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>تعديل بيانات الجهاز</h2>
        <form method="POST">
            <label>اسم الجهاز:</label><input type="text" name="name" value="<?= $row['name'] ?>" required>
            <label>الشركة المصنعة:</label><input type="text" name="type" value="<?= $row['type'] ?>" required>
            <label>الموديل:</label><input type="text" name="model" value="<?= $row['model'] ?>" required>
            <label>الرقم التسلسلي:</label><input type="text" name="serial" value="<?= $row['serial_number'] ?>" required>
            <label>حالة الجهاز:</label><input type="text" name="status" value="<?= $row['status'] ?>" required>
            <label>آخر صيانة:</label><input type="date" name="last_maintenance" value="<?= $row['last_maintenance'] ?>" required>
            <label>المشرف:</label><input type="text" name="supervisor" value="<?= $row['supervisor'] ?>" required>
            <button type="submit">حفظ التعديلات</button>
        </form>
    </div>
</body>
</html>
