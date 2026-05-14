<!-- Nav Header Component Start -->
<div class="iq-navbar-header" style="height: 215px">
	<div class="container-fluid iq-container">
		<div class="row">
			<div class="col-md-12">
				<div class="flex-wrap d-flex justify-content-between align-items-center">
					<div>
						<h1>Update CIP</h1>
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
		<div class="card-body">
			<?php

			// Cek apakah pengguna sudah login
			if (!isset($_SESSION['user'])) {
				echo '<div class="alert alert-danger">You must be logged in to access this page.</div>';
				exit;
			}

			// Ambil data berdasarkan ID
			$id_cip = isset($_GET['id']) ? $_GET['id'] : null;
			if (!$id_cip) {
				die('<div class="alert alert-danger">Invalid ID.</div>');
			}

			$query = mysqli_query($koneksi, "SELECT * FROM cip WHERE id='$id_cip'");
			$data = mysqli_fetch_array($query);

			if (!$data) {
				die('<div class="alert alert-danger">Data not found.</div>');
			}

			if (isset($_POST['update'])) {
				$date = mysqli_real_escape_string($koneksi, $_POST['date']);
				$title = mysqli_real_escape_string($koneksi, $_POST['title']);
				$technician = isset($_POST['technician']) ? implode(',', $_POST['technician']) : ''; // Menggabungkan teknisi yang dipilih
				$result = mysqli_real_escape_string($koneksi, $_POST['result']);

				// Proses upload file
				$upload_treatise = $data['upload_treatise']; // Default ke file yang ada
				if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
					$upload_dir = 'uploads/'; // Ganti dengan direktori upload Anda

					if (!is_dir($upload_dir)) {
						mkdir($upload_dir, 0777, true);
					}

					$target_file = $upload_dir . basename($_FILES["file"]["name"]);
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
						$upload_treatise = basename($_FILES["file"]["name"]); // Simpan nama file baru
					} else {
						echo '<div class="alert alert-danger">Sorry, there was an error uploading your file.</div>';
					}
				}

				// Validasi input
				if (empty($date) || empty($title) || empty($technician) || empty($upload_treatise) || empty($result)) {
					echo '<div class="alert alert-danger">Please fill in all required fields.</div>';
				} else {
					// Query update
					$sql = "UPDATE cip SET date='$date', title='$title', technician='$technician', upload_treatise='$upload_treatise', result='$result' WHERE id='$id_cip'";
					$query = mysqli_query($koneksi, $sql);

					if ($query) {
						echo '<div class="alert alert-success">Update Data Successfully.</div>';
						echo '<meta http-equiv="refresh" content="1;url=?page=kpi/cip">';
					} else {
						echo '<div class="alert alert-danger">Update Data Failed: ' . mysqli_error($koneksi) . '</div>';
					}
				}
			}
			?>

			<form method="post" enctype="multipart/form-data" class="form-horizontal">
				<div class="form-group row">
					<label class="control-label col-sm-2 align-self-center mb-0" for="date">Date:</label>
					<div class="col-sm-5">
						<input type="date" class="form-control" id="date" name="date" value="<?php echo $data['date']; ?>" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-2 align-self-center mb-0" for="title">Title:</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" id="title" name="title" value="<?php echo $data['title']; ?>" required>
					</div>
				</div>
				<div class="form-group row">
					<label for="file" class="control-label col-sm-2 align-self-center mb-0">Upload Treatise:</label>
					<div class="col-sm-5">
						<input type="file" name="file" id="file" class="form-control">
						<small>Current file: <?php echo $data['upload_treatise']; ?></small>
					</div>
				</div>
				<div class="form-group">
					<label class="form-label">Member:</label>
					<div class="card p-4" style="background-color:rgb(218, 234, 254);">
						<div class="row">
							<?php
							$tec = mysqli_query($koneksi, "SELECT * FROM teknisi");
							while ($teknisi = mysqli_fetch_array($tec)) {
								$checked = in_array($teknisi['id_teknisi'], explode(',', $data['technician'])) ? 'checked' : '';
							?>
								<div class="col-md-4">
									<div class="bt-df-checkbox" style="padding: 0">
										<div class="i-checks">
											<label style="font-weight: normal">
												<input type="checkbox" name="technician[]" value="<?php echo $teknisi['id_teknisi']; ?>" <?php echo $checked; ?>> <i></i> <?php echo $teknisi['nama']; ?>
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
							<option value="1" <?php echo ($data['result'] == 1) ? 'selected' : ''; ?>>Bronze</option>
							<option value="2" <?php echo ($data['result'] == 2) ? 'selected' : ''; ?>>Silver</option>
							<option value="3" <?php echo ($data['result'] == 3) ? 'selected' : ''; ?>>Gold</option>
						</select>
					</div>
				</div>
				<button type="submit" name="update" class="btn btn-primary">Save Changes</button>
				<a href="?page=kpi/cip" class="btn btn-outline-secondary" style="float: right;">Back</a>
				<button type="reset" class="btn btn-danger" style="float: right;">Reset</button>
			</form>
		</div>
	</div>
</div>