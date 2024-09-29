<?php session_start();
include '../class/Database.php';
include '../class/Quyen.php';
include '../class/NguoiDung.php';

$conn = Database::getConnection();

$lstRole = Quyen::getAll($conn);

$tenTaiKhoan = "";
$tenNguoiDung = "";
$matKhau = "";
$matKhauXacNhan = "";
$email = "";
$sdt = "";
$idRole = "";
$pwHash = "";

$tenTaiKhoanError = "";
$tenNguoiDungError = "";
$matKhauError = "";
$matKhauXacNhanError = "";
$emailError = "";
$sdtError = "";
$idRoleError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['TenTaiKhoan'])) {
        $tenTaiKhoanError = "Tên tài khoản không được để trống";
    } else {
        $tenTaiKhoan = $_POST['TenTaiKhoan'];
    }

    if (empty($_POST['TenNguoiDung'])) {
        $tenNguoiDungError = "Tên người dùng không được để trống";
    } else {
        $tenNguoiDung = $_POST['TenNguoiDung'];
    }

    if (empty($_POST['IdRole'])) {
        $idRoleError = "Quyền tài khoản chưa chọn";
    } else {
        $idRole = $_POST['IdRole'];
    }

    $email = $_POST['Email'];
    $sdt = $_POST['SoDienThoai'];

    if (empty($_POST['MatKhau'])) {
        $matKhauError = "Mật khẩu không được để trống";
    } else {
        $matKhau = $_POST['MatKhau'];
        $pwHash = password_hash($matKhau, PASSWORD_BCRYPT);
    }

    if (empty($_POST['MatKhauXacNhan'])) {
        $matKhauXacNhanError = "Mật khẩu xác nhận không được để trống";
    } else {
        $matKhauXacNhan = $_POST['MatKhauXacNhan'];
        if ($matKhauXacNhan != $matKhau) {
            $matKhauXacNhanError = "Mật khẩu xác nhận không trùng khớp";
        }
    }

    if (empty($tenTaiKhoanError) && empty($tenNguoiDungError) && empty($idRoleError) && empty($matKhauError) && empty($matKhauXacNhanError)) {
        $check = NguoiDung::createAccount($conn, $tenTaiKhoan, $tenNguoiDung, $pwHash, $email, $sdt, $idRole);
        if ($check) {
            header("location: adminAccounts.php");
            exit();
        } else {
            echo 'Tao tai khoan that bai';
        }
    }
}
?>

<?php include './header.php';
include './navbar-menu.php' ?>


<main class="main" id="main">
    <section class="section">
        <div class="form-create">
            <form action="create-account.php" method="post" class="w-50 mx-auto">
                <h1 class="text-center">Tạo tài khoản</h1>
                <div class="row">
                    <!-- ten tk -->
                    <div class="col-md-6">
                        <input type="text" name="TenTaiKhoan" id="TenTaiKhoan" placeholder="Tên tài khoản" class="form-control rounded-pill my-2 p-4" value="<?= $tenTaiKhoan ?>">
                        <span class="text-danger">* <?= $tenTaiKhoanError ?></span>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="TenNguoiDung" id="TenNguoiDung" placeholder="Tên người dùng" class="form-control rounded-pill my-2 p-4" value="<?= $tenNguoiDung ?>">
                        <span class="text-danger">* <?= $tenNguoiDungError ?></span>
                    </div>
                    <div class="col-12">
                        <select name="IdRole" id="IdRole" class="form-control rounded-pill my-2">
                            <option value="">Chọn quyền cho tài khoản ...</option>
                            <?php foreach ($lstRole as $role) : ?>
                                <?php if ($role->IdRole != 1) : ?>
                                    <option value="<?= $role->IdRole ?>"><?= $role->NameRole ?></option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>
                        <span class="text-danger">* <?= $idRoleError ?></span>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="MatKhau" id="MatKhau" placeholder="Mật khẩu" class="form-control rounded-pill my-2 p-4">
                        <span class="text-danger">* <?= $matKhauError ?></span>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="MatKhauXacNhan" id="MatKhauXacNhan" placeholder="Mật khẩu xác nhận" class="form-control rounded-pill my-2 p-4">
                        <span class="text-danger">* <?= $matKhauXacNhanError ?></span>
                    </div>
                    <div class="col-12">
                        <input type="text" name="SoDienThoai" id="SoDienThoai" placeholder="Số điện thoại" class="form-control rounded-pill my-2 p-4" value="<?= $sdt ?>">
                    </div>
                    <div class="col-12">
                        <input type="email" name="Email" id="Email" placeholder="Địa chỉ email" class="form-control rounded-pill my-2 p-4" value="<?= $email ?>">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary rounded-pill my-2 py-2 w-100">Tạo tài khoản</button>
                        <a href="adminAccounts.php" class="btn btn-light rounded-pill my-2 py-2 w-100">Trở lại</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>

<?php include './footer.php' ?>