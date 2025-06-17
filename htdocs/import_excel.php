<?php
require 'vendor/autoload.php';
require 'db.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['import'])) {
    $file = $_FILES['excel']['tmp_name'];

    if ($file) {
        $spreadsheet = IOFactory::load($file);
        $data = $spreadsheet->getActiveSheet()->toArray();

        // تجاوز أول صف (عناوين الأعمدة)
        for ($i = 1; $i < count($data); $i++) {
            list($name, $type, $model, $serial, $status, $last_maintenance, $supervisor, $location, $floor, $maintenance_desc, $notes) = $data[$i];

            $stmt = $conn->prepare("INSERT INTO devices (name, type, model, serial_number, status, last_maintenance, supervisor, location, floor, maintenance_desc, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssss", $name, $type, $model, $serial, $status, $last_maintenance, $supervisor, $location, $floor, $maintenance_desc, $notes);
            $stmt->execute();
        }

        echo "تم استيراد البيانات بنجاح.";
    } else {
        echo "يرجى رفع ملف Excel صالح.";
    }
}
?>
