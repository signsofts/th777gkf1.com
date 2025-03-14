<?php $session = service('session'); ?>

<?php //dd($_SESSION); ?>


<nav class="layout-navbar container-fluid navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                <span class="fs-3"><?= '' //$this->renderSection('nav-title') 
                    ?>
                    <?= '' // getenv("CI_TITLE") 
                        ?></span>
            </div>
        </div>
        <!-- /Search -->
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Place this tag where you want the button to render. -->
            <li class="nav-item dropdown me-2 me-xl-0 mr-5">
                <a class="nav-link dropdown-toggle hide-arrow" id="nav-theme" href="javascript:void(0);"
                    data-bs-toggle="dropdown" aria-label="Toggle theme (dark)" aria-expanded="false">
                    <img class="w-px-40 h-auto rounded-circle"
                        src="<?= $session->get('lang') == "th" ? '/assets/img/icons/lang/thailand.png' : "/assets/img/icons/lang/english.png" ?>">

                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
                    <li class="nav-item lh-1 me-3">
                        <a class="dropdown-item <?= $session->get('lang') == "en" ? 'active' : "" ?>"
                            href="<?= site_url('lang/en'); ?>"> <img class="w-px-40 h-auto rounded-circle"
                                src="/assets/img/icons/lang/english.png"> English</a>
                    </li>
                    <li class="nav-item lh-1 me-3">
                        <a class="dropdown-item <?= $session->get('lang') == "th" ? 'active' : "" ?>"
                            href="<?= site_url('lang/th'); ?>"> <img class="w-px-40 h-auto rounded-circle"
                                src="/assets/img/icons/lang/thailand.png"> Thailand</a>
                    </li>
                </ul>
            </li>

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="/logo_j.jpg" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="/logo_j.jpg" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block"><?= $_SESSION["user"]->ac_email ?? ""; ?></span>
                                    <small class="text-muted"><?= $_SESSION["user"]->role->RoleName ?? ""; ?></small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bx bx-cog me-2"></i>
                            <span class="align-middle"><?= lang('navbar.btnSettings') ?></span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="/signout/1">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle"><?= lang('navbar.btnLogout') ?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>