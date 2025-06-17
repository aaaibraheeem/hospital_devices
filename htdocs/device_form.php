<?php
include 'db.php';
$id = $_GET['id'] ?? 0;

$result = $conn->query("SELECT * FROM devices WHERE id = $id");
$device = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $location = $_POST['location'];
    $floor = $_POST['floor'];
    $maintenance_description = $_POST['maintenance_description'];
    $notes = $_POST['notes'];

    $stmt = $conn->prepare("UPDATE devices SET location=?, floor=?, maintenance_description=?, notes=? WHERE id=?");
    $stmt->bind_param("ssssi", $location, $floor, $maintenance_description, $notes, $id);
    $stmt->execute();

    header("Location: device_card.php?id=$id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تعديل تفاصيل الجهاز</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>📝 تعديل تفاصيل الجهاز</header>
<div class="container">
    <form method="post">
        <label>مكان تواجد الجهاز:</label>
        <input type="text" name="location" value="<?= htmlspecialchars($device['location']) ?>" required>

        <label>الطابق:</label>
        <input type="text" name="floor" value="<?= htmlspecialchars($device['floor']) ?>" required>

        <label>شرح آخر صيانة:</label>
        <textarea name="maintenance_description" rows="4"><?= htmlspecialchars($device['maintenance_description']) ?></textarea>

        <label>ملاحظات:</label>
        <textarea name="notes" rows="4"><?= htmlspecialchars($device['notes']) ?></textarea>

        <button type="submit">💾 حفظ</button>
        <a href="device_card.php?id=<?= $id ?>">🔙 إلغاء</a>
    </form>
</div>
</body>
</html>
