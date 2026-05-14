<!-- Nav Header Component Start -->
<div class="iq-navbar-header" style="height: 215px">
	<div class="container-fluid iq-container">
		<div class="row">
			<div class="col-md-12">
				<div class="flex-wrap d-flex justify-content-between align-items-center">
					<div>
						<h1>Add Data</h1>
					</div>
					<div>
						<a href="index.php?page=riskmanagement/cybersecurity/cyber-local" class="btn btn-primary btn-soft-light">
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
			// Pastikan user sudah login
			if (!isset($_SESSION['user']['id_user'])) {
				die('<div class="alert alert-danger">You must be logged in to access this page.</div>');
			}

			if (!$koneksi) {
				die("Connection failed: " . mysqli_connect_error());
			}

			// Cek apakah tombol simpan ditekan
			if (isset($_POST['simpan'])) {
				$id_user = $_SESSION['user']['id_user'];
				$date = $_POST['date'];
				$event = $_POST['event'];
				$risk = $_POST['risk'];
				$mitigation = $_POST['mitigation'];
				$prg = $_POST['prg'];
				$status = $_POST['status'];

				if (empty($date) || empty($event) || empty($risk) || empty($mitigation) || empty($prg) || empty($status)) {
					echo '<div class="alert alert-danger">Please fill in all required fields.</div>';
				} else {
					$query = mysqli_query($koneksi, "INSERT INTO cyber (id_user, date, event, risk, mitigation, prg, status) 
							VALUES ('$id_user', '$date', '$event', '$risk', '$mitigation', '$prg', '$status')");

					if ($query) {
						echo '<div class="alert alert-success">Add Data Successfully.</div>';
						echo '<meta http-equiv="refresh" content="1;url=?page=riskmanagement/cybersecurity/cyber-local">';
					} else {
						echo '<div class="alert alert-danger">Add Data Failed: ' . mysqli_error($koneksi) . '</div>';
					}
				}
			}
			?>

			<form method="post" enctype="multipart/form-data">
				<div class="form-group row">
					<label class="control-label col-sm-2 align-self-center mb-0" for="date">Date:</label>
					<div class="col-sm-4">
						<input type="date" class="form-control" id="date" name="date" required>
					</div>
				</div>
				<div class="form-group">
					<label class="form-label" for="summernote1">Unexpected Event</label>
					<textarea class="form-control" id="summernote1" rows="5" name="event" required></textarea>
				</div>
				<div class="form-group">
					<label class="form-label" for="summernote2">Major Risks</label>
					<textarea class="form-control" id="summernote2" rows="5" name="risk" required></textarea>
				</div>
				<div class="form-group">
					<label class="form-label" for="summernote3">Risk Mitigation</label>
					<textarea class="form-control" id="summernote3" rows="5" name="mitigation" required></textarea>
				</div>
				<div class="form-group">
					<label class="form-label" for="summernote4">Progress</label>
					<textarea class="form-control" id="summernote4" rows="5" name="prg" required></textarea>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 align-self-center mb-0" for="status">Status:</label>
					<div class="col-sm-4">
						<select name="status" class="form-select shadow-none">
							<option class="text-primary" value="1">Open</option>
							<option class="text-info" value="2">In Progress</option>
							<option class="text-secondary" value="3">Hold</option>
							<option class="text-success" value="4">Done</option>
							<option class="text-danger" value="5">Cancel</option>
						</select>
					</div>
				</div>
				<button type="submit" name="simpan" class="btn btn-primary" value="simpan">Save</button>
				<a href="?page=riskmanagement/cybersecurity/cyber-local" class="btn btn-outline-secondary" style="float: right;">Back</a>
				<button type="reset" class="btn btn-danger" style="float: right;">Reset</button>
			</form>
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
<script>
	$('#summernote1').summernote({
		placeholder: 'Enter unexpected event',
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

	$('#summernote2, #summernote3, #summernote4').summernote({
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