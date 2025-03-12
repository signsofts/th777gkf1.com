<?php

use App\Models\GroupModel;

$GroupModel = new GroupModel();

$uri = current_url(TRUE);
$uriStr = explode("/", uri_string());
$segments1 = isset($uriStr[0]) ? $uriStr[0] : "";
$segments2 = isset($uriStr[1]) ? $uriStr[1] : "";
$segments3 = isset($uriStr[2]) ? $uriStr[2] : "";
$segments4 = isset($uriStr[3]) ? $uriStr[3] : "";
$segments5 = isset($uriStr[4]) ? $uriStr[4] : "";

?>

<div class="app-brand demo">
    <a href="<?= base_url('admin'); ?>" class="app-brand-link">
        <span class="app-brand-logo demo">
        </span>
        <span class="app-brand-text demo menu-text fw-bolder ms-2 text"
            style="text-transform :capitalize;"><?= getenv('CI_TITLE') ?></span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
</div>

<div class="menu-inner-shadow"></div>
<ul class="menu-inner py-1">

    <?php if ($_SESSION["user"]->RoleID == '4' || $_SESSION["user"]->RoleID == '1' || $_SESSION["user"]->RoleID == '2' || $_SESSION["user"]->RoleID == '3' || $_SESSION["user"]->RoleID == '5'): ?>
        <li class="menu-item <?= $segments1 == '' ? "active" : "" ?>">
            <a href="<?= base_url('admin'); ?>" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-dashboard'></i>
                <div><?= lang('menu.text.dashboard') ?></div>
            </a>
        </li>
    <?php endif ?>

    <?php if ($_SESSION["user"]->RoleID == '4' || $_SESSION["user"]->RoleID == '1' || $_SESSION["user"]->RoleID == '2' || $_SESSION["user"]->RoleID == '3' || $_SESSION["user"]->RoleID == '5'): ?>

        <li class="menu-item <?= $segments1 == 'g' ? "active" : "" ?>">
            <a href="/admin/g/v" class="menu-link">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div><?= lang('menu.text.rooms') ?></div>
            </a>
        </li>
        <!-- <li class="menu-item <?= $segments1 == 'g' ? "active open" : "" ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts"><?= lang('menu.text.rooms') ?></div>
            </a>
            <ul class="menu-sub">
                <?php
                $groupRow = $GroupModel
                    ->where('groupDelete', '0')
                    ->findAll();
                ?>

                <?php foreach ($groupRow as $key => $item): ?>
                    <li class="menu-item <?= $segments3 == $item->groupId ? "active" : "" ?>">
                        <a href="<?= base_url('admin/g/v/'); ?><?= $item->groupId ?>" class="menu-link">
                            <div><?= $item->groupName ?> </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li> -->
    <?php endif ?>

    <?php if ($_SESSION["user"]->RoleID == '4' || $_SESSION["user"]->RoleID == '1' || $_SESSION["user"]->RoleID == '2' || $_SESSION["user"]->RoleID == '3' || $_SESSION["user"]->RoleID == '6'): ?>

        <li class="menu-item <?= $segments1 == 'm' ? "active" : "" ?>">
            <a href="/admin/m" class="menu-link">
                <i class='menu-icon tf-icons bx bx-user-circle'></i>
                <div><?= lang('menu.text.members') ?></div>
            </a>
        </li>

    <?php endif ?>

    <?php if ($_SESSION["user"]->RoleID == '4' || $_SESSION["user"]->RoleID == '1' || $_SESSION["user"]->RoleID == '2' || $_SESSION["user"]->RoleID == '3' || $_SESSION["user"]->RoleID == '7'): ?>
        <li class="menu-item <?= $segments1 == 'b' && $segments2 == '' ? "active" : "" ?>">
            <a href="/admin/b" class="menu-link">
                <i class='menu-icon tf-icons  bx bxs-bank'></i>
                <div><?= lang('menu.text.banks') ?></div>
            </a>
        </li>
    <?php endif ?>

    <?php if ($_SESSION["user"]->RoleID == '4' || $_SESSION["user"]->RoleID == '1' || $_SESSION["user"]->RoleID == '2' || $_SESSION["user"]->RoleID == '3' || $_SESSION["user"]->RoleID == '7' || $_SESSION["user"]->RoleID == '6'): ?>
        <li class="menu-item <?= $segments1 == 'b' && $segments2 == 'approve' ? "active" : "" ?>">
            <a href="/admin/b/approve" class="menu-link">
                <i class='menu-icon tf-icons  bx bxs-bank'></i>
                <div><?= lang('menu.TM1') ?></div>
            </a>
        </li>
    <?php endif ?>


    <?php if ($_SESSION["user"]->RoleID == '4' || $_SESSION["user"]->RoleID == '1'): ?>
        <li class="menu-item <?= $segments1 == 'ac' ? "active" : "" ?>">
            <a href="<?= base_url('admin/ac'); ?>" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-shield-alt-2'></i>
                <div><?= lang('menu.text.admin') ?></div>
            </a>
        </li>
    <?php endif ?>

    <?php if ($_SESSION["user"]->RoleID == '4' || $_SESSION["user"]->RoleID == '1'): ?>
        <li class="menu-item <?= $segments1 == 'report' ? "active open" : "" ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div><?= lang('menu.text.report') ?></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= $segments2 == "agent" ? "active" : "" ?>">
                    <a href="<?= base_url('/admin/report/agent/'); ?>" class="menu-link">
                        <div> <?= lang('menu.text.report-agent') ?> </div>
                    </a>
                </li>

            </ul>
        </li>
    <?php endif ?>


    <?php if ($_SESSION["user"]->RoleID == '4' || $_SESSION["user"]->RoleID == '1'): ?>
        <li class="menu-item <?= $segments1 == 'setting' ? "active open" : "" ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div><?= lang('menu.text.setting') ?></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= $segments2 == "agent" ? "active" : "" ?>">
                    <a href="<?= base_url('/admin/setting/env'); ?>" class="menu-link">
                        <div> <?= lang('menu.text.setting-env') ?> </div>
                    </a>
                </li>

            </ul>
        </li>
    <?php endif ?>

</ul>