<?= $this->extend('layouts/layout') ?>
<?= $this->section('title'); ?>
<?= lang('global.page.dashboard.title') ?>
<?= $this->endSection(); ?>
<?= $this->section('nav-title') ?>
<?= lang('global.page.dashboard.title') ?>
<?= $this->endSection() ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/pages/css/b-approve.css") ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> <?= lang('global.page.title') ?> /</span>
    <?= lang('users.TM3') ?></h4>

<div class="nav-align-top mb-4">
    <ul class="nav nav-tabs nav-fill" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active  " role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-justified-withdraw" aria-controls="navs-justified-withdraw" aria-selected="false">
                <i class="tf-icons bx bx-user"></i> <?= lang('users.T7'); ?>
                <span
                    class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger"><?= count($statements ?? []) ?></span>
            </button>
        </li>
    </ul>

    <div class="tab-content">

        <div class="tab-pane fade active show" id="navs-justified-withdraw" role="tabpanel">
            <h4 class=""><?= lang('users.T7'); ?></h4>

            <div class="table-responsive text-nowrap">
                <table id="table-list" class="table w-100">
                    <thead>
                        <tr class="text-nowrap">
                            <th class="text-start">#</th>
                            <th class="text-start"><?= lang('global.text.date'); ?></th>
                            <th class="text-start"><?= lang('global.T2'); ?></th>
                            <th class="text-start">
                                <?= lang('global.page.member.show.text.table.statement.thead.detail'); ?></th>
                            <th class="text-start"><?= lang('users.T8'); ?></th>
                            <th class="text-start"><?= lang('users.T18'); ?> - <?= lang('users.T19'); ?></th>
                            <th class="text-start"><?= lang('global.T3'); ?></th>
                            <th class="text-start"><?= lang('users.T9'); ?></th>
                            <th class="text-start"><?= lang('global.T1'); ?></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
            </div>
        </div>


    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url("assets/pages/js/b-approve.js") ?>"></script>
<?= $this->endSection() ?>