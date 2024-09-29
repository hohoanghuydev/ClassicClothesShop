<?php
session_start();
include '../class/Database.php';
include '../class/NguoiDung.php';

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

        if (NguoiDung::getByUsername($conn, $TenTaiKhoan) != false) {
            $infoUser = NguoiDung::getByUsername($conn, $TenTaiKhoan);

            if (password_verify($MatKhau, $infoUser->MatKhau) && in_array($infoUser->IdRole, [1, 2])) {
                $_SESSION['name'] = $infoUser->TenNguoiDung;
                $_SESSION['username'] = $infoUser->TenTaiKhoan;
                $_SESSION['role'] = $infoUser->IdRole;
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
<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="./css/custom.min.css" rel="stylesheet">
</head>

<body> -->
<?php include './header.php' ?>
    <div class="container my-5" style="height: 500px;">
        <h1 class="text-center">Đăng nhập</h1>
        <form action="login-admin.php" method="POST" class="mx-auto" style="max-width: 500px;">
            <div class="row gy-3">
                <div class="col-12 mb-3">
                    <label for="TenTaiKhoan" class="form-label">Tên tài khoản</label>
                    <input type="text" name="TenTaiKhoan" id="TenTaiKhoan" class="form-control">
                </div>

                <div class="col-12 mb-3">
                    <label for="MatKhau" class="form-label">Mật khẩu</label>
                    <input type="password" name="MatKhau" id="MatKhau" class="form-control">
                </div>
                <div class="col-12 mb-3">
                    <span class="text-danger"><?= $error ?></span>
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-dark me-1">Đăng nhập</button>
                </div>
            </div>
        </form>
    </div>
    <?php include './footer.php' ?>
<!-- </body>

</html> -->