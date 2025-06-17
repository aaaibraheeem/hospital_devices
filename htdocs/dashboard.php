<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة تحكم المشرف</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- شريط تنقل -->
    <nav>
        <ul>
            <?php if (isset($_SESSION['user'])): ?>
                <li><a href="logout.php">تسجيل الخروج</a></li>
            <?php else: ?>
                <li><a href="login.php">تسجيل الدخول</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="container">
        <h1 class="page-title">👨‍💼 لوحة تحكم المشرفين</h1>
        <div class="dashboard-actions">
            <a href="add_user.php" class="button">➕ تسجيل مستخدم جديد</a>
            <a href="login.php" class="button">🔐 تسجيل الدخول</a>
        </div>
    </div>
</body>
</html>
