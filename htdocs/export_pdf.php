<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once 'db.php';

if (!isset($_GET['id'])) {
    die("لم يتم تحديد الجهاز.");
}

$id = intval($_GET['id']);

// جلب بيانات الجهاز
$stmt = $conn->prepare("SELECT * FROM devices WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("الجهاز غير موجود.");
}

$row = $result->fetch_assoc();

// جلب سجلات الصيانة للجهاز
$stmt2 = $conn->prepare("SELECT * FROM maintenance WHERE device_id = ? ORDER BY maintenance_date DESC");
$stmt2->bind_param("i", $id);
$stmt2->execute();
$maintenance_result = $stmt2->get_result();

// إنشاء كائن mPDF
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'default_font' => 'dejavusans',
]);

// إعداد HTML
$html = "
<style>
    body { font-family: 'dejavusans'; direction: rtl; text-align: right; }
    h2 { text-align: center; margin: 10px 0; }
    .header { text-align: right; margin: 10px 0; font-size: 14pt; font-weight: bold; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
    th, td { border: 1px solid #000; padding: 6px; font-size: 11pt; }
</style>

<div class='header'>
    الجمهورية العربية السورية<br>
    وزارة التعليم العالي و البحث العلمي<br>
    مستشفى اللاذقية الجامعي  
</div>

<h2>بطاقة جهاز</h2>

<table>
    <tr>
        <th>اسم الجهاز</th>
        <td>{$row['name']}</td>
        <th>الشركة المصنعة</th>
        <td>{$row['type']}</td>
    </tr>
    <tr>
        <th>الموديل</th>
        <td>{$row['model']}</td>
        <th>الرقم التسلسلي</th>
        <td>{$row['serial_number']}</td>
    </tr>
    <tr>
        <th>حالة الجهاز</th>
        <td>{$row['status']}</td>
        <th>تاريخ آخر صيانة</th>
        <td>{$row['last_maintenance']}</td>
    </tr>
    <tr>
        <th>المشرف</th>
        <td>{$row['supervisor']}</td>
        <th>القسم</th>
        <td>{$row['location']}</td>
    </tr>
    <tr>
        <th>الطابق</th>
        <td>{$row['floor']}</td>
        <th colspan='2'></th>
    </tr>
    <tr>
        <th>شرح آخر صيانة</th>
        <td colspan='3'>{$row['maintenance_description']}</td>
    </tr>
    <tr>
        <th>ملاحظات</th>
        <td colspan='3'>{$row['notes']}</td>
    </tr>
</table>

<h2>متابعة أعمال الصيانة والإصلاح</h2>

<table>
    <thead>
        <tr>
            <th>تاريخ طلب الصيانة</th>
            <th>الأعمال التي تمت</th>
            <th>الجهة المنفذة</th>
            <th>القطع التبديلية</th>
            <th>تاريخ تنفيذ الصيانة</th>
            <th>توقيع المشرف</th>
            <th>ملاحظات</th>
        </tr>
    </thead>
    <tbody>";

if ($maintenance_result->num_rows > 0) {
    while ($m = $maintenance_result->fetch_assoc()) {
        $html .= "<tr>
            <td>" . htmlspecialchars($m['request_date']) . "</td>
            <td>" . htmlspecialchars($m['work_done']) . "</td>
            <td>" . htmlspecialchars($m['executing_party']) . "</td>
            <td>" . htmlspecialchars($m['spare_parts']) . "</td>
            <td>" . htmlspecialchars($m['maintenance_date']) . "</td>
            <td>" . htmlspecialchars($m['supervisor_signature']) . "</td>
            <td>" . htmlspecialchars($m['notes']) . "</td>
        </tr>";
    }
} else {
    $html .= "<tr><td colspan='7'>لا توجد سجلات صيانة.</td></tr>";
}

$html .= "</tbody></table>";

// إخراج PDF
$mpdf->WriteHTML($html);
$mpdf->Output("device_card_$id.pdf", "I");
