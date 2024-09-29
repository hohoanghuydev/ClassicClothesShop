<?php
class Quyen{
    public $IdRole;
    public $NameRole;

    public static function getAll($conn){
        $sql = "select * from quyen";
        $stmt = $conn->prepare($sql);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Quyen');
            return $stmt->fetchAll();
        }
    }
}