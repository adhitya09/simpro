<?php
// Ambil ID dari URL
$id = $_GET['id'];

// Query untuk menghapus data berdasarkan id_myssc
$qq = mysqli_query($koneksi, "DELETE FROM cyb_myssc WHERE id_myssc = $id");

// Tampilkan pesan dan alihkan kembali ke halaman cyber-myssc
if ($qq) {
    echo '<script>alert("Delete Data Successfully.")</script>';
    echo '<meta http-equiv="refresh" content="0;url=?page=riskmanagement/cybersecurity/cyber-myssc">';
} else {
    echo '<script>alert("Failed to Delete Data.")</script>';
    echo '<meta http-equiv="refresh" content="0;url=?page=riskmanagement/cybersecurity/cyber-myssc">';
}
?>
