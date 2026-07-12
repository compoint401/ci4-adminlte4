<?= $this->extend('layout/dashboard-layout'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header" id="print-header">
        <div class="row">
          <div class="col">
            <h2>List of Users</h2>
          </div>
          <div class="col">
            <div id="buttons"></div>
          </div>
          <div class="col text-end">
            <p><button id="addUserBtn" class="btn btn-primary">Add New User</button></p>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover table-bordered table-striped" id="user-table" width="100%">
            <thead>
              <th>#</th>
              <th>UserName</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Phone No.</th>
              <th>Gender</th>
              <th>Reg. Date & Time</th>
              <th>Update Date & Time</th>
              <th>Last Login Date & Time</th>
              <th>Status</th>
              <th>is Active?</th>
              <th>Action</th>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->include('admin/users/_userModal'); ?>
<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
<script src="/js/app.js"></script>
<script>
  var csrfName = $('meta.csrf').attr('name'); //CSRF TOKEN NAME
  var csrfHash = $('meta.csrf').attr('content'); //CSRF HASH

  $('.modal').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $(this).find('span.error-text').text('');
  });

$(document).ready(function() {

 var Table =  $('#user-table').DataTable({
    "processing": true,
    "serverSide": true,
    "ajax": "<?= route_to('get.all.users'); ?>",
    stateSave: true,
    info: true,
    "iDisplayLength": 5,
    "pageLength": 5,
    "aLengthMenu": [
      [5, 10, 25, 50, -1],
      [5, 10, 25, 50, "All"]
    ],
    columnDefs: [{
      "targets": 0,
      "searchable": false,
      "orderable": false,
      "data": null,
      "title": '# ',
      "render": function(data, type, full, meta) {
        return meta.settings._iDisplayStart + meta.row + 1;
      }
    }],
  });

  var buttons = new $.fn.dataTable.Buttons(Table, {
      buttons: [
        'colvis',
        'excel',
        {
          extend: 'print',
          footer: true,
          title: ' ',
          message: ' ',
          customize: function(win) {
            $(win.document.body)
              // .css('font-size', '10pt')
              .prepend(
                $('#print-header').html()
              );
          }
        }
      ]
    }).container().appendTo($('#buttons'));
});
  $(document).on('click', '#addUserBtn', function() {

    var $modal = $('#user-modal');
    var $form = $modal.find('form');

    // Reset form for adding
    $form[0].reset();
    $form.find('input[name="id"]').val('');

    $form.attr('action', '<?= route_to('add.user') ?>');
    $modal.find('#modal-label').text('Add New User');
    $modal.find('#form-submit-btn').text('Save');

    // Clear any previous validation errors
    $form.find('.is-invalid').removeClass('is-invalid');
    $form.find('.invalid-feedback').remove();

    $modal.modal('show');
    $modal.find('.email-field-group').show();
    $modal.find('select[name="usertype"]').removeAttr('required');
    $modal.find('.usertype-field-group').hide();
  });


  $(document).on('click', '.updateUserBtn', function() {
    <?= check_permission('users.create', 'update user') ?>
    var user_id = $(this).data('id');
    var $modal = $('#user-modal');
    var $form = $modal.find('form');

    // Reset form for adding
    $form[0].reset();
    $form.find('input[name="id"]').val('');

    $form.attr('action', '<?= route_to('update.user') ?>');
    $modal.find('#modal-label').text('Edit User');
    $modal.find('#form-submit-btn').text('Save Changes');

    // Clear any previous validation errors
    $form.find('.is-invalid').removeClass('is-invalid');
    $form.find('.invalid-feedback').remove();

    $.post("<?= route_to('get.user.info') ?>", {
      user_id: user_id,
      [csrfName]: csrfHash
    }, function(data) {

      $form.find('input[name="id"]').val(data.results.id);
      $form.find('input[name="username"]').val(data.results.username);
      $form.find('input[name="first_name"]').val(data.results.first_name);
      $form.find('input[name="last_name"]').val(data.results.last_name);
      $form.find('select[name="gender"]').val(data.results.gender);
      $form.find('input[name="phone_number"]').val(data.results.phone_number);
      $form.find('select[name="usertype"]').val(data.groups);

      // Hide email field and show usertype field for editing
      $modal.find('.email-field-group').hide();
      $modal.find('.usertype-field-group').show();
      $modal.find('input[name="email"]').removeAttr('required');

      $modal.modal('show');
    }, 'json');

  });

  // Universal form submission
  $('#user-form').submit(function(e) {
    e.preventDefault();
    handleFormSubmit(this);
  });

  $(document).on('click', '.disableUserBtn', function() {
    <?= check_permission('users.create', 'Diable user') ?>
    handleConfirmation(this, '(Un)Ban', 'User', '#user-table');
  });

  $(document).on('click', '.deleteUserBtn', function() {
    <?= check_permission('users.create', 'Delete user') ?>
    handleConfirmation(this, 'Delete', 'User', '#user-table');
  });
</script>

<?= $this->endSection(); ?>