<?php

use App\Models\GroupModel;

$GroupModel = new GroupModel();

$uri = current_url(true);
$uriStr = explode("/", uri_string());
$segments1 = isset($uriStr[0]) ? $uriStr[0] : "";
$segments2 = isset($uriStr[1]) ? $uriStr[1] : "";
$segments3 = isset($uriStr[2]) ? $uriStr[2] : "";
$segments4 = isset($uriStr[3]) ? $uriStr[3] : "";
$segments5 = isset($uriStr[4]) ? $uriStr[4] : "";

?>

<div class="app-brand demo">
    <a href="<?= base_url('users'); ?>" class="app-brand-link">
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
    <li class="menu-item <?= $segments1 == "users" && $segments2 == '' ? "active" : "" ?>">
        <a href="<?= base_url('users'); ?>" class="menu-link">
            <i class='menu-icon tf-icons bx bxs-dashboard'></i>
            <div><?= lang('menu.text.dashboard') ?></div>
        </a>
    </li>
    <li class="menu-item <?= $segments1 == "users" && $segments2 == 'statements' ? "active" : "" ?>">
        <a href="<?= base_url('users/statements'); ?>" class="menu-link">
            <i class='menu-icon tf-icons bx bxs-dashboard'></i>
            <div><?= lang('users.TM3') ?></div>
        </a>
    </li>
    <li class="menu-item <?= $segments1 == "users" && $segments2 == 'account' ? "active" : "" ?>">
        <a href="<?= base_url('users/account'); ?>" class="menu-link">
            <i class='menu-icon tf-icons bx bx-dock-top'></i>
            <div><?= lang('users.TM4') ?></div>
        </a>
    </li>
</ul>