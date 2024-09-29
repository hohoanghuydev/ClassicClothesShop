<?php
session_start();
include '../class/Database.php';
include '../class/DatHang.php';

$conn = Database::getConnection();

if (isset($_GET['idorder'])) {
    $idOrder = $_GET['idorder'];
} else {
    die("Sai đường dẫn");
}

$lstDatHang = DatHang::getByDonHang($conn, $idOrder);
?>

<?php include './header.php';
include './navbar-menu.php' ?>

<main class="main" id="main">
    <section class="section">
        <h1>Detail Order</h1>
        <table class="table table-success">
            <thead>
                <th>Mã sản phẩm</th>
                <th>Mã đơn hàng</th>
                <th>Số lượng</th>
                <th>Kích thước</th>
                <th>Tổng cộng</th>
            </thead>
            <tbody>
                <?php foreach ($lstDatHang as $don) : ?>
                    <tr>
                        <?php foreach (get_object_vars($don) as $key => $value) : ?>
                            <?php if ($key == "TongCong") : ?>
                                <td><?= number_format($value, 0, '.', ',') ?>đ</td>
                            <?php else : ?>
                                <td><?= $value ?></td>
                            <?php endif ?>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <a href="adminOrders.php" class="btn btn-light">Back</a>
    </section>
</main>

<?php include './footer.php' ?>