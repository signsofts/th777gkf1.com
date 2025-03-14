<!DOCTYPE html>
<html lang="<?= $_SESSION["lang"] ?? "en" ?>" class="dark-style layout-menu-fixed" dir="ltr" data-theme="dark"
    data-assets-path="/assets/" data-template="vertical-menu-template" data-bs-theme="dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title id="title"><?= $this->renderSection('title') ?>- <?= getenv("CI_TITLE") ?>
    </title>
    <meta name="description" content="" />
    <meta id="base_url" data-url="<?= base_url() ?>" />
    <link rel="icon" type="image/x-icon" href="/icons/icon-180x180.png" />

    <link rel="manifest" href="<?= base_url('manifest.json'); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="/icons/icon-180x180.png">
    <meta name="theme-color" content="#212529">



    <?= $this->include("layouts/styles") ?>

    <?= $this->renderSection('style') ?>


</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar ">
        <div class="layout-container">
            <!-- Layout container -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <?= $this->include("layouts/users/layout-menu") ?>
            </aside>
            <div class="layout-page">
                <!-- Navbar -->
                <?= $this->include("layouts/users/navbar") ?>
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <div>
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

                        <?= $this->renderSection('content') ?>
                    </div>
                    <!-- / Content -->
                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <?= $this->include("layouts/users/footer") ?>
                    </footer>
                    <!-- / Footer -->
                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <div class="modal fade" id="modalMain" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalMainLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalMainTitle"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="modalMainBody" class="modal-body">

                </div>
                <div id="modalMainFooter" class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal"><?= lang("global.btn.close"); ?></button>
                </div>
            </div>
        </div>
    </div>


    <div class="bs-toast toast toast-placement-ex m-2" role="alert" aria-live="assertive" aria-atomic="true"
        data-delay="2000">
        <div class="toast-header">
            <i class="bx bx-bell me-2"></i>
            <div class="me-auto fw-semibold" id="toast-title"></div>
            <small></small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div id="toast-body" class="toast-body"></div>
    </div>

    <?= $this->include("layouts/scripts") ?>
    <?= $this->renderSection('script') ?>
</body>

</html>