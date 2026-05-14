<?php
// Aktifkan penampilan error untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<style>
  .project-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }

  .project-table th,
  .project-table td {
    padding: 15px;
    border: 1px solid #ddd;
  }
</style>
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

<!-- Nav Header Component Start -->
<div class="iq-navbar-header" style="height: 215px">
  <div class="container-fluid iq-container">
    <div class="row">
      <div class="col-md-12">
        <div
          class="flex-wrap d-flex justify-content-between align-items-center">
          <div>
            <h1>Dashboard</h1>
            <p>
              Hallo, <?php echo htmlspecialchars($_SESSION['user']['nama']); ?>!
            </p>
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

<div class="container mt-2">
  <!-- Nav Tabs -->
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <a class="nav-link active" id="project-tab" data-bs-toggle="tab" href="#project" role="tab" aria-controls="project" aria-selected="true">Project <span class="badge text-bg-danger"><?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM ph4")); ?></span></a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="kpi-tab" data-bs-toggle="tab" href="#kpi" role="tab" aria-controls="kpi" aria-selected="false">KPI <span class="badge text-bg-danger"><?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM ph4")); ?></span></a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="cip-tab" data-bs-toggle="tab" href="#cip" role="tab" aria-controls="cip" aria-selected="false">CIP <span class="badge text-bg-danger"><?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cip")); ?></span></a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="rfc-tab" data-bs-toggle="tab" href="#rfc" role="tab" aria-controls="rfc" aria-selected="false">RFC <span class="badge text-bg-danger"><?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM ph4")); ?></span></a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="myssc-tab" data-bs-toggle="tab" href="#myssc" role="tab" aria-controls="myssc" aria-selected="false">MYSSC <span class="badge text-bg-danger"><?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cyb_myssc")); ?></span></a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="local-tab" data-bs-toggle="tab" href="#local" role="tab" aria-controls="local" aria-selected="false">Local <span class="badge text-bg-danger"><?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM cyber")); ?></span></a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="dataprivacy-tab" data-bs-toggle="tab" href="#dataprivacy" role="tab" aria-controls="dataprivacy" aria-selected="false">Data Privacy <span class="badge text-bg-danger"><?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM dataprivat")); ?></span></a>
    </li>
  </ul>

  <!-- Tab Content -->
  <div class="row justify-content-center">
    <div class="col-lg-12 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="tab-content" id="myTabContent">
            <!-- project -->
            <div class="tab-pane fade show active" id="project" role="tabpanel" aria-labelledby="project-tab">
              <div class="row">
                <div class="col-lg-6">
                  <div id="projectPieChart"></div>
                </div>
                <div class="col-lg-6">
                  <div id="projectFilterContainer">
                    <form id="projectFilterForm">
                      <div class="row mb-4">
                        <div class="col-lg-4 col-sm-12">
                          <label for="start_date" class="col-form-label">Start Date:</label>
                          <input type="date" id="start_date" class="form-control">
                        </div>
                        <div class="col-lg-4 col-sm-12">
                          <label for="end_date" class="col-form-label">End Date:</label>
                          <input type="date" id="end_date" class="form-control">
                        </div>
                        <div class="col-lg-4 col-sm-12 align-self-end">
                          <button type="button" id="filter_btn" class="btn btn-primary">Apply Filter</button>
                          <button type="reset" class="btn btn-danger">Reset</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div id="projectTableContainer">
                    <div class="accordion my-3" id="accordionPanelsStayOpenExample">
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

                    <table id="projectTable" class="project-table table table-striped" data-toggle="data-table">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Description</th>
                          <th>Progress</th>
                          <th>Status</th>
                          <th class="date-column">Date</th> <!-- Hidden Date Column -->
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        // Mengambil data dari hasil query dan menampilkan dalam tabel
                        $no = 1;
                        $query = "SELECT * FROM ph4";
                        $result = mysqli_query($koneksi, $query);
                        if (!$result) {
                          die("Query Error : " . mysqli_errno($link) . " - " . mysqli_error($link));
                        }

                        while ($data = mysqli_fetch_array($result)) {
                        ?>
                          <tr>
                            <!-- No: Menampilkan nomor otomatis -->
                            <td><?php echo $no++; ?></td>

                            <!-- Project Handling: Mengambil data dari kolom 'work_item' -->
                            <td><a href="?page=kpi/project&&id=<?php echo $data['id']; ?>"><?php echo (strlen($data['work_item']) > 60) ? substr($data['work_item'], 0, 60) . '...' : $data['work_item']; ?></a></td>

                            <!-- Update Progress: Menampilkan progres yang statis -->
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

                                ?></p>
                            </td>
                            <td class="date-column"><?php echo $data['date']; ?></td> <!-- Date Column to filter but hide visually -->
                          </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>
                    <script>
                      document.getElementById('filter_btn').addEventListener('click', function() {
                        var startDate = document.getElementById('start_date').value;
                        var endDate = document.getElementById('end_date').value;

                        // Ensure both start and end date are provided
                        if (!startDate || !endDate) {
                          alert('Please select both start and end dates');
                          return;
                        }

                        console.log("Start Date: " + startDate + " | End Date: " + endDate);

                        // Convert the start and end dates to JavaScript Date objects
                        var start = new Date(startDate);
                        var end = new Date(endDate);

                        console.log("Start: " + start + " | End: " + end);

                        var rows = document.querySelectorAll('#projectTable tbody tr');
                        rows.forEach(function(row) {
                          var rowDate = row.querySelector('.date-column').textContent.trim(); // Get date from table
                          console.log("Row Date: " + rowDate);

                          // Ensure the rowDate is parsed correctly into a Date object
                          var rowDateObj = new Date(rowDate);
                          console.log("Row Date Object: " + rowDateObj);

                          // Compare the dates and hide/show rows based on filter
                          if (rowDateObj >= start && rowDateObj <= end) {
                            row.style.display = ''; // Show row
                          } else {
                            row.style.display = 'none'; // Hide row
                          }
                        });
                      });
                    </script>
                  </div>
                </div>
              </div>
              <script>
                document.getElementById('filter_btn').addEventListener('click', function() {
                  var startDate = document.getElementById('start_date').value;
                  var endDate = document.getElementById('end_date').value;

                  // Ensure both start and end date are provided
                  if (!startDate || !endDate) {
                    alert('Please select both start and end dates');
                    return;
                  }

                  console.log("Start Date: " + startDate + " | End Date: " + endDate);

                  // Convert the start and end dates to JavaScript Date objects
                  var start = new Date(startDate);
                  var end = new Date(endDate);

                  console.log("Start: " + start + " | End: " + end);

                  var rows = document.querySelectorAll('#projectTable tbody tr');
                  rows.forEach(function(row) {
                    var rowDate = row.querySelector('.date-column').textContent.trim(); // Get date from table
                    console.log("Row Date: " + rowDate);

                    // Ensure the rowDate is parsed correctly into a Date object
                    var rowDateObj = new Date(rowDate);
                    console.log("Row Date Object: " + rowDateObj);

                    // Compare the dates and hide/show rows based on filter
                    if (rowDateObj >= start && rowDateObj <= end) {
                      row.style.display = ''; // Show row
                    } else {
                      row.style.display = 'none'; // Hide row
                    }
                  });
                });
              </script>
            </div>

            <!-- kpi -->
            <div class="tab-pane fade" id="kpi" role="tabpanel" aria-labelledby="kpi-tab">
              <div class="row">
                <div class="col-lg-6">
                  <div id="kpiPieChart"></div>
                </div>
                <div class="col-lg-6">
                  <div id="kpiFilterContainer">
                    <form id="kpiFilterForm">
                      <div class="row mb-4">
                        <div class="col-lg-4 col-sm-12">
                          <label for="start_date" class="col-form-label">Start Date:</label>
                          <input type="date" id="kpi_start_date" class="form-control">
                        </div>
                        <div class="col-lg-4 col-sm-12">
                          <label for="end_date" class="col-form-label">End Date:</label>
                          <input type="date" id="kpi_end_date" class="form-control">
                        </div>
                        <div class="col-lg-4 col-sm-12 align-self-end">
                          <button type="button" id="kpi_filter_btn" class="btn btn-primary">Apply Filter</button>
                          <button type="reset" class="btn btn-danger">Reset</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div id="kpiTableContainer">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                      <div class="accordion-item">
                        <h2 class="accordion-header">
                          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                            Get to Know the Notations!
                          </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                          <div class="accordion-body">
                            <div class="row">
                              <div class="col-md-3">
                                <h4>Planning :</h4>
                                <ul>
                                  <li><span class="badge text-bg-success rounded-circle">S</span> : Survey</li>
                                  <li><span class="badge text-bg-warning rounded-circle">D</span> : Design</li>
                                  <li><span class="badge text-bg-primary rounded-circle">T</span> : Topology</li>
                                </ul>
                              </div>
                              <div class="col-md-3">
                                <h4>Preparation :</h4>
                                <ul>
                                  <li><span class="badge text-bg-success rounded-pill">PADI</span> : PADI</li>
                                  <li><span class="badge text-bg-warning rounded-pill">MR</span> : MR</li>
                                  <li><span class="badge text-bg-primary rounded-circle">T</span> : Tender</li>
                                  <li><span class="badge text-bg-info rounded-circle">P</span> : Picking</li>
                                  <li><span class="badge text-bg-secondary rounded-circle">O</span> : Others</li>
                                </ul>
                              </div>
                              <div class="col-md-3">
                                <h4>Implementation :</h4>
                                <ul>
                                  <li><span class="badge text-bg-success rounded-circle">I</span> : Implementation</li>
                                  <li><span class="badge text-bg-warning rounded-circle">M</span> : Monitoring</li>
                                </ul>
                              </div>
                              <div class="col-md-3">
                                <h4>Finalization :</h4>
                                <ul>
                                  <li><span class="badge text-bg-success rounded-pill">UAT</span> : UAT</li>
                                  <li><span class="badge text-bg-warning rounded-pill">BASTP</span> : BASTP</li>
                                  <li><span class="badge text-bg-primary rounded-pill">BASTB</span> : BASTB</li>
                                </ul>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="my-3">
                      <div class="form-group row">
                        <label for="entriesPerPage-myssc" class="form-label col-lg-2">Show entries:</label>
                        <div class="col-lg-2">
                          <select id="entriesPerPage-myssc" class="form-select" onchange="changeEntriesPerPageMyssc()">
                            <option value="20">5</option>
                            <option value="40">10</option>
                            <option value="80">20</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead class="table-primary">
                          <style>
                            th {
                              text-align: center;
                              /* Menyelaraskan teks secara horizontal */
                              vertical-align: middle;
                              /* Menyelaraskan teks secara vertikal */
                            }
                          </style>
                          <tr>
                            <th rowspan="3" class="border-2">No</th>
                            <th rowspan="3" class="border-2">No.RFC</th>
                            <th rowspan="3" class="border-2">Work Item</th>
                            <th rowspan="3" class="border-2">Progress</th>
                            <th colspan="12" class="border-2">TW1</th>
                            <th colspan="12" class="border-2">TW2</th>
                            <th colspan="12" class="border-2">TW3</th>
                            <th colspan="12" class="border-2">TW4</th>
                          </tr>
                          <tr>
                            <!-- Bulan -->
                            <th colspan="4" class="border-2">Jan</th>
                            <th colspan="4" class="border-2">Feb</th>
                            <th colspan="4" class="border-2">Mar</th>
                            <th colspan="4" class="border-2">Apr</th>
                            <th colspan="4" class="border-2">May</th>
                            <th colspan="4" class="border-2">Jun</th>
                            <th colspan="4" class="border-2">Jul</th>
                            <th colspan="4" class="border-2">Aug</th>
                            <th colspan="4" class="border-2">Sep</th>
                            <th colspan="4" class="border-2">Oct</th>
                            <th colspan="4" class="border-2">Nov</th>
                            <th colspan="4" class="border-2">Dec</th>
                          </tr>
                          <tr>
                            <!-- Minggu -->
                            <!-- jan -->
                            <th colspan="1" class="border-2">W1</th>
                            <th colspan="1" class="border-2">W2</th>
                            <th colspan="1" class="border-2">W3</th>
                            <th colspan="1" class="border-2">W4</th>
                            <!-- feb -->
                            <th colspan="1" class="border-2">W1</th>
                            <th colspan="1" class="border-2">W2</th>
                            <th colspan="1" class="border-2">W3</th>
                            <th colspan="1" class="border-2">W4</th>
                            <!-- mar -->
                            <th colspan="1" class="border-2">W1</th>
                            <th colspan="1" class="border-2">W2</th>
                            <th colspan="1" class="border-2">W3</th>
                            <th colspan="1" class="border-2">W4</th>
                            <!-- apr -->
                            <th colspan="1" class="border-2">W1</th>
                            <th colspan="1" class="border-2">W2</th>
                            <th colspan="1" class="border-2">W3</th>
                            <th colspan="1" class="border-2">W4</th>
                            <!-- may -->
                            <th colspan="1" class="border-2">W1</th>
                            <th colspan="1" class="border-2">W2</th>
                            <th colspan="1" class="border-2">W3</th>
                            <th colspan="1" class="border-2">W4</th>
                            <!-- jun -->
                            <th colspan="1" class="border-2">W1</th>
                            <th colspan="1" class="border-2">W2</th>
                            <th colspan="1" class="border-2">W3</th>
                            <th colspan="1" class="border-2">W4</th>
                            <!-- jul -->
                            <th colspan="1" class="border-2">W1</th>
                            <th colspan="1" class="border-2">W2</th>
                            <th colspan="1" class="border-2">W3</th>
                            <th colspan="1" class="border-2">W4</th>
                            <!-- aug -->
                            <th colspan="1" class="border-2">W1</th>
                            <th colspan="1" class="border-2">W2</th>
                            <th colspan="1" class="border-2">W3</th>
                            <th colspan="1" class="border-2">W4</th>
                            <!-- sep -->
                            <th colspan="1" class="border-2">W1</th>
                            <th colspan="1" class="border-2">W2</th>
                            <th colspan="1" class="border-2">W3</th>
                            <th colspan="1" class="border-2">W4</th>
                            <!-- oct -->
                            <th colspan="1" class="border-2">W1</th>
                            <th colspan="1" class="border-2">W2</th>
                            <th colspan="1" class="border-2">W3</th>
                            <th colspan="1" class="border-2">W4</th>

                            <!-- nov -->
                            <th colspan="1" class="border-2">W1</th>
                            <th colspan="1" class="border-2">W2</th>
                            <th colspan="1" class="border-2">W3</th>
                            <th colspan="1" class="border-2">W4</th>

                            <!-- dec -->
                            <th colspan="1" class="border-2">W1</th>
                            <th colspan="1" class="border-2">W2</th>
                            <th colspan="1" class="border-2">W3</th>
                            <th colspan="1" class="border-2">W4</th>

                          </tr>
                        </thead>
                        <tbody id="table-body">
                          <?php
                          // Fungsi untuk menghitung minggu
                          function calculateWeeks($start_date, $end_date)
                          {
                            if ($start_date === null || $end_date === null) {
                              return []; // Kembalikan array kosong jika salah satu tanggal null
                            }

                            $weeks = [];
                            $start_month = $start_date->format('n');
                            $end_month = $end_date->format('n');

                            for ($month = $start_month; $month <= $end_month; $month++) {
                              if ($month == $start_month) {
                                $start_week = (int)ceil($start_date->format('j') / 7);
                              } else {
                                $start_week = 1; // Minggu pertama
                              }

                              if ($month == $end_month) {
                                $end_week = (int)ceil($end_date->format('j') / 7);
                                // Jika end_week lebih dari 4, set menjadi 4
                                if ($end_week > 4) {
                                  $end_week = 4;
                                }
                              } else {
                                $end_week = 4; // Minggu keempat
                              }

                              // Centang minggu yang sesuai
                              for ($week = $start_week; $week <= $end_week; $week++) {
                                $weeks[$month][$week] = true;
                              }

                              // Tambahkan logika untuk menangani kasus di mana rentang tanggal kurang dari satu minggu
                              if ($start_date->diff($end_date)->days < 7) {
                                // Jika tanggal mulai dan akhir berada dalam minggu yang sama
                                if ($start_month == $end_month) {
                                  $weeks[$start_month][(int)ceil($start_date->format('j') / 7)] = true; // Centang minggu yang sesuai
                                }
                              }
                            }

                            // Jika end_date lebih dari W4, pastikan W4 dicentang
                            if ($end_date->format('j') > 28) {
                              $weeks[$end_month][4] = true; // Centang W4
                            }

                            return $weeks;
                          }

                          $query = mysqli_query($koneksi, "SELECT * FROM ph4");

                          $no = 1;
                          while ($data = mysqli_fetch_array($query)) {
                            // Ambil tanggal untuk setiap bagian
                            $survey_start_date = !empty($data['survey_start_date']) ? new DateTime($data['survey_start_date']) : null;
                            $survey_end_date = !empty($data['survey_end_date']) ? new DateTime($data['survey_end_date']) : null;

                            $design_start_date = !empty($data['design_start_date']) ? new DateTime($data['design_start_date']) : null;
                            $design_end_date = !empty($data['design_end_date']) ? new DateTime($data['design_end_date']) : null;

                            $topologi_start_date = !empty($data['topologi_start_date']) ? new DateTime($data['topologi_start_date']) : null;
                            $topologi_end_date = !empty($data['topologi_end_date']) ? new DateTime($data['topologi_end_date']) : null;

                            $padi_start_date = !empty($data['padi_start_date']) ? new DateTime($data['padi_start_date']) : null;
                            $padi_end_date = !empty($data['padi_end_date']) ? new DateTime($data['padi_end_date']) : null;

                            $mr_start_date = !empty($data['mr_start_date']) ? new DateTime($data['mr_start_date']) : null;
                            $mr_end_date = !empty($data['mr_end_date']) ? new DateTime($data['mr_end_date']) : null;

                            $tender_start_date = !empty($data['tender_start_date']) ? new DateTime($data['tender_start_date']) : null;
                            $tender_end_date = !empty($data['tender_end_date']) ? new DateTime($data['tender_end_date']) : null;

                            $picking_start_date = !empty($data['picking_start_date']) ? new DateTime($data['picking_start_date']) : null;
                            $picking_end_date = !empty($data['picking_end_date']) ? new DateTime($data['picking_end_date']) : null;

                            $others_start_date = !empty($data['others_start_date']) ? new DateTime($data['others_start_date']) : null;
                            $others_end_date = !empty($data['others_end_date']) ? new DateTime($data['others_end_date']) : null;

                            $implementation_start_date = !empty($data['implementation_start_date']) ? new DateTime($data['implementation_start_date']) : null;
                            $implementation_end_date = !empty($data['implementation_end_date']) ? new DateTime($data['implementation_end_date']) : null;

                            $monitoring_start_date = !empty($data['monitoring_start_date']) ? new DateTime($data['monitoring_start_date']) : null;
                            $monitoring_end_date = !empty($data['monitoring_end_date']) ? new DateTime($data['monitoring_end_date']) : null;

                            $uat_start_date = !empty($data['uat_start_date']) ? new DateTime($data['uat_start_date']) : null;
                            $uat_end_date = !empty($data['uat_end_date']) ? new DateTime($data['uat_end_date']) : null;

                            $bastp_start_date = !empty($data['bastp_start_date']) ? new DateTime($data['bastp_start_date']) : null;
                            $bastp_end_date = !empty($data['bastp_end_date']) ? new DateTime($data['bastp_end_date']) : null;

                            $bastb_start_date = !empty($data['bastb_start_date']) ? new DateTime($data['bastb_start_date']) : null;
                            $bastb_end_date = !empty($data['bastb_end_date']) ? new DateTime($data['bastb_end_date']) : null;

                            // Hitung minggu untuk setiap bagian
                            $survey_weeks = calculateWeeks($survey_start_date, $survey_end_date);
                            $design_weeks = calculateWeeks($design_start_date, $design_end_date);
                            $topologi_weeks = calculateWeeks($topologi_start_date, $topologi_end_date);
                            $padi_weeks = calculateWeeks($padi_start_date, $padi_end_date);
                            $mr_weeks = calculateWeeks($mr_start_date, $mr_end_date);
                            $tender_weeks = calculateWeeks($tender_start_date, $tender_end_date);
                            $picking_weeks = calculateWeeks($picking_start_date, $picking_end_date);
                            $others_weeks = calculateWeeks($others_start_date, $others_end_date);
                            $implementation_weeks = calculateWeeks($implementation_start_date, $implementation_end_date);
                            $monitoring_weeks = calculateWeeks($monitoring_start_date, $monitoring_end_date);
                            $uat_weeks = calculateWeeks($uat_start_date, $uat_end_date);
                            $bastp_weeks = calculateWeeks($bastp_start_date, $bastp_end_date);
                            $bastb_weeks = calculateWeeks($bastb_start_date, $bastb_end_date);              ?>
                            <!-- planning -->
                            <tr>
                              <td rowspan="4" class="border-2"><?php echo $no++; ?></td>
                              <td rowspan="4" class="border-2"><a href="?page=rfc&&id=<?php echo $data['id']; ?>"><?php echo $data['rfc']; ?></a></td>
                              <td rowspan="4" class="border-2"><a href="?page=projecthandling&&id=<?php echo $data['id']; ?>"><?php echo (strlen($data['work_item']) > 60) ? substr($data['work_item'], 0, 60) . '...' : $data['work_item']; ?></a></td>
                              <td class="text-start table-primary border-2">Planning</td>
                              <!-- TW1 -->
                              <td class="border-2">
                                <?php
                                // Survey, Design, dan Topologi dalam satu kolom
                                if (isset($survey_weeks[1][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[1][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[1][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[1][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[1][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[1][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[1][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[1][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[1][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[1][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[1][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[1][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <!-- TW2 -->
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[2][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[2][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[2][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[2][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[2][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[2][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[2][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[2][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[2][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[2][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[2][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[2][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <!-- TW3 -->
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[3][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[3][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[3][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[3][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[3][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[3][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[3][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[3][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[3][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[3][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[3][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[3][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <!-- TW4 -->
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[4][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[4][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[4][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[4][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[4][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[4][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[4][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[4][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[4][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[4][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[4][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[4][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <!-- TW5 -->
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[5][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[5][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[5][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[5][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[5][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[5][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[5][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[5][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[5][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[5][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[5][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[5][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <!-- TW6 -->
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[6][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[6][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[6][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[6][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[6][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[6][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[6][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[6][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[6][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[6][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[6][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[6][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <!-- TW7 -->
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[7][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[7][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[7][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[7][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[7][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[7][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[7][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[7][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[7][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[7][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[7][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[7][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <!-- TW8 -->
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[8][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[8][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[8][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[8][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[8][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[8][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[8][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[8][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[8][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[8][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[8][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[8][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <!-- TW9 -->
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[9][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[9][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[9][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[9][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[9][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[9][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[9][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[9][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[9][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[9][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[9][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[9][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <!-- TW10 -->
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[10][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[10][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[10][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[10][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[10][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[10][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[10][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[10][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[10][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[10][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[10][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[10][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <!-- TW11 -->
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[11][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[11][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[11][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[11][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[11][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[11][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[11][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[11][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[11][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[11][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[11][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[11][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <!-- TW12 -->
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[12][1])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[12][1])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[12][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[12][2])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[12][2])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[12][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[12][3])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[12][3])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[12][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($survey_weeks[12][4])) echo '<div><span class="badge text-bg-success rounded-circle">S</span></div> ';
                                if (isset($design_weeks[12][4])) echo '<div><span class="badge text-bg-warning rounded-circle">D</span></div> ';
                                if (isset($topologi_weeks[12][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                ?>
                              </td>
                            </tr>
                            <!-- preparation -->
                            <tr>
                              <td class="text-start border-2 table-primary">Preparation</td>
                              <!-- TW1 -->
                              <td class="border-2">
                                <?php
                                // Survey, Design, dan Topologi dalam satu kolom
                                if (isset($padi_weeks[1][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[1][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[1][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[1][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[1][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[1][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[1][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[1][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[1][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[1][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[1][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[1][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[1][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[1][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[1][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[1][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[1][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[1][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[1][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[1][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <!-- TW2 -->
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[2][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[2][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[2][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[2][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[2][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[2][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[2][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[2][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[2][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[2][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[2][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[2][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[2][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[2][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[2][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[2][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[2][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[2][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[2][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[2][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <!-- TW3 -->
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[3][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[3][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[3][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[3][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[3][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[3][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[3][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[3][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[3][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[3][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[3][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[3][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[3][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[3][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[3][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[3][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[3][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[3][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[3][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[3][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <!-- TW4 -->
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[4][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[4][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[4][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[4][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[4][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[4][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[4][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[4][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[4][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[4][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[4][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[4][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[4][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[4][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[4][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[4][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[4][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[4][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[4][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[4][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <!-- TW5 -->
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[5][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[5][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[5][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[5][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[5][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[5][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[5][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[5][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[5][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[5][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[5][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[5][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[5][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[5][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[5][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[5][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[5][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[5][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[5][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[5][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <!-- TW6 -->
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[6][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[6][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[6][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[6][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[6][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[6][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[6][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[6][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[6][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[6][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[6][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[6][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[6][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[6][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[6][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[6][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[6][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[6][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[6][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[6][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <!-- TW7 -->
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[7][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[7][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[7][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[7][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[7][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[7][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[7][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[7][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[7][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[7][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[7][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[7][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[7][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[7][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[7][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[7][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[7][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[7][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[7][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[7][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <!-- TW8 -->
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[8][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[8][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[8][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[8][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[8][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[8][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[8][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[8][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[8][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[8][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[8][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[8][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[8][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[8][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[8][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[8][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[8][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[8][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[8][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[8][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <!-- TW9 -->
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[9][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[9][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[9][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[9][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[9][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[9][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[9][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[9][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[9][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[9][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[9][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[9][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[9][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[9][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[9][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[9][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[9][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[9][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[9][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[9][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <!-- TW10 -->
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[10][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[10][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[10][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[10][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[10][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[10][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[10][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[10][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[10][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[10][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[10][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[10][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[10][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[10][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[10][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[10][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[10][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[10][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[10][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[10][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <!-- TW11 -->
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[11][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[11][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[11][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[11][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[11][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[11][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[11][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[11][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[11][22])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[11][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[11][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[11][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[11][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[11][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[11][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[11][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[11][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[11][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[11][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[11][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <!-- TW12 -->
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[12][1])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[12][1])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[12][1])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[12][1])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[12][1])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[12][2])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[12][2])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[12][2])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[12][2])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[12][2])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[12][3])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[12][3])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[12][3])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[12][3])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[12][3])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($padi_weeks[12][4])) echo '<div><span class="badge text-bg-success rounded-pill">PADI</span></div> ';
                                if (isset($mr_weeks[12][4])) echo '<div><span class="badge text-bg-warning rounded-pill">MR</span></div> ';
                                if (isset($tender_weeks[12][4])) echo '<div><span class="badge text-bg-primary rounded-circle">T</span></div>';
                                if (isset($picking_weeks[12][4])) echo '<div><span class="badge text-bg-info rounded-circle">P</span></div>';
                                if (isset($others_weeks[12][4])) echo '<div><span class="badge text-bg-secondary rounded-circle">O</span></div>';
                                ?>
                              </td>
                            </tr>
                            <!-- implementation -->
                            <tr>
                              <td class=" text-start table-primary border-2">Implementation</td>
                              <!-- TW1 -->
                              <td class="border-2">
                                <?php
                                // Survey, Design, dan Topologi dalam satu kolom
                                if (isset($implementation_weeks[1][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[1][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[1][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[1][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[1][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[1][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[1][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[1][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <!-- TW2 -->
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[2][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[2][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[2][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[2][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[2][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[2][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[2][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[2][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <!-- TW3 -->
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[3][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[3][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[3][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[3][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[3][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[3][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[3][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[3][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <!-- TW4 -->
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[4][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[4][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[4][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[4][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[4][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[4][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[4][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[4][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <!-- TW5 -->
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[5][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[5][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[5][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[5][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[5][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[5][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[5][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[5][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <!-- TW6 -->
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[6][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[6][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[6][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[6][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[6][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[6][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[6][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[6][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <!-- TW7 -->
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[7][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[7][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[7][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[7][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[7][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[7][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[7][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[7][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <!-- TW8 -->
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[8][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[8][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[8][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[8][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[8][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[8][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[8][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[8][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <!-- TW9 -->
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[9][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[9][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[9][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[9][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[9][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[9][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[9][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[9][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <!-- TW10 -->
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[10][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[10][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[10][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[10][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[10][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[10][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[10][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[10][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <!-- TW11 -->
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[11][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[11][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[11][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[11][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[11][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[11][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[11][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[11][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <!-- TW12 -->
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[12][1])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[12][1])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[12][2])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[12][2])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[12][3])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[12][3])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($implementation_weeks[12][4])) echo '<div><span class="badge text-bg-success rounded-circle">I</span></div> ';
                                if (isset($monitoring_weeks[12][4])) echo '<div><span class="badge text-bg-warning rounded-circle">M</span></div> ';
                                ?>
                              </td>
                            </tr>
                            <tr>
                              <td class="text-start border-2 table-primary">Finalization</td>
                              <!-- TW1 -->
                              <td class="border-2">
                                <?php
                                // Survey, Design, dan Topologi dalam satu kolom
                                if (isset($uat_weeks[1][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[1][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[1][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[1][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[1][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[1][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[1][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[1][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[1][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[1][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[1][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[1][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <!-- TW2 -->
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[2][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[2][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[2][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[2][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[2][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[2][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[2][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[2][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[2][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[2][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[2][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[2][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <!-- TW3 -->
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[3][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[3][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[3][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[3][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[3][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[3][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[3][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[3][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[3][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[3][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[3][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[3][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <!-- TW4 -->
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[4][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[4][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[4][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[4][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[4][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[4][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[4][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[4][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[4][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[4][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[4][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[4][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <!-- TW5 -->
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[5][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[5][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[5][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[5][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[5][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[5][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[5][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[5][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[5][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[5][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[5][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[5][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <!-- TW6 -->
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[6][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[6][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[6][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[6][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[6][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[6][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[6][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[6][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[6][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[6][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[6][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[6][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <!-- TW7 -->
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[7][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[7][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[7][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[7][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[7][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[7][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[7][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[7][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[7][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[7][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[7][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[7][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <!-- TW8 -->
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[8][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[8][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[8][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[8][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[8][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[8][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[8][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[8][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[8][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[8][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[8][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[8][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <!-- TW9 -->
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[9][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[9][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[9][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[9][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[9][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[9][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[9][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[9][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[9][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[9][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[9][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[9][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <!-- TW10 -->
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[10][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[10][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[10][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[10][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[10][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[10][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[10][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[10][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[10][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[10][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[10][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[10][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <!-- TW11 -->
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[11][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[11][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[11][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[11][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[11][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[11][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[11][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[11][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[11][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[11][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[11][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[11][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <!-- TW12 -->
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[12][1])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[12][1])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[12][1])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[12][2])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[12][2])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[12][2])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[12][3])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[12][3])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[12][3])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                              <td class="border-2">
                                <?php
                                if (isset($uat_weeks[12][4])) echo '<div><span class="badge text-bg-success rounded-pill">UAT</span></div> ';
                                if (isset($bastp_weeks[12][4])) echo '<div><span class="badge text-bg-warning rounded-pill">BASTP</span></div> ';
                                if (isset($bastb_weeks[12][4])) echo '<div><span class="badge text-bg-primary rounded-pill">BASTB</span></div>';
                                ?>
                              </td>
                            </tr>
                          <?php
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>

                    <div class="row">
                      <div id="pagination-myssc" class="pagination">
                        <div class="col">
                          <button class="btn btn-primary" id="prev-myssc" onclick="changePageMyssc(-1)">Prev</button>
                        </div>
                        <div class="col tex-center">
                          <span id="page-info-myssc"></span>
                        </div>
                        <div class="col">
                          <button class="btn btn-primary float-end" id="next-myssc" onclick="changePageMyssc(1)">Next</button>
                        </div>
                      </div>
                    </div>
                    <script>
                      let rowsPerPageMyssc = 20; // Default number of rows per page
                      let currentPageMyssc = 1;
                      const tableBodyMyssc = document.getElementById('table-body-myssc');
                      const rowsMyssc = tableBodyMyssc.getElementsByTagName('tr');
                      const totalPagesMyssc = Math.ceil(rowsMyssc.length / rowsPerPageMyssc);

                      function displayRowsMyssc() {
                        const start = (currentPageMyssc - 1) * rowsPerPageMyssc;
                        const end = start + rowsPerPageMyssc;

                        for (let i = 0; i < rowsMyssc.length; i++) {
                          rowsMyssc[i].style.display = (i >= start && i < end) ? '' : 'none';
                        }

                        document.getElementById('page-info-myssc').innerText = `Page ${currentPageMyssc} of ${totalPagesMyssc}`;
                        document.getElementById('prev-myssc').disabled = currentPageMyssc === 1;
                        document.getElementById('next-myssc').disabled = currentPageMyssc === totalPagesMyssc;
                      }

                      function changePageMyssc(direction) {
                        currentPageMyssc += direction;
                        displayRowsMyssc();
                      }

                      function changeEntriesPerPageMyssc() {
                        const select = document.getElementById('entriesPerPage-myssc');
                        rowsPerPageMyssc = parseInt(select.value);
                        currentPageMyssc = 1; // Reset to first page
                        displayRowsMyssc();
                      }

                      // Display rows initially
                      displayRowsMyssc();
                    </script>

                  </div>
                </div>
              </div>
              <script>
                document.getElementById('kpi_filter_btn').addEventListener('click', function() {
                  var startDate = document.getElementById('kpi_start_date').value;
                  var endDate = document.getElementById('kpi_end_date').value;

                  // Ensure both start and end date are provided
                  if (!startDate || !endDate) {
                    alert('Please select both start and end dates');
                    return;
                  }

                  console.log("Start Date: " + startDate + " | End Date: " + endDate);

                  // Convert the start and end dates to JavaScript Date objects
                  var start = new Date(startDate);
                  var end = new Date(endDate);

                  console.log("Start: " + start + " | End: " + end);

                  var rows = document.querySelectorAll('#kpiTable tbody tr');
                  rows.forEach(function(row) {
                    var rowDate = row.querySelector('.date-column').textContent.trim(); // Get date from table
                    console.log("Row Date: " + rowDate);

                    // Ensure the rowDate is parsed correctly into a Date object
                    var rowDateObj = new Date(rowDate);
                    console.log("Row Date Object: " + rowDateObj);

                    // Compare the dates and hide/show rows based on filter
                    if (rowDateObj >= start && rowDateObj <= end) {
                      row.style.display = ''; // Show row
                    } else {
                      row.style.display = 'none'; // Hide row
                    }
                  });
                });
              </script>
            </div>

            <!-- cip -->
            <div class="tab-pane fade" id="cip" role="tabpanel" aria-labelledby="cip-tab">
              <div class="row">
                <div class="col-lg-6">
                  <div id="cipPieChart"></div>
                </div>
                <div class="col-lg-6">
                  <div id="cipFilterContainer">
                    <form id="cipFilterForm">
                      <div class="row mb-4">
                        <div class="col-lg-4 col-sm-12">
                          <label for="start_date" class="col-form-label">Start Date:</label>
                          <input type="date" id="cip_start_date" class="form-control">
                        </div>
                        <div class="col-lg-4 col-sm-12">
                          <label for="end_date" class="col-form-label">End Date:</label>
                          <input type="date" id="cip_end_date" class="form-control">
                        </div>
                        <div class="col-lg-4 col-sm-12 align-self-end">
                          <button type="button" id="cip_filter_btn" class="btn btn-primary">Apply Filter</button>
                          <button type="reset" class="btn btn-danger">Reset</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div id="cipTableContainer">
                    <table class="project-table table table-striped" id="cipTable" data-toggle="data-table">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Date</th>
                          <th>Title</th>
                          <th>Member</th>
                          <th>Upload Treatise</th>
                          <th>Result</th>
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
                                    $q = $koneksi->query("SELECT * FROM user WHERE id_user = $techa_id");
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
                              <p><a href="uploads/<?php echo $data['upload_treatise']; ?>" target="_blank">Download</a></p>
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
                          </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
              <script>
                // Handling the filter button functionality for CIP
                document.getElementById('cip_filter_btn').addEventListener('click', function() {
                  var startDate = document.getElementById('cip_start_date').value;
                  var endDate = document.getElementById('cip_end_date').value;

                  if (!startDate || !endDate) {
                    alert('Please select both start and end dates');
                    return;
                  }

                  var start = new Date(startDate);
                  var end = new Date(endDate);

                  var rows = document.querySelectorAll('#cipTable tbody tr');
                  rows.forEach(function(row) {
                    var rowDate = row.querySelector('td:nth-child(4)').textContent.trim();
                    var rowDateObj = new Date(rowDate);

                    if (rowDateObj >= start && rowDateObj <= end) {
                      row.style.display = ''; // Show row
                    } else {
                      row.style.display = 'none'; // Hide row
                    }
                  });
                });
              </script>
            </div>

            <!-- rfc -->
            <div class="tab-pane fade" id="rfc" role="tabpanel" aria-labelledby="rfc-tab">
              <div class="row">
                <div class="col-lg-6">
                  <div id="rfcPieChart"></div>
                </div>
                <div class="col-lg-6">
                  <div id="rfcFilterContainer">
                    <form id="rfcFilterForm">
                      <div class="row mb-4">
                        <div class="col-lg-4 col-sm-12">
                          <label for="start_date" class="col-form-label">Start Date:</label>
                          <input type="date" id="rfc_start_date" class="form-control">
                        </div>
                        <div class="col-lg-4 col-sm-12">
                          <label for="end_date" class="col-form-label">End Date:</label>
                          <input type="date" id="rfc_end_date" class="form-control">
                        </div>
                        <div class="col-lg-4 col-sm-12 align-self-end">
                          <button type="button" id="rfc_filter_btn" class="btn btn-primary">Apply Filter</button>
                          <button type="reset" class="btn btn-danger">Reset</button>
                        </div>
                      </div>
                    </form>

                  </div>
                </div>
                <div class="col-lg-12">
                  <div id="rfcTableContainer">
                    <div class="mb-3">
                      <div class="form-group row">
                        <label for="entriesPerPage" class="form-label col-lg-2">Show entries:</label>
                        <div class="col-lg-2">
                          <select id="entriesPerPage" class="form-select" onchange="changeEntriesPerPage()">
                            <option value="80">5</option>
                            <option value="160">10</option>
                            <option value="320">20</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <script>
                      let rowsPerPage = 80; // Default jumlah baris per halaman
                      let currentPage = 1;
                      const tableBody = document.getElementById('table-body');
                      const rows = tableBody.getElementsByTagName('tr');
                      const totalPages = Math.ceil(rows.length / rowsPerPage);

                      function displayRows() {
                        const start = (currentPage - 1) * rowsPerPage;
                        const end = start + rowsPerPage;

                        for (let i = 0; i < rows.length; i++) {
                          rows[i].style.display = (i >= start && i < end) ? '' : 'none';
                        }

                        document.getElementById('page-info').innerText = `Page ${currentPage} of ${totalPages}`;
                        document.getElementById('prev').disabled = currentPage === 1;
                        document.getElementById('next').disabled = currentPage === totalPages;
                      }

                      function changePage(direction) {
                        currentPage += direction;
                        displayRows();
                      }

                      function changeEntriesPerPage() {
                        const select = document.getElementById('entriesPerPage');
                        rowsPerPage = parseInt(select.value);
                        currentPage = 1; // Reset ke halaman pertama
                        displayRows();
                      }

                      // Tampilkan baris pertama kali
                      displayRows();
                    </script>
                    <div class="table-responsive">
                      <table id="rfcTable" class="rfc-table table table-striped text-center align-middle">
                        <thead class="table-primary">
                          <tr>
                            <th class="border-2">NO</th>
                            <th class="border-2">Date</th>
                            <th class="border-2">No.RFC</th>
                            <th class="border-2">Work Item</th>
                            <th class="border-2">Update Process</th>
                            <th colspan="2" class="border-2">Upload</th>
                            <th class="border-2">Bobot</th>
                          </tr>
                        </thead>
                        <tbody id="table-body">
                          <?php
                          // Mengambil data dari hasil query dan menampilkan dalam tabel
                          $no = 1;
                          $query = mysqli_query($koneksi, "SELECT * FROM ph4");
                          while ($data = mysqli_fetch_array($query)) {
                            $survey_done = !empty($data['survey_file']) && !empty($data['survey_start_date']) && !empty($data['survey_end_date']);
                            $design_done = !empty($data['design_file']) && !empty($data['design_start_date']) && !empty($data['design_end_date']);
                            $topologi_done = !empty($data['topologi_file']) && !empty($data['topologi_start_date']) && !empty($data['topologi_end_date']);
                            $padi_done = !empty($data['padi_oe']) && !empty($data['padi_tor']) && !empty($data['padi_tkdn']) && !empty($data['padi_start_date']) && !empty($data['padi_tor_start_date']) && !empty($data['padi_tkdn_start_date']) && !empty($data['padi_end_date']) && !empty($data['padi_tor_end_date']) && !empty($data['padi_tkdn_end_date']);
                            $mr_done = !empty($data['mr_oe']) && !empty($data['mr_tender_file']) && !empty($data['mr_start_date']) && !empty($data['mr_end_date']);
                            $tender_done = !empty($data['tender_file']) && !empty($data['tender_start_date']) && !empty($data['tender_end_date']);
                            $picking_done = !empty($data['picking']) && !empty($data['picking_start_date']) && !empty($data['picking_end_date']);
                            $others_done = !empty($data['others']) && !empty($data['others_start_date']) && !empty($data['others_end_date']);
                            $implementation_done = !empty($data['implementation_file']) && !empty($data['implementation_start_date']) && !empty($data['implementation_end_date']) && !empty($data['implementation_description']);
                            $monitoring_done = !empty($data['monitoring_file']) && !empty($data['monitoring_start_date']) && !empty($data['monitoring_end_date']) && !empty($data['monitoring_description']);
                            $uat_done = !empty($data['uat_file']) && !empty($data['uat_start_date']) && !empty($data['uat_end_date']);
                            $bastp_done = !empty($data['bastp_file']) && !empty($data['bastp_start_date']) && !empty($data['bastp_end_date']);
                            $bastb_done = !empty($data['bastb_file']) && !empty($data['bastb_start_date']) && !empty($data['bastb_end_date']);
                          ?>
                            <tr>
                              <td rowspan="16" class="border-2"><?php echo $no++; ?></td>
                              <td rowspan="16" class="border-2"><?php echo $data['date']; ?></td>
                              <td rowspan="16" class="border-2"><?php echo $data['rfc']; ?></td>
                              <td rowspan="16" class="border-2"><a href="?page=kpi/project&&id=<?php echo $data['id']; ?>"><?php echo $data['work_item']; ?></a></td>
                              <td colspan="4" style="background-color: lightgray;" class="border-2">Perencanaan</td>
                            </tr>
                            <tr>
                              <td class="border-2">Survey</td>
                              <th colspan="2" class="border-2"><?php echo $survey_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
                              <td class="border-2"><?php echo $survey_done ? '1' : ''; ?></td>
                            </tr>
                            <tr>
                              <td class="border-2">Design</td>
                              <th colspan="2" class="border-2"><?php echo $design_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
                              <td class="border-2"><?php echo $design_done ? '1' : ''; ?></td>
                            </tr>
                            <tr>
                              <td class="border-2">Topologi</td>
                              <th colspan="2" class="border-2"><?php echo $topologi_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
                              <td class="border-2"><?php echo $topologi_done ? '1' : ''; ?></td>
                            </tr>
                            <tr>
                              <td colspan="4" style="background-color: lightgray;" class="border-2">Penyediaan</td>
                            </tr>
                            <tr>
                              <td class="border-2">PADI</td>
                              <th colspan="2" class="border-2"><?php echo $padi_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
                              <td class="border-2"><?php echo $padi_done ? '1' : ''; ?></td>
                            </tr>
                            <tr>
                              <td class="border-2">MR</td>
                              <th><?php echo $mr_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
                              <th><?php echo $mr_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
                              <td class="border-2"><?php echo $mr_done ? '2' : ''; ?></td>
                            </tr>
                            <tr>
                              <td class="border-2">Tender</td>
                              <th colspan="2" class="border-2"><?php echo $tender_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
                              <td class="border-2"><?php echo $tender_done ? '1' : ''; ?></td>
                            </tr>
                            <tr>
                              <td class="border-2">Picking</td>
                              <th colspan="2" class="border-2"><?php echo $picking_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
                              <td class="border-2"><?php echo $picking_done ? '1' : ''; ?></td>
                            </tr>
                            <tr>
                              <td class="border-2">Others</td>
                              <th colspan="2" class="border-2"><?php echo $others_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
                              <td class="border-2"><?php echo $others_done ? '1' : ''; ?></td>
                            </tr>
                            <tr>
                              <td class="border-2">Implementasi</td>
                              <th colspan="2" class="border-2"><?php echo $implementation_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
                              <td class="border-2"><?php echo $implementation_done ? '1' : ''; ?></td>
                            </tr>
                            <tr>
                              <td class="border-2">Monitoring</td>
                              <th colspan="2" class="border-2"><?php echo $monitoring_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
                              <td class="border-2"><?php echo $monitoring_done ? '1' : ''; ?></td>
                            </tr>
                            <tr>
                              <td colspan="4" style="background-color: lightgray;" class="border-2">Finalisasi Dokumen</td>
                            </tr>
                            <tr>
                              <td class="border-2">UAT</td>
                              <th colspan="2" class="border-2"><?php echo $uat_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
                              <td class="border-2"><?php echo $uat_done ? '1' : ''; ?></td>
                            </tr>
                            <tr>
                              <td class="border-2">BASTP</td>
                              <th colspan="2" class="border-2"><?php echo $bastp_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
                              <td class="border-2"><?php echo $bastp_done ? '1' : ''; ?></td>
                            </tr>
                            <tr>
                              <td class="border-2">BASTB</td>
                              <th colspan="2" class="border-2"><?php echo $bastb_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
                              <td class="border-2"><?php echo $bastb_done ? '1' : ''; ?></td>
                            </tr>
                          <?php
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                    <div class="row">
                      <div id="pagination" class="pagination">
                        <div class="col">
                          <button class="btn btn-primary" id="prev" onclick="changePage(-1)">Prev</button>
                        </div>
                        <div class="col tex-center">
                          <span id="page-info"></span>
                        </div>
                        <div class="col">
                          <button class="btn btn-primary float-end" id="next" onclick="changePage(1)">Next</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <script>
                document.getElementById('rfc_filter_btn').addEventListener('click', function() {
                  var startDate = document.getElementById('rfc_start_date').value;
                  var endDate = document.getElementById('rfc_end_date').value;

                  // Ensure both start and end date are provided
                  if (!startDate || !endDate) {
                    alert('Please select both start and end dates');
                    return;
                  }

                  console.log("Start Date: " + startDate + " | End Date: " + endDate);

                  // Convert the start and end dates to JavaScript Date objects
                  var start = new Date(startDate);
                  var end = new Date(endDate);

                  console.log("Start: " + start + " | End: " + end);

                  var rows = document.querySelectorAll('#rfcTable tbody tr');
                  rows.forEach(function(row) {
                    var rowDate = row.querySelector('.date-column').textContent.trim(); // Get date from table
                    console.log("Row Date: " + rowDate);

                    // Ensure the rowDate is parsed correctly into a Date object
                    var rowDateObj = new Date(rowDate);
                    console.log("Row Date Object: " + rowDateObj);

                    // Compare the dates and hide/show rows based on filter
                    if (rowDateObj >= start && rowDateObj <= end) {
                      row.style.display = ''; // Show row
                    } else {
                      row.style.display = 'none'; // Hide row
                    }
                  });
                });
              </script>
            </div>

            <!-- myssc -->
            <div class="tab-pane fade" id="myssc" role="tabpanel" aria-labelledby="myssc-tab">
              <div class="row">
                <div class="col-lg-6">
                  <div id="mysscPieChart"></div>
                </div>
                <div class="col-lg-6">
                  <div id="mysscFilterContainer">
                    <form id="mysscFilterForm">
                      <div class="row mb-4">
                        <div class="col-lg-4 col-sm-12">
                          <label for="start_date" class="col-form-label">Start Date:</label>
                          <input type="date" id="myssc_start_date" class="form-control">
                        </div>
                        <div class="col-lg-4 col-sm-12">
                          <label for="end_date" class="col-form-label">End Date:</label>
                          <input type="date" id="myssc_end_date" class="form-control">
                        </div>
                        <div class="col-lg-4 col-sm-12 align-self-end">
                          <button type="button" id="myssc_filter_btn" class="btn btn-primary">Apply Filter</button>
                          <button type="reset" class="btn btn-danger">Reset</button>
                        </div>
                      </div>
                    </form>

                  </div>
                </div>
                <div class="col-lg-12">
                  <div id="mysscTableContainer">
                    <table class="project-table table table-striped" id="mysscTable" data-toggle="data-table">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th class="date-column">Date</th>
                          <th>Unexpected Event</th>
                          <th>Major Risks</th>
                          <th>Risk Mitigation</th>
                          <th>Progress</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        // Pastikan koneksi tersedia
                        if (!isset($koneksi)) {
                          die('Database connection not initialized.');
                        }
                        $i = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM cyb_myssc");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                          <tr>
                            <td>
                              <p><?php echo $i++; ?></p>
                            </td>
                            <td>
                              <p class="date-column"><?php echo $data['date']; ?></p>
                            </td>
                            <td>
                              <?php echo (strlen($data['event']) > 60) ? substr($data['event'], 0, 60) . '...' : $data['event']; ?>
                            </td>
                            <td><?php echo (strlen($data['risk']) > 60) ? substr($data['risk'], 0, 60) . '...' : $data['risk']; ?></td>
                            <td>
                              <?php echo (strlen($data['mitigation']) > 60) ? substr($data['mitigation'], 0, 60) . '...' : $data['mitigation']; ?>
                            </td>
                            <td><?php echo (strlen($data['progres']) > 60) ? substr($data['progres'], 0, 60) . '...' : $data['progres']; ?>
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
                          </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <script>
                // Handling the filter button functionality for MYSSC
                document.getElementById('myssc_filter_btn').addEventListener('click', function() {
                  var startDate = document.getElementById('myssc_start_date').value;
                  var endDate = document.getElementById('myssc_end_date').value;

                  if (!startDate || !endDate) {
                    alert('Please select both start and end dates');
                    return;
                  }

                  var start = new Date(startDate);
                  var end = new Date(endDate);

                  var rows = document.querySelectorAll('#mysscTable tbody tr');
                  rows.forEach(function(row) {
                    var rowDate = row.querySelector('td:nth-child(4)').textContent.trim();
                    var rowDateObj = new Date(rowDate);
                    if (rowDateObj >= start && rowDateObj <= end) {
                      row.style.display = ''; // Show row
                    } else {
                      row.style.display = 'none'; // Hide row
                    }
                  });
                });
              </script>
            </div>

            <!-- local -->
            <div class="tab-pane fade" id="local" role="tabpanel" aria-labelledby="local-tab">
              <div class="row">
                <div class="col-lg-6">
                  <div id="localPieChart"></div>
                </div>
                <div class="col-lg-6">
                  <div id="localFilterContainer">
                    <form id="localFilterForm">
                      <div class="row mb-4">
                        <div class="col-lg-4 col-sm-12">
                          <label for="start_date" class="col-form-label">Start Date:</label>
                          <input type="date" id="local_start_date" class="form-control">
                        </div>
                        <div class="col-lg-4 col-sm-12">
                          <label for="end_date" class="col-form-label">End Date:</label>
                          <input type="date" id="local_end_date" class="form-control">
                        </div>
                        <div class="col-lg-4 col-sm-12 align-self-end">
                          <button type="button" id="local_filter_btn" class="btn btn-primary">Apply Filter</button>
                          <button type="reset" class="btn btn-danger">Reset</button>
                        </div>
                      </div>
                    </form>

                  </div>
                </div>
                <div class="col-lg-12">
                  <div id="localTableContainer">
                    <table class="project-table table table-striped" id="localTable" data-toggle="data-table">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Date</th>
                          <th>Unexpected Event</th>
                          <th>Major Risks</th>
                          <th>Risk Mitigation</th>
                          <th>Progress</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        // Pastikan koneksi tersedia
                        if (!isset($koneksi)) {
                          die('Database connection not initialized.');
                        }
                        $i = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM cyber");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                          <tr>
                            <td>
                              <p><?php echo $i++; ?></p>
                            </td>
                            <td>
                              <p><?php echo $data['date']; ?></p>
                            </td>
                            <td>
                              <?php echo (strlen($data['event']) > 60) ? substr($data['event'], 0, 60) . '...' : $data['event']; ?>
                            </td>
                            <td><?php echo (strlen($data['risk']) > 60) ? substr($data['risk'], 0, 60) . '...' : $data['risk']; ?></td>
                            <td>
                              <?php echo (strlen($data['mitigation']) > 60) ? substr($data['mitigation'], 0, 60) . '...' : $data['mitigation']; ?>
                            </td>
                            <td><?php echo (strlen($data['prg']) > 60) ? substr($data['prg'], 0, 60) . '...' : $data['prg']; ?>
                            <td>
                              <p>
                                <?php
                                switch ($data['status']) {
                                  case 1:
                                    echo '<img src="/simpro/html/assets/images/icon_status/open.png" style="width: 30px; height: 30px;">';
                                    break;
                                  case 2:
                                    echo '<img src="/simpro/html/assets/images/icon_status/progress.png" style="width: 30px; height: 30px;">';
                                    break;
                                  case 3:
                                    echo '<img src="/simpro/html/assets/images/icon_status/pending.png" style="width: 30px; height: 30px;">';
                                    break;
                                  case 4:
                                    echo '<img src="/simpro/html/assets/images/icon_status/done.png" style="width: 30px; height: 30px;">';
                                    break;
                                  case 5:
                                    echo '<img src="/simpro/html/assets/images/icon_status/cancel.png" style="width: 30px; height: 30px;">';
                                    break;
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
              <script>
                // Handling the filter button functionality for Local
                document.getElementById('local_filter_btn').addEventListener('click', function() {
                  var startDate = document.getElementById('local_start_date').value;
                  var endDate = document.getElementById('local_end_date').value;

                  if (!startDate || !endDate) {
                    alert('Please select both start and end dates');
                    return;
                  }

                  var start = new Date(startDate);
                  var end = new Date(endDate);

                  var rows = document.querySelectorAll('#localTable tbody tr');
                  rows.forEach(function(row) {
                    var rowDate = row.querySelector('td:nth-child(4)').textContent.trim();
                    var rowDateObj = new Date(rowDate);

                    if (rowDateObj >= start && rowDateObj <= end) {
                      row.style.display = ''; // Show row
                    } else {
                      row.style.display = 'none'; // Hide row
                    }
                  });
                });
              </script>
            </div>

            <!-- data privacy -->
            <div class="tab-pane fade" id="dataprivacy" role="tabpanel" aria-labelledby="dataprivacy-tab">
              <div class="row">
                <div class="col-lg-6">
                  <div id="dataprivacyPieChart"></div>
                </div>
                <div class="col-lg-6">
                  <div id="dataprivacyFilterContainer">
                    <form id="dataprivacyFilterForm">
                      <div class="row mb-4">
                        <div class="col-lg-4 col-sm-12">
                          <label for="start_date" class="col-form-label">Start Date:</label>
                          <input type="date" id="dataprivacy_start_date" class="form-control">
                        </div>
                        <div class="col-lg-4 col-sm-12">
                          <label for="end_date" class="col-form-label">End Date:</label>
                          <input type="date" id="dataprivacy_end_date" class="form-control">
                        </div>
                        <div class="col-lg-4 col-sm-12 align-self-end">
                          <button type="button" id="dataprivacy_filter_btn" class="btn btn-primary">Apply Filter</button>
                          <button type="reset" class="btn btn-danger">Reset</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div id="dataprivacyTableContainer">
                    <table class="project-table table table-striped" id="dataprivacyTable" data-toggle="data-table">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Date</th>
                          <th>Ticket Number</th>
                          <th>Description of Attacks</th>
                          <th>IP Source</th>
                          <th>Hostname</th>
                          <th>ID User</th>
                          <th>Ticket Created</th>
                          <th>Ticket Resolved</th>
                          <th>Action Taken</th>
                          <th>Status</th>
                          <th>Officer</th>
                        </tr>
                      </thead>
                      <tbody id="table-data-dataprivacy">
                        <?php
                        // Pastikan koneksi tersedia
                        if (!isset($koneksi)) {
                          die('Database connection not initialized.');
                        }
                        $i = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM dataprivat");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                          <tr>
                            <td>
                              <p><?php echo $i++; ?></p>
                            </td>
                            <td>
                              <p><?php echo htmlspecialchars($data['date']); ?></p>
                            </td>
                            <td>
                              <p><?php echo htmlspecialchars($data['ticket_number']); ?></p>
                            </td>
                            <td>
                              <?php
                              echo !empty($data['description_of_attacks'])
                                ? (strlen($data['description_of_attacks']) > 60
                                  ? substr($data['description_of_attacks'], 0, 60) . '...'
                                  : $data['description_of_attacks'])
                                : '-';
                              ?>
                            </td>
                            <td>
                              <p><?php echo htmlspecialchars($data['ip_source']); ?></p>
                            </td>
                            <td>
                              <p><?php echo htmlspecialchars($data['hostname']); ?></p>
                            </td>
                            <td>
                              <p><?php echo htmlspecialchars($data['user_id']); ?></p>
                            </td>
                            <td>
                              <p><?php echo htmlspecialchars($data['datetime_created']); ?></p>
                            </td>
                            <td>
                              <p><?php echo htmlspecialchars($data['datetime_resolved']); ?></p>
                            </td>
                            <td>
                              <?php
                              echo !empty($data['description_of_attacks'])
                                ? (strlen($data['description_of_attacks']) > 60
                                  ? substr($data['description_of_attacks'], 0, 60) . '...'
                                  : $data['description_of_attacks'])
                                : '-';
                              ?>
                            </td>

                            <td>
                              <p>
                                <?php
                                $status_icons = [
                                  1 => 'open.png',
                                  2 => 'progress.png',
                                  3 => 'pending.png',
                                  4 => 'done.png',
                                  5 => 'cancel.png',
                                ];
                                $icon_path = $status_icons[$data['status']] ?? 'default.png';
                                echo "<img src='/simpro/../html/assets/images/icon_status/$icon_path' style='width: 30px; height: 30px;'>";
                                ?></p>
                            </td>
                            <td>
                              <p><?php echo $data['nama']; ?></p>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                    <div class="row">
                      <div id="pagination-dataprivacy" class="pagination">
                        <div class="col">
                          <button class="btn btn-primary" id="prev-dataprivacy" onclick="changePageDataPrivacy(-1)">Prev</button>
                        </div>
                        <div class="col tex-center">
                          <span id="page-info-dataprivacy"></span>
                        </div>
                        <div class="col">
                          <button class="btn btn-primary float-end" id="next-dataprivacy" onclick="changePageDataPrivacy(1)">Next</button>
                        </div>
                      </div>
                    </div>
                    <script>
                      let rowsPerPageDataPrivacy = 70; // Default number of rows per page
                      let currentPageDataPrivacy = 1;
                      const tableBodyDataPrivacy = document.getElementById('table-body-dataprivacy');
                      const rowsDataPrivacy = tableBodyDataPrivacy.getElementsByTagName('tr');
                      const totalPagesDataPrivacy = Math.ceil(rowsDataPrivacy.length / rowsPerPageDataPrivacy);

                      function displayRowsDataPrivacy() {
                        const start = (currentPageDataPrivacy - 1) * rowsPerPageDataPrivacy;
                        const end = start + rowsPerPageDataPrivacy;

                        for (let i = 0; i < rowsDataPrivacy.length; i++) {
                          rowsDataPrivacy[i].style.display = (i >= start && i < end) ? '' : 'none';
                        }

                        document.getElementById('page-info-dataprivacy').innerText = `Page ${currentPageDataPrivacy} of ${totalPagesDataPrivacy}`;
                        document.getElementById('prev-dataprivacy').disabled = currentPageDataPrivacy === 1;
                        document.getElementById('next-dataprivacy').disabled = currentPageDataPrivacy === totalPagesDataPrivacy;
                      }

                      function changePageDataPrivacy(direction) {
                        currentPageDataPrivacy += direction;
                        displayRowsDataPrivacy();
                      }

                      function changeEntriesPerPageDataPrivacy() {
                        const select = document.getElementById('entriesPerPage-dataprivacy');
                        rowsPerPageDataPrivacy = parseInt(select.value);
                        currentPageDataPrivacy = 1; // Reset to first page
                        displayRowsDataPrivacy();
                      }

                      // Display rows initially
                      displayRowsDataPrivacy();
                    </script>

                  </div>
                </div>
              </div>
              <script>
                // Handling the filter button functionality for Data Privacy
                document.getElementById('dataprivacy_filter_btn').addEventListener('click', function() {
                  var startDate = document.getElementById('dataprivacy_start_date').value;
                  var endDate = document.getElementById('dataprivacy_end_date').value;

                  if (!startDate || !endDate) {
                    alert('Please select both start and end dates');
                    return;
                  }

                  var start = new Date(startDate);
                  var end = new Date(endDate);

                  var rows = document.querySelectorAll('#dataprivacyTable tbody tr');
                  rows.forEach(function(row) {
                    var rowDate = row.querySelector('td:nth-child(4)').textContent.trim();
                    var rowDateObj = new Date(rowDate);

                    if (rowDateObj >= start && rowDateObj <= end) {
                      row.style.display = ''; // Show row
                    } else {
                      row.style.display = 'none'; // Hide row
                    }
                  });
                });
              </script>
            </div>


          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->
<script>
  // Event listener untuk tab
  document.querySelectorAll('.nav-link').forEach(tab => {
    tab.addEventListener('click', function() {
      const selectedTab = this.getAttribute('href').substring(1); // Mendapatkan ID tab yang dipilih
      console.log(`Tab yang dipilih: ${selectedTab}`);

      // Panggil fungsi untuk render pie chart hanya jika tab yang dipilih adalah project
      if (selectedTab === 'project') {
        projectfetchPieChartData(); // Memanggil fungsi untuk merender pie chart untuk tab project
      }
      // Panggil fungsi untuk render pie chart hanya jika tab yang dipilih adalah kpi
      if (selectedTab === 'kpi') {
        kpifetchPieChartData(); // Memanggil fungsi untuk merender pie chart untuk tab kpi
      }
      // Panggil fungsi untuk render pie chart hanya jika tab yang dipilih adalah cip
      if (selectedTab === 'cip') {
        cipfetchPieChartData(); // Memanggil fungsi untuk merender pie chart untuk tab cip
      }
      // Panggil fungsi untuk render pie chart hanya jika tab yang dipilih adalah rfc
      if (selectedTab === 'rfc') {
        rfcfetchPieChartData(); // Memanggil fungsi untuk merender pie chart untuk tab rfc
      }
      // Panggil fungsi untuk render pie chart hanya jika tab yang dipilih adalah myssc
      if (selectedTab === 'myssc') {
        mysscfetchPieChartData(); // Memanggil fungsi untuk merender pie chart untuk tab myssc
      }
      // Panggil fungsi untuk render pie chart hanya jika tab yang dipilih adalah local
      if (selectedTab === 'local') {
        localfetchPieChartData(); // Memanggil fungsi untuk merender pie chart untuk tab local
      }
      // Panggil fungsi untuk render pie chart hanya jika tab yang dipilih adalah dataprivacy
      if (selectedTab === 'dataprivacy') {
        dataprivacyfetchPieChartData(); // Memanggil fungsi untuk merender pie chart untuk tab dataprivacy
      }
      // Anda dapat menambahkan logika lain jika perlu untuk tab lainnya
    });
  });

  // Fetch pie chart data for Project
  function projectfetchPieChartData() {
    <?php
    // Query to get the count of each status for Project
    $statusCounts = [
      'Open' => 0,
      'In Progress' => 0,
      'Hold' => 0,
      'Done' => 0,
      'Cancel' => 0,
    ];

    $result = mysqli_query($koneksi, "SELECT status FROM ph4");
    while ($row = mysqli_fetch_assoc($result)) {
      switch ($row['status']) {
        case 1:
          $statusCounts['Open']++;
          break;
        case 2:
          $statusCounts['In Progress']++;
          break;
        case 3:
          $statusCounts['Hold']++;
          break;
        case 4:
          $statusCounts['Done']++;
          break;
        case 5:
          $statusCounts['Cancel']++;
          break;
      }
    }

    // Pass PHP data to JavaScript
    echo "var statusCounts = " . json_encode($statusCounts) . ";";
    ?>

    // Create a pie chart with ApexCharts for Project
    var options = {
      series: Object.values(statusCounts),
      chart: {
        type: 'pie',
        height: 350
      },
      labels: Object.keys(statusCounts),
      colors: ['#36A2EB', '#9bc04b', '#ff6b00', '#90ee90', '#FF5733'], // Colors added
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };

    var chart = new ApexCharts(document.querySelector("#projectPieChart"), options);
    chart.render();
  }

  // Fetch pie chart data for KPI
  function kpifetchPieChartData() {
    <?php
    // Query to get the count of each status for KPI
    $statusCounts = [
      'Open' => 0,
      'In Progress' => 0,
      'Hold' => 0,
      'Done' => 0,
      'Cancel' => 0,
    ];

    $result = mysqli_query($koneksi, "SELECT status FROM ph4");
    while ($row = mysqli_fetch_assoc($result)) {
      switch ($row['status']) {
        case 1:
          $statusCounts['Open']++;
          break;
        case 2:
          $statusCounts['In Progress']++;
          break;
        case 3:
          $statusCounts['Hold']++;
          break;
        case 4:
          $statusCounts['Done']++;
          break;
        case 5:
          $statusCounts['Cancel']++;
          break;
      }
    }

    // Pass PHP data to JavaScript
    echo "var statusCounts = " . json_encode($statusCounts) . ";";
    ?>

    // Create a pie chart with ApexCharts for kpi
    var options = {
      series: Object.values(statusCounts),
      chart: {
        type: 'pie',
        height: 350
      },
      labels: Object.keys(statusCounts),
      colors: ['#36A2EB', '#9bc04b', '#ff6b00', '#90ee90', '#FF5733'], // Colors added
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };

    var chart = new ApexCharts(document.querySelector("#kpiPieChart"), options);
    chart.render();
  }

  // Fetch pie chart data for CIP
  function cipfetchPieChartData() {
    <?php
    // Query to get the count of each result for CIP
    $statusCounts = [
      'Bronze' => 0,
      'Silver' => 0,
      'Gold' => 0,
    ];

    $result = mysqli_query($koneksi, "SELECT result FROM cip");
    while ($row = mysqli_fetch_assoc($result)) {
      switch ($row['result']) {
        case 1:
          $statusCounts['Bronze']++;
          break;
        case 2:
          $statusCounts['Silver']++;
          break;
        case 3:
          $statusCounts['Gold']++;
          break;
      }
    }

    // Pass PHP data to JavaScript
    echo "var statusCounts = " . json_encode($statusCounts) . ";";
    ?>

    // Create a pie chart with ApexCharts for CIP
    var options = {
      series: Object.values(statusCounts),
      chart: {
        type: 'pie',
        height: 350
      },
      labels: Object.keys(statusCounts),
      colors: ['#CD7F32', '#C0C0C0', '#FFD700'], // Colors for Gold, Silver, and Bronze
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };

    var chart = new ApexCharts(document.querySelector("#cipPieChart"), options);
    chart.render();
  }

  // Fetch pie chart data for KPI
  function rfcfetchPieChartData() {
    <?php
    // Query to get the count of each status for rfc
    $statusCounts = [
      'Open' => 0,
      'In Progress' => 0,
      'Hold' => 0,
      'Done' => 0,
      'Cancel' => 0,
    ];

    $result = mysqli_query($koneksi, "SELECT status FROM ph4");
    while ($row = mysqli_fetch_assoc($result)) {
      switch ($row['status']) {
        case 1:
          $statusCounts['Open']++;
          break;
        case 2:
          $statusCounts['In Progress']++;
          break;
        case 3:
          $statusCounts['Hold']++;
          break;
        case 4:
          $statusCounts['Done']++;
          break;
        case 5:
          $statusCounts['Cancel']++;
          break;
      }
    }

    // Pass PHP data to JavaScript
    echo "var statusCounts = " . json_encode($statusCounts) . ";";
    ?>

    // Create a pie chart with ApexCharts for rfc
    var options = {
      series: Object.values(statusCounts),
      chart: {
        type: 'pie',
        height: 350
      },
      labels: Object.keys(statusCounts),
      colors: ['#36A2EB', '#9bc04b', '#ff6b00', '#90ee90', '#FF5733'], // Colors added
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };

    var chart = new ApexCharts(document.querySelector("#rfcPieChart"), options);
    chart.render();
  }

  // Fetch pie chart data for Project
  function mysscfetchPieChartData() {
    <?php
    // Ambil role dari session
    $role = $_SESSION['user']['role'] ?? null;

    // Query untuk menghitung jumlah status untuk myssc
    $statusCounts = [
      'Open' => 0,
      'In Progress' => 0,
      'Hold' => 0,
      'Done' => 0,
      'Cancel' => 0,
    ];

    // Menentukan kondisi query berdasarkan role pengguna
    $where = "";
    if ($role != 1) { // Jika bukan admin, tampilkan data berdasarkan id_user
      $id_user = $koneksi->real_escape_string($_SESSION['user']['id_user']);
      $where = "WHERE id_user = '$id_user'"; // Filter berdasarkan id_user
    }

    // Query untuk mengambil status berdasarkan role
    $query = $koneksi->query("SELECT status FROM cyb_myssc $where");

    // Tampilkan error jika query gagal
    if (!$query) {
      die('Query Error: ' . $koneksi->error);
    }

    // Hitung jumlah status
    while ($row = $query->fetch_assoc()) {
      switch ($row['status']) {
        case 1:
          $statusCounts['Open']++;
          break;
        case 2:
          $statusCounts['In Progress']++;
          break;
        case 3:
          $statusCounts['Hold']++;
          break;
        case 4:
          $statusCounts['Done']++;
          break;
        case 5:
          $statusCounts['Cancel']++;
          break;
      }
    }

    // Pass PHP data to JavaScript
    echo "var statusCounts = " . json_encode($statusCounts) . ";";
    ?>


    // Create a pie chart with ApexCharts for myssc
    var options = {
      series: Object.values(statusCounts),
      chart: {
        type: 'pie',
        height: 350
      },
      labels: Object.keys(statusCounts),
      colors: ['#36A2EB', '#9bc04b', '#ff6b00', '#90ee90', '#FF5733'], // Colors added
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };

    var chart = new ApexCharts(document.querySelector("#mysscPieChart"), options);
    chart.render();
  }

  // Fetch pie chart data for Local
  function localfetchPieChartData() {
    <?php
    // Ambil role dari session
    $role = $_SESSION['user']['role'] ?? null;

    // Query untuk menghitung jumlah status untuk myssc
    $statusCounts = [
      'Open' => 0,
      'In Progress' => 0,
      'Hold' => 0,
      'Done' => 0,
      'Cancel' => 0,
    ];

    // Menentukan kondisi query berdasarkan role pengguna
    $where = "";
    if ($role != 1) { // Jika bukan admin, tampilkan data berdasarkan id_user
      $id_user = $koneksi->real_escape_string($_SESSION['user']['id_user']);
      $where = "WHERE id_user = '$id_user'"; // Filter berdasarkan id_user
    }

    // Query untuk mengambil status berdasarkan role
    $query = $koneksi->query("SELECT status FROM cyber $where");

    // Tampilkan error jika query gagal
    if (!$query) {
      die('Query Error: ' . $koneksi->error);
    }

    // Hitung jumlah status
    while ($row = $query->fetch_assoc()) {
      switch ($row['status']) {
        case 1:
          $statusCounts['Open']++;
          break;
        case 2:
          $statusCounts['In Progress']++;
          break;
        case 3:
          $statusCounts['Hold']++;
          break;
        case 4:
          $statusCounts['Done']++;
          break;
        case 5:
          $statusCounts['Cancel']++;
          break;
      }
    }

    // Pass PHP data to JavaScript
    echo "var statusCounts = " . json_encode($statusCounts) . ";";
    ?>

    // Create a pie chart with ApexCharts for Local
    var options = {
      series: Object.values(statusCounts),
      chart: {
        type: 'pie',
        height: 350
      },
      labels: Object.keys(statusCounts),
      colors: ['#36A2EB', '#9bc04b', '#ff6b00', '#90ee90', '#FF5733'], // Colors for Gold, Silver, and Bronze
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };

    var chart = new ApexCharts(document.querySelector("#localPieChart"), options);
    chart.render();
  }

  // Fetch pie chart data for Data Privacy
  function dataprivacyfetchPieChartData() {
    <?php
    // Ambil role dari session
    $role = $_SESSION['user']['role'] ?? null;

    // Query untuk menghitung jumlah status untuk myssc
    $statusCounts = [
      'Open' => 0,
      'In Progress' => 0,
      'Hold' => 0,
      'Done' => 0,
      'Cancel' => 0,
    ];

    // Menentukan kondisi query berdasarkan role pengguna
    $where = "";
    if ($role != 1) { // Jika bukan admin, tampilkan data berdasarkan id_user
      $id_user = $koneksi->real_escape_string($_SESSION['user']['id_user']);
      $where = "WHERE id_user = '$id_user'"; // Filter berdasarkan id_user
    }

    // Query untuk mengambil status berdasarkan role
    $query = $koneksi->query("SELECT status FROM dataprivat $where");

    // Tampilkan error jika query gagal
    if (!$query) {
      die('Query Error: ' . $koneksi->error);
    }

    // Hitung jumlah status
    while ($row = $query->fetch_assoc()) {
      switch ($row['status']) {
        case 1:
          $statusCounts['Open']++;
          break;
        case 2:
          $statusCounts['In Progress']++;
          break;
        case 3:
          $statusCounts['Hold']++;
          break;
        case 4:
          $statusCounts['Done']++;
          break;
        case 5:
          $statusCounts['Cancel']++;
          break;
      }
    }

    // Pass PHP data to JavaScript
    echo "var statusCounts = " . json_encode($statusCounts) . ";";
    ?>

    // Create a pie chart with ApexCharts for Data Privacy
    var options = {
      series: Object.values(statusCounts),
      chart: {
        type: 'pie',
        height: 350
      },
      labels: Object.keys(statusCounts),
      colors: ['#36A2EB', '#9bc04b', '#ff6b00', '#90ee90', '#FF5733'], // Colors for Gold, Silver, and Bronze
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };

    var chart = new ApexCharts(document.querySelector("#dataprivacyPieChart"), options);
    chart.render();
  }
</script>