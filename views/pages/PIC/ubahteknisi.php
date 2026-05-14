<?php

if ($_SESSION['user']['role'] != 1) {
  // Redirect jika bukan administrator
  header("Location: index.php?page=dashboard");
  exit;
}

?>

<div class="iq-navbar-header" style="height: 215px">
  <div class="container-fluid iq-container">
    <div class="row">
      <div class="col-md-12">
        <div class="flex-wrap d-flex justify-content-between align-items-center">
          <div>
            <h1>Update Data</h1>
          </div>
          <div>
            <a href="index.php?page=teknisi" class="btn btn-primary btn-soft-light">
              < Back</a>
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

<div class="col-12">
  <div class="card">
    <div class="card-header d-flex justify-content-between">
      <div class="header-title">
        <h4 class="card-title">Update Data Teknisi</h4>
      </div>
    </div>
    <div class="card-body">
      <?php

      // Aktifkan penampilan error untuk debugging
      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);

      // Ambil data berdasarkan ID teknisi
      $id_teknisi = isset($_GET['id']) ? $_GET['id'] : null;
      if (!$id_teknisi) {
        die('<div class="alert alert-danger">Invalid ID.</div>');
      }

      $query = mysqli_query($koneksi, "SELECT * FROM teknisi WHERE id_teknisi='$id_teknisi'");
      $data = mysqli_fetch_array($query);

      if (!$data) {
        die('<div class="alert alert-danger">Technician not found.</div>');
      }
      if (isset($_POST['update'])) {
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
        $foto = $data['foto'];

        // Jika ada file baru yang diunggah
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

        // Update data di database
        $update_query = mysqli_query($koneksi, "
                    UPDATE teknisi SET 
                    nik='$nik', 
                    nama='$nama', 
                    nip='$nip', 
                    departement='$departement', 
                    jenis_kelamin='$jenis_kelamin', 
                    tempat_lahir='$tempat_lahir', 
                    tanggal_lahir='$tanggal_lahir', 
                    umur='$umur', 
                    edukasi='$edukasi', 
                    work_location='$work_location', 
                    email='$email', 
                    status_pernikahan='$status_pernikahan', 
                    type='$type', 
                    hp='$hp', 
                    alamat_ktp='$alamat_ktp', 
                    foto='$foto'
                    WHERE id_teknisi='$id_teknisi'
                ");

        if ($update_query) {
          echo '<div class="alert alert-success">Update Data Successfully.</div>';
          echo '<meta http-equiv="refresh" content="1;url=?page=teknisi">';
        } else {
          echo '<div class="alert alert-danger">Update Data Failed.</div>';
        }
      }
      ?>
      <form method="post" enctype="multipart/form-data">
        <table class="table table-bordered table-striped">
          <tr>
            <td width="180" style="vertical-align: middle">Photos</td>
            <td>
              <input type="file" name="foto" class="form-control">
              <br>
              <img src="/simpro/html/assets/images/teknisi/<?php echo $data['foto']; ?>" alt="Current Photo" width="100">
            </td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">NIK</td>
            <td><input required type="text" name="nik" class="form-control" value="<?php echo $data['nik']; ?>"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Full Name</td>
            <td><input required type="text" name="nama" class="form-control" value="<?php echo $data['nama']; ?>"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">NIP</td>
            <td><input required type="text" name="nip" class="form-control" value="<?php echo $data['nip']; ?>"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Departements</td>
            <td><input required type="text" name="departement" class="form-control" value="<?php echo $data['departement']; ?>"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Gender</td>
            <td>
              <select name="jenis_kelamin" class="form-control">
                <option value="Laki-laki" <?php if ($data['jenis_kelamin'] == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                <option value="Perempuan" <?php if ($data['jenis_kelamin'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
              </select>
            </td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Place of Birth</td>
            <td><input required type="text" name="tempat_lahir" class="form-control" value="<?php echo $data['tempat_lahir']; ?>"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Date of Birth</td>
            <td><input required type="date" name="tanggal_lahir" class="form-control" value="<?php echo $data['tanggal_lahir']; ?>"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Age</td>
            <td><input required type="number" name="umur" class="form-control" value="<?php echo $data['umur']; ?>"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Education</td>
            <td><input required type="text" name="edukasi" class="form-control" value="<?php echo $data['edukasi']; ?>"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Work Location</td>
            <td><input required type="text" name="work_location" class="form-control" value="<?php echo $data['work_location']; ?>"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Email</td>
            <td><input required type="email" name="email" class="form-control" value="<?php echo $data['email']; ?>"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Marital Status</td>
            <td>
              <select name="status_pernikahan" class="form-control">
                <option value="Kawin" <?php if ($data['status_pernikahan'] == 'Kawin') echo 'selected'; ?>>Kawin</option>
                <option value="Belum Kawin" <?php if ($data['status_pernikahan'] == 'Belum Kawin') echo 'selected'; ?>>Belum Kawin</option>
              </select>
            </td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">Types Of Work</td>
            <td>
              <select name="type" class="form-control">
                <option value="Pekerja" <?php if ($data['type'] == 'Pekerja') echo 'selected'; ?>>Pekerja</option>
                <option value="Outsourcing" <?php if ($data['type'] == 'Outsourcing') echo 'selected'; ?>>Outsourcing</option>
                <option value="Kontrak Volume" <?php if ($data['type'] == 'Kontrak Volume') echo 'selected'; ?>>Kontrak Volume</option>
              </select>
            </td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">HP</td>
            <td><input required type="number" step="0" name="hp" class="form-control" value="<?php echo $data['hp']; ?>"></td>
          </tr>
          <tr>
            <td width="180" style="vertical-align: middle">KTP Address</td>
            <td><input required type="text" name="alamat_ktp" class="form-control" value="<?php echo $data['alamat_ktp']; ?>"></td>
          </tr>
          <tr>
            <td></td>
            <td>
              <button type="submit" name="update" class="btn btn-success btn-flat login-submit-cs" value="update">Save Changes</button>
              <a href="?page=teknisi" class="btn btn-custon-two btn-default">Back</a>
            </td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>