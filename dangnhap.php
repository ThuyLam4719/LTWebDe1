<?php session_start() ?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BookStore";
$mysql = new mysqli($servername, $username, $password, $dbname);
if($mysql->connect_error){
    die("Ket noi that bai: " .$mysql->connect_error);
}

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $makh = $_POST['makh'];
    
    $stmt = $mysql->prepare("SELECT * FROM customers WHERE email = ? AND makh = ?");
    $stmt->bind_param("ss",$email,$makh);
    $stmt->execute();
    $result = $stmt->get_result();

    $stmt->close();

    if($result->num_rows == 1){
        $_SESSION['email'] = $email;
        header("Location: thongtin.php");
        echo "dang nhap thanh cong";
    } else{
        echo "Sai email hoac mat khau!";
    }

}

$mysql->close(); //Dong ket noi CSDL khi da hoan thanh

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
        <h1> Dang nhap </h1>
        <form method="post">
            Dia chi Email: <input type="email" name="email" placeholder="Nhap email" required /> <br>
            Mat khau: <input type="password" name="makh" placeholder="Nhap mat khau" required> <br>
            <button type="submit" name="submit"> Dang nhap </button>
        </form>
    </div>
</body>

</html>