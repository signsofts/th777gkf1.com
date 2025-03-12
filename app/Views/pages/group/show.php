<?= $this->extend('layouts/layout') ?>
<?= $this->section('title') ?>
<?= $group->groupName ?>
<?= $this->endSection() ?>
<?= $this->section('nav-title') ?>
<?= $group->groupName ?>
<?= $this->endSection() ?>


<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/pages/css/g_v.css?v=") . time() ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> <?= lang('global.page.title') ?> /</span> <span class="text-muted fw-light"> <?= lang('global.page.g.title') ?> /</span> <?= $group->groupName ?> ( <?= lang('global.page.g.text.user', ["count" => count($group->members)]); ?>)</h4>

<div class="row">
    <div class=" col-12 col-sm-4 col-md-3 mb-4  ">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                    <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                        <div class="card-title">
                            <h5 class="text-nowrap mb-2"><?= lang('global.page.g.text.money-sum') ?>
                            </h5>
                        </div>
                        <div class="mt-sm-auto">

                            <h3 class="mb-0 text-primary"><?= currency($group->moneySum) ?>
                                <?= '' //lang('global.page.g.text.text-baht') 
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
                            <h5 class="text-nowrap mb-2"><?= lang('global.page.g.text.money-pay') ?>
                            </h5>
                        </div>
                        <div class="mt-sm-auto">

                            <h3 class="mb-0 text-primary"><?= currency($group->moneyPay) ?>
                                <?= '' // lang('global.page.g.text.text-baht') 
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
                            <h5 class="text-nowrap mb-2  "><?= lang('global.page.g.text.money-totle') ?>
                            </h5>
                        </div>
                        <div class="mt-sm-auto">

                            <h3 class="mb-0 text-primary"><?= currency($group->moneyTotle) ?>
                                <?= '' // lang('global.page.g.text.text-baht') 
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

<div class="row mb-3">
    <div class="col-12 d-flex justify-content-between">
        <button type="button" class="btn btn-md btn-warning" data-bs-toggle="modal" data-bs-target="#EditRoomShowModal"> <?= lang('global.btn.edit'); ?> </button>
        <button type="button" class="btn btn-md  btn-primary" data-bs-toggle="modal" data-bs-target="#AddShowModal"><?= lang("group.btn-live") ?></button>
    </div>
</div>

<div class="nav-align-top mb-4">
    <ul class="nav nav-tabs nav-fill" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true">
                <i class="tf-icons bx bx-home"></i> <?= lang('global.page.g.table.title'); ?>
                <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger"><?= count($group->lives ?? []); ?></span>
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile" aria-selected="false">
                <i class="tf-icons bx bx-user"></i> <?= lang('global.page.g.text.userText'); ?>
                <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger"><?= count($group->members ?? []) ?></span>
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
                <table id="table-live-index" class="table w-100">
                    <thead>
                        <tr class="text-nowrap">
                            <th>#</th>
                            <th><?= lang('global.page.g.table.date'); ?></th>
                            <th><?= lang('global.page.g.table.thead.count-open'); ?></th>
                            <th><?= lang('global.page.g.table.thead.games'); ?></th>
                            <th><?= lang('global.page.g.table.thead.status'); ?></th>
                            <th><?= lang('global.page.g.text.money-sum') ?></th>
                            <th><?= lang('global.page.g.text.money-pay') ?></th>
                            <th><?= lang('global.page.g.text.money-totle') ?></th>
                            <th><?= lang('global.text.detail'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($group->lives as $key => $iline) : ?>
                            <tr>
                                <th scope="row"><?= $key + 1 ?></th>
                                <td><?= formatDateDDMMYYYY($iline->liveCreated_at) ?></td>
                                <td><?= $iline->openCardSum ?></td>
                                <td><?= $lang == "th" ?  $iline->msNameT   : $iline->msNameE ?></td>
                                <td class="<?= $iline->statusCloseLive == 0 ? "text-success" : "text-danger"; ?> ">
                                    <?= $iline->statusCloseLive == 0 ? "OPEN" : "CLOSE"; ?>
                                </td>
                                <td><?= currency($iline->GLI_Total_Quantity ?? 0); ?></td>
                                <td><?= currency($iline->GLI_Total_Payment ?? 0); ?></td>
                                <td><?= currency($iline->GLI_Remaining_Balance ?? 0); ?></td>
                                <td>
                                    <a href="<?= base_url("admin/g/l/" . $iline->groupId . "/" . $iline->groupLive_ID); ?>" class="btn btn-sm btn-primary"><?= lang('global.text.detail'); ?></a>
                                    <?php if (!$iline->statusCloseLive) : ?>
                                        <button type="button" class="btn btn-sm btn-warning" onclick="closeOpenLive('<?= $iline->groupLive_ID; ?>')"> <?= lang('global.btn.close'); ?></button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
            <table id="table-users" class="table w-100">
                <thead>
                    <tr class="text-nowrap       ">
                        <th width="5px" class="text-start  "><?= lang('global.text.number-row'); ?></th>
                        <th width="50px" class="text-start"><?= lang('global.page.member.text.table.thead.pictureUrl'); ?></th>
                        <th width="20px" class="text-start"><?= lang('global.page.member.text.table.thead.date'); ?></th>
                        <!-- <th class="text-start"><?= lang('global.page.member.text.table.thead.userId'); ?></th> -->
                        <th class="text-start"><?= lang('global.page.member.text.table.thead.displayName'); ?></th>
                        <th width="5px" class="text-start"><?= lang('global.page.member.text.table.thead.follow'); ?></th>
                        <th class="text-start"><?= lang('global.page.member.text.table.thead.user_remain'); ?></th>
                        <th width="10px" class="text-start"><?= lang('global.text.management'); ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($group->members as $key => $item) : ?>
                        <tr>
                            <td><?= $key + 1; ?></td>
                            <td> <img src="<?= $item->pictureUrl ?>" width="50px" height="50px" class=""> </td>
                            <td><?= formatDate($item->created_at); ?></td>
                            <td><?= $item->displayName; ?></td>
                            <td><?= $item->follow == "1" ? "กำลังติดตาม" : "ไม่ได้ติดตาม"; ?></td>
                            <td><?= currency($item->user_remain); ?></td>
                            <td class="text-start"><a class="btn btn-sm btn-outline-primary " href="<?= base_url('m/v/') . $item->userId; ?>"><?= lang("global.text.detail"); ?></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <!-- <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel"></div> -->
    </div>
</div>



<div class="modal fade" id="AddShowModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="AddShowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form id="id-form-add" method="post" action="javascript:;" enctype="multipart/form-data">
                <input type="hidden" name="groupId" value="<?= $group->groupId; ?>">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="AddShowModalLabel"><?= lang("global.page.g.text.modal.title") ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2">
                        <label for="id-openCardSum" class="form-label"><?= lang('global.page.g.text.modal.label-openCardSum'); ?></label>
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



<div class="modal fade" id="EditRoomShowModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="EditRoomShowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form id="id-form-edit" method="post" action="javascript:;" enctype="multipart/form-data">
                <input type="hidden" name="groupId" value="<?= $group->groupId; ?>">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="EditRoomShowModalLabel"><?= lang("global.page.g.text.modalEdit.title") ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2">
                        <label for="id-openCardSum" class="form-label"><?= lang('global.page.g.text.modalEdit.lang'); ?></label>
                        <select name="group_language" class="form-select">
                            <option <?= $group->group_language == "en" ? "selected" : ""; ?> value="en">English</option>
                            <option <?= $group->group_language == "th" ? "selected" : ""; ?> value="th">ไทย</option>
                        </select>
                    </div>
                    <div class="mt-2">
                        <label for="id-openCardSum" class="form-label"><?= lang('global.page.g.text.modalEdit.gamemasters'); ?></label>
                        <select name="msID" class="form-select">
                            <?php foreach ($gamemasters as $item) : ?>
                                <option <?= $group->msID == $item->msID ? "selected" : ""; ?> value="<?= $item->msID; ?>"><?= $lang == "th" ? $item->msNameT : $item->msNameE; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="mt-2">
                        <label for="id-openCardSum" class="form-label"><?= lang('global.page.g.text.modalEdit.GRO_InviteLink'); ?></label>
                        <input type="text" name="GRO_InviteLink" value="<?= $group->GRO_InviteLink; ?>" class="form-control">
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
<script src="<?= base_url("assets/pages/js/g_v.js?v=") . time() ?>"></script>
<?= $this->endSection() ?>