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
            <h1>Account Access</h1>
          </div>
          <div>
            <a href="index.php?page=accountaccess/user_tambah" class="btn btn-primary btn-soft-light">
              Add Data +
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
    <div class="card-body">
      <table id="datatable" class="table table-striped" data-toggle="data-table">
        <thead>
          <tr>
            <th data-field="id" data-width="1">No</th>
            <th data-field="foto" data-width="80">Photos</th>
            <th data-field="jenis" data-width="80">Level</th>
            <th data-field="name">Name</th>
            <th data-field="email">Email</th>
            <th data-field="username">Username</th>
            <th data-field="status">Status</th>
            <th data-field="action" data-width="100">Action</th>
          </tr>
        </thead>
        <tbody>

          <?php
          $i = 1;
          $query = mysqli_query($koneksi, "select*from user");
          while ($data = mysqli_fetch_array($query)) {
          ?>
            <tr>
              <td><?php echo $i++; ?></td>
              <td>
                <img src="<?php
                          // Gunakan jalur relatif terhadap root server untuk akses gambar di browser
                          $basePath = '/simpro/html/assets/images/user/';

                          if ($data['foto']) {
                            // Tentukan jalur lengkap gambar yang diambil dari database
                            $fotoPath = $_SERVER['DOCUMENT_ROOT'] . $basePath . $data['foto'];

                            // Cek apakah file gambar ada di server
                            if (file_exists($fotoPath)) {
                              // Jika file ada, gunakan jalur URL relatif
                              $foto = $basePath . $data['foto'];
                            } else {
                              // Jika file tidak ditemukan, gunakan gambar default
                              $foto = $basePath . 'no_image.jpg';
                            }
                          } else {
                            // Jika tidak ada foto di database, gunakan gambar default
                            $foto = $basePath . 'no_image.jpg';
                          }

                          // Tampilkan gambar
                          echo $foto;
                          ?>" width="80">
              </td>

              <td><?php
                  if ($data['role'] == 1) {
                    echo '<div class="bg-success" style="padding:5px 10px;text-align: center;">Administrator</div>';
                  } else if ($data['role'] == 2) {
                    echo '<div class="bg-info" style="padding:5px 10px;text-align: center;">PIC</div>';
                  } else {
                    echo '<div class="bg-danger" style="padding:5px 10px;text-align: center;">Pekerja</div>';
                  }
                  ?></td>
              <td><?php echo $data['nama']; ?></td>
              <td><?php echo $data['email']; ?></td>
              <td><?php echo $data['username']; ?></td>
              <td style="text-align: center;">
                <form method="post" action="index.php?page=accountaccess/user_status">
                  <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input" type="checkbox" id="switch-<?php echo $data['id_user']; ?>"
                      name="status" value="1"
                      <?php if ($data['status'] == 1) echo 'checked'; ?>
                      onchange="this.form.submit()" />
                    <input type="hidden" name="id" value="<?php echo $data['id_user']; ?>">
                    <label class="form-check-label" for="switch-<?php echo $data['id_user']; ?>"></label>
                  </div>
                </form>
              </td>

              <td>
                <?php
                if ($_SESSION['user']['role'] == 1) {
                ?>
                  <a href="?page=accountaccess/user_ubah&&id=<?php echo $data['id_user']; ?>" class="btn btn-warning" style="color: #FFF;"><i class="fa fa-pencil-square"></i></a>
                  <a href="?page=accountaccess/user_hapus&&id=<?php echo $data['id_user']; ?>" class="btn btn-danger" style="color: #FFF;" onclick="return confirm('Are you sure to delete this data?')"><i class="fa fa-remove"></i></a>
                <?php
                }
                ?>
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>