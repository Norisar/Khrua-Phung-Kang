<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>myshop</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.min.js" ></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="./TCss/product.css" rel="stylesheet">
</head>
<body>
    <?php include 'menu.php'; ?>
  
    <br>
    <div class="container mt-4">
        <video autoplay="autoplay" loop="loop" width="100%" height="100%" muted>
            <source src="img/PR01D.mp4" type="video/mp4">
        </video>
        <br>
        <form class="d-flex" method="POST" action="show_product.php" role="search">
            <input class="form-control me-2" type="search" name="keyword" placeholder="ค้นหา" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">ค้นหา</button>
        </form>
        <br>
    
        <div class="row">
            <?php
            include 'condb.php';
            
            // คำสั่ง SQL สำหรับดึงข้อมูลสินค้าทั้งหมด
            $sql = "SELECT * FROM product ORDER BY pro_id";
            $result = mysqli_query($conn, $sql);
            
            while ($row = mysqli_fetch_assoc($result)) {
                $price = $row['price'];
                $amount1 = $row['amount'];
                ?>
                <div class="col-sm-3">
                    <div class="text-center">
                        <img src="img/<?=$row['image']?>" width="70%" height="70%"><br><br>
                        <h5 class="text-success"><?=$row['pro_name']?></h5> 
                        ราคา <b class="text-danger"><?=$row['price']?></b> บาท<br>
                        <?php if ($amount1 <= 0) { ?>
                            <a class="btn btn-danger mt-2" href="#">หมด</a>
                        <?php } else { ?>
                            <a class="btn btn-outline-success mt-2" href="sh_product_detail.php?id=<?=$row['pro_id']?>">รายละเอียด</a>
                        <?php } ?>
                    </div>
                    <br>
                </div>
            <?php } ?>
        </div>
        <?php mysqli_close($conn); ?>
    </div>
</body>
</html>
