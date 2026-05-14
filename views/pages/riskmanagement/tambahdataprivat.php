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
			// Pastikan koneksi tersedia
			if (!$koneksi) {
				die("Connection failed: " . mysqli_connect_error());
			}

			// Ambil id_user dari sesi user yang login
			$id_user = $_SESSION['user']['id_user'];

			// Proses penyimpanan data
			if (isset($_POST['simpan'])) {
				// Mengambil data dari form
				$user_id = mysqli_real_escape_string($koneksi, $_POST['user_id']);
				$date = mysqli_real_escape_string($koneksi, $_POST['date']);
				$ticket_number = mysqli_real_escape_string($koneksi, $_POST['ticket_number']);
				$datetime_created = mysqli_real_escape_string($koneksi, $_POST['datetime_created']);
				$datetime_resolved = mysqli_real_escape_string($koneksi, $_POST['datetime_resolved']);
				$ip_source = mysqli_real_escape_string($koneksi, $_POST['ip_source']);
				$hostname = mysqli_real_escape_string($koneksi, $_POST['hostname']);
				$description_of_attacks =  $_POST['description_of_attacks'];
				$action =  $_POST['action'];
				$progress =  $_POST['progress'];
				$status = mysqli_real_escape_string($koneksi, $_POST['status']);

				// Validasi input
				if (empty($user_id) || empty($date) || empty($ticket_number) || empty($datetime_created) || empty($datetime_resolved) || empty($ip_source) || empty($hostname) || empty($description_of_attacks) || empty($action) || empty($progress) || empty($status)) {
					echo '<div class="alert alert-danger">Please fill in all required fields.</div>';
				} else {
					// Simpan data ke database
					$query = mysqli_query($koneksi, "INSERT INTO dataprivat (id_user, user_id, date, ticket_number, datetime_created, datetime_resolved, ip_source, hostname, description_of_attacks, action, progress, status) 
            VALUES ('$id_user', '$user_id', '$date', '$ticket_number', '$datetime_created', '$datetime_resolved', '$ip_source', '$hostname', '$description_of_attacks', '$action', '$progress', '$status')");

					if ($query) {
						echo '<div class="alert alert-success">Add Data Successfully.</div>';
						echo '<meta http-equiv="refresh" content="1;url=?page=riskmanagement/dataprivacy">';
					} else {
						echo '<div class="alert alert-danger">Add Data Failed: ' . mysqli_error($koneksi) . '</div>';
					}
				}
			}
			?>

			<form method="post" enctype="multipart/form-data" class="form-horizontal">
				<div class="form-group row">
					<label class="control-label col-sm-2 align-self-center mb-0" for="date">Date:</label>
					<div class="col-sm-4">
						<input type="date" class="form-control" id="date" name="date" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 align-self-center mb-0" for="ticket_number">Ticket Number:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="ticket_number" name="ticket_number" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 align-self-center mb-0" for="datetime_created">Ticket Created:</label>
					<div class="col-sm-4">
						<input type="datetime-local" class="form-control" id="datetime_created" name="datetime_created" required>
					</div>
					<label class="control-label col-sm-2 align-self-center mb-0" for="datetime_resolved">Ticket Resolved:</label>
					<div class="col-sm-4">
						<input type="datetime-local" class="form-control" id="datetime_resolved" name="datetime_resolved" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 align-self-center mb-0" for="user_id">ID User:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="user_id" name="user_id" required>
					</div>
					<label class="control-label col-sm-2 align-self-center mb-0" for="ip_source">IP Source:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="ip_source" name="ip_source" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 align-self-center mb-0" for="hostname">Hostname:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="hostname" name="hostname" required>
					</div>
				</div>
				<div class="form-group">
					<label class="form-label" for="summernote1">Description of Attacks</label>
					<textarea class="form-control" id="summernote1" rows="5" name="description_of_attacks" required></textarea>
				</div>
				<div class="form-group">
					<label class="form-label" for="summernote2">Action</label>
					<textarea class="form-control" id="summernote2" rows="5" name="action" required></textarea>
				</div>
				<div class="form-group">
					<label class="form-label" for="summernote3">Progress</label>
					<textarea class="form-control" id="summernote3" rows="5" name="progress" required></textarea>
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
				<button type="submit" name="simpan" class="btn btn-primary">Save</button>
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