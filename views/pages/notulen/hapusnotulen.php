<?php
$id = $_GET['id'];
$qq = mysqli_query($koneksi, "delete from meeting where id_meeting=$id");
echo '<script>alert("Delete Data Successfully.")</script>';
echo '<meta http-equiv="refresh" content="0;url=?page=notulen">';
?>