<?php
require_once 'db.php';
$device_id = $_GET['id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_date = $_POST['request_date'];
    $maintenance_date = $_POST['maintenance_date'];
    $work_done = $_POST['work_done'];
    $executing_party = $_POST['executing_party'];
    $spare_parts = $_POST['spare_parts'];
    $supervisor_signature = $_POST['supervisor_signature'];
    $notes = $_POST['notes'];

    $stmt = $conn->prepare("INSERT INTO maintenance (device_id, request_date, maintenance_date, work_done, executing_party, spare_parts, supervisor_signature, notes)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $device_id, $request_date, $maintenance_date, $work_done, $executing_party, $spare_parts, $supervisor_signature, $notes);
    $stmt->execute();

    header("Location: device_card.php?id=$device_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة صيانة</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>إضافة صيانة للجهاز</h2>
    <form method="post">
        <label>تاريخ الطلب:</label>
        <input type="date" name="request_date" required>

        <label>تاريخ الصيانة:</label>
        <input type="date" name="maintenance_date" required>

        <label>الأعمال المنفذة:</label>
        <textarea name="work_done" required></textarea>

        <label>الجهة المنفذة:</label>
        <input type="text" name="executing_party" required>

        <label>القطع التبديلية:</label>
        <textarea name="spare_parts"></textarea>

        <label>توقيع المشرف:</label>
        <input type="text" name="supervisor_signature">

        <label>ملاحظات:</label>
        <textarea name="notes"></textarea>

        <button type="submit">💾 حفظ الصيانة</button>
    </form>
</div>
</body>
</html>
