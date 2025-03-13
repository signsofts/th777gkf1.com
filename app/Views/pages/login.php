<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="assets/"
    data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title><?= lang('login.Title') ?> - <?= getenv("CI_TITLE") ?></title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="/icons/icon-180x180.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('') ?>assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="<?= base_url('') ?>assets/vendor/css/core.css"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url('') ?>assets/vendor/css/theme-dark.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= base_url('') ?>assets/css/demo.css" />
    <link rel="stylesheet" href="<?= base_url('') ?>assets/vendor/libs/select2/select2.min.css" />
    <link rel="stylesheet" href="<?= base_url('') ?>assets/vendor/libs/sweetalert2/sweetalert2.min.css" />
    <link rel="stylesheet" href="<?= base_url('') ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?= base_url('') ?>assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="<?= base_url('') ?>assets/vendor/js/helpers.js"></script>
    <script src="<?= base_url('') ?>assets/js/config.js"></script>
</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-center mb-0">
                            <img src="/icons/icon-n-b.png" width="60%" alt="" srcset="">
                        </div>
                        <div class="app-brand justify-content-center">
                            <span class="app-brand-text demo text-body fw-bolder"
                                style="text-transform: capitalize;"><?= getenv("CI_TITLE") ?></span>
                        </div>
                        <h4 class="mb-2"><?= lang('login.Welcome') ?> <?= getenv("CI_TITLE") ?> 👋</h4>
                        <p class="mb-4"><?= lang("login.BodyText") ?></p>
                        <ul class="navbar-nav flex-row  justify-content-between">
                            <!-- Place this tag where you want the button to render. -->
                            <li class="nav-item lh-1 me-3">
                                <a class="dropdown-item <?= $lang == "en" ? 'active' : "" ?>"
                                    href="<?= site_url('lang/en'); ?>"> <img class="w-px-40 h-auto rounded-circle"
                                        src="<?= base_url('') ?>assets/img/icons/lang/english.png"> </a>
                            </li>
                            <li class="nav-item lh-1 me-3">
                                <a class="dropdown-item <?= $lang == "th" ? 'active' : "" ?>"
                                    href="<?= site_url('lang/th'); ?>"> <img class="w-px-40 h-auto rounded-circle"
                                        src="<?= base_url('') ?>assets/img/icons/lang/thailand.png"> </a>
                            </li>

                        </ul>
                        <form id="formAuthentication" class="mb-3" action="javascript:;" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label"><?= lang("login.labelEmail") ?></label>
                                <input type="text" class="form-control" id="email" name="email" value=""
                                    placeholder="<?= lang("login.placehEmail") ?>" autofocus />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label"
                                        for="password"><?= lang("login.labelPassword") ?></label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password" value=""
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100"
                                    type="submit"><?= lang("login.btnSubmit") ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('') ?>assets/vendor/libs/jscookie/js.cookie.min.js"></script>
    <script src="<?= base_url('') ?>assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?= base_url('') ?>assets/vendor/libs/popper/popper.js"></script>
    <script src="<?= base_url('') ?>assets/vendor/js/bootstrap.js"></script>
    <script src="<?= base_url('') ?>assets/vendor/libs/select2/select2.min.js"></script>
    <script src="<?= base_url('') ?>assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="<?= base_url('') ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?= base_url('') ?>assets/vendor/js/menu.js"></script>
    <script src="<?= base_url('') ?>assets/js/main.js"></script>
    <script src="<?= base_url('') ?>assets/js/login.js?v=<?= time() ?>"></script>

</body>

</html>