<?php
class DonHang{
    public $MaDonHang;
    public $TenTaiKhoan;
    public $NgayDat;
    public $TongTien;
    public $TrangThaiDonHang;

    public static function getAll($conn){
        $sql = "select * from DonHang";
        $stmt = $conn->prepare($sql);
        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'DonHang');
            return $stmt->fetchAll();
        }
    }

    public static function getByUsername($conn, $username){
        $sql = "select * from DonHang where TenTaiKhoan = :us and TrangThaiDonHang = 0";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':us', $username, PDO::PARAM_STR);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'DonHang');
            return $stmt->fetch();
        }else{
            echo 'Truy van that bai';
        }
    }
    public static function createBill($conn, $user){
        $sql = "insert into DonHang(TenTaiKhoan, TongTien, TrangThaiDonHang)
                values (:user, 0, 0)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':user', $user, PDO::PARAM_STR);

        return $stmt->execute() ? true : false;
    }
    public static function updateTongTien($conn, $donHang, $tongTien){
        $sql = "update donhang set tongtien = :total where madonhang = :donhang";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':total', $tongTien, PDO::PARAM_INT);
        $stmt->bindParam(':donhang', $donHang, PDO::PARAM_INT);

        return $stmt->execute() ? true : false;
    }

    public static function thanhToanDonHang($conn, $maDonHang){
        $sql = "update donhang set trangthaidonhang = 1 where madonhang = :billid";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':billid', $maDonHang, PDO::PARAM_INT);
        return $stmt->execute() ? true : false;
    }
}