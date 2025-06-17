<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM devices WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$device = $result->fetch_assoc();

if (!$device) {
    echo "الجهاز غير موجود.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>بطاقة الجهاز - <?= htmlspecialchars($device['name']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <ul>
        <li><strong>مرحباً، <?= htmlspecialchars($_SESSION['user']['full_name']) ?></strong></li>
        <li><a href="index.php">القائمة الرئيسية</a></li>
        <li><a href="logout.php">تسجيل الخروج</a></li>
    </ul>
</nav>

<div class="container card">
    <h2><?= htmlspecialchars($device['name']) ?></h2>
    <p><strong>الشركة المصنعة:</strong> <?= htmlspecialchars($device['type']) ?></p>
    <p><strong>الموديل:</strong> <?= htmlspecialchars($device['model']) ?></p>
    <p><strong>الرقم التسلسلي:</strong> <?= htmlspecialchars($device['serial_number']) ?></p>
    <p><strong>حالة الجهاز:</strong> <?= htmlspecialchars($device['status']) ?></p>
    <p><strong>تاريخ آخر صيانة:</strong> <?= htmlspecialchars($device['last_maintenance']) ?></p>
    <p><strong>المشرف:</strong> <?= htmlspecialchars($device['supervisor']) ?></p>
    <p><strong>القسم:</strong> <?= htmlspecialchars($device['location']) ?></p>
    <p><strong>الطابق:</strong> <?= htmlspecialchars($device['floor']) ?></p>
    <p><strong>شرح آخر صيانة:</strong><br><?= nl2br(htmlspecialchars($device['maintenance_description'])) ?></p>
    <p><strong>ملاحظات:</strong><br><?= nl2br(htmlspecialchars($device['notes'])) ?></p>

    <div class="dashboard-actions">
        <a class="button" href="add_maintenance.php?id=<?= $device['id'] ?>">➕ إضافة صيانة</a>
        <a class="button" href="export_pdf.php?id=<?= $device['id'] ?>">🖨️ تصدير PDF</a>
        <a class="button" href="index.php">🔙 العودة</a>
    </div>

    <hr>

    <h2>سجل الصيانة</h2>
    <table>
        <thead>
            <tr>
                <th>تاريخ الطلب</th>
                <th>تاريخ الصيانة</th>
                <th>الأعمال المنفذة</th>
                <th>الجهة المنفذة</th>
                <th>القطع التبديلية</th>
                <th>توقيع المشرف</th>
                <th>ملاحظات</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt2 = $conn->prepare("SELECT * FROM maintenance WHERE device_id = ? ORDER BY maintenance_date DESC");
            $stmt2->bind_param("i", $id);
            $stmt2->execute();
            $maint_result = $stmt2->get_result();
            if ($maint_result->num_rows > 0):
                while ($m = $maint_result->fetch_assoc()):
            ?>
            <tr>
                <td><?= htmlspecialchars($m['request_date']) ?></td>
                <td><?= htmlspecialchars($m['maintenance_date']) ?></td>
                <td><?= htmlspecialchars($m['work_done']) ?></td>
                <td><?= htmlspecialchars($m['executing_party']) ?></td>
                <td><?= htmlspecialchars($m['spare_parts']) ?></td>
                <td><?= htmlspecialchars($m['supervisor_signature']) ?></td>
                <td><?= htmlspecialchars($m['notes']) ?></td>
            </tr>
            <?php endwhile; else: ?>
                <tr><td colspan="7">لا توجد سجلات صيانة لهذا الجهاز.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
