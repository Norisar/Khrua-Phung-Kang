<?php
include 'condb.php';
$ids=$_POST['pid'];
$nums=$_POST['pnum'];

$sql = "UPDATE product set amount= amount - $nums WHERE pro_id='$ids' ";
$hand=mysqli_query($conn,$sql);
if($hand){
    echo "<script> alert('ลดจำนวนเรียบร้อย'); </script>";
    echo "<script> window.location='index2.php'; </script>";
}else{
    echo "<script> alert('ไม่สามารถลดจำนวนได้'); </script>";
}
mysqli_close($conn);
?>