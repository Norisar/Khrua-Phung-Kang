<?php
include 'condb.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['orderID'])) {
    $orderID = $_GET['orderID'];

    // ตรวจสอบคำสั่งซื้อและลบจากฐานข้อมูล
    $checkSql = "SELECT * FROM tb_order WHERE orderID = $orderID";
    $checkResult = mysqli_query($conn, $checkSql);

    if (mysqli_num_rows($checkResult) > 0) {
        // คำสั่งซื้อมีอยู่จริง ดังนั้นคุณสามารถลบได้
        $deleteSql = "DELETE FROM tb_order WHERE orderID = $orderID";

        if (mysqli_query($conn, $deleteSql)) {
            // ลบสำเร็จ ทำการ redirect กลับไปยัง repost_order.php
            header('Location: repost_order.php');
            exit;
        } else {
            // ลบไม่สำเร็จ
            echo "error";
        }
    } else {
        // ไม่พบคำสั่งซื้อนี้ในฐานข้อมูล
        echo "not found";
    }
} else {
    // คำขอไม่ถูกต้อง
    echo "invalid request";
}

mysqli_close($conn);
?>
