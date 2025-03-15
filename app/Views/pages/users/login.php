<!DOCTYPE html>
<html lang="th" style="height: auto;">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- Share Link -->
    <meta property="og:image" content="<?= base_url('assets/icons/icon-b.png'); ?>">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="BS8SttmJcndH1OlcZq2GKZ63EkBqTRKIk5cLD5sE">
    <meta name="imageURI" content="<?= base_url('assets/icons/icon-b.png'); ?>">
    <meta name="band" content="limbo">
    <meta name="regi_button" content="<?= lang("login.tfooter") ?>">
    <meta name="login_theme" content="login_theme_v1">
    <meta name="login_theme_v" content="">
    <meta property="og:description" content="Copyright 2021 ©  เว็บพนันออนไลน์ อันดับ 1 All Rights Reserved.">
    <meta name="app_name" content="">
    <meta name="lang" content="">
    <meta name="bt" content="$2y$10$cEsaSj0QnTDXQEO4xOinlu9UoEpZjI1wrCyyFkbGBVE6bVBtHhhEK">
    <link rel="icon" href="<?= base_url('assets/icons/icon-b.png'); ?>" type="image/x-icon">
    <title><?= getenv("CI_TITLE") ?>
    </title>
    <meta name="description" content="<?= lang("login.description") ?>">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta name="bingbot" content="index, follow">

    <link rel="stylesheet" href="<?= base_url('assets/ucoppy/app.css'); ?>">
    <link rel="stylesheet" href="<?= site_url('assets/vendor/fontawesome/css/all.min.css') ?>" />

    <link rel="manifest" href="<?= base_url('manifest.json'); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/icons/icon-180x180.png">
    <meta name="theme-color" content="#212529">

</head>


<body style="background: radial-gradient(circle, rgb(39, 39, 39) 0px, rgb(6, 6, 6) 70%); height: auto;">
    <main>
        <div class="fix-lang">
            <div class="btn-group">
                <div class="dropdown" style="align-self: center;">
                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link lang_select">
                        <?php if ($lang == "th"): ?>
                            <img src="<?= base_url('assets/ucoppy/th.png'); ?>" class="lang_flag"><span
                                class="lang_text">TH</span>
                            <span class="icon-caret caret_icon"></span>
                        <?php elseif ($lang == "en"): ?>
                            <img src="<?= base_url('assets/ucoppy/en.png'); ?>" class="lang_flag"><span
                                class="lang_text">EN</span>
                            <span class="icon-caret caret_icon"></span>
                        <?php endif ?>

                    </a>
                    <ul class="dropdown-menu dropdown-menu-right lang_dropdown animate slideIn position_dp_lang">
                        <li class="thai ">
                            <a href="<?= site_url('lang/th'); ?>">
                                <img src="<?= base_url('assets/ucoppy/th.png'); ?>" class="lang_flag">
                                <span class="lang_text">TH</span>
                            </a>
                        </li>
                        <li class="eng lang_active">
                            <a href="<?= site_url('lang/en'); ?>">
                                <img src="<?= base_url('assets/ucoppy/en.png'); ?>" class="lang_flag">
                                <span class="lang_text">EN</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div>
            <div class="center-login">
                <div class="width-login">
                    <div class="margin-img">
                        <img src="<?= base_url('assets/icons/icon-n-b.png'); ?>" alt="login logo" width="100%" height="auto">
                    </div>
                    <div class="card">
                        <div class="card-body ">

                            <?php echo form_open(base_url("users/signin"), ['csrf_id' => '_token']); ?>

                            <div class="row">
                                <div class="col-12">
                                    <?php if (session()->has('success')): ?>
                                        <div class="alert alert-success" role="alert">
                                            <?= session('success') ?>
                                        </div>
                                    <?php endif ?>
                                    <?php if (session()->has('error')): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?= session('error') ?>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-12 pd_two_button">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span id="inputGroupPrepend2" class="input-group-text bg-login-input"><i
                                                    class="fas fa-user"></i></span>
                                        </div>
                                        <input type="tel" onkeypress="handle(event)"
                                            placeholder="<?= lang("login.username") ?>" name="username"
                                            id="login_username" autocomplete="username" autofocus="autofocus"
                                            class="form-control  ">
                                    </div>
                                </div>
                                <div class="col-12 pd_two_button">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend"><span id="inputGroupPrepend2"
                                                class="input-group-text bg-login-input"><i
                                                    class="fas fa-key"></i></span></div> <input type="password"
                                            placeholder="<?= lang("login.labelPassword") ?>" name="password"
                                            id="login_password" autofocus="autofocus" onkeypress="handle(event)"
                                            class="form-control  " style="border-radius: 0px 0.25rem 0.25rem 0px;">
                                        <span class="eyes"><i id="eye" class="fas fa-eye-slash"></i></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group mb-1 d-none">
                                        <div class="form-check"><input type="checkbox" name="remember" id="remember"
                                                class="form-check-input"> <label for="remember"
                                                class="form-check-label font-white">
                                                จดจำฉันไว้
                                            </label></div>
                                    </div>
                                </div>
                                <div class="col-12 pd_two_button mt-2">
                                    <div class="btn_login_theme">
                                        <button type="submit" id="prelogin_btn" class="login_theme_v1">
                                            <?= lang("login.btnSubmit") ?>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <?= form_close(); ?>

                            <div class="container_btn_register">
                                <div class="btn_regi_outlined"><a href="<?= base_url('customer/register'); ?>">
                                        <?= lang("login.regi") ?>
                                    </a></div> <span>|</span>
                                <div class="btn_regi_scale_transition"><a onclick="goTOLinkLine(this)"
                                        name="https://line.me/ti/p/<?= getenv('LINE_CHANNEL_BASIC_ID'); ?>"><i
                                            class="fab fa-line line-contract"></i>
                                        <span><u><?= lang("login.cont") ?></u></span></a>
                                </div>
                            </div>
                            <div class="col-12 tx-center mt-4 tx_white">
                                <p>
                                    Copyright <?= date("Y"); ?> © <?= lang("login.tfooter") ?>
                                    All Rights Reserved.
                                </p>
                            </div>
                        </div>
                        <section>
                            <div></div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <audio id="notialert" src="" preload="auto" autoplay="autoplay" style="display: none;"></audio>
    </main>
    <script type="text/javascript" src="<?= base_url('assets/ucoppy/app.js'); ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/ucoppy/jquery.doubleScroll.js'); ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/ucoppy/uni.js'); ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/ucoppy/jquery.coloring-pick.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/ucoppy/jquery.coloring-pick.min.js.css'); ?>">



    <script>


        function goTOLinkLine(val) {
            let operatingSystem = getOperatingSystem();
            if (operatingSystem == 'iOS') {
                window.location.href = val.name
            } else {
                window.open(val.name, '_blank');
            }
        }

        function getOperatingSystem() {
            var userAgent = navigator.userAgent || navigator.vendor || window.opera;
            if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
                return 'iOS';
            }
            if (/android/i.test(userAgent)) {
                return 'Android';
            }
            return 'unknown';
        }

        function handle(e) {
            var key = e.keyCode || e.which;
            if (key == 13) {
                document.getElementById("prelogin_btn").click();
            }
        }

        $(function () {
            $('#eye').click(function () {
                if ($(this).hasClass('fa-eye-slash')) {

                    $(this).removeClass('fa-eye-slash');

                    $(this).addClass('fa-eye');

                    $('#login_password').attr('type', 'text');

                } else {
                    $(this).removeClass('fa-eye');

                    $(this).addClass('fa-eye-slash');

                    $('#login_password').attr('type', 'password');
                }
            });
        });
    </script>
</body>

</html>