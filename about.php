<?php
session_start();
include './class/DanhMuc.php';
include './class/Database.php';
include './class/DatHang.php';
$conn = Database::getConnection();

?>
<?php include './inc/header.php'?>

<div class="container align-middle py-5">
    <h1 class="text-center ">About</h1>
    <p>Chào mừng bạn đến với My Shop, nơi mua sắm thời trang trực tuyến, mang đến cho bạn những trải nghiệm mua sắm tuyệt vời và thuận tiện nhất. 
        Tại My Shop, chúng tôi tự hào cung cấp một bộ sưu tập phong phú các sản phẩm thời trang chất lượng cao, từ quần áo, phụ kiện đến các sản phẩm đặc biệt trang sức bắt mắt.
    </p>
    <p>Trang web được thực hiện bởi Hồ Hoàng Huy. Đây là trang web bán quần, tại đây có đầy đủ các chức năng cần thiết cho việc bán quần áo.
        Với các chức năng cơ bản như xem sản phẩm, tìm kiếm, sắp xếp để có thể dễ dàng tìm thấy sản phẩm mong muốn. Người dùng còn có thể 
        thêm vào giỏ hàng sau khi đăng nhập vào trang we và cuối cùng để hoàn tất quá trình mua hàng đó là thanh toán, bạn có thể thanh toán nhanh 
        chóng bằng cách điền đầy đủ thông tin giao hàng.
    </p>

    <p>Hãy bắt đầu trải nghiệm mua sắm thú vị và đẳng cấp tại My Shop ngay hôm nay! Chúng tôi luôn sẵn sàng đón nhận và phục vụ bạn với tất cả sự tận tâm và chuyên nghiệp.</p>
</div>

<?php include './inc/footer.php'?>