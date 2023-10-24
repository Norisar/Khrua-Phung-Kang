<?php
include 'condb.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>showtype</title>

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

</head>
<body>
        <?php include 'menu1.php'; ?>
                <div class="container-fluid px-4">
                <a class="btn btn-primary mt-4 mb-4" href="add_type.php" role="button">Add+</a>
                    <div class="card mb-4">
                        <div class="alert alert-info " role="alert">
                                <i class="fas fa-table me-1"></i>
                                ประเภทสินค้า
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple" class="table table-striped" >
                                    <thead>
                                        <tr>
                                            <th>รหัสประเภทสินค้า</th>
                                            <th>ชื่อประเภทสินค้า</th>
                                            <!--<th>ลบ</th>-->
                                            

                                        </tr>
                                    </thead>
                                   
                                    <tbody>
<?php  

    $sql="SELECT * FROM type p,type t WHERE p.type_id=t.type_id";
    $hand=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_array($hand)){
?>

                                        <tr>
                                            <td><?=$row['type_id']?></td>
                                            <td><?=$row['type_name']?></td>
                                            <!--<td><a href="type_delete.php?id=<?=$row['type_id']?> "class="btn btn-success"> ลบ</a></td>
    -->
                                            
                                        </tr>
                                        <?php
    

?>
                            <?php  
                            }
                            mysqli_close($conn);
                            ?>
                                      
                                    </tbody>
                                </table>
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