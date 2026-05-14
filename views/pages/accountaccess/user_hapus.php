<?php
if ($_SESSION['user']['role'] != 1) {
  // Redirect jika bukan administrator
  header("Location: index.php?page=dashboard");
  exit;
}

$id = $_GET['id'];
$qq = mysqli_query($koneksi, "delete from user where id_user=$id");
echo '<script>alert("Delete Data Successfully.")</script>';
echo '<meta http-equiv="refresh" content="0;url=?page=accountaccess">';
?>