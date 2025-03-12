<?php

// $uri = current_url(true);

// dd(uri_string());
$uriStr = explode("/", uri_string());
$segments1 = isset($uriStr[0]) ? $uriStr[0] : "";
$segments2 = isset($uriStr[1]) ? $uriStr[1] : "";
$segments3 = isset($uriStr[2]) ? $uriStr[2] : "";
$segments4 = isset($uriStr[3]) ? $uriStr[3] : "";
$segments5 = isset($uriStr[4]) ? $uriStr[4] : "";

?>
<?= $this->extend('layouts/layout') ?>
<?= $this->section('title') ?>
<?= lang('global.page.opencard.title', ["count" => $dRow->glco_count]) ?>
<?= $this->endSection() ?>
<?= $this->section('nav-title') ?>
<?= lang('global.page.opencard.title', ["count" => $dRow->glco_count]) ?>
<?= $this->endSection() ?>



<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/pages/css/group-card.css?v=") . time() ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<input type="hidden" id="hidden-glco_ID" value="<?= $dRow->glco_ID; ?>" required>


<div class="card mb-4" style="zoom: 80%;">
    <h5 class="card-header"></h5>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between ">
                <div>
                    <?php if (($dRow->glco_count - 1) > 0): ?>
                        <a href="<?php echo "/$segments1/$segments2/$segments3/$segments4/$segments5/" . $dRow->previous ?>"
                            class="btn btn-md btn-dark">
                            << Previous</a>
                            <?php endif; ?>
                </div>
                <div>
                    <?php if (($dRow->glco_count + 1) <= $dRow->openCardSum): ?>
                        <a href="<?= "/$segments1/$segments2/$segments3/$segments4/$segments5/" . $dRow->next ?>"
                            class="btn btn-md btn-dark"> Next >> </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 order-3 order-md-2">
                <div class="row">
                    <div class=" col-12 col-sm-4 col-md-3 mb-4  ">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                    <div
                                        class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                        <div class="card-title">
                                            <h5 class="text-nowrap mb-2">
                                                <?= lang('global.page.live.text.money-sum') ?>
                                            </h5>
                                        </div>
                                        <div class="mt-sm-auto">
                                            <h3 class="mb-0 text-primary">
                                                <div id="moneySum"> <?= currency($mRow->GL_Total_Quantity ?? 0.00); ?>
                                                </div>
                                                <?= '' // lang('global.text.currency') 
                                                    ?>
                                            </h3>
                                        </div>
                                    </div>
                                    <div id="profileReportChart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                    <div
                                        class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                        <div class="card-title">
                                            <h5 class="text-nowrap mb-2">
                                                <?= lang('global.page.opencard.text.money-pay') ?>
                                            </h5>
                                        </div>
                                        <div class="mt-sm-auto">

                                            <h3 class="mb-0 text-primary">
                                                <div id="moneyPay"> <?= currency($mRow->GL_Total_Payment ?? 0.00); ?>
                                                </div>

                                                <?= '' //  lang('global.text.currency') 
                                                    ?>
                                            </h3>
                                        </div>
                                    </div>
                                    <div id="profileReportChart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                    <div
                                        class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                        <div class="card-title">
                                            <h5 class="text-nowrap mb-2  ">
                                                <?= lang('global.page.opencard.text.money-totle') ?>
                                            </h5>
                                        </div>
                                        <div class="mt-sm-auto">

                                            <h3 class="mb-0 text-primary">
                                                <div id="moneyTotle">
                                                    <?= currency($mRow->GL_Remaining_Balance ?? 0.00); ?>
                                                </div>
                                                <?= '' //  lang('global.text.currency') 
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
            </div>


        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-between">
                <div>

                </div>
                <div>

                    <?php ?>
                    <?php if ($dRow->GLCO_STEP == 1): ?>
                        <button type="button" class="btn btn-md btn-primary"
                            onclick="ClickOpen('<?= $dRow->glco_ID; ?>')"><?= lang("global.page.opencard.text.btn.open") ?></button>
                    <?php elseif ($dRow->GLCO_STEP == 2): ?>
                        <button type="button" class="btn btn-md btn-primary"
                            onclick="ClickStop('<?= $dRow->glco_ID; ?>')"><?= lang("global.page.opencard.text.btn.stop") ?></button>
                    <?php elseif ($dRow->GLCO_STEP == 3): ?>
                        <button type="button" class="btn btn-md btn-primary" data-bs-toggle="modal"
                            data-bs-target="#saveCardShowModal"><?= lang("global.page.opencard.text.btn.saveCard") ?></button>
                    <?php elseif ($dRow->GLCO_STEP == 4): ?>
                        <button type="button" class="btn btn-md btn-warning"
                            onclick="closeOpenLive('<?= $dRow->groupLive_ID; ?>')"> <?= lang('global.btn.close'); ?>
                            Live</button>
                    <?php elseif ($dRow->GLCO_STEP == 5): ?>
                        <a href="<?= base_url("admin/g/v/" . $dRow->groupId); ?>" class="btn btn-md btn-info">
                            <?= lang("global.page.opencard.text.btn.toMain") ?> </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <h5 class=""><?= lang('global.page.opencard.text.table.title', ["count" => $dRow->glco_count]); ?></h5>

        <div class="table-responsive">
            <table id="table-card" class="table w-100">
                <thead>
                    <tr class="">
                        <th style="width: 5px;">#</th>
                        <th style="width: 60px;"><?= lang('global.page.g.table.date'); ?></th>
                        <!-- <th><?= lang('global.page.opencard.text.table.thead.th-picture'); ?></th> -->
                        <th><?= lang('global.page.opencard.text.table.thead.th-memter'); ?></th>
                        <th><?= lang('global.page.opencard.text.table.thead.th-grName'); ?></th>
                        <th><?= lang('global.page.opencard.text.table.thead.th-quantity'); ?></th>
                        <!-- <th><?= lang('global.page.opencard.text.table.thead.th-remain'); ?></th> -->
                        <!-- <th><?= lang('global.page.opencard.text.table.thead.th-result'); ?></th> -->
                        <th><?= lang('global.page.opencard.text.table.thead.th-win-los'); ?></th>
                        <th><?= lang('global.page.opencard.text.table.thead.noney_pay'); ?></th>
                        <!-- <th><?= lang('global.page.opencard.text.table.thead.noney_sum'); ?></th> -->
                        <!-- <th><?= lang('global.text.detail'); ?></th> -->
                    </tr>
                </thead>

            </table>
        </div>

    </div>
</div>


<div class="modal fade" id="saveCardShowModal" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="saveCardShowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form id="id-form-add" method="post" action="javascript:;" enctype="multipart/form-data">

                <input type="hidden" name="glco_ID" value="<?= $dRow->glco_ID; ?>">
                <input type="hidden" name="groupLive_ID" value="<?= $dRow->groupLive_ID; ?>">
                <input type="hidden" name="groupId" value="<?= $dRow->groupId; ?>">
                <input type="hidden" name="next" value="<?= $dRow->next; ?>">
                <input type="hidden" name="msID" value="<?= $mRow->msID; ?>">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="saveCardShowModalLabel">
                        <?= lang("global.page.opencard.text.modal.title") ?>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2">
                        <label for="id-openCardSum"
                            class="form-label"><?= lang('global.page.opencard.text.modal.label-win'); ?></label>
                        <select class="form-control" name="grId" id="id-grId" required>
                            <option value=""><?= lang("global.text.select"); ?></option>
                            <?php foreach ($dRow->gamerules as $item): ?>
                                <option value="<?= $item->grId; ?>"><?= $lang == "th" ? $item->grName : $item->grNameEN; ?>
                                </option>
                            <?php endforeach ?>
                        </select>

                        <label for="id-openCardSum" class="form-label <?= $mRow->msID == '3' ? "" : "d-none" ?> ">
                            Multiplication rate </label>
                        <select name="grIdWin" id="id-grId-win"
                            class="form-control <?= $mRow->msID == '3' ? "" : "d-none" ?>" required>
                            <option value="1" selected> 1 multiply </option>
                            <option value="3"> 3 multiply </option>
                            <option value="5"> 5 multiply </option>
                        </select>
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
<script src="<?= base_url("assets/pages/js/group-card.js?v=") . time() ?>"></script>
<?= $this->endSection() ?>