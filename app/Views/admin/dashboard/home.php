<?= $this->extend('layout/dashboard-layout'); ?>
<?= $this->section('content'); ?>
<div class="row">
  <div class="col-md-4 col-lg-3">
    <div class="small-box bg-gradient-success">
      <div class="inner">
        <h3><?= $UsersNos ?></h3>
        <p>Users</p>
      </div>
      <div class="icon">
        <i class="fas fa-address-book"></i>
      </div>
      <a href="<?= route_to('list.users') ?>" class="small-box-footer">
        More info <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-md-4 col-lg-3">
    <div class="small-box bg-gradient-warning">
      <div class="inner">
        <h3><?= $PartyNos ?></h3>
        <p>Party</p>
      </div>
      <div class="icon">
        <i class="far fa-address-card"></i>
      </div>
      <a href="<?= route_to('parties') ?>" class="small-box-footer">
        More info <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-md-4 col-lg-3">
    <div class="small-box bg-success">
      <div class="inner">
        <h3><?= $ItemsNos ?></h3>
        <p>Items</p>
      </div>
      <div class="icon">
        <i class="fas fa-boxes"></i>
      </div>
      <a href="<?= route_to('list.items') ?>" class="small-box-footer">
        More info <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-md-4 col-lg-3">
    <div class="small-box bg-danger">
      <div class="inner">
        <h3><?= $SitesNos ?></h3>
        <p>Project/Sites</p>
      </div>
      <div class="icon">
        <i class="fas fa-chart-pie"></i>
      </div>
      <a href="<?= route_to('list.site') ?>" class="small-box-footer">More info <i
          class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-4 col-lg-3">
    <div class="small-box bg-gradient-info">
      <div class="inner">
        <h3><?= $OrdersNos ?></h3>
        <p>Orders</p>
      </div>
      <div class="icon">
        <i class="far fa-edit"></i>
      </div>
      <a href="<?= route_to('list.orders') ?>" class="small-box-footer">
        More info <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-md-4 col-lg-3">
    <div class="small-box bg-gradient-orange">
      <div class="inner">
        <h3><?= $DeliveryNos ?></h3>
        <p>Delivery</p>
      </div>
      <div class="icon">
        <i class="fas fa-truck-pickup"></i>
      </div>
      <a href="<?= route_to('list.delivery') ?>" class="small-box-footer">
        More info <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-md-4 col-lg-3">
    <div class="small-box bg-gradient-primary">
      <div class="inner">
        <h3><?= $SalesNos ?></h3>
        <p>Sales</p>
      </div>
      <div class="icon">
        <i class="fas fa-clipboard-check"></i>
      </div>
      <a href="<?= route_to('sales') ?>" class="small-box-footer">
        More info <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-md-4 col-lg-3">
    <div class="small-box bg-gradient-pink">
      <div class="inner">
        <h3><?= $PurchasesNos ?></h3>
        <p>Purchases</p>
      </div>
      <div class="icon">
        <i class="fas fa-warehouse"></i>
      </div>
      <a href="<?= route_to('purchases') ?>" class="small-box-footer">
        More info <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
</div>

<!-- Monthly Sales Bar Chart -->
<div class="row">
  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">Monthly Sales Comparison (2024-25 vs 2025-26 vs 2026-27)</h3>
      </div>
      <div class="card-body">
        <canvas id="monthlySalesChart" height="100"></canvas>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- <script src="plugins/chart.js/Chart.js"></script> -->
<script>
$(function() {
  $.getJSON("<?= site_url('sales/monthly-data') ?>", function(data) {
    const ctx = document.getElementById('monthlySalesChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: data.labels,
        datasets: [{
            label: '2024-25',
            data: data.sales_2024_25,
            backgroundColor: 'rgba(18, 230, 85, 0.7)'
          },
          {
            label: '2025-26',
            data: data.sales_2025_26,
            backgroundColor: 'rgba(255, 99, 132, 0.7)'
          },
          {
            label: '2026-27',
            data: data.sales_2026_27,
            backgroundColor: 'rgba(249, 9, 233, 0.7)'
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top'
          },
          title: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  });
});
</script>
<?= $this->endSection(); ?>