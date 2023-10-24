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
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>

        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    </head>
    <body class="sb-nav-fixed">
        <?php include 'menu1.php'; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        
                        <ol class="breadcrumb mb-4">
                            <!--<li class="breadcrumb-item active">Dashboard</li>-->
                        </ol>
                        
                        <div class="card mb-4">
                        <div class="alert alert-info " role="alert">
                                <i class="fas fa-table me-1"></i>
                                ข้อมูลสินค้า
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple" class="table table-striped" >
                                    <thead>
                                        <tr>
                                            <th>รูปภาพ</th>
                                            <th>รหัสสินค้า</th>
                                            <th>ชื่อสินค้า</th>
                                            <th>รายละเอียด</th>
                                            <th>ประเภทสินค้า</th>
                                            <th>ราคา</th>
                                            <th>จำนวน</th>
                                            <th>เพิ่มสต็อก</th>
                                            <th>ลดสต็อก</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>pro_id</th>
                                            <th>pro_name</th>
                                            <th>detail</th>
                                            <th>type_name</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
<?php  
    $sql="SELECT * FROM product p,type t WHERE p.type_id=t.type_id";
    $hand=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_array($hand)){

    
?>
                                        <tr>
                                            <td><img src="../img/<?=$row['image']?>" width="100" height="100"></td>
                                            <td><?=$row['pro_id']?></td>
                                            <td><?=$row['pro_name']?></td>
                                            <td><?=$row['detail']?></td>
                                            <td><?=$row['type_name']?></td>
                                            <td><?=$row['price']?></td>
                                            <td><?=$row['amount']?></td>
                                            <td><a href="addStock.php?id=<?=$row['pro_id']?> "class="btn btn-success"> เพิ่ม</a></td>
                                            <td><a href="delStock.php?id=<?=$row['pro_id']?> "class="btn btn-danger"> ลด</a></td>
                                        </tr>
                            <?php  
                            }
                            mysqli_close($conn);
                            ?>
                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <?php include 'footer.php'; ?>
                


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
