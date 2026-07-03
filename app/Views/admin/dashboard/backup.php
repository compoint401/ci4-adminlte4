<?= $this->extend('layout/dashboard-layout'); ?>
<?= $this->section('content'); ?>

<?php if (session()->has("message")) { ?>
  <div
    class="alert alert-<?= esc(session()->getFlashdata('status') === 'success' ? 'success' : 'danger', 'attr') ?> alert-dismissible fade show"
    role="alert">
    <strong><?= session()->getFlashdata("message") ?></strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php } ?>

<div class="row">
  <div class="col-md-12">
    <div class="card" id="backupCard">
      <div class="card-header">
        <div class="row">
          <div class="col">
            <h2>Database Backup</h2>
          </div>
          <div class="col text-right">
            <?= form_open(url_to('Backup::create')) ?>
            <button type="submit" class="button">Create Backup Now</button>
            <?= form_close() ?>
          </div>
        </div>
      </div>
      <div class="card-body">
        <?php if (!empty($backups)): ?>
          <table class="table table-striped" width="100%">
            <thead>
              <tr>
                <th>Filename</th>
                <th>Date & Time</th>
                <th>Size</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($backups as $backup): ?>
                <tr>
                  <td><?= esc($backup['name']) ?></td>
                  <td><?= esc($backup['time']) ?></td>
                  <td><?= esc($backup['size_readable']) ?></td>
                  <td><a href="<?= url_to('Backup::download', $backup['name']) ?>"
                      class="btn btn-success btn-sm">Download</a>
                    <?= form_open(url_to('Backup::delete', $backup['name']), ['method' => 'post', 'style' => 'display:inline']) ?>
                    <button type="submit" class="btn btn-danger btn-sm"
                      onclick="return confirm('Delete this backup?')">Delete</button>
                    <?= form_close() ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p class="text-center">No backup files found in the backup directory.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
</div>

<?= $this->endSection(); ?>