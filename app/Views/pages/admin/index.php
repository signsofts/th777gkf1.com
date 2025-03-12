<?= $this->extend('layouts/layout') ?>
<?= $this->section('title') ?>
<?= lang("global.page.admin.title") ?>
<?= $this->endSection() ?>
<?= $this->section('nav-title') ?>
<?= lang("global.page.admin.title") ?>
<?= $this->endSection() ?>


<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/pages/css/admin-index.css?v=") . time() ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> <?= lang('global.page.title') ?> /</span> <?= lang('global.page.admin.title') ?></h4>

<div class="row">
    <div class="col-12 order-3 order-md-2  ">
        <div class="row">
            <div class=" col-12 col-sm-4 col-md-3 mb-4      ">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title">
                                    <h5 class="text-nowrap mb-2"><?= lang('global.page.admin.text.userAll') ?>
                                    </h5>
                                </div>
                                <div class="mt-sm-auto">
                                    <h3 class="mb-0 text-primary">
                                        <?= $adCount ?> <?= lang('global.page.admin.text.person') ?>
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

<div class="card mb-4">

    <div class="card-body">
        <div class="row mt-3">
            <div class="col-12 d-flex justify-content-between">
                <button type="button" class="btn btn-md btn-primary " data-bs-toggle="modal" data-bs-target="#AdminAddShowModal"><?= lang("global.page.admin.btn.showmodal") ?></button>
            </div>
        </div>

        <div class="table-responsive text-nowrap">
            <table id="table-admin" class="table w-100">
                <thead>
                    <tr class="text-nowrap       ">
                        <th width="5px" class="text-start  "><?= lang('global.text.number-row'); ?></th>
                        <th width="20px" class="text-start"><?= lang('global.page.admin.text.table.thead.date'); ?></th>
                        <th width="20px" class="text-start"><?= lang('global.page.admin.text.table.thead.ad_code'); ?></th>
                        <th class="text-start"><?= lang('global.page.admin.text.table.thead.referral'); ?></th>
                        <th class="text-start"><?= lang('global.page.admin.text.table.thead.displayName'); ?></th>
                        <th class="text-start"><?= lang('global.page.admin.text.table.thead.email'); ?></th>
                        <th class="text-start"><?= lang('global.page.admin.text.table.thead.roleName'); ?></th>
                        <th width="10px" class="text-start"><?= lang('global.text.management'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admin as $key => $item) : ?>

                        <?php
                        if (SYS_CODE == $item->ac_code) {
                            continue;
                        }
                        ?>
                        <tr>
                            <td> <?= $key + 1 ?> </td>
                            <td><?= formatDate($item->created_at); ?></td>
                            <td><?= $item->ac_code; ?></td>
                            <td><?= $item->ac_referral ?? "-"; ?></td>
                            <td><?= $item->ac_fname . " " . $item->ac_lname . " ($item->ac_niname)"; ?></td>
                            <td><?= $item->ac_email; ?></td>
                            <td><?= $item->RoleName; ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#AdminEditShowModal-<?= $item->ac_id ?>"> <?= lang('global.btn.edit'); ?> </button>
                                <!-- <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#AdminRolesModal-<?= $item->ac_id ?>"> <?= lang('global.page.admin.text.modalMenu.title'); ?> </button> -->
                            </td>

                        </tr>



                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="AdminAddShowModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="AdminAddShowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form id="id-AdminAdd" action="javascript:;" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="AdminAddShowModalLabel"><?= lang("global.page.admin.modal.title") ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="div-RoleID">
                            <div class="mt-2">
                                <label class="form-label" for="id-RoleID"><?= lang('global.page.admin.text.modal.role'); ?></label>
                                <select name="RoleID" class="form-select" id="id-RoleID" required>
                                    <option selected value=""> ---- <?= lang("global.text.select") ?> ----</option>
                                    <?php foreach ($RoleList as $item) : ?>
                                        <option value="<?= $item->RoleID; ?>"> ---- <?= $item->RoleName ?> ----</option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <label for="id-ac_email" class="form-label"><?= lang('global.page.admin.text.modal.label-ac_email'); ?></label>
                        <input type="email" class="form-control" id="id-ac_email" name="ac_email" required />
                    </div>
                    <div class="mt-2">
                        <label for="id-ac_password" class="form-label"><?= lang('global.page.admin.text.modal.label-ac_password'); ?></label>
                        <input type="password" class="form-control" id="id-ac_password" name="ac_password" required />
                    </div>
                    <div class="mt-2">
                        <label for="id-confirm_password" class="form-label"><?= lang('global.page.admin.text.modal.label-confirm_password'); ?></label>
                        <input type="password" class="form-control" id="id-confirm_password" name="confirm_password" required />
                    </div>
                    <div class="mt-2">
                        <label for="id-ac_fname" class="form-label"><?= lang('global.page.admin.text.modal.label-ac_fname'); ?></label>
                        <input type="text" class="form-control" id="id-ac_fname" name="ac_fname" required />
                    </div>
                    <div class="mt-2">
                        <label for="id-ac_lname" class="form-label"><?= lang('global.page.admin.text.modal.label-ac_lname'); ?></label>
                        <input type="text" class="form-control" id="id-ac_lname" name="ac_lname" required />
                    </div>
                    <div class="mt-2">
                        <label for="id-ac_niname" class="form-label"><?= lang('global.page.admin.text.modal.label-ac_niname'); ?></label>
                        <input type="text" class="form-control" id="id-ac_niname" name="ac_niname" required min="3" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang("global.btn.close") ?></button>
                    <button type="submit" class="btn btn-primary"><?= lang("global.btn.save") ?></button>
                </div>
            </form>

        </div>
    </div>
</div>


<?= $this->endSection() ?>


<?= $this->section('script') ?>
<script src="<?= base_url("assets/pages/js/admin-index.js?v=") . time() ?>"></script>


<?php foreach ($admin as $key => $item) : ?>
    <div class="modal fade" id="AdminEditShowModal-<?= $item->ac_id ?>" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="AdminEditShowModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="id-AdminEdit-<?= $item->ac_id ?>" action="javascript:formSubmitEdit('id-AdminEdit-<?= $item->ac_id ?>','<?= $item->ac_id ?>');" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="AdminEditShowModalLabel"><?= lang("global.page.admin.modal.title") ?></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12" id="div-RoleID">
                                <div class="mt-2">
                                    <label class="form-label" for="id-RoleID-<?= $item->ac_id ?>"><?= lang('global.page.admin.text.modal.role'); ?></label>
                                    <select name="RoleID" class="form-select" id="id-RoleID-<?= $item->ac_id ?>" required>
                                        <option value=""> ---- <?= lang("global.text.select") ?> ----</option>
                                        <?php foreach ($RoleList as $ir) : ?>
                                            <option <?= $ir->RoleID == $item->RoleID ? "selected" : ""; ?> value="<?= $ir->RoleID; ?>"> ---- <?= $ir->RoleName ?> ----</option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <label for="id-ac_email-<?= $item->ac_id ?>" class="form-label"><?= lang('global.page.admin.text.modal.label-ac_email'); ?></label>
                            <input type="email" readonly class="form-control" id="id-ac_email-<?= $item->ac_id ?>" name="ac_email" required value="<?= $item->ac_email ?>" />
                        </div>
                        <div class="mt-2">
                            <label for="id-ac_password-<?= $item->ac_id ?>" class="form-label"><?= lang('global.page.admin.text.modal.label-ac_password'); ?></label>
                            <input type="password" class="form-control" id="id-ac_password-<?= $item->ac_id ?>" name="ac_password" value="*******************" />
                        </div>
                        <div class="mt-2">
                            <label for="id-confirm_password-<?= $item->ac_id ?>" class="form-label"><?= lang('global.page.admin.text.modal.label-confirm_password'); ?></label>
                            <input type="password" class="form-control" id="id-confirm_password-<?= $item->ac_id ?>" name="confirm_password" value="*******************" />
                        </div>
                        <div class="mt-2">
                            <label for="id-ac_fname-<?= $item->ac_id ?>" class="form-label"><?= lang('global.page.admin.text.modal.label-ac_fname'); ?></label>
                            <input type="text" class="form-control" id="id-ac_fname-<?= $item->ac_id ?>" name="ac_fname" required value="<?= $item->ac_fname ?>" />
                        </div>
                        <div class="mt-2">
                            <label for="id-ac_lname-<?= $item->ac_id ?>" class="form-label"><?= lang('global.page.admin.text.modal.label-ac_lname'); ?></label>
                            <input type="text" class="form-control" id="id-ac_lname-<?= $item->ac_id ?>" name="ac_lname" required value="<?= $item->ac_lname ?>" />
                        </div>
                        <div class="mt-2">
                            <label for="id-ac_niname-<?= $item->ac_id ?>" class="form-label"><?= lang('global.page.admin.text.modal.label-ac_niname'); ?></label>
                            <input type="text" class="form-control" id="id-ac_niname-<?= $item->ac_id ?>" name="ac_niname" required value="<?= $item->ac_niname ?>" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang("global.btn.close") ?></button>
                        <button type="button" class="btn btn-danger" onclick="BtnDelete('<?= $item->ac_id ?>')"><?= lang("global.btn.delete") ?></button>
                        <button type="submit" class="btn btn-primary"><?= lang("global.btn.save") ?></button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="AdminRolesModal-<?= $item->ac_id ?>" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="AdminRolesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="id-AdminEditMenu-<?= $item->ac_id ?>" action="javascript:formSubmitEditMenu('id-AdminEditMenu-<?= $item->ac_id ?>','<?= $item->ac_id ?>');" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="AdminRolesModalLabel"><?= lang("global.page.admin.text.modalMenu.title") ?></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <table class="table table-striped table-borderless border-bottom">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Type</th>
                                    <th class="text-nowrap text-center">✉️ Email</th>
                                    <th class="text-nowrap text-center">🖥 Browser</th>
                                    <th class="text-nowrap text-center">👩🏻&zwj;💻 App</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-nowrap">New for you</td>
                                    <td>
                                        <div class="form-check d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck1" checked="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck2" checked="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck3" checked="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap">Account activity</td>
                                    <td>
                                        <div class="form-check d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck4" checked="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck5" checked="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck6" checked="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap">A new browser used to sign in</td>
                                    <td>
                                        <div class="form-check d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck7" checked="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck8" checked="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck9">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap">A new device is linked</td>
                                    <td>
                                        <div class="form-check d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck10" checked="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck11">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck12">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang("global.btn.close") ?></button>
                        <button type="submit" class="btn btn-primary"><?= lang("global.btn.save") ?></button>
                    </div>
                </form>

            </div>
        </div>
    </div>
<?php endforeach ?>


<?= $this->endSection() ?>