<?php
session_start();
require_once 'db.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: index.php");
            exit;
        } else {
            $message = 'كلمة المرور غير صحيحة.';
        }
    } else {
        $message = 'اسم المستخدم غير موجود.';
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>تسجيل الدخول</h2>
        <form method="post">
            <label>اسم المستخدم:</label>
            <input type="text" name="username" required>
            <label>كلمة المرور:</label>
            <input type="password" name="password" required>
            <button type="submit">دخول</button>
            <p style="color:red;"><?php echo $message; ?></p>
        </form>
    </div>
</body>
</html>
