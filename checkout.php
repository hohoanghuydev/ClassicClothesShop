<?php
session_start(); //có thông tin user => binding thong tin len
//nhan checkout.php?madonhang=1
//nho validation chi nhap so cho sdt
include 'class/DanhMuc.php';
include 'class/Database.php';
include 'class/NguoiDung.php';
include 'class/DonHang.php';
include './class/DatHang.php';

if (!isset($_SESSION['TenTaiKhoan'])) {
    // die('chua dang nhap');
    header("location: login.php");
    exit();
}

if(isset($_GET['bill']) || isset($_POST['bill'])){
    $bill = $_GET['bill'] ?? $_POST['bill'];
}else{
    header("location: 404.php");
    exit();
}

$conn = Database::getConnection();
$error = "";
$userInfo = NguoiDung::getByUsername($conn, $_SESSION['TenTaiKhoan']);

if($_SERVER['REQUEST_METHOD'] == "POST"){
    // var_dump($_POST);
    // var_dump($userInfo);
    if(empty($_POST['hoten']) || empty($_POST['sdt']) || empty($_POST['email']) || empty($_POST['diachi'])){
        $error = "Vui lòng nhập đầy đủ thông tin vận chuyển trước khi thanh toán";
    }

    if(empty($error)){
        //Thanh toan
        $checkout = Donhang::thanhToanDonHang($conn, $bill);
        if($checkout){
            unset($_SESSION['DonHang']);
            header("location: confirmation.php");
            exit();
        }
    }
}
?>


<?php include 'inc/header.php' ?>

<div class="w-50 mx-auto my-5">
    <form action="checkout.php" method="post">
        <input type="hidden" name="bill" value="<?=$bill?>">
        <div class="row g-2">
            <div class="col-12">
                <h3>Thông tin vận chuyển</h3>
            </div>
            <div class="col-md-6">
                <input type="text" name="hoten" id="hoten" class="form-control rounded-4" placeholder="Họ tên khách hàng" value="<?=$userInfo->TenNguoiDung?>">
            </div>
            <div class="col-md-6">
                <input type="text" name="sdt" id="sdt" class="form-control rounded-4" placeholder="Số điện thoại" value="<?=$userInfo->SoDienThoai?>">
            </div>
            <div class="col-12">
                <input type="email" name="email" id="email" class="form-control rounded-4" placeholder="Email" value="<?=$userInfo->Email?>">
            </div>
            <div class="col-12">
                <input type="text" name="diachi" id="diachi" class="form-control rounded-4" placeholder="Địa chỉ giao hàng">
            </div>
            <div class="col-12">
                <textarea name="ghichu" id="ghichu" cols="30" rows="2" class="form-control rounded-4" placeholder="Ghi chú thêm (Ví dụ: Giao hàng giờ hành chính)"></textarea>
            </div>
            <div class="col-12">
                <span class="text-danger"><?=$error?></span>
            </div>
            <div class="col-12 my-3">
                <h3>Hình thức thanh toán</h3>
                <div class="hinhthuc__cod border border-1 border-dark rounded-4 p-3">
                    <div class="px-3">
                        <input class="form-check-input" type="radio" name="httt" id="httt" value="cod" checked>
                        <label class="form-check-label" for="httt">
                            COD - Thanh toán khi nhận hàng
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-dark w-100 rounded-3 py-3">Thanh toán</button>
            </div>
        </div>
    </form>



</div>

<?php include 'inc/footer.php' ?>