<?php
// Ambil data dari tabel 'ph4'
$query = mysqli_query($koneksi, "SELECT * FROM ph4");
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.js"></script>

<!-- Nav Header Component Start -->
<div class="iq-navbar-header" style="height: 215px" class="border-2">
  <div class="container-fluid iq-container" class="border-2">
    <div class="row" class="border-2">
      <div class="col-md-12">
        <div class="flex-wrap d-flex justify-content-between align-items-center">
          <div>
            <h1>RFC</h1>
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
      <table class="table table-bordered">
        <thead class="table-primary">
          <tr>
            <th class="border-2">No</th>
            <th class="border-2">No.RFC</th>
            <th class="border-2">Work Item</th>
            <th class="border-2">Update</th>
            <th colspan="2" class="border-2">Upload</th>
            <th class="border-2">Evidance</th>
          </tr>
        </thead>
        <tbody id="table-body">
          <?php
          // Mengambil data dari hasil query dan menampilkan dalam tabel
          $no = 1;
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
              <td rowspan="16" class="border-2"><?php echo $data['rfc']; ?></td>
              <td rowspan="16" class="border-2"><a href="?page=kpi/project&&id=<?php echo $data['id']; ?>"><?php echo $data['work_item']; ?></a></td>
              <td colspan="4" style="background-color: lightgray;" class="border-2">Planing</td>
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
              <td colspan="4" style="background-color: lightgray;" class="border-2">Preparation</td>
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
              <td class="border-2">Implementation</td>
              <th colspan="2" class="border-2"><?php echo $implementation_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
              <td class="border-2"><?php echo $implementation_done ? '1' : ''; ?></td>
            </tr>
            <tr>
              <td class="border-2">Monitoring</td>
              <th colspan="2" class="border-2"><?php echo $monitoring_done ? '<i class="fa fa-check" class="border-2"></i>' : ''; ?></th>
              <td class="border-2"><?php echo $monitoring_done ? '1' : ''; ?></td>
            </tr>
            <tr>
              <td colspan="4" style="background-color: lightgray;" class="border-2">Finalization Dokument</td>
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