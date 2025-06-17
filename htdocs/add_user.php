<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $profession = $_POST['profession'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (full_name, phone, address, profession, username, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $full_name, $phone, $address, $profession, $username, $password);
    $stmt->execute();

    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تسجيل مستخدم جديد</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>تسجيل مستخدم جديد</h2>
        <form method="post">
            <label>الاسم الكامل:</label>
            <input type="text" name="full_name" required>
            <label>رقم الهاتف:</label>
            <input type="text" name="phone" required>
            <label>العنوان:</label>
            <input type="text" name="address" required>
            <label>العمل:</label>
            <select name="profession" required>
                <option value="فني">فني</option>
                <option value="مهندس">مهندس</option>
            </select>
            <label>اسم المستخدم:</label>
            <input type="text" name="username" required>
            <label>كلمة المرور:</label>
            <input type="password" name="password" required>
            <button type="submit">تسجيل</button>
        </form>
    </div>
</body>
</html>
