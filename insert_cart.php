<?php
session_start();
include 'condb.php';
$cusName=$_POST['cus_name'];
$cusAddress=$_POST['cus_add'];
$cusTel=$_POST['cus_tel'];
$cusdetail=$_POST['cus_detail'];


//อัพโหลดรูปภาพ
if (is_uploaded_file($_FILES['file1']['tmp_name'])) {
    $new_image_name = 'sl_'.uniqid().".".pathinfo(basename($_FILES['file1']['name']), PATHINFO_EXTENSION);
    $image_upload_path = "./img/".$new_image_name;
    move_uploaded_file($_FILES['file1']['tmp_name'],$image_upload_path);
} else {
    $new_image_name = "";
}

$sql="INSERT INTO tb_order(cus_name,addres_s,telephone,cus_detail,total_price,image)
VALUES('$cusName','$cusAddress','$cusTel','$cusdetail','".$_SESSION["sum_price"]."','$new_image_name')";

$result=mysqli_query($conn,$sql);
if($result){
    echo "<script> window.location='slip.php'; </script>";
}


$orderID = mysqli_insert_id($conn);
$_SESSION["order_id"] = $orderID;

for ($i=0; $i <= (int)$_SESSION["intLine"]; $i++){
    if(($_SESSION["strProductID"][$i]) !=""){
    //ดึงข้อมูลสินค้า
    $sql1="select * from product where pro_id = '" . $_SESSION["strProductID"][$i] ."' ";
    $result1=mysqli_query($conn,$sql1);
    $row1=mysqli_fetch_array($result1);
    $price = $row1['price'];
    $total=$_SESSION["strQty"][$i] * $price;


    $sql2="insert into order_detail(orderID,pro_id,orderPrice,orderQty,Total)
    values('$orderID','" . $_SESSION["strProductID"][$i] ."','$price','".$_SESSION["strQty"][$i]."','$total')";
    if(mysqli_query($conn,$sql2)){
        //ตัดสต็อกสินค้า
        $sql3 = "update product set amount= amount - '" . $_SESSION["strQty"][$i] ."'
        where pro_id='" . $_SESSION["strProductID"][$i] ."'";
        mysqli_query($conn,$sql3);
        //echo "<script> alert('บันทึกข้อมูลเรียบร้อย') </script>";
        echo "<script> window.location='slip.php'; </script>";
    }


    }


}

//Line Notify
if(isset($_POST['submit'])){
    $orderID=$_POST['orderID'];
    $cusName=$_POST['cus_name'];
    $cusAddress=$_POST['cus_add'];
    $cusTel=$_POST['cus_tel'];
    $cusdetail=$_POST['cus_detail'];

    $sToken = "Uma2lOw39Bs2Zf8Ay3qa64GBFCuvECEuNNJfr4AKkY5";
	$sMessage = "มีคนสั่งอาหารโว้ยยยยยย\n";
    $sMessage .= "ชื่อ: ". $cusName . "\n";
    $sMessage .= "ที่อยู่: ". $cusAddress . "\n";
    $sMessage .= "เบอร์: ". $cusTel . "\n";
    $sMessage .= "รายละเอียด: ". $cusdetail . "\n";
    $sMessage .= "\n";
                    

	$chOne = curl_init(); 
	curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt( $chOne, CURLOPT_POST, 1); 
	curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
	$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
	curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
	curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
	$result = curl_exec( $chOne ); 

	//Result error 
	if($result){
        $_SESSION['success'] = "สั่งเรียบเรียบเเล้ว";
        header("location: slip.php" );
    } 
	
	curl_close( $chOne );   


}


mysqli_close($conn);
unset($_SESSION["intLine"]);
unset($_SESSION["strProductID"]);
unset($_SESSION["strQty"]);
unset($_SESSION["sum_price"]);

?>


