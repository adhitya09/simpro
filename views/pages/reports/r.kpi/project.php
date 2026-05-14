<?php
// Aktifkan penampilan error untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ambil filter dari input pengguna
$bul = filter_input(INPUT_GET, 'month', FILTER_VALIDATE_INT) ?? date('m');
$year = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT) ?? date('Y');
$inputTeknisi = isset($_GET['teknisi']) ? $_GET['teknisi'] : '';
$inputStatus = isset($_GET['status']) ? $_GET['status'] : '';
$searchRFC = isset($_GET['search_rfc']) ? $_GET['search_rfc'] : ''; // Input pencarian untuk nomor RFC

// Array bulan untuk dropdown
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

// Membuat kondisi untuk query
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

// Membangun query
$queryCondition = implode(' AND ', $conditions);
$query = "SELECT * FROM ph4" . (count($conditions) > 0 ? " WHERE $queryCondition" : "");

// Eksekusi query
$result = mysqli_query($koneksi, $query);
if (!$result) {
  die('Query Error: ' . mysqli_error($koneksi));
}

// Cek apakah ada data
$dataExists = mysqli_num_rows($result) > 0;
?>

<!-- Nav Header Component Start -->
<div class="iq-navbar-header" style="height: 215px">
  <div class="container-fluid iq-container">
    <div class="row">
      <div class="col-md-12">
        <div class="flex-wrap d-flex justify-content-between align-items-center">
          <div>
            <h1>Report KPI</h1>
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
      <form method="get">
        <input type="hidden" name="page" value="reports/r.kpi/project">
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
            <a href="views/pages/reports/r.kpi/project_data.php?type=excel&&month=<?php echo $bul; ?>&year=<?php echo $year; ?>&status=<?php echo $inputStatus; ?>" target="_blank" class="btn btn-success" style="border-radius: 0"><i class="fa fa-file-excel-o"></i> Export Excel</a>
            <a href="views/pages/reports/r.kpi/project_data.php?type=print&&month=<?php echo $bul; ?>&year=<?php echo $year; ?>&status=<?php echo $inputStatus; ?>" target="_blank" class="btn btn-danger" style="border-radius: 0"><i class="fa fa-print"></i> Print</a>
          </div>
        </div>
      </form>
      <div class="mt-4">
        <div class="accordion" id="accordionPanelsStayOpenExample">
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                Get to Know the Notations!
              </button>
            </h2>
            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
              <div class="accordion-body">
                <div class="row">
                  <div class="col-md-3">
                    <h4>Planning :</h4>
                    <ul>
                      <li><span class="badge text-bg-success rounded-circle">S</span> : Survey</li>
                      <li><span class="badge text-bg-warning rounded-circle">D</span> : Design</li>
                      <li><span class="badge text-bg-primary rounded-circle">T</span> : Topology</li>
                    </ul>
                  </div>
                  <div class="col-md-3">
                    <h4>Preparation :</h4>
                    <ul>
                      <li><span class="badge text-bg-success rounded-pill">PADI</span> : PADI</li>
                      <li><span class="badge text-bg-warning rounded-pill">MR</span> : MR</li>
                      <li><span class="badge text-bg-primary rounded-circle">T</span> : Tender</li>
                      <li><span class="badge text-bg-info rounded-circle">P</span> : Picking</li>
                      <li><span class="badge text-bg-secondary rounded-circle">O</span> : Others</li>
                    </ul>
                  </div>
                  <div class="col-md-3">
                    <h4>Implementation :</h4>
                    <ul>
                      <li><span class="badge text-bg-success rounded-circle">I</span> : Implementation</li>
                      <li><span class="badge text-bg-warning rounded-circle">M</span> : Monitoring</li>
                    </ul>
                  </div>
                  <div class="col-md-3">
                    <h4>Finalization :</h4>
                    <ul>
                      <li><span class="badge text-bg-success rounded-pill">UAT</span> : UAT</li>
                      <li><span class="badge text-bg-warning rounded-pill">BASTP</span> : BASTP</li>
                      <li><span class="badge text-bg-primary rounded-pill">BASTB</span> : BASTB</li>
                    </ul>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="my-3">
        <div class="form-group row">
          <label for="entriesPerPage" class="form-label col-lg-2">Show entries:</label>
          <div class="col-lg-2">
            <select id="entriesPerPage" class="form-select" onchange="changeEntriesPerPage()">
              <option value="20">5</option>
              <option value="40">10</option>
              <option value="80">20</option>
            </select>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="project-table table table-bordered">
          <thead class="table-primary">
            <style>
              th {
                text-align: center;
                /* Menyelaraskan teks secara horizontal */
                vertical-align: middle;
                /* Menyelaraskan teks secara vertikal */
              }
            </style>
            <tr>
              <th rowspan="3" class="border-2">No</th>
              <th rowspan="3" class="border-2">No.RFC</th>
              <th rowspan="3" class="border-2">Work Item</th>
              <th rowspan="3" class="border-2">Progress</th>
              <th colspan="12" class="border-2">TW1</th>
              <th colspan="12" class="border-2">TW2</th>
              <th colspan="12" class="border-2">TW3</th>
              <th colspan="12" class="border-2">TW4</th>
            </tr>
            <tr>
              <!-- Bulan -->
              <th colspan="4" class="border-2">Jan</th>
              <th colspan="4" class="border-2">Feb</th>
              <th colspan="4" class="border-2">Mar</th>
              <th colspan="4" class="border-2">Apr</th>
              <th colspan="4" class="border-2">May</th>
              <th colspan="4" class="border-2">Jun</th>
              <th colspan="4" class="border-2">Jul</th>
              <th colspan="4" class="border-2">Aug</th>
              <th colspan="4" class="border-2">Sep</th>
              <th colspan="4" class="border-2">Oct</th>
              <th colspan="4" class="border-2">Nov</th>
              <th colspan="4" class="border-2">Dec</th>
            </tr>
            <tr>
              <!-- Minggu -->
              <!-- jan -->
              <th colspan="1" class="border-2">W1</th>
              <th colspan="1" class="border-2">W2</th>
              <th colspan="1" class="border-2">W3</th>
              <th colspan="1" class="border-2">W4</th>
              <!-- feb -->
              <th colspan="1" class="border-2">W1</th>
              <th colspan="1" class="border-2">W2</th>
              <th colspan="1" class="border-2">W3</th>
              <th colspan="1" class="border-2">W4</th>
              <!-- mar -->
              <th colspan="1" class="border-2">W1</th>
              <th colspan="1" class="border-2">W2</th>
              <th colspan="1" class="border-2">W3</th>
              <th colspan="1" class="border-2">W4</th>
              <!-- apr -->
              <th colspan="1" class="border-2">W1</th>
              <th colspan="1" class="border-2">W2</th>
              <th colspan="1" class="border-2">W3</th>
              <th colspan="1" class="border-2">W4</th>
              <!-- may -->
              <th colspan="1" class="border-2">W1</th>
              <th colspan="1" class="border-2">W2</th>
              <th colspan="1" class="border-2">W3</th>
              <th colspan="1" class="border-2">W4</th>
              <!-- jun -->
              <th colspan="1" class="border-2">W1</th>
              <th colspan="1" class="border-2">W2</th>
              <th colspan="1" class="border-2">W3</th>
              <th colspan="1" class="border-2">W4</th>
              <!-- jul -->
              <th colspan="1" class="border-2">W1</th>
              <th colspan="1" class="border-2">W2</th>
              <th colspan="1" class="border-2">W3</th>
              <th colspan="1" class="border-2">W4</th>
              <!-- aug -->
              <th colspan="1" class="border-2">W1</th>
              <th colspan="1" class="border-2">W2</th>
              <th colspan="1" class="border-2">W3</th>
              <th colspan="1" class="border-2">W4</th>
              <!-- sep -->
              <th colspan="1" class="border-2">W1</th>
              <th colspan="1" class="border-2">W2</th>
              <th colspan="1" class="border-2">W3</th>
              <th colspan="1" class="border-2">W4</th>
              <!-- oct -->
              <th colspan="1" class="border-2">W1</th>
              <th colspan="1" class="border-2">W2</th>
              <th colspan="1" class="border-2">W3</th>
              <th colspan="1" class="border-2">W4</th>

              <!-- nov -->
              <th colspan="1" class="border-2">W1</th>
              <th colspan="1" class="border-2">W2</th>
              <th colspan="1" class="border-2">W3</th>
              <th colspan="1" class="border-2">W4</th>

              <!-- dec -->
              <th colspan="1" class="border-2">W1</th>
              <th colspan="1" class="border-2">W2</th>
              <th colspan="1" class="border-2">W3</th>
              <th colspan="1" class="border-2">W4</th>

            </tr>
          </thead>
          <tbody id="table-body">
            <?php
            // Fungsi untuk menghitung minggu
            function calculateWeeks($start_date, $end_date)
            {
              if ($start_date === null || $end_date === null) {
                return []; // Kembalikan array kosong jika salah satu tanggal null
              }

              $weeks = [];
              $start_month = $start_date->format('n');
              $end_month = $end_date->format('n');

              for ($month = $start_month; $month <= $end_month; $month++) {
                if ($month == $start_month) {
                  $start_week = (int)ceil($start_date->format('j') / 7);
                } else {
                  $start_week = 1; // Minggu pertama
                }

                if ($month == $end_month) {
                  $end_week = (int)ceil($end_date->format('j') / 7);
                  // Jika end_week lebih dari 4, set menjadi 4
                  if ($end_week > 4) {
                    $end_week = 4;
                  }
                } else {
                  $end_week = 4; // Minggu keempat
                }

                // Centang minggu yang sesuai
                for ($week = $start_week; $week <= $end_week; $week++) {
                  $weeks[$month][$week] = true;
                }

                // Tambahkan logika untuk menangani kasus di mana rentang tanggal kurang dari satu minggu
                if ($start_date->diff($end_date)->days < 7) {
                  // Jika tanggal mulai dan akhir berada dalam minggu yang sama
                  if ($start_month == $end_month) {
                    $weeks[$start_month][(int)ceil($start_date->format('j') / 7)] = true; // Centang minggu yang sesuai
                  }
                }
              }

              // Jika end_date lebih dari W4, pastikan W4 dicentang
              if ($end_date->format('j') > 28) {
                $weeks[$end_month][4] = true; // Centang W4
              }

              return $weeks;
            }

            $query = mysqli_query($koneksi, "SELECT * FROM ph4");

            $no = 1;
            while ($data = mysqli_fetch_array($query)) {
              // Ambil tanggal untuk setiap bagian
              $survey_start_date = !empty($data['survey_start_date']) ? new DateTime($data['survey_start_date']) : null;
              $survey_end_date = !empty($data['survey_end_date']) ? new DateTime($data['survey_end_date']) : null;

              $design_start_date = !empty($data['design_start_date']) ? new DateTime($data['design_start_date']) : null;
              $design_end_date = !empty($data['design_end_date']) ? new DateTime($data['design_end_date']) : null;

              $topologi_start_date = !empty($data['topologi_start_date']) ? new DateTime($data['topologi_start_date']) : null;
              $topologi_end_date = !empty($data['topologi_end_date']) ? new DateTime($data['topologi_end_date']) : null;

              $padi_start_date = !empty($data['padi_start_date']) ? new DateTime($data['padi_start_date']) : null;
              $padi_end_date = !empty($data['padi_end_date']) ? new DateTime($data['padi_end_date']) : null;

              $mr_start_date = !empty($data['mr_start_date']) ? new DateTime($data['mr_start_date']) : null;
              $mr_end_date = !empty($data['mr_end_date']) ? new DateTime($data['mr_end_date']) : null;

              $tender_start_date = !empty($data['tender_start_date']) ? new DateTime($data['tender_start_date']) : null;
              $tender_end_date = !empty($data['tender_end_date']) ? new DateTime($data['tender_end_date']) : null;

              $picking_start_date = !empty($data['picking_start_date']) ? new DateTime($data['picking_start_date']) : null;
              $picking_end_date = !empty($data['picking_end_date']) ? new DateTime($data['picking_end_date']) : null;

              $others_start_date = !empty($data['others_start_date']) ? new DateTime($data['others_start_date']) : null;
              $others_end_date = !empty($data['others_end_date']) ? new DateTime($data['others_end_date']) : null;

              $implementation_start_date = !empty($data['implementation_start_date']) ? new DateTime($data['implementation_start_date']) : null;
              $implementation_end_date = !empty($data['implementation_end_date']) ? new DateTime($data['implementation_end_date']) : null;

              $monitoring_start_date = !empty($data['monitoring_start_date']) ? new DateTime($data['monitoring_start_date']) : null;
              $monitoring_end_date = !empty($data['monitoring_end_date']) ? new DateTime($data['monitoring_end_date']) : null;

              $uat_start_date = !empty($data['uat_start_date']) ? new DateTime($data['uat_start_date']) : null;
              $uat_end_date = !empty($data['uat_end_date']) ? new DateTime($data['uat_end_date']) : null;

              $bastp_start_date = !empty($data['bastp_start_date']) ? new DateTime($data['bastp_start_date']) : null;
              $bastp_end_date = !empty($data['bastp_end_date']) ? new DateTime($data['bastp_end_date']) : null;

              $bastb_start_date = !empty($data['bastb_start_date']) ? new DateTime($data['bastb_start_date']) : null;
              $bastb_end_date = !empty($data['bastb_end_date']) ? new DateTime($data['bastb_end_date']) : null;

              // Hitung minggu untuk setiap bagian
              $survey_weeks = calculateWeeks($survey_start_date, $survey_end_date);
              $design_weeks = calculateWeeks($design_start_date, $design_end_date);
              $topologi_weeks = calculateWeeks($topologi_start_date, $topologi_end_date);
              $padi_weeks = calculateWeeks($padi_start_date, $padi_end_date);
              $mr_weeks = calculateWeeks($mr_start_date, $mr_end_date);
              $tender_weeks = calculateWeeks($tender_start_date, $tender_end_date);
              $picking_weeks = calculateWeeks($picking_start_date, $picking_end_date);
              $others_weeks = calculateWeeks($others_start_date, $others_end_date);
              $implementation_weeks = calculateWeeks($implementation_start_date, $implementation_end_date);
              $monitoring_weeks = calculateWeeks($monitoring_start_date, $monitoring_end_date);
              $uat_weeks = calculateWeeks($uat_start_date, $uat_end_date);
              $bastp_weeks = calculateWeeks($bastp_start_date, $bastp_end_date);
              $bastb_weeks = calculateWeeks($bastb_start_date, $bastb_end_date);              ?>
              <!-- planning -->
              <tr>
                <td rowspan="4" class="border-2"><?php echo $no++; ?></td>
                <td rowspan="4" class="border-2"><a href="?page=rfc&&id=<?php echo $data['id']; ?>"><?php echo $data['rfc']; ?></a></td>
                <td rowspan="4" class="border-2"><a href="?page=projecthandling&&id=<?php echo $data['id']; ?>"><?php echo (strlen($data['work_item']) > 60) ? substr($data['work_item'], 0, 60) . '...' : $data['work_item']; ?></a></td>
                <td class="text-start table-primary border-2">Planning</td>
                <!-- TW1 -->
                <td class="border-2">
                  <?php
                  // Survey, Design, dan Topologi dalam satu kolom
                  if (isset($survey_weeks[1][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[1][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[1][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[1][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[1][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[1][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[1][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[1][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[1][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[1][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[1][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[1][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <!-- TW2 -->
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[2][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[2][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[2][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[2][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[2][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[2][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[2][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[2][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[2][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[2][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[2][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[2][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <!-- TW3 -->
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[3][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[3][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[3][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[3][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[3][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[3][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[3][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[3][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[3][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[3][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[3][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[3][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <!-- TW4 -->
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[4][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[4][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[4][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[4][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[4][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[4][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[4][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[4][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[4][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[4][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[4][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[4][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <!-- TW5 -->
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[5][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[5][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[5][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[5][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[5][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[5][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[5][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[5][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[5][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[5][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[5][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[5][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <!-- TW6 -->
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[6][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[6][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[6][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[6][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[6][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[6][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[6][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[6][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[6][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[6][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[6][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[6][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <!-- TW7 -->
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[7][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[7][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[7][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[7][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[7][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[7][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[7][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[7][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[7][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[7][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[7][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[7][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <!-- TW8 -->
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[8][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[8][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[8][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[8][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[8][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[8][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[8][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[8][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[8][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[8][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[8][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[8][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <!-- TW9 -->
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[9][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[9][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[9][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[9][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[9][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[9][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[9][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[9][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[9][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[9][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[9][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[9][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <!-- TW10 -->
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[10][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[10][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[10][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[10][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[10][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[10][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[10][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[10][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[10][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[10][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[10][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[10][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <!-- TW11 -->
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[11][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[11][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[11][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[11][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[11][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[11][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[11][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[11][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[11][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[11][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[11][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[11][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <!-- TW12 -->
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[12][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[12][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[12][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[12][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[12][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[12][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[12][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[12][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[12][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($survey_weeks[12][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                  if (isset($design_weeks[12][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                  if (isset($topologi_weeks[12][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  ?>
                </td>
              </tr>
              <!-- preparation -->
              <tr>
                <td class="text-start border-2 table-primary">Preparation</td>
                <!-- TW1 -->
                <td class="border-2">
                  <?php
                  // Survey, Design, dan Topologi dalam satu kolom
                  if (isset($padi_weeks[1][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[1][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[1][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[1][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[1][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[1][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[1][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[1][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[1][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[1][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[1][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[1][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[1][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[1][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[1][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[1][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[1][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[1][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[1][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[1][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <!-- TW2 -->
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[2][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[2][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[2][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[2][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[2][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[2][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[2][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[2][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[2][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[2][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[2][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[2][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[2][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[2][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[2][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[2][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[2][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[2][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[2][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[2][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <!-- TW3 -->
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[3][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[3][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[3][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[3][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[3][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[3][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[3][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[3][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[3][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[3][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[3][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[3][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[3][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[3][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[3][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[3][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[3][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[3][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[3][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[3][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <!-- TW4 -->
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[4][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[4][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[4][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[4][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[4][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[4][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[4][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[4][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[4][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[4][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[4][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[4][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[4][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[4][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[4][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[4][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[4][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[4][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[4][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[4][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <!-- TW5 -->
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[5][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[5][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[5][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[5][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[5][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[5][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[5][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[5][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[5][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[5][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[5][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[5][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[5][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[5][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[5][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[5][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[5][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[5][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[5][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[5][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <!-- TW6 -->
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[6][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[6][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[6][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[6][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[6][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[6][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[6][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[6][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[6][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[6][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[6][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[6][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[6][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[6][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[6][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[6][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[6][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[6][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[6][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[6][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <!-- TW7 -->
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[7][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[7][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[7][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[7][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[7][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[7][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[7][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[7][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[7][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[7][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[7][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[7][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[7][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[7][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[7][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[7][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[7][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[7][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[7][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[7][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <!-- TW8 -->
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[8][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[8][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[8][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[8][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[8][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[8][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[8][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[8][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[8][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[8][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[8][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[8][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[8][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[8][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[8][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[8][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[8][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[8][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[8][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[8][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <!-- TW9 -->
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[9][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[9][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[9][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[9][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[9][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[9][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[9][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[9][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[9][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[9][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[9][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[9][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[9][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[9][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[9][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[9][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[9][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[9][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[9][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[9][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <!-- TW10 -->
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[10][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[10][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[10][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[10][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[10][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[10][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[10][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[10][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[10][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[10][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[10][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[10][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[10][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[10][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[10][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[10][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[10][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[10][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[10][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[10][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <!-- TW11 -->
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[11][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[11][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[11][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[11][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[11][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[11][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[11][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[11][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[11][22])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[11][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[11][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[11][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[11][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[11][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[11][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[11][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[11][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[11][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[11][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[11][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <!-- TW12 -->
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[12][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[12][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[12][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[12][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[12][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[12][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[12][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[12][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[12][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[12][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[12][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[12][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[12][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[12][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[12][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($padi_weeks[12][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                  if (isset($mr_weeks[12][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                  if (isset($tender_weeks[12][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                  if (isset($picking_weeks[12][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                  if (isset($others_weeks[12][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                  ?>
                </td>
              </tr>
              <!-- implementation -->
              <tr>
                <td class=" text-start table-primary border-2">Implementation</td>
                <!-- TW1 -->
                <td class="border-2">
                  <?php
                  // Survey, Design, dan Topologi dalam satu kolom
                  if (isset($implementation_weeks[1][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[1][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[1][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[1][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[1][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[1][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[1][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[1][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <!-- TW2 -->
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[2][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[2][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[2][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[2][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[2][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[2][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[2][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[2][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <!-- TW3 -->
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[3][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[3][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[3][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[3][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[3][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[3][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[3][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[3][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <!-- TW4 -->
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[4][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[4][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[4][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[4][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[4][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[4][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[4][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[4][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <!-- TW5 -->
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[5][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[5][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[5][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[5][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[5][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[5][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[5][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[5][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <!-- TW6 -->
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[6][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[6][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[6][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[6][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[6][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[6][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[6][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[6][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <!-- TW7 -->
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[7][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[7][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[7][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[7][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[7][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[7][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[7][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[7][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <!-- TW8 -->
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[8][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[8][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[8][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[8][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[8][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[8][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[8][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[8][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <!-- TW9 -->
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[9][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[9][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[9][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[9][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[9][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[9][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[9][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[9][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <!-- TW10 -->
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[10][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[10][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[10][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[10][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[10][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[10][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[10][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[10][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <!-- TW11 -->
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[11][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[11][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[11][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[11][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[11][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[11][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[11][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[11][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <!-- TW12 -->
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[12][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[12][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[12][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[12][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[12][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[12][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($implementation_weeks[12][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                  if (isset($monitoring_weeks[12][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                  ?>
                </td>
              </tr>
              <tr>
                <td class="text-start border-2 table-primary">Finalization</td>
                <!-- TW1 -->
                <td class="border-2">
                  <?php
                  // Survey, Design, dan Topologi dalam satu kolom
                  if (isset($uat_weeks[1][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[1][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[1][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[1][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[1][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[1][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[1][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[1][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[1][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[1][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[1][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[1][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <!-- TW2 -->
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[2][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[2][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[2][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[2][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[2][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[2][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[2][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[2][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[2][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[2][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[2][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[2][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <!-- TW3 -->
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[3][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[3][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[3][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[3][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[3][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[3][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[3][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[3][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[3][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[3][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[3][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[3][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <!-- TW4 -->
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[4][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[4][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[4][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[4][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[4][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[4][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[4][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[4][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[4][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[4][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[4][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[4][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <!-- TW5 -->
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[5][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[5][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[5][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[5][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[5][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[5][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[5][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[5][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[5][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[5][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[5][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[5][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <!-- TW6 -->
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[6][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[6][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[6][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[6][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[6][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[6][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[6][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[6][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[6][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[6][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[6][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[6][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <!-- TW7 -->
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[7][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[7][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[7][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[7][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[7][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[7][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[7][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[7][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[7][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[7][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[7][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[7][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <!-- TW8 -->
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[8][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[8][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[8][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[8][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[8][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[8][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[8][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[8][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[8][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[8][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[8][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[8][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <!-- TW9 -->
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[9][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[9][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[9][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[9][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[9][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[9][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[9][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[9][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[9][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[9][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[9][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[9][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <!-- TW10 -->
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[10][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[10][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[10][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[10][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[10][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[10][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[10][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[10][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[10][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[10][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[10][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[10][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <!-- TW11 -->
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[11][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[11][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[11][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[11][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[11][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[11][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[11][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[11][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[11][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[11][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[11][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[11][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <!-- TW12 -->
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[12][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[12][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[12][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[12][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[12][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[12][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[12][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[12][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[12][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
                <td class="border-2">
                  <?php
                  if (isset($uat_weeks[12][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                  if (isset($bastp_weeks[12][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                  if (isset($bastb_weeks[12][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                  ?>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
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
  let rowsPerPage = 20; // Default jumlah baris per halaman
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