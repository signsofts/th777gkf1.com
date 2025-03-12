<?= $this->extend('layouts/layout') ?>
<?= $this->section('title') ?>
<?= $dRow->groupName ?>
<?= $this->endSection() ?>
<?= $this->section('nav-title') ?>
<?= $dRow->groupName ?>
<?= $this->endSection() ?>


<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/pages/css/group-live.css?v=") . time() ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card mb-4">
    <h5 class="card-header"><?= $dRow->groupName ?> ( Live <?= formatDate($dRow->created_at); ?> ) </h5>
    <div class="card-body">
        <div class="row">
            <div class="col-12 order-3 order-md-2">
                <div class="row">
                    <div class=" col-12 col-sm-4 col-md-3 mb-4  ">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                    <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                         <div class="card-title">
                                            <h5 class="text-nowrap mb-2"><?= lang('global.page.live.text.money-sum') ?>
                                            </h5>
                                        </div>
                                        <div class="mt-sm-auto">

                                            <h3 class="mb-0 text-primary"><?= currency($dRow->moneySum ?? 0)
                                                                            ?>
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
                                    <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                        <div class="card-title">
                                            <h5 class="text-nowrap mb-2"><?= lang('global.page.live.text.money-pay') ?>
                                            </h5>
                                        </div>
                                        <div class="mt-sm-auto">

                                            <h3 class="mb-0 text-primary"><?= currency($dRow->moneyPay ?? 0)
                                                                            ?>
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
                                    <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                        <div class="card-title">
                                            <h5 class="text-nowrap mb-2  "><?= lang('global.page.live.text.money-totle') ?>
                                            </h5>
                                        </div>
                                        <div class="mt-sm-auto">

                                            <h3 class="mb-0 text-primary"><?= currency($dRow->moneyTotle ?? 0)
                                                                            ?>
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
                </div>
            </div>

        </div>
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between">
                <?php if (!$dRow->statusCloseLive) : ?>
                    <button type="button" class="btn btn-md btn-warning" onclick="closeOpenLive('<?= $dRow->groupLive_ID; ?>')"> <?= lang('global.btn.close'); ?> Live</button>
                <?php endif; ?>
                <!-- <button type="button" class="btn btn-lg btn-warning"> <?= lang('global.btn.edit'); ?> </button> -->
                <!-- <button type="button" class="btn btn-lg btn-primary" data-bs-toggle="modal" data-bs-target="#AddShowModal"><?= lang("group.btn-live") ?></button> -->
            </div>
        </div>
        <div class="">
            <h5 class=""><?= lang('global.page.live.text.table.title'); ?></h5>
            <div class="table-responsive text-nowrap">
                <table id="table-live" class="table w-100">
                    <thead>
                        <tr class="text-nowrap">
                            <!-- <th>#</th> -->
                            <th><?= lang('global.page.live.text.table.thead.count-open'); ?></th>
                            <th><?= lang('global.page.live.text.table.thead.count-play'); ?></th>
                            <th><?= lang('global.page.live.text.table.thead.resule-win'); ?></th>
                            <th><?= lang('global.page.live.text.table.thead.resule-los'); ?></th>
                            <th><?= lang('global.page.live.text.table.thead.count-money'); ?></th>
                            <th><?= lang('global.page.live.text.table.thead.noney_pay'); ?></th>
                            <th><?= lang('global.page.live.text.money-totle') ?></th>
                            <th><?= lang('global.page.live.text.table.thead.status'); ?></th>
                            <th><?= lang('global.text.detail'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dRow->cardOpen as $key => $iopen) : ?>
                            <tr>
                                <td><?= $iopen->glco_count; ?></td>
                                <td><?= $iopen->GL_Games_Played; ?></td>
                                <td><?= $iopen->GL_Win_Total; ?></td>
                                <td><?= $iopen->GL_Loss_Total; ?></td>
                                <td><?= currency($iopen->GL_Total_Quantity ?? 0); ?></td>
                                <td><?= currency($iopen->GL_Total_Payment ?? 0); ?></td>
                                <td><?= currency($iopen->GL_Remaining_Balance ?? 0); ?></td>
                                <td class="<?= $iopen->status_class  ?>">
                                    <?= $lang == "th" ?  $iopen->status_name : $iopen->status_nameEN; ?>
                                </td>
                                <td> <a href="<?= base_url("admin/g/ld/" . $dRow->groupId . "/" . $iopen->groupLive_ID . "/" . $iopen->glco_count); ?>" class="btn btn-sm btn-primary"><?= lang('global.text.detail'); ?></a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="AddShowModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="AddShowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form id="id-form-add" method="post" action="javascript:;" enctype="multipart/form-data">
                <input type="hidden" name="groupId" value="<?= $dRow->groupId; ?>">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="AddShowModalLabel"><?= lang("global.page.live.text.modal.title") ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2">
                        <label for="id-openCardSum" class="form-label"><?= lang('global.page.live.text.modal.label-openCardSum'); ?></label>
                        <input type="number" class="form-control" id="id-openCardSum" name="openCardSum" required />
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
<script src="<?= base_url("assets/pages/js/group-live.js?v=") . time() ?>"></script>
<?= $this->endSection() ?>