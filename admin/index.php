<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login-admin.php");
    exit();
}

include './header.php';
include './navbar-menu.php' ?>

<!-- Page Heading -->
<main class="main" id="main">
    <section class="section">
        <div class="align-items-center mb-4">
            <h3 class="mb-0 text-gray-800">Dashboard</h3>
        </div>
    </section>
</main>


<?php include './footer.php' ?>