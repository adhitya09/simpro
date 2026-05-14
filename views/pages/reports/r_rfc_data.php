<?php
include "../../../koneksi.php";

$type = isset($_GET['type']) ? $_GET['type'] : 'print';
$bul = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('m');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
$inputTeknisi = isset($_GET['teknisi']) ? $_GET['teknisi'] : '';
$inputStatus = isset($_GET['status']) ? $_GET['status'] : '';
$searchRFC = isset($_GET['search_rfc']) ? $_GET['search_rfc'] : ''; // Input pencarian untuk nomor RFC

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
  header("Content-Disposition: attachment; filename=Report RFC " . $bulans[$bul] . ' ' . $year . ".xls");
}
?>

<h1 style="text-align: center; padding:0; margin:0;">REPORT RFC</h1>
<h2 style="text-align: center; padding:0; margin:0 0 20px;"><?php echo $bulans[$bul] . ' ' . $year; ?></h2>
<table border="1" cellpadding="5" cellspacing="0">
  <thead>
    <tr>
      <th>No</th>
      <th>No.RFC</th>
      <th>Work Item</th>
      <th>Update</th>
      <th colspan="2">Upload</th>
      <th>Evidance</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $i = 1;
    $conditions = [];
    if ($bul) {
      $conditions[] = "MONTH(date) = $bul"; // Ganti 'start_date' dengan kolom yang sesuai
    }
    if ($year) {
      $conditions[] = "YEAR(date) = $year"; // Ganti 'start_date' dengan kolom yang sesuai
    }
    if ($inputTeknisi) {
      $conditions[] = "technician LIKE '%$inputTeknisi%'"; // Ganti 'technician' dengan kolom yang sesuai
    }
    if ($inputStatus) {
      $conditions[] = "status = $inputStatus"; // Ganti 'status' dengan kolom yang sesuai
    }
    if ($searchRFC) {
      $conditions[] = "rfc LIKE '%$searchRFC%'"; // Menambahkan kondisi pencarian untuk nomor RFC
    }

    $queryCondition = implode(' AND ', $conditions);
    $query = "SELECT * FROM ph4" . (count($conditions) > 0 ? " WHERE $queryCondition" : "");

    $result = mysqli_query($koneksi, $query);
    if (!$result) {
      die('Query Error: ' . mysqli_error($koneksi));
    }

    while ($data = mysqli_fetch_array($result)) {
      $survey_done = !empty($data['survey_file']) && !empty($data['survey_start_date']) && !empty($data['survey_end_date']);
      $design_done = !empty($data['design_file']) && !empty($data['design_start_date']) && !empty($data['design_end_date']);
      $topologi_done = !empty($data['topologi_file']) && !empty($data['topologi_start_date']) && !empty($data['topologi_end_date']);
      $padi_done = !empty($data['padi_oe']) && !empty($data['padi_tor']) && !empty($data['padi_tkdn']) && !empty($data['padi_start_date']) && !empty($data['padi_tor_start_date']) && !empty($data['padi_tkdn_start_date']) && !empty($data['padi_end_date']) && !empty($data['padi_tor_end_date']) && !empty($data['padi_tkdn_end_date']);
      $mr_done = !empty($data['mr_oe']) && !empty($data['mr_tender_file']) && !empty($data['mr_start_date']) && !empty($data['mr_end_date']);
      $tender_done = !empty($data['tender_file']) && !empty($data['tender_start_date']) && !empty($data['tender_end_date']);
      $picking_done = !empty($data['picking']) && !empty($data['picking_start_date']) && !empty($data['picking_end_date']);
      $others_done = !empty($data['others']) && !empty($data['others_start_date']) && !empty($data['others_end_date']);
      $implementation_done = !empty($data['implementation_file']) && !empty($data['implementation_start_date']) && !empty($data['implementation_end_date']) && !empty($data['implementation_description']);
      $monitoring_done = !empty($data['monitoring_file']) && !empty($data['monitoring_start_date']) && !empty($data['monitoring_end_date']) && !empty($data['monitoring_description']);
      $uat_done = !empty($data['uat_file']) && !empty($data['uat_start_date']) && !empty($data['uat_end_date']);
      $bastp_done = !empty($data['bastp_file']) && !empty($data['bastp_start_date']) && !empty($data['bastp_end_date']);
      $bastb_done = !empty($data['bastb_file']) && !empty($data['bastb_start_date']) && !empty($data['bastb_end_date']);
    ?>
      <tr>
        <td rowspan="16" class="border-2"><?php echo $i++; ?></td>
        <td rowspan="16" class="border-2"><?php echo $data['rfc']; ?></td>
        <td rowspan="16" class="border-2"><a href="?page=kpi/project&&id=<?php echo $data['id']; ?>"><?php echo $data['work_item']; ?></a></td>
        <td colspan="4" style="background-color: lightgray;" class="border-2">Planing</td>
      </tr>
      <tr>
        <td class="border-2">Survey</td>
        <th colspan="2" class="border-2"><?php echo $survey_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
        <td class="border-2"><?php echo $survey_done ? '1' : ''; ?></td>
      </tr>
      <tr>
        <td class="border-2">Design</td>
        <th colspan="2" class="border-2"><?php echo $design_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
        <td class="border-2"><?php echo $design_done ? '1' : ''; ?></td>
      </tr>
      <tr>
        <td class="border-2">Topologi</td>
        <th colspan="2" class="border-2"><?php echo $topologi_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
        <td class="border-2"><?php echo $topologi_done ? '1' : ''; ?></td>
      </tr>
      <tr>
        <td colspan="4" style="background-color: lightgray;" class="border-2">Preparation</td>
      </tr>
      <tr>
        <td class="border-2">PADI</td>
        <th colspan="2" class="border-2"><?php echo $padi_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
        <td class="border-2"><?php echo $padi_done ? '1' : ''; ?></td>
      </tr>
      <tr>
        <td class="border-2">MR</td>
        <th><?php echo $mr_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
        <th><?php echo $mr_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
        <td class="border-2"><?php echo $mr_done ? '2' : ''; ?></td>
      </tr>
      <tr>
        <td class="border-2">Tender</td>
        <th colspan="2" class="border-2"><?php echo $tender_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
        <td class="border-2"><?php echo $tender_done ? '1' : ''; ?></td>
      </tr>
      <tr>
        <td class="border-2">Picking</td>
        <th colspan="2" class="border-2"><?php echo $picking_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
        <td class="border-2"><?php echo $picking_done ? '1' : ''; ?></td>
      </tr>
      <tr>
        <td class="border-2">Others</td>
        <th colspan="2" class="border-2"><?php echo $others_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
        <td class="border-2"><?php echo $others_done ? '1' : ''; ?></td>
      </tr>
      <tr>
        <td class="border-2">Implementation</td>
        <th colspan="2" class="border-2"><?php echo $implementation_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
        <td class="border-2"><?php echo $implementation_done ? '1' : ''; ?></td>
      </tr>
      <tr>
        <td class="border-2">Monitoring</td>
        <th colspan="2" class="border-2"><?php echo $monitoring_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
        <td class="border-2"><?php echo $monitoring_done ? '1' : ''; ?></td>
      </tr>
      <tr>
        <td colspan="4" style="background-color: lightgray;" class="border-2">Finalization Dokument</td>
      </tr>
      <tr>
        <td class="border-2">UAT</td>
        <th colspan="2" class="border-2"><?php echo $uat_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
        <td class="border-2"><?php echo $uat_done ? '1' : ''; ?></td>
      </tr>
      <tr>
        <td class="border-2">BASTP</td>
        <th colspan="2" class="border-2"><?php echo $bastp_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
        <td class="border-2"><?php echo $bastp_done ? '1' : ''; ?></td>
      </tr>
      <tr>
        <td class="border-2">BASTB</td>
        <th colspan="2" class="border-2"><?php echo $bastb_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
        <td class="border-2"><?php echo $bastb_done ? '1' : ''; ?></td>
      </tr>
    <?php
    }
    ?>

  </tbody>
</table>

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