<?php 
session_start();
include 'condb.php'; 


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.min.js" ></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="./TCss/Cart.css">
</head>
<body>
<?php include 'menu.php' ?> 
 <br><br>
 <br>
 <br>

    <div class="container">
        <form id="form1" method="POST" action="insert_cart.php"></form>
        <div class ="row">
            <div class ="col-md-20">
            <br>
            <div class="alert alert-primary h4" role="alert">
  การสั่งซื้อสินค้า
</div>
        <table class = "table table-hover">
         <tr> 
                <th>ลำดับที่</th>
                <th>ภาพสินค้า</th>
                <th>ชื่อสินค้า</th>
                <th>ราคา</th>
                <th>จำนวน</th>
                <th>ราคารวม</th>
                <th>เพิ่ม - ลด</th>
                <th>ลบ</th>
         </tr>
<?php
$total = 0;
$sumPrice = 0;
$m = 1;
$sumTotal=0;

if(isset($_SESSION["intLine"])) {   //ถ้าไม่เป็นค่าว่างให้ทำงานใน {}

for ($i=0; $i <= (int)$_SESSION["intLine"]; $i++){
    if(($_SESSION["strProductID"][$i]) !=""){
        $sql1="select * from product where pro_id = '" . $_SESSION["strProductID"][$i] . "' " ;
        $result1 = mysqli_query($conn, $sql1);
        $row_pro = mysqli_fetch_array($result1);

        $_SESSION["price"] = $row_pro['price'];
        $Total = $_SESSION["strQty"][$i];
        $sum = $Total * $row_pro['price'];
        $sumPrice = $sumPrice + $sum;
        $_SESSION["sum_price"] = $sumPrice;
        $sumTotal=$sumTotal+$Total;

?>
         <tr>
                <td><?=$m?></td>
                <td>
                    <img src="img/<?=$row_pro['image']?>" width="80" height="100" class="border" ></td>
                    <td> <?=$row_pro['pro_name']?></td>
                <td><?=$row_pro['price']?></td>
                <td><?=$_SESSION["strQty"][$i]?></td>
                <td><?=$sum?></td>
                <td>
                <a href="order.php?id=<?=$row_pro['pro_id']?>"class="btn btn-outline-success">+</a> 
                <?php if($_SESSION["strQty"][$i] > 1 ){ ?>
                <a href="order_del.php?id=<?=$row_pro['pro_id']?>"class="btn btn-outline-success">-</a>   
                <?php } ?>
                </td>
                
                <td><a href= "pro_delete.php?Line=<?=$i?>" > <img src="img/delete.png"width="30" ></td>
         </tr>
<?php
    $m=$m+1;
}
}
} //endif
?>
<tr>
  <td class="text-end" colspan="4">รวมเป็นเงิน</td>  
  <td class="text-center"><?=$sumPrice?></td> 
  <td>บาท</td> 
</tr>


            </div>
     </table>
<p class="text-end">จำนวนอาหารที่สั่งซื้อ <?=$sumTotal?> เมนู</p>
            
            <br>
        </div>
        <br>
        <button type="button" class="button" data-bs-toggle="modal" data-bs-target="#deliveryModal">
   กดเพื่อกรอกข้อมูลการสั่งซื้อ
</button>

<!-- Modal -->
<div class="modal fade" id="deliveryModal" tabindex="-1" aria-labelledby="deliveryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- เพิ่ม class modal-lg ที่นี่ -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deliveryModalLabel">กรอกข้อมูลจัดส่งสินค้า</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form name="form2"method="post"action="insert_cart.php"enctype="multipart/form-data">
<form action="insert_cart.php"method="POST">
ชื่อ-นามสกุล:
<input type="text"name="cus_name"class="form-control"required placeholder="ใส่ชื่อ-นามสกุลให้ตรงกับสลิป"><br>
ที่อยู่จัดส่ง:
<textarea class="form-control"required placeholder="เช่น ชื่อหอพัก" name="cus_add"rows="3"></textarea><br>
เบอร์โทรศัพท์:
<input type="number"name="cus_tel"class="form-control"required placeholder="เบอร์โทรศัพท์"><br>
เพิ่มรายละเอียด:
<textarea class="form-control"required placeholder="รายละเอียด เช่น ไม่กินเผ็ด ไม่ใส่ผัก"name="cus_detail"rows="3"></textarea><br>
<label>สลิป: </label>
    <input type="file"name="file1"required > <br>  <br>


    <img src="img/slip.jpg" width="100%" height="100%" class="mt-5 p-2 my-2 border"><br>
    เลขบัญชี: 071-3-57138-5<br>
ธนาคาร:กสิกรไทย<br>
ชื่อ นาย ธีรภัทร เเก้วดวงดี<br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
        <a href ="show_product.php" > <button type="button" class="btn btn-outline-primary">เลือกสินค้า</button> </a> 
        <button type="submit" name="submit" class="btn btn-outline-success">ยืนยันการสั่งซื้อ</button>
      </div>
    </div>
  </div>
</div>

  
    
 
</div>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>