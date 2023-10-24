<?php
include 'condb.php';
session_start();

// ตรวจสอบว่ามีเซสชันของผู้ใช้งานหรือไม่
if (!isset($_SESSION['user_id'])) {
    // หากไม่มีเซสชัน ให้เปลี่ยนเส้นทางไปยังหน้าล็อคอิน
    header("Location: login.php"); // หรือหน้าที่คุณต้องการให้กลับไปยังหน้าล็อคอิน
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>addtype</title>

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
  เพิ่มประเภทสินค้า
</div>  

<form name="form1" method="post" action="insert_type.php" enctype="multipart/form-data">
<label>รหัสประเภทสินค้า: </label>
    <input type="text" name="tid" class="form-control" placeholder="รหัสสินค้า" required > <br>
<label>ชื่อประเภทสินค้า: </label>
    <input type="text" name="tname" class="form-control" placeholder="ชื่อประเภท" required > <br>


    <?php
mysqli_close($conn);
 ?>

</select>


    <button type="submit" class="btn btn-primary">Submit</button>
    <a class="btn btn-danger" href="show_type.php" role="button">Cancel</a>
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