<!-- Nav Header Component Start -->
<div class="iq-navbar-header" style="height: 215px">
  <div class="container-fluid iq-container">
    <div class="row">
      <div class="col-md-12">
        <div class="flex-wrap d-flex justify-content-between align-items-center">
          <div>
            <h1>Update Data</h1>
          </div>
          <div>
            <a href="index.php?page=riskmanagement/dataprivacy" class="btn btn-primary btn-soft-light">
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
    <div class="card-body">
      <?php

      // Debugging untuk koneksi database
      if (!$koneksi) {
        die("Connection failed: " . mysqli_connect_error());
      }

      // Mendapatkan ID untuk data yang akan diubah
      $id = isset($_GET['id']) ? $_GET['id'] : null;

      if (!$id) {
        echo '<div class="alert alert-danger">Data not found!</div>';
        echo '<meta http-equiv="refresh" content="2;url=index.php?page=riskmanagement/dataprivacy">';
        exit;
      }

      // Mengambil data berdasarkan ID
      $query = mysqli_query($koneksi, "
  SELECT dataprivat.*, user.nama 
  FROM dataprivat 
  LEFT JOIN user ON dataprivat.id_user = user.id_user 
  WHERE dataprivat.id = '$id'
");
      $data = mysqli_fetch_assoc($query);

      if (!$data) {
        echo '<div class="alert alert-danger">Data not found!</div>';
        echo '<meta http-equiv="refresh" content="2;url=index.php?page=riskmanagement/dataprivacy">';
        exit;
      }

      // Proses update data
      if (isset($_POST['update'])) {
        // Mengambil data dari form
        $user_id = mysqli_real_escape_string($koneksi, $_POST['user_id']);
        $date = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['date']));
        $ticket_number = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['ticket_number']));
        $datetime_created = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['datetime_created']));
        $datetime_resolved = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['datetime_resolved']));
        $id_user = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['id_user']));
        $ip_source = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['ip_source']));
        $hostname = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['hostname']));
        $description_of_attacks =  $_POST['description_of_attacks'];
        $action =  $_POST['action'];
        $progress =  $_POST['progress'];
        $status = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['status']));


        // Validasi input
        if (empty($user_id) || empty($date) || empty($ticket_number) || empty($datetime_created) || empty($datetime_resolved) || empty($id_user) || empty($ip_source) || empty($hostname) || empty($description_of_attacks) || empty($action) || empty($progress) || empty($status)) {
          echo '<div class="alert alert-danger">Please fill in all required fields.</div>';
        } else {
          // Update data ke database
          $query = mysqli_query($koneksi, "UPDATE dataprivat SET user_id = '$user_id', date = '$date', ticket_number = '$ticket_number', datetime_created = '$datetime_created', datetime_resolved = '$datetime_resolved', id_user = '$id_user', ip_source = '$ip_source', hostname = '$hostname', description_of_attacks = '$description_of_attacks', action = '$action', progress = '$progress', status = '$status' WHERE id = '$id'");

          if ($query) {
            echo '<div class="alert alert-success">Update Data Successfully.</div>';
            echo '<meta http-equiv="refresh" content="2;url=index.php?page=riskmanagement/dataprivacy">';
          } else {
            echo '<div class="alert alert-danger">Update Data Failed: ' . mysqli_error($koneksi) . '</div>';
          }
        }
      }
      ?>

      <form method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="form-group row">
          <label class="control-label col-sm-2 align-self-center mb-0" for="date">Date:</label>
          <div class="col-sm-4">
            <input type="date" class="form-control" id="date" name="date" value="<?php echo $data['date']; ?>" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-sm-2 align-self-center mb-0" for="ticket_number">Ticket Number:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="ticket_number" name="ticket_number" value="<?php echo $data['ticket_number']; ?>" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-sm-2 align-self-center mb-0" for="datetime_created">Datetime Created:</label>
          <div class="col-sm-4">
            <input type="datetime-local" class="form-control" id="datetime_created" name="datetime_created" value="<?php echo $data['datetime_created']; ?>" required>
          </div>
          <label class="control-label col-sm-3 align-self-center mb-0" for="datetime_resolved">Datetime Resolved:</label>
          <div class="col-sm-3">
            <input type="datetime-local" class="form-control" id="datetime_resolved" name="datetime_resolved" value="<?php echo $data['datetime_resolved']; ?>" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-sm-2 align-self-center mb-0" for="ip_source">Ip Source:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="ip_source" name="ip_source" value="<?php echo $data['ip_source']; ?>" required>
          </div>
          <label class="control-label col-sm-3 align-self-center mb-0" for="user_id">ID User:</label>
          <div class="col-sm-3">
            <input type="text" class="form-control" id="user_id" name="user_id" value="<?php echo $data['user_id']; ?>" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-sm-2 align-self-center mb-0" for="hostname">Hostname:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="hostname" name="hostname" value="<?php echo $data['hostname']; ?>" required>
          </div>
          <label class="control-label col-sm-3 align-self-center mb-0" for="id_user">Officer:</label>
          <div class="col-sm-3">
            <input type="text" class="form-control" value="<?php echo $data['nama']; ?>" readonly>
            <input type="hidden" name="id_user" value="<?php echo $data['id_user']; ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label" for="summernote1">Description of Attacks</label>
          <textarea class="form-control" id="summernote1" rows="5" name="description_of_attacks" required><?php echo $data['description_of_attacks']; ?></textarea>
        </div>
        <div class="form-group">
          <label class="form-label" for="summernote2">Action</label>
          <textarea class="form-control" id="summernote2" rows="5" name="action" required><?php echo $data['action']; ?></textarea>
        </div>
        <div class="form-group">
          <label class="form-label" for="summernote3">Progress</label>
          <textarea class="form-control" id="summernote3" rows="5" name="progress" required><?php echo $data['progress']; ?></textarea>
        </div>
        <div class="form-group row">
          <label class="control-label col-sm-2 align-self-center mb-0" for="status">Status:</label>
          <div class="col-sm-4">
            <select name="status" class="form-select shadow-none">
              <option value="1" <?php if ($data['status'] == 1) echo 'selected'; ?>>Open</option>
              <option value="2" <?php if ($data['status'] == 2) echo 'selected'; ?>>In Progress</option>
              <option value="3" <?php if ($data['status'] == 3) echo 'selected'; ?>>Hold</option>
              <option value="4" <?php if ($data['status'] == 4) echo 'selected'; ?>>Done</option>
              <option value="5" <?php if ($data['status'] == 5) echo 'selected'; ?>>Cancel</option>
            </select>
          </div>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="?page=riskmanagement/dataprivacy" class="btn btn-outline-secondary" style="float: right;">Back</a>
        <button type="reset" class="btn btn-danger" style="float: right;">Reset</button>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
<script>
	$('#summernote1, #summernote2, #summernote3').summernote({
		placeholder: 'Enter details',
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