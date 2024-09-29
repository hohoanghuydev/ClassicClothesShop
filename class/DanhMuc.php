<?php
class DanhMuc{
    public $MaDanhMuc;
    public $TenDanhMuc;

    public static function getAll(){
        $conn = Database::getConnection();

        $sql = "select * from danhmuc";
        $stmt = $conn->prepare($sql);
        
        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'DanhMuc');
            return $stmt->fetchAll();
        }
    }
}