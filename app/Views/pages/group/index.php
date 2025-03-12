<?= $this->extend('layouts/layout') ?>
<?= $this->section('title') ?>
<?= lang('menu.text.rooms') ?>
<?= $this->endSection() ?>
<?= $this->section('nav-title') ?>
<?= lang('menu.text.rooms') ?>
<?= $this->endSection() ?>


<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/pages/css/g-index.css?v=") . time() ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> <?= lang('global.page.title') ?> /</span>
    <?= lang('menu.text.rooms') ?></h4>

<div class="row">
    <div class=" col-12 col-sm-4 col-md-3 mb-4  ">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                    <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                        <div class="card-title">
                            <h5 class="text-nowrap mb-2"><?= lang('global.page.g-index.text.money-sum') ?>
                            </h5>
                        </div>
                        <div class="mt-sm-auto">

                            <h3 class="mb-0 text-primary"><?= currency($moneySum ?? 0) ?>
                                <?= '' //lang('global.page.g-index.text.text-baht') 
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
                            <h5 class="text-nowrap mb-2"><?= lang('global.page.g-index.text.money-pay') ?>
                            </h5>
                        </div>
                        <div class="mt-sm-auto">

                            <h3 class="mb-0 text-primary"><?= currency($moneyPay ?? 0) ?>
                                <?= '' // lang('global.page.g-index.text.text-baht') 
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
                            <h5 class="text-nowrap mb-2  "><?= lang('global.page.g-index.text.money-totle') ?>
                            </h5>
                        </div>
                        <div class="mt-sm-auto">

                            <h3 class="mb-0 text-primary"><?= currency($moneyTotle ?? 0) ?>
                                <?= '' // lang('global.page.g-index.text.text-baht') 
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

<div class="nav-align-top mb-4">
    <ul class="nav nav-tabs nav-fill" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true">
                <i class="tf-icons bx bx-home"></i><?= lang('menu.text.rooms') ?>
                <span
                    class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger"><?= count($gRow ?? []); ?></span>
            </button>
        </li>
        <!-- <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile" aria-selected="false">
                <i class="tf-icons bx bx-user"></i> <?= lang('global.page.g-index.text.userText'); ?>
                <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger"></span>
            </button>
        </li> -->
        <!-- <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-messages" aria-controls="navs-justified-messages" aria-selected="false">
                <i class="tf-icons bx bx-message-square"></i> Messages
            </button>
        </li> -->
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
            <div class="table-responsive text-nowrap">
                <table id="table-group-index" class="table w-100">
                    <thead>
                        <tr class="text-nowrap">
                            <th>#</th>
                            <th><?= lang('global.page.g-index.table.date'); ?></th>
                            <th><?= lang('global.page.g-index.table.thead.room'); ?></th>
                            <th><?= lang('global.page.g-index.table.thead.games'); ?></th>
                            <th><?= lang('global.page.g-index.table.thead.status'); ?></th>
                            <th><?= lang('global.page.g-index.table.thead.user'); ?></th>
                            <th><?= lang('global.page.g-index.text.money-sum') ?></th>
                            <th><?= lang('global.page.g-index.text.money-pay') ?></th>
                            <th><?= lang('global.page.g-index.text.money-totle') ?></th>
                            <th><?= lang("global.page.g-index.text.makeLink"); ?> </th>
                            <th><?= lang('global.text.detail'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($gRow ?? [] as $key => $item): ?>
                            <tr>
                                <td><?= $key + 1; ?></td>
                                <td><?= formatDateDDMMYYYY($item->created_at); ?></td>
                                <td><?= $item->groupName; ?></td>
                                <td><?= $lang == "th" ? $item->msNameT : $item->msNameE; ?></td>
                                <td><?= $item->status ?></td>
                                <td><?= lang("global.page.g-index.text.user", ["count" => $item->membersCount]) ?></td>
                                <td><?= currency($item->GRO_Total_Quantity) ?></td>
                                <td><?= currency($item->GRO_Total_Payment) ?></td>
                                <td><?= currency($item->GRO_Remaining_Balance) ?></td>
                                <td><a href="javascript:clipboardMakeLink('<?= $item->groupId; ?>');"><i
                                            class='bx bx-link-alt'></i> <?= lang("global.page.g-index.text.makeLink"); ?>
                                    </a></td>
                                <td>
                                    <a href="<?= base_url('admin/g/v/' . $item->groupId); ?>"
                                        class="btn btn-sm btn-primary"><?= lang('global.text.detail'); ?></a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

        </div>
        <!-- <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
            <table id="table-users" class="table w-100">
                <thead>
                    <tr class="text-nowrap       ">
                        <th width="5px" class="text-start  "><?= lang('global.text.number-row'); ?></th>
                        <th width="50px" class="text-start"><?= lang('global.page.member.text.table.thead.pictureUrl'); ?></th>
                        <th width="20px" class="text-start"><?= lang('global.page.member.text.table.thead.date'); ?></th>
                        <th class="text-start"><?= lang('global.page.member.text.table.thead.userId'); ?></th>
                        <th class="text-start"><?= lang('global.page.member.text.table.thead.displayName'); ?></th>
                        <th width="5px" class="text-start"><?= lang('global.page.member.text.table.thead.follow'); ?></th>
                        <th class="text-start"><?= lang('global.page.member.text.table.thead.user_remain'); ?></th>
                        <th width="10px" class="text-start"><?= lang('global.text.management'); ?></th>
                    </tr>
                </thead>

                <tbody>
                    
                </tbody>
            </table>
        </div> -->
        <!-- <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel"></div> -->
    </div>
</div>





<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script src="<?= base_url("assets/pages/js/g-index.js?v=") . time() ?>"></script>
<?= $this->endSection() ?>