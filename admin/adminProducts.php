<?php
session_start();
include '../class/Database.php';
include '../class/SanPham.php';

if (!isset($_SESSION['username'])) {
    header("location: login-admin.php");
    exit();
}

$conn = Database::getConnection();
$search = "";
// if (isset($_GET['action'])) {
//     $action = $_GET['action'];
//     if ($action == "delete") {
//         $idDelete = isset($_GET['idDelete']) ? $_GET['idDelete'] : "";

//         if (!empty($idDelete)) {
//             $sql = "delete from sanpham where masanpham = :id";
//             $stDelete = $conn->prepare($sql);

//             $stDelete->bindParam(':id', $idDelete, PDO::PARAM_INT);
//             if ($stDelete->execute()) {
//                 header("location: adminProducts.php");
//                 exit();
//             }else{
//                 die("truy van sai");
//             }
//         }
//     }
//     //Nếu không có id thì sao?
// }

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $search = "%$search%";
}

$proPerView = 5;
$countProduct = SanPham::countProducts($conn, 0, $search)['SoLuong'];

$pages = ceil($countProduct / $proPerView);

$sql1 = "select MaSanPham, TenSanPham, Gia, TenDanhMuc FROM sanpham, danhmuc WHERE sanpham.MaDanhMuc = danhmuc.MaDanhMuc order by MaSanPham limit :limit offset :offset";
$stmt = $conn->prepare($sql1);

$page = $_GET['page'] ?? 1;

if($page == 0){
    header("location: adminProducts.php?page=1");
    exit();
}else if($page > $pages){
    header("location: adminProducts.php?page=" . $pages);
    exit();
}

$skip = ($page - 1) * $proPerView;

$stmt->bindParam(':limit', $proPerView, PDO::PARAM_INT);
$stmt->bindParam(':offset', $skip, PDO::PARAM_INT);

if ($stmt->execute()) {
    // $stmt->setFetchMode(PDO::FETCH_CLASS, 'SanPham');
    $data = $stmt->fetchAll();
} else {
    die("truy van sai");
}
?>


<?php include './header.php';
include './navbar-menu.php' ?>

<main class="main" id="main">
    <section class="section">
        <h1 class="text-center">Danh sách sản phẩm</h1>
        <!-- Begin content -->
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>
        <a href="createProduct.php" class="btn btn-outline-primary my-3">Thêm sản phẩm</a>

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
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Loại sản phẩm</th>
                                <!-- <td></td> -->
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Loại sản phẩm</th>
                                <!-- <td></td> -->
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($data as $row) : ?>
                                <tr>
                                    <td><?= $row['MaSanPham'] ?></td>
                                    <td><a href="detail-product.php?MaSanPham=<?= $row['MaSanPham'] ?>"><?= $row['TenSanPham'] ?></a></td>
                                    <td><?= number_format($row['Gia'], 0, '.', ',') ?>đ</td>
                                    <td><?= $row['TenDanhMuc'] ?></td>
                                    <!-- <td>
                                <a href="updateProduct.php?idUpdate=<?= $row['MaSanPham'] ?>" class="btn btn-warning m-1">Edit</a>
                                <button type="button" class="btn btn-danger m-1" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</button>
                            </td> -->
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between">
                        <h5>Show 5 products per page</h5>
                        <ul class="pagination">
                            <li class="paginate-button page-item"><a href="adminProducts.php?page=<?= $page - 1 ?>" class="page-link">pre</a></li>
                            <?php for ($i = 1; $i <= $pages; $i++) : ?>
                                <li class="paginate-button page-item"><a href="adminProducts.php?page=<?= $i ?>" class="page-link"><?= $i ?></a></li>
                            <?php endfor ?>
                            <li class="paginate-button page-item"><a href="adminProducts.php?page=<?= $page + 1 ?>" class="page-link">next</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- End content -->


<!-- <div class="container">
    <div class="d-flex justify-content-between">
        <div>
            <a href="createProduct.php" class="btn btn-outline-success">Thêm sản phẩm</a>
        </div>
        <form class="d-flex" role="search" action="adminProducts.php" method="get">
            <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>
    <table class="table table-light">
        <tr>
            <td>Mã sản phẩm</td>
            <td>Tên sản phẩm</td>
            <td>Giá</td>
            <td>Loại sản phẩm</td>
            <td></td>
        </tr>
        In theo class => lỗi
        <?php foreach ($data as $row) : ?>
            <tr>
                <td><?= $row->MaSanPham ?></td>
                <td><a href="#<?= $row->MaSanPham ?>"><?= $row->TenSanPham ?></a></td>
                <td><?= number_format($row->Gia, 0, '.', ',') ?>đ</td>
                <td><?= $row->MaDanhMuc ?></td>
                <td></td>
            </tr>
        <?php endforeach ?>
        <?php foreach ($data as $row) : ?>
            <tr>
                <td><?= $row['MaSanPham'] ?></td>
                <td><a href="detail-product.php?MaSanPham=<?= $row['MaSanPham'] ?>"><?= $row['TenSanPham'] ?></a></td>
                <td><?= number_format($row['Gia'], 0, '.', ',') ?>đ</td>
                <td><?= $row['TenDanhMuc'] ?></td>
                <td>
                    <a href="updateProduct.php?idUpdate=<?= $row['MaSanPham'] ?>" class="btn btn-warning mx-1">Edit</a>
                    <button type="button" class="btn btn-danger mx-1" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</button>
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Bạn thật sự muốn xóa ?</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Thông tin sản phẩm muốn xóa: <?= $row['TenSanPham'] ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <a href="adminProducts.php?action=delete&idDelete=<?= $row['MaSanPham'] ?>" class="btn btn-primary">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
    <div class="mx-auto pagination my-5 d-flex justify-content-center">
        <nav aria-label="Page navigation example ">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $pages; $i++) : ?>
                    <li class="page-item"><a class="page-link" href="adminProducts.php?page=<?= $i ?>"><?= $i ?></a></li>
                <?php endfor ?>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div> -->

<?php include './footer.php' ?>