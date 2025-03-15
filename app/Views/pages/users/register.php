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

    <div class="center-login">
        <div class="width-register">
            <div class="margin-img"><img src="<?= base_url('assets/icons/icon-n-b.png'); ?>" alt="login logo" width="100%"
                    height="auto"></div>
            <div class="card">
                <div class="container d-flex justify-content-end">
                    <div class="btn-group position_front_zindex">
                        <div class="dropdown" style="align-self: center;">

                            <?php if ($lang == "th"): ?>
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    class="nav-link lang_select">
                                    <img src="/assets/ucoppy/th.png" class="lang_flag_regis"><span
                                        class="lang_text_regis">TH</span> <span class="icon-caret caret_icon"></span>
                                </a>
                            <?php elseif ($lang == "en"): ?>
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    class="nav-link lang_select">
                                    <img src="/assets/ucoppy/en.png" class="lang_flag_regis"><span
                                        class="lang_text_regis">EN</span> <span class="icon-caret caret_icon"></span>
                                </a>
                            <?php endif ?>
                            <ul
                                class="dropdown-menu dropdown-menu-right lang_dropdown animate slideIn position_lang_regis">
                                <li class="thai lang_active">
                                    <a href="<?= base_url('lang/th'); ?>">
                                        <img src="/assets/ucoppy/th.png" class="lang_flag_regis"><span
                                            class="lang_text_regis">TH</span>
                                    </a>
                                </li>
                                <li class="eng ">
                                    <a href="<?= base_url('lang/en'); ?>">
                                        <img src="/assets/ucoppy/en.png" class="lang_flag_regis"><span
                                            class="lang_text_regis">EN</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="reigis_cus">

                        <div class="card-body login-card-body">

                            <p class="font-title-login">
                                <span class="title_font_color_register"><?= lang("login.กรอกข้อมูล") ?></span>
                            </p>

                            <div class="row">
                                <div class="col-12">
                                    <?php if (session()->has('success')): ?>
                                        <div class="alert alert-success" role="alert">
                                            <?= session('success') ?>
                                        </div>
                                    <?php endif ?>
                                    <?php if (session()->has('error')): ?>
                                        <?php if (gettype(session('error')) == 'string'): ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?= session('error') ?>
                                            </div>
                                        <?php elseif (gettype(session('error')) == 'array'): ?>
                                            <?php foreach (session('error') as $mess): ?>
                                                <div class="alert alert-danger" role="alert">
                                                    <?= $mess ?>
                                                </div>
                                            <?php endforeach ?>
                                        <?php endif ?>

                                    <?php endif ?>
                                </div>
                            </div>

                            <?php echo form_open(base_url("customer/register"), ['csrf_id' => '_token']); ?>

                            <div class="form-group text-left">
                                <label for="fname" class="font_color_register"><?= lang("login.ชื่อจริง") ?> :</label>
                                <input required type="text" name="fname" placeholder="<?= lang("login.ชื่อจริง") ?>"
                                    class="form-control register_input">
                            </div>

                            <div class="form-group text-left">
                                <label for="lname" class="font_color_register"><?= lang("login.นามสกุล") ?>:</label>
                                <input required type="text" name="lname" placeholder="<?= lang("login.นามสกุล") ?>"
                                    class="form-control register_input">
                            </div>


                            <div class="form-group text-left">
                                <label for="tel_phone"
                                    class="font_color_register"><?= lang("login.เบอร์โทรศัพท์มือถือ") ?> :</label>
                                <input required type="text" name="tel_phone"
                                    placeholder="<?= lang("login.เบอร์โทรศัพท์มือถือ") ?>" autocomplete="off"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,&#39;&#39;);"
                                    class="form-control register_input">
                            </div>


                            <div class="form-group text-left">
                                <label for="email" class="font_color_register"><?= lang("login.labelEmail") ?>
                                    :</label>
                                <input required type="email" name="email" placeholder="<?= lang("login.labelEmail") ?>"
                                    autocomplete="off" class="form-control register_input">
                            </div>


                            <div class="form-group text-left">
                                <label for="password"
                                    class="font_color_register"><?= lang("login.labelPassword") ?>:</label>
                                <input required type="password" name="password"
                                    placeholder="<?= lang("login.labelPassword") ?>"
                                    class="form-control register_input">
                            </div>



                            <div class="form-group text-left">
                                <label for="line" class="font_color_register"><?= lang("login.LINEID") ?>:</label>
                                <input required type="text" name="line" placeholder="<?= lang("login.LINEID") ?>"
                                    class="form-control register_input">
                            </div>
                            <div class="form-group text-left">
                                <label for="bank" class="font_color_register"><?= lang("login.ธนาคาร") ?> :</label>
                                <select required name="bank" class="form-control form-select register_input">
                                    <option value=""> <?= lang("login.เลือกธนาคาร") ?> </option>
                                    <?php foreach ($banks as $item): ?>
                                        <option value="<?= $lang == "th" ? $item->bank_name : $item->bank_nameEN; ?>">
                                            <?= $lang == "th" ? $item->bank_name : $item->bank_nameEN; ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div> <!---->
                            <div class="form-group text-left">
                                <label for="bank_number" class="font_color_register"><?= lang("login.เลขบัญชี") ?>
                                    :</label>
                                <input required type="number" name="bank_number"
                                    placeholder="<?= lang("login.เลขบัญชี") ?>"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,&#39;&#39;);"
                                    class="form-control register_input">
                            </div>
                            <div id="divrecom" class="form-group text-left mb-0">
                                <label class="font_color_register"><?= lang("login.รหัสผู้แนะนำ") ?> :</label>
                                <input type="text" name="agent" placeholder="<?= lang("login.รหัสผู้แนะนำ") ?>"
                                    class="form-control register_input">
                            </div> <!---->
                            <div class="form-group text-left pt-0">
                                <div class="">

                                </div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-12">
                                    <button type="submit" class="btn w-100 confirm_btn_regis_login btn_register_submit">
                                        <?= lang("login.ยืนยันการสมัคร") ?>
                                    </button>
                                </div>
                            </div>
                            <?= form_close(); ?>
                            <div class="container_btn_register"><!----> <!---->
                                <div class="btn_regi_outlined"><a href="<?= base_url('users/signin'); ?>">
                                        <?= lang("login.btnSubmit") ?>
                                    </a></div> <span>|</span>
                                <div class="btn_regi_scale_transition"><a onclick="goTOLinkLine(this)"
                                        name="https://line.me/ti/p/<?= getenv('LINE_CHANNEL_BASIC_ID'); ?>"><i
                                            class="fab fa-line line-contract"></i>
                                        <span><u><?= lang("login.cont") ?></u></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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