<?= $this->extend('layouts/layout') ?>
<?= $this->section('title') ?>
<?= lang('menu.text.report-agent') ?>
<?= $this->endSection() ?>
<?= $this->section('nav-title') ?><?= $this->endSection() ?>
<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/pages/css/report-agent.css?v=") . time() ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> <?= lang('global.page.title') ?> /</span> <span class="text-muted fw-light"> <?= lang('menu.text.report') ?> /</span> <?= lang('menu.text.report-agent') ?></h4>


<div class="row">
    <div class="col-6 order-1 mb-4">
        <div class="card h-100">
            <div class="card-body px-0">
                <div id="chart1"></div>
            </div>
        </div>
    </div>
    <div class="col-6 order-1 mb-4">
        <div class="card h-100">
            <div class="card-body px-0">
                <div id="chart2"></div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('script') ?>
<script src="<?= base_url("assets/pages/js/report-agent.js?v=") . time() ?>"></script>
<?= $this->endSection() ?>