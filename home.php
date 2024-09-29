<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="stylesheet" href="./css/temp.css">
</head>

<body>
    <div class="container-fluid">
        <header class="py-5 bg-light">
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
                            <div class="logo text-center">
                                <a href="#">
                                    <h1>My shop</h1>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-12 col-sm-4 d-flex justify-content-center">
                            <nav class="navbar bg-light">
                                <div class="container-fluid">
                                    <form class="d-flex" role="search">
                                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                                        <button class="btn btn-outline-dark" type="submit">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                    </form>
                                </div>
                            </nav>
                            <div class="nav-cart">
                                <a href="#cart">
                                    <i class="fa-solid fa-cart-shopping fa-2xl mt-4"></i>
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
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                            <a class="nav-link" href="#">Shop</a>
                            <a class="nav-link" href="#">Categories</a>
                            <a class="nav-link" href="#">Login</a>
                            <a class="nav-link" href="#">About us</a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

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
                            <a href="#">
                                <img class="img-fluid w-50 mx-auto d-block" src="https://front-co.com/cdn/shop/files/BB_720x.png?v=1708599467" alt="">
                                <div class="content align">
                                    <h3>Clothing</h3>
                                    <p>All</p>
                                </div>
                            </a>
                        </div>

                        <div class="category-box bg-white border">
                            <a href="#">
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
                            <a href="#">
                                <img class="img-fluid mx-auto d-block" src="https://front-co.com/cdn/shop/products/59e1a1c51afcd5a28ced1_720x.jpg?v=1647242121" alt="">
                                <div class="content">
                                    <h3>Jewelry</h3>
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
                    <div class="title text-center">
                        <h2>Trendy Products</h2>
                    </div>
                </div>
                <div class="row row-cols-md-3 row-cols-1 g-4">
                    <div class="col">
                        <div class="card">
                            <img src="https://front-co.com/cdn/shop/files/E1_720x.png?v=1709624619" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card">
                            <img src="https://front-co.com/cdn/shop/files/E1_720x.png?v=1709624619" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card">
                            <img src="https://front-co.com/cdn/shop/files/E1_720x.png?v=1709624619" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card">
                            <img src="https://front-co.com/cdn/shop/files/E1_720x.png?v=1709624619" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card">
                            <img src="https://front-co.com/cdn/shop/files/E1_720x.png?v=1709624619" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                        </div>
                    </div>
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

        <footer class="footer py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 d-flex flex-column align-content-center">
                        <ul class="social-media d-flex justify-content-center">
                            <li class="mx-2">
                                <a href="#">
                                    <i class="fa-brands fa-facebook fa-bounce fa-2xl"></i>
                                </a>
                            </li>

                            <li class="mx-2">
                                <a href="#">
                                    <i class="fa-brands fa-instagram fa-bounce fa-2xl"></i>
                                </a>
                            </li>

                            <li class="mx-2">
                                <a href="#">
                                    <i class="fa-brands fa-youtube fa-bounce fa-2xl"></i>
                                </a>
                            </li>

                            <li class="mx-2">
                                <a href="#">
                                    <i class="fa-brands fa-twitter fa-bounce fa-2xl"></i>
                                </a>
                            </li>
                        </ul>

                        <ul class="footer__menu text-uppercase d-flex justify-content-center mt-5">
                            <li class="mx-2">
                                <a href="">CONTACT</a>
                            </li>
                            <li class="mx-2">
                                <a href="">SHOP</a>
                            </li>
                            <li class="mx-2">
                                <a href="">Pricing</a>
                            </li>
                            <li class="mx-2">
                                <a href="">PRIVACY POLICY</a>
                            </li>
                            <li class="mx-2">
                                <a href="">About us</a>
                            </li>
                        </ul>

                        <p class="fw-semibold text-secondary mx-2 d-flex justify-content-center mt-3">Design by Ho Hoang Huy</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="https://kit.fontawesome.com/3bb9851cda.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
</body>

</html>