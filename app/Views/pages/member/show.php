<?php

use CodeIgniter\I18n\Time;


?>

<?= $this->extend('layouts/layout') ?>
<?= $this->section('title') ?>
<?= $member->displayName ?>
<?= $this->endSection() ?>
<?= $this->section('nav-title') ?><?= $this->endSection() ?>
<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/pages/css/m-show.css") ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> <?= lang('global.page.title') ?> /</span> <span
        class="text-muted fw-light"> <?= lang('global.page.member.title') ?> /</span> <?= $member->displayName ?></h4>

<div class="row  mb-4">
    <div class="col-12 col-sm-12">
        <div class="card">
            <h5 class="card-header"><?= lang('global.page.member.show.text.header-info'); ?></h5>
            <div class="card-body">

                <div class="row">
                    <div class="col-3">
                        <img src="<?= $member->pictureUrl ?>" class=" rounded-3 " width="100%" height="100%">
                    </div>
                    <div class="col-9">
                        <div class="d-flex mb-3">
                            <div class="flex-grow-1 row">
                                <div class="col-12 mb-sm-0 mb-2">
                                    <small
                                        class="text-muted"><?= lang('global.page.member.show.text.displayName'); ?></small>
                                    <h4 class="mb-0"><?= $member->displayName ?></h4>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="flex-grow-1 row">
                                <div class="col-12 mb-sm-0 mb-2">
                                    <small
                                        class="text-muted"><?= lang('global.page.member.show.text.moneyCount'); ?></small>
                                    <h3 class="mb-0"><?= currency($member->user_remain); ?></h3>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="flex-grow-1 row">
                                <div class="col-12 mb-sm-0 mb-2">
                                    <small class="text-muted"><?= lang('global.page.member.show.text.lang'); ?></small>
                                    <h4 class="mb-0"><?= $member->language == 'th' ? "ภาษาไทย" : "English" ?></h4>
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
                                        class="text-muted"><?= lang('global.page.member.show.text.follow'); ?></small>
                                    <h4 class="mb-0"><?= $member->follow == "1" ? "กำลังติดตาม" : "ไม่ได้ติดตาม" ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <!-- <div class="flex-shrink-0">
                                <img src="../assets/img/icons/brands/google.png" alt="google" class="me-3" height="30" />
                            </div> -->
                            <div class="flex-grow-1 row">
                                <div class="col-12 mb-sm-0 mb-2">
                                    <small class="text-muted"><?= lang('global.text.agent'); ?></small>
                                    <?php if (!is_null($member->user_agent)): ?>
                                        <h4 class="mb-0"><?= $member->AGENT_NINAME ?? " - " ?>
                                        </h4>
                                    <?php else: ?>
                                        <br>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#addAgentModal"
                                            class="btn btn-sm btn-primary"><?= lang("global.page.member.show.btn.addAgent") ?></button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" onclick="deleteUser('<?= $member->user_id; ?>')"
                                class="btn btn-md btn-danger"><?= lang("global.btn.delete") ?></button>
                        </div>
                        <hr>
                    </div>
                </div>

                <!-- /Connections -->
            </div>
        </div>
    </div>
</div>


<div class="nav-align-top mb-4">
    <ul class="nav nav-tabs nav-fill" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true">
                <i class="tf-icons bx bx-home"></i>
                <?= lang('global.page.member.show.text.table.statement.text.table-name'); ?>
                <span
                    class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger"><?= count($member->statements ?? []); ?></span>
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile" aria-selected="false">
                <i class="tf-icons bx bx-user"></i> <?= lang('global.page.member.text.groupText'); ?>
                <span
                    class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger"><?= count($member->group ?? []) ?></span>
            </button>
        </li>
        <!-- <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-messages" aria-controls="navs-justified-messages" aria-selected="false">
                <i class="tf-icons bx bx-message-square"></i> Messages
            </button>
        </li> -->
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
            <div class="table-responsive text-nowrap">
                <div class="row mt-3">
                    <div class="col-12 d-flex justify-content-between">
                        <button type="button" class="btn btn-md btn-danger " data-bs-toggle="modal"
                            data-bs-target="#withDrawShowModal"><?= lang("global.page.member.show.btn.withdraw") ?></button>
                        <button type="button" class="btn btn-md btn-success " data-bs-toggle="modal"
                            data-bs-target="#upMoneyShowModal"><?= lang("global.page.member.show.btn.up-money") ?></button>
                    </div>
                </div>
                <hr class="my-3">
                <div class="table-responsive text-nowrap">
                    <table id="table-userStatements" class="table w-100">
                        <thead>
                            <tr class="text-nowrap">
                                <!-- <th class="text-start"><?= lang('global.text.number-row'); ?></th> -->
                                <th class="text-start"><?= lang('global.text.date'); ?></th>
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
                                    <?= lang('global.page.member.show.text.table.statement.thead.statement_remain'); ?>
                                </th>
                                <th class="text-start">
                                    <?= lang('global.page.member.show.text.table.statement.thead.statement_note'); ?>
                                </th>
                                <th class="text-start">
                                    <?= lang('global.page.member.show.text.table.statement.thead.ad_name'); ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($member->statements as $key => $item): ?>
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
                                    <td class="text-start"><?= currency($item->statement_remain); ?></td>
                                    <td class="text-start">
                                        <?php
                                        $nn = $lang == "th" ? (string) " " . $item->blit_name . " " . $item->blit_number . "  " : (string) " " . $item->blit_name . " " . $item->blit_number . " ";
                                        if (SYS_BANK == $item->blit_id) {
                                            echo "";
                                        } else if ($item->statement_IN == '1') {
                                            echo lang('global.page.member.show.text.table.body.statement_IN', ["name" => $nn]);
                                        } else if ($item->statement_OUT == '1') {
                                            echo lang('global.page.member.show.text.table.body.statement_out', ["name" => $nn]);
                                        }
                                        ?>
                                    </td>
                                    <td><?= " $item->ac_niname"; ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
        <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
            <div class="row mt-4">
                <h4 class=""><?= lang('global.page.member.show.text.table.groups.table-name'); ?></h4>

                <div class="col-12">
                    <div class="table-responsive text-nowrap">
                        <table id="table-userGroups" class="table w-100">
                            <thead>
                                <tr class="text-nowrap">
                                    <th class="text-start"><?= lang('global.text.number-row'); ?></th>
                                    <th class="text-start"><?= lang('global.text.date'); ?></th>
                                    <!-- <th class="text-start"><?= lang('global.page.member.show.text.table.groups.thead.roomID'); ?></th> -->
                                    <th class="text-start">
                                        <?= lang('global.page.member.show.text.table.groups.thead.room'); ?>
                                    </th>
                                    <!-- <th class="text-start"><?= lang('global.page.member.show.text.table.groups.thead.countPlay'); ?></th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($member->group as $key => $item): ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= formatDateDDMMYYYY($item->created_at); ?></td>
                                        <!-- <td><?= $item->groupId; ?></td> -->
                                        <td><?= $item->groupName; ?></td>
                                        <!-- <td class="text-start"><?= 0 ?></td> -->
                                    </tr>
                                <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel"></div> -->
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="upMoneyShowModal" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="upMoneyShowModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="id-FormUpMoney" action="javascript:;" method="post" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?= $member->user_id; ?>">
                <input type="hidden" name="statement_IN" value="1">
                <input type="hidden" name="statement_OUT" value="0">
                <input type="hidden" name="status_id" value="3">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="upMoneyShowModalLabel">
                        <?= lang("global.page.member.show.btn.up-money") ?>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="div-blit_id">
                            <div class="mt-2">
                                <label class="form-label"
                                    for="id-blit_id"><?= lang('global.page.member.show.text.modal.bank'); ?></label>
                                <select name="blit_id" class="form-select" id="id-blit_id" required>
                                    <option selected value=""> <?= lang("global.text.select") ?> </option>
                                    <?php foreach ($bankList as $item): ?>
                                        <option value="<?= $item->blit_id; ?>">
                                            <?= $item->bank_name . " " . $item->blit_name . "(" . $item->blit_number . " )" ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2">
                        <label for="id-money_incoming"
                            class="form-label"><?= lang('global.page.member.show.text.modal.label-money_incoming'); ?></label>
                        <input type="number" min="1" step="0.01" value="0" class="form-control" id="id-money_incoming"
                            name="money_incoming" required aria-describedby="" />
                    </div>
                    <div class="mt-2">
                        <label for="id-statement_slip"
                            class="form-label"><?= lang('global.page.member.show.text.modal.label-bstate_slip'); ?></label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="id-statement_slip" name="statement_slip"
                                accept=".png,.jpge,.jpg" />
                        </div>
                    </div>
                    <div class="mt-2">
                        <label for="id-money_incoming" class="form-label"><?= lang('global.text.detail'); ?></label>
                        <textarea name="statement_note" id="id-statement_note" class="form-control" rows="3"></textarea>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="id-FormWithDraw" action="javascript:;" method="post" enctype="multipart/form-data">

                <input type="hidden" name="user_id" value="<?= $member->user_id; ?>">
                <input type="hidden" name="statement_IN" value="0">
                <input type="hidden" name="statement_OUT" value="1">
                <input type="hidden" name="status_id" value="4">


                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="upMoneyShowModalLabel">
                        <?= lang("global.page.member.show.btn.withdraw") ?>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="div-blit_id">
                            <div class="mt-2">
                                <label class="form-label"
                                    for="id-blit_id-FormWithDraw"><?= lang('global.page.member.show.text.modal.bank'); ?></label>
                                <select name="blit_id" class="form-select" id="id-blit_id-FormWithDraw" required>
                                    <option selected value=""> <?= lang("global.text.select") ?> </option>
                                    <?php foreach ($bankList as $item): ?>
                                        <option value="<?= $item->blit_id; ?>">
                                            <?= $lang == "th" ? $item->bank_name . " " . $item->blit_name . "(" . $item->blit_number . " )" : $item->bank_nameEN . " " . $item->blit_name . "(" . $item->blit_number . " )" ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <label for="id-money_out-d"
                            class="form-label"><?= lang('global.page.member.show.text.modal.label-money_out'); ?></label>
                        <input type="number" min="1" step="0.01" value="0" class="form-control" id="id-money_out-d"
                            name="money_out" required aria-describedby="" />
                    </div>
                    <div class="mt-2">
                        <label for="id-statement_slip-d"
                            class="form-label"><?= lang('global.page.member.show.text.modal.label-bstate_slip'); ?></label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="id-statement_slip-d" name="statement_slip"
                                accept=".png,.jpge,.jpg" />
                        </div>
                    </div>
                    <div class="mt-2">
                        <label for="id-money_incoming" class="form-label"><?= lang('global.text.detail'); ?></label>
                        <textarea name="statement_note" id="id-statement_note" class="form-control" rows="3"></textarea>
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

<div class="modal fade" id="addAgentModal" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="addAgentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="id-FormAddAgent" action="javascript:;" method="post">
                <input type="hidden" name="user_id" value="<?= $member->user_id; ?>">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addAgentModalTitle">
                        <?= lang("global.page.member.show.btn.addAgent") ?>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="addAgentModalBody" class="modal-body">
                    <div class="mt-2">
                        <label class="form-label"
                            for="id-user_agent-FormWithDraw"><?= lang('global.text.agent'); ?></label>
                        <select name="user_agent" class="form-select" id="id-user_agent-FormWithDraw" required>
                            <option selected value=""> <?= lang("global.text.select") ?> </option>
                            <?php foreach ($agent as $item): ?>
                                <option value="<?= $item->ac_code; ?>">
                                    <?= $item->ac_fname . " " . $item->ac_lname ?>
                                </option>
                            <?php endforeach ?>

                        </select>
                    </div>
                </div>
                <div id="addAgentModalFooter" class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal"><?= lang("global.btn.close"); ?></button>
                    <button type="submit" class="btn btn-primary"><?= lang("global.btn.save") ?></button>
                </div>
            </form>

        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('script') ?>
<script src="<?= base_url("assets/pages/js/m-show.js") ?>"></script>
<?= $this->endSection() ?>