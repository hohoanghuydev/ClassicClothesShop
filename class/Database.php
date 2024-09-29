<?php
class Database{
    public static function getConnection(){
        $host = "localhost";
        $dbname = "dbwebshop";
        $user = "my_dblocal";
        $pass = "0393004328Huy";

        try {
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
            $pdo = new PDO($dsn, $user, $pass);

            if($pdo != null){
                // echo 'Ket noi thanh cong';
                return $pdo;
            }else{
                echo 'Ket noi khong thanh cong';
            }
        } catch (Throwable $th) {
            //throw $th;
            echo $th;
        }
    }
}