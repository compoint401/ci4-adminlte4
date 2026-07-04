<?= $this->extend('layout/dashboard-layout'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <div class="col-md-4 offset-md-4">
    <table class="table table-bordered table-striped">
      <thead>
        <th>Particulars</th>
        <th>Value</th>
      </thead>
      <tbody>
        <tr>
          <td>UserName</td>
          <td><?= $User->username ?></td>
        </tr>
        <tr>
          <td>Email</td>
          <td><?= $User->email ?></td>
        </tr>
        <tr>
          <td>First Name</td>
          <td><?= $User->first_name ?></td>
        </tr>
        <tr>
          <td>Last Name</td>
          <td><?= $User->last_name ?></td>
        </tr>
        <tr>
          <td>Phone Number</td>
          <td><?= $User->phone_number ?></td>
        </tr>
        <tr>
          <td>Group</td>
          <td><?= implode(",", $User->getGroups()) ?></td>
        </tr>
      </tbody>

    </table>
  </div>
</div>
<?= $this->endSection(); ?>