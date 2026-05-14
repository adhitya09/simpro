<?php
// Pastikan koneksi tersedia
if (!isset($koneksi)) {
  die('Database connection not initialized.');
}

// Ambil role dan id_user dari session
$role = $_SESSION['user']['role'] ?? null;
$id_user = $_SESSION['user']['id_user'] ?? null;

// Query berdasarkan role
$where = "";
if ($role != 1) { // Jika bukan admin, tampilkan data berdasarkan id_user
  $id_user = $koneksi->real_escape_string($id_user);
  $where = "WHERE id_user = '$id_user'";
}
$query = $koneksi->query("SELECT * FROM cyber $where");

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
        <div
          class="flex-wrap d-flex justify-content-between align-items-center">
          <div>
            <h1>Cyber Security (Local)</h1>
          </div>
          <div>
            <a href="index.php?page=riskmanagement/cybersecurity/tambahcyber" class="btn btn-primary btn-soft-light">
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
            <th>No</th>
            <th>Date</th>
            <th>Unexpected Event</th>
            <th>Major Risks</th>
            <th>Risk Mitigation</th>
            <th>Progress</th>
            <th>Status</th>
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
                <p><?php echo $data['date']; ?></p>
              </td>
              <td>
              <?php echo (strlen($data['event']) > 60) ? substr($data['event'], 0, 60) . '...' : $data['event']; ?>
              </td>
              <td><?php echo (strlen($data['risk']) > 60) ? substr($data['risk'], 0, 60) . '...' : $data['risk']; ?></td>
              <td>
              <?php echo (strlen($data['mitigation']) > 60) ? substr($data['mitigation'], 0, 60) . '...' : $data['mitigation']; ?>
              </td>
              <td><?php echo (strlen($data['prg']) > 60) ? substr($data['prg'], 0, 60) . '...' : $data['prg']; ?>
              <td>
                <p>
                  <?php
                  switch ($data['status']) {
                    case 1:
                      echo '<img src="/simpro/html/assets/images/icon_status/open.png" style="width: 30px; height: 30px;">';
                      break;
                    case 2:
                      echo '<img src="/simpro/html/assets/images/icon_status/progress.png" style="width: 30px; height: 30px;">';
                      break;
                    case 3:
                      echo '<img src="/simpro/html/assets/images/icon_status/pending.png" style="width: 30px; height: 30px;">';
                      break;
                    case 4:
                      echo '<img src="/simpro/html/assets/images/icon_status/done.png" style="width: 30px; height: 30px;">';
                      break;
                    case 5:
                      echo '<img src="/simpro/html/assets/images/icon_status/cancel.png" style="width: 30px; height: 30px;">';
                      break;
                  }
                  ?>
                </p>
              </td>
              <td>
                <p>
                  <a href="?page=riskmanagement/cybersecurity/ubahcyber&id=<?php echo $data['id_cyber']; ?>" class="btn btn-warning" style="color: #FFF;"><i class="fa fa-pencil-square"></i></a>
                  <?php
                  if ($role == "1") { ?>
                    <a href="?page=riskmanagement/cybersecurity/hapuscyber&id=<?php echo $data['id_cyber']; ?>" class="btn btn-danger" style="color: #FFF;" onclick="return confirm('Are you sure to delete this data?')"><i class="fa fa-remove"></i></a>
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