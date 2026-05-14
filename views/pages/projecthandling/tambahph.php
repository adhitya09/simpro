<!-- Nav Header Component Start -->
<div class="iq-navbar-header" style="height: 215px">
	<div class="container-fluid iq-container">
		<div class="row">
			<div class="col-md-12">
				<div class="flex-wrap d-flex justify-content-between align-items-center">
					<div>
						<h1>Tambah Data Project Handling</h1>
					</div>
					<div>
						<a href="index.php?page=projecthandling" class="btn btn-link btn-soft-light">
							< Kembali </a>
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

<div>
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<div class="card">
				<div class="card-body">
					<?php

					if (!isset($_SESSION['user'])) {
						echo '<div class="alert alert-danger">You must be logged in to access this page.</div>';
						exit;
					}

					// Function to generate the next RFC number
					function generateRFCNumber($koneksi)
					{
						$query = "SELECT MAX(CAST(SUBSTRING(rfc, 5) AS UNSIGNED)) AS max_rfc FROM ph4";
						$result = mysqli_query($koneksi, $query);
						$row = mysqli_fetch_assoc($result);
						$next_rfc_number = isset($row['max_rfc']) ? $row['max_rfc'] + 1 : 1; // Start from 1 if no records exist
						return 'RF-' . str_pad($next_rfc_number, 3, '0', STR_PAD_LEFT); // Format as RF-001, RF-002, etc.
					}


					// Generate the RFC number
					$rfc_number = generateRFCNumber($koneksi);


					// Handle form submission
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						// Step 1: Planning
						$date = $_POST['date'];
						$work_item = $_POST['work_item'];
						$technician = isset($_POST['technician']) ? $_POST['technician'] : '';

						// Ambil nama teknisi berdasarkan ID
						if (!empty($technician_ids)) {
							$ids = explode(',', $technician_ids);
							$names = [];
							foreach ($ids as $id) {
								$result = mysqli_query($koneksi, "SELECT nama FROM teknisi WHERE id_teknisi = '$id'");
								if ($row = mysqli_fetch_assoc($result)) {
									$names[] = $row['nama'];
								}
							}
							$technician = implode(',', $names); // Gabungkan nama-nama teknisi
						}

						$survey_start_date = $_POST['survey_start_date'];
						$survey_end_date = $_POST['survey_end_date'];
						$design_start_date = $_POST['design_start_date'];
						$design_end_date = $_POST['design_end_date'];
						$topologi_start_date = $_POST['topologi_start_date'];
						$topologi_end_date = $_POST['topologi_end_date'];


						// Prepare to upload files
						$upload_dir = 'uploads/'; // Ensure this directory exists and is writable
						$uploaded_files = [];

						// Function to handle file uploads
						function uploadFile($file, $upload_dir, $folder_name)
						{
							// Create the full upload path
							$target_dir = $upload_dir . $folder_name . '/';

							// Create the directory if it doesn't exist
							if (!is_dir($target_dir)) {
								mkdir($target_dir, 0755, true);
							}

							if ($file['error'] !== UPLOAD_ERR_OK) {
								echo "Error during file upload: " . $file['error'];
								return false;
							}
							$original_name = basename($file['name']);
							$fileType = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
							$new_name = uniqid() . '.' . $fileType; // Generate a unique name
							$target_file = $target_dir . $new_name;

							// Move the uploaded file to the target directory
							if (move_uploaded_file($file['tmp_name'], $target_file)) {
								return $new_name; // Return the new name
							} else {
								echo "Sorry, there was an error uploading your file.";
								return false;
							}
						}

						// Upload files for each input
						$file_inputs = [
							'survey_file' => 'survey_upload',
							'design_file' => 'design_upload',
							'topologi_file' => 'topologi_upload',
						];

						foreach ($file_inputs as $input => $folder) {
							if (isset($_FILES[$input]) && $_FILES[$input]['error'] !== UPLOAD_ERR_NO_FILE) {
								$uploaded_files[$input] = uploadFile($_FILES[$input], $upload_dir, $folder);
							} else {
								$uploaded_files[$input] = null; // Set to null if not uploaded
							}
						}

						// Prepare the SQL query
						$query = "INSERT INTO ph4 (
                            rfc, date, work_item, technician, 
                            survey_start_date, survey_end_date, 
                            design_start_date, design_end_date, 
                            topologi_start_date, topologi_end_date, 
                            survey_file, design_file, topologi_file
                        ) VALUES (
                            '$rfc_number', '$date', '$work_item', '$technician', 
                            " . ($survey_start_date ? "'$survey_start_date'" : "NULL") . ", 
                            " . ($survey_end_date ? "'$survey_end_date'" : "NULL") . ", 
                            " . ($design_start_date ? "'$design_start_date'" : "NULL") . ", 
                            " . ($design_end_date ? "'$design_end_date'" : "NULL") . ", 
                            " . ($topologi_start_date ? "'$topologi_start_date'" : "NULL") . ", 
                            " . ($topologi_end_date ? "'$topologi_end_date'" : "NULL") . ", 
                            '{$uploaded_files['survey_file']}', 
                            '{$uploaded_files['design_file']}', 
                            '{$uploaded_files['topologi_file']}'
                        )";
						// Execute the query
						if (mysqli_query($koneksi, $query)) {
							echo '<div class="alert alert-success">Data berhasil disimpan!</div>';
							echo '<meta http-equiv="refresh" content="1;url=?page=projecthandling">';
						} else {
							echo '<div class="alert alert-danger">Error: ' . mysqli_error($koneksi) . '</div>';
						}
					}
					?>

					<form id="form-wizard1" class="mt-3 text-center" method="POST" enctype="multipart/form-data">
						<div class="form-card text-start">
							<div class="row">
								<div class="col-7">
									<h3 class="mb-4">Step 1 Planning:</h3>
								</div>
							</div>
							<div class="row">
								<!-- Date Input Below Step 1 Planning -->
								<div class="row mb-3">
									<div class="col-md-6">
										<label class="form-label">Date:</label>
										<input type="date" class="form-control border-2" name="date"
											value="<?php echo $data['date']; ?>" style="width: auto;" />
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label class="form-label">Work Item: </label>
										<input type="text" class="form-control border-2" name="work_item"
											placeholder="Contoh: CCTV 9 Lokasi.." required />
									</div>
								</div>

								<div class="form-group">
									<button type="button" class="btn btn-primary" data-bs-toggle="modal"
										data-bs-target="#picModal">
										Pilih PIC
									</button>
									<input type="hidden" name="technician" id="selectedTechnicians">
									<div id="selectedPICNames" class="mt-2"></div>
									<!-- Tempat untuk menampilkan nama PIC yang dipilih -->
								</div>

								<!-- Modal untuk Pencarian PIC -->
								<div class="modal fade" id="picModal" tabindex="-1" aria-labelledby="picModalLabel"
									aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="picModalLabel">Pilih PIC</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal"
													aria-label="Close"></button>
											</div>
											<div class="modal-body">
												<input type="text" id="searchPIC" class="form-control"
													placeholder="Cari PIC...">
												<div id="picList" class="mt-3">
													<?php
													$tec = mysqli_query($koneksi, "SELECT * FROM teknisi");
													while ($teknisi = mysqli_fetch_array($tec)) {
													?>
														<div class="form-check">
															<input class="form-check-input" type="checkbox"
																value="<?php echo $teknisi['id_teknisi']; ?>"
																id="pic_<?php echo $teknisi['id_teknisi']; ?>">
															<label class="form-check-label"
																for="pic_<?php echo $teknisi['id_teknisi']; ?>">
																<?php echo $teknisi['nama']; ?>
															</label>
														</div>
													<?php
													}
													?>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary"
													data-bs-dismiss="modal">Tutup</button>
												<button type="button" class="btn btn-primary"
													id="selectPIC">Pilih</button>
											</div>
										</div>
									</div>
								</div>

								<div class="container">
									<div class="row align-items-center">
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label">Survey:</label>
												<input type="file" class="form-control border-2" name="survey_file"
													accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label">Start Date:</label>
												<input type="date" class="form-control border-2"
													name="survey_start_date">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label">End Date:</label>
												<input type="date" class="form-control border-2" name="survey_end_date">
											</div>
										</div>
									</div>

									<div class="row align-items-center">
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label">Design:</label>
												<input type="file" class="form-control border-2" name="design_file"
													accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label">Start Date:</label>
												<input type="date" class="form-control border-2"
													name="design_start_date">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label">End Date:</label>
												<input type="date" class="form-control border-2" name="design_end_date">
											</div>
										</div>
									</div>

									<div class="row align-items-center">
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label">Topologi:</label>
												<input type="file" class="form-control border-2" name="topologi_file"
													accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label">Start Date:</label>
												<input type="date" class="form-control border-2"
													name="topologi_start_date">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label">End Date:</label>
												<input type="date" class="form-control border-2"
													name="topologi_end_date">
											</div>
										</div>
									</div>

									<!-- New RFC Number Field -->
									<div class="row align-items-center">
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label">No. RFC:</label>
												<input type="text" class="form-control border-2" name="rfc_number"
													value="<?php echo $rfc_number; ?>" readonly>
											</div>
										</div>
									</div>
								</div>
							</div>
							<button type="submit" name="submit" class="btn btn-primary next action-button float-end"
								value="Submit">Finish</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
	// Fungsi untuk mencari PIC
	document.getElementById('searchPIC').addEventListener('keyup', function() {
		var input = this.value.toLowerCase();
		var picList = document.getElementById('picList').children;

		for (var i = 0; i < picList.length; i++) {
			var label = picList[i].querySelector('label').innerText.toLowerCase();
			picList[i].style.display = label.includes(input) ? '' : 'none';
		}
	});

	// Fungsi untuk memilih PIC
	document.getElementById('selectPIC').addEventListener('click', function() {
		var selected = [];
		var selectedNames = [];
		var checkboxes = document.querySelectorAll('#picList input[type="checkbox"]:checked');

		checkboxes.forEach(function(checkbox) {
			selected.push(checkbox.value);
			selectedNames.push(checkbox.nextElementSibling.innerText); // Ambil nama dari label
		});

		// Simpan ID teknisi yang dipilih ke input tersembunyi
		document.getElementById('selectedTechnicians').value = selected.join(',');

		// Tampilkan nama-nama PIC yang dipilih
		document.getElementById('selectedPICNames').innerText = 'PIC yang dipilih: ' + selectedNames.join(', ');

		// Tutup modal dengan cara yang benar
		$('#picModal').modal('hide'); // Tutup modal
		$('.modal-backdrop').remove(); // Hapus backdrop modal jika masih ada
		$('body').removeClass('modal-open'); // Hapus kelas modal-open dari body
	});
</script>