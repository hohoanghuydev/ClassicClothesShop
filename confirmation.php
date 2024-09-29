<?php
session_start();
include 'class/DanhMuc.php';
include 'class/Database.php';
include './class/DatHang.php';
$conn = Database::getConnection();

?>

<?php include './inc/header.php' ?>

<section class="page-wrapper success-msg py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="block text-center">
                    <i style="font-size: 3rem;" class="fa-solid fa-circle-check fa-2xl my-4"></i>
                    <h2 class="text-center">Thank you! For your payment</h2>
                    <p>Payment success</p>
                    <a href="./products-page.php" class="btn btn-light mt-20">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.page-warpper -->

<?php include './inc/footer.php' ?>