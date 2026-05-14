<?php
include "../../../koneksi.php"; // Pastikan koneksi ke database sudah benar

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
  header("Content-Disposition: attachment; filename=Report_Project_Handling_" . $bulans[$bul] . ' ' . $year . ".xls");
}
?>

<h1 style="text-align: center; padding:0; margin:0;">REPORT PROJECT HANDLING</h1>
<h2 style="text-align: center; padding:0; margin:0 0 20px;"><?php echo $bulans[$bul] . ' ' . $year; ?></h2>

<table border="1" cellpadding="5" cellspacing="0">
  <thead>
    <tr>
      <th>No</th>
      <th>No.RFC</th>
      <th>Work Item</th>
      <th>PIC</th>
      <th>Update Progress</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
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
        <td rowspan="16" class="border-2"><?php echo $no++; ?></td>
        <td rowspan="16" class="border-2"><?php echo $data['rfc']; ?></td>
        <td rowspan="16" class="border-2"><?php echo $data['work_item']; ?></td>
        <td rowspan="16" class="border-2">
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
        <td colspan="3" class="border-2 bg-warning">Planing</td>
        <td rowspan="16" class="border-2">
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
        <td class="border-2">PADI</td>
        <td class="border-2"><?php echo $data['padi_start_date']; ?></td>
        <td class="border-2"><?php echo $data['padi_end_date']; ?></td>
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
        <td class="border-2 bg-success text-white">Tender</td>
        <td class="border-2"><?php echo $data['tender_start_date']; ?></td>
        <td class="border-2"><?php echo $data['tender_end_date']; ?></td>
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

<br><br><br><br>

<style type="text/css">
  @media print {
    @page {
      size: landscape;
    }
  }
</style>
<script>
  window.print();
  setTimeout(function() {
    window.close();
  }, 100);
</script>