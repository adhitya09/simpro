<?php
$bul = filter_input(INPUT_GET, 'month', FILTER_VALIDATE_INT) ?? date('m');
$year = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT) ?? date('Y');
$inputresult = isset($_GET['result']) ? $_GET['result'] : '';

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

// Build the WHERE clause dynamically
$where = "WHERE YEAR(date(date)) = '" . mysqli_real_escape_string($koneksi, $year) . "' AND MONTH(date(date)) = '" . mysqli_real_escape_string($koneksi, $bul) . "'";

// Tambahkan filter result jika pengguna memilih salah satu kategori (1, 2, atau 3)
if ($inputresult != "" && in_array($inputresult, ['1', '2', '3'])) {
  $where .= " AND result='" . mysqli_real_escape_string($koneksi, $inputresult) . "' ";
}

// SQL Query with WHERE clause
$query = mysqli_query($koneksi, "SELECT * FROM cip $where");

?>
<!-- HTML Form for Filters -->

<!-- Nav Header Component Start -->
<div class="iq-navbar-header" style="height: 215px">
  <div class="container-fluid iq-container">
    <div class="row">
      <div class="col-md-12">
        <div
          class="flex-wrap d-flex justify-content-between align-items-center">
          <div>
            <h1>Report CIP</h1>
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

<form method="get">
  <input type="hidden" name="page" value="reports/r.kpi/r.cip">
  <div class="row">
    <div class="col-lg-6">
      <label class="form-label">Report Date</label>
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
    <div class="col-lg-4">
      <label class="form-label" for="result">Result:</label>
      <select name="result" class="form-select shadow-none">
        <option value="" <?php if ($inputresult == '') echo 'selected'; ?>>-All Results-</option>
        <option value="1" <?php if ($inputresult == '1') echo 'selected'; ?>>Bronze</option>
        <option value="2" <?php if ($inputresult == '2') echo 'selected'; ?>>Silver</option>
        <option value="3" <?php if ($inputresult == '3') echo 'selected'; ?>>Gold</option>
      </select>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-md-12 login-btn-inner">
      <button type="submit" class="btn btn-primary login-submit-cs">
        <i class="fa fa-filter"></i> Filter Report
      </button>
      <button type="reset" class="btn btn-secondary">
        <i class="fa fa-refresh"></i> Reset Filter
      </button>
      <a href="views/pages/reports/r.kpi/r.cip_data.php?type=excel&&month=<?php echo $bul; ?>&year=<?php echo $year; ?>&result=<?php echo $inputresult; ?>" target="_blank" class="btn btn-success">
        <i class="fa fa-file-excel-o"></i> Export Excel
      </a>
      <a href="views/pages/reports/r.kpi/r.cip_data.php?type=print&&month=<?php echo $bul; ?>&year=<?php echo $year; ?>&result=<?php echo $inputresult; ?>" target="_blank" class="btn btn-danger">
        <i class="fa fa-print"></i> Print
      </a>
    </div>
  </div>
</form>

<!-- Display Data -->
<table id="datatable" class="table table-striped" data-toggle="data-table">
  <thead>
    <tr>
      <th>No</th>
      <th>Date</th>
      <th>Title</th>
      <th>Member</th>
      <th>Upload Treatise</th>
      <th>Result</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $i = 1;
    while ($data = mysqli_fetch_array($query)) {
    ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $data['date']; ?></td>
        <td><?php echo $data['title']; ?></td>
        <td>
          <ol style="padding-left: 12px">
            <?php
            if ($data['technician']) {
              $techa = explode(',', $data['technician']);
              foreach ($techa as $techa_id) {
                $q = $koneksi->query("SELECT * FROM teknisi WHERE id_teknisi = $techa_id");
                $teknisi = $q->fetch_array();
                if ($teknisi) {
                  echo '<li>' . $teknisi['nama'] . '</li>';
                }
              }
            }
            ?>
          </ol>
        </td>
        <td><?php echo $data['upload_treatise']; ?></td>
        <td>
          <?php
          switch ($data['result']) {
            case 1:
              echo '<div style="color: brown;text-decoration: underline">Bronze</div>';
              break;
            case 2:
              echo '<div style="color: silver;text-decoration: underline">Silver</div>';
              break;
            case 3:
              echo '<div style="color: yellow;text-decoration: underline">Gold</div>';
              break;
          }
          ?>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>