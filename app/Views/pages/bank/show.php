<?php
use CodeIgniter\I18n\Time;
?>

<?= $this->extend('layouts/layout') ?>
<?= $this->section('title') ?>
<?= $lang == "th" ? $bank->bank_name : $bank->bank_nameEN ?>
<?= $this->endSection() ?>
<?= $this->section('nav-title') ?>
<?= $lang == "th" ? $bank->bank_name : $bank->bank_nameEN ?>
<?= $this->endSection() ?>
<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/pages/css/b-show.css") ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> <?= lang('global.page.title') ?> / </span>
    <?= $lang == "th" ? $bank->bank_name : $bank->bank_nameEN ?> ( <?= $bank->blit_number; ?> ) </h4>

<div class="row">
    <div class="col-12 order-3 order-md-2">
        <div class="row">

            <div class=" col-12 col-sm-6 col-md-4 mb-4  ">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title">
                                    <h5 class="text-nowrap mb-2"><?= lang('global.page.bank.text.money-sum') ?>
                                    </h5>
                                </div>
                                <div class="mt-sm-auto">

                                    <h3 class="mb-0 text-primary">
                                        <?= currency($bank->blit_remain) ?> <?= lang('global.page.g.text.text-baht') ?>
                                    </h3>
                                </div>
                            </div>
                            <div id="profileReportChart"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<div class="row mb-4">

    <div class="col-12">
        <div class="card">
            <h5 class="card-header"><?= lang('global.page.bank.show.text.header-info'); ?></h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <img src="<?= base_url("image?img=") . $bank->blit_image; ?>" width="100%">
                    </div>
                    <div class="col-8">
                        <div class="d-flex mb-3">
                            <div class="flex-grow-1 row">
                                <div class="col-12 mb-sm-0 mb-2">
                                    <small class="text-muted"><?= lang('global.page.bank.text.label-bank'); ?></small>
                                    <h4 class="mb-0"><?= $lang == "th" ? $bank->bank_name : $bank->bank_nameEN ?></h4>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="flex-grow-1 row">
                                <div class="col-12 mb-sm-0 mb-2">
                                    <small
                                        class="text-muted"><?= lang('global.page.bank.text.label-blit_name'); ?></small>
                                    <h4 class="mb-0"><?= $bank->blit_name ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <!-- <div class="flex-shrink-0">
                                <img src="../assets/img/icons/brands/google.png" alt="google" class="me-3" height="30" />
                            </div> -->
                            <div class="flex-grow-1 row">
                                <div class="col-12 mb-sm-0 mb-2">
                                    <small
                                        class="text-muted"><?= lang('global.page.bank.text.label-blit_number'); ?></small>
                                    <h4 class="mb-0"><?= $bank->blit_number ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <!-- <div class="flex-shrink-0">
                                <img src="../assets/img/icons/brands/google.png" alt="google" class="me-3" height="30" />
                            </div> -->
                            <div class="flex-grow-1 row">
                                <div class="col-12 mb-sm-0 mb-2">
                                    <button type="button" onclick="BankDelete('<?= $bank->blit_id; ?>')"
                                        class="btn btn-sm btn-warning"><?= lang("global.page.bank.show.btn.delete") ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /Connections -->
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">

        <?php //var_dump($bank) 
        ?>

        <div class="row mt-3">
            <div class="col-12 d-flex justify-content-between">
                <button type="button" class="btn btn-md btn-danger " data-bs-toggle="modal"
                    data-bs-target="#withDrawShowModal"><?= lang("global.page.bank.show.btn.withdraw") ?></button>
                <button type="button" class="btn btn-md btn-success " data-bs-toggle="modal"
                    data-bs-target="#upMoneyShowModal"><?= lang("global.page.bank.show.btn.up-money") ?></button>
            </div>
        </div>
        <hr class="my-3">
        <h4 class=""><?= lang('global.page.bank.show.text.table-name'); ?></h4>
        <div class="table-responsive text-nowrap">
            <table id="table-bankStatements" class="table w-100">
                <thead>
                    <tr class="text-nowrap">
                        <!-- <th class="text-start"><?= lang('global.text.number-row'); ?></th> -->
                        <th class="text-start"><?= lang('global.text.date'); ?></th>
                        <th class="text-start"><?= lang('global.page.bank.show.text.table.thead.detail'); ?></th>
                        <th class="text-start"><?= lang('global.page.bank.show.text.table.thead.bstate_IN'); ?></th>
                        <th class="text-start"><?= lang('global.page.bank.show.text.table.thead.bstate_out'); ?></th>
                        <th class="text-start"><?= lang('global.page.bank.show.text.table.thead.bstate_remain'); ?></th>
                        <th class="text-start"><?= lang('global.page.bank.show.text.table.thead.bstate_note'); ?></th>
                        <th class="text-start"><?= lang('global.page.bank.show.text.table.thead.ad_name'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($statements as $key => $item): ?>
                        <?php

                        $BlCreated_at = (new Time($item->BlCreated_at))->format("D, d M Y H:i:s");
                        ?>
                        <tr>
                            <!-- <td class="text-start"><?= $key + 1; ?></td> -->
                            <td class="text-start"><?= formatDateDDMMYYYY($item->BlCreated_at); ?></td>
                            <td class="text-start"><?= $lang == "th" ? $item->status_name : $item->status_nameEN; ?></td>
                            <td class="text-start text-success">
                                <?= $item->bstate_IN == "1" ? " + " . currency($item->money_incoming) : ''; ?>
                            </td>
                            <td class="text-start text-danger">
                                <?= $item->bstate_out == "1" ? " - " . currency($item->money_out) : ''; ?>
                            </td>
                            <td class="text-start       "><?= currency($item->bstate_remain); ?></td>
                            <td class="text-start">
                                <?php
                                if (!empty($item->user_id)) {
                                    if ($item->bstate_IN == '1') {
                                        echo lang('global.page.bank.show.text.table.body.bstate_IN', ["name" => $item->displayName]);
                                    } else if ($item->bstate_out == '1') {
                                        echo lang('global.page.bank.show.text.table.body.bstate_out', ["name" => $item->displayName]);
                                    }
                                } else {
                                    if ($item->bstate_IN == '1') {

                                    } else if ($item->bstate_out == '0') {

                                    }
                                }
                                ?>

                            </td>
                            <td class="text-start"><?= " $item->ac_niname "; ?></td>
                        </tr>
                    <?php endforeach ?>

                </tbody>

            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="upMoneyShowModal" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="upMoneyShowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form id="id-FormUpMoney" action="javascript:;" method="post" enctype="multipart/form-data">

                <input type="hidden" name="blit_id" value="<?= $bank->blit_id; ?>">
                <input type="hidden" name="bank_id" value="<?= $bank->bank_id; ?>">
                <input type="hidden" name="bstate_IN" value="1">
                <input type="hidden" name="bstate_out" value="0">
                <input type="hidden" name="form" value="bank">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="upMoneyShowModalLabel">
                        <?= lang("global.page.bank.show.btn.up-money") ?>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <small
                                class="text-light fw-semibold d-block fs-6"><?= lang('global.page.bank.show.text.label-trail'); ?></small>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input fs-5" type="radio" checked name="type" id="id-type-2"
                                    value="member" onchange="onCheangeType(this)" />
                                <label class="form-check-label fs-5"
                                    for="id-type-2"><?= lang('global.page.bank.show.text.label-radio-type-2'); ?></label>
                            </div>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input fs-5" type="radio" name="type" id="id-type-1"
                                    value="other" onchange="onCheangeType(this)" />
                                <label class="form-check-label fs-5"
                                    for="id-type-1"><?= lang('global.page.bank.show.text.label-radio-type-1'); ?></label>
                            </div>
                        </div>
                        <div class="col-12" id="div-user_id">
                            <div class="mt-2">
                                <label class="form-label"
                                    for="id-user_id"><?= lang('global.page.bank.show.text.label-user'); ?></label>
                                <select name="user_id" class="form-select" id="id-user_id" required>
                                    <option selected value=""> ---- <?= lang("global.text.select") ?> ----</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2">
                        <label for="id-money_incoming"
                            class="form-label"><?= lang('global.page.bank.show.text.label-money_incoming'); ?></label>
                        <input type="number" min="1" step="0.01" value="0" class="form-control" id="id-money_incoming"
                            name="money_incoming" required aria-describedby="" />
                    </div>
                    <div class="mt-2">
                        <label for="id-bstate_slip"
                            class="form-label"><?= lang('global.page.bank.show.text.label-bstate_slip'); ?></label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="id-bstate_slip" name="bstate_slip"
                                accept=".png,.jpge,.jpg" />
                        </div>
                    </div>
                    <div class="mt-2">
                        <label for="id-money_incoming" class="form-label"><?= lang('global.text.detail'); ?></label>
                        <textarea name="bstate_note" id="id-bstate_note" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal"><?= lang("global.btn.close") ?></button>
                    <button type="submit" class="btn btn-primary"><?= lang("global.btn.save") ?></button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="withDrawShowModal" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="withDrawShowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form id="id-FormWithDraw" action="javascript:;" method="post" enctype="multipart/form-data">

                <input type="hidden" name="blit_id" value="<?= $bank->blit_id; ?>">
                <input type="hidden" name="bank_id" value="<?= $bank->bank_id; ?>">
                <input type="hidden" name="bstate_IN" value="0">
                <input type="hidden" name="bstate_out" value="1">
                <input type="hidden" name="form" value="bank">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="upMoneyShowModalLabel">
                        <?= lang("global.page.bank.show.btn.withdraw") ?>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <small
                                class="text-light fw-semibold d-block fs-6"><?= lang('global.page.bank.show.text.label-trail'); ?></small>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input fs-5" type="radio" checked name="type"
                                    id="id-type-with-2" value="member" onchange="onCheangeTypeWith(this)" />
                                <label class="form-check-label fs-5"
                                    for="id-type-with-2"><?= lang('global.page.bank.show.text.label-radio-type-2'); ?></label>
                            </div>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input fs-5" type="radio" name="type" id="id-type-with-1"
                                    value="other" onchange="onCheangeTypeWith(this)" />
                                <label class="form-check-label fs-5"
                                    for="id-type-with-1"><?= lang('global.page.bank.show.text.label-radio-type-1'); ?></label>
                            </div>
                        </div>
                        <div class="col-12" id="div-with-user_id">
                            <div class="mt-2">
                                <label class="form-label"
                                    for="id-with-user_id"><?= lang('global.page.bank.show.text.label-user'); ?></label>
                                <select name="user_id" class="form-select" id="id-with-user_id" required>
                                    <option selected value=""> ---- <?= lang("global.text.select") ?> ----</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2">
                        <label for="id-money_out"
                            class="form-label"><?= lang('global.page.bank.show.text.label-money_out'); ?></label>
                        <input type="number" min="1" step="0.01" value="0" class="form-control" id="id-money_out"
                            name="money_out" required aria-describedby="" />
                    </div>
                    <div class="mt-2">
                        <label for="id-bstate_slip"
                            class="form-label"><?= lang('global.page.bank.show.text.label-bstate_slip'); ?></label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="id-bstate_slip" name="bstate_slip"
                                accept=".png,.jpge,.jpg" />
                        </div>
                    </div>
                    <div class="mt-2">
                        <label for="id-money_out" class="form-label"><?= lang('global.text.detail'); ?></label>
                        <textarea name="bstate_note" id="id-bstate_note" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal"><?= lang("global.btn.close") ?></button>
                    <button type="submit" class="btn btn-primary"><?= lang("global.btn.save") ?></button>
                </div>
            </form>

        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('script') ?>
<script src="<?= base_url("assets/pages/js/b-show.js") ?>"></script>
<?= $this->endSection() ?>