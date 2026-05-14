<?php
if ($_SESSION['user']['role'] != 1) {
  // Redirect jika bukan administrator
  header("Location: index.php?page=dashboard");
  exit;
}

$id = $_POST['id'];
$status = isset($_POST['status']) ? $_POST['status'] : 0;

$qq = mysqli_query($koneksi, "update user set status=$status where id_user=$id");
echo '<meta http-equiv="refresh" content="0;url=index.php?page=accountaccess">';
?>