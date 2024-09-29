<?php
session_start();
include './class/DanhMuc.php';
include './class/Database.php';
include './class/DatHang.php';
include './class/NguoiDung.php';
$conn = Database::getConnection();

$user = NguoiDung::getByUsername($conn, $_SESSION['TenTaiKhoan']);
?>
<?php include 'inc/header.php'?>

<div class="container align-middle" style="height: 300px;">
    <h1 class="text-center">Thông tin cá nhân</h1>
    <table class="table table-borderless">
        <tbody>
            <tr>
                <th>Tên tài khoản</th>
                <td><?=$user->TenTaiKhoan?></td>
            </tr>
            
            <tr>
                <th>Tên người dùng</th>
                <td><?=$user->TenNguoiDung?></td>
            </tr>
            
            <tr>
                <th>Email</th>
                <td><?=$user->Email?></td>
            </tr>
            
            <tr>
                <th>Số điện thoại</th>
                <td><?=$user->SoDienThoai?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php include 'inc/footer.php'?>