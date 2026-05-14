<!-- Nav Header Component Start -->
<div class="iq-navbar-header" style="height: 215px">
	<div class="container-fluid iq-container">
		<div class="row">
			<div class="col-md-12">
				<div class="flex-wrap d-flex justify-content-between align-items-center">
					<div>
						<h1>Tambah Data CIP</h1>
					</div>
					<div>
						<a href="index.php?page=kpi/cip" class="btn btn-primary btn-soft-light">
							< Kembali
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
		<!-- <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Data CIP</h4>
            </div>
        </div> -->
		<div class="card-body">
			<?php

			// Cek apakah pengguna sudah login
			if (!isset($_SESSION['user'])) {
				echo '<div class="alert alert-danger">You must be logged in to access this page.</div>';
				exit;
			}

			// Koneksi ke database (ganti dengan detail koneksi Anda)
			$koneksi = mysqli_connect("localhost", "root", "", "si-fs_3");
			if (!$koneksi) {
				die("Connection failed: " . mysqli_connect_error());
			}

			// Jika form disubmit
			if (isset($_POST['simpan'])) {
				$id_user = $_SESSION['user']['id_user']; // Pastikan ini ada di session
				$date = $_POST['date'];
				$title = mysqli_real_escape_string($koneksi, $_POST['title']);
				$technician = isset($_POST['technician']) ? implode(',', $_POST['technician']) : '';
				$result = mysqli_real_escape_string($koneksi, $_POST['result']);

				// Ganti 'upload_treatise' dengan 'file'
				$upload_treatise = $_FILES['file']['name'];
				$tmp_name = $_FILES['file']['tmp_name'];
				$upload_dir = 'uploads/';

				// Pastikan folder 'uploads' ada
				if (!is_dir($upload_dir)) {
					mkdir($upload_dir, 0777, true);
				}

				// Pindahkan file ke folder
				if (move_uploaded_file($tmp_name, $upload_dir . $upload_treatise)) {
					// Pastikan kolom yang digunakan sesuai dengan struktur tabel cip
					$query = mysqli_query($koneksi, "INSERT INTO cip (id_user, date, title, upload_treatise, technician, result) VALUES ('$id_user', '$date', '$title', '$upload_treatise', '$technician', '$result')");

					if ($query) {
						echo '<div class="alert alert-success">Data berhasil disimpan.</div>';
						echo '<meta http-equiv="refresh" content="1;url=?page=kpi/cip">';
					} else {
						echo '<div class="alert alert-danger">Gagal menyimpan data: ' . mysqli_error($koneksi) . '</div>';
					}
				} else {
					echo '<div class="alert alert-danger">Gagal mengunggah file.</div>';
				}
			}
			?>

			<form method="post" enctype="multipart/form-data" class="form-horizontal">
				<div class="form-group row">
					<label class="control-label col-sm-2 align-self-center mb-0" for="date">Date:</label>
					<div class="col-sm-5">
						<input type="date" class="form-control" id="date" name="date" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 align-self-center mb-0" for="title">Title:</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" id="title" name="title" required>
					</div>
				</div>
				<div class="form-group row">
					<label for="file" class="control-label col-sm-2 align-self-center mb-0">Upload Treatise:</label>
					<div class="col-sm-5">
						<input type="file" name="file" id="file" class="form-control" required>
					</div>
				</div>
				<div class="form-group">
					<label class="form-label">Member:</label>
					<div class="card p-4" style="background-color:rgb(218, 234, 254);">
						<div class="row">
							<?php
							$tec = mysqli_query($koneksi, "SELECT * FROM teknisi");
							while ($teknisi = mysqli_fetch_array($tec)) {
							?>
								<div class="col-md-4">
									<div class="bt-df-checkbox" style="padding: 0">
										<div class="i-checks">
											<label style="font-weight: normal">
												<input type="checkbox" name="technician[]" value="<?php echo $teknisi['id_teknisi']; ?>"> <i></i> <?php echo $teknisi['nama']; ?>
											</label>
										</div>
									</div>
								</div>
							<?php
							}
							?>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 align-self-center mb-0" for="result">Result:</label>
					<div class="col-sm-5">
						<select name="result" class="form-select shadow-none">
							<option class="" value="1">Bronze</option>
							<option class="" value="2">Silver</option>
							<option class="" value="3">Gold</option>
						</select>
					</div>
				</div>
				<button type="submit" name="simpan" class="btn btn-primary">Save</button>
				<a href="?page=kpi/cip" class="btn btn-outline-secondary" style="float: right;">Back</a>
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