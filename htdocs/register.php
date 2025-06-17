<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
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

<form method="post">
    <h2>تسجيل مستخدم جديد</h2>
    <input type="text" name="full_name" placeholder="الاسم الكامل" required><br>
    <input type="text" name="phone" placeholder="رقم الهاتف"><br>
    <input type="text" name="address" placeholder="العنوان"><br>
    <select name="profession" required>
        <option value="فني">فني</option>
        <option value="مهندس">مهندس</option>
    </select><br>
    <input type="text" name="username" placeholder="اسم المستخدم" required><br>
    <input type="password" name="password" placeholder="كلمة المرور" required><br>
    <button type="submit">تسجيل</button>
</form>
