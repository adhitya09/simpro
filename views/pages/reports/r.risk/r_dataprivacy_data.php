<?php
include "../../../../koneksi.php";
$type = isset($_GET['type']) ? $_GET['type'] : date('print');
$month = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('m');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
$inputStatus = isset($_GET['status']) ? $_GET['status'] : '';

$months = array(
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
  header("Content-Disposition: attachment; filename=DataPrivacy_Report_" . $months[$month] . "_" . $year . ".xls");
}
?>

<h1 style="text-align: center; margin:0;">REPORT DATA & PRIVACY</h1>
<h2 style="text-align: center; margin:0 0 20px;">
  <?php echo $months[$month] . " " . $year; ?>
</h2>

<table border="1" cellpadding="5" cellspacing="0">
  <thead>
    <tr>
      <th>No</th>
      <th>Date</th>
      <th>Ticket Number</th>
      <th>Ticket Created</th>
      <th>Ticket Resolved</th>
      <th>IP Source</th>
      <th>Hostname</th>
      <th>Description of Attacks</th>
      <th>Action</th>
      <th>Progress</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $i = 1;
    $where = "WHERE YEAR(date) = '" . mysqli_real_escape_string($koneksi, $year) . "' AND MONTH(date) = '" . mysqli_real_escape_string($koneksi, $month) . "'";

    if ($inputStatus !== "") {
      $where .= " AND status = '" . mysqli_real_escape_string($koneksi, $inputStatus) . "'";
    }

    $query = mysqli_query($koneksi, "SELECT * FROM dataprivat $where");
    while ($data = mysqli_fetch_array($query)) {
    ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $data['date']; ?></td>
        <td><?php echo $data['ticket_number']; ?></td>
        <td><?php echo $data['datetime_created']; ?></td>
        <td><?php echo $data['datetime_resolved']; ?></td>
        <td><?php echo $data['ip_source']; ?></td>
        <td><?php echo $data['hostname']; ?></td>
        <td><?php echo $data['description_of_attacks']; ?></td>
        <td><?php echo $data['action']; ?></td>
        <td><?php echo $data['progress']; ?></td>
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
  <?php if ($type == 'print') { ?>
    window.print();
    setTimeout(function() {
      window.close();
    }, 100);
  <?php } ?>
</script>