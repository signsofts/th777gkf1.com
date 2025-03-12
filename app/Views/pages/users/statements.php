<?= $this->extend('layouts/users/layout') ?>
<?= $this->section('title'); ?>
<?= lang('global.page.dashboard.title') ?>
<?= $this->endSection(); ?>
<?= $this->section('nav-title') ?>
<?= lang('global.page.dashboard.title') ?>
<?= $this->endSection() ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/users/css/statement.css?v=") . time() ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> <?= lang('global.page.title') ?> /</span>
    <?= lang('users.TM3') ?></h4>


<div class="row mt-3 mb-5">
    <div class="col-12 d-flex justify-content-between">
        <button type="button" class="btn btn-md btn-success text-dark " data-bs-toggle="modal"
            data-bs-target="#showModalTM1"><?= lang("users.TM1") ?></button>
        <button type="button" class="btn btn-md btn-danger " data-bs-toggle="modal"
            data-bs-target="#showModalT6"><?= lang("users.T6") ?></button>
    </div>
</div>
<div class="nav-align-top mb-4">
    <ul class="nav nav-tabs nav-fill" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="false">
                <i class="tf-icons bx bx-user"></i> <?= lang('users.TM3'); ?>
                <span
                    class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger"><?= count($statements ?? []) ?></span>
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link  " role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-justified-withdraw" aria-controls="navs-justified-withdraw" aria-selected="false">
                <i class="tf-icons bx bx-user"></i> <?= lang('users.T7'); ?>
                <span
                    class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger"><?= count($payment ?? []) ?></span>
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade  show active " id="navs-justified-home" role="tabpanel">
            <h4 class=""><?= lang('users.TM3'); ?></h4>
            <div class="table-responsive text-nowrap">
                <table id="table-userStatements" class="table w-100">
                    <thead>
                        <tr class="text-nowrap">
                            <th style="width: 100px;" class="text-start"><?= lang('global.text.date'); ?></th>
                            <th class="text-start">
                                <?= lang('global.page.member.show.text.table.statement.thead.detail'); ?>
                            </th>
                            <th class="text-start">
                                <?= lang('global.page.member.show.text.table.statement.thead.statement_IN'); ?>
                            </th>
                            <th class="text-start">
                                <?= lang('global.page.member.show.text.table.statement.thead.statement_OUT'); ?>
                            </th>
                            <th class="text-start">
                                <?= lang('global.page.member.show.text.table.statement.thead.statement_note'); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($statements as $key => $item): ?>
                            <tr>
                                <td class="text-start"><?= formatDateDDMMYYYY($item->mscreated_at); ?></td>
                                <td class="text-start">
                                    <?= $lang == "th" ? $item->status_name : $item->status_nameEN; ?>
                                </td>
                                <td class="text-start text-success">
                                    <?= $item->statement_IN == "1" ? " + " . currency($item->money_incoming) : ''; ?>
                                </td>
                                <td class="text-start text-danger">
                                    <?= $item->statement_OUT == "1" ? " - " . currency($item->money_out) : ''; ?>
                                </td>
                                <td class="text-start">
                                    <?php
                                    $nn = $lang == "th" ? $item->bank_name . " " . $item->blit_name . "(" . $item->blit_number . " )" : $item->bank_nameEN . " " . $item->blit_name . "(" . $item->blit_number . " )";
                                    if (SYS_BANK == $item->blit_id) {
                                        echo "";
                                    } else if ($item->statement_IN == '1') {
                                        echo lang('global.page.member.show.text.table.body.statement_IN', ["name" => $nn]);
                                    } else if ($item->statement_OUT == '1') {
                                        echo lang('global.page.member.show.text.table.body.statement_out', ["name" => $nn]);
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>

                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="navs-justified-withdraw" role="tabpanel">
            <h4 class=""><?= lang('users.T7'); ?></h4>

            <div class="table-responsive text-nowrap">
                <table id="table-withdraw" class="table w-100">
                    <thead>
                        <tr class="text-nowrap">
                            <th style="width: 100px;" class="text-start"><?= lang('global.text.date'); ?></th>
                            <th style="width: 25%;" class="text-start">
                                <?= lang('global.page.member.show.text.table.statement.thead.detail'); ?>
                            </th>
                            <th style="width: 100px;" class="text-start"><?= lang('users.T18'); ?> -
                                <?= lang('users.T19'); ?></th>
                            <th class="text-center ">
                                <?= lang('users.T8'); ?>
                            </th>
                            <th class="text-end">
                                <?= lang('users.T9'); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payment as $key => $item): ?>
                            <tr>
                                <td class="text-start"><?= formatDateDDMMYYYY($item->PAY_created_at); ?></td>
                                <td class="text-start">
                                    <?= $lang == "th" ? $item->status_name : $item->status_nameEN; ?>
                                </td>
                                <td class="text-start">
                                    <?= !is_null($item->PAY_DATE) ? formatDateDDMMYYYY($item->PAY_DATE . " " . $item->PAY_TIME) : "" ?>
                                    <?= $item->PAY_TIME ?? ""; ?></td>

                                <td class="text-center <?= $item->PAY_IN == "1" ? "text-success" : "text-danger"; ?>  ">
                                    <?= $item->PAY_IN == "1" ? " + " . currency($item->PAY_MONEY) : ''; ?>
                                    <?= $item->PAY_OUT == "1" ? " - " . currency($item->PAY_MONEY) : ''; ?>
                                </td>


                                <td class="text-end">
                                    <?php
                                    if (is_null($item->PAY_APPROVE)) {
                                        echo "<span class='text-primary' >" . lang('users.T15') . "</span>";
                                    } else if ($item->PAY_APPROVE == 0) {
                                        echo "<span class='text-danger' >" . lang('users.T16') . "</span>";
                                    } else if ($item->PAY_APPROVE == 1) {
                                        echo "<span class='text-success' >" . lang('users.T17') . "</span>";
                                    }
                                    ?>
                                </td>

                            </tr>
                        <?php endforeach ?>
                    </tbody>

                </table>
            </div>
        </div>


    </div>
</div>

<div class="modal fade" id="showModalTM1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="showModalTM1Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="id-FormUpMoney" action="javascript:;" method="post" enctype="multipart/form-data">
                <input type="hidden" name="statement_IN" value="1">
                <input type="hidden" name="statement_OUT" value="0">
                <input type="hidden" name="status_id" value="3">
                <input type="hidden" name="blit_id" value="<?= $banks->blit_id; ?>">
                <input type="hidden" name="user_id" value="<?= session('user_id') ?>">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="showModalTM1Label">
                        <?= lang("global.page.member.show.btn.up-money") ?>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <img src="<?= base_url("image?img=" . $banks->blit_image); ?>" alt=" "
                                class="w-100 rounded-3 " height="250px">
                        </div>
                        <div class="row mt-5">
                            <div class="col-4">
                                <h4 class="text-end"><?= lang("users.T11"); ?></h4>
                            </div>
                            <div class="col-8">
                                <h4 class="text-start text-primary ">
                                    <?= $lang == "th" ? $banks->bank_name : $banks->bank_nameEN; ?></h4>
                            </div>
                            <div class="col-4">
                                <h4 class="text-end"><?= lang("users.T12"); ?></h4>
                            </div>
                            <div class="col-8">
                                <h4 class="text-start text-primary"><?= $banks->blit_name; ?></h4>
                            </div>
                            <div class="col-4">
                                <h4 class="text-end"><?= lang("users.T13"); ?></h4>
                            </div>
                            <div class="col-8">
                                <h4 class="text-start text-primary"><?= $banks->blit_number; ?></h4>
                            </div>
                        </div>

                    </div>

                    <div class="mt-2">
                        <label for="id-money_incoming"
                            class="form-label"><?= lang('global.page.member.show.text.modal.label-money_incoming'); ?></label>
                        <input type="number" min="1" step="0.01" value="0" class="form-control" id="id-money_incoming"
                            name="money" required aria-describedby="" />
                    </div>
                    <div class="mt-2">
                        <label for="id-PAY_DATE" class="form-label"><?= lang('users.T18'); ?></label>
                        <input type="date" value="<?= date("Y-m-d"); ?>" class="form-control" id="id-PAY_DATE"
                            name="PAY_DATE" required aria-describedby="" />
                    </div>
                    <div class="mt-2">
                        <label for="id-PAY_TIME" class="form-label"><?= lang('users.T19'); ?></label>
                        <input type="time" value="" class="form-control" id="id-PAY_TIME" name="PAY_TIME" required
                            aria-describedby="" />
                    </div>
                    <div class="mt-2">
                        <label for="id-statement_slip" class="form-label"><?= lang('users.T14'); ?></label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="id-statement_slip" name="statement_slip"
                                accept=".png,.jpge,.jpg" required />
                        </div>
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

<div class="modal fade" id="showModalT6" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="showModalT6Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="id-FormWithDraw" action="javascript:;" method="post" enctype="multipart/form-data">

                <input type="hidden" name="statement_IN" value="0">
                <input type="hidden" name="statement_OUT" value="1">
                <input type="hidden" name="status_id" value="4">
                <input type="hidden" name="user_id" value="<?= session('user_id') ?>">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="upMoneyShowModalLabel"><?= lang("users.T6") ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mt-2">
                        <label for="id-money_out-d"
                            class="form-label"><?= lang('global.page.member.show.text.modal.label-money_out'); ?></label>
                        <input type="number" min="1" step="0.01" value="0" class="form-control" id="id-money_out-d"
                            name="money" required aria-describedby="" />
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
<script src="<?= base_url("assets/users/js/statement.js?v=") . time() ?>"></script>
<?= $this->endSection() ?>