<?php

if (!isset($_SESSION['user'])) {
	echo '<div class="alert alert-danger">You must be logged in to access this page.</div>';
	exit;
}
?>

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
						<a href="index.php?page=notulen" class="btn btn-primary btn-soft-light">
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
		<div class="card-header d-flex justify-content-between">
			<div class="header-title">
				<h4 class="card-title">Data Notulen</h4>
			</div>
		</div>
		<div class="card-body">
			<?php
			$id = $_GET['id'];
			$lastId = 1;
			$q = mysqli_query($koneksi, "SELECT*FROM meeting where id_meeting=$id");
			$dt = mysqli_fetch_array($q);
			if ($dt) {
				$lastId = $dt['id_meeting'];
			}
			if (isset($_POST['simpan'])) {
				$date = $_POST['date'];
				$nr = $_POST['nr'];
				$abt = $_POST['abt'];
				$time = $_POST['time'];
				$place = $_POST['place'];
				$ldr = $_POST['ldr'];
				$ntl = $_POST['ntl'];
				$problem = $_POST['problem'];
				$solution = $_POST['solution'];
				$n1d = $_POST['n1d'];
				$technician = implode(',', $_POST['technician']);
				$target = $_POST['target'];
				$realized = $_POST['realized'];
				$status = $_POST['status'];

				$query = mysqli_query($koneksi, "UPDATE meeting set date='$date', nr='$nr', abt='$abt', time='$time', place='$place', ldr='$ldr', ntl='$ntl', problem='$problem', solution='$solution', n1d='$n1d', technician='$technician', target='$target', realized='$realized', status='$status' WHERE id_meeting=$id");
				if ($query) {

					echo '<div class="alert alert-success">Change Data Successfully.</div>';
					echo '<meta http-equiv="refresh" content="1;url=?page=notulen">';
				} else {
					echo '<div class="alert alert-danger">Change Data Failed.</div>';
				}
			}
			?>
			<form method="post" enctype="multipart/form-data" class="form-horizontal">
				<div class="form-group row">
					<label class="control-label col-sm-2 align-self-center mb-0" for="date">Date:</label>
					<div class="col-sm-4">
						<input type="date" class="form-control border-2" id="date" name="date" value="<?php echo $dt['date']; ?>" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 align-self-center mb-0" for="nr">Number:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control border-2" id="nr" name="nr" value="<?php echo $dt['nr']; ?>" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 align-self-center mb-0" for="abt">About:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control border-2" id="abt" name="abt" value="<?php echo $dt['abt']; ?>" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 align-self-center mb-0" for="time">Time:</label>
					<div class="col-sm-4">
						<input type="datetime-local" class="form-control border-2" id="time" name="time" value="<?php echo $dt['time']; ?>" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 align-self-center mb-0" for="place">Place:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control border-2" id="place" name="place" value="<?php echo $dt['place']; ?>" required>
					</div>
				</div>
				<div class="form-group row" style="margin-top: 60px; margin-bottom: 60px;">
					<label class="control-label col-sm-2 align-self-center mb-0" for="ldr">Leaders:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control border-2" id="ldr" name="ldr" value="<?php echo $dt['ldr']; ?>" required>
					</div>
					<label class="control-label col-sm-2 align-self-center mb-0" for="ntl">Notulen:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control border-2" id="ntl" name="ntl" value="<?php echo $dt['ntl']; ?>" required>
					</div>
				</div>
				<div class="form-group">
					<label class="form-label" for="summernote1">Problem to Handle</label>
					<textarea class="form-control border-2" id="summernote1" rows="5" name="problem" required><?php echo $dt['problem']; ?></textarea>
				</div>
				<div class="form-group">
					<label class="form-label" for="summernote2">Solution to Take</label>
					<textarea class="form-control border-2" id="summernote2" rows="5" name="solution" required><?php echo $dt['solution']; ?></textarea>
				</div>
				<div class="form-group">
					<label class="form-label" for="summernote3">Progress</label>
					<textarea class="form-control border-2" id="summernote3" rows="5" name="n1d" required><?php echo $dt['n1d']; ?></textarea>
				</div>
				<div class="form-group">
					<label class="form-label">PIC</label>
					<div class="row">
						<?php
						$tek = explode(',', $dt['technician']);
						$br = mysqli_query($koneksi, "SELECT*FROM teknisi");
						while ($teknisi = mysqli_fetch_array($br)) {
						?>
							<div class="col-md-4">
								<div class="bt-df-checkbox" style="padding: 0">
									<div class="i-checks">
										<label style="font-weight: normal"><input type="checkbox" <?php
																																							foreach ($tek as $item) {
																																								if ($item == $teknisi['id_teknisi']) echo 'checked';
																																							}
																																							?>
												name="technician[]" value="<?php echo $teknisi['id_teknisi']; ?>"> <i></i> <?php echo $teknisi['nama']; ?></label>
									</div>
								</div>
							</div>
						<?php
						}
						?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 align-self-center mb-0" for="target">Target:</label>
					<div class="col-sm-2">
						<input type="text" class="form-control border-2" id="target" name="target" value="<?php echo $dt['target']; ?>" required>
					</div>
					<label class="control-label col-sm-2 align-self-center mb-0" for="realized">Realized:</label>
					<div class="col-sm-2">
						<input type="date" class="form-control border-2" id="realized" name="realized" value="<?php echo $dt['realized']; ?>" required>
					</div>
					<label class="control-label col-sm-2 align-self-center mb-0" for="ntl">Status:</label>
					<div class="col-sm-2">
						<select name="status" class="form-select shadow-none">
							<option class="text-primary" value="1" <?php if ($dt['status'] == 1) echo 'selected'; ?>>Open</option>
							<option class="text-info" value="2" <?php if ($dt['status'] == 2) echo 'selected'; ?>>In Progress</option>
							<option class="text-secondary" value="3" <?php if ($dt['status'] == 3) echo 'selected'; ?>>Hold</option>
							<option class="text-success" value="4" <?php if ($dt['status'] == 4) echo 'selected'; ?>>Done</option>
							<option class="text-danger" value="5" <?php if ($dt['status'] == 5) echo 'selected'; ?>>Cancel</option>
						</select>
					</div>
				</div>
				<button type="submit" name="simpan" class="btn btn-primary" value="simpan">Update</button>
				<a href="?page=notulen" class="btn btn-outline-secondary" style="float: right;">Back</a>
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
		placeholder: 'Hello stand alone ui',
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

	$('#summernote2').summernote({
		placeholder: 'Hello stand alone ui',
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

	$('#summernote3').summernote({
		placeholder: 'Hello stand alone ui',
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