<?php
session_start();
include '../class/NguoiDung.php';
include '../class/Database.php';
include '../class/Quyen.php';

if (!isset($_SESSION['username'])) {
    header("location: login-admin.php");
    exit();
}

$conn = Database::getConnection();

$account = [];
if (isset($_GET['username'])) {
    $account = NguoiDung::getByUsername($conn, $_GET['username']);
    $lstRole = Quyen::getAll($conn);
} else {
    die("Sai duong dan truy cap");
}

$TenTaiKhoan = $account->TenTaiKhoan;
$TenNguoiDung = $account->TenNguoiDung;
$email = $account->Email;
$sdt = $account->SoDienThoai;
$quyen = $account->IdRole;

$usError = "";
$tenError = "";
$roleError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //validation and get info
    if (!empty($_POST['TenTaiKhoan'])) {
        $TenTaiKhoan = $_POST['TenTaiKhoan'];
    } else {
        $usError = "Tên tài khoản không được để trống";
    }

    if (!empty($_POST['TenNguoiDung'])) {
        $TenNguoiDung = $_POST['TenNguoiDung'];
    } else {
        $tenError = "Tên người dùng không được để trống";
    }

    if (!empty($_POST['IdRole'])) {
        $quyen = $_POST['IdRole'];
    } else {
        $roleError = "Phải chọn quyền cho tài khoản";
    }

    $email = $_POST['Email'];
    $sdt = $_POST['SoDienThoai'];

    if (empty($usError) && empty($tenError) && empty($roleError)) {
        $check = NguoiDung::updateInfo($conn, $TenTaiKhoan, $TenNguoiDung, $email, $sdt, $quyen);
        if ($check) {
            header("location: adminAccounts.php");
            exit();
        }
    }
    // goi ham update
}




?>

<?php include './header.php';
include './navbar-menu.php' ?>

<main class="main" id="main">
    <section class="section">
        <div class="container my-5">
            <h1 class="text-center">Cập nhật thông tin tài khoản</h1>
            <form action="#" method="post" class="mx-auto" style="max-width: 500px;">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="TenTaiKhoan" class="form-label">Tên tài khoản</label>
                        <input type="text" name="TenTaiKhoan" id="TenTaiKhoan" class="form-control" value="<?= $TenTaiKhoan ?>" readonly>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="IdRole" class="form-label">Role</label>
                        <select name="IdRole" id="IdRole" class="form-control">
                            <option value="">Chọn role cho tài khoản...</option>
                            <?php foreach ($lstRole as $role) : ?>
                                <?php if ($role->IdRole == $quyen) : ?>
                                    <option value="<?= $role->IdRole ?>" selected><?= $role->NameRole ?></option>
                                <?php else : ?>
                                    <option value="<?= $role->IdRole ?>"><?= $role->NameRole ?></option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>
                        <span class="text-danger">* <?= $roleError ?></span>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="TenNguoiDung" class="form-label">Tên người dùng</label>
                        <input type="text" name="TenNguoiDung" id="TenNguoiDung" class="form-control" value="<?= $TenNguoiDung ?>">
                        <span class="text-danger">* <?= $tenError ?></span>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="Email" class="form-label">Email</label>
                        <input type="email" name="Email" id="Email" class="form-control" value="<?= $email ?>">
                    </div>

                    <div class="col-12 mb-3">
                        <label for="SoDienThoai" class="form-label">Số điện thoại</label>
                        <input type="text" name="SoDienThoai" id="SoDienThoai" class="form-control" value="<?= $sdt ?>">
                    </div>

                    <div class="col-12 mb-3">
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="adminAccounts.php" class="btn btn-light">Back</a>
                        <!--Thêm nút đăng nhập ngay tự điền thông tin vào form đăng nhập -->
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>

<?php include './footer.php' ?>