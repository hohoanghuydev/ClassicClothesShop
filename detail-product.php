<?php
session_start();
include 'class/DanhMuc.php';
include 'class/DatHang.php';
include 'class/DonHang.php';
include 'class/Database.php';
include 'class/SanPham.php';

$conn = Database::getConnection();
$tongTien = 0;
if (!isset($_GET['MaSanPham'])) {
    header("location: 404.php");
    exit();
} else {
    $id = $_GET['MaSanPham'];
}

if (empty($id)) {
    header("location: 404.php");
    exit();
}

// var_dump($_GET);
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $alert = 1;
    if ($action == "addtocart") {

        if (!isset($_SESSION['TenTaiKhoan'])) {
            header("location: login.php");
            exit();
        }

        $username = $_SESSION['TenTaiKhoan'];

        $donHang = DonHang::getByUsername($conn, $username);


        if (!$donHang) {
            $check = DonHang::createBill($conn, $username);
            if($check) {
                $donHang = DonHang::getByUsername($conn, $username);
            }
        }

        $_SESSION['DonHang'] = $donHang->MaDonHang;
        $datHang = DatHang::getByProduct($conn, $id, $donHang->MaDonHang);
        $sp = SanPham::getById($id);

        if ($datHang) {
            $check = DatHang::updateGioHang($conn, $id, $donHang->MaDonHang, $datHang->SoLuong + 1, $sp->Gia);
        } else {
            $soLuong = 1;
            $check = DatHang::addToCart($conn, $id, $donHang->MaDonHang, $soLuong, 'XL', $sp->Gia * $soLuong);
        }
        $tongTien = DatHang::tinhTongTien($conn, $donHang->MaDonHang);
        $check = DonHang::updateTongTien($conn, $donHang->MaDonHang, $tongTien);
    }
}

$conn = Database::getConnection();

$query = "select * from sanpham where masanpham = :id";
$stmt = $conn->prepare($query);

$stmt->bindParam(':id', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'SanPham');
    $row = $stmt->fetch();
}

// var_dump($row);
?>
<?php include 'inc/header.php' ?>
<div class="py-5 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="">
                    <div>
                        <img src="./img/<?= $row->HinhAnh ?>" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <div class="product-info">
                    <h3><?= $row->TenSanPham ?></h3>
                    <h2 class="text-secondary"><?= number_format($row->Gia, 0, '.', ',') ?>đ</h2>
                    <p><?= $row->MoTa ?></p>
                    <div class="product_count d-flex align-items-center">
                        <label for="qty">Quantity:</label>
                        <input type="text" readonly class="form-control text-center mx-3 rounded-pill" style="max-width: 3rem;" name="qty" id="sst" size="2" maxlength="12" value="1" title="Quantity:">
                        <a class="btn btn-outline-dark py-3 px-5 rounded-pill" href="detail-product.php?action=addtocart&MaSanPham=<?= $id ?>">Add to Cart</a>
                    </div>
                    <div class="card_area mt-4 d-flex align-items-center">
                        <a class="icon_btn" href="#"><i class="lnr lnr lnr-diamond"></i></a>
                        <a class="icon_btn" href="#"><i class="lnr lnr lnr-heart"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'inc/footer.php' ?>