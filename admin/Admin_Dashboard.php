<?php

include 'condb.php'; // เชื่อมต่อฐานข้อมูล


session_start();

// ตรวจสอบว่ามีเซสชันของผู้ใช้งานหรือไม่
if (!isset($_SESSION['user_id'])) {
    // หากไม่มีเซสชัน ให้เปลี่ยนเส้นทางไปยังหน้าล็อคอิน
    header("Location: login.php"); // หรือหน้าที่คุณต้องการให้กลับไปยังหน้าล็อคอิน
    exit();
}

/********************************************** */
// SQL query สำหรับหาผลรวมของคอลัมน์ total_price ในตาราง tb_order
$sql = "SELECT SUM(total_price) AS total_sales FROM tb_order";

// ทำการส่งคำสั่ง SQL ไปยังฐานข้อมูล
$result = mysqli_query($conn, $sql);

// ตรวจสอบว่ามีข้อมูลที่ถูกคืนมาหรือไม่
if ($result) {
    // ดึงข้อมูลผลรวม
    $row = mysqli_fetch_assoc($result);
    $totalSales = $row['total_sales'];
} else {
    // หากเกิดข้อผิดพลาดในการสั่ง SQL
    echo "Error: " . mysqli_error($conn);
}
/********************************************** */

// SQL query สำหรับหาจำนวนการสั่งซื้อทั้งหมด
$sql = "SELECT COUNT(orderID) AS total_orders FROM tb_order";

// ทำการส่งคำสั่ง SQL ไปยังฐานข้อมูล
$result = mysqli_query($conn, $sql);

// ตรวจสอบว่ามีข้อมูลที่ถูกคืนมาหรือไม่
if ($result) {
    // ดึงข้อมูลผลรวม
    $row = mysqli_fetch_assoc($result);
    $totalOrders = $row['total_orders'];
} else {
    // หากเกิดข้อผิดพลาดในการสั่ง SQL
    echo "Error: " . mysqli_error($conn);
}

/********************************************** */

// SQL query สำหรับหายอดขายของวันนี้
$sql = "SELECT SUM(total_price) AS today_sales FROM tb_order WHERE DATE(reg_date) = CURDATE()";

$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $todaySales = $row['today_sales'];
} else {
    echo "Error: " . mysqli_error($conn);
}

/********************************************** */
include 'condb.php';

// SQL query สำหรับหาจำนวนการสั่งซื้อทั้งหมด
$sql = "SELECT DATE_FORMAT(reg_date, '%Y-%m') AS month, SUM(total_price) AS total_sales FROM tb_order GROUP BY month ORDER BY month";

// ทำการส่งคำสั่ง SQL ไปยังฐานข้อมูล
$result = mysqli_query($conn, $sql);

// ตรวจสอบว่ามีข้อมูลที่ถูกคืนมาหรือไม่
if ($result) {
    // ดึงข้อมูลผลรวมแต่ละเดือน
    $salesData = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $salesData[] = $row;
    }
} else {
    // หากเกิดข้อผิดพลาดในการสั่ง SQL
    echo "Error: " . mysqli_error($conn);
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
mysqli_close($conn);
/********************************************** */

include 'condb.php'; // เชื่อมต่อฐานข้อมูล

// สร้างคำสั่ง SQL เพื่อดึงข้อมูลยอดขายใน 7 วันที่แสดงวันที่ในรูปแบบ "วัน เดือน ปี"
$sql = "SELECT DATE_FORMAT(DATE(reg_date), '%d %M %Y') AS date, SUM(total_price) AS total_sales FROM tb_order WHERE DATE(reg_date) BETWEEN DATE_SUB(CURDATE(), INTERVAL 6 DAY) AND CURDATE() GROUP BY DATE(reg_date) ORDER BY DATE(reg_date)";

$result = mysqli_query($conn, $sql);

if ($result) {
    $salesData = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $salesData[] = $row;
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin Dashboard</title>
    <script src="day.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="./js/day.js" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <?php include 'menu1.php'; ?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="alert alert-info h4 text-center mt-4" role="alert">
                    Admin Dashboard
                </div>

                <div class="row">
                    
                    <!-- แสดงผล รายได้ของวันนี้ในการสั่งซื้อ -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            รายได้ของวันนี้</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?= number_format($todaySales, 2) ?> บาท <!-- แสดงยอดขายเฉพาะวันนี้ -->
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- แสดงผลรายได้ทั้งหมดในการสั่งซื้อ -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            รายได้ทั้งหมด</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?= number_format($totalSales, 2) ?> บาท<!-- แสดงผลลัพธ์ที่คำนวณ -->
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- แสดงจำนวนการสั่งซื้อทั้งหมด -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            จำนวนการสั่งซื้อ</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?= $totalOrders ?> ออเดอร์ <!-- แสดงผลลัพธ์ที่คำนวณ -->
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- แสดงกราฟยอดขายแต่ละเดือน -->
                    <div class="col-xl-8 col-lg-7">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">ยอดขายแต่ละเดือน</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                    
    <div class="container">
    </div>
<!-- ส่วน HTML ด้านบนของหน้าเว็บ -->

<div class="container">
    <canvas id="monthlySalesChart" width="400" height="200"></canvas>
</div>

<!-- ส่วนสคริปต์ PHP สำหรับการดึงข้อมูลจากฐานข้อมูล -->
<?php
include 'condb.php'; // เชื่อมต่อฐานข้อมูล

// SQL query สำหรับหายอดขายของแต่ละเดือน
$sql = "SELECT DATE_FORMAT(reg_date, '%Y-%m') AS month, SUM(total_price) AS total_sales FROM tb_order GROUP BY month ORDER BY month";

// ทำการส่งคำสั่ง SQL ไปยังฐานข้อมูล
$result = mysqli_query($conn, $sql);

// ตรวจสอบว่ามีข้อมูลที่ถูกคืนมาหรือไม่
if ($result) {
    // ดึงข้อมูลยอดขายแต่ละเดือน
    $monthlySalesData = array();
    $labels = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $monthlySalesData[] = $row['total_sales'];
        // แปลงรูปแบบเดือนเป็นชื่อเดือนภาษาไทย
        $monthInThai = date('F', strtotime($row['month']));
        $thaiMonths = array(
            'January' => 'มกราคม',
            'February' => 'กุมภาพันธ์',
            'March' => 'มีนาคม',
            'April' => 'เมษายน',
            'May' => 'พฤษภาคม',
            'June' => 'มิถุนายน',
            'July' => 'กรกฎาคม',
            'August' => 'สิงหาคม',
            'September' => 'กันยายน',
            'October' => 'ตุลาคม',
            'November' => 'พฤศจิกายน',
            'December' => 'ธันวาคม'
        );
        $thaiMonth = $thaiMonths[$monthInThai];
        $labels[] = $thaiMonth;
    }
} else {
    // หากเกิดข้อผิดพลาดในการสั่ง SQL
    echo "Error: " . mysqli_error($conn);
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
mysqli_close($conn);
?>

<!-- ส่วนสคริปต์ JavaScript สำหรับการสร้างกราฟแท่ง -->
<script>
// ข้อมูลยอดขายแต่ละเดือนที่คุณดึงมาจากฐานข้อมูล
var monthlySalesData = <?php echo json_encode($monthlySalesData); ?>;

// ชื่อเดือนที่ใช้แสดงบนกราฟแท่ง (เป็นภาษาไทย)
var labels = <?php echo json_encode($labels); ?>;

// สร้าง canvas สำหรับแสดงกราฟแท่ง
var monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');

// กำหนดข้อมูลและตัวเลือกสำหรับกราฟแท่ง
var monthlySalesChart = new Chart(monthlySalesCtx, {
    type: 'bar',
    data: {
        labels: labels, // ใช้ชื่อเดือนภาษาไทยเป็น labels
        datasets: [{
            label: 'ยอดขาย',
            data: monthlySalesData,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<!-- ส่วน HTML ด้านล่างของหน้าเว็บ -->

 
        
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">สรุปยอดขาย 7 วัน</h6>
            <div class="dropdown no-arrow"></div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <!-- เพิ่ม canvas สำหรับแสดงกราฟทรงกลม -->
            <canvas id="salesPieChart" width="400" height="200"></canvas>
            <script>
    // ข้อมูลสำหรับ Pie Chart
    var pieData = <?php echo json_encode($salesData); ?>;

    // สร้าง canvas สำหรับแสดง Pie Chart
    var pieCtx = document.getElementById('salesPieChart').getContext('2d');

    // กำหนดตัวเลือกสำหรับ Pie Chart
    var pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: pieData.map(item => item.date), // ใช้วันที่เป็น labels
            datasets: [{
                label: 'ยอดขาย',
                data: pieData.map(item => item.total_sales),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)',
                    'rgba(100, 200, 64, 0.5)' // เพิ่มสีเพิ่มเติมตามความต้องการ
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(100, 200, 64, 1)' // เพิ่มสีเพิ่มเติมตามความต้องการ
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
</script>
        </div>
    </div>
</div>

            <br>
            <div class="table-responsive small">
             

            <h2 class="m-0 font-weight-bold text-primary">รายการสั่งซื้อ</h2>
            <br>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
        }

        .pagination li {
            margin-right: 10px;
        }
    </style>

    <?php
    include 'condb.php'; // เชื่อมต่อฐานข้อมูล

    $itemsPerPage = 10; // จำนวนรายการต่อหน้า
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // หน้าปัจจุบัน

    // คำนวณเริ่มต้นและสิ้นสุดของรายการที่จะแสดงในหน้าปัจจุบัน
    $start = ($currentPage - 1) * $itemsPerPage;

    // สร้างคำสั่ง SQL สำหรับดึงข้อมูลการสั่งสินค้าทั้งหมด
    $sql = "SELECT * FROM tb_order ORDER BY reg_date DESC LIMIT $start, $itemsPerPage";


    // ทำการส่งคำสั่ง SQL ไปยังฐานข้อมูล
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>รหัสการสั่งซื้อ</th>';
            echo '<th>วันที่สั่งซื้อ</th>';
            echo '<th>ชื่อลูกค้า</th>';
            echo '<th>ราคารวม (บาท)</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['orderID'] . '</td>';
                echo '<td>' . $row['reg_date'] . '</td>';
                echo '<td>' . (isset($row['cus_name']) ? $row['cus_name'] : '') . '</td>';
                echo '<td>' . $row['total_price'] . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';

            // สร้างลิงก์หน้าถัดไปและหน้าก่อนหน้า
            $totalOrders = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_order"));
            $totalPages = ceil($totalOrders / $itemsPerPage);
          
            echo '<ul class="pagination">';
            if ($currentPage > 1) {
                echo '<li><a href="?page=' . ($currentPage - 1) . '">ก่อนหน้า</a></li>';
            }
            
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<li><a href="?page=' . $i . '">' . $i . '</a></li>';
            }
            
            if ($currentPage < $totalPages) {
                echo '<li><a href="?page=' . ($currentPage + 1) . '">ถัดไป</a></li>';
            }
            echo '</ul>';
            

            echo '</ul>';
        } else {
            echo 'ยังไม่มีข้อมูลการสั่งสินค้าในระบบ';
        }
    } else {
        echo 'เกิดข้อผิดพลาดในการดึงข้อมูล: ' . mysqli_error($conn);
    }

    // ปิดการเชื่อมต่อกับฐานข้อมูล
    mysqli_close($conn);
    ?>

            </div>
        </main>
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
