<?php
include 'condb.php';

$p_id = $_POST['pid'];
$p_name = $_POST['pname'];
$p_detail = $_POST['pdetail'];
$typeID = $_POST['typeID'];
$price = $_POST['price'];

// เช็ครหัสสินค้าว่ามีอยู่ใน product หรือไม่
$check = "SELECT * FROM product WHERE pro_id ='$p_id'";
$hand = mysqli_query($conn, $check);
$num1 = mysqli_num_rows($hand);
if ($num1 > 0) {
    echo "<script> alert('มีรหัสสินค้าอยู่เเล้ว'); </script>";
    echo "<script> window.location='add_product.php'; </script>";
    exit();
}

// อัพโหลดรูปภาพ
if (is_uploaded_file($_FILES['file1']['tmp_name'])) {
    $new_image_name = 'pr_' . uniqid() . "." . pathinfo(basename($_FILES['file1']['name']), PATHINFO_EXTENSION);
    $image_upload_path = "../img/" . $new_image_name;
    move_uploaded_file($_FILES['file1']['tmp_name'], $image_upload_path);
} else {
    $new_image_name = "";
}

// กำหนดค่า amount เริ่มต้นเป็น 1 และไม่เป็น 0
$amount = isset($_POST['num']) && $_POST['num'] >= 100 ? $_POST['num'] : 100;

// คำสั่งเพิ่มข้อมูลในตาราง product
$sql = "INSERT INTO product(pro_id,pro_name,detail,type_id,price,amount,image)
VALUES('$p_id','$p_name','$p_detail','$typeID','$price','$amount','$new_image_name')";

$result = mysqli_query($conn, $sql);
if ($result) {
    echo "<script> alert('บันทึกข้อมูลเรียบร้อย'); </script>";
    echo "<script> window.location='add_product.php'; </script>";
} else {
    echo "<script> alert('ไม่สามารถบันทึกข้อมูลได้'); </script>";
}
?>
