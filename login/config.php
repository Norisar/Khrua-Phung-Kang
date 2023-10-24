<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "datadb"; // ตั้งชื่อตามฐานข้อมูลของคุณ


try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("เกิดข้อผิดพลาดในการเชื่อมต่อกับฐานข้อมูล: " . $e->getMessage());
}
?>
