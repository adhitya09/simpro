<?php
// Ambil ID dari URL
$id = $_GET['id'];

// Query untuk menghapus data berdasarkan id_cyber
$qq = mysqli_query($koneksi, "DELETE FROM cyber WHERE id_cyber = $id");

// Tampilkan pesan dan alihkan kembali ke halaman cyber-local
if ($qq) {
    echo '<script>alert("Delete Data Successfully.")</script>';
    echo '<meta http-equiv="refresh" content="0;url=?page=riskmanagement/cybersecurity/cyber-local">';
} else {
    echo '<script>alert("Failed to Delete Data.")</script>';
    echo '<meta http-equiv="refresh" content="0;url=?page=riskmanagement/cybersecurity/cyber-local">';
}
?>
