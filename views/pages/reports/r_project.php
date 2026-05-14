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
            <h1>Report Project Handling</h1>
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
        <input type="hidden" name="page" value="reports/r_project">
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
          <div class="col-md-3" style="margin-bottom: 10px">
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
          <div class="col-md-2" style="margin-bottom: 10px">
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
            <a href="views/pages/reports/r_project_data.php?type=excel&&month=<?php echo $bul; ?>&year=<?php echo $year; ?>&status=<?php echo $inputStatus; ?>" target="_blank" class="btn btn-success" style="border-radius: 0"><i class="fa fa-file-excel-o"></i> Export Excel</a>
            <a href="views/pages/reports/r_project_data.php?type=print&&month=<?php echo $bul; ?>&year=<?php echo $year; ?>&status=<?php echo $inputStatus; ?>" target="_blank" class="btn btn-danger" style="border-radius: 0"><i class="fa fa-print"></i> Print</a>
          </div>
        </div>
      </form>
      <div class="my-3">
        <div class="form-group row">
          <label for="entriesPerPage" class="form-label col-lg-2">Show entries:</label>
          <div class="col-lg-2">
            <select id="entriesPerPage" class="form-select" onchange="changeEntriesPerPage()">
              <option value="105">5</option>
              <option value="210">10</option>
              <option value="420">20</option>
            </select>
          </div>
        </div>
      </div>
      <table class="project-table table table-bordered mt-4">
        <thead class="table-primary">
          <tr>
            <th class="border-2">NO</th>
            <th class="border-2">No.RFC</th>
            <th class="border-2">Work Item</th>
            <th class="border-2" data-width="300">PIC</th>
            <th class="border-2">Update Progress</th>
            <th class="border-2">Start Date</th>
            <th class="border-2">End Date</th>
            <th class="border-2">Status</th>
          </tr>
        </thead>
        <tbody id="table-body">
          <?php
          // Mengambil data dari hasil query dan menampilkan dalam tabel
          $no = 1;
          $conditions = [];
          if ($bul) {
            $conditions[] = "MONTH(date) = $bul"; // Ganti 'date' dengan kolom yang sesuai
          }
          if ($year) {
            $conditions[] = "YEAR(date) = $year"; // Ganti 'date' dengan kolom yang sesuai
          }
          if ($inputTeknisi) {
            $conditions[] = "technician LIKE '%$inputTeknisi%'"; // Ganti 'technician' dengan kolom yang sesuai
          }
          if ($inputStatus) {
            $conditions[] = "status = $inputStatus"; // Ganti 'status' dengan kolom yang sesuai
          }

          $queryCondition = implode(' AND ', $conditions);
          $query = "SELECT * FROM ph4" . (count($conditions) > 0 ? " WHERE $queryCondition" : "");

          $result = mysqli_query($koneksi, $query);
          if (!$result) {
            die('Query Error: ' . mysqli_error($koneksi));
          }

          while ($data = mysqli_fetch_array($result)) {
          ?>
            <tr>
              <td rowspan="21" class="border-2"><?php echo $no++; ?></td>
              <td rowspan="21" class="border-2"><?php echo $data['rfc']; ?></td>
              <td rowspan="21" class="border-2"><?php echo $data['work_item']; ?></td>
              <td rowspan="21" class="border-2">
                <p>
                  <?php
                  if ($data['technician']) {
                  ?>
                <ol style="padding-left: 12px">
                  <?php
                    $techa = explode(',', $data['technician']);
                    foreach ($techa as $techa) {
                      $q = mysqli_query($koneksi, "SELECT * FROM teknisi WHERE id_teknisi=$techa");
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

              <td colspan="3" class="border-2 bg-success text-white">Planing</td>
              <td rowspan="21" class="border-2">
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
            <tr>
              <td class="border-2">Survey</td>
              <td class="border-2"><?php echo $data['survey_start_date']; ?></td>
              <td class="border-2"><?php echo $data['survey_end_date']; ?></td>
            </tr>
            <tr>
              <td class="border-2">Design</td>
              <td class="border-2"><?php echo $data['design_start_date']; ?></td>
              <td class="border-2"><?php echo $data['design_end_date']; ?></td>
            </tr>
            <tr>
              <td class="border-2">Topologi</td>
              <td class="border-2"><?php echo $data['topologi_start_date']; ?></td>
              <td class="border-2"><?php echo $data['topologi_end_date']; ?></td>
            </tr>
            <tr>
              <td colspan="3" class="border-2 bg-success text-white">Preparation</td>
            </tr>
            <tr>
              <td colspan="3" class="border-2 bg-warning">PADI</td>
            </tr>
            <tr>
              <td class="border-2">PADI OE</td>
              <td class="border-2"><?php echo $data['padi_start_date']; ?></td>
              <td class="border-2"><?php echo $data['padi_end_date']; ?></td>
            </tr>
            <tr>
              <td class="border-2">PADI TOR</td>
              <td class="border-2"><?php echo $data['padi_tor_start_date']; ?></td>
              <td class="border-2"><?php echo $data['padi_tor_end_date']; ?></td>
            </tr>
            <tr>
              <td class="border-2">PADI TKDN</td>
              <td class="border-2"><?php echo $data['padi_tkdn_start_date']; ?></td>
              <td class="border-2"><?php echo $data['padi_tkdn_end_date']; ?></td>
            </tr>
            <tr>
              <td colspan="3" class="border-2 bg-warning">MR</td>
            </tr>
            <tr>
              <td class="border-2">OE</td>
              <td class="border-2"><?php echo $data['mr_start_date']; ?></td>
              <td class="border-2"><?php echo $data['mr_end_date']; ?></td>
            </tr>
            <tr>
              <td class="border-2">Dokumen Tender</td>
              <td class="border-2"><?php echo $data['mr_start_date']; ?></td>
              <td class="border-2"><?php echo $data['mr_end_date']; ?></td>
            </tr>
            <tr>
              <td class="border-2">Tender</td>
              <td class="border-2"><?php echo $data['tender_start_date']; ?></td>
              <td class="border-2"><?php echo $data['tender_end_date']; ?></td>
            </tr>
            <tr>
              <td class="border-2">Picking</td>
              <td class="border-2"><?php echo $data['picking_start_date']; ?></td>
              <td class="border-2"><?php echo $data['picking_end_date']; ?></td>
            </tr>
            <tr>
              <td class="border-2">Others</td>
              <td class="border-2"><?php echo $data['others_start_date']; ?></td>
              <td class="border-2"><?php echo $data['others_end_date']; ?></td>
            </tr>
            <tr>
              <td class="border-2 bg-warning">Implementation</td>
              <td class="border-2"><?php echo $data['implementation_start_date']; ?></td>
              <td class="border-2"><?php echo $data['implementation_end_date']; ?></td>
            </tr>
            <tr>
              <td class="border-2 bg-success text-white">Monitoring</td>
              <td class="border-2"><?php echo $data['monitoring_start_date']; ?></td>
              <td class="border-2"><?php echo $data['monitoring_end_date']; ?></td>
            </tr>
            <tr>
              <td colspan="3" class="border-2 bg-warning">Finalization Dokument</td>
            </tr>
            <tr>
              <td class="border-2">UAT</td>
              <td class="border-2"><?php echo $data['uat_start_date']; ?></td>
              <td class="border-2"><?php echo $data['uat_end_date']; ?></td>
            </tr>
            <tr>
              <td class="border-2">BASTP</td>
              <td class="border-2"><?php echo $data['bastp_start_date']; ?></td>
              <td class="border-2"><?php echo $data['bastp_end_date']; ?></td>
            </tr>
            <tr>
              <td class="border-2">BASTB</td>
              <td class="border-2"><?php echo $data['bastb_start_date']; ?></td>
              <td class="border-2"><?php echo $data['bastb_end_date']; ?></td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
      <div class="row">
        <div id="pagination" class="pagination">
          <div class="col">
            <button class="btn btn-primary" id="prev" onclick="changePage(-1)">Prev</button>
          </div>
          <div class="col tex-center">
            <span id="page-info"></span>
          </div>
          <div class="col">
            <button class="btn btn-primary float-end" id="next" onclick="changePage(1)">Next</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  let rowsPerPage = 105; // Default jumlah baris per halaman
  let currentPage = 1;
  const tableBody = document.getElementById('table-body');
  const rows = tableBody.getElementsByTagName('tr');
  const totalPages = Math.ceil(rows.length / rowsPerPage);

  function displayRows() {
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    for (let i = 0; i < rows.length; i++) {
      rows[i].style.display = (i >= start && i < end) ? '' : 'none';
    }

    document.getElementById('page-info').innerText = `Page ${currentPage} of ${totalPages}`;
    document.getElementById('prev').disabled = currentPage === 1;
    document.getElementById('next').disabled = currentPage === totalPages;
  }

  function changePage(direction) {
    currentPage += direction;
    displayRows();
  }

  function changeEntriesPerPage() {
    const select = document.getElementById('entriesPerPage');
    rowsPerPage = parseInt(select.value);
    currentPage = 1; // Reset ke halaman pertama
    displayRows();
  }

  // Tampilkan baris pertama kali
  displayRows();
</script>