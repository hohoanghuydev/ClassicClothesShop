<?php
class GioHang{

    public static function getCartByBillId($billId){
        $conn = Database::getConnection();
        $sql = "select * from dathang where MaDonHang = :id";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id', $billId, PDO::PARAM_INT);

        if($stmt->execute()){
            return $stmt->fetch();
        }
    }
}