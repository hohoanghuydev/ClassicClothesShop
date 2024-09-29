<?php
session_start();
include 'class/DanhMuc.php';
include 'class/Database.php';
include 'class/SanPham.php';
include './class/DatHang.php';

$conn = Database::getConnection();
$search = "";
$sort = "MaSanPham";
$arrange = "asc";
$page = 0;
$productPerPage = 4;

if(isset($_GET['sort'])){
    $sort = $_GET['sort'];
}

if(isset($_GET['arr'])){
    $arrange = $_GET['arr'];
}

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

$query = "select * from sanpham where tensanpham like :search order by Gia desc limit :limit offset :offset";
$count = SanPham::countProducts($conn, 0, $search);
$pages = ceil($count['SoLuong'] / $productPerPage);

$page = $_GET['page'] ?? 1;

if($page == 0){
    header("location: products-page.php?search=" . $search . "&page=1" . "&sort=" . $sort . "&arr=" . $arrange);
    exit();
}else if($page > $pages){
    header("location: products-page.php?search=" . $search . "&page=" . $pages . "&sort=" . $sort . "&arr=" . $arrange);
    exit();
}

$skip = ($page - 1) * $productPerPage;
$recordProducts = SanPham::executeSearch($conn, $search, $sort, $arrange, $page, $productPerPage);

?>

<?php include 'inc/header.php' ?>
<div class="container my-5">
    <h1 class="text-center mb-5">SHOP ALL</h1>
    <div class="dropdown mb-3">
        <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Arrange
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="products-page.php?search=<?=$search?>&page=<?=$page?>&sort=TenSanPham&arr=asc">Sắp xếp theo tên tăng</a></li>
            <li><a class="dropdown-item" href="products-page.php?search=<?=$search?>&page=<?=$page?>&sort=TenSanPham&arr=desc">Sắp xếp theo tên giảm</a></li>
            <li><a class="dropdown-item" href="products-page.php?search=<?=$search?>&page=<?=$page?>&sort=Gia&arr=asc">Sắp xếp theo giá tăng dần</a></li>
            <li><a class="dropdown-item" href="products-page.php?search=<?=$search?>&page=<?=$page?>&sort=Gia&arr=desc">Sắp xếp theo giá giảm dần</a></li>
            <li><a class="dropdown-item" href="products-page.php?search=<?=$search?>&page=<?=$page?>&sort=MaDanhMuc&arr=asc">Sắp xếp theo loại tăng</a></li>
            <li><a class="dropdown-item" href="products-page.php?search=<?=$search?>&page=<?=$page?>&sort=MaDanhMuc&arr=desc">Sắp xếp theo loại giảm</a></li>
        </ul>
    </div>
    <div class="all__product">
        <div class="row g-3">
            <?php foreach ($recordProducts as $row) : ?>
                <div class="col-md-6">
                    <div class="card">
                        <img src="img/<?= $row->HinhAnh ?>" class="card-img-top" alt="...">
                        <div class="card-body text-center">
                            <p class="card-text">FRONT</p>
                            <h5 class="card-title"><a href="detail-product.php?MaSanPham=<?= $row->MaSanPham ?>" class="text-dark stretched-link"><?= $row->TenSanPham ?></a></h5>
                            <p class="card-text"><?= number_format($row->Gia, 0, ',', '.') ?>đ</p>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <div class="pagination my-5 d-flex justify-content-center">
        <nav aria-label="Page navigation example ">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="products-page.php?search=<?=$search?>&page=<?= $page - 1 ?>&sort=<?=$sort?>&arr=<?=$arrange?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $pages; $i++) : ?>
                    <li class="page-item"><a class="page-link" href="products-page.php?search=<?=$search?>&page=<?= $i ?>&sort=<?=$sort?>&arr=<?=$arrange?>"><?= $i ?></a></li>
                <?php endfor ?>
                <li class="page-item">
                    <a class="page-link" href="products-page.php?search=<?=$search?>&page=<?= $page + 1 ?>&sort=<?=$sort?>&arr=<?=$arrange?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<?php include 'inc/footer.php' ?>