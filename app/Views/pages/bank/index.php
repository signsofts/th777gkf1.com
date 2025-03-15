<?= $this->extend('layouts/layout') ?>
<?= $this->section('title') ?>
<?= lang("global.page.bank.title") ?>
<?= $this->endSection() ?>
<?= $this->section('nav-title') ?>
<?= lang("global.page.bank.title") ?>
<?= $this->endSection() ?>


<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/pages/css/b-index.css") ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> <?= lang('global.page.title') ?> /</span>
    <?= lang('global.page.bank.title') ?></h4>
<div class="row">
    <div class="col-12 order-3 order-md-2">
        <div class="row">

            <div class=" col-12 col-sm-3 col-md-3 mb-4  ">
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
                                        <?= currency($remain ?? 0) ?> <?= lang('global.page.g.text.text-baht') ?>
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
        <h4 class=""><?= lang('global.page.bank.text.table-name'); ?></h4>

        <div class="row">
            <div class="col-12 d-flex justify-content-between">
                <div></div>
                <button type="button" class="btn btn-md btn-primary " data-bs-toggle="modal"
                    data-bs-target="#addShowModal"><?= lang("global.btn.add") ?></button>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table id="table-banklist" class="table w-100">
                <thead>
                    <tr class="text-nowrap">
                        <th class="text-start"><?= lang('global.text.number-row'); ?></th>
                        <th class="text-start"><?= lang('global.page.bank.text.table.thead.bank-name'); ?></th>
                        <th class="text-start"><?= lang('global.page.bank.text.table.thead.bank-account-name'); ?></th>
                        <th class="text-start"><?= lang('global.page.bank.text.table.thead.bank-number'); ?></th>
                        <th class="text-start">
                            <?= lang('global.page.bank.text.table.thead.money-totle'); ?>(<?= lang("global.text.currency"); ?>)
                        </th>
                        <th class="text-start"><?= lang('global.text.management'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($banklist as $key => $item): ?>
                        <?php
                        if (SYS_BANK == $item->blit_id) {
                            continue;
                        }
                        ?>
                        <!-- <option value="<?= $item->bank_id ?>"> ---- <?= $item->bank_name ?> ----</option> -->
                        <tr>
                            <td class="text-start"><?= $key + 1; ?></td>
                            <td class="text-start"><?= $item->bank_name ?></td>
                            <td class="text-start"><?= $item->blit_name ?></td>
                            <td class="text-start"><?= $item->blit_number ?></td>
                            <td class="text-start"><?= currency($item->blit_remain ?? 0) ?>
                                <?= lang("global.text.currency"); ?>
                            </td>
                            <td class="text-start"><a class="btn btn-sm btn-outline-primary "
                                    href="<?= base_url('admin/b/v/') . $item->blit_id; ?>"><?= lang("global.text.detail"); ?></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addShowModal" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="addShowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form id="id-formAddBankList" action="<?= base_url("admin/b/create") ?>" method="post"
                enctype="multipart/form-data">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addShowModalLabel"><?= lang("global.btn.add") ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2">
                        <label class="form-label"
                            for="id-bank_id"><?= lang('global.page.bank.text.label-bank'); ?></label>
                        <select name="bank_id" class="form-select" id="id-bank_id" required>
                            <option selected value=""> ---- <?= lang("global.text.select") ?> ----</option>
                            <?php foreach ($Bank as $key => $item): ?>
                                <option value="<?= $item->bank_id ?>"> ----
                                    <?= $lang == "th" ? $item->bank_name : $item->bank_nameEN ?> ----
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="mt-2">
                        <label for="id-blit_name"
                            class="form-label"><?= lang('global.page.bank.text.label-blit_name'); ?></label>
                        <input type="text" class="form-control" id="id-blit_name" name="blit_name" required
                            aria-describedby="defaultFormControlHelp" />
                    </div>
                    <div class="mt-2">
                        <label for="id-blit_number"
                            class="form-label"><?= lang('global.page.bank.text.label-blit_number'); ?></label>
                        <input type="text" class="form-control" id="id-blit_number" name="blit_number" required
                            aria-describedby="defaultFormControlHelp" />
                    </div>
                    <div class="mt-2">
                        <label for="id-blit_image"
                            class="form-label"><?= lang('global.page.bank.text.label-blit_image'); ?></label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="id-blit_image" name="blit_image" required
                                accept=".png,.jpge,.jpg" />
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

<?= $this->endSection() ?>


<?= $this->section('script') ?>
<script src="<?= base_url("assets/pages/js/b-index.js") ?>"></script>
<?= $this->endSection() ?>