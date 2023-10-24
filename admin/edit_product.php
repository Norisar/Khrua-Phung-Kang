<?php
include 'condb.php';

$proID=$_GET['id'];
$sql1="select * from product where pro_id='$proID' " ;
$hand=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_array($hand);
$Ptype_id=$row1['type_id'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>editproduct</title>

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
        <?php include 'menu1.php'; ?>

        <div id="layoutSidenav_content">
                <main>
                <div class="container px-4 ">
                    <div class="alert alert-info h4 text-center mt-4" role="alert">
  เเก้ไขข้อมูล
</div>  

<form name="form1" method="post" action="update_product.php" enctype="multipart/form-data">
<label>รหัสสินค้า: </label>
    <input type="text" name="pid" class="form-control" readonly value=<?=$row1['pro_id']?> > <br>
<label>ชื่อสินค้า: </label>
    <textarea class="form-control" name="pname" class="form-control" > <?=$row1['pro_name']?> </textarea> <br>
    <label>รายละเอียดสินค้า: </label>
    <textarea class="form-control" name="pdetail" class="form-control" > <?=$row1['detail']?> </textarea> <br>

    <label>ประเภทสินค้า: </label>
    <select class="form-select" name="typeID" >
    <?php
    $sql="SELECT * FROM type ORDER BY type_name";
    $hand=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_array($hand)){
        $Ttype_id=$row['type_id'];

    ?>
  <option value="<?=$row['type_id']?>" <?php if($Ttype_id == $Ptype_id){echo "selected=selected"; } ?> >
  <?=$row['type_name']?> </option>
  <?php
}

 ?>

</select>

    <label>ราคา: </label>
    <input type="number" name="price" class="form-control" value=<?=$row1['price']?> > <br>
    <label>จำนวน: </label>
    <input type="number" name="num" class="form-control" value=<?=$row1['amount']?> > <br>

    <img src="../img/<?=$row1['image']?>" width="100" >
    <label>รูปภาพ: </label>
    <input type="file" name="file1"   > <br>  <br>
    <input type="hidden" name="txtimg" class="form-control" value=<?=$row1['image']?> > <br>

    <button type="submit" class="btn btn-primary">Submit</button>
    <a class="btn btn-danger" href="show_product.php" role="button">Cancel</a>
    <br>
    <br>
</form>
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

        <?php
        mysqli_close($conn);
        ?>