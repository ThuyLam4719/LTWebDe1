<?php session_start();?>
<?php
if(!isset($_SESSION['email'])){
    header("Location: thongtin.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BookStore";
$mysql = new mysqli($servername, $username, $password, $dbname);
if($mysql->connect_error){
    die("Ket noi that bai: " .$mysql->connect_error);
}

//Lay thong tin tu 
$email = $_SESSION['email'];
$stmt = $mysql->prepare("SELECT ten,namsinh,quocgia FROM customers WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user=$stmt->get_result()->fetch_assoc();
//Xu li cap nhat
if(isset($_POST['capnhat'])){
    $ten = $_POST['ten'];
    $namsinh = $_POST['namsinh'];
    $quocgia = $_POST['quocgia'];

    $stmt=$mysql->prepare("UPDATE customers SET ten=?, namsinh=?, quocgia=? WHERE email=?");
    $stmt->bind_param("siss",$ten,$namsinh,$quocgia,$email);
    if($stmt->execute()){
        header("Location: thongtin.php");
    }
    
}

$mysql->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        <h1>Cap nhat thong tin</h1>
        <form method="post">
            Ho ten: <input type="text" name="ten" value="<?php echo $user['ten']; ?>" /> <br>
            Nam sinh:
            <select name="namsinh" id="namsinh">
                <script>
                    for (let i = 1990; i <= 2020; i++) {
                        document.write(`<option value="${i}"> ${i} </option>`)
                    }
                </script>
            </select> <br>
            Quoc gia: <input type="text" name="quocgia" value="<?php echo $user['quocgia']; ?>"> <br>
            <button type="submit" name="capnhat"> Cap nhat</button>

        </form>
    </div>
</body>

</html>



