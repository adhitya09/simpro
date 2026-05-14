<?php
$id = $_GET['id'];
$qq = mysqli_query($koneksi, "delete from ph4 where id=$id");
echo '<script>alert("Delete Data Successfully.")</script>';
echo '<meta http-equiv="refresh" content="0;url=?page=projecthandling">';
?>