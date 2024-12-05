<?php
require_once '../config/conn.php';

$type = isset($_POST['type']) ? $_POST['type'] : null;
$region_id = isset($_POST['region_id']) ? $_POST['region_id'] : null;
$province_id = isset($_POST['province_id']) ? $_POST['province_id'] : null;

if ($type) {
    try {
        if ($type == 'region') {
            $query = "SELECT * FROM tbl_refregion ORDER BY regDesc ASC";
            $stmt = $DB_con->prepare($query);
            $stmt->execute();
            $regions = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($regions) {
                foreach ($regions as $region) {
                    $selected = ($region['regCode'] == '04') ? 'selected' : ''; // Default REGION IV-A
                    echo "<option value='{$region['regCode']}' {$selected}>{$region['regDesc']}</option>";
                }
            } else {
                echo "<option value=''>No Regions Available</option>";
            }
        } elseif ($type == 'province' && $region_id) {
            $query = "SELECT * FROM tbl_refprovince WHERE regCode = :region_id ORDER BY provDesc ASC";
            $stmt = $DB_con->prepare($query);
            $stmt->bindParam(':region_id', $region_id);
            $stmt->execute();
            $provinces = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($provinces) {
                foreach ($provinces as $province) {
                    echo "<option value='{$province['provCode']}'>{$province['provDesc']}</option>";
                }
            } else {
                echo "<option value=''>No Provinces Available</option>";
            }
        } elseif ($type == 'city' && $province_id) {
            $query = "SELECT * FROM tbl_refcitymun WHERE provCode = :province_id ORDER BY citymunDesc ASC";
            $stmt = $DB_con->prepare($query);
            $stmt->bindParam(':province_id', $province_id);
            $stmt->execute();
            $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($cities) {
                foreach ($cities as $city) {
                    echo "<option value='{$city['citymunCode']}'>{$city['citymunDesc']}</option>";
                }
            } else {
                echo "<option value=''>No Cities Available</option>";
            }
        }
    } catch (PDOException $e) {
        echo "<option value=''>Error: " . $e->getMessage() . "</option>";
    }
}
?>
