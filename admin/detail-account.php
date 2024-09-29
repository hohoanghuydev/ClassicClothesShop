<?php
session_start();
include '../class/NguoiDung.php';
include '../class/Database.php';

if (!isset($_SESSION['username'])) {
    header("location: login-admin.php");
    exit();
}

$conn = Database::getConnection();

$account = [];
if (isset($_GET['username'])) {
    $account = NguoiDung::getByUsername($conn, $_GET['username']);
} else {
    die("Sai duong dan truy cap");
}
// var_dump($account);
?>

<?php include './header.php';
include './navbar-menu.php' ?>

<main class="main" id="main">
    <section class="section">
        <table class="table table-primary">
            <tr>
                <th>Tên tài khoản</th>
                <td><?= $account->TenTaiKhoan ?></td>
            </tr>
            <tr>
                <th>Role</th>
                <td><?= $account->IdRole ?></td>
            </tr>
            <tr>
                <th>Tên người dùng</th>
                <td><?= $account->TenNguoiDung ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= $account->Email ?></td>
            </tr>
            <tr>
                <th>Số điện thoại</th>
                <td><?= $account->SoDienThoai ?></td>
            </tr>
        </table>
        <a href="adminAccounts.php" class="btn btn-light">Back</a>
    </section>
</main>

<?php include './footer.php' ?>