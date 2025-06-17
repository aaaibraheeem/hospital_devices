<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $model = $_POST['model'];
    $serial = $_POST['serial_number'];
    $status = $_POST['status'];
    $last_maintenance = $_POST['last_maintenance'];
    $supervisor = $_POST['supervisor'];
    $location = $_POST['location'];
    $floor = $_POST['floor'];
    $maintenance_desc = $_POST['maintenance_description'];
    $notes = $_POST['notes'];

    $stmt = $conn->prepare("INSERT INTO devices (name, type, model, serial_number, status, last_maintenance, supervisor, location, floor, maintenance_description, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $name, $type, $model, $serial, $status, $last_maintenance, $supervisor, $location, $floor, $maintenance_description, $notes);
    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة جهاز جديد</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>إضافة جهاز طبي جديد</h2>
        <form method="POST">
            <label>اسم الجهاز:</label><input type="text" name="name" required>
            <label>الشركة المصنعة:</label><input type="text" name="type">
            <label>الموديل:</label><input type="text" name="model">
            <label>الرقم التسلسلي:</label><input type="text" name="serial_number">
            <label>حالة الجهاز :</label><input type="text" name="status">
            <label>تاريخ آخر صيانة:</label><input type="date" name="last_maintenance">
            <label>المشرف:</label><input type="text" name="supervisor">
            <label>القسم المتواجد به:</label><input type="text" name="location">
            <label>الطابق:</label><input type="text" name="floor">
            <label>وصف آخر صيانة:</label><textarea name="maintenance_description"></textarea>
            <label>ملاحظات:</label><textarea name="notes"></textarea>
            <button type="submit" class="btn">💾 حفظ الجهاز</button>
        </form>

       <h3>استيراد من ملف Excel:</h3>
       <form action="import_excel.php" method="post" enctype="multipart/form-data">
           <input type="file" name="excel" accept=".xlsx, .xls" required>
           <button type="submit" name="import">استيراد</button>
       </form>

    </div>
</body>
</html>
