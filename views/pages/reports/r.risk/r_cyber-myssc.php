<?php
// Aktifkan penampilan error untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Filter input untuk bulan, tahun, dan status
$bul = filter_input(INPUT_GET, 'month', FILTER_VALIDATE_INT) ?? date('m');
$year = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT) ?? date('Y');
$inputStatus = isset($_GET['status']) ? $_GET['status'] : '';

$bulans = array(
  '1' => 'Januari',
  '2' => 'Februari',
  '3' => 'Maret',
  '4' => 'April',
  '5' => 'Mei',
  '6' => 'Juni',
  '7' => 'Juli',
  '8' => 'Agustus',
  '9' => 'September',
  '10' => 'Oktober',
  '11' => 'November',
  '12' => 'Desember',
);
?>

<div class="iq-navbar-header" style="height: 215px">
  <div class="container-fluid iq-container">
    <div class="row">
      <div class="col-md-12">
        <div class="flex-wrap d-flex justify-content-between align-items-center">
          <div>
            <h1>Report MYSSC</h1>
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
      <form method="get">
        <input type="hidden" name="page" value="reports/r.risk/r_cyber-myssc">
        <div class="row">
          <div class="col-md-4" style="margin-bottom: 10px">
            <label>Report Date</label>
            <div class="input-group">
              <select name="month" class="form-control">
                <?php foreach ($bulans as $key => $bulan) { ?>
                  <option value="<?php echo $key; ?>" <?php if ($bul == $key) echo 'selected'; ?>><?php echo $bulan; ?></option>
                <?php } ?>
              </select>
              <span class="input-group-addon" style="border: 0"></span>
              <select name="year" class="form-control">
                <?php for ($i = date('Y'); $i > 2023; $i--) { ?>
                  <option value="<?php echo $i; ?>" <?php if ($year == $i) echo 'selected'; ?>><?php echo $i; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-3" style="margin-bottom: 10px">
            <label>Status</label>
            <select name="status" class="form-control">
              <option value="">- All Status -</option>
              <option <?php if ($inputStatus == 1) echo 'selected'; ?> value="1">Open</option>
              <option <?php if ($inputStatus == 2) echo 'selected'; ?> value="2">In Progress</option>
              <option <?php if ($inputStatus == 3) echo 'selected'; ?> value="3">Hold</option>
              <option <?php if ($inputStatus == 4) echo 'selected'; ?> value="4">Done</option>
              <option <?php if ($inputStatus == 5) echo 'selected'; ?> value="5">Cancel</option>
            </select>
          </div>
          <div class="col-md-12 login-btn-inner">
            <button type="submit" class="btn btn-primary login-submit-cs"><i class="fa fa-filter"></i> Filter Report</button>
            <a href="views/pages/reports/r.risk/r_cyber-myssc_data.php?type=excel&&month=<?php echo $bul; ?>&year=<?php echo $year; ?>&status=<?php echo $inputStatus; ?>" target="_blank" class="btn btn-success" style="border-radius: 0"><i class="fa fa-file-excel-o"></i> Export Excel</a>
            <a href="views/pages/reports/r.risk/r_cyber-myssc_data.php?type=print&&month=<?php echo $bul; ?>&year=<?php echo $year; ?>&status=<?php echo $inputStatus; ?>" target="_blank" class="btn btn-danger" style="border-radius: 0"><i class="fa fa-print"></i> Print</a>
          </div>
        </div>
      </form>

      <table id="datatable" class="table table-striped" data-toggle="data-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Date</th>
            <th>Unexpected Event</th>
            <th>Major Risks</th>
            <th>Risk Mitigation</th>
            <th>Progress</th>
            <th>Ticket Created</th>
            <th>Ticket Realized</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          $where = "WHERE YEAR(date) = '" . mysqli_real_escape_string($koneksi, $year) . "' 
                          AND MONTH(date) = '" . mysqli_real_escape_string($koneksi, $bul) . "'";

          if ($inputStatus != "") {
            $where .= " AND status='" . mysqli_real_escape_string($koneksi, $inputStatus) . "'";
          }

          $query = mysqli_query($koneksi, "SELECT * FROM cyb_myssc $where");
          while ($data = mysqli_fetch_array($query)) {
          ?>
            <tr>
              <td>
                <p><?php echo $i++; ?></p>
              </td>
              <td>
                <p><?php echo htmlspecialchars($data['date']); ?></p>
              </td>
              <td><?php echo (strlen($data['event']) > 60) ? substr($data['event'], 0, 60) . '...' : $data['event']; ?></td>
              <td><?php echo (strlen($data['risk']) > 60) ? substr($data['risk'], 0, 60) . '...' : $data['risk']; ?></td>
              <td><?php echo (strlen($data['mitigation']) > 60) ? substr($data['mitigation'], 0, 60) . '...' : $data['mitigation']; ?></td>
              <td><?php echo (strlen($data['progres']) > 60) ? substr($data['progres'], 0, 60) . '...' : $data['progres']; ?></td>
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
                      echo '<span style="color: blue;text-decoration: underline">Open</span>';
                      break;
                    case 2:
                      echo '<span class="text-info" style="text-decoration: underline">Progress</span>';
                      break;
                    case 3:
                      echo '<span style="color: orangered;text-decoration: underline">Hold</span>';
                      break;
                    case 4:
                      echo '<span style="color: green;text-decoration: underline">Done</span>';
                      break;
                    case 5:
                      echo '<span style="color: red;text-decoration: underline">Cancel</span>';
                      break;
                  }
                  ?>
                </p>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>