<?php

// Ambil data dari tabel 'ph4'
$query = mysqli_query($koneksi, "SELECT * FROM ph4");
?>

<!-- Nav Header Component Start -->
<div class="iq-navbar-header" style="height: 215px">
  <div class="container-fluid iq-container">
    <div class="row">
      <div class="col-md-12">
        <div class="flex-wrap d-flex justify-content-between align-items-center">
          <div>
            <h1>Project Handling</h1>
          </div>
          <div>
            <a href="index.php?page=projecthandling/tambahph" class="btn btn-primary btn-soft-light">
              Add Data +
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="iq-header-img">
    <img src="/simpro/html/assets/images/dashboard/top-header.png" alt="header"
      class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX" />
    <img src="/simpro/html/assets/images/dashboard/top-header1.png" alt="header"
      class="theme-color-purple-img img-fluid w-100 h-100 animated-scaleX" />
    <img src="/simpro/html/assets/images/dashboard/top-header2.png" alt="header"
      class="theme-color-blue-img img-fluid w-100 h-100 animated-scaleX" />
    <img src="/simpro/html/assets/images/dashboard/top-header3.png" alt="header"
      class="theme-color-green-img img-fluid w-100 h-100 animated-scaleX" />
    <img src="/simpro/html/assets/images/dashboard/top-header4.png" alt="header"
      class="theme-color-yellow-img img-fluid w-100 h-100 animated-scaleX" />
    <img src="/simpro/html/assets/images/dashboard/top-header5.png" alt="header"
      class="theme-color-pink-img img-fluid w-100 h-100 animated-scaleX" />
  </div>
</div>
<!-- Nav Header Component End -->

<!-- Keterangan Warna -->

<div class="col-12">
  <div class="card">
    <div class="card-body">
      <div class="accordion mb-4" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
              Get to Know the Color Notations!
            </button>
          </h2>
          <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
            <div class="accordion-body">
              <div class="row">
                <div class="col-md-2" style="display: flex; align-items: center;">
                  <div class="progress-item planning" style="background-color: white; border-color: grey;"></div>
                  <span style="margin-left: 10px;">Incomplete</span>
                </div>
                <div class="col-md-2" style="display: flex; align-items: center;">
                  <div class="progress-item planning" style="background-color: orange; border-color: orange;"></div>
                  <span style="margin-left: 10px;">Planning</span>
                </div>
                <div class="col-md-2" style="display: flex; align-items: center;">
                  <div class="progress-item preparation" style="background-color: blue; border-color: blue;"></div>
                  <span style="margin-left: 10px;">Preparation</span>
                </div>
                <div class="col-md-2" style="display: flex; align-items: center;">
                  <div class="progress-item implementation" style="background-color: red; border-color: red;"></div>
                  <span style="margin-left: 10px;">Implementation</span>
                </div>
                <div class="col-md-2" style="display: flex; align-items: center;">
                  <div class="progress-item finalization" style="background-color: green; border-color: green;"></div>
                  <span style="margin-left: 10px;">Finalization</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <br>
      <table id="datatable" class="project-table table table-striped" data-toggle="data-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Description</th>
            <th>Progress</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          while ($data = mysqli_fetch_array($query)) {
          ?>
            <tr>
              <td><?php echo $no++; ?></td>
              <td style="text-align: left;">
                <a href="?page=kpi/project&&id=<?php echo $data['id']; ?>">
                  <?php echo (strlen($data['work_item']) > 60) ? substr($data['work_item'], 0, 60) . '...' : $data['work_item']; ?>
                </a>
              </td>
              <td>
                <p>
                  <?php
                  $planning_active = false;
                  $preparation_active = false;
                  $implementation_active = false;
                  $finalization_active = false;

                  if (
                    !empty($data['date']) && !empty($data['work_item']) && !empty($data['survey_start_date']) && !empty($data['survey_end_date']) &&
                    !empty($data['survey_file']) && !empty($data['design_start_date']) && !empty($data['design_end_date']) &&
                    !empty($data['design_file']) && !empty($data['topologi_start_date']) && !empty($data['topologi_end_date']) &&
                    !empty($data['topologi_file'])
                  ) {
                    $planning_active = true;
                  }

                  if (
                    !empty($data['padi_oe']) && !empty($data['padi_tor']) && !empty($data['padi_tkdn']) ||
                    !empty($data['mr_oe']) && !empty($data['mr_tender_file']) && !empty($data['mr_start_date']) && !empty($data['mr_end_date']) ||
                    !empty($data['tender_oe']) && !empty($data['tender_start_date']) && !empty($data['tender_end_date']) ||
                    !empty($data['picking']) && !empty($data['picking_start_date']) && !empty($data['picking_end_date']) ||
                    !empty($data['others']) && !empty($data['others_start_date']) && !empty($data['others_end_date'])
                  ) {
                    $preparation_active = true;
                  }

                  if (
                    !empty($data['implementation_description']) && !empty($data['implementation_file']) &&
                    !empty($data['implementation_start_date']) && !empty($data['implementation_end_date']) &&
                    !empty($data['monitoring_description']) && !empty($data['monitoring_file']) &&
                    !empty($data['monitoring_start_date']) && !empty($data['monitoring_end_date'])
                  ) {
                    $implementation_active = true;
                  }

                  if (
                    !empty($data['uat_file']) && !empty($data['uat_start_date']) && !empty($data['uat_end_date']) &&
                    !empty($data['bastp_file']) && !empty($data['bastp_start_date']) && !empty($data['bastp_end_date']) &&
                    !empty($data['bastb_file']) && !empty($data['bastb_start_date']) && !empty($data['bastb_end_date'])
                  ) {
                    $finalization_active = true;
                  }
                  ?>

                <div class="progress-timeline">
                  <div class="progress-item planning <?php echo $planning_active ? 'active' : ''; ?>">
                  </div>
                  <div class="line"></div>
                  <div class="progress-item preparation <?php echo $preparation_active ? 'active' : ''; ?>">
                  </div>
                  <div class="line"></div>
                  <div class="progress-item implementation <?php echo $implementation_active ? 'active' : ''; ?>">
                  </div>
                  <div class="line"></div>
                  <div class="progress-item finalization <?php echo $finalization_active ? 'active' : ''; ?>">
                  </div>

                </div>
                </p>
              </td>

              <!-- Status: Mengambil data dari kolom 'status' -->
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

                  ?>
                </p>
              </td>

              <!-- Action: Tampilkan tombol untuk mengedit dan menghapus -->
              <td>
                <a href="?page=projecthandling/editph&&id=<?php echo $data['id']; ?>" class="btn btn-warning"
                  style="color: #FFF;">
                  <i class="fa fa-pencil-square"></i>
                </a>
                <?php if ($role == "1") { ?>
                  <a href="?page=projecthandling/hapusph&&id=<?php echo $data['id']; ?>" class="btn btn-danger"
                    style="color: #FFF;" onclick="return confirm('Are you sure to delete this data?')"><i
                      class="fa fa-remove"></i></a>
                <?php } ?>
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

<style>
  .progress-timeline {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .progress-item {
    width: 30px;
    height: 30px;
    border: 3px solid #ddd;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: white;
    position: relative;
  }

  .progress-item span {
    font-size: 12px;
    text-align: center;
    position: absolute;
    bottom: -20px;
    width: 100%;
  }

  .line {
    height: 3px;
    width: 100px;
    background-color: #ddd;
  }

  /* Warna Aktif */
  .progress-item.planning.active {
    background-color: orange;
    border-color: orange;
    color: white;
  }

  .progress-item.preparation.active {
    background-color: blue;
    border-color: blue;
    color: white;
  }

  .progress-item.implementation.active {
    background-color: red;
    border-color: red;
    color: white;
  }

  .progress-item.finalization.active {
    background-color: green;
    border-color: green;
    color: white;
  }

  /* Garis berubah warna jika tahap sebelumnya aktif */
  .planning.active+.line {
    background-color: orange;
  }

  .preparation.active+.line {
    background-color: blue;
  }

  .implementation.active+.line {
    background-color: red;
  }

  .finalization.active+.line {
    background-color: green;
  }
</style>