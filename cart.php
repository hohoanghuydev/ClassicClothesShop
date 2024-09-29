<?php
session_start();
include './class/DatHang.php';
include './class/DonHang.php';
include './class/GioHang.php';
include './class/Database.php';
include './class/SanPham.php';
include './class/DanhMuc.php';

if (!isset($_SESSION['TenTaiKhoan'])) {
    header("location: login.php");
    exit();
}

$conn = Database::getConnection();
$lstDatHang = [];
$tongTien = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $proId = $_POST['proId'];
    $qty = $_POST['qty'];
    $billId = $_POST['billId'];
    $price = $_POST['proPrice'];

    $check = DatHang::updateGioHang($conn, $proId, $billId, $qty, $price);
    $tongTien = DatHang::tinhTongTien($conn, $billId);
    $check = DonHang::updateTongTien($conn, $billId, $tongTien);
}

if (isset($_GET['action']) && isset($_GET['proid']) && isset($_GET['bill'])) {
    $action = $_GET['action'];
    $proid = $_GET['proid'];
    $billid = $_GET['bill'];
    if ($action == "delete" && !empty($proid) && !empty($billid)) {
        $check = DatHang::xoaDatHang($conn, $billid, $proid);
        if ($check) {
            $tongTien = DatHang::tinhTongTien($conn, $billid);
            var_dump($tongTien);
            $check2 = DonHang::updateTongTien($conn, $billid, $tongTien);
            // var_dump($check2);
            if ($check2) {
                header("location: cart.php");
                exit();
            }
        }
    }
}

if (isset($_SESSION['TenTaiKhoan'])) {
    $donHang = DonHang::getByUsername($conn, $_SESSION['TenTaiKhoan']);

    if ($donHang) {
        $lstDatHang = DatHang::getByDonHang($conn, $donHang->MaDonHang);
        $tongTien = $donHang->TongTien;
    }
}


?>
<?php include './inc/header.php' ?>
<section class="cart_area mb-5">
    <div class="container">
        <div class="cart_inner">
            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="px-0">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lstDatHang as $row) :
                            $sp = SanPham::getById($row->MaSanPham);
                        ?>
                            <tr class="product__info">
                                <td>
                                    <div class="media">
                                        <img class="w-25 h-25" src="img/<?= $sp->HinhAnh ?>" alt="">
                                        <div class="media-body d-inline-flex">
                                            <p><?= $sp->TenSanPham ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5><?= number_format($sp->Gia, 0, '.', ',') ?>đ</h5>
                                </td>
                                <td>
                                    <form action="cart.php" method="post">
                                        <input type="hidden" name="proId" value="<?= $sp->MaSanPham ?>">
                                        <input type="hidden" name="billId" value="<?= $donHang->MaDonHang ?>">
                                        <input type="hidden" name="proPrice" value="<?= $sp->Gia ?>">
                                        <div class="product_count mb-3">
                                            <input type="number" name="qty" id="sst" maxlength="12" min="1" minlength="1" onkeydown="return false;" style="max-width: 77px;" value="<?= $row->SoLuong ?>" title="Quantity:" class="input-text qty form-control">
                                        </div>
                                        <button type="submit" class="btn btn-secondary">Update</button>
                                    </form>
                                </td>
                                <td>
                                    <h5><?= number_format($row->TongCong, 0, '.', ',') ?>đ</h5>
                                </td>
                                <td>
                                    <a href="cart.php?action=delete&proid=<?= $row->MaSanPham ?>&bill=<?= $row->MaDonHang ?>">
                                        <span class="btn__delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 50 50">
                                                <path d="M 7.71875 6.28125 L 6.28125 7.71875 L 23.5625 25 L 6.28125 42.28125 L 7.71875 43.71875 L 25 26.4375 L 42.28125 43.71875 L 43.71875 42.28125 L 26.4375 25 L 43.71875 7.71875 L 42.28125 6.28125 L 25 23.5625 Z"></path>
                                            </svg>
                                        </span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>

                        <?php if (empty($lstDatHang)) : ?>
                            <tr style="height: 300px;" class="align-middle">
                                <td colspan="5">
                                    <h1 class="text-center">Giỏ hàng trống</h1>
                                </td>
                            </tr>
                        <?php endif ?>
                        <tr>
                            <td></td>
                            <td>
                                <h5>Tổng cộng</h5>
                            </td>
                            <td colspan="2">
                                <h5><?= $tongTien ? number_format($tongTien, 0, '.', ',') : 0 ?> đ</h5>
                            </td>
                        </tr>
                        <tr class="out_button_area">
                            <td class="d-none-l">
                            </td>
                            <td class="">
                            </td>
                            <td>
                            </td>
                            <td>
                                <div class="checkout_btn_inner d-flex align-items-center">
                                    <a class="btn btn-outline-dark me-3" href="products-page.php">Tiếp tục mua hàng</a>
                                    <a class="btn btn-dark" href="checkout.php?bill=<?= $donHang->MaDonHang ?>">Thanh toán</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php include 'inc/footer.php' ?>