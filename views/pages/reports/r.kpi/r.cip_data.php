<?php
include "../../../../koneksi.php";

$type = isset($_GET['type']) ? $_GET['type'] : 'print';
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
  header("Content-Disposition: attachment; filename=Report CIP " . $bulans[$bul] . ' ' . $year . ".xls");
}
?>

<h1 style="text-align: center; padding:0; margin:0;">REPORT CIP</h1>
<h2 style="text-align: center; padding:0; margin:0 0 20px;"><?php echo $bulans[$bul] . ' ' . $year; ?></h2>
<table border="1" cellpadding="5" cellspacing="0">
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
    $where = "WHERE YEAR(date) = $year AND MONTH(date) = $bul";

    if ($inputStatus != "") {
      $where .= " AND status=$inputStatus";
    }

    $query = mysqli_query($koneksi, "SELECT * FROM cip $where");
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
          echo ($data['result'] == 1)
            ? '<div style="color: brown; text-decoration: underline">Bronze</div>'
            : (($data['result'] == 2)
              ? '<div style="color: silver; text-decoration: underline">Silver</div>'
              : '<div style="color: yellow; text-decoration: underline">Gold</div>');
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