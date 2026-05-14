<!-- Nav Header Component Start -->
<div class="iq-navbar-header" style="height: 215px">
  <div class="container-fluid iq-container">
    <div class="row">
      <div class="col-md-12">
        <div
          class="flex-wrap d-flex justify-content-between align-items-center">
          <div>
            <h1>Notulen</h1>
            <p>
            </p>
          </div>
          <div>
            <a href="index.php?page=notulen/tambahnotulen" class="btn btn-primary btn-soft-light">
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
            <th data-field="nr">Number</th>
            <th data-field="problem">Problem to Handle</th>
            <th data-field="solution">Solution to Take</th>
            <th data-field="n1d">Progress</th>
            <th data-field="technician">PIC</th>
            <th data-field="target">Target</th>
            <th data-field="status" data-align="center">Status</th>
            <th data-field="action" data-width="150">Action</th>
          </tr>
        </thead>
        <tbody>

          <?php
          $i = 1;
          $where = "";
          if ($role != 1) {
            $where = $_SESSION['user']['id_user'];
            $query = $koneksi->query("SELECT meeting.*, user.nama from meeting
                                      LEFT JOIN user on user.id_user = meeting.id_user
                                      WHERE meeting.id_user=" . $where . "");
          } else {
            $query = $koneksi->query("SELECT meeting.*, user.nama from meeting
                                      LEFT JOIN user on user.id_user = meeting.id_user");
          }

          while ($data = $query->fetch_array()) {
          ?>
            <tr>
              <td>
                <p><?php echo $i++; ?></p>
              </td>
              <td>
                <p><?php echo $data['date']; ?></p>
              </td>
              <td>
                <p><?php echo $data['nr']; ?></p>
              </td>
              <td><?php echo (strlen($data['problem']) > 60) ? substr($data['problem'], 0, 60) . '...' : $data['problem']; ?></td>
              <td><?php echo (strlen($data['solution']) > 60) ? substr($data['solution'], 0, 60) . '...' : $data['solution']; ?></td>
              <td><?php echo (strlen($data['n1d']) > 50) ? substr($data['n1d'], 0, 50) . '...' : $data['n1d']; ?></td>
              <td>
                <p>
                  <?php
                  if ($data['technician']) {
                  ?>
                <ol style="padding-left: 12px">
                  <?php
                    $techa = explode(',', $data['technician']);
                    foreach ($techa as $techa) {
                      $q = mysqli_query($koneksi, "SELECT*FROM teknisi where id_teknisi=$techa");
                      $techa = mysqli_fetch_array($q);
                  ?>
                    <li><?php echo $techa['nama']; ?></li>
                  <?php
                    }
                  ?>
                </ol>
              <?php
                  }
              ?></p>
              </td>
              <td>
                <p><?php echo $data['target']; ?></p>
              </td>
              <td>
                <p>
                  <?php
                  switch ($data['status']) {
                    case 1:
                      echo '<img src="/simpro/html/assets/images/icon_status/open.png" style="width: 30px; height: 30px;">';
                      break;
                    case 2:
                      echo '<img src="/simpro/html/assets/images/icon_status/progress.png"  style="width: 30px; height: 30px;">';
                      break;
                    case 3:
                      echo '<img src="/simpro/html/assets/images/icon_status/pending.png"  style="width: 30px; height: 30px;">';
                      break;
                    case 4:
                      echo '<img src="/simpro/html/assets/images/icon_status/done.png"  style="width: 30px; height: 30px;">';
                      break;
                    case 5:
                      echo '<img src="/simpro/html/assets/images/icon_status/cancel.png"  style="width: 30px; height: 30px;">';
                      break;
                  }
                  ?></p>
              </td>
              <td>
                <p>
                  <a href="?page=notulen/ubahnotulen&&id=<?php echo $data['id_meeting']; ?>" class="btn btn-warning" style="color: #FFF;"><i class="fa fa-pencil-square"></i></a>
                  <?php if ($role == "1") { ?>
                    <a href="?page=notulen/hapusnotulen&&id=<?php echo $data['id_meeting']; ?>"
                      class="btn btn-danger"
                      style="color: #FFF;" onclick="return confirm('Are you sure to delete this data?')"><i class="fa fa-remove"></i></a>
                  <?php } ?>
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