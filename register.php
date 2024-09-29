<?php 
include 'class/Database.php';
include 'class/NguoiDung.php';
include 'class/DanhMuc.php';

$TenTaiKhoan = "";
$MatKhau = "";
$XacNhanMatKhau = "";
$TenNguoiDung = "";
$MatKhauHash = "";
$email = "";
$sdt = "";

$usError = "";
$pwError = "";
$confirmPwError = "";
$tenError = "";
$emailError = "";
$sdtError = "";

$sumError = "";

$conn = Database::getConnection();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST['TenTaiKhoan'])){
        $TenTaiKhoan = $_POST['TenTaiKhoan'];
        $check = NguoiDung::getByUsername($conn, $TenTaiKhoan);
        // var_dump($check);
        if($check){
            $usError = "Tên tài khoản đã tồn tại";
        }
    }else{
        $usError = "Tên tài khoản không được để trống";
    }

    if(!empty($_POST['MatKhau'])){
        $MatKhau = $_POST['MatKhau'];
        $MatKhauHash = password_hash($MatKhau, PASSWORD_BCRYPT);
    }else{
        $pwError = "Mật khẩu không được để trống";
    }

    if(!empty($_POST['TenNguoiDung'])){
        $TenNguoiDung = $_POST['TenNguoiDung'];
    }else{
        $tenError = "Tên người dùng không được để trống";
    }

    if(empty($_POST['XacNhanMatKhau'])){
        $confirmPwError = "Mật khẩu xác nhận không được để trống";
    }else if(strcmp($_POST['XacNhanMatKhau'], $MatKhau) != 0){
        $confirmPwError = "Mật khẩu xác nhận không khớp";
    }


    if(empty($_POST['Email'])){
        $emailError = "Email không được để trống";
    }else{
        $email = $_POST['Email'];
    }

    if(empty($_POST['SoDienThoai'])){
        $sdtError = "Số điện thoại không được để trống";
    }else{
        $sdt = $_POST['SoDienThoai'];
    }

    if(empty($usError) && empty($pwError) && empty($confirmPwError) && empty($tenError) && empty($emailError) && empty($sdtError)){
        $sql = "insert into NguoiDung (TenTaiKhoan, MatKhau, IdRole, TenNguoiDung, Email, SoDienThoai) values (:username, :password, 3, :name, :email, :sdt)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':username', $TenTaiKhoan, PDO::PARAM_STR);
        $stmt->bindParam(':password', $MatKhauHash, PDO::PARAM_STR);
        $stmt->bindParam(':name', $TenNguoiDung, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':sdt', $sdt, PDO::PARAM_STR);

        if($stmt->execute()){
            header("location: login.php");
            exit();
        }else{
            $sumError = "Tài khoản hoặc email đã tồn tại";
        }
    }
}


?>
<?php include 'inc/header.php'?>

<div class="container my-5">
    <h1 class="text-center">Đăng ký</h1>
    <form action="register.php" method="post" class="mx-auto" style="max-width: 500px;">
        <div class="row">
            <div class="col-12">
                <label for="TenTaiKhoan" class="form-label">Tên tài khoản</label>
                <input type="text" name="TenTaiKhoan" id="TenTaiKhoan" class="form-control" value="<?=$TenTaiKhoan?>">
                <span class="text-danger">* <?=$usError?></span>
            </div>

            <div class="col-12">
                <label for="TenNguoiDung" class="form-label">Tên người dùng</label>
                <input type="text" name="TenNguoiDung" id="TenNguoiDung" class="form-control" value="<?=$TenNguoiDung?>">
                <span class="text-danger">* <?=$tenError?></span>
            </div>

            <div class="col-12">
                <label for="MatKhau" class="form-label">Mật khẩu</label>
                <input type="password" name="MatKhau" id="MatKhau" class="form-control">
                <span class="text-danger">* <?=$pwError?></span>
            </div>

            <div class="col-12">
                <label for="XacNhanMatKhau" class="form-label">Xác nhận mật khẩu</label>
                <input type="password" name="XacNhanMatKhau" id="XacNhanMatKhau" class="form-control">
                <span class="text-danger">* <?=$confirmPwError?></span>
            </div>

            <div class="col-12">
                <label for="Email" class="form-label">Email</label>
                <input type="email" name="Email" id="Email" class="form-control" value="<?=$email?>">
                <span class="text-danger">* <?=$emailError?></span>
            </div>

            <div class="col-12">
                <label for="SoDienThoai" class="form-label">Số điện thoại</label>
                <input type="text" name="SoDienThoai" id="SoDienThoai" class="form-control" value="<?=$sdt?>">
                <span class="text-danger">* <?=$sdtError?></span>
            </div>

            <div class="col-12">
                <span class="text-danger"><?=$sumError?></span>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-success">Đăng ký</button>
                <!--Thêm nút đăng nhập ngay tự điền thông tin vào form đăng nhập -->
            </div>
        </div>
    </form>
</div>


<?php include 'inc/footer.php'?>