<?php
class NguoiDung{
    public $TenTaiKhoan;
    public $MatKhau;
    public $IdRole;
    public $TenNguoiDung;
    public $Email;
    public $SoDienThoai;

    public static function getByUsername($conn, $user){
        $sql = "select * from NguoiDung where TenTaiKhoan = :user";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':user', $user, PDO::PARAM_STR);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'NguoiDung');
            return $stmt->fetch();
        }else{
            return false;
        }
    }

    public static function getAll($conn){
        $sql = "select * from nguoidung";
        $stmt = $conn->prepare($sql);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'NguoiDung');
            return $stmt->fetchAll();
        }
    }

    // public static function checkLogin($conn, $taiKhoan, $matKhau){
    //     $getInfoUser = new NguoiDung();
    //     $getInfoUser = NguoiDung::getByUsername($conn, $taiKhoan);

    //     if(empty($getInfoUser)){
    //         return null;
    //     }

    //     if(!password_verify($matKhau, $getInfoUser->MatKhau)){
    //         return null;
    //     }

    //     return $getInfoUser;
    // }

    public static function updateInfo($conn, $user, $ten, $email, $sdt, $role){
        $sql = "update nguoidung set TenNguoiDung = :ten, Email = :email, IdRole = :role, SoDienThoai = :sdt where TenTaiKhoan = :username";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':ten', $ten, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_INT);
        $stmt->bindParam(':sdt', $sdt, PDO::PARAM_STR);
        $stmt->bindParam(':username', $user, PDO::PARAM_STR);

        return $stmt->execute() ? true : false;
    }

    public static function deleteAccount($conn, $user){
        $sql = "delete from NguoiDung where TenTaiKhoan = :user";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':user', $user, PDO::PARAM_STR);

        return $stmt->execute() ? true : false;
    }

    public static function createAccount($conn, $user, $name, $pw, $email, $sdt, $role){
        $sql = "INSERT INTO nguoidung(TenTaiKhoan, MatKhau, IdRole, TenNguoiDung, Email, SoDienThoai) VALUES (:user, :pw, :idrole, :ten, :email, :sdt)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':user', $user, PDO::PARAM_STR);
        $stmt->bindParam(':pw', $pw, PDO::PARAM_STR);
        $stmt->bindParam(':idrole', $role, PDO::PARAM_INT);
        $stmt->bindParam(':ten', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':sdt', $sdt, PDo::PARAM_STR);

        return $stmt->execute() ? true : false;
    }
}