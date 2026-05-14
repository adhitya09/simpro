<?php
include "../../../../koneksi.php";

$type = isset($_GET['type']) ? $_GET['type'] : date('print');
$bul = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('m');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
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
  header("Content-Disposition: attachment; filename=Report Cyber MYSSC " . $bulans[$bul] . ' ' . $year . ".xls");
}
?>
<h1 style="text-align: center; padding:0; margin:0;">REPORT MYSSC</h1>
<h2 style="text-align: center; padding:0; margin:0 0 20px;">
  <?php echo $bulans[$bul] . ' ' . $year; ?>
</h2>
<table border="thin" cellpadding="5" cellspacing="0">
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
    $where = "WHERE YEAR(date) = $year AND MONTH(date) = $bul";
    if ($inputStatus != "") {
      $where .= " AND status=$inputStatus ";
    }

    $query = mysqli_query($koneksi, "SELECT * FROM cyb_myssc $where");
    while ($data = mysqli_fetch_array($query)) {
    ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $data['date']; ?></td>
        <td><?php echo $data['event']; ?></td>
        <td><?php echo $data['risk']; ?></td>
        <td><?php echo $data['mitigation']; ?></td>
        <td><?php echo $data['progres']; ?></td>
        <td><?php echo $data['tc']; ?></td>
        <td><?php echo $data['tr']; ?></td>
        <td>
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
        </td>
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