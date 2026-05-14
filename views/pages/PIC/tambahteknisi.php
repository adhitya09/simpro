<?php
if ($_SESSION['user']['role'] != 1) {
  // Redirect jika bukan administrator
  header("Location: index.php?page=dashboard");
  exit;
}
?>

<!-- Nav Header Component Start -->
<div class="iq-navbar-header" style="height: 215px">
  <div class="container-fluid iq-container">
    <div class="row">
      <div class="col-md-12">
        <div
          class="flex-wrap d-flex justify-content-between align-items-center">
          <div>
            <h1>Add Data</h1>
          </div>
          <div>
            <a href="index.php?page=teknisi" class="btn btn-primary btn-soft-light">
              < Back
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="iq-header-img">
    <img
      src="/simpro/html/assets/images/dashboard/top-header.png"
      alt="header"
      class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX" />
    <img
      src="/simpro/html/assets/images/dashboard/top-header1.png"
      alt="header"
      class="theme-color-purple-img img-fluid w-100 h-100 animated-scaleX" />
    <img
      src="/simpro/html/assets/images/dashboard/top-header2.png"
      alt="header"
      class="theme-color-blue-img img-fluid w-100 h-100 animated-scaleX" />
    <img
      src="/simpro/html/assets/images/dashboard/top-header3.png"
      alt="header"
      class="theme-color-green-img img-fluid w-100 h-100 animated-scaleX" />
    <img
      src="/simpro/html/assets/images/dashboard/top-header4.png"
      alt="header"
      class="theme-color-yellow-img img-fluid w-100 h-100 animated-scaleX" />
    <img
      src="/simpro/html/assets/images/dashboard/top-header5.png"
      alt="header"
      class="theme-color-pink-img img-fluid w-100 h-100 animated-scaleX" />
  </div>
</div>
<!-- Nav Header Component End -->

<div class="col-12">
  <div class="card">
    <div class="card-header d-flex justify-content-between">
      <div class="header-title">
        <h4 class="card-title">Data Teknisi</h4>
      </div>
    </div>
    <div class="card-body">
      <?php
      if (isset($_POST['simpan'])) {
        $nik = $_POST['nik'];
        $nama = $_POST['nama'];
        $nip = $_POST['nip'];
        $departement = $_POST['departement'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $tempat_lahir = $_POST['tempat_lahir'];
        $tanggal_lahir = $_POST['tanggal_lahir'];
        $umur = $_POST['umur'];
        $edukasi = $_POST['edukasi'];
        $work_location = $_POST['work_location'];
        $email = $_POST['email'];
        $status_pernikahan = $_POST['status_pernikahan'];
        $type = $_POST['type'];
        $hp = $_POST['hp'];
        $alamat_ktp = $_POST['alamat_ktp'];
        $foto = "";

        if ($_FILES['foto']['name'] != "") {
          $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
          if (in_array($_FILES['foto']['type'], $allowedTypes)) {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/simpro/html/assets/images/teknisi/';
            $uploadFile = $uploadDir . basename($_FILES['foto']['name']);

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadFile)) {
              $foto = $_FILES['foto']['name'];
            } else {
              echo '<div class="alert alert-danger">Failed to upload photo.</div>';
            }
          } else {
            echo '<div class="alert alert-danger">Invalid file type. Please upload an image file.</div>';
          }
        }


        $query = mysqli_query($koneksi, "insert into teknisi(nik, nama, nip, departement, jenis_kelamin, tempat_lahir, tanggal_lahir, umur, edukasi, work_location, email, status_pernikahan, type, hp, alamat_ktp,foto) values('$nik', '$nama', '$nip', '$departement', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', '$umur', '$edukasi', '$work_location', '$email', '$status_pernikahan', '$type', '$hp', '$alamat_ktp', '$foto')");
        if ($query) {

          echo '<div class="alert alert-success">Add Data Successfully.</div>';
          echo '<meta http-equiv="refresh" content="1;url=?page=teknisi">';
        } else {
          echo '<div class="alert alert-danger">Add Data Failed.</div>';
        }
      }
      ?>
      <form method="post" enctype="multipart/form-data">
        <table class="table table-bordered table-striped">
          <tr>
            <td width="180" style="vertical-align: middle">Photos</td>
            <td><input type="file" name="foto" class="form-control"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">NIK</td>
            <td><input required type="text" name="nik" class="form-control"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Full Name</td>
            <td><input required type="text" name="nama" class="form-control"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">NIP</td>
            <td><input required type="text" name="nip" class="form-control"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Departements</td>
            <td><input required type="text" name="departement" class="form-control"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Gender</td>
            <td>
              <select name="jenis_kelamin" class="form-control">
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
            </td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Place of Birth</td>
            <td><input required type="text" name="tempat_lahir" class="form-control"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Date of Birth</td>
            <td><input required type="date" name="tanggal_lahir" class="form-control"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Age</td>
            <td><input required type="number" name="umur" class="form-control"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Education</td>
            <td><input required type="text" name="edukasi" class="form-control"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Work Location</td>
            <td><input required type="text" name="work_location" class="form-control"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Email</td>
            <td><input required type="email" name="email" class="form-control"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Marital Status</td>
            <td>
              <select name="status_pernikahan" class="form-control">
                <option value="Kawin">Kawin</option>
                <option value="Belum Kawin">Belum Kawin</option>
              </select>
            </td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Types Of Work</td>
            <td>
              <select name="type" class="form-control">
                <option value="Pekerja">Pekerja</option>
                <option value="Outsourcing">Outsourcing</option>
                <option value="Kontrak Volume">Kontrak Volume</option>
              </select>
            </td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">HP</td>
            <td><input required type="number" step="0" name="hp" class="form-control"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">KTP Address</td>
            <td><input required type="text" name="alamat_ktp" class="form-control"></td>
          </tr>
          <tr>
            <td></td>
            <td>
              <button type="submit" name="simpan" class="btn btn-success btn-flat login-submit-cs" value="simpan">Save</button>
              <button type="reset" class="btn btn-custon-two btn-danger">Reset</button>
              <a href="?page=teknisi" class="btn btn-custon-two btn-default">Back</a>
            </td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>