<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}

$full_name = $_SESSION['user']['full_name'];
require_once 'db.php';

$search = $_GET['search'] ?? '';
$sort_by = $_GET['sort_by'] ?? 'id';
$order = $_GET['order'] ?? 'ASC';

$query = "SELECT * FROM devices WHERE name LIKE ? OR type LIKE ? OR model LIKE ? ORDER BY $sort_by $order";
$stmt = $conn->prepare($query);
$like = "%$search%";
$stmt->bind_param("sss", $like, $like, $like);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة الأجهزة الطبية</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <ul>
        <li><a href="dashboard.php">لوحة التحكم</a></li>
        <li><strong>👤 المستخدم: <?= htmlspecialchars($full_name) ?></strong></li>
        <li><a href="logout.php">تسجيل الخروج</a></li>
    </ul>
</nav>

<div class="container">
    <h1 class="page-title">إدارة الأجهزة الطبية</h1>

    <div class="controls">
        <a href="add_device.php" class="btn">➕ إضافة جهاز</a>
        <form method="get" class="search-form">
            <input type="text" name="search" placeholder="🔍 ابحث باسم أو نوع أو موديل" value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn">بحث</button>
        </form>
        <form method="get" class="sort-form">
            <select name="sort_by">
                <option value="name">الاسم</option>
                <option value="type">النوع</option>
                <option value="model">الموديل</option>
                <option value="last_maintenance">آخر صيانة</option>
            </select>
            <select name="order">
                <option value="ASC">تصاعدي</option>
                <option value="DESC">تنازلي</option>
            </select>
            <button type="submit" class="btn">🔃 فرز</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>الاسم</th>
                <th>النوع</th>
                <th>الموديل</th>
                <th>الرقم التسلسلي</th>
                <th>المشرف</th>
                <th>العمليات</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($device = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($device['name']) ?></td>
                    <td><?= htmlspecialchars($device['type']) ?></td>
                    <td><?= htmlspecialchars($device['model']) ?></td>
                    <td><?= htmlspecialchars($device['serial_number']) ?></td>
                    <td><?= htmlspecialchars($device['supervisor']) ?></td>
                    <td class="actions">
                        <a href="device_card.php?id=<?= $device['id'] ?>" class="btn">📋 بطاقة الجهاز</a>
                        <a href="edit_device.php?id=<?= $device['id'] ?>" class="btn btn-edit">✏️ تعديل</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
