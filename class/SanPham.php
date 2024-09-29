<?php
class SanPham{
    public $MaSanPham;
    public $TenSanPham;
    public $Gia;
    public $HinhAnh;
    public $MoTa;
    public $MaDanhMuc;

    public static function countProducts($conn, $catId, $search =""){
        if($catId != 0){
            $sql = "select count(MaSanPham) as SoLuong from sanpham where MaDanhMuc = :cat";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':cat', $catId, PDO::PARAM_INT);
        }else{
            $sql = "select count(MaSanPham) as SoLuong from sanpham where tensanpham like :search";
            $search = "%$search%";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':search', $search, PDO::PARAM_STR);
        }
        
        if($stmt->execute()){
            return $stmt->fetch();
        }
        return 0;
    }

    public static function executeSearch($conn, $search = "", $sort = "MaSanPham", $arrange = "asc", $page = 1, $proPerPage = 1){
        $query = "select * from sanpham where tensanpham like :search";
        $search = "%$search%";

        switch($sort){
            case "MaSanPham":
                if($arrange == "desc"){
                    $query = "select * from sanpham where tensanpham like :search order by MaSanPham desc";
                }else if($arrange == "asc"){
                    $query = "select * from sanpham where tensanpham like :search order by MaSanPham";
                }
                break;
            case "TenSanPham":
                if($arrange == "desc"){
                    $query = "select * from sanpham where tensanpham like :search order by TenSanPham desc";
                }else if($arrange == "asc"){
                    $query = "select * from sanpham where tensanpham like :search order by TenSanPham";
                }
                break;
            case "Gia":
                if($arrange == "desc"){
                    $query = "select * from sanpham where tensanpham like :search order by Gia desc";
                }else if($arrange == "asc"){
                    $query = "select * from sanpham where tensanpham like :search order by Gia";
                }
                break;
            case "MaDanhMuc":
                if($arrange == "desc"){
                    $query = "select * from sanpham where tensanpham like :search order by MaDanhMuc desc";
                }else if($arrange == "asc"){
                    $query = "select * from sanpham where tensanpham like :search order by MaDanhMuc";
                }
                break;
            default:
                break;
        }
        
        $query = $query . " limit :limit offset :offset";

        // echo $query;
        $skip = ($page - 1) * $proPerPage;

        // echo $search;
        // echo $skip;
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':search', $search, PDO::PARAM_STR);
        $stmt->bindParam(':limit', $proPerPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $skip, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'SanPham');
            return $stmt->fetchAll();
        } else {
            return [];
        }
    }


    public static function executeSearchCat($conn, $cat = 0, $search = "", $sort = "MaSanPham", $arrange = "asc", $page = 1, $proPerPage = 1){
        $query = "select * from sanpham where tensanpham like :search ";
        $search = "%$search%";

        if($cat != 0){
            $query = $query . "and madanhmuc = :cat";
        }

        switch($sort){
            case "MaSanPham":
                if($arrange == "desc"){
                    $query = $query . " order by MaSanPham desc";
                }else if($arrange == "asc"){
                    $query = $query . " order by MaSanPham";
                }
                break;
            case "TenSanPham":
                if($arrange == "desc"){
                    $query = $query . " order by TenSanPham desc";
                }else if($arrange == "asc"){
                    $query = $query . " order by TenSanPham";
                }
                break;
            case "Gia":
                if($arrange == "desc"){
                    $query = $query . " order by Gia desc";
                }else if($arrange == "asc"){
                    $query = $query . " order by Gia";
                }
                break;
            case "MaDanhMuc":
                if($arrange == "desc"){
                    $query = $query . " order by MaDanhMuc desc";
                }else if($arrange == "asc"){
                    $query = $query . " order by MaDanhMuc";
                }
                break;
            default:
                break;
        }
        
        $query = $query . " limit :limit offset :offset";

        // echo $query;
        $skip = ($page - 1) * $proPerPage;

        // echo $search;
        // echo $skip;
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':search', $search, PDO::PARAM_STR);
        $stmt->bindParam(':limit', $proPerPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $skip, PDO::PARAM_INT);
        if($cat != 0){
            $stmt->bindParam(':cat', $cat, PDO::PARAM_INT);
        }

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'SanPham');
            return $stmt->fetchAll();
        } else {
            return [];
        }
    }

    public static function getById($id){
        $conn = Database::getConnection();
        $sql = "select * from sanpham where MaSanPham = :id";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'SanPham');
            return $stmt->fetch();
        }
    }

    public static function CreateProduct($conn, $tenSp, $gia, $hinh, $moTa, $maDanhMuc){
        $sql = "INSERT INTO sanpham(TenSanPham, Gia, HinhAnh, MoTa, MaDanhMuc) VALUES (:ten ,:gia ,:hinh ,:mota,:danhmuc)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':ten', $tenSp, PDO::PARAM_STR);
        $stmt->bindParam(':gia', $gia, PDO::PARAM_INT);
        $stmt->bindParam(':hinh', $hinh, PDO::PARAM_STR);
        $stmt->bindParam(':mota', $moTa, PDO::PARAM_STR);
        $stmt->bindParam(':danhmuc', $maDanhMuc, PDO::PARAM_INT);

        return $stmt->execute() ? true : false;
    }

    public static function UpdateProduct($conn, $maSp, $tenSp, $gia, $hinh, $moTa, $maDanhMuc){
        $sql = "update sanpham set tensanpham = :tensp, gia = :gia, hinhanh = :hinh, mota = :mota
        , madanhmuc = :madanhmuc where masanpham = :masp";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':tensp', $tenSp, PDO::PARAM_STR);
        $stmt->bindParam(':gia', $gia, PDO::PARAM_INT);
        $stmt->bindParam(':hinh', $hinh, PDO::PARAM_STR);
        $stmt->bindParam(':mota', $moTa, PDO::PARAM_STR);
        $stmt->bindParam(':madanhmuc', $maDanhMuc, PDO::PARAM_INT);
        $stmt->bindParam(':masp', $maSp, PDO::PARAM_INT);

        return $stmt->execute() ? true : false;
    }

    public static function DeleteProduct($conn, $maSp){
        $sql = "delete from sanpham where masanpham = :masp";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':masp', $maSp, PDO::PARAM_INT);

        return $stmt->execute() ? true : false;
    }

    public static function getAll($conn){
        $sql = "select * from sanpham";
        $stmt = $conn->prepare($sql);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'SanPham');
            return $stmt->fetchAll();
        }
    }
}