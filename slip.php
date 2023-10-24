<?php 
session_start();
include 'condb.php'; 
$sql="select * from tb_order where orderID= ' " . $_SESSION["order_id"] . "' ";
$result = mysqli_query($conn,$sql);
$rs=mysqli_fetch_array($result);
$total_price=$rs['total_price'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการสั่งซื้อ</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.min.js" ></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="./TCss/silll.css">
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-md-10"> 
    <div class="alert alert-primary h4 text-center mt-4" role="alert">
  การสั่งซื้อเสร็จสมบูรณ์
</div>
เลขที่ใบสั่งซื้อ: <?=$rs['orderID']?> <br>
ชื่อ-นามสกุล:  <?=$rs['cus_name']?> <br>
ที่อยู่การจัดส่ง: <?=$rs['addres_s']?> <br>
เบอร์โทรศัพท์: <?=$rs['telephone']?> <br>
เพิ่มรายละเอียด: <?=$rs['cus_detail']?> <br>
<br>
<div class="card mb-4 mt-4">
    <div class="card-body">
<table class="table table-hover">
  <thead>
    <tr>
      <th>รหัสสินค้า</th>
      <th>ชื่อสินค้า</th>
      <th>ราคา</th>
      <th>จำนวน</th>
      <th>ราคารวม</th>
    </tr>
  </thead>
  <tbody>
<?php
$sql1="select * from order_detail d,product p where d.pro_id=p.pro_id and d.orderID= ' " . $_SESSION["order_id"] . "' ";
$result1 = mysqli_query($conn,$sql1);
while($row=mysqli_fetch_array($result1)){


?>

    <tr>
      <td><?=$row['pro_id']?></td>
      <td><?=$row['pro_name']?></td>
      <td><?=$row['orderPrice']?></td>
      <td><?=$row['orderQty']?></td>
      <td><?=$row['Total']?></td>
    </tr>
</tbody>
<?php

}
?>
</table>

<h6 class="text-end"> รวมเป็นเงิน <?=number_format( $total_price,2) ?> บาท</h6>
</div>
</div>
<div class="text-center mt-4">
    *** กรุณารอรับสายจากร้านค้า จะได้อาหารโดยประมาณ 15-30 นาที ***
    <br><br>
</div>
<div class="text-center mt-4">
<a href="show_product.php" class="btn btn-success">Back</a>
 <!--<button onclick="window.print()" class="btn btn-warning">Print</button> -->  
</div>
<br>
    </div>
  </div>
</div>

</body>
</html>