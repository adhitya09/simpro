<?php
// Aktifkan penampilan error untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<div class="iq-navbar-header" style="height: 215px">
  <div class="container-fluid iq-container">
    <div class="row">
      <div class="col-md-12">
        <div class="flex-wrap d-flex justify-content-between align-items-center">
          <div>
            <h1>Report Notulen</h1>
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
      <?php
      $bul = filter_input(INPUT_GET, 'month', FILTER_VALIDATE_INT) ?? date('m');
      $year = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT) ?? date('Y');
      $inputTeknisi = isset($_GET['teknisi']) ? $_GET['teknisi'] : '';
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
      <form method="get">
        <input type="hidden" name="page" value="reports/r_notulen">
        <div class="row">
          <div class="col-md-4" style="margin-bottom: 10px">
            <label>Report Date</label>
            <div class="input-group">
              <select name="month" class="form-control">
                <?php
                foreach ($bulans as $key => $bulan) {
                ?>
                  <option value="<?php echo $key; ?>" <?php if ($bul == $key) echo 'selected'; ?>><?php echo $bulan; ?></option>
                <?php
                }
                ?>
              </select>
              <span class="input-group-addon" style="border: 0"></span>
              <select name="year" class="form-control">
                <?php
                for ($i = date('Y'); $i > 2023; $i--) {
                ?>
                  <option value="<?php echo $i; ?>" <?php if ($year == $i) echo 'selected'; ?>><?php echo $i; ?></option>
                <?php
                }
                ?>
              </select>
            </div>
          </div>
          <div class="col-md-4" style="margin-bottom: 10px">
            <label>PIC</label>
            <select name="teknisi" class="form-control">
              <option value="">- All PIC -</option>
              <?php
              $loc = mysqli_query($koneksi, "SELECT * FROM teknisi");
              while ($location = mysqli_fetch_array($loc)) {
              ?>
                <option <?php if ($inputTeknisi == $location['id_teknisi']) echo 'selected'; ?> value="<?php echo $location['id_teknisi']; ?>"><?php echo $location['nama']; ?></option>
              <?php
              }
              ?>
            </select>
          </div>
          <div class="col-md-4" style="margin-bottom: 10px">
            <label>Status</label>
            <select name="status" class="form-control">
              <option value="">- All Status -</option>
              <option value="1" <?php if ($inputStatus == 1) echo 'selected'; ?>>Open</option>
              <option value="2" <?php if ($inputStatus == 2) echo 'selected'; ?>>Progress</option>
              <option value="3" <?php if ($inputStatus == 3) echo 'selected'; ?>>Hold</option>
              <option value="4" <?php if ($inputStatus == 4) echo 'selected'; ?>>Done</option>
              <option value="5" <?php if ($inputStatus == 5) echo 'selected'; ?>>Cancel</option>
            </select>
          </div>
          <div class="col-md-12 login-btn-inner">
            <button type="submit" class="btn btn-primary login-submit-cs"><i class="fa fa-filter"></i> Filter Report</button>
            <button type="button" class="btn btn-success" onclick="showExportModal()"><i class="fa fa-file-excel-o"></i> Export</button>
          </div>
        </div>
      </form>
      <br>
      <table id="datatable" class="table table-striped" data-toggle="data-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Date</th>
            <th>Discussion</th>
            <th>Follow Up</th>
            <th>Additional</th>
            <th>PIC</th>
            <th>Target</th>
            <th>Realized</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          $where = "WHERE YEAR(date(date)) = '$year' AND MONTH(date(date)) = '$bul'";

          if (!empty($inputTeknisi)) {
            $where .= " AND technician LIKE '%$inputTeknisi%'";
          }

          if ($inputStatus != "") {
            $where .= " AND meeting.status=$inputStatus";
          }

          if (!empty($_GET['search'])) {
            $search = $_GET['search'];
            $where .= " AND (problem LIKE '%$search%' OR solution LIKE '%$search%')";
          }

          $query = mysqli_query($koneksi, "SELECT meeting.*, user.nama FROM meeting 
                    LEFT JOIN user ON user.id_user = meeting.id_user $where");

          while ($data = mysqli_fetch_array($query)) {
          ?>
            <tr>
              <td>
                <p><?php echo $i++; ?></p>
              </td>
              <td>
                <p><?php echo $data['date']; ?></p>
              </td>
              <td><?php echo (strlen($data['problem']) > 60) ? substr($data['problem'], 0, 60) . '...' : $data['problem']; ?></td>
              <td><?php echo (strlen($data['solution']) > 60) ? substr($data['solution'], 0, 60) . '...' : $data['solution']; ?></td>
              <td><?php echo (strlen($data['n1d']) > 60) ? substr($data['n1d'], 0, 60) . '...' : $data['n1d']; ?></td>
              <td>
                <p>
                  <?php
                  if ($data['technician']) {
                  ?>
                <ol style="padding-left: 12px">
                  <?php
                    $techa = explode(',', $data['technician']);
                    foreach ($techa as $techa) {
                      $q = mysqli_query($koneksi, "SELECT*FROM teknisi where id_teknisi=$techa");
                      $techa = mysqli_fetch_array($q);
                  ?>
                    <li><?php echo $techa['nama']; ?></li>
                  <?php
                    }
                  ?>
                </ol>
                <?php
                  }
                ?>
                </p>
              </td>
              <td>
                <p><?php echo $data['target']; ?></p>
              </td>
              <td>
                <p><?php echo $data['realized']; ?></p>
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

<!-- Modal for Export -->
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exportModalLabel">Export Report</h5>
      </div>
      <div class="modal-body">
        <form id="exportForm">
          <div class="form-group">
            <label for="notulis">Nama Notulis</label>
            <input type="text" class="form-control" id="notulis" name="notulis" placeholder="Masukkan nama notulis">
          </div>
          <div class="form-group">
            <label for="pimpinan">Nama Pimpinan Rapat</label>
            <input type="text" class="form-control" id="pimpinan" name="pimpinan" placeholder="Masukkan nama pimpinan rapat">
          </div>
          <div class="form-group">
            <label for="startDate">Start Date</label>
            <input type="date" class="form-control" id="startDate" name="startDate" required>
          </div>
          <div class="form-group">
            <label for="endDate">End Date</label>
            <input type="date" class="form-control" id="endDate" name="endDate" required>
          </div>
          <input type="hidden" name="month" value="<?php echo $bul; ?>">
          <input type="hidden" name="year" value="<?php echo $year; ?>">
          <input type="hidden" name="status" value="<?php echo $inputStatus; ?>">
          <input type="hidden" name="teknisi" value="<?php echo $inputTeknisi; ?>">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="exportExcel()" target="_blank">Export to Excel</button>
        <button type="button" class="btn btn-danger" onclick="printPDF()" target="_blank">Export to PDF</button>
      </div>
    </div>
  </div>
</div>

<script>
  function showExportModal() {
    $('#exportModal').modal('show');
  }

  function exportExcel() {
    var notulis = document.getElementById('notulis').value;
    var pimpinan = document.getElementById('pimpinan').value;
    var startDate = document.getElementById('startDate').value;
    var endDate = document.getElementById('endDate').value;
    var month = "<?php echo $bul; ?>";
    var year = "<?php echo $year; ?>";
    var status = "<?php echo $inputStatus; ?>";
    var teknisi = "<?php echo $inputTeknisi; ?>";
    window.location.href = "views/pages/reports/r_notulen_data.php?type=excel&notulis=" + encodeURIComponent(notulis) + "&pimpinan=" + encodeURIComponent(pimpinan) + "&month=" + month + "&year=" + year + "&status=" + status + "&teknisi=" + teknisi + "&startDate=" + encodeURIComponent(startDate) + "&endDate=" + encodeURIComponent(endDate);
  }

  function printPDF() {
    var notulis = document.getElementById('notulis').value;
    var pimpinan = document.getElementById('pimpinan').value;
    var startDate = document.getElementById('startDate').value;
    var endDate = document.getElementById('endDate').value;
    var month = "<?php echo $bul; ?>";
    var year = "<?php echo $year; ?>";
    var status = "<?php echo $inputStatus; ?>";
    var teknisi = "<?php echo $inputTeknisi; ?>";
    window.location.href = "views/pages/reports/r_notulen_data.php?type=print&notulis=" + encodeURIComponent(notulis) + "&pimpinan=" + encodeURIComponent(pimpinan) + "&month=" + month + "&year=" + year + "&status=" + status + "&teknisi=" + teknisi + "&startDate=" + encodeURIComponent(startDate) + "&endDate=" + encodeURIComponent(endDate);
  }
</script>