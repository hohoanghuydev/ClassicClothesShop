<?php
session_start();
include '../class/Database.php';
include '../class/SanPham.php';
include '../class/DanhMuc.php';

if (!isset($_SESSION['username'])) {
    header("location: login-admin.php");
    exit();
}

if (isset($_GET['MaSanPham']) && !empty($_GET['MaSanPham'])) {
    $id = $_GET['MaSanPham'];
} else {
    header("location: 404.php");
    exit();
}

$conn = Database::getConnection();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == "delete") {

        if (!empty($id)) {
            $sql = "delete from sanpham where masanpham = :id";
            $stDelete = $conn->prepare($sql);

            $stDelete->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stDelete->execute()) {
                header("location: adminProducts.php");
                exit();
            }
        }
    }
}

$query = "select * from sanpham where masanpham = :id";
$stmt = $conn->prepare($query);

$stmt->bindParam(':id', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'SanPham');
    $row = $stmt->fetch();

    if($row == null) {
        header("location: 404.php");
        exit();
    }
}

?>

<?php include './header.php';
include './navbar-menu.php' ?>

<main class="main" id="main">
    <section class="section">
        <table class="table table-responsive">
            <tr>
                <th>Hình ảnh</th>
                <td colspan="3"><img class="img-fluid" src="../img/<?= $row->HinhAnh ?>" alt=""></td>
            </tr>
            <tr>
                <th>Mã sản phẩm</th>
                <td><?= $row->MaSanPham ?></td>
                <th>Tên sản phẩm</th>
                <td><?= $row->TenSanPham ?></td>
            </tr>
            <tr>
                <th>Giá</th>
                <td><?= number_format($row->Gia, 0, '.', ',') ?>đ</td>
                <th>Mã danh mục</th>
                <td><?= $row->MaDanhMuc ?></td>
            </tr>
            <tr>
                <th>Mô tả</th>
                <td colspan="3"><?= $row->MoTa ?></td>
            </tr>
        </table>

        <div class="action g-3">
            <a href="updateProduct.php?idUpdate=<?= $row->MaSanPham ?>" class="btn btn-warning">Edit</a>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</button>
            <a href="adminProducts.php?page=3" class="btn btn-light">Cancel</a>
        </div>
    </section>
</main>


<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc chắn muốn xóa ?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Thông tin sản phẩm muốn xóa: <?= $row->TenSanPham ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="detail-product.php?MaSanPham=<?= $id ?>&action=delete" class="btn btn-primary">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php include './footer.php' ?>