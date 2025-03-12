<?= $this->extend ( 'layouts/layout' ) ?>

<?= $this->section ( 'title' ) ?>
จัดการไฟล์ .env
<?= $this->endSection () ?>

<?= $this->section ( 'nav-title' ) ?>
จัดการไฟล์ .env
<?= $this->endSection () ?>

<?= $this->section ( 'style' ) ?>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .message {
        color: green;
        margin-bottom: 10px;
    }

    .form-container {
        margin-bottom: 20px;
    }

    .btn-delete {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-delete:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .form-inline {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-inline input,
    .form-inline select {
        flex: 1;
    }
</style>
<?= $this->endSection () ?>

<?= $this->section ( 'content' ) ?>

<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">การตั้งค่า /</span> จัดการไฟล์ .env
</h4>

<div class="row">
    <div class="col-12 order-1 mb-4">
        <div class="card h-100">
            <div class="card-body px-0 p-3">


                <!-- ฟอร์มเพิ่มตัวแปรใหม่ -->
                <div class="form-container m-3">

                    <?php if ( $message ): ?>
                        <div class="message"><?= esc ( $message ) ?></div>
                    <?php endif; ?>


                    <form method="post" action="<?= base_url ( 'admin/setting/env/save' ) ?>">
                        <div class="mb-3">
                            <label for="key" class="form-label">Key</label>
                            <input type="text" name="key" id="key" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="value" class="form-label">Value</label>
                            <input type="text" name="value" id="value" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">เพิ่มตัวแปร</button>
                    </form>
                </div>

                <!-- ตารางแสดงและแก้ไขตัวแปร -->
                <table class="table w-100">
                    <thead>
                        <tr>
                            <th>Key</th>
                            <th>Value</th>
                            <th>การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $envVars as $key => $value ): ?>
                            <tr>
                                <td><?= esc ( $key ) ?></td>
                                <td>
                                    <form method="post" action="<?= base_url ( 'admin/setting/env/save' ) ?>"
                                        class="form-inline">
                                        <input type="hidden" name="key" value="<?= esc ( $key ) ?>">
                                        <?php if ( $key === 'CI_ENVIRONMENT' ): ?>
                                            <select name="value" class="form-control">
                                                <option value="development" <?= $value === 'development' ? 'selected' : '' ?>>
                                                    Development</option>
                                                <option value="production" <?= $value === 'production' ? 'selected' : '' ?>>
                                                    Production</option>
                                            </select>
                                        <?php else: ?>
                                            <input type="text" name="value" value="<?= esc ( $value ) ?>" class="form-control">
                                        <?php endif; ?>
                                        <button type="submit" class="btn btn-sm btn-primary">บันทึก</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="<?= base_url ( 'admin/setting/env/delete/' . urlencode ( $key ) ) ?>"
                                        class="btn btn-sm btn-delete"
                                        onclick="return confirm('แน่ใจว่าต้องการลบ <?= esc ( $key ) ?>?')">ลบ</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if ( empty ( $envVars ) ): ?>
                            <tr>
                                <td colspan="3">ไม่มีตัวแปรใน .env</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection () ?>

<?= $this->section ( 'script' ) ?>
<?= $this->endSection () ?>