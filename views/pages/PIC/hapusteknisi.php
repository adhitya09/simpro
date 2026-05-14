<?php

if ($_SESSION['user']['role'] != 1) {
  // Redirect jika bukan administrator
  header("Location: index.php?page=dashboard");
  exit;
}

$id = $_GET['id'];
$qq = mysqli_query($koneksi, "delete from teknisi where id_teknisi=$id");
echo '<script>alert("Delete Data Successfully.")</script>';
echo '<meta http-equiv="refresh" content="0;url=?page=teknisi">';
?>
