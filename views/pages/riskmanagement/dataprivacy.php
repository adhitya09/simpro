<?php

// Pastikan koneksi tersedia
if (!isset($koneksi)) {
  die('Database connection not initialized.');
}

// Pastikan $role sudah didefinisikan
$role = $_SESSION['user']['role'] ?? null;

// Query berdasarkan role
$where = "";
if ($role != 1) {
  $where = $koneksi->real_escape_string($_SESSION['user']['id_user']);
  $query = $koneksi->query("
    SELECT dataprivat.*, user.nama 
    FROM dataprivat
    LEFT JOIN user ON user.id_user = dataprivat.id_user
    WHERE dataprivat.id_user = '$where'
  ");
} else {
  $query = $koneksi->query("
    SELECT dataprivat.*, user.nama 
    FROM dataprivat
    LEFT JOIN user ON user.id_user = dataprivat.id_user
  ");
}

// Tampilkan error jika query gagal
if (!$query) {
  die('Query Error: ' . $koneksi->error);
}
?>

<div class="iq-navbar-header" style="height: 215px">
  <div class="container-fluid iq-container">
    <div class="row">
      <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h1>Data & Privacy</h1>
          </div>
          <div>
            <a href="?page=riskmanagement/tambahdataprivat" class="btn btn-primary btn-soft-light">
              Add Data +
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="iq-header-img">
    <img
      src="/simpro/html/assets/images/dashboard/top-header.png"
      alt="header"
      class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX" />
    <img
      src="/simpro/html/assets/images/dashboard/top-header1.png"
      alt="header"
      class="theme-color-purple-img img-fluid w-100 h-100 animated-scaleX" />
    <img
      src="/simpro/html/assets/images/dashboard/top-header2.png"
      alt="header"
      class="theme-color-blue-img img-fluid w-100 h-100 animated-scaleX" />
    <img
      src="/simpro/html/assets/images/dashboard/top-header3.png"
      alt="header"
      class="theme-color-green-img img-fluid w-100 h-100 animated-scaleX" />
    <img
      src="/simpro/html/assets/images/dashboard/top-header4.png"
      alt="header"
      class="theme-color-yellow-img img-fluid w-100 h-100 animated-scaleX" />
    <img
      src="/simpro/html/assets/images/dashboard/top-header5.png"
      alt="header"
      class="theme-color-pink-img img-fluid w-100 h-100 animated-scaleX" />
  </div>
</div>

<div class="col-12">
  <div class="card">
    <div class="card-body">
      <table id="datatable" class="table table-striped" data-toggle="data-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Date</th>
            <th>Ticket Number</th>
            <th>Description of Attacks</th>
            <th>IP Source</th>
            <th>Hostname</th>
            <th>ID User</th>
            <th>Ticket Created</th>
            <th>Ticket Resolved</th>
            <th>Action Taken</th>
            <th>Status</th>
            <th>Officer</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          while ($data = $query->fetch_array()) {
          ?>
            <tr>
              <td>
                <p><?php echo $i++; ?></p>
              </td>
              <td>
                <p><?php echo htmlspecialchars($data['date']); ?></p>
              </td>
              <td>
                <p><?php echo htmlspecialchars($data['ticket_number']); ?></p>
              </td>
              <td>
                <?php
                echo !empty($data['description_of_attacks'])
                  ? (strlen($data['description_of_attacks']) > 60
                    ? substr($data['description_of_attacks'], 0, 60) . '...'
                    : $data['description_of_attacks'])
                  : '-';
                ?>
              </td>
              <td>
                <p><?php echo htmlspecialchars($data['ip_source']); ?></p>
              </td>
              <td>
                <p><?php echo htmlspecialchars($data['hostname']); ?></p>
              </td>
              <td>
                <p><?php echo htmlspecialchars($data['user_id']); ?></p>
              </td>
              <td>
                <p><?php echo htmlspecialchars($data['datetime_created']); ?></p>
              </td>
              <td>
                <p><?php echo htmlspecialchars($data['datetime_resolved']); ?></p>
              </td>
              <td>
                <?php
                echo !empty($data['description_of_attacks'])
                  ? (strlen($data['description_of_attacks']) > 60
                    ? substr($data['description_of_attacks'], 0, 60) . '...'
                    : $data['description_of_attacks'])
                  : '-';
                ?>
              </td>

              <td>
                <p>
                  <?php
                  $status_icons = [
                    1 => 'open.png',
                    2 => 'progress.png',
                    3 => 'pending.png',
                    4 => 'done.png',
                    5 => 'cancel.png',
                  ];
                  $icon_path = $status_icons[$data['status']] ?? 'default.png';
                  echo "<img src='/simpro/html/assets/images/icon_status/$icon_path' style='width: 30px; height: 30px;'>";
                  ?></p>
              </td>
              <td>
                <p><?php echo $data['nama']; ?></p>
              </td>
              <td>
                <p>
                  <a href="?page=riskmanagement/ubahdataprivat&id=<?php echo isset($data['id']) ? $data['id'] : ''; ?>" class="btn btn-warning" style="color: #FFF;">
                    <i class="fa fa-pencil-square"></i>
                  </a>
                  <?php if ($role == "1") { ?>
                    <a href="?page=riskmanagement/hapusdataprivat&id=<?php echo isset($data['id']) ? $data['id'] : ''; ?>" class="btn btn-danger" style="color: #FFF;" onclick="return confirm('Are you sure to delete this data?')">
                      <i class="fa fa-remove"></i>
                    </a>
                  <?php } ?>
                </p>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- DataTables Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function() {
    $('#datatable').DataTable();
  });
</script>