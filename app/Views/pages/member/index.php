<?= $this->extend('layouts/layout') ?>
<?= $this->section('title') ?>
<?= lang("global.page.member.title") ?>
<?= $this->endSection() ?>
<?= $this->section('nav-title') ?>
<?= lang("global.page.member.title") ?>
<?= $this->endSection() ?>


<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/pages/css/m-index.css?v=") . time() ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> <?= lang('global.page.title') ?> /</span> </span>
    <?= lang("global.page.member.title") ?></h4>

<div class="row">
    <div class="col-12 order-3 order-md-2  ">
        <div class="row">
            <div class=" col-12 col-sm-4 col-md-3 mb-4      ">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title">
                                    <h5 class="text-nowrap mb-2"><?= lang('global.page.member.text.userAll') ?>
                                    </h5>
                                </div>
                                <div class="mt-sm-auto">
                                    <h3 class="mb-0 text-primary">
                                        <?= $memberCount ?> <?= lang('global.page.member.text.person') ?>
                                    </h3>
                                </div>
                            </div>
                            <div id="profileReportChart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" col-12 col-sm-4 col-md-3 mb-4      ">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title">
                                    <h5 class="text-nowrap mb-2"><?= lang('global.page.member.text.momeySum') ?>
                                    </h5>
                                </div>
                                <div class="mt-sm-auto">
                                    <h3 class="mb-0 text-primary">
                                        <?= currency($momneySum) ?>
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
        <h4 class=""><?= lang('global.page.member.text.table.title'); ?></h4>
        <div class="table-responsive text-nowrap">
            <table id="table-memberlist" class="table w-100">
                <thead>
                    <tr class="text-nowrap       ">
                        <th width="5px" class="text-start  "><?= lang('global.text.number-row'); ?></th>
                        <th width="50px" class="text-start">
                            <?= lang('global.page.member.text.table.thead.pictureUrl'); ?>
                        </th>
                        <th width="20px" class="text-start"><?= lang('global.page.member.text.table.thead.date'); ?>
                        </th>
                        <th class="text-start"><?= lang('global.page.member.text.table.thead.displayName'); ?></th>
                        <th width="5px" class="text-start"><?= lang('global.page.member.text.table.thead.follow'); ?>
                        </th>
                        <th class="text-start"><?= lang('global.page.member.text.table.thead.user_remain'); ?></th>
                        <th width="5px" class="text-start"><?= lang('global.page.member.text.table.thead.user_room'); ?>
                        </th>
                        <th width="5px" class="text-start"><?= lang('global.text.agent'); ?></th>
                        <th width="10px" class="text-start"><?= lang('global.text.management'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($member as $key => $item): ?>
                        <tr>
                            <td><?= $key + 1; ?></td>
                            <td> <img src="<?= $item->pictureUrl ?>" width="50px" height="50px" class=""> </td>
                            <td><?= formatDateDDMMYYYY($item->created_at); ?></td>
                            <td><?= $item->displayName; ?></td>
                            <td><?= $item->follow == "1" ? "กำลังติดตาม" : "ไม่ได้ติดตาม"; ?></td>
                            <td><?= currency($item->user_remain); ?></td>
                            <td><?= count($item->group) ?>     <?= lang('global.page.member.text.table.thead.room'); ?></td>
                            <td>
                                <?php if (is_null($item->user_agent)): ?>
                                    <a href="javascript:clipboardMakeLink('<?= $item->user_id; ?>');"><i
                                            class='bx bx-link-alt'></i> <?= lang("global.page.g-index.text.makeLink"); ?> </a>
                                <?php else: ?>
                                    <?= $item->AGENT_NINAME ?? ' - '; ?>
                                <?php endif; ?>
                            </td>
                            <td class="text-start"><a class="btn btn-sm btn-outline-primary "
                                    href="<?= base_url('admin/m/v/') . $item->user_id; ?>"><?= lang("global.text.detail"); ?></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('script') ?>
<script src="<?= base_url("assets/pages/js/m-index.js?v=") . time() ?>"></script>
<?= $this->endSection() ?>