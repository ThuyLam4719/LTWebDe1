<?php
$servername = "localhost";
$username = "root";
$password ="";
$db = "BookStore";

$mysql = new mysqli($servername,$username,$password,$db);
if($mysql->connect_error){
    die("Ket noi that bai" . $mysql->connect_error);
}

$quocgia = isset($_POST['quocgia']) ? $_POST['quocgia']: "";//Nhan gia tri quoc gia tu Ajax khi nguoi dung chon

//Truy van du lieu khach hang
if($quocgia == "TatCa"){
    $sql = "SELECT ten, email, namsinh, quocgia FROM customers";
    $stmt = $mysql->prepare($sql);
} else {
    $sql = "SELECT ten, email, namsinh, quocgia FROM customers WHERE quocgia = ?";
    $stmt = $mysql->prepare($sql);
    $stmt->bind_param("s",$quocgia);
}
$stmt->execute();
$result = $stmt->get_result();

//Hien thi du lieu htmly
$output = "";
while ($row = $result->fetch_assoc()){
    $output .= "<tr>
    <td>{$row['ten']}</td>
    <td>{$row['email']}</td>
    <td>{$row['namsinh']}</td>
    <td>{$row['quocgia']}</td>
</tr>";
}
echo $output;

$stmt->close();
$mysql->close();

?>