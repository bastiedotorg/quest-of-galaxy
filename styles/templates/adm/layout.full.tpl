<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link
            rel="shortcut icon"
            href="./styles/resource/admin/images/favicon.svg"
            type="image/x-icon"
    />
    <title>{$LNG.adm_cp_title} &bull; {$game_name}</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" type="text/css" href="./styles/resource/admin/css/bootstrap.min.css?">

    <link rel="stylesheet" href="./styles/resource/admin/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="./styles/resource/admin/css/LineIcons.css"/>
    <link rel="stylesheet" href="./styles/resource/admin/css/materialdesignicons.min.css"/>
    <link rel="stylesheet" href="./styles/resource/admin/css/fullcalendar.css"/>
    <link rel="stylesheet" href="./styles/resource/admin/css/fullcalendar.css"/>
    <link rel="stylesheet" href="./styles/resource/admin/css/main.css"/>
</head>
<body>
<!-- ======== sidebar-nav start =========== -->
<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo">
        <a href="admin.php">
            <img class="img-fluid" src="./styles/theme/qog/img/qog_logo.png" alt="logo"/>
        </a>
    </div>
    <nav class="sidebar-nav">
        {include "menu.admin.default.tpl"}
    </nav>
</aside>
<div class="overlay"></div>
<!-- ======== sidebar-nav end =========== -->

<!-- ======== main-wrapper start =========== -->
<main class="main-wrapper">
    <!-- ========== header start ========== -->
    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-6">
                    <div class="header-left d-flex align-items-center">
                        <div class="menu-toggle-btn mr-20">
                            <button
                                    id="menu-toggle"
                                    class="main-btn primary-btn btn-hover"
                            >
                                <i class="lni lni-chevron-left me-2"></i> Menu
                            </button>
                        </div>
                        <div class="header-search d-none d-md-flex">
                            <form action="#">
                                <input type="text" placeholder="Search..."/>
                                <button><i class="lni lni-search-alt"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ========== header end ========== -->

    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">
{block name="content"}{/block}
        </div>
        <!-- end container -->
    </section>
    <!-- ========== section end ========== -->

    <!-- ========== footer start =========== -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 order-last order-md-first">
                    <div class="copyright text-center text-md-start">
                        <p class="text-sm">
                            Designed and Developed by
                            <a
                                    href="https://plainadmin.com"
                                    rel="nofollow"
                                    target="_blank"
                            >
                                PlainAdmin
                            </a>
                        </p>
                    </div>
                </div>
                <!-- end col-->
                <div class="col-md-6">
                    <div class="terms d-flex justify-content-center justify-content-md-end">
                        <span>Quest of Galaxy ACP</span>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </footer>
    <!-- ========== footer end =========== -->
</main>
<!-- ======== main-wrapper end =========== -->

<!-- ========= All Javascript files linkup ======== -->
<script src="./styles/resource/admin/js/bootstrap.bundle.min.js"></script>

</body>
</html>