<?php
session_start();

// تدمير الجلسة الحالية لتسجيل الخروج
session_unset();
session_destroy();

// إعادة توجيه المستخدم إلى صفحة تسجيل الدخول
header("Location: login.php");
exit();
?>
