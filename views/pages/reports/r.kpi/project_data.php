<?php
include "../../../../koneksi.php";

$type = isset($_GET['type']) ? $_GET['type'] : 'print';
$bul = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('m');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
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

if ($type == 'excel') {
  header("Content-type: application/vnd-ms-excel");
  header("Content-Disposition: attachment; filename=Report Project " . $bulans[$bul] . ' ' . $year . ".xls");
}
?>

<style type="text/css">
  @media print {
    @page {
      size: landscape;
    }
  }
</style>

<h1 style="text-align: center; padding:0; margin:0;">REPORT PROJECT</h1>
<h2 style="text-align: center; padding:0; margin:0 0 20px;"><?php echo $bulans[$bul] . ' ' . $year; ?></h2>
<table border="1" cellpadding="5" cellspacing="0">
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
          if (isset($survey_weeks[1][1])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[1][1])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[1][1])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[1][2])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[1][2])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[1][2])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[1][3])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[1][3])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[1][3])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[1][4])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[1][4])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[1][4])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <!-- TW2 -->
        <td class="border-2">
          <?php
          if (isset($survey_weeks[2][1])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[2][1])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[2][1])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[2][2])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[2][2])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[2][2])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[2][3])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[2][3])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[2][3])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[2][4])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[2][4])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[2][4])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <!-- TW3 -->
        <td class="border-2">
          <?php
          if (isset($survey_weeks[3][1])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[3][1])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[3][1])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[3][2])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[3][2])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[3][2])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[3][3])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[3][3])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[3][3])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[3][4])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[3][4])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[3][4])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <!-- TW4 -->
        <td class="border-2">
          <?php
          if (isset($survey_weeks[4][1])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[4][1])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[4][1])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[4][2])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[4][2])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[4][2])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[4][3])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[4][3])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[4][3])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[4][4])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[4][4])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[4][4])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <!-- TW5 -->
        <td class="border-2">
          <?php
          if (isset($survey_weeks[5][1])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[5][1])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[5][1])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[5][2])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[5][2])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[5][2])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[5][3])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[5][3])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[5][3])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[5][4])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[5][4])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[5][4])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <!-- TW6 -->
        <td class="border-2">
          <?php
          if (isset($survey_weeks[6][1])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[6][1])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[6][1])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[6][2])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[6][2])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[6][2])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[6][3])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[6][3])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[6][3])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[6][4])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[6][4])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[6][4])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <!-- TW7 -->
        <td class="border-2">
          <?php
          if (isset($survey_weeks[7][1])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[7][1])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[7][1])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[7][2])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[7][2])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[7][2])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[7][3])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[7][3])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[7][3])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[7][4])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[7][4])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[7][4])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <!-- TW8 -->
        <td class="border-2">
          <?php
          if (isset($survey_weeks[8][1])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[8][1])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[8][1])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[8][2])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[8][2])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[8][2])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[8][3])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[8][3])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[8][3])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[8][4])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[8][4])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[8][4])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <!-- TW9 -->
        <td class="border-2">
          <?php
          if (isset($survey_weeks[9][1])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[9][1])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[9][1])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[9][2])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[9][2])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[9][2])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[9][3])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[9][3])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[9][3])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[9][4])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[9][4])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[9][4])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <!-- TW10 -->
        <td class="border-2">
          <?php
          if (isset($survey_weeks[10][1])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[10][1])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[10][1])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[10][2])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[10][2])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[10][2])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[10][3])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[10][3])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[10][3])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[10][4])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[10][4])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[10][4])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <!-- TW11 -->
        <td class="border-2">
          <?php
          if (isset($survey_weeks[11][1])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[11][1])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[11][1])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[11][2])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[11][2])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[11][2])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[11][3])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[11][3])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[11][3])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[11][4])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[11][4])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[11][4])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <!-- TW12 -->
        <td class="border-2">
          <?php
          if (isset($survey_weeks[12][1])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[12][1])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[12][1])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[12][2])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[12][2])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[12][2])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[12][3])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[12][3])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[12][3])) echo '<div style="color:blue;">Topology</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($survey_weeks[12][4])) echo '<div style="color:green;">Survey</div> ';
          if (isset($design_weeks[12][4])) echo '<div style="color:yellow;">Design</div> ';
          if (isset($topologi_weeks[12][4])) echo '<div style="color:blue;">Topology</div>';
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
          if (isset($padi_weeks[1][1])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[1][1])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[1][1])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[1][1])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[1][1])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[1][2])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[1][2])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[1][2])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[1][2])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[1][2])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[1][3])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[1][3])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[1][3])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[1][3])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[1][3])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[1][4])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[1][4])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[1][4])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[1][4])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[1][4])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <!-- TW2 -->
        <td class="border-2">
          <?php
          if (isset($padi_weeks[2][1])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[2][1])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[2][1])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[2][1])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[2][1])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[2][2])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[2][2])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[2][2])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[2][2])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[2][2])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[2][3])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[2][3])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[2][3])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[2][3])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[2][3])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[2][4])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[2][4])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[2][4])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[2][4])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[2][4])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <!-- TW3 -->
        <td class="border-2">
          <?php
          if (isset($padi_weeks[3][1])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[3][1])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[3][1])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[3][1])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[3][1])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[3][2])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[3][2])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[3][2])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[3][2])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[3][2])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[3][3])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[3][3])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[3][3])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[3][3])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[3][3])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[3][4])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[3][4])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[3][4])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[3][4])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[3][4])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <!-- TW4 -->
        <td class="border-2">
          <?php
          if (isset($padi_weeks[4][1])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[4][1])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[4][1])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[4][1])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[4][1])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[4][2])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[4][2])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[4][2])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[4][2])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[4][2])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[4][3])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[4][3])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[4][3])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[4][3])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[4][3])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[4][4])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[4][4])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[4][4])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[4][4])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[4][4])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <!-- TW5 -->
        <td class="border-2">
          <?php
          if (isset($padi_weeks[5][1])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[5][1])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[5][1])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[5][1])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[5][1])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[5][2])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[5][2])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[5][2])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[5][2])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[5][2])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[5][3])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[5][3])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[5][3])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[5][3])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[5][3])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[5][4])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[5][4])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[5][4])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[5][4])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[5][4])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <!-- TW6 -->
        <td class="border-2">
          <?php
          if (isset($padi_weeks[6][1])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[6][1])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[6][1])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[6][1])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[6][1])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[6][2])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[6][2])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[6][2])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[6][2])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[6][2])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[6][3])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[6][3])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[6][3])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[6][3])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[6][3])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[6][4])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[6][4])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[6][4])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[6][4])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[6][4])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <!-- TW7 -->
        <td class="border-2">
          <?php
          if (isset($padi_weeks[7][1])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[7][1])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[7][1])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[7][1])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[7][1])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[7][2])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[7][2])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[7][2])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[7][2])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[7][2])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[7][3])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[7][3])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[7][3])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[7][3])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[7][3])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[7][4])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[7][4])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[7][4])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[7][4])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[7][4])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <!-- TW8 -->
        <td class="border-2">
          <?php
          if (isset($padi_weeks[8][1])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[8][1])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[8][1])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[8][1])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[8][1])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[8][2])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[8][2])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[8][2])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[8][2])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[8][2])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[8][3])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[8][3])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[8][3])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[8][3])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[8][3])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[8][4])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[8][4])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[8][4])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[8][4])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[8][4])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <!-- TW9 -->
        <td class="border-2">
          <?php
          if (isset($padi_weeks[9][1])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[9][1])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[9][1])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[9][1])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[9][1])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[9][2])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[9][2])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[9][2])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[9][2])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[9][2])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[9][3])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[9][3])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[9][3])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[9][3])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[9][3])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[9][4])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[9][4])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[9][4])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[9][4])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[9][4])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <!-- TW10 -->
        <td class="border-2">
          <?php
          if (isset($padi_weeks[10][1])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[10][1])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[10][1])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[10][1])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[10][1])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[10][2])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[10][2])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[10][2])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[10][2])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[10][2])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[10][3])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[10][3])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[10][3])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[10][3])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[10][3])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[10][4])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[10][4])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[10][4])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[10][4])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[10][4])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <!-- TW11 -->
        <td class="border-2">
          <?php
          if (isset($padi_weeks[11][1])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[11][1])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[11][1])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[11][1])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[11][1])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[11][2])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[11][2])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[11][2])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[11][22])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[11][2])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[11][3])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[11][3])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[11][3])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[11][3])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[11][3])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[11][4])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[11][4])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[11][4])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[11][4])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[11][4])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <!-- TW12 -->
        <td class="border-2">
          <?php
          if (isset($padi_weeks[12][1])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[12][1])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[12][1])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[12][1])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[12][1])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[12][2])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[12][2])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[12][2])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[12][2])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[12][2])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[12][3])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[12][3])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[12][3])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[12][3])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[12][3])) echo '<div style="color:grey;">Others</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($padi_weeks[12][4])) echo '<div style="color:green;">PADI</div> ';
          if (isset($mr_weeks[12][4])) echo '<div style="color:yellow;">MR</div> ';
          if (isset($tender_weeks[12][4])) echo '<div style="color:blue;">Tender</div>';
          if (isset($picking_weeks[12][4])) echo '<div style="color:lightblue;">Picking</div>';
          if (isset($others_weeks[12][4])) echo '<div style="color:grey;">Others</div>';
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
          if (isset($implementation_weeks[1][1])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[1][1])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[1][2])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[1][2])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[1][3])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[1][3])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[1][4])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[1][4])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <!-- TW2 -->
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[2][1])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[2][1])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[2][2])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[2][2])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[2][3])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[2][3])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[2][4])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[2][4])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <!-- TW3 -->
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[3][1])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[3][1])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[3][2])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[3][2])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[3][3])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[3][3])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[3][4])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[3][4])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <!-- TW4 -->
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[4][1])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[4][1])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[4][2])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[4][2])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[4][3])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[4][3])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[4][4])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[4][4])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <!-- TW5 -->
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[5][1])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[5][1])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[5][2])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[5][2])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[5][3])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[5][3])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[5][4])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[5][4])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <!-- TW6 -->
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[6][1])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[6][1])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[6][2])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[6][2])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[6][3])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[6][3])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[6][4])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[6][4])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <!-- TW7 -->
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[7][1])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[7][1])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[7][2])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[7][2])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[7][3])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[7][3])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[7][4])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[7][4])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <!-- TW8 -->
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[8][1])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[8][1])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[8][2])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[8][2])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[8][3])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[8][3])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[8][4])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[8][4])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <!-- TW9 -->
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[9][1])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[9][1])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[9][2])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[9][2])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[9][3])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[9][3])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[9][4])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[9][4])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <!-- TW10 -->
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[10][1])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[10][1])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[10][2])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[10][2])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[10][3])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[10][3])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[10][4])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[10][4])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <!-- TW11 -->
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[11][1])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[11][1])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[11][2])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[11][2])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[11][3])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[11][3])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[11][4])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[11][4])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <!-- TW12 -->
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[12][1])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[12][1])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[12][2])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[12][2])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[12][3])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[12][3])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($implementation_weeks[12][4])) echo '<div style="color:green;">Implementation</div> ';
          if (isset($monitoring_weeks[12][4])) echo '<div style="color:yellow;">Monitoring</div> ';
          ?>
        </td>
      </tr>
      <tr>
        <td class="text-start border-2 table-primary">Finalization</td>
        <!-- TW1 -->
        <td class="border-2">
          <?php
          // Survey, Design, dan Topologi dalam satu kolom
          if (isset($uat_weeks[1][1])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[1][1])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[1][1])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[1][2])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[1][2])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[1][2])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[1][3])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[1][3])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[1][3])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[1][4])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[1][4])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[1][4])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <!-- TW2 -->
        <td class="border-2">
          <?php
          if (isset($uat_weeks[2][1])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[2][1])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[2][1])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[2][2])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[2][2])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[2][2])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[2][3])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[2][3])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[2][3])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[2][4])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[2][4])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[2][4])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <!-- TW3 -->
        <td class="border-2">
          <?php
          if (isset($uat_weeks[3][1])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[3][1])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[3][1])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[3][2])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[3][2])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[3][2])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[3][3])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[3][3])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[3][3])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[3][4])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[3][4])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[3][4])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <!-- TW4 -->
        <td class="border-2">
          <?php
          if (isset($uat_weeks[4][1])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[4][1])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[4][1])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[4][2])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[4][2])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[4][2])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[4][3])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[4][3])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[4][3])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[4][4])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[4][4])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[4][4])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <!-- TW5 -->
        <td class="border-2">
          <?php
          if (isset($uat_weeks[5][1])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[5][1])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[5][1])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[5][2])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[5][2])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[5][2])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[5][3])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[5][3])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[5][3])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[5][4])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[5][4])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[5][4])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <!-- TW6 -->
        <td class="border-2">
          <?php
          if (isset($uat_weeks[6][1])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[6][1])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[6][1])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[6][2])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[6][2])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[6][2])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[6][3])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[6][3])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[6][3])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[6][4])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[6][4])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[6][4])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <!-- TW7 -->
        <td class="border-2">
          <?php
          if (isset($uat_weeks[7][1])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[7][1])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[7][1])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[7][2])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[7][2])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[7][2])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[7][3])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[7][3])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[7][3])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[7][4])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[7][4])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[7][4])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <!-- TW8 -->
        <td class="border-2">
          <?php
          if (isset($uat_weeks[8][1])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[8][1])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[8][1])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[8][2])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[8][2])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[8][2])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[8][3])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[8][3])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[8][3])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[8][4])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[8][4])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[8][4])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <!-- TW9 -->
        <td class="border-2">
          <?php
          if (isset($uat_weeks[9][1])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[9][1])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[9][1])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[9][2])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[9][2])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[9][2])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[9][3])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[9][3])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[9][3])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[9][4])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[9][4])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[9][4])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <!-- TW10 -->
        <td class="border-2">
          <?php
          if (isset($uat_weeks[10][1])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[10][1])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[10][1])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[10][2])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[10][2])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[10][2])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[10][3])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[10][3])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[10][3])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[10][4])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[10][4])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[10][4])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <!-- TW11 -->
        <td class="border-2">
          <?php
          if (isset($uat_weeks[11][1])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[11][1])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[11][1])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[11][2])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[11][2])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[11][2])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[11][3])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[11][3])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[11][3])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[11][4])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[11][4])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[11][4])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <!-- TW12 -->
        <td class="border-2">
          <?php
          if (isset($uat_weeks[12][1])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[12][1])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[12][1])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[12][2])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[12][2])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[12][2])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[12][3])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[12][3])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[12][3])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
        <td class="border-2">
          <?php
          if (isset($uat_weeks[12][4])) echo '<div style="color:green;">UAT</div> ';
          if (isset($bastp_weeks[12][4])) echo '<div style="color:yellow;">BASTP</div> ';
          if (isset($bastb_weeks[12][4])) echo '<div style="color:blue;">BASTB</div>';
          ?>
        </td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>

<script>
  window.print();
  setTimeout(function() {
    window.close();
  }, 100);
</script>