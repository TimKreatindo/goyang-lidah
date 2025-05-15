<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=no">
    <meta name="description" content="Suha - Multipurpose E-commerce Mobile HTML Template">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#625AFA">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- The above tags *must* come first in the head, any other head content must come *after* these tags -->
    <!-- Title -->
    <title>Goyang Lidah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&amp;display=swap"
        rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="img/icons/icon-72x72.png">
    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" href="img/icons/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="img/icons/icon-167x167.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/icons/icon-180x180.png">
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?= base_url('template/customer/') ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('template/customer/') ?>css/tabler-icons.min.css">
    <link rel="stylesheet" href="<?= base_url('template/customer/') ?>css/animate.css">
    <link rel="stylesheet" href="<?= base_url('template/customer/') ?>css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url('template/customer/') ?>css/magnific-popup.css">
    <link rel="stylesheet" href="<?= base_url('template/customer/') ?>css/nice-select.css">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="<?= base_url('template/customer/') ?>css/style.css">
    <!-- Web App Manifest -->
    <link rel="manifest" href="<?= base_url('template/customer/') ?>js/manifest.json">

    <style>
    @media screen and (min-width: 991px) {
        .single-product-slide {
            height: 60vh;
        }
    }

    @media screen and (min-width: 768px) {
        .single-product-slide {
            height: 60vh;
        }
    }
    </style>
</head>

<body>
    <!-- Preloader-->
    <div class="preloader" id="preloader">
        <div class="spinner-grow text-secondary" role="status">
            <div class="sr-only"></div>
        </div>
    </div>
    <!-- Header Area -->
    <div class="header-area" id="headerArea">
        <div class="container h-100 d-flex align-items-center justify-content-between d-flex rtl-flex-d-row-r">
            <!-- Logo Wrapper -->
            <div class="logo-wrapper">
                <a href="home.html">
                    <img src="<?= base_url('template/customer/') ?>img/core-img/logo-small.png" alt="">
                </a>
            </div>
            <div class="navbar-logo-container d-flex align-items-center">

                <div class="form-check form-switch">
                    <input class="form-check-input" id="darkSwitch" type="checkbox" role="switch">
                </div>

                <!-- User Profile Icon -->
                <div class="user-profile-icon ms-2"><a href="profile.html"><img
                            src="<?= base_url('template/customer/') ?>img/bg-img/9.jpg" alt=""></a></div>
                <!-- end user profile icon -->

            </div>
        </div>
    </div>


    <?php $this->load->view($view) ?>





    <!-- Internet Connection Status-->
    <div class="internet-connection-status" id="internetStatus"></div>
    <!-- Footer Nav-->
    <div class="footer-nav-area" id="footerNav">
        <div class="suha-footer-nav">
            <ul class="h-100 d-flex align-items-center justify-content-between ps-0 d-flex rtl-flex-d-row-r">
                <li><a href="home.html"><i class="ti ti-home"></i>Home</a></li>
                <li><a href="message.html"><i class="ti ti-message"></i>Chat</a></li>
                <li><a href="cart.html"><i class="ti ti-basket"></i>Cart</a></li>
                <li><a href="settings.html"><i class="ti ti-settings"></i>Settings</a></li>
                <li><a href="pages.html"><i class="ti ti-heart"></i>Pages</a></li>
            </ul>
        </div>
    </div>
    <!-- All JavaScript Files-->
    <script src="<?= base_url('template/customer/') ?>js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('template/customer/') ?>js/jquery.min.js"></script>
    <script src="<?= base_url('template/customer/') ?>js/waypoints.min.js"></script>
    <script src="<?= base_url('template/customer/') ?>js/jquery.easing.min.js"></script>
    <script src="<?= base_url('template/customer/') ?>js/owl.carousel.min.js"></script>
    <script src="<?= base_url('template/customer/') ?>js/jquery.magnific-popup.min.js"></script>
    <script src="<?= base_url('template/customer/') ?>js/jquery.counterup.min.js"></script>
    <script src="<?= base_url('template/customer/') ?>js/jquery.countdown.min.js"></script>
    <script src="<?= base_url('template/customer/') ?>js/jquery.passwordstrength.js"></script>
    <script src="<?= base_url('template/customer/') ?>js/jquery.nice-select.min.js"></script>
    <script src="<?= base_url('template/customer/') ?>js/theme-switching.js"></script>
    <script src="<?= base_url('template/customer/') ?>js/no-internet.js"></script>
    <script src="<?= base_url('template/customer/') ?>js/active.js"></script>
    <!-- <script src="<?= base_url('template/customer/') ?>js/pwa.js"></script> -->
</body>

</html>