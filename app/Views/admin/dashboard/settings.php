<?= $this->extend('layout/dashboard-layout'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <div class="col-md-12">
    <a href="<?= route_to('settings.createviews') ?>" class="btn btn-primary">Create Views </a>

    <br><br>
    <!-- <button href="</?= route_to('settings.createtables') ?>" class="btn btn-primary" disabled> Create Tables </button>
    <br><br>
    <button href="</?= route_to('settings.seeddata') ?>" class="btn btn-primary" disabled> Seed Data </button> -->
    <br> <br>
    <a href="<?= route_to('backup') ?>" class="btn btn-primary"> Database Backup </a>

  </div>
</div>

<?php if (session()->has("message")) { ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong><?= session()->getFlashdata("message") ?></strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php } ?>
<?= $this->endSection(); ?>