<?= $this->extend('layout/dashboard-layout'); ?>
<?= $this->section('css'); ?>
<link rel="stylesheet" href="plugins/datatables-select/css/select.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/jquery-datatables-checkboxes/css/dataTables.checkboxes.css">
<?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h2>Sales</h2>
        <button class="btn btn-default" id="toggleFilterBtn" title="Filter">
          <i class="fas fa-filter"></i>
        </button>
      </div>
      <div class="card-body">

        <form id="salesFilterForm" class="mb-3" style="display:none;">
          <div class="form-row">
            <div class="col-md-3">
              <input type="date" class="form-control" name="date" placeholder="Date">
            </div>
            <div class="col-md-3">
              <input type="text" class="form-control" name="inv_no" placeholder="Invoice No.">
            </div>
            <div class="col-md-3">
              <select class="form-control" name="site_name">
                <option value="">-- Project/Site Name --</option>
                <?php foreach ($Sites as $site) : ?>
                  <option value="<?= $site['id']; ?>">
                    <?= $site['project'] . ' - ' . $site['name']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-1">
              <button type="submit" class="btn btn-primary btn-block">Apply</button>
            </div>
            <div class="col-md-1">
              <button type="button" class="btn btn-secondary btn-block" id="resetFilterBtn">Reset</button>
            </div>
          </div>
        </form>
        <table class="table table-hover table-bordered nowrap" id="sales-table">
          <thead>
            <th>#</th>
            <th>Date</th>
            <th>Invoice No</th>
            <!-- <th>Quantity</th> -->
            <th>Basic Amt</th>
            <th>GST Amt</th>
            <th>Inv. Amt</th>
            <th>Due Date</th>
            <th>Inv. Reg. No.</th>
            <th>Inv. Reg. Date</th>
            <th>Project</th>
            <th>Site Name</th>
            <th>PO Number</th>
            <th>Dly. Start Dt</th>
            <th>Dly. End Dt.</th>
            <th>Actions</th>
          </thead>
          <tbody></tbody>

        </table>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h2>Search for Unbilled Delivery to Customer</h2>
      </div>
      <div class="card-body">
        <form action="<?= route_to('delivery.dlfc'); ?>" method="POST" id="search-delivery-form">
          <?= csrf_field(); ?>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="siteId">Project/Site Name *</label>
                <select class="custom-select" name="siteId" id="siteId" onchange="doSiteId(this)" required>
                  <option value="">--Select a Project/Site --</option>
                  <?php foreach ($Sites as $site) : ?>
                    <option value="<?= $site['id']; ?>">
                      <?= $site['project'] . ' - ' . $site['name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <span class="text-danger error-text inputSiteId_error"></span>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="ordersId">PO Number *</label>
                <select class="custom-select" name="ordersId" id="ordersId" onchange="doPoItems(this)" required>
                  <option value="">--Select a PO Number --</option>
                  <?php foreach ($Orders as $order) : ?>
                    <option value="<?= $order['id']; ?>" data-pono="<?= $order['po_no']; ?>"
                      data-siteid="<?= $order['site_id']; ?>">
                      <?= $order['po_no'] . ' - ' . $order['site_id']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <span class="text-danger error-text ordersId_error"></span>
              </div>
            </div>

            <!-- <div class="col-md-3">
              <div class="form-group">
                <label for="itemsIds">Items Name *</label>
                <select class="custom-select" name="itemsIds[]" id="itemsIds" multiple required>
                  <option value="">--Select an Item --</option>
                  </?php foreach ($Items as $Item) : ?>
                    <option value="</?= $Item['id']; ?>">
                      </?= $Item['name']; ?>
                    </option>
                  </?php endforeach; ?>
                </select>
                <span class="text-danger error-text itemsId_error"></span>
              </div>
            </div> -->
          </div>
          <?php $year = (date('m') < 4) ? date('Y') - 1 : date('Y'); ?>
          <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                <label for="start_date">Period From</label>
                <input type="date" class="form-control" name="start_date" value="<?= $year . '-04-01' ?>" required>
                <span class="text-danger error-text start_date_error"></span>
              </div>
            </div>

            <div class="col-md-2">
              <div class="form-group">
                <label for="end_date">Period To</label>
                <div class="form-group">
                  <input type="date" class="form-control" name="end_date" value="<?= date('Y-m-d'); ?>" required>
                  <span class="text-danger error-text end_date_error"></span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <h5>&nbsp; </h5>
                <button type="submit" class="btn btn-success" id="btnSubmit">Search</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<?= $this->include('modals/addSalesModal'); ?>
<?= $this->include('modals/editSalesModal'); ?>
<?= $this->endSection() ?>
<?= $this->section('scripts'); ?>
<script>
  var csrfName = $('meta.csrf').attr('name'); //CSRF TOKEN NAME
  var csrfHash = $('meta.csrf').attr('content'); //CSRF HASH

  const reg = /[\.\*\\/\s!?#%:><~@()[\]]/g;

  // Array holding selected row IDs
  var rows_selected = [];
  var total = 0;
  var having_pair_order = false;

  $('#toggleFilterBtn').on('click', function() {
    $('#salesFilterForm').slideToggle();
  });
  $('#resetFilterBtn').on('click', function() {
    $('#salesFilterForm')[0].reset();
    $('#sales-table').DataTable().ajax.reload();
  });

  function addDays(date, daysToAdd) {
    var d = new Date(date);
    d.setDate(d.getDate() + daysToAdd);
    // Format the future date as 'yyyy-MM-dd'
    var formattedDate = d.toISOString().slice(0, 10);
    return formattedDate;
  }

  function doDueDate(t) {

    var form = $(t).closest('form');
    var date = $(t).val();
    var dueDate = addDays(date, 45);
    $(form).find('input[name="dueDate"]').val(dueDate);
  }

  // function doBillMethod(t) {
  //   var form = $(t).closest('form');
  //   var method = $(t).val();
  //   if (method == 1)
  //     $(form).find('#frt_invDetails').show();
  //   else
  //     $(form).find('#frt_invDetails').hide();
  // }


  function doFrtDueDate(t) {

    var form = $(t).closest('form');
    var date = $(t).val();
    var dueDate = addDays(date, 45);
    $(form).find('input[name="frt_dueDate"]').val(dueDate);
  }

  $('#search-delivery-form').submit(function(e) {
    e.preventDefault();
    var form = this;
    $.ajax({
      url: $(form).attr('action'),
      method: $(form).attr('method'),
      data: new FormData(form),
      processData: false,
      dataType: 'JSON',
      contentType: false,
      success: function(data) {
        if (data.code == 1) {
          if ($.fn.dataTable.isDataTable('#delivery-table')) {
            var table = $('#delivery-table').DataTable();
            table.destroy();
          }
          $('#delivery-table').DataTable({
            data: data.results,
            columns: [{
                data: "id",
              },
              {
                data: "po_no",
              },
              {
                data: "items_name",
              },
              {
                data: "wtmt_date",
              },
              {
                data: "weightment_no",
              },
              {
                data: "approved_qty_mt",
              },
              {
                data: "vehicle_no",
              },
              {
                data: "dc_no",
              }

            ],
            'columnDefs': [{
              'targets': 0,
              'checkboxes': {
                'selectRow': true
              }
            }],
            'select': {
              'style': 'multi'
            },
            'order': [
              [1, 'asc']
            ],
            "iDisplayLength": 5,
            "pageLength": 5,
            "aLengthMenu": [
              [5, 10, 25, 50, -1],
              [5, 10, 25, 50, "All"]
            ],
          });
          var total = 0.000;
          var sId = $("#search-delivery-form").find('#siteId').val();
          var oId = $("#search-delivery-form").find('#ordersId').val();
          var iIds = $("#search-delivery-form").find('#itemsIds').val();
          var sDate = $("#search-delivery-form").find('input[name="start_date"]').val();
          var eDate = $("#search-delivery-form").find('input[name="end_date"]').val();
         // var pairedOrder_id = $("#search-delivery-form").find('input[name="pairedOrder_id"]').val();


          let e = $('.listDelivery').find('form');

          $(e).find('input[name="siteId"]').val(sId);
          $(e).find('input[name="ordersId"]').val(oId);
          $(e).find('input[name="sDate"]').val(sDate);
          $(e).find('input[name="eDate"]').val(eDate);
          // $(e).find('input[name="ids"]').val(iIds);
          
          html = "";
          html2 = "";

          if (data.orders != null) {
           
            for (var i = 0; i < data.orders.length; i++) {

              html += '<tr id ="' + (data.orders[i]['items_name']).replace(reg, '_') +
                '"><input type="hidden" name="items_id[]" class="items_id" value="' + data.orders[i][
                  'items_id'
                ] + '"><input type="hidden" name="items_orders_id[]" class="items_orders_id" value="' + data.orders[i][
                  'orders_id'] + '"><td><input type="text" class="items_name" name="items_name[]" value="' +
                data.orders[i]['items_name'] +
                '" readonly></td><td><input type="text" class="unit" name="unit[]" value="' + // Display unit
                data.orders[i]['unit'] + // unit from orders_items
                '" readonly></td><td><input type = "number" class="items_qty" name ="items_qty[]" value="0.000" min="0"' +
                '  max="9999999999" step=".001" size="12" onchange="doInvAmt(this)"  required>' +
                '</td><td> <input type="text" class="basic_rate" name="basic_rate[]" value="' + data.orders[i][
                  'basic_rate'
                ] +
                '" ></td><td><input type="text" class ="other_charges" name="other_charges[]" value="' +
                data.orders[i]['other_charges'] +
                '" ></td><td><input type="text" class="gst_rate" name="gst_rate[]" value="' + data
                .orders[i]['gst_rate'] + '"></td><td><input type = "number" class="items_amount" name ="items_amount[]" value="0.00" min="0" max="9999999999" step=".01" size="12">' +
                '</td></tr>';
            }
            $('#invoice-items-table tbody').html(html);
          }

          if (data.pair_order != null) {
             having_pair_order = true;
             $(e).find('input[name="frt_order_id"]').val(data.pair_order[0]['orders_id']);
             console.log(data.pair_order[0]['orders_id']);
            for (var i = 0; i < data.pair_order.length; i++) {

              html2 += '<tr id ="' + (data.pair_order[i]['items_name']).replace(reg, '_') +
                '"><input type="hidden" name="items_id[]" class="items_id" value="' + data.pair_order[i][
                  'items_id']  + '"><input type="hidden" name="items_orders_id[]" class="items_orders_id" value="' + data.pair_order[i][
                  'orders_id'] + '"><td><input type="text" class="items_name" name="items_name[]" value="' +
                data.pair_order[i]['items_name'] +
                '" readonly></td><td><input type="text" class="unit" name="unit[]" value="' + // Display unit
                data.pair_order[i]['unit'] + // unit from pair_order_items
                '" readonly></td><td><input type = "number" class="items_qty" name ="items_qty[]" value="0.000" min="0"' +
                '  max="9999999999" step=".001" size="12" onchange="doInvAmt(this)"  required>' +
                '</td><td> <input type="text" class="basic_rate" name="basic_rate[]" value="' + data.pair_order[i][
                  'basic_rate'
                ] +
                '" onchange="doInvAmt(this)"></td><td><input type="text" class ="other_charges" name="other_charges[]" value="' +
                data.pair_order[i]['other_charges'] +
                '" onchange="doInvAmt(this)"></td><td><input type="text" class="gst_rate" name="gst_rate[]" value="' + data
                .pair_order[i]['gst_rate'] + '" onchange="doInvAmt(this)"></td><td><input type = "number" class="items_amount" name ="items_amount[]" value="0.00" min="0" max="9999999999" step=".01" size="12">' +
                '</td></tr>';
            }
            $('#invoice-freight-table tbody').html(html2);
          }

          $('.listDelivery').modal('show');
          if (data.pair_order != null) {
            $('#frt_invDetails').show();
          } else {
            $('#frt_invDetails').hide();
          }
        } else {
          alert(data.msg);
        }

      }
    });
  });


  function setTableValue(value, key, map) {
    e = $("#invoice-items-table tbody tr#" + key);
    $(e).find('td input.items_qty').val(value.toFixed(3));
  }

  $('#invoice-freight-table').on('change', 'input.items_qty', function() {
  updateFirstFrtAmt();
});

  function dototalqty(t) {

    var table = $('#delivery-table').DataTable();
    var form = $(t).closest('form');
    var rows_selected = table.column(0).checkboxes.selected();
    var total = 0;
    var qtys = [];
    var map = new Map();
    $('#invoice-items-table tr').not(':first').each(function() {
      items_name = ($(this).find('td input.items_name').val()).replace(reg, '_');
      map.set(items_name, 0);
    });

    //console.log(map);

    table.rows('.selected').every(function(rowIdx, tableLoop, rowLoop) {
      var d = this.data();
      var items_name = (d.items_name).replace(reg, '_');
      q = (map.get(items_name) * 1000 + parseFloat(d.approved_qty_mt) * 1000) / 1000;
      map.set(items_name, q)
    });

    map.forEach(setTableValue);

    ids = '';
    if (rows_selected.length > 0) {
      $.each(rows_selected, function(index, rowId) {
        if (ids == '') {
          ids = rowId;
        } else {
          ids += ', ' + rowId;
        }
      });

      $(form).find('#ids').val(ids);

      doInvAmt($(form));

      $(form).find('button[type="submit"]').removeAttr('disabled');
    } else {
      $(form).find('button[type="submit"]').attr('disabled', 'disabled');
    }
  }

  $('#sales-table').DataTable({
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": "<?= route_to('list.sales'); ?>",
      "data": function(d) {
        d.date = $('input[name="date"]').val();
        d.inv_no = $('input[name="inv_no"]').val();
        d.site_name = $('select[name="site_name"]').val();
      }
    },
    stateSave: true,
    info: true,
    scrollX: true,
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
    }, {
      className: "text-right",
      targets: [3, 4, 5],
    }],
  });

  $('#salesFilterForm').on('submit', function(e) {
    e.preventDefault();
    $('#sales-table').DataTable().ajax.reload();
  });


  $('#add-sales-form').submit(function(e) {
    e.preventDefault();
    var form = this;

    $.ajax({
      url: $(form).attr('action'),
      method: $(form).attr('method'),
      data: new FormData(form),
      processData: false,
      dataType: 'json',
      contentType: false,
      beforeSend: function() {
        $(form).find('span.error-text').text('');
      },
      success: function(data) {
        if ($.isEmptyObject(data.error)) {
          if (data.code == 1) {
            $(form)[0].reset();
            $('#sales-table').DataTable().ajax.reload(null, false);
            $('.listDelivery').modal('hide');
            // alert(data.msg);
          } else {
            alert(data.msg);
          }
        } else {
          $.each(data.error, function(prefix, val) {
            $(form).find('span.' + prefix + '_error').text(val);
          });
        }
      }
    });
  });


  function doSiteId(t, orders_id = "", items_id = "") {
    if ($(t).is(':input')) {
      var e = $(t).closest('form');
    } else {
      var e = $(t);
    }
    var site_id = $(e).find('#siteId').val();
    // console.log('site_id :' + site_id);
    if (site_id != "") {
      $.post("<?= route_to('get.orders.bysiteid') ?>", {
        site_id: site_id,
        [csrfName]: csrfHash
      }, function(data) {
        html = "";
        if (data.results != null) {
          for (var i = 0; i < data.results.length; i++) {
            html += '<option value="' + data.results[i]['id'] + '" ' + ((data.results[i]['id'] == orders_id) ?
                'selected = "selected"' :
                '') +
              '>' +
              data.results[i]['po_no'] + '</option>';
          }
          $(e).find('#ordersId').html(html).css({
            "border": "2px solid green"
          });
          doPoItems(t, items_id);
        } else {
          $(e).find('#ordersId').html('<option value="">Not Available </option>');
          $(e).find('#itemsId').html('<option value="">Not Available </option>');
        }
      }, 'json');
    } else {
      $(e).find('#ordersId').html('<option value="">Not Available </option>');
      $(e).find('#itemsId').html('<option value="">Not Available </option>');
    }
  }

  function doInvAmt(t) {
    if ($(t).is(':input')) {
      var e = $(t).closest('form');
    } else {
      var e = $(t);
    }
    var qty = 0,
      rate = 0,
      oc = 0,
      gstrate = 0,
      basicAmt = 0,
      gstAmt = 0,
      invAmt = 0,
      tQty = 0,
      tBasicAmt = 0,
      tGstAmt = 0,
      tInvAmt = 0;
    $('#invoice-items-table tr').not(':first').each(function() {
      qty = parseFloat($(this).find('td input.items_qty').val());
      rate = parseFloat($(this).find('td input.basic_rate').val());
      oc = parseFloat($(this).find('td input.other_charges').val());
      gstrate = parseFloat($(this).find('td input.gst_rate').val());
      basicAmt = (qty * (rate * 1000 + oc * 1000) / 1000);
      gstAmt = basicAmt * gstrate / 100;
      itemAmt = (basicAmt * 1000 + gstAmt * 1000) / 1000;
      $(this).find('td input.items_amount').val(itemAmt.toFixed(2));
      tQty += qty;
      // console.log('basicAmt : ' + basicAmt + " gstAmt : " + gstAmt + " invAmt " + invAmt + "/n");
      tBasicAmt += basicAmt * 1000;
      tGstAmt += gstAmt * 1000;
      tInvAmt = tBasicAmt + tGstAmt;
    });
    $(e).find('input[name="basicAmt"]').val((tBasicAmt / 1000).toFixed(2));
    $(e).find('input[name="gstAmt"]').val((tGstAmt / 1000).toFixed(2));
    $(e).find('input[name="invAmt"]').val((tInvAmt / 1000).toFixed(2));

    var ftBasicAmt = 0,
        ftGstAmt = 0,
        ftInvAmt = 0;

    // Save current total qty for freight-row fallback when qty is zero
    window.currentInvQty = tQty;

    if (having_pair_order) {
      $('#invoice-freight-table tr').first().each(updateFrtAmt);
      // totals are updated inside updateFrtTotals
      updateFrtTotals(e);
    } else {
      $(e).find('input[name="frt_basicAmt"]').val((ftBasicAmt / 1000).toFixed(2));
      $(e).find('input[name="frt_gstAmt"]').val((ftGstAmt / 1000).toFixed(2));
      $(e).find('input[name="frt_invAmt"]').val((ftInvAmt / 1000).toFixed(2));
    }
  }

function updateFrtAmt(index, row) {
    var $row = row ? $(row) : $(this);
    var tQty = window.currentInvQty || 0;

    var qtyVal = parseFloat($row.find('td input.items_qty').val());
    var qty = (qtyVal === 0 || isNaN(qtyVal)) ? tQty : qtyVal;
    if (qty === 0) {
      $row.find('td input.items_qty').val('0.000');
    } else {
      $row.find('td input.items_qty').val(qty.toFixed(3));
    }

    var rate = parseFloat($row.find('td input.basic_rate').val()) || 0;
    var oc = parseFloat($row.find('td input.other_charges').val()) || 0;
    var gstrate = parseFloat($row.find('td input.gst_rate').val()) || 0;

    var basicAmt = (qty * (rate * 1000 + oc * 1000) / 1000);
    var gstAmt = basicAmt * gstrate / 100;
    var itemAmt = (basicAmt * 1000 + gstAmt * 1000) / 1000;

    $row.find('td input.items_amount').val(itemAmt.toFixed(2));
}

function updateFrtTotals(form) {
    var $form = $(form);
    var ftBasicAmt = 0;
    var ftGstAmt = 0;
    var ftInvAmt = 0;

    $('#invoice-freight-table tr').each(function() {
        var qty = parseFloat($(this).find('td input.items_qty').val()) || 0;
        var rate = parseFloat($(this).find('td input.basic_rate').val()) || 0;
        var oc = parseFloat($(this).find('td input.other_charges').val()) || 0;
        var gstrate = parseFloat($(this).find('td input.gst_rate').val()) || 0;

        var basicAmt = (qty * (rate * 1000 + oc * 1000) / 1000);
        var gstAmt = basicAmt * gstrate / 100;

        ftBasicAmt += basicAmt * 1000;
        ftGstAmt += gstAmt * 1000;
    });

    ftInvAmt = ftBasicAmt + ftGstAmt;

    $form.find('input[name="frt_basicAmt"]').val((ftBasicAmt / 1000).toFixed(2));
    $form.find('input[name="frt_gstAmt"]').val((ftGstAmt / 1000).toFixed(2));
    $form.find('input[name="frt_invAmt"]').val((ftInvAmt / 1000).toFixed(2));
}

function updateFirstFrtAmt() {
  $('#invoice-freight-table tr').first().each(updateFrtAmt);
  updateFrtTotals($('.listDelivery form')); // adjust selector to your form scope
}

  function doPoItems(t, items_id = "") {
    if ($(t).is(':input')) {
      var e = $(t).closest('form');
    } else {
      var e = $(t);
    }
    var orders_id = $(e).find('#ordersId').val();
    if (orders_id != "") {
      $.post("<?= route_to('get.orders.info') ?>", {
        orders_id: orders_id,
        [csrfName]: csrfHash
      }, function(data) {
        html = "";
        if (data.ordersItems != null) {
          for (var i = 0; i < data.ordersItems.length; i++) {
            html += '<option value="' + data.ordersItems[i]['items_id'] + '" ' + ((data.ordersItems[i][
                  'items_id'
                ] ==
                items_id) ? 'selected = "selected"' :
              '') + '>' + data.ordersItems[i]['items_name'] + '</option>';
          }
          $(e).find('#itemsIds').html(html).css({
            "border": "2px solid green"
          });
          //  doPoId(e);
        } else {
          $(e).find('#itemsIds').html('<option value="">Not Available </option>');
        }
      }, 'json');
    } else {
      $(e).find('#itemsIds').html('<option value="">Not Available </option>');
    }

  }

  $(document).on('click', '#deleteSalesBtn', function() {
    <?php if (!auth()->user()->can('users.create')) { ?>
      alert('You Are Not Allowed to Delete');
      return;
    <?php } ?>

    var cid = $(this).data('id');
    var url = "<?= route_to('delete.sales'); ?>";

    swal.fire({

      title: 'Are you sure?',
      html: 'You want to delete this Invoice id : ' + cid,
      showCloseButton: true,
      showCancelButton: true,
      cancelButtonText: 'Cancel',
      confirmButtonText: 'Yes, delete',
      cancelButtonColor: '#d33',
      confirmButtonColor: '#556eeb',
      width: 300,
      allowOutsideClick: false

    }).then(function(result) {
      if (result.value) {

        $.post(url, {
            [csrfName]: csrfHash,
            cid: cid
          }, function(data) {
            if (data.code == 1) {
              alert(data.msg);
              $('#sales-table').DataTable().ajax.reload(null, false);
            } else {
              alert(data.msg);
            }
          }, 'json')
          .fail(function(response) {
            alert('Error: ' + response.responseText);
          });
      }
    });
  });

  $(document).on('click', '#updateSalesBtn', function() {
    var cid = $(this).data('id');
    <?php if (!auth()->user()->can('users.create')) {  ?>
      alert('You Are Not Allowed to Update');
      return;
    <?php } ?>
    $.post("<?= route_to('get.info.sales') ?>", {
      cid: cid,
      [csrfName]: csrfHash
    }, function(data) {
      var e = $('.editSales').find('form');
      $(e).find('input[name="cid"]').val(data.results.id)
      $(e).find('#invNo1').val(data.results.inv_no);
      $(e).find('#invDate1').val(data.results.date);
      $(e).find('#dueDate1').val(data.results.due_date);
      // $(e).find('#tQty1').val(data.results.qty);
      $(e).find('#basicAmt1').val(data.results.basic_amt);
      $(e).find('#gstAmt1').val(data.results.gst_amt);
      $(e).find('#invAmt1').val(data.results.inv_amt);
      $(e).find('#inv_reg_no1').val(data.results.inv_reg_no);
      $(e).find('#inv_reg_date1').val(data.results.inv_reg_date);
      // $(e).find('#recdDate1').val(data.results.recd_date);
      // $(e).find('#tdsAmt1').val(data.results.tds_amt);
      // $(e).find('#recdAmt1').val(data.results.recd_amt);
      // $(e).find('#balAmt1').val(data.results.bal_amt);
      // $(e).find('#remarks1').val(data.results.remarks);

      // $(e).find('#basic_rate1').val(data.orders.basic_rate);
      // $(e).find('#other_charges1').val(data.orders.other_charges);
      // $(e).find('#gst_rate1').val(data.orders.gst_rate);

      $(e).find('span.error-text').text('');
      $('.editSales').modal('show');
    }, 'json');


  });

  $('#update-sales-form').submit(function(e) {
    e.preventDefault();
    var form = this;

    $.ajax({
      url: $(form).attr('action'),
      method: $(form).attr('method'),
      data: new FormData(form),
      processData: false,
      dataType: 'json',
      contentType: false,
      beforeSend: function() {
        $(form).find('span.error-text').text('');
      },
      success: function(data) {
        if ($.isEmptyObject(data.error)) {
          if (data.code == 1) {
            $('#sales-table').DataTable().ajax.reload(null, false);
            $('.editSales').modal('hide');
          } else {
            alert(data.msg);
          }
        } else {
          $.each(data.error, function(prefix, val) {
            $(form).find('span.' + prefix + '_error').text(val);
          });
        }
      }
    });
  });
</script>

<script src="plugins/datatables-select/js/dataTables.select.min.js"></script>
<script src="plugins/datatables-select/js/select.bootstrap4.min.js"></script>
<script type="text/javascript" src="plugins/jquery-datatables-checkboxes/js/dataTables.checkboxes.min.js"></script>
<?= $this->endSection(); ?>