<?php
class DatHang{
    public $MaSanPham;
    public $MaDonHang;
    public $SoLuong;
    public $KichThuoc;
    public $TongCong;

    public static function getByProduct($conn, $proId, $billId){
        $sql = "select * from DatHang where MaSanPham = :proid and MaDonHang = :billid";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':proid', $proId, PDO::PARAM_INT);
        $stmt->bindParam(':billid', $billId, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'DatHang');
            return $stmt->fetch();
        }else{
            echo 'Truy van that bai';
        }
    }

    public static function getByDonHang($conn, $billId){
        $sql = "select * from DatHang where MaDonHang = :billid";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':billid', $billId, PDO::PARAM_INT);
        
        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'DatHang');
            return $stmt->fetchAll();
        }
    }
    
    public static function updateGioHang($conn, $proId, $billId, $quantity, $price){
        $sql = "update DatHang set SoLuong = :qty, TongCong = :thanhtien where MaSanPham = :proid and MaDonHang = :billid";

        $stmt = $conn->prepare($sql);

        $thanhTien = $price * $quantity;

        $stmt->bindParam(':qty', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':thanhtien', $thanhTien, PDO::PARAM_INT);
        $stmt->bindParam(':proid', $proId, PDO::PARAM_INT);
        $stmt->bindParam(':billid', $billId, PDO::PARAM_INT);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public static function addToCart($conn, $proId, $billId, $quantity, $size, $total){
        $sql = "insert into DatHang (MaSanPham, MaDonHang, SoLuong, KichThuoc, TongCong)
                values (:proid, :billid, :qty, :size, :total)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':proid', $proId, PDO::PARAM_INT);
        $stmt->bindParam(':billid', $billId, PDO::PARAM_INT);
        $stmt->bindParam(':qty', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':size', $size, PDO::PARAM_STR);
        $stmt->bindParam(':total', $total, PDO::PARAM_INT);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public static function tinhTongTien($conn, $maDonHang){
        $sql = "SELECT COALESCE(SUM(TongCong), 0) as TongTien FROM dathang WHERE MaDonHang = :madonhang";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':madonhang', $maDonHang, PDO::PARAM_INT);

        if($stmt->execute()){
            return $stmt->fetch(PDO::FETCH_COLUMN);
        }else{
            return 0;
        }
    }
    public static function xoaDatHang($conn, $maDonHang, $masp){
        $sql = "delete from dathang where madonhang = :madh and masanpham = :masp";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':madh', $maDonHang, PDO::PARAM_INT);
        $stmt->bindParam(':masp', $masp, PDO::PARAM_INT);

        return $stmt->execute() ? true : false;
    }

    public static function sumCart($conn, $maDonHang) {
        $sql = "SELECT SUM(SoLuong) as SoLuongGioHang FROM dathang WHERE MaDonHang = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id', $maDonHang, PDO::PARAM_INT);

        $stmt->execute();

        $sum = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $sum['SoLuongGioHang'];
    }
}