<?php
include 'class/DanhMuc.php';
include 'class/Database.php';
include 'class/NguoiDung.php';

$conn = Database::getConnection();
$error = "";
$info = new NguoiDung();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty($_POST['email'])){
        $error = "Bạn chưa nhập email";
    }else{
        $email = $_POST['email'];

        $sql = "select * from nguoidung where email = :email";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'NguoiDung');
            $info = $stmt->fetch();
        }

        // var_dump($info);
        // if($info){
        //     $matKhau = password_verify($info->MatKhau, PASSWORD_BCRYPT);
        //     echo $matKhau;
        // }else{
        //     $error = "Email không hợp lệ";
        // }
    }

    
}
?>

<?php include 'inc/header.php'?>

<div class="mx-auto w-25 m-5">
    <h2 class="text-center mb-3">Cấp lại mật khẩu</h2>
    <form action="forgot-password.php" method="post">
        <input type="email" name="email" id="email" class="form-control mb-3" placeholder="Email của bạn">
        <span class="text-danger"><?=$error?></span>
        <button type="submit" class="btn btn-dark w-100 mt-3">Kiểm tra</button>
    </form>
</div>

<?php include 'inc/footer.php'?>