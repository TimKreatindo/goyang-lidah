<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> | FMIPA UNEJ</title>

    <link rel="icon" href="<?= base_url('assets/img/web/logo.png') ?>" type="image/x-icon">

    <link rel="stylesheet" href="<?= base_url('template/client/') ?>compiled/css/app.css">
    <link rel="stylesheet" href="<?= base_url('template/client/') ?>compiled/css/app-dark.css">
    <link rel="stylesheet" href="<?= base_url('template/client/') ?>compiled/css/iconly.css">

    <link rel="stylesheet" href="<?= base_url('template/admin') ?>/fonts/fontawesome.css">
    <link rel="stylesheet" href="<?= base_url('template/client/extensions/sweetalert2/sweetalert2.min.css') ?>">
    <link rel="stylesheet"
        href="<?= base_url('template/client/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') ?>">


    <style>
    .list_uploaded {
        border: 1px solid #a6a5c7;
    }

    .list-dosen {
        border: 1px solid #a6a5c7;
    }
    </style>
</head>

<body>
    <script src="<?= base_url('template/client/') ?>static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo w-100">
                            <a href=""><img width="65px" style="height: 60px"
                                    src="<?= base_url('assets/img/web/logo.png') ?>" alt="Logo"></a>
                        </div>
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20"
                                height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                        opacity=".3"></path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark"
                                    style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">

                    <div class="row g-1 align-items-center px-2 py-3" style="border: 1px solid #e0e0e0;">
                        <div class="col-2">
                            <img src="<?= base_url('assets/img/profile/') . $user->image ?>" alt="avatar" class="w-100">
                        </div>
                        <div class="col-10">
                            <strong><?= word_limiter($user->nama, 4) ?></strong> <br>
                            <small><?= $user->nip ?></small>
                        </div>
                    </div>

                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        <li class="sidebar-item">
                            <a href="<?= base_url('client') ?>" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="far fa-folder"></i>
                                <span>Hibah</span>
                            </a>

                            <ul class="submenu ">

                                <li class="submenu-item  ">
                                    <a href="<?= base_url('client/hibah-penelitian') ?>" class="submenu-link">Hibah
                                        Penelitian</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="<?= base_url('client/hibah-pengabdian') ?>" class="submenu-link">Hibah
                                        Pengabdian</a>
                                </li>

                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a href="<?= base_url('client/kegiatan-tridharma') ?>" class='sidebar-link'>
                                <i class="far fa-folder"></i>
                                <span>Kegiatan Tridharma</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="<?= base_url('client/hki') ?>" class='sidebar-link'>
                                <i class="far fa-folder"></i>
                                <span>HKI</span>
                            </a>
                        </li>

                        <!-- <li class="sidebar-item">
                            <a href="<?= base_url('client/hibah-penelitian') ?>" class='sidebar-link'>
                                <i class="far fa-folder"></i>
                                <span>Hibah Penelitian</span>
                            </a>
                        </li> -->

                        <li class="sidebar-item">
                            <a href="<?= base_url('client/seminar-webinar') ?>" class='sidebar-link'>
                                <i class="far fa-folder"></i>
                                <span>Seminar/Webinar</span>
                            </a>
                        </li>

                        <!-- <li class="sidebar-item">
                            <a href="<?= base_url('client/hibah-pengabdian') ?>" class='sidebar-link'>
                                <i class="far fa-folder"></i>
                                <span>Hibah Pengabdian</span>
                            </a>
                        </li> -->

                        <li class="sidebar-item">
                            <a href="<?= base_url('client/rekognisi') ?>" class='sidebar-link'>
                                <i class="far fa-folder"></i>
                                <span>Rekognisi</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="<?= base_url('client/sertifikat-kompetensi') ?>" class='sidebar-link'>
                                <i class="far fa-folder"></i>
                                <span>Sertifikat Kompetensi</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="<?= base_url('client/publikasi') ?>" class='sidebar-link'>
                                <i class="far fa-folder"></i>
                                <span>Publikasi</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="<?= base_url('client/pengelola-jurnal') ?>" class='sidebar-link'>
                                <i class="far fa-folder"></i>
                                <span>Pengelola Jurnal</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="<?= base_url('client/organisasi') ?>" class='sidebar-link'>
                                <i class="far fa-folder"></i>
                                <span>Organisasi</span>
                            </a>
                        </li>


                        <li class="sidebar-item ">
                            <a href="<?= base_url('login/logout') ?>" class='sidebar-link'>
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Log out</span>
                            </a>
                        </li>
                    </ul>

                    <div class="text-center">
                        <small>&copy 2025 JTeam</small>
                    </div>
                </div>
            </div>
        </div>
        <div id="main" style="height: 100vh;">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <h3><?= $title ?></h3>
            </div>
            <div class="page-content">
                <section class="row">
                    <?php $this->load->view($view) ?>
                </section>
            </div>
        </div>
    </div>
    <script src="<?= base_url('template/client/') ?>static/js/components/dark.js"></script>
    <script src="<?= base_url('template/client/') ?>extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>


    <script src="<?= base_url('template/client/') ?>compiled/js/app.js"></script>
    <script src="<?= base_url('template/client') ?>/extensions/jquery/jquery.min.js"></script>
    <script src="<?= base_url('template/client/extensions/sweetalert2/sweetalert2.min.js') ?>"></script>
    <script src="<?= base_url('template/client/extensions/datatables.net/js/jquery.dataTables.js') ?>">
    </script>
    <script src="<?= base_url('template/client/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') ?>">
    </script>
    <script>
    const base_url = '<?= base_url() ?>'

    function loading_animation() {
        Swal.fire({
            title: 'Loading..',
            html: 'Please wait..',
            timerProgressBar: true,
            draggable: true,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
            },
        })
    }

    function regenerate_token(token) {
        const c_name = '<?= $this->security->get_csrf_token_name() ?>'
        $('input[name="' + c_name + '"]').val(token)
    }

    function error_alert(msg) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: msg
        })
    }

    function error_alert_reloaded(msg) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: msg
        }).then((res) => {
            window.location.reload()
        })
    }

    function success_alert(msg) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: msg
        })
    }

    function success_alert_reloaded(msg) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: msg
        }).then((res) => {
            window.location.reload()
        })
    }
    </script>
    <script src="<?= base_url('assets/js/file.js') ?>"></script>
    <?php
        if(isset($js)){
            foreach($js as $j){
                echo '<script src="'.base_url('assets/js/client/').$j.'"></script>';
            }
        }
    ?>
    <script>
    $(document).ready(function() {
        var currentUrl = window.location.href;
        $('.menu .sidebar-link').each(function() {
            if (this.href === currentUrl) {
                $(this).parent('.sidebar-item').addClass('active');
            }
        });
    });
    </script>

</body>

</html>