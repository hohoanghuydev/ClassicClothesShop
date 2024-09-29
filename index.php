<?php session_start();
include 'class/Database.php';
include 'class/DanhMuc.php';
include './class/SanPham.php';
include './class/DatHang.php';
$conn = Database::getConnection();
$data = SanPham::getAll($conn);
// var_dump($data);
?>

<?php include 'inc/header.php' ?>

<!-- Banner -->
<swiper-container class="mySwiper" navigation="true">
    <swiper-slide>
        <img src="https://marketplace.canva.com/EAFEH3mIUaM/1/0/1600w/canva-dark-grey-and-white-minimalist-new-fashion-collection-banner-nvaqxg-8iXI.jpg" alt="">
    </swiper-slide>

    <swiper-slide>
        <img src="https://marketplace.canva.com/EAFKwirl3N8/1/0/1600w/canva-brown-minimalist-fashion-product-banner-iRHpbHTqh-A.jpg" alt="">
    </swiper-slide>

    <swiper-slide>
        <img src="https://marketplace.canva.com/EAFCzI60uhU/1/0/1600w/canva-brown-and-white-simple-fashion-collection-banner-IklhR9m-bSg.jpg" alt="">
    </swiper-slide>

    <swiper-slide>
        <img src="https://marketplace.canva.com/EAFoEJMTGiI/1/0/1600w/canva-beige-aesthetic-new-arrival-fashion-banner-landscape-cNjAcBMeF9s.jpg" alt="">
    </swiper-slide>
</swiper-container>
<!-- End banner -->

<!-- Categories -->
<div class="product-category py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title text-center text-uppercase text-secondary py-3">
                    <h2>Product Category</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="category-box bg-white border">
                    <a href="./clothing.php?cat=1">
                        <img class="img-fluid w-50 mx-auto d-block" src="https://front-co.com/cdn/shop/files/BB_720x.png?v=1708599467" alt="">
                        <div class="content align">
                            <h3>Clothing</h3>
                            <p>All</p>
                        </div>
                    </a>
                </div>

                <div class="category-box bg-white border">
                    <a href="./clothing.php?cat=2">
                        <img class="img-fluid w-50 mx-auto d-block" src="https://front-co.com/cdn/shop/products/D4G31_1080x.jpg?v=1663399972" alt="">
                        <div class="content">
                            <h3>Bag</h3>
                            <p>All</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="category-box category-box-2 bg-white border">
                    <a href="./clothing.php?cat=4">
                        <img class="img-fluid mx-auto d-block" src="https://front-co.com/cdn/shop/products/59e1a1c51afcd5a28ced1_720x.jpg?v=1647242121" alt="">
                        <div class="content">
                            <h3>Jewelry</h3>
                            <p>All</p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-12">
                <div class="category-box bg-white border">
                    <a href="./clothing.php?cat=3">
                        <img class="img-fluid mx-auto d-block" style="width: 25rem" src="https://front-co.com/cdn/shop/files/281201b3d65e86d3d1a2dd010b97646a_720x.jpg?v=1691749391" alt="">
                        <div class="content">
                            <h3>Accessories</h3>
                            <p>All</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End categories -->

<!-- Trendy products -->
<div class="trendy-products bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="title text-center text-uppercase py-3">
                <h2>Trendy Products</h2>
            </div>
        </div>
        <div class="row row-cols-md-3 row-cols-1 g-4">
            <?php foreach ($data as $row):?> 
                <?php if ($row->MaSanPham == 1 || $row->MaSanPham == 3 || $row->MaSanPham == 5 || $row->MaSanPham == 27 || $row->MaSanPham == 29):?>
                    <div class="col">
                        <div class="card">
                            <img src="./img/<?=$row->HinhAnh?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h6 class="card-title text-center text-secondary">
                                    <a href="./detail-product.php?MaSanPham=<?=$row->MaSanPham?>" class="stretched-link"><?=$row->TenSanPham?></a>
                                </h6>
                            </div>
                        </div>
                    </div>
                <?php endif?>
            <?php endforeach?>
        </div>
    </div>
</div>

<!-- End trendy products -->

<div class="email-subscribe py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="title">
                    <h2>SUBSCRIBE TO NEWSLETTER</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat, <br> facilis numquam
                        impedit ut sequi. Minus facilis vitae excepturi sit laboriosam.</p>
                </div>
                <div class="col-lg-6 offset-md-3">
                    <div class="input-group subscription-form">
                        <input type="text" class="form-control" placeholder="Enter Your Email Address">
                        <span class="input-group-btn">
                            <button class="btn btn-main" type="button">Subscribe Now!</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="view-us py-5">
    <div class="container">
        <div class="row">
            <div class="title text-center">
                <h2>View us on instagram</h2>
            </div>
        </div>
    </div>
</div>


<?php include 'inc/footer.php' ?>