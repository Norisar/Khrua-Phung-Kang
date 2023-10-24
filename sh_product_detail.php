<?php include 'condb.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyshopDetail</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.min.js" ></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="./TCss/shop.css">

</head>
<body>
<?php include 'menu.php' ?>
<br>
<div class="container ">
  <div class="row">
  <?php
  $ids=$_GET['id'];
$sql = "SELECT * FROM product,type WHERE product.type_id= type.type_id and product.pro_id='$ids'  ";
$result = mysqli_query($conn,$sql);
$row=mysqli_fetch_array($result )
?>
    <div class="col-md-4">
      <img src="img/<?=$row['image']?>" width="90% " height="90%" class="mt-5 p-2 my-2 border" />
    </div>
    
    <div class="col-md-6"><br><br><br>
 
    <div class="container">
  <div class="login-form">
    <div class="header">
    <label class="title"><h5 class="text-success"><?=$row['pro_name']?> </h5> </label>
    ประเภทสินค้า : <?=$row['type_name']?> <br>
    รายละเอียด : <?=$row['detail']?> <br>
    ราคา  <?=$row['price']?> </b> บาท </b>
    </div>
    <div class="input_container">
  </div>
  <a a class="sign-in_btn" class="btn btn-outline-success mt-2" href="order.php?id=<?=$row['pro_id']?>" >สั่งซื้อ</a>
    </div>

  </div>
  </div>


 
<?php
mysqli_close($conn);
?>


</body>
</html>