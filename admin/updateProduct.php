<?php
session_start();
include '../class/Database.php';
include '../class/SanPham.php';
include '../class/DanhMuc.php';

$conn = Database::getConnection();

if (!isset($_SESSION['username'])) {
    header("location: login-admin.php");
    exit();
}

$TenSanPhamError = "";
$GiaError = "";
$MoTaError = "";
$MaDanhMucError = "";
$hinhError = "";

$TenSanPham = "";
$Gia = "";
$MoTa = "";
$MaDanhMuc = "";
$hinhAnh = "";

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
    // var_dump($_POST);

    $id = $_POST['MaSanPham'];
    if (empty($_POST['TenSanPham'])) {
        $TenSanPhamError = "Tên sản phẩm không được bỏ trống";
    } else {
        $TenSanPham = $_POST['TenSanPham'];
    }

    if ($_POST['Gia'] < 1000) {
        $GiaError = "Giá sản phẩm không hợp lệ";
    } else {
        $Gia = $_POST['Gia'];
    }

    if (empty($_POST['MaDanhMuc'])) {
        $MaDanhMucError = "Danh mục sản phẩm chưa chọn";
    } else {
        $MaDanhMuc = $_POST['MaDanhMuc'];
    }

    $MoTa = $_POST['MoTa'];

    $file_image = $_FILES['HinhAnh'];

    if (!empty($file_image['name'])) {
        switch ($file_image['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                $hinhError = "No file image";
                break;
            default:
                $hinhError = "Invalid file";
        }
        if ($file_image['size'] > 1000000) {
            $hinhError = "Image too large";
        }

        $myex = ['image/jpeg', 'image/png', 'image/webp'];
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileType = finfo_file($fileInfo, $file_image['tmp_name']);

        // echo $fileType;
        if (!in_array($fileType, $myex)) {
            $hinhError = "Invalid extension";
        }

        //save image
        if (empty($hinhError)) {
            $pathinfo = pathinfo($file_image['name']);
            $ex = $pathinfo['extension'];

            $folder = '../img/';
            $file = 'image.' . $ex;
            $dir_save = $folder . $file;
            $i = 1;
            while (file_exists($dir_save)) {
                $file = 'image-' . $i . '.' . $ex;
                $dir_save = $folder . $file;
                $i++;
            }

            if (move_uploaded_file($file_image['tmp_name'], $dir_save)) {
                $hinhAnh = $file;
            }
        }
    } else {
        $hinhError = "Empty image";
    }

    if (empty($TenSanPhamError) && empty($GiaError) && empty($MaDanhMucError)) {
        $sql = "update sanpham set TenSanPham = :tensp, Gia = :gia, MoTa = :mota, MaDanhMuc = :danhmuc where MaSanPham = :id";

        if (!empty($hinhAnh)) {
            $sql = "update sanpham set TenSanPham = :tensp, Gia = :gia, MoTa = :mota, MaDanhMuc = :danhmuc, HinhAnh = :hinh where MaSanPham = :id";
        }

        $stmt = $conn->prepare($sql);

        // Binding 
        $stmt->bindParam(':tensp', $TenSanPham, PDO::PARAM_STR);
        $stmt->bindParam(':gia', $Gia, PDO::PARAM_INT);
        $stmt->bindParam(':mota', $MoTa, PDO::PARAM_STR);
        $stmt->bindParam(':danhmuc', $MaDanhMuc, PDO::PARAM_INT);

        if (!empty($hinhAnh)) {
            $stmt->bindParam(':hinh', $hinhAnh, PDO::PARAM_STR);
        }

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("location: adminProducts.php");
            exit();
        } else {
            die("Truy van sai");
        }
    }
}
$sql2 = "select * from danhmuc";
$stmtDanhMuc = $conn->prepare($sql2);

if ($stmtDanhMuc->execute()) {
    $stmtDanhMuc->setFetchMode(PDO::FETCH_CLASS, 'DanhMuc');
    $danhMucs = $stmtDanhMuc->fetchAll();
}

if (isset($_GET['idUpdate']) && !empty($_GET['idUpdate'])) {
    $queryPro = "select * from sanpham where masanpham = :id";
    $stSanPham = $conn->prepare($queryPro);

    $idUpdate = $_GET['idUpdate'] ?? 0;
    $stSanPham->bindParam(':id', $idUpdate, PDO::PARAM_INT);

    if ($stSanPham->execute()) {
        $stSanPham->setFetchMode(PDO::FETCH_CLASS, 'SanPham');
        $infoSanPham = $stSanPham->fetch();
    }
} else {
    header("location: 404.php");
    exit();
}
?>

<?php include './header.php';
include './navbar-menu.php' ?>

<main class="main" id="main">
    <section class="section">
        <div class="form__update mx-auto my-5" style="max-width: 500px;">
            <h2 class="">Thay đổi thông tin sản phẩm</h2>
            <form action="updateProduct.php?idUpdate=<?= $infoSanPham->MaSanPham ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="MaSanPham" value="<?= $infoSanPham->MaSanPham ?>">
                <div class="row g-3">
                    <div class="col-12">
                        <label for="TenSanPham" class="form-label">Tên sản phẩm</label>
                        <input type="text" name="TenSanPham" id="TenSanPham" class="form-control" value="<?= $infoSanPham->TenSanPham ?>">
                        <span class="text-danger">* <?= $TenSanPhamError ?></span>
                    </div>
                    <div class="col-12">
                        <label for="Gia" class="form-label">Giá</label>
                        <input type="number" name="Gia" id="Gia" class="form-control" value="<?= $infoSanPham->Gia ?>">
                        <span class="text-danger">* <?= $GiaError ?></span>
                    </div>
                    <div class="col-12">
                        <label for="MaDanhMuc" class="form-label">Danh mục</label>
                        <select name="MaDanhMuc" id="MaDanhMuc" class="form-control">
                            <option value="">Chọn danh mục sản phẩm</option>
                            <?php foreach ($danhMucs as $option) : ?>
                                <?php if ($option->MaDanhMuc == $infoSanPham->MaDanhMuc) : ?>
                                    <option selected value="<?= $option->MaDanhMuc ?>"><?= $option->TenDanhMuc ?></option>
                                <?php else : ?>
                                    <option value="<?= $option->MaDanhMuc ?>"><?= $option->TenDanhMuc ?></option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>
                        <span class="text-danger">* <?= $MaDanhMucError ?></span>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="HinhAnh" class="form-label">Hình ảnh</label>
                        <input type="file" name="HinhAnh" id="HinhAnh" src="" alt="" class="form-control">
                    </div>
                    <div class="col-12 mb-3">
                        <label for="MoTa" class="form-label">Mô tả</label>
                        <textarea name="MoTa" id="MoTa" cols="30" rows="10" class="form-control"><?= $infoSanPham->MoTa ?></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" name="submit" value="submit" class="btn btn-success">Sửa</button>
                        <a href="../admin/adminProducts.php" class="btn btn-light">Hủy</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>

<?php include './footer.php' ?>