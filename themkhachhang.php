 <?php session_start();?><!-- Bat session -->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BookStore";
$mysql = new mysqli($servername, $username, $password, $dbname);
if($mysql->connect_error){
    die("Ket noi that bai: " .$mysql->connect_error);
}

//Khoi tao session 
if(!isset($_SESSION['customerCount'])){ 
    $_SESSION['customerCount'] = 0;  //Neu chua them KH, gia tri mac dinh = 0
}

//Dang ky
if(isset($_POST['submit'])){
        $ten = $_POST['ten'];
        $email = $_POST['email'];
        $quocgia = $_POST['quocgia'];
        $namsinh = $_POST['namsinh'];
        $makh = $_POST['makh'];

        //Kiem tra dia chi email
        $checkEmail = $mysql->prepare("SELECT email FROM customers WHERE email=?");
        $checkEmail->bind_param("s",$email);
        $checkEmail->execute();
        $result = $checkEmail->get_result();
        if($result->num_rows > 0){
            echo "<script>alert('Email da ton tai!')</script>";
        } else { // Truy van INSERT
            $stmt = $mysql->prepare("INSERT INTO customers (makh, ten, email, namsinh, quocgia) values (?,?,?,?,?)");
            $stmt->bind_param("sssis", $makh,$ten,$email,$namsinh,$quocgia);
            if($stmt->execute()){
                $_SESSION['customerCount']++;
                echo "<script>alert(\"Đã thêm khách hàng thành công!\\nMật khẩu của người dùng: $makh\\nTong so nhan vien da them trong phien lam viec nay: {$_SESSION['customerCount']}\");</script>";            
            } else{
                echo "Loi: " . $stmt->error;
            }
            $stmt->close();
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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <h1>Them Khach hang</h1>
        <form method="post">
            Ten khach hang: <input type="text" name="ten" placeholder="Ho va ten" required> <br>
            Dia chi Email: <input type="email" name="email" placeholder="Nhap dia chi email" required> <br>
            Mat khau: <input type="password" name="makh" placeholder="Nhap mat khau" required> <br>
            Quoc gia: <select name="quocgia" id="quocgia">
                <option value="Vietnam"> Vietnam</option>
                <option value="USA"> USA </option>
                <option value="Khac"> Khac </option>
            </select> <br>
            Nam sinh: <select name="namsinh" id="namsinh">
                <script>
                    for (let i = 1980; i <= 2020; i++) {
                        document.write(`<option value=${i}> ${i}</option>`)
                    }
                </script>
            </select><br>
            <button type="submit" name="submit"> Luu </button>
            <button type="reset"> Xoa </button>
        </form>
    </div>
</body>

</html>