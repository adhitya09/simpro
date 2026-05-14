<!-- Nav Header Component Start -->
<div class="iq-navbar-header" style="height: 215px">
  <div class="container-fluid iq-container">
    <div class="row">
      <div class="col-md-12">
        <div
          class="flex-wrap d-flex justify-content-between align-items-center">
          <div>
            <h1>CIP</h1>
            <!-- <p>
              deskripsi halaman disini..
            </p> -->
          </div>
          <div>
            <a href="index.php?page=kpi/tambahcip" class="btn btn-primary btn-soft-light">
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
            <th data-field="date">Date</th>
            <th data-field="title">Title</th>
            <th data-field="technician">Member</th>
            <th data-field="upload_treatise">Upload Treatise</th>
            <th data-field="result">Result</th>
            <th data-field="action" data-width="150">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          $query = mysqli_query($koneksi, "SELECT * FROM cip");
          while ($data = mysqli_fetch_array($query)) {
            // Tampilkan data di sini
          ?>
            <tr>
              <td>
                <p><?php echo $i++; ?></p>
              </td>
              <td>
                <p><?php echo $data['date']; ?></p>
              </td>
              <td>
                <p><?php echo (strlen($data['title']) > 60) ? substr($data['title'], 0, 60) . '...' : $data['title']; ?></p>
              </td>
              <td>
                <ol style="padding-left: 12px">
                  <?php
                  if ($data['technician']) {
                    $techa = explode(',', $data['technician']);
                    foreach ($techa as $techa_id) {
                      $q = $koneksi->query("SELECT * FROM teknisi WHERE id_teknisi = $techa_id");
                      $teknisi = $q->fetch_array();
                      if ($teknisi) {
                        echo '<li>' . $teknisi['nama'] . '</li>';
                      }
                    }
                  }
                  ?>
                </ol>
              </td>
              <td>
                <p><a href="uploads/<?php echo $data['upload_treatise']; ?>" target="_blank">Lihat File</a></p>
              </td>
              <td>
                <p>
                  <?php
                  switch ($data['result']) {
                    case 1:
                      echo '<img src="/simpro/html/assets/images/medal/3.png" style="width: 30px; height: 30px;">';
                      break;
                    case 2:
                      echo '<img src="/simpro/html/assets/images/medal/2.png" style="width: 30px; height: 30px;">';
                      break;
                    case 3:
                      echo '<img src="/simpro/html/assets/images/medal/1.png" style="width: 30px; height: 30px;">';
                      break;
                  }
                  ?></p>
              </td>
              <td>
                <p>
                  <a href="index.php?page=kpi/editcip&id=<?php echo $data['id']; ?>" class="btn btn-warning"><i class="fa fa-pencil-square text-white"></i></a>
                  <?php
                  if ($role == "1") { ?>
                    <a href="index.php?page=kpi/hapuscip&id=<?php echo $data['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-remove text-white"></i></a>
                  <?php
                  }
                  ?>
                </p>
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