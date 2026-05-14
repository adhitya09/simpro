<?php

if (!isset($_SESSION['user'])) {
  echo '<div class="alert alert-danger">You must be logged in to access this page.</div>';
  exit;
}

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
            <a href="index.php?page=accountaccess" class="btn btn-primary btn-soft-light">
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


<div class="data-table-area mg-tb-15">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="sparkline13-list">
          <div class="login-btn-inner">
            <?php
            if (isset($_POST['simpan'])) {
              $nama = $_POST['nama'];
              $username = $_POST['username'];
              $role = $_POST['role'];
              $email = $_POST['email'];
              $status = isset($_POST['status']) ? $_POST['status'] : 0;
              $password = md5($_POST['password']);
              $foto = "";

              if ($_FILES['foto']['name'] != "") {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (in_array($_FILES['foto']['type'], $allowedTypes)) {
                  // Ganti __DIR__ dengan $_SERVER['DOCUMENT_ROOT']
                  $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/simpro/html/assets/images/user/';
                  $uploadFile = $uploadDir . basename($_FILES['foto']['name']);

                  // Pindahkan file gambar yang diupload
                  if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadFile)) {
                    $foto = $_FILES['foto']['name'];
                  } else {
                    echo '<div class="alert alert-danger">Failed to upload photo.</div>';
                  }
                } else {
                  echo '<div class="alert alert-danger">Invalid file type. Please upload an image file.</div>';
                }
              }

              // Insert data ke database
              $query = mysqli_query($koneksi, "INSERT INTO user (nama, email, foto, username, password, role, status) 
  VALUES ('$nama', '$email', '$foto', '$username', '$password', '$role', '$status')");

              if ($query) {
                echo '<div class="alert alert-success">Add Data Successfully.</div>';
                echo '<meta http-equiv="refresh" content="1;url=?page=accountaccess">';
              } else {
                echo '<div class="alert alert-danger">Add Data Failed.</div>';
              }
            }
            ?>
            <form method="post" enctype="multipart/form-data">
              <table class="table table-bordered table-striped">
                <tr>
                  <td width="180" style="vertical-align: middle">Name</td>
                  <td><input required type="text" name="nama" class="form-control"></td>
                </tr>
                <tr>
                  <td width="180" style="vertical-align: middle">Email</td>
                  <td><input required type="text" name="email" class="form-control"></td>
                </tr>
                <tr>
                  <td width="180" style="vertical-align: middle">Username</td>
                  <td><input required type="text" name="username" class="form-control"></td>
                </tr>
                <tr>
                  <td width="180" style="vertical-align: middle">Password</td>
                  <td><input required type="password" name="password" class="form-control"></td>
                </tr>
                <tr>
                  <td width="180" style="vertical-align: middle">Role</td>
                  <td>
                    <select name="role" class="form-control">
                      <option value="1">Administrator</option>
                      <option value="2">PIC</option>
                      <option value="3">Pekerja</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td width="180" style="vertical-align: middle">Photos</td>
                  <td><input type="file" name="foto" class="form-control"></td>
                </tr>
                <tr>
                  <td width="180" style="vertical-align: middle">Status</td>
                  <td>
                    <div class="bt-df-checkbox" style="padding: 0">
                      <div class="form-check form-switch form-check-inline">
                        <input class="form-check-input" type="checkbox" id="switchStatus" name="status" value="1" checked>
                        <label class="form-check-label" for="switchStatus">On Switch</label>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                    <button type="submit" name="simpan" class="btn btn-primary" value="simpan">Save</button>
                    <button type="reset" class="btn btn-custon-two btn-danger">Reset</button>
                    <a href="?page=accountaccess" class="btn btn-outline-secondary" style="float: right;">Back</a>
                  </td>
                </tr>
              </table>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>