<?php
session_start();
include '../class/DonHang.php';
include '../class/Database.php';

if (!isset($_SESSION['username'])) {
    header("location: login-admin.php");
    exit();
}

$conn = Database::getConnection();

$lstDatHang = DonHang::getAll($conn);

?>

<?php include './header.php';
include './navbar-menu.php' ?>

<main class="main" id="main">
    <section class="section">
        <h1 class="text-center">Danh sách đơn hàng</h1>
        <!-- Begin content -->
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Tên tài khoản</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <td>Trạng thái đơn hàng</td>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Tên tài khoản</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <td>Trạng thái đơn hàng</td>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($lstDatHang as $row) : ?>
                                <tr>
                                    <td><a href="detail-order.php?idorder=<?= $row->MaDonHang ?>"><?= $row->MaDonHang ?></a></td>
                                    <td><?= $row->TenTaiKhoan ?></td>
                                    <td><?= $row->NgayDat ?></td>
                                    <td><?= number_format($row->TongTien, 0, '.', ',') ?>đ</td>
                                    <?php if ($row->TrangThaiDonHang == 0) : ?>
                                        <td>Chưa thanh toán</td>
                                    <?php else : ?>
                                        <td>Đã thanh toán</td>
                                    <?php endif ?>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include './footer.php' ?>