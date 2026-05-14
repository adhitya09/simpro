<?php
if ($_SESSION['user']['role'] != 1) {
  // Redirect jika bukan administrator
  header("Location: index.php?page=dashboard");
  exit;
}

// Aktifkan error debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ambil data berdasarkan ID pengguna
$id_user = isset($_GET['id']) ? $_GET['id'] : null;
if (!$id_user) {
  die('<div class="alert alert-danger">Invalid ID.</div>');
}

$query = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
$data = mysqli_fetch_array($query);

if (!$data) {
  die('<div class="alert alert-danger">User not found.</div>');
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
            <h1>Update Data</h1>
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

<div class="col-12">
  <div class="card">
    <div class="card-header d-flex justify-content-between">
      <div class="header-title">
        <h4 class="card-title">Edit User Details</h4>
      </div>
    </div>
    <div class="card-body">
      <?php
      if (isset($_POST['update'])) {
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $role = $_POST['role'];
        $email = $_POST['email'];
        $status = isset($_POST['status']) ? $_POST['status'] : 0;
        $password = $_POST['password'];
        $foto = $data['foto'];

        // Jika ada file foto baru yang diunggah
        if ($_FILES['foto']['name'] != "") {
          $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
          if (in_array($_FILES['foto']['type'], $allowedTypes)) {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/simpro/html/assets/images/user/';
            $uploadFile = $uploadDir . basename($_FILES['foto']['name']);

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadFile)) {
              // Hapus foto lama jika ada
              if ($data['foto'] && file_exists($uploadDir . $data['foto'])) {
                unlink($uploadDir . $data['foto']);
              }
              $foto = $_FILES['foto']['name'];
            } else {
              echo '<div class="alert alert-danger">Failed to upload photo.</div>';
            }
          } else {
            echo '<div class="alert alert-danger">Invalid file type. Please upload an image file.</div>';
          }
        }

        // Update data pengguna
        $update_query = mysqli_query($koneksi, "
          UPDATE user SET 
          nama = '$nama', 
          username = '$username', 
          email = '$email', 
          role = '$role', 
          status = '$status', 
          foto = '$foto'
          WHERE id_user = '$id_user'
        ");

        // Update password jika diisi
        if ($password != "") {
          $hashedPassword = md5($password);
          $password_query = mysqli_query($koneksi, "UPDATE user SET password = '$hashedPassword' WHERE id_user = '$id_user'");
        }

        if ($update_query) {
          echo '<div class="alert alert-success">User updated successfully.</div>';
          echo '<meta http-equiv="refresh" content="1;url=?page=accountaccess">';
        } else {
          echo '<div class="alert alert-danger">Failed to update user data.</div>';
        }
      }
      ?>
      <form method="post" enctype="multipart/form-data">
        <table class="table table-bordered table-striped">
          <tr>
            <td width="180">Photo</td>
            <td>
              <input type="file" name="foto" class="form-control">
              <br>
              <img src="/simpro/html/assets/images/user/<?php echo $data['foto']; ?>" alt="Current Photo" width="100">
            </td>
          </tr>
          <tr>
            <td>Name</td>
            <td><input required type="text" name="nama" class="form-control" value="<?php echo $data['nama']; ?>"></td>
          </tr>
          <tr>
            <td>Username</td>
            <td><input required type="text" name="username" class="form-control" value="<?php echo $data['username']; ?>"></td>
          </tr>
          <tr>
            <td>Email</td>
            <td><input required type="email" name="email" class="form-control" value="<?php echo $data['email']; ?>"></td>
          </tr>
          <tr>
            <td>Password (Leave blank to keep unchanged)</td>
            <td><input type="password" name="password" class="form-control"></td>
          </tr>
          <tr>
            <td>Role</td>
            <td>
              <select name="role" class="form-control">
                <option value="1" <?php echo ($data['role'] == 1) ? 'selected' : ''; ?>>Administrator</option>
                <option value="2" <?php echo ($data['role'] == 2) ? 'selected' : ''; ?>>PIC</option>
                <option value="3" <?php echo ($data['role'] == 3) ? 'selected' : ''; ?>>Worker</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>Status</td>
            <td>
              <input type="checkbox" name="status" value="1" <?php echo ($data['status'] == 1) ? 'checked' : ''; ?>>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <button type="submit" name="update" class="btn btn-primary">Update</button>
              <a href="?page=accountaccess" class="btn btn-outline-secondary" style="float: right;">Back</a>     
            </td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
