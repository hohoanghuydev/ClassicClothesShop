<?php
session_start();
unset($_SESSION['TenTaiKhoan'], $_SESSION['TenNguoiDung'], $_SESSION['Quyen'], $_SESSION['DonHang']);
header("location: login.php");
exit();