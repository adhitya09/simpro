<?php

// Pastikan koneksi tersedia
if (!isset($koneksi)) {
  die('Database connection not initialized.');
}

// Ambil role dari session
$role = $_SESSION['user']['role'] ?? null;

// Query berdasarkan role
$where = "";
if ($role != 1) { // Jika bukan admin, tampilkan data berdasarkan id_user
  $id_user = $koneksi->real_escape_string($_SESSION['user']['id_user']);
  $where = "WHERE id_user = '$id_user'";
}
$query = $koneksi->query("SELECT * FROM cyb_myssc $where");

// Tampilkan error jika query gagal
if (!$query) {
  die('Query Error: ' . $koneksi->error);
}
?>

<!-- Nav Header Component Start -->
<div class="iq-navbar-header" style="height: 215px">
  <div class="container-fluid iq-container">
    <div class="row">
      <div class="col-md-12">
        <div class="flex-wrap d-flex justify-content-between align-items-center">
          <div>
            <h1>Cyber Security (MYSSC)</h1>
          </div>
          <div>
            <a href="index.php?page=riskmanagement/cybersecurity/tambahcybermyssc" class="btn btn-primary btn-soft-light">
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
<!-- Nav Header Component End -->

<div class="col-12">
  <div class="card">
    <div class="card-body">
      <table id="datatable" class="table table-striped" data-toggle="data-table">
        <thead>
          <tr>
            <th data-field="id_myssc" data-width="1">No</th>
            <th data-field="date">Date</th>
            <th data-field="event">Unexpected Event</th>
            <th data-field="risk">Major Risks</th>
            <th data-field="mitigation">Risk Mitigation</th>
            <th data-field="progres">Progress</th>
            <th data-field="tc">Ticket Created</th>
            <th data-field="tr">Ticket Resolved</th>
            <th data-field="status" data-align="center">Status</th>
            <th data-field="action" data-width="150">Action</th>
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
              <?php echo (strlen($data['event']) > 60) ? substr($data['event'], 0, 60) . '...' : $data['event']; ?>
              </td>
              <td><?php echo (strlen($data['risk']) > 60) ? substr($data['risk'], 0, 60) . '...' : $data['risk']; ?></td>
              <td>
              <?php echo (strlen($data['mitigation']) > 60) ? substr($data['mitigation'], 0, 60) . '...' : $data['mitigation']; ?>
              </td>
              <td><?php echo (strlen($data['progres']) > 60) ? substr($data['progres'], 0, 60) . '...' : $data['progres']; ?>
              <td>
                <p><?php echo htmlspecialchars($data['tc']); ?></p>
              </td>
              <td>
                <p><?php echo htmlspecialchars($data['tr']); ?></p>
              </td>
              <td>
                <p>
                  <?php
                  switch ($data['status']) {
                    case 1:
                      echo '<img src="/simpro/html/assets/images/icon_status/open.png" style="width: 30px; height: 30px;">';
                      break;
                    case 2:
                      echo '<img src="/simpro/html/assets/images/icon_status/progress.png"  style="width: 30px; height: 30px;">';
                      break;
                    case 3:
                      echo '<img src="/simpro/html/assets/images/icon_status/pending.png"  style="width: 30px; height: 30px;">';
                      break;
                    case 4:
                      echo '<img src="/simpro/html/assets/images/icon_status/done.png"  style="width: 30px; height: 30px;">';
                      break;
                    case 5:
                      echo '<img src="/simpro/html/assets/images/icon_status/cancel.png"  style="width: 30px; height: 30px;">';
                      break;
                  }
                  ?>
                </p>
              </td>
              <td>
                <p>
                  <a href="?page=riskmanagement/cybersecurity/ubahcyber-myssc&&id=<?php echo $data['id_myssc']; ?>" class="btn btn-warning" style="color: #FFF;">
                    <i class="fa fa-pencil-square"></i>
                  </a>
                  <?php
                  if ($role == "1") { ?>
                    <a href="?page=riskmanagement/cybersecurity/hapuscyber-myssc&&id=<?php echo $data['id_myssc']; ?>" class="btn btn-danger" style="color: #FFF;" onclick="return confirm('Are you sure to delete this data?')">
                      <i class="fa fa-remove"></i>
                    </a>
                  <?php
                  }
                  ?>
                </p>
              </td>

            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>