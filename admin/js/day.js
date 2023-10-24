const thaiMonths = [
    'มกราคม',
    'กุมภาพันธ์',
    'มีนาคม',
    'เมษายน',
    'พฤษภาคม',
    'มิถุนายน',
    'กรกฎาคม',
    'สิงหาคม',
    'กันยายน',
    'ตุลาคม',
    'พฤศจิกายน',
    'ธันวาคม'
  ];
  
  function getThaiMonthName(monthNumber) {
    if (monthNumber >= 1 && monthNumber <= 12) {
      return thaiMonths[monthNumber - 1];
    } else {
      return 'เดือนไม่ถูกต้อง';
    }
  }
  
  // ใช้เมื่อต้องการทดสอบฟังก์ชัน getThaiMonthName
  // ตัวอย่างการใช้งาน:
  // const monthNumber = 3; // ตัวอย่างการใช้งานโดยกำหนดเดือนที่ 3 (มีนาคม)
  // const thaiMonthName = getThaiMonthName(monthNumber);
  // console.log(thaiMonthName); // ผลลัพธ์ควรเป็น 'มีนาคม'
  
  // Export ฟังก์ชันเพื่อให้เรียกใช้จากไฟล์อื่น
  export { getThaiMonthName };
  
// กำหนดข้อมูลและตัวเลือกสำหรับกราฟแบบแท่ง
var salesChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: salesData.map(item => item.month), // ใช้ชื่อเดือนใน labels
        datasets: [{
            label: 'ยอดขาย',
            data: salesData.map(item => item.total_sales),
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

// สร้าง Canvas Element และ context
var canvas = document.getElementById('salesPieChart');
var ctx = canvas.getContext('2d');

// รับข้อมูลยอดขายย้อนหลัง 7 วันจากฐานข้อมูล
// สมมุติว่าคุณมีตัวแปร salesData ที่เก็บข้อมูลยอดขายของแต่ละวัน

// กำหนดข้อมูลสีสำหรับ Pie Chart
var colors = ['#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff', '#990000'];

// สร้าง Pie Chart
var salesPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: salesData.map(item => item.date), // ใช้วันที่เป็น label
        datasets: [{
            data: salesData.map(item => item.total_sales), // ใช้ยอดขายเป็นข้อมูล
            backgroundColor: colors,
        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
    },
});

