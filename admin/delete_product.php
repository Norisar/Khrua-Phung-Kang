<?php
include 'condb.php';

if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    
    // ตรวจสอบว่าสินค้ามีอยู่ในระบบหรือไม่
    $sql = "SELECT * FROM product WHERE pro_id = $productId";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // ลบสินค้า
        $deleteSql = "DELETE FROM product WHERE pro_id = $productId";
        if (mysqli_query($conn, $deleteSql)) {
            // ลบสำเร็จ ให้เปลี่ยนหน้าไปยัง show_product.php
            header("Location: show_product.php");
            exit();
        } else {
            echo "เกิดข้อผิดพลาดในการลบสินค้า: " . mysqli_error($conn);
        }
    } else {
        echo "ไม่พบสินค้าที่ต้องการลบ";
    }
} else {
    echo "รหัสสินค้าไม่ถูกต้อง";
}

mysqli_close($conn);
?>
