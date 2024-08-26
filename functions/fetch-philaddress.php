<?php
require_once '../config/conn.php';

$type = isset($_POST['type']) ? $_POST['type'] : null;
$region_id = isset($_POST['region_id']) ? $_POST['region_id'] : null;
$province_id = isset($_POST['province_id']) ? $_POST['province_id'] : null;

if ($type) {
    if ($type == 'region') {
        $query = "SELECT * FROM tbl_refregion ORDER BY regDesc ASC";
        $stmt = $DB_con->prepare($query);
        $stmt->execute();
        $regions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($regions as $region) {
            echo "<option value='{$region['regCode']}'>{$region['regDesc']}</option>";
        }
    } elseif ($type == 'province' && $region_id) {
        $query = "SELECT * FROM tbl_refprovince WHERE regCode = :region_id ORDER BY provDesc ASC";
        $stmt = $DB_con->prepare($query);
        $stmt->bindParam(':region_id', $region_id);
        $stmt->execute();
        $provinces = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($provinces as $province) {
            echo "<option value='{$province['provCode']}'>{$province['provDesc']}</option>";
        }
    } elseif ($type == 'city' && $province_id) {
        $query = "SELECT * FROM tbl_refcitymun WHERE provCode = :province_id ORDER BY citymunDesc ASC";
        $stmt = $DB_con->prepare($query);
        $stmt->bindParam(':province_id', $province_id);
        $stmt->execute();
        $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($cities as $city) {
            echo "<option value='{$city['citymunCode']}'>{$city['citymunDesc']}</option>";
        }
    }
}
?>
