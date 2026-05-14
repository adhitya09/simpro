<!-- Nav Header Component Start -->
<div class="iq-navbar-header" style="height: 215px">
  <div class="container-fluid iq-container">
    <div class="row">
      <div class="col-md-12">
        <div
          class="flex-wrap d-flex justify-content-between align-items-center">
          <div>
            <h1>Buat Form BASTP</h1>
            <!-- <p>
              deskripsi halaman disini..
            </p> -->
          </div>
          <!-- <div>
            <a href="index.php?page=notulen/tambahnotulen" class="btn btn-primary btn-soft-light">
              Add Data +
            </a>
          </div> -->
        </div>
      </div>
    </div>
  </div>
  <div class="iq-header-img">
    <img
      src="/Simpro/html/assets/images/dashboard/top-header.png"
      alt="header"
      class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX" />
    <img
      src="/Simpro/html/assets/images/dashboard/top-header1.png"
      alt="header"
      class="theme-color-purple-img img-fluid w-100 h-100 animated-scaleX" />
    <img
      src="/Simpro/html/assets/images/dashboard/top-header2.png"
      alt="header"
      class="theme-color-blue-img img-fluid w-100 h-100 animated-scaleX" />
    <img
      src="/Simpro/html/assets/images/dashboard/top-header3.png"
      alt="header"
      class="theme-color-green-img img-fluid w-100 h-100 animated-scaleX" />
    <img
      src="/Simpro/html/assets/images/dashboard/top-header4.png"
      alt="header"
      class="theme-color-yellow-img img-fluid w-100 h-100 animated-scaleX" />
    <img
      src="/Simpro/html/assets/images/dashboard/top-header5.png"
      alt="header"
      class="theme-color-pink-img img-fluid w-100 h-100 animated-scaleX" />
  </div>
</div>
<!-- Nav Header Component End -->

<?php

if (!isset($_SESSION['user'])) {
    echo '<div class="alert alert-danger">You must be logged in to access this page.</div>';
    exit;
}

$upload_dir = 'uploads/';

if (isset($_POST['simpan'])) {
    $hari = $_POST['hari'];
    $tanggal = $_POST['tanggal'];
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
    $kasus = mysqli_real_escape_string($koneksi, $_POST['kasus']);
    $lokasi = mysqli_real_escape_string($koneksi, $_POST['lokasi']);
    $uraian_pekerjaan = mysqli_real_escape_string($koneksi, $_POST['uraian_pekerjaan']);

    $uploaded_files = [];
    
    function uploadFile($file, $upload_dir, $folder_name) {
        $target_dir = $upload_dir . $folder_name . '/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }
        $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $new_name = uniqid() . '.' . $fileType;
        $target_file = $target_dir . $new_name;
        return move_uploaded_file($file['tmp_name'], $target_file) ? $target_file : null;
    }

    $file_inputs = [
        'permasalahan_upload' => 'permasalahan_upload',
        'proses_perbaikan' => 'proses_perbaikan',
        'sesudah_perbaikan' => 'sesudah_perbaikan',
    ];

    foreach ($file_inputs as $input => $folder) {
        $uploaded_files[$input] = isset($_FILES[$input]) ? uploadFile($_FILES[$input], $upload_dir, $folder) : null;
    }

    $query = mysqli_query($koneksi, "INSERT INTO bastp (hari, tanggal, bulan, tahun, kasus, lokasi, uraian_pekerjaan, permasalahan_upload, proses_perbaikan, sesudah_perbaikan)
                                      VALUES ('$hari', '$tanggal', '$bulan', '$tahun', '$kasus', '$lokasi', '$uraian_pekerjaan', '{$uploaded_files['permasalahan_upload']}', '{$uploaded_files['proses_perbaikan']}', '{$uploaded_files['sesudah_perbaikan']}')");

    if ($query) {
        echo '<div class="alert alert-success">Add Data Successfully.</div>';
        echo '<meta http-equiv="refresh" content="1;url=?page=bastp">';
    } else {
        echo '<div class="alert alert-danger">Add Data Failed.</div>';
    }
}
?>
            <form method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="control-label col-sm-4 align-self-center mb-0" for="hari">Hari:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control border-2" id="hari" name="hari" required
                                    placeholder="Masukkan nama hari, misal: Senin">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-sm-4 align-self-center mb-0" for="tanggal">Tanggal:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control border-2" id="tanggal" name="tanggal" required
                                    placeholder="Masukkan tanggal, misal: sepuluh">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-sm-4 align-self-center mb-0" for="bulan">Bulan:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control border-2" id="bulan" name="bulan" required
                                    placeholder="Masukkan bulan, misal: Februari">
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="control-label col-sm-4 align-self-center mb-0" for="tahun">Tahun:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control border-2" id="tahun" name="tahun" required
                                    placeholder="Masukkan tahun, misal: Dua Ribu Dua Lima">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-sm-4 align-self-center mb-0" for="kasus">Pekerjaan:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control border-2" id="kasus" name="kasus" required
                                    placeholder="Jelaskan pekerjaan yang dilakukan">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-sm-4 align-self-center mb-0" for="lokasi">Lokasi:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control border-2" id="lokasi" name="lokasi" required
                                    placeholder="Masukkan lokasi pekerjaan">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label class="form-label" for="summernote1">Uraian Pekerjaan</label>
                    <textarea class="form-control border-2" id="summernote1" rows="5" name="uraian_pekerjaan"
                        required></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label" for="permasalahan_upload">Permasalahan Upload</label>
                    <input type="file" class="form-control border-2 w-50" name="permasalahan_upload"
                        accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="proses_perbaikan">Proses Perbaikan</label>
                    <input type="file" class="form-control border-2 w-50" name="proses_perbaikan"
                        accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="sesudah_perbaikan">Sesudah Perbaikan</label>
                    <input type="file" class="form-control border-2 w-50" name="sesudah_perbaikan"
                        accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt" required>
                </div>

                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-success" onclick="showExportModal()">Export BASTP</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal untuk Export -->
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export BASTP</h5>
            </div>
            <div class="modal-body">
                <form id="exportForm">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="last_update">Last Update</label>
                        <input type="date" class="form-control" id="last_update" name="last_update" required>
                    </div>
                    <div class="form-group">
                        <label for="jr_officer">Jr. Officer FS MOR VIII</label>
                        <input type="text" class="form-control" id="jr_officer" name="jr_officer" required>
                    </div>
                    <div class="form-group">
                        <label for="sr_spv">Sr. Spv. MOR VIII</label>
                        <input type="text" class="form-control" id="sr_spv" name="sr_spv" required>
                    </div>
                    <div class="form-group">
                        <label for="fuel_manager">Fuel Terminal Manager Namlea</label>
                        <input type="text" class="form-control" id="fuel_manager" name="fuel_manager" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="exportData('excel')">Export to Excel</button>
                <button type="button" class="btn btn-danger" onclick="exportData('pdf')">Export to PDF</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
<script>
    $('#summernote1').summernote({
        placeholder: 'Masukkan uraian pekerjaan',
        tabsize: 2,
        height: 120,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
</script>

<script>
    function showExportModal() {
        $('#exportModal').modal('show');
    }
    
    function exportData(type) {
        let form = document.getElementById('exportForm');
        let formData = new FormData(form);
        let params = new URLSearchParams(formData).toString();
        window.location.href = 'bastp_data.php?type=' + type + '&' + params;
    }
</script>