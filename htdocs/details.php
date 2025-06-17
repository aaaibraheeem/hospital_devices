<?php
require 'db.php';
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM devices WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>بطاقة الجهاز</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>بطاقة الجهاز</h2>
        <table>
            <tr><th>الاسم:</th><td><?= $row['name'] ?></td></tr>
            <tr><th>النوع:</th><td><?= $row['type'] ?></td></tr>
            <tr><th>الموديل:</th><td><?= $row['model'] ?></td></tr>
            <tr><th>الرقم التسلسلي:</th><td><?= $row['serial_number'] ?></td></tr>
            <tr><th>الوضع الفني:</th><td><?= $row['status'] ?></td></tr>
            <tr><th>آخر صيانة:</th><td><?= $row['last_maintenance'] ?></td></tr>
            <tr><th>المشرف:</th><td><?= $row['supervisor'] ?></td></tr>
            <tr><th>الموقع:</th><td><?= $row['location'] ?? 'غير محدد' ?></td></tr>
            <tr><th>الطابق:</th><td><?= $row['floor'] ?? 'غير محدد' ?></td></tr>
            <tr><th>وصف الصيانة:</th><td><?= $row['maintenance_desc'] ?? 'لا يوجد' ?></td></tr>
            <tr><th>ملاحظات:</th><td><?= $row['notes'] ?? 'لا توجد ملاحظات' ?></td></tr>
        </table>

        <br>
        <a href="export_pdf.php?id=<?= $row['id'] ?>" class="btn">تصدير PDF</a>
        <a href="export_excel.php?id=<?= $row['id'] ?>" class="btn">تصدير Excel</a>
        <a href="index.php" class="btn">عودة</a>
    </div>
</body>
</html>
