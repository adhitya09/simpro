<?php
include "../../../koneksi.php"; // Pastikan koneksi database sudah benar

// Ambil data dari URL
$notulis = isset($_GET['notulis']) ? $_GET['notulis'] : 'Tidak ada';
$pimpinan = isset($_GET['pimpinan']) ? $_GET['pimpinan'] : 'Tidak ada';
$bul = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('m');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
$inputTeknisi = isset($_GET['teknisi']) ? $_GET['teknisi'] : '';
$inputStatus = isset($_GET['status']) ? $_GET['status'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : 'print';
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';

// Definisikan array bulan
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

// Initialize the $where variable
$where = "WHERE date(date) BETWEEN '$startDate' AND '$endDate'";

if ($inputTeknisi != "") {
    $where .= " AND technician LIKE '%$inputTeknisi%'";
}
if ($inputStatus != "") {
    $where .= " AND meeting.status=$inputStatus";
}

// Jika tipe adalah excel
if ($type == 'excel') {
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Report_Notulen_" . $bulans[$bul] . "_" . $year . ".xls");
} elseif ($type == 'pdf') {
    // Jika tipe adalah pdf, kita akan menggunakan TCPDF
    require_once '../../../vendor/autoload.php'; // Pastikan jalur ini sesuai dengan lokasi autoload.php Composer

    // Buat instance TCPDF
    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Report Notulen');
    $pdf->SetHeaderData('', 0, 'REPORT NOTULEN', $bulans[$bul] . ' ' . $year);
    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(10, 10, 10);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->AddPage();

    // Tulis judul
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'REPORT NOTULEN', 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, $bulans[$bul] . ' ' . $year, 0, 1, 'C');
    $pdf->Ln(10); // Jarak

    // Tulis header kolom
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(10, 10, 'No', 1);
    $pdf->Cell(30, 10, 'Date', 1);
    $pdf->Cell(40, 10, 'Discussion', 1);
    $pdf->Cell(40, 10, 'Follow Up', 1);
    $pdf->Cell(40, 10, 'Additional', 1);
    $pdf->Cell(30, 10, 'PIC', 1);
    $pdf->Cell(30, 10, 'Target', 1);
    $pdf->Cell(30, 10, 'Realized', 1);
    $pdf->Cell(30, 10, 'Status', 1);
    $pdf->Cell(30, 10, 'Officers', 1);
    $pdf->Ln();

    // Ambil data dari database
    $query = mysqli_query($koneksi, "SELECT meeting.*, user.nama FROM meeting 
        LEFT JOIN user ON user.id_user = meeting.id_user $where");

    $i = 1;
    while ($data = mysqli_fetch_array($query)) {
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(10, 10, $i++, 1);
        $pdf->Cell(30, 10, $data['date'], 1);
        $pdf->Cell(40, 10, $data['problem'], 1);
        $pdf->Cell(40, 10, $data['solution'], 1);
        $pdf->Cell(40, 10, $data['n1d'], 1);
        $pdf->Cell(30, 10, $data['technician'], 1);
        $pdf->Cell(30, 10, $data['target'], 1);
        $pdf->Cell(30, 10, $data['realized'], 1);
        $pdf->Cell(30, 10, $data['status'], 1);
        $pdf->Cell(30, 10, $data['nama'], 1);
        $pdf->Ln();
    }

    // Menambahkan bagian notulis dan pimpinan
    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Notulis: ' . $notulis, 0, 1, 'L');
    $pdf->Cell(0, 10, 'Pimpinan Rapat: ' . $pimpinan, 0, 1, 'L');

    // Output PDF
    $pdf->Output('Report_Notulen_' . $bulans[$bul] . '_' . $year . '.pdf', 'D');
    exit;
}

// Jika bukan excel atau pdf, tampilkan HTML
?>
<h1 style="text-align: center; padding:0; margin:0;">NOTULEN RAPAT</h1>
<h2 style="text-align: center; padding:0; margin:0 0 20px;"><?php echo $bulans[$bul] . ' ' . $year; ?></h2>
<table border="thin" cellpadding="5" cellspacing="0" style="margin: 0 auto;">
    <thead>
        <tr>
            <th>No</th>
            <th>Date</th>
            <th>Leaders</th>
            <th>Notulen</th>
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
        // Use the $where variable here
        $query = mysqli_query($koneksi, "SELECT meeting.*, user.nama FROM meeting 
            LEFT JOIN user ON user.id_user = meeting.id_user $where");
        while ($data = mysqli_fetch_array($query)) {
        ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $data['date']; ?></td>
                <td><?php echo $data['ldr']; ?></td>
                <td><?php echo $data['ntl']; ?></td>
                <td><?php echo $data['problem']; ?></td>
                <td><?php echo $data['solution']; ?></td>
                <td><?php echo $data['n1d']; ?></td>
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
                <td><?php echo $data['target']; ?></td>
                <td><?php echo $data['realized']; ?></td>
                <td>
                    <?php
                    $status_labels = [
                        1 => '<span style="color: blue;text-decoration: underline">Open</span>',
                        2 => '<span class="text-info" style="text-decoration: underline">Progress</span>',
                        3 => '<span style="color: orangered;text-decoration: underline">Hold</span>',
                        4 => '<span style="color: green;text-decoration: underline">Done</span>',
                        5 => '<span style="color: red;text-decoration: underline">Cancel</span>'
                    ];
                    echo isset($status_labels[$data['status']]) ? $status_labels[$data['status']] : '<span style="color: grey;">Unknown</span>';
                    ?>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<br><br><br><br>

<!-- Bagian Notulis dan Pimpinan Rapat -->
<table style="width: 100%; margin-top: 50px; border: none;">
    <tr>
        <td style="width: 50%; text-align: center; padding-right: 50px; vertical-align: top;">
            <p style="margin: 0;">Notulis,</p>
            <br><br><br>
            <p style="margin: 0;"><?php echo $notulis; ?></p>
        </td>
        <td style="width: 50%; text-align: center; padding-left: 50px; vertical-align: top;">
            <p style="margin: 0;">Pimpinan Rapat,</p>
            <br><br><br>
            <p style="margin: 0;"><?php echo $pimpinan; ?></p>
        </td>
    </tr>
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