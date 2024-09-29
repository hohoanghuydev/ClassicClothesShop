<?php
session_start();
include '../class/Database.php';
include '../class/NguoiDung.php';

if (!isset($_SESSION['username'])) {
    header("location: login-admin.php");
    exit();
}

$conn = Database::getConnection();

$users = NguoiDung::getAll($conn);

if (isset($_GET['action']) && isset($_GET['userId'])) {
    $action = $_GET['action'];
    $userId = $_GET['userId'];
    if ($action == "delete") {
        $check = NguoiDung::deleteAccount($conn, $userId);
        if ($check) {
            header("location: adminAccounts.php");
            exit();
        } else {
            echo 'Xoa tai khoan that bai';
        }
    }
}
?>

<?php include './header.php';
include './navbar-menu.php' ?>

<main id="main" class="main">
    <section class="section">
        <h1 class="text-center">Danh sách tài khoản</h1>
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>

        <a href="create-account.php" class="btn btn-primary mb-3">Thêm tài khoản</a>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tên tài khoản</th>
                                <th>Role</th>
                                <th>Họ tên</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Tên tài khoản</th>
                                <th>Role</th>
                                <th>Họ tên</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($users as $row) : ?>
                                <tr>
                                    <td><a href="detail-account.php?username=<?= $row->TenTaiKhoan ?>"><?= $row->TenTaiKhoan ?></a></td>
                                    <td><?= $row->IdRole ?></td>
                                    <td><?= $row->TenNguoiDung ?></td>
                                    <td><?= $row->Email ?></td>
                                    <td><?= $row->SoDienThoai ?></td>
                                    <td>
                                        <a href="update-account.php?username=<?= $row->TenTaiKhoan ?>" class="btn btn-outline-warning">Edit</a>
                                        <a href="adminAccounts.php?action=delete&userId=<?= $row->TenTaiKhoan ?>" class="btn btn-outline-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between">
                    <h5>Show table</h5>
                    <ul class="pagination">
                        <li class="page-item"><a href="#" class="page-link">pre</a></li>
                        <li class="page-item"><a href="#" class="page-link">1</a></li>
                        <li class="page-item"><a href="#" class="page-link">nex</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include './footer.php' ?>