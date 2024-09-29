<?php
session_start();
include './class/Database.php';
include './class/NguoiDung.php';
include './class/DanhMuc.php';
include './class/DonHang.php';
include './class/DatHang.php';

$TenTaiKhoan = "";
$MatKhau = "";

$error = "";

$conn = Database::getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['TenTaiKhoan'])) {
        $TenTaiKhoan = $_POST['TenTaiKhoan'];
    } else {
        $error = "Nhập đầy đủ tài khoản và mật khẩu";
    }

    if (!empty($_POST['MatKhau'])) {
        $MatKhau = $_POST['MatKhau'];
        if (NguoiDung::getByUsername($conn, $TenTaiKhoan)) {
            $infoUser = NguoiDung::getByUsername($conn, $TenTaiKhoan);
            if (password_verify($MatKhau, $infoUser->MatKhau) && $infoUser->IdRole == 3) {
                $_SESSION['TenNguoiDung'] = $infoUser->TenNguoiDung;
                $_SESSION['TenTaiKhoan'] = $infoUser->TenTaiKhoan;
                $donHang = DonHang::getByUsername($conn, $infoUser->TenTaiKhoan);
                if($donHang) {
                    $_SESSION['DonHang'] = $donHang->MaDonHang;
                }
                $_SESSION['Quyen'] = $infoUser->IdRole;
                header("location: index.php");
                exit();
            } else {
                $error = "Tài khoản hoặc mật khẩu không khớp";
            }
        } else {
            $error = "Tài khoản không tồn tại";
        }
    } else {
        $error = "Nhập đầy đủ tài khoản và mật khẩu";
    }
}

?>
<?php include './inc/header.php' ?>
<section class="signin-page my-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 border p-5">
                <div class="text-center">
                    <h2 class="text-center text-uppercase my-3">Welcome Back</h2>
                    <form action="login.php" method="post" class="mx-auto" style="max-width: 500px;">
                        <div class="row gy-3">
                            <div class="col-12 form-group">
                                <input type="text" name="TenTaiKhoan" placeholder="Username" id="TenTaiKhoan" class="form-control">
                            </div>

                            <div class="col-12 form-group">
                                <input type="password" name="MatKhau" placeholder="Password" id="MatKhau" class="form-control">
                            </div>

                            <div class="col-12">
                                <span class="text-danger"><?= $error ?></span>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-dark mb-3 w-25 rounded-0 px-3 py-2">Login</button>
                                <div class="text-center mt-3">
                                    <a href="register.php">Đăng ký tài khoản mới</a>
                                    <span class="mx-2">|</span>
                                    <a href="forgot-password.php">Quên mật khẩu</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'inc/footer.php' ?>