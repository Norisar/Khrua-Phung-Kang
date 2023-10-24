<?php 
include 'condb.php'; 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Day</title>

        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    </head>
    <body class="sb-nav-fixed">
        <?php include 'menu1.php'; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4 ">
                        
                        <div class="card mb-4 mt-4">
                        <div class="alert alert-info " role="alert">
                                <i class="fas fa-table me-1"></i>
                                ข้อมูลลูกค้าสั่งอาหาร 
                            </div>
                            
                            <div>
<!--<form name="form1" method="POST" action="repost_order.php" >
<div class="row">
    <div class="col-sm-2">
      <input type="date" name="dt1" class="form-control">
    </div>
    <div class="col-sm-2">
    <input type="date" name="dt2" class="form-control">
    </div>
    <div class="col-sm-4">
    <button type="submit" class="btn btn-outline-success"><i class="fas fa-search"></i></button>
    </div>
</div>
</form>-->
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple" class="table table-striped" >
                                    <thead>
                                        <tr>
                                            <th>เลขที่ใบสั่งซื้อ</th>
                                            <th>ชื่อลูกค้า</th>
                                            <th>ที่อยู่</th>
                                            <th>เบอร์โทรศัพท์</th>
                                            <th>ราคารวมสุทธิ</th>
                                            <th>วันที่สั่งซื้อ</th>
                                            <th>เพิ่มรายละเอียด</th>
                                            <th>รูปสลิปโอนเงิน</th>
                                            <th>รายระเอียดการสั่งซื้อ</th>
                                            <th>รายการสั่งซื้อ</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>orderID</th>
                                            <th>cus_name</th>
                                            <th>address</th>
                                            <th>telephone</th>
                                            <th>cus_detail</th>
                                            <th>transfer_slip</th>
                                        </tr>
                                    </tfoot>
                                    
                                    <?php
$ddt1=@$_POST['dt1'];
$ddt2=@$_POST['dt2'];
$add_date= date('Y/M/D', strtotime($ddt2 . "+1 days"));

if(($ddt1 != "") & ($ddt2 !="")){
    echo "ค้นหาจากวันที่ $ddt1 ถึง $ddt2 " ;
    $sql ="select * from tb_order where reg_date BETWEEN '$ddt1' and '$add_date'
    order by reg_date DESC";
}else{
    $sql ="select * from tb_order order by reg_date DESC";
}


$result=mysqli_query($conn,$sql);
while($row=mysqli_fetch_array($result)){

?>
                                    
                                        <tr>
                                            <td><?=$row['orderID']?></td>
                                            <td><?=$row['cus_name']?></td>
                                            <td><?=$row['addres_s']?></td>
                                            <td><?=$row['telephone']?></td>
                                            <td><?=$row['total_price']?></td>
                                            <td><?=$row['reg_date']?></td>
                                            <td><?=$row['cus_detail']?></td>
                                            <td><img src="../img/<?=$row['image']?>" width="100" height="100"></td>

                                            <td><a href="report_order_detail.php?id=<?=$row['orderID']?>" class="btn btn-warning" > รายละเอียด </td>
                                            <td><a href="delete_order.php?orderID=<?=$row['orderID']?>" class="btn btn-danger" onclick="return confirm('รายการสัางซื้อของคุณจะหายไปและไม่สามารถกลับมาอีกได้ต้องการลบโปรดยื่นยัน');">ยกเลิกคำสั่งซื้อ</a></td>


                                        </tr>
                                    
                                    <?php 
                                    }
                                    mysqli_close($conn);
                                    ?>
                                    
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
        <script>
    function deleteOrder(orderID) {
        // แสดงปุ่มยืนยันลบและซ่อนปุ่มลบ
        document.getElementById("confirmDelete_" + orderID).style.display = "inline";
        event.target.style.display = "none";
    }

    function confirmDelete(orderID) {
        if (confirm("คุณแน่ใจหรือไม่ที่จะลบคำสั่งซื้อนี้?")) {
            // ส่งคำขอลบคำสั่งซื้อไปยังหน้าเป็น PHP ที่จะดำเนินการลบข้อมูล
            window.location.href = "delete_order.php?orderID=" + orderID;
        } else {
            // ถ้าผู้ใช้ยกเลิกการลบ ซ่อนปุ่มยืนยันลบและแสดงปุ่มลบอีกครั้ง
            document.getElementById("confirmDelete_" + orderID).style.display = "none";
            document.getElementById("delete_" + orderID).style.display = "inline";
        }
    }
</script>
