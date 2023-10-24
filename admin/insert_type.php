<?php
include 'condb.php';
$t_id = $_POST['tid'];
$t_name = $_POST['tname'];


//เช้ครหัสนี้มีใน product ไหม
$check ="select * from product where pro_id ='$t_id' ";
$hand = mysqli_query($conn,$check);
$num1 = mysqli_num_rows($hand);
if($num1 > 0) {
    echo "<script> alert('มีรหัสสินค้าอยู่เเล้ว'); </script>";
    echo "<script> window.location='add_product.php'; </script>";
}


//คำสั่งเพิ่มข้อมูลในตาราง product
$sql="INSERT INTO type(type_id,type_name)
VALUES('$t_id','$t_name')";

$result=mysqli_query($conn,$sql);
if($result){
    echo "<script> alert('บันทึกข้อมูลเรียบร้อย'); </script>";
    echo "<script> window.location='add_type.php'; </script>";
}else{
    echo "<script> alert('ไม่สามารถบันทึกข้อมูลได้'); </script>";
}

?>