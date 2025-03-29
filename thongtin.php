<?php session_start(); ?>
<?php
if(!isset($_SESSION['email'])){
    header("Location: dangnhap.php");
    exit();
}

$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "BookStore";

$mysql = new mysqli($hostname, $username,$password,$dbname);
if($mysql->connect_error){
    die("Khet noi that bai:" . $$mysql->connect_error);
}
$email = $_SESSION['email'];

$stmt = $mysql->prepare("SELECT ten,email, namsinh, quocgia, makh FROM customers WHERE email = ?");
$stmt->bind_param("s",$email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div>
        <h1>Thong tin nguoi dung</h1> 
        <p>Ho ten: <?php echo $user['ten'] ?> </p>
        <p>Dia chi email: <?php echo $user['email'] ?></p>
        <p>Nam sinh: <?php echo $user['namsinh'] ?></p>
        <p>Quoc gia: <?php echo $user['quocgia'] ?></p>
        <button > <a href="dangxuat.php"> Dang xuat </a> </button>
    </div>
</body>

</html>