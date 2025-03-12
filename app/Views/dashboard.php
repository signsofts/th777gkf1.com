<?= $this->extend('layouts/layout') ?>
<?= $this->section('title'); ?>
<?= lang('global.page.dashboard.title') ?>
<?= $this->endSection(); ?>
<?= $this->section('nav-title') ?>
<?= lang('global.page.dashboard.title') ?>
<?= $this->endSection() ?>


<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/pages/css/dashboards.css?v=") . time() ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> <?= lang('global.page.title') ?> /</span> <?= lang('global.page.dashboard.title') ?></h4>
<?php if ($_SESSION["user"]->RoleID == '4' || $_SESSION["user"]->RoleID == '1' || $_SESSION["user"]->RoleID == '2') : ?>
    <input type="hidden" id="loadChartDashboardData" value='<?= json_encode($ChartData); ?>'>
    <div class="row" style="zoom: 90%;">
        <div class=" col-12 col-sm-4 col-md-3 mb-4  ">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                        <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                            <div class="card-title">
                                <h5 class="text-nowrap mb-2"><?= lang('global.page.dashboard.text.bankNumber') ?>
                                </h5>
                            </div>
                            <div class="mt-sm-auto">
                                <h3 class="mb-0 text-primary">
                                    <?= $bankCount ?? 0 ?> <?= lang('global.page.dashboard.text.bank') ?>
                                </h3>
                            </div>
                        </div>
                        <div id="profileReportChart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-12 col-sm-4 col-md-3 mb-4  ">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                        <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                            <div class="card-title">
                                <h5 class="text-nowrap mb-2"><?= lang('global.page.dashboard.text.TotalBalance') ?>
                                </h5>
                            </div>
                            <div class="mt-sm-auto">
                                <h3 class="mb-0 text-primary">
                                    <?= currency($blit_remain ?? 0) ?>
                                </h3>
                            </div>
                        </div>
                        <div id="profileReportChart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-12 col-sm-4 col-md-3 mb-4  ">
            <div class="card">
                <div class="card-body  ">
                    <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                        <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                            <div class="card-title">
                                <h5 class="text-nowrap mb-2"><?= lang('global.page.dashboard.text.remaining') ?>
                                </h5>
                            </div>
                            <div class="mt-sm-auto">
                                <h3 class="mb-0 text-primary">
                                    <?= currency($remainingCount ?? 0)  ?> <?= '' //lang('global.text.currency') 
                                                                            ?>
                                </h3>
                            </div>
                        </div>
                        <div id="profileReportChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class=" col-12 col-sm-4 col-md-3 mb-4  ">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                        <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                            <div class="card-title">
                                <h5 class="text-nowrap mb-2"><?= lang('global.page.member.text.userAll') ?>
                                </h5>
                            </div>
                            <div class="mt-sm-auto">
                                <h3 class="mb-0 text-primary">
                                    <?= $memberCount ?? 0 ?> <?= lang('global.page.member.text.person') ?>
                                </h3>
                            </div>
                        </div>
                        <div id="profileReportChart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-12 col-sm-4 col-md-3 mb-4  ">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                        <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                            <div class="card-title">
                                <h5 class="text-nowrap mb-2"><?= lang('global.page.dashboard.text.groupNumber') ?>
                                </h5>
                            </div>
                            <div class="mt-sm-auto">
                                <h3 class="mb-0 text-primary">
                                    <?= $groupCount ?? 0 ?> <?= lang('global.page.dashboard.text.groupRoom') ?>
                                </h3>
                            </div>
                        </div>
                        <div id="profileReportChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12 order-1 mb-4">
            <div class="card h-100">
                <div class="card-body px-0">
                    <div id="incomeChart"></div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>
<?= $this->endSection() ?>


<?= $this->section('script') ?>
<script src="<?= base_url("assets/pages/js/dashboards.js?v=") . time() ?>"></script>
<?= $this->endSection() ?>