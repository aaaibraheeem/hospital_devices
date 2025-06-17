<?php
require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'default_font' => 'dejavusans', // خط يدعم العربية
]);

$html = '
<style>
body { font-family: dejavusans; direction: rtl; text-align: right; }
h1 { color: #333366; }
</style>

<h1>بطاقة الجهاز الطبية</h1>
<p><strong>الاسم:</strong> جهاز تخطيط القلب</p>
<p><strong>الموديل:</strong> ECG-500</p>
<p><strong>الموقع:</strong> الطابق الأول - جناح الطوارئ</p>
<p><strong>المشرف:</strong> د. محمد عبد الله</p>
';

$mpdf->WriteHTML($html);
$mpdf->Output('device_card.pdf', 'I'); // عرض مباشر في المتصفح
?>
