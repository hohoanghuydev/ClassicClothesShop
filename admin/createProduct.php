<?php
session_start();
include '../class/Database.php';
include '../class/SanPham.php';
include '../class/DanhMuc.php';

if (!isset($_SESSION['username'])) {
    header("location: login-admin.php");
    exit();
}

$ten = "";
$gia = 0;
$mota = "";
$danhmuc = 0;
$hinhAnh = "";

$tenError = "";
$giaError = "";
$motaError = "";
$hinhError = "";
$danhmucError = "";

$conn = Database::getConnection();

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
    // var_dump($_POST);

    if (empty($_POST['TenSanPham'])) {
        $tenError = "Tên sản phẩm không được bỏ trống";
    } else {
        $ten = $_POST['TenSanPham'];
    }

    if ($_POST['Gia'] < 1000) {
        $giaError = "Giá sản phẩm không hợp lệ";
    } else {
        $gia = $_POST['Gia'];
    }

    if (empty($_POST['MaDanhMuc'])) {
        $danhmucError = "Danh mục sản phẩm chưa chọn";
    } else {
        $danhmuc = $_POST['MaDanhMuc'];
    }

    $mota = $_POST['MoTa'];

    // validation cho image
    $file_image = $_FILES['HinhAnh'];
    var_dump($_FILES['HinhAnh']);
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

    if (empty($tenError) && empty($giaError) && empty($danhmucError) && !empty($hinhAnh)) {
        $sql = "insert into sanpham (TenSanPham, Gia, HinhAnh, MoTa, MaDanhMuc) values ( :ten, :gia, :hinh, :mota, :danhmuc)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ten', $ten, PDO::PARAM_STR);
        $stmt->bindParam(':gia', $gia, PDO::PARAM_INT);
        $stmt->bindParam(':hinh', $hinhAnh, PDO::PARAM_STR);
        $stmt->bindParam(':mota', $mota, PDO::PARAM_STR);
        $stmt->bindParam(':danhmuc', $danhmuc, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("location: adminProducts.php");
            exit();
        }
    }
}
$sql = "select * from danhmuc";
$stmt = $conn->prepare($sql);

if ($stmt->execute()) {
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'DanhMuc');
    $danhMucs = $stmt->fetchAll();
}

?>
<?php include './header.php';
include './navbar-menu.php' ?>
<main class="main" id="main">
    <section class="section">

        <div class="mx-auto m-5" style="max-width: 500px;">
            <h1>Thêm sản phẩm mới</h1>
            <form action="createProduct.php" method="post" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-12 mb-3">
                        <label for="TenSanPham" class="form-label">Tên sản phẩm</label>
                        <input type="text" name="TenSanPham" id="TenSanPham" class="form-control" value="<?= $ten ?>">
                        <span class="text-danger">* <?= $tenError ?></span>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="Gia" class="form-label">Giá</label>
                        <input type="number" name="Gia" id="Gia" class="form-control" value="<?= $gia ?>">
                        <span class="text-danger">* <?= $giaError ?></span>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="MaDanhMuc" class="form-label">Danh mục</label>
                        <select name="MaDanhMuc" id="MaDanhMuc" class="form-control">
                            <option value="">Chọn danh mục sản phẩm</option>
                            <?php foreach ($danhMucs as $option) : ?>
                                <?php if ($option->MaDanhMuc == $danhmuc) : ?>
                                    <option selected value="<?= $option->MaDanhMuc ?>"><?= $option->TenDanhMuc ?></option>
                                <?php else : ?>
                                    <option value="<?= $option->MaDanhMuc ?>"><?= $option->TenDanhMuc ?></option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>
                        <span class="text-danger">* <?= $danhmucError ?></span>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="HinhAnh" class="form-label">Hình ảnh</label>
                        <input type="file" name="HinhAnh" id="HinhAnh" class="form-control">
                        <span class="text-danger">* <?= $hinhError ?></span>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="MoTa" class="form-label">Mô tả</label>
                        <textarea name="MoTa" id="MoTa" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" name="submit" value="submit" class="btn btn-success">Thêm</button>
                        <a href="../admin/adminProducts.php" class="btn btn-light">Hủy</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>

<?php include './footer.php' ?>