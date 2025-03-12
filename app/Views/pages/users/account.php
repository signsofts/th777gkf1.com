<?= $this->extend('layouts/users/layout') ?>
<?= $this->section('title'); ?>
<?= lang('global.page.dashboard.title') ?>
<?= $this->endSection(); ?>
<?= $this->section('nav-title') ?>
<?= lang('global.page.dashboard.title') ?>
<?= $this->endSection() ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/users/css/account.css?v=") . time() ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> <?= lang('global.page.title') ?> /</span>
    <?= lang('users.T20') ?></h4>
<div class="card mb-4">
    <h5 class="card-header"><?= lang('users.T21'); ?></h5>
    <!-- Account -->
    <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-4">
            <img src="<?= $_row->pictureUrl ?? base_url("icons/icon-512x512.png"); ?>" alt="user-avatar"
                class="d-block rounded" height="100" width="100" id="uploadedAvatar">
            <div class="button-wrapper">

            </div>
        </div>
    </div>
    <hr class="my-0">
    <div class="card-body">
        <form id="formAccountSettings" method="POST" action="javascript:;" onsubmit="return false">
            <input type="hidden" name="user_id" value="<?= session('user_id'); ?>">
            <div class="row">
                <div class="col-12">
                    <h4><?= lang("users.T21"); ?></h4>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="user_fname" class="form-label"><?= lang('users.T22'); ?></label>
                    <input class="form-control" type="text" id="user_fname" name="user_fname"
                        value="<?= $_row->user_fname ?? ''; ?>" autofocus="">
                </div>
                <div class="mb-3 col-md-6">
                    <label for="user_lname" class="form-label"><?= lang('users.T23'); ?></label>
                    <input class="form-control" type="text" name="user_lname" id="user_lname"
                        value="<?= $_row->user_lname ?? ''; ?>">
                </div>
                <div class="mb-3 col-md-6">
                    <label for="user_email" class="form-label"><?= lang('users.T24'); ?></label>
                    <input class="form-control" type="text" id="user_email" name="user_email"
                        value="<?= $_row->user_email ?? ''; ?>" placeholder="john.doe@example.com">
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label" for="user_phone"><?= lang('users.T25'); ?></label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">TH (+66)</span>
                        <input type="text" id="user_phone" name="user_phone" class="form-control"
                            value="<?= $_row->user_phone ?? ''; ?>" placeholder="202 555 0111">
                    </div>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="user_address" class="form-label"><?= lang('users.T26'); ?></label>
                    <input type="text" class="form-control" id="user_address" name="user_address"
                        value="<?= $_row->user_address ?? ''; ?>" placeholder="<?= lang('users.T26'); ?>">
                </div>
                <div class="mb-3 col-md-6">
                    <label for="user_zipCode" class="form-label"><?= lang('users.T27'); ?></label>
                    <input type="text" class="form-control" id="user_zipCode" name="user_zipCode"
                        value="<?= $_row->user_zipCode ?? ''; ?>" maxlength="6">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="user_country"><?= lang('users.T28'); ?></label>
                    <select id="user_country" name="user_country" class="select2 form-select">
                        <option <?= $_row->user_country == '' || $_row->user_country == null ? 'selected' : ''; ?> value="a "
                            selected>Select</option>
                        <option <?= $_row->user_country == 'aAustralia' ? 'selected' : ''; ?> value="aAustralia">Australia
                        </option>
                        <option <?= $_row->user_country == 'aBangladesh' ? 'selected' : ''; ?> value="aBangladesh">
                            Bangladesh</option>
                        <option <?= $_row->user_country == 'aBelarus' ? 'selected' : ''; ?> value="aBelarus">Belarus
                        </option>
                        <option <?= $_row->user_country == 'aBrazil' ? 'selected' : ''; ?> value="aBrazil">Brazil</option>
                        <option <?= $_row->user_country == 'aCanada' ? 'selected' : ''; ?> value="aCanada">Canada</option>
                        <option <?= $_row->user_country == 'aChina' ? 'selected' : ''; ?> value="aChina">China</option>
                        <option <?= $_row->user_country == 'aFrance' ? 'selected' : ''; ?> value="aFrance">France</option>
                        <option <?= $_row->user_country == 'aGermany' ? 'selected' : ''; ?> value="aGermany">Germany
                        </option>
                        <option <?= $_row->user_country == 'aIndia' ? 'selected' : ''; ?> value="aIndia">India</option>
                        <option <?= $_row->user_country == 'aIndonesia' ? 'selected' : ''; ?> value="aIndonesia">Indonesia
                        </option>
                        <option <?= $_row->user_country == 'aIsrael' ? 'selected' : ''; ?> value="aIsrael">Israel</option>
                        <option <?= $_row->user_country == 'aItaly' ? 'selected' : ''; ?> value="aItaly">Italy</option>
                        <option <?= $_row->user_country == 'aJapan' ? 'selected' : ''; ?> value="aJapan">Japan</option>
                        <option <?= $_row->user_country == 'aKorea' ? 'selected' : ''; ?> value="aKorea">Korea, Republic of
                        </option>
                        <option <?= $_row->user_country == 'aMexico' ? 'seleced' : ''; ?> value="aMexico">Mexico</option>
                        <option <?= $_row->user_country == 'aPhilippines' ? 'selected' : ''; ?> value="aPhilippines">
                            Philippines</option>
                        <option <?= $_row->user_country == 'aRussia' ? 'selected' : ''; ?> value="aRussia">Russian
                            Federation</option>
                        <option <?= $_row->user_country == 'aSouth' ? 'selected' : ''; ?> value="aSouth Africa">South
                            Africa</option>
                        <option <?= $_row->user_country == 'aThailand' ? 'selected' : ''; ?> value="aThailand">Thailand
                        </option>
                        <option <?= $_row->user_country == 'aTurkey' ? 'selected' : ''; ?> value="aTurkey">Turkey</option>
                        <option <?= $_row->user_country == 'aUkraine' ? 'selected' : ''; ?> value="aUkraine">Ukraine
                        </option>
                        <option <?= $_row->user_country == 'aUnited' ? 'selected' : ''; ?> value="aUnited Arab Emirates">
                            United Arab Emirates</option>
                        <option <?= $_row->user_country == 'aUnited' ? 'selected' : ''; ?> value="aUnited Kingdom">United
                            Kingdom</option>
                        <option <?= $_row->user_country == 'aUnited' ? 'selected' : ''; ?> value="aUnited States">United
                            States</option>
                    </select>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="language" class="form-label"><?= lang("users.T29"); ?></label>
                    <select id="language" name="language" class="select2 form-select">
                        <option value="">Select Language</option>
                        <option <?= $_row->language == 'en' ? 'selected' : ''; ?> value="en">English</option>
                        <option <?= $_row->language == 'th' ? 'selected' : ''; ?> value="th">Thailand</option>
                    </select>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="user_currency" class="form-label"><?= lang("users.T30"); ?></label>
                    <select id="user_currency" class="select2 form-select">
                        <option value="">Select Currency</option>
                        <!-- <option <?= $_row->user_currency == 'USD' ? 'selected' : ''; ?> value="USD">USD</option> -->
                        <option <?= $_row->user_currency == 'THB' ? 'selected' : ''; ?> value="THB">THB</option>
                    </select>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <h4><?= lang("users.T31"); ?></h4>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="user_bankFName" class="form-label"><?= lang('users.T22'); ?></label>
                    <input class="form-control" type="text" id="user_bankFName" name="user_bankFName"
                        value="<?= $_row->user_bankFName ?? ''; ?>">
                </div>
                <div class="mb-3 col-md-6">
                    <label for="user_bankLName" class="form-label"><?= lang('users.T23'); ?></label>
                    <input class="form-control" type="text" name="user_bankLName" id="user_bankLName"
                        value="<?= $_row->user_bankLName ?? ''; ?>">
                </div>
                <div class="mb-3 col-md-6">
                    <label for="user_bankNumber" class="form-label"><?= lang('users.T32'); ?></label>
                    <input class="form-control" type="text" id="user_bankNumber" name="user_bankNumber"
                        value="<?= $_row->user_bankNumber ?? ''; ?>">
                </div>
                <div class="mb-3 col-md-6">
                    <label for="user_bank" class="form-label"><?= lang('users.T33'); ?></label>
                    <input class="form-control" type="text" id="user_bank" name="user_bank"
                        value="<?= $_row->user_bank ?? ''; ?>">
                </div>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="accountActivation" id="" required>
                <label class="form-check-label" for="">I confirm my account deactivation</label>
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2"><?= lang('global.btn.save'); ?></button>
            </div>
        </form>
    </div>
    <!-- /Account -->
</div>


<div class="card" style="display: none;">
    <h5 class="card-header">Delete Account</h5>
    <div class="card-body">
        <div class="mb-3 col-12 mb-0">
            <div class="alert alert-warning">
                <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?</h6>
                <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
            </div>
        </div>
        <form id="formAccountDeactivation" onsubmit="return false">
            <input type="hidden" name="user_id" value="<?= session('user_id'); ?>">
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation"
                    required>
                <label class="form-check-label" for="accountActivation">I confirm my account deactivation</label>
            </div>
            <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url("assets/users/js/account.js?v=") . time() ?>"></script>
<?= $this->endSection() ?>