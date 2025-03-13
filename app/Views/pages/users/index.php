<?= $this->extend('layouts/users/layout') ?>
<?= $this->section('title'); ?>
<?= lang('global.page.dashboard.title') ?>
<?= $this->endSection(); ?>
<?= $this->section('nav-title') ?>
<?= lang('global.page.dashboard.title') ?>
<?= $this->endSection() ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/users/css/dashboards.css?v=") . time() ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> <?= lang('global.page.title') ?> /</span>
    <?= lang('global.page.dashboard.title') ?></h4>




<div class="row" style="zoom: 90%;">
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
                                <?= currency($_row->user_remain ?? 0) ?>
                            </h3>
                        </div>
                    </div>
                    <div id="profileReportChart"></div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="nav-align-top mb-4">
    <ul class="nav nav-tabs nav-fill" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-justified-roomAll" aria-controls="navs-justified-roomAll" aria-selected="false">
                <i class="tf-icons bx bx-user"></i> <?= lang('users.T4'); ?>
                <span
                    class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger"><?= count($_rowR ?? []) ?></span>
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile" aria-selected="false">
                <i class="tf-icons bx bx-user"></i> <?= lang('users.T3'); ?>
                <span
                    class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger"><?= count($_row->group ?? []) ?></span>
            </button>
        </li>

    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="navs-justified-roomAll" role="tabpanel">
            <div class="row mt-4">
                <h4 class=""><?= lang('users.T4'); ?></h4>
                <div class="col-12">
                    <div class="table-responsive text-nowrap">
                        <table id="table-userGroups" class="table w-100">
                            <thead>
                                <tr class="text-nowrap">
                                    <th class="text-start"><?= lang('global.text.number-row'); ?></th>
                                    <th class="text-start">
                                        <?= lang('global.page.member.show.text.table.groups.thead.room'); ?>
                                    </th>
                                    <th><?= lang('users.T2'); ?></th>
                                    <th><?= lang('users.T1'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_rowR as $key => $item): ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= $item->groupName; ?></td>
                                        <td><?= $lang == 'th' ? $item->msNameT : $item->msNameE; ?></td>
                                        <td><a href="<?= $item->GRO_InviteLink; ?>" class="btn btn-sm btn-primary">
                                                <?= lang('users.T1'); ?> </a></td>
                                    </tr>
                                <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
            <div class="row mt-4">
                <h4 class=""><?= lang('users.T5'); ?></h4>

                <div class="col-12">
                    <div class="table-responsive text-nowrap">
                        <table id="table-userGroups" class="table w-100">
                            <thead>
                                <tr class="text-nowrap">
                                    <th class="text-start"><?= lang('global.text.number-row'); ?></th>
                                    <th class="text-start">
                                        <?= lang('global.page.member.show.text.table.groups.thead.room'); ?>
                                    </th>
                                    <th><?= lang('users.T2'); ?></th>
                                    <th><?= lang('users.T1'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_row->group as $key => $item): ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= $item->groupName; ?></td>
                                        <td><?= $lang == 'th' ? $item->msNameT : $item->msNameE; ?></td>
                                        <td><a href="<?= $item->GRO_InviteLink; ?>" class="btn btn-sm btn-primary">
                                                <?= lang('users.T1'); ?> </a></td>
                                    </tr>
                                <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel"></div> -->
</div>


<!-- แจ้งเตือน -->

<?php
$check_aller = false;
$aler = array_map(function ($obj) use (&$check_aller) {
    if ($obj['status'] == true) {
        $check_aller = true;
    }
    return $obj;
}, $aler);

?>

<?php if ($check_aller): ?>
    <div class="modal fade fs-4" id="showModaMapLine" data-checkAler="<?= $check_aller; ?>" data-bs-backdrop="static"
        data-bs-keyboard="false" aria-labelledby="showModaMapLineLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-fullscreen-md-down modal-dialog-centered">
            <div class="modal-content">
                <form id="id-map-line" action="javascript:;" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="userId" value="<?= session('userId') ?>">

                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="upMoneyShowModalLabel"><?= lang("login.แจ้งเตือน"); ?></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <?php foreach ($aler as $key => $item): ?>
                            <div class="mt-2">
                                <?php if ($key == 'line' && $item['status'] === true): ?>
                                    <div class="d-flex justify-content-between  ">
                                        <div>
                                            <p><?= lang("login.LINE_MAP"); ?></p>
                                        </div>
                                        <div>
                                            <a href="<?= $item['getLink']; ?>"> <i class="fa-brands fa-line"></i>
                                                <?= lang("login.LINE_MAP_1"); ?> </a>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal"><?= lang("global.btn.close") ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php endif ?>






<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url("assets/users/js/dashboards.js?v=") . time() ?>"></script>
<?= $this->endSection() ?>