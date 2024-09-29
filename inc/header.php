<?php
$lstDanhMuc = DanhMuc::getAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="./css/temp.css">

</head>

<body>
    <div class="container-fluid p-0">
        <header class="py-3 bg-light">
            <section class="top-header">
                <div class="container">
                    <div class="row gy-3">
                        <div class="col-md-4 col-xs-12 col-sm-4 d-flex justify-content-center">
                            <div class="contact-number d-flex align-items-center">
                                <i class="fa-solid fa-phone fa-lg mx-2"></i>
                                <span class="">0909-808-707</span>
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-12 col-sm-4">
                            <div class="logo text-center mt-3">
                                <a href="../DoAn/">
                                    <h1>My shop</h1>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-12 col-sm-4 d-flex justify-content-center">
                            <nav class="navbar bg-light">
                                <div class="container-fluid">
                                    <form role="search" action="../DoAn/products-page.php" method="get">
                                        <div class="form__search d-flex">
                                            <input class="input__search form-control" name="search" value="" id="search" type="search" placeholder="Search" aria-label="Search">
                                            <button class="btn" type="submit">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32px" height="32px">
                                                    <path d="M 19 3 C 13.488281 3 9 7.488281 9 13 C 9 15.394531 9.839844 17.589844 11.25 19.3125 L 3.28125 27.28125 L 4.71875 28.71875 L 12.6875 20.75 C 14.410156 22.160156 16.605469 23 19 23 C 24.511719 23 29 18.511719 29 13 C 29 7.488281 24.511719 3 19 3 Z M 19 5 C 23.429688 5 27 8.570313 27 13 C 27 17.429688 23.429688 21 19 21 C 14.570313 21 11 17.429688 11 13 C 11 8.570313 14.570313 5 19 5 Z" />
                                                </svg>
                                            </button>
                                        </div>
                                        <span class="underline"></span>
                                    </form>
                                </div>
                            </nav>
                            <div class="nav-cart position-relative">
                                <a href="../DoAn/cart.php">
                                    <i class="fa-solid fa-cart-shopping fa-2xl mt-4"></i>
                                    <?php if (isset($_SESSION['DonHang']) && DatHang::sumCart($conn, $_SESSION['DonHang']) > 0): ?>
                                        <span class="position-absolute top-0 start-100 badge text-bg-danger">
                                            <?= DatHang::sumCart($conn, $_SESSION['DonHang']) ?>
                                        </span>
                                    <?php endif ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <hr>
            <nav class="navbar navbar-expand-lg bg-light">
                <div class="container-fluid ">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
                        <div class="navbar-nav text-center text-uppercase">
                            <a class="nav-link active" aria-current="page" href="../DoAn/index.php">Home</a>
                            <a class="nav-link" href="../DoAn/products-page.php">Shop</a>
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Categories
                                </a>

                                <ul class="dropdown-menu">
                                    <?php foreach ($lstDanhMuc as $danhMuc) : ?>
                                        <li><a class="dropdown-item" href="../DoAn/clothing.php?cat=<?= $danhMuc->MaDanhMuc ?>"><?= $danhMuc->TenDanhMuc ?></a></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>

                            <?php if (!isset($_SESSION['TenTaiKhoan'])) : ?>
                                <a class="nav-link" href="../DoAn/login.php">Login</a>
                            <?php else : ?>
                                <a class="nav-link" href="../DoAn/information.php">Hello <?= $_SESSION['TenNguoiDung'] ?></a>
                                <a class="nav-link" href="../DoAn/logout.php">Logout</a>
                            <?php endif ?>
                            <a class="nav-link" href="../DoAn/about.php">About us</a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>