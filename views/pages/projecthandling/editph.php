<!-- Nav Header Component Start -->
<div class="iq-navbar-header" style="height: 215px">
	<div class="container-fluid iq-container">
		<div class="row">
			<div class="col-md-12">
				<div class="flex-wrap d-flex justify-content-between align-items-center">
					<div>
						<h1>Edit Data Project Handling</h1>
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

					if (!$koneksi) {
						die("Connection failed: " . mysqli_connect_error());
					}

					// Check if an ID is provided for editing
					if (isset($_GET['id'])) {
						$id = $_GET['id'];
						$query = "SELECT * FROM ph4 WHERE id = '$id'";
						$result = mysqli_query($koneksi, $query);
						$data = mysqli_fetch_assoc($result);

						if (!$data) {
							echo '<div class="alert alert-danger">Data not found!</div>';
							exit;
						}
					} else {
						echo '<div class="alert alert-danger">No ID provided!</div>';
						exit;
					}

					function generateRFCNumber($koneksi)
					{
						$query = "SELECT MAX(CAST(SUBSTRING(rfc, 5) AS UNSIGNED)) AS max_rfc FROM ph4";
						$result = mysqli_query($koneksi, $query);
						$row = mysqli_fetch_assoc($result);
						$next_rfc_number = isset($row['max_rfc']) ? $row['max_rfc'] + 1 : 1;
						return 'RF-' . str_pad($next_rfc_number, 3, '0', STR_PAD_LEFT);
					}

					$rfc_number = generateRFCNumber($koneksi);

					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						$id = $_POST['id'];

						if (isset($_POST['save_step'])) {
							// Step 1: Planning
							if ($_POST['save_step'] == 'step1') {
								$date = $_POST['date'] ?: NULL;
								$work_item = $_POST['work_item'] ?: NULL;
								$technician = $_POST['technician'] ?: NULL;
								$survey_start_date = $_POST['survey_start_date'] ?: NULL;
								$survey_end_date = $_POST['survey_end_date'] ?: NULL;
								$design_start_date = $_POST['design_start_date'] ?: NULL;
								$design_end_date = $_POST['design_end_date'] ?: NULL;
								$topologi_start_date = $_POST['topologi_start_date'] ?: NULL;
								$topologi_end_date = $_POST['topologi_end_date'] ?: NULL;

								// Handle file uploads
								$survey_file = $_FILES['survey_file']['name'] ? $_FILES['survey_file']['name'] : $data['survey_file'];
								$design_file = $_FILES['design_file']['name'] ? $_FILES['design_file']['name'] : $data['design_file'];
								$topologi_file = $_FILES['topologi_file']['name'] ? $_FILES['topologi_file']['name'] : $data['topologi_file'];

								// Create directories if they don't exist
								$directories = ['uploads/survey_upload', 'uploads/design_upload', 'uploads/topologi_upload'];
								foreach ($directories as $dir) {
									if (!is_dir($dir))
										mkdir($dir, 0777, true);
								}

								// Move uploaded files
								if ($_FILES['survey_file']['name']) {
									move_uploaded_file($_FILES['survey_file']['tmp_name'], 'uploads/survey_upload/' . $survey_file);
								}
								if ($_FILES['design_file']['name']) {
									move_uploaded_file($_FILES['design_file']['tmp_name'], 'uploads/design_upload/' . $design_file);
								}
								if ($_FILES['topologi_file']['name']) {
									move_uploaded_file($_FILES['topologi_file']['tmp_name'], 'uploads/topologi_upload/' . $topologi_file);
								}

								$query = "UPDATE ph4 SET 
								rfc = '$rfc_number',
                date = " . ($date ? "'$date'" : "NULL") . ", 
                work_item = " . ($work_item ? "'$work_item'" : "NULL") . ", 
                technician = " . ($technician ? "'$technician'" : "NULL") . ", 
                survey_file = '$survey_file',
                survey_start_date = " . ($survey_start_date ? "'$survey_start_date'" : "NULL") . ", 
                survey_end_date = " . ($survey_end_date ? "'$survey_end_date'" : "NULL") . ", 
                design_file = '$design_file',
                design_start_date = " . ($design_start_date ? "'$design_start_date'" : "NULL") . ", 
                design_end_date = " . ($design_end_date ? "'$design_end_date'" : "NULL") . ", 
                topologi_file = '$topologi_file',
                topologi_start_date = " . ($topologi_start_date ? "'$topologi_start_date'" : "NULL") . ", 
                topologi_end_date = " . ($topologi_end_date ? "'$topologi_end_date'" : "NULL") . " 
                WHERE id = '$id'";

								if (mysqli_query($koneksi, $query)) {
									echo '<div class="alert alert-success">Step 1 data saved successfully!</div>';
								} else {
									echo '<div class="alert alert-danger">Error: ' . mysqli_error($koneksi) . '</div>';
								}
							}


							// Step 2: Preparation
							if ($_POST['save_step'] == 'step2') {
								$status = $_POST['status'] ?: NULL;

								// Handle file uploads
								$padi_oe = $_FILES['padi_oe']['name'] ? $_FILES['padi_oe']['name'] : $data['padi_oe'];
								$padi_tor = $_FILES['padi_tor']['name'] ? $_FILES['padi_tor']['name'] : $data['padi_tor'];
								$padi_tkdn = $_FILES['padi_tkdn']['name'] ? $_FILES['padi_tkdn']['name'] : $data['padi_tkdn'];
								$mr_oe = $_FILES['mr_oe']['name'] ? $_FILES['mr_oe']['name'] : $data['mr_oe'];
								$tender_file = $_FILES['tender_file']['name'] ? $_FILES['tender_file']['name'] : $data['tender_file'];
								$picking = mysqli_real_escape_string($koneksi, $_POST['picking'] ?? '');
								$others = mysqli_real_escape_string($koneksi, $_POST['others'] ?? '');
								$picking_start_date = $_POST['picking_start_date'] ?? NULL;
								$picking_end_date = $_POST['picking_end_date'] ?? NULL;
								$others_start_date = $_POST['others_start_date'] ?? NULL;
								$others_end_date = $_POST['others_end_date'] ?? NULL;


								// Create directories if they don't exist
								$directories = ['uploads/padi_upload', 'uploads/mr_oe_upload', 'uploads/tender_file_upload'];
								foreach ($directories as $dir) {
									if (!is_dir($dir))
										mkdir($dir, 0777, true);
								}

								// Move uploaded files
								if ($_FILES['padi_oe']['name']) {
									move_uploaded_file($_FILES['padi_oe']['tmp_name'], 'uploads/padi_upload/' . $padi_oe);
								}
								if ($_FILES['padi_tor']['name']) {
									move_uploaded_file($_FILES['padi_tor']['tmp_name'], 'uploads/padi_upload/' . $padi_tor);
								}
								if ($_FILES['padi_tkdn']['name']) {
									move_uploaded_file($_FILES['padi_tkdn']['tmp_name'], 'uploads/padi_upload/' . $padi_tkdn);
								}
								if ($_FILES['mr_oe']['name']) {
									move_uploaded_file($_FILES['mr_oe']['tmp_name'], 'uploads/mr_oe_upload/' . $mr_oe);
								}
								if ($_FILES['tender_file']['name']) {
									move_uploaded_file($_FILES['tender_file']['tmp_name'], 'uploads/tender_file_upload/' . $tender_file);
								}

								// Prepare the query
								$query = "UPDATE ph4 SET 
								status = '$status',
								picking = " . ($picking ? "'$picking'" : "NULL") . ",
								picking_start_date = " . ($picking_start_date ? "'$picking_start_date'" : "NULL") . ",
								picking_end_date = " . ($picking_end_date ? "'$picking_end_date'" : "NULL") . ",
								others = " . ($others ? "'$others'" : "NULL") . ",
								others_start_date = " . ($others_start_date ? "'$others_start_date'" : "NULL") . ",
								others_end_date = " . ($others_end_date ? "'$others_end_date'" : "NULL") . ",
								padi_oe = '$padi_oe',
								padi_start_date = " . (isset($_POST['padi_start_date']) && $_POST['padi_start_date'] ? "'{$_POST['padi_start_date']}'" : "NULL") . ", 
								padi_end_date = " . (isset($_POST['padi_end_date']) && $_POST['padi_end_date'] ? "'{$_POST['padi_end_date']}'" : "NULL") . ", 
								padi_tor = '$padi_tor',
								padi_tor_start_date = " . (isset($_POST['padi_tor_start_date']) && $_POST['padi_tor_start_date'] ? "'{$_POST['padi_tor_start_date']}'" : "NULL") . ", 
								padi_tor_end_date = " . (isset($_POST['padi_tor_end_date']) && $_POST['padi_tor_end_date'] ? "'{$_POST['padi_tor_end_date']}'" : "NULL") . ", 
								padi_tkdn = '$padi_tkdn',
								padi_tkdn_start_date = " . (isset($_POST['padi_tkdn_start_date']) && $_POST['padi_tkdn_start_date'] ? "'{$_POST['padi_tkdn_start_date']}'" : "NULL") . ", 
								padi_tkdn_end_date = " . (isset($_POST['padi_tkdn_end_date']) && $_POST['padi_tkdn_end_date'] ? "'{$_POST['padi_tkdn_end_date']}'" : "NULL") . ", 
								mr_oe = '$mr_oe',
								mr_start_date = " . (isset($_POST['mr_start_date']) && $_POST['mr_start_date'] ? "'{$_POST['mr_start_date']}'" : "NULL") . ", 
								mr_end_date = " . (isset($_POST['mr_end_date']) && $_POST['mr_end_date'] ? "'{$_POST['mr_end_date']}'" : "NULL") . ", 
								tender_file = '$tender_file',
								tender_start_date = " . (isset($_POST['tender_start_date']) && $_POST['tender_start_date'] ? "'{$_POST['tender_start_date']}'" : "NULL") . ", 
								tender_end_date = " . (isset($_POST['tender_end_date']) && $_POST['tender_end_date'] ? "'{$_POST['tender_end_date']}'" : "NULL") . " 
								WHERE id = '$id'";

								if (mysqli_query($koneksi, $query)) {
									echo '<div class="alert alert-success">Step 2 data saved successfully!</div>';
								} else {
									echo '<div class="alert alert-danger">Error: ' . mysqli_error($koneksi) . '</div>';
								}
							}

							// Step 3: Implementation & Monitoring
							if ($_POST['save_step'] == 'step3') {
								$implementation_description = $_POST['implementation_description'] ?: NULL;
								$monitoring_description = $_POST['monitoring_description'] ?: NULL;
								$implementation_start_date = $_POST['implementation_start_date'] ?: NULL;
								$implementation_end_date = $_POST['implementation_end_date'] ?: NULL;
								$monitoring_start_date = $_POST['monitoring_start_date'] ?: NULL;
								$monitoring_end_date = $_POST['monitoring_end_date'] ?: NULL;

								// Handle file uploads
								$implementation_file = $_FILES['implementation_file']['name'] ? $_FILES['implementation_file']['name'] : $data['implementation_file'];
								$monitoring_file = $_FILES['monitoring_file']['name'] ? $_FILES['monitoring_file']['name'] : $data['monitoring_file'];

								// Create directories if they don't exist
								$directories = ['uploads/implementation_file_upload', 'uploads/monitoring_file_upload'];
								foreach ($directories as $dir) {
									if (!is_dir($dir))
										mkdir($dir, 0777, true);
								}

								// Move uploaded files
								if ($_FILES['implementation_file']['name']) {
									move_uploaded_file($_FILES['implementation_file']['tmp_name'], 'uploads/implementation_file_upload/' . $implementation_file);
								}
								if ($_FILES['monitoring_file']['name']) {
									move_uploaded_file($_FILES['monitoring_file']['tmp_name'], 'uploads/monitoring_file_upload/' . $monitoring_file);
								}

								$query = "UPDATE ph4 SET 
									implementation_description = " . ($implementation_description ? "'$implementation_description'" : "NULL") . ",
									implementation_file = '$implementation_file',
									implementation_start_date = " . ($implementation_start_date ? "'$implementation_start_date'" : "NULL") . ",
									implementation_end_date = " . ($implementation_end_date ? "'$implementation_end_date'" : "NULL") . ",
									monitoring_description = " . ($monitoring_description ? "'$monitoring_description'" : "NULL") . ",
									monitoring_file = '$monitoring_file',
									monitoring_start_date = " . ($monitoring_start_date ? "'$monitoring_start_date'" : "NULL") . ",
									monitoring_end_date = " . ($monitoring_end_date ? "'$monitoring_end_date'" : "NULL") . "
									WHERE id = '$id'";

								if (mysqli_query($koneksi, $query)) {
									echo '<div class="alert alert-success">Step 3 data saved successfully!</div>';
								} else {
									echo '<div class="alert alert-danger">Error: ' . mysqli_error($koneksi) . '</div>';
								}
							}

							// Step 4: Finalization
							if ($_POST['save_step'] == 'step4') {
								$uat_start_date = $_POST['uat_start_date'] ?: NULL;
								$uat_end_date = $_POST['uat_end_date'] ?: NULL;
								$bastp_start_date = $_POST['bastp_start_date'] ?: NULL;
								$bastp_end_date = $_POST['bastp_end_date'] ?: NULL;
								$bastb_start_date = $_POST['bastb_start_date'] ?: NULL;
								$bastb_end_date = $_POST['bastb_end_date'] ?: NULL;

								// Handle file uploads
								$uat_file = $_FILES['uat_file']['name'] ? $_FILES['uat_file']['name'] : $data['uat_file'];
								$bastp_file = $_FILES['bastp_file']['name'] ? $_FILES['bastp_file']['name'] : $data['bastp_file'];
								$bastb_file = $_FILES['bastb_file']['name'] ? $_FILES['bastb_file']['name'] : $data['bastb_file'];

								// Create directories if they don't exist
								$directories = ['uploads/uat_upload', 'uploads/bastp_upload', 'uploads/bastb_upload'];
								foreach ($directories as $dir) {
									if (!is_dir($dir))
										mkdir($dir, 0777, true);
								}

								// Move uploaded files
								if ($_FILES['uat_file']['name']) {
									move_uploaded_file($_FILES['uat_file']['tmp_name'], 'uploads/uat_upload/' . $uat_file);
								}
								if ($_FILES['bastp_file']['name']) {
									move_uploaded_file($_FILES['bastp_file']['tmp_name'], 'uploads/bastp_upload/' . $bastp_file);
								}
								if ($_FILES['bastb_file']['name']) {
									move_uploaded_file($_FILES['bastb_file']['tmp_name'], 'uploads/bastb_upload/' . $bastb_file);
								}

								$query = "UPDATE ph4 SET 
								uat_file = '$uat_file',
								uat_start_date = " . ($uat_start_date ? "'$uat_start_date'" : "NULL") . ",
								uat_end_date = " . ($uat_end_date ? "'$uat_end_date'" : "NULL") . ",
								bastp_file = '$bastp_file',
								bastp_start_date = " . ($bastp_start_date ? "'$bastp_start_date'" : "NULL") . ",
								bastp_end_date = " . ($bastp_end_date ? "'$bastp_end_date'" : "NULL") . ",
								bastb_file = '$bastb_file',
								bastb_start_date = " . ($bastb_start_date ? "'$bastb_start_date'" : "NULL") . ",
								bastb_end_date = " . ($bastb_end_date ? "'$bastb_end_date'" : "NULL") . "
								WHERE id = '$id'";

								if (mysqli_query($koneksi, $query)) {
									echo '<div class="alert alert-success">Step 4 data saved successfully!</div>';
								} else {
									echo '<div class="alert alert-danger">Error: ' . mysqli_error($koneksi) . '</div>';
								}
							}
						}
					}
					?>
					<form id="form-wizard1" class="mt-3 text-center" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
						<input type="hidden" name="save_step" id="save_step" value="">
						<ul id="top-tab-list" class="p-0 row list-inline">
							<li class="mb-2 col-lg-3 col-md-6 text-start active" id="account">
								<a href="javascript:void();">
									<div class="iq-icon me-3">
										<svg class="svg-icon icon-20" xmlns="http://www.w3.org/2000/svg" width="20"
											fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
												d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
										</svg>
									</div>
									<span class="dark-wizard">Planning</span>
								</a>
							</li>
							<li id="personal" class="mb-2 col-lg-3 col-md-6 text-start">
								<a href="javascript:void();">
									<div class="iq-icon me-3">
										<svg class="svg-icon icon-20" xmlns="http://www.w3.org/2000/svg" width="20"
											fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
												d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7  0 00-7 7h14a7 7 0 00-7-7z" />
										</svg>
									</div>
									<span class="dark-wizard">Preparation</span>
								</a>
							</li>
							<li id="payment" class="mb-2 col-lg-3 col-md-6 text-start">
								<a href="javascript:void();">
									<div class="iq-icon me-3">
										<svg class="svg-icon icon-20" xmlns="http://www.w3.org/2000/svg" width="20"
											fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
												d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
												d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
										</svg>
									</div>
									<span class="dark-wizard">Implementation</span>
								</a>
							</li>
							<li id="confirm" class="mb-2 col-lg-3 col-md-6 text-start">
								<a href="javascript:void();">
									<div class="iq-icon me-3">
										<svg class="svg-icon icon-20" xmlns="http://www.w3.org/2000/svg" width="20"
											fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
												d="M5 13l4 4L19 7" />
										</svg>
									</div>
									<span class="dark-wizard">Finalization</span>
								</a>
							</li>
						</ul>
						<!-- fieldsets -->
						<!-- Step 1 Planning -->
						<fieldset>
							<div class="form-card text-start">
								<div class="row">
									<div class="col-7">
										<h3 class="mb-4">Step 1 Planning:</h3>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label">Date: </label>
											<input type="date" class="form-control border-2" name="date"
												value="<?php echo $data['date']; ?>" style="width: 100%;" />
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label">Work Item: </label>
											<input type="text" class="form-control border-2" name="work_item"
												value="<?php echo $data['work_item']; ?>" style="width: 100%;" />
										</div>
									</div>
								</div>

								<!-- PIC Selection -->
								<div class="form-group">
									<button type="button" class="btn btn-primary" data-bs-toggle="modal"
										data-bs-target="#picModal">
										Pilih PIC
									</button>
									<input type="hidden" name="technician" id="selectedTechnicians"
										value="<?php echo $data['technician']; ?>">
									<div id="selectedPICNames" class="mt-2">
										<?php
										if (!empty($data['technician'])) {
											$selectedTechnicians = explode(',', $data['technician']);
											$names = [];

											$result = mysqli_query($koneksi, "SELECT nama FROM teknisi WHERE id_teknisi IN (" . implode(',', $selectedTechnicians) . ")");
											while ($row = mysqli_fetch_assoc($result)) {
												$names[] = $row['nama'];
											}
											echo implode(', ', $names);
										}
										?>
									</div>
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
														$checked = in_array($teknisi['id_teknisi'], $selectedTechnicians) ? 'checked' : '';
													?>
														<div class="form-check">
															<input class="form-check-input" type="checkbox"
																value="<?php echo $teknisi['id_teknisi']; ?>"
																id="pic_<?php echo $teknisi['id_teknisi']; ?>" <?php echo $checked; ?>>
															<label class="form-check-label"
																for="pic_<?php echo $teknisi['id_teknisi']; ?>">
																<?php echo $teknisi['nama']; ?>
															</label>
														</div>
													<?php } ?>
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
									<?php $sections = ['Survey', 'Design', 'Topologi']; ?>
									<?php foreach ($sections as $section): ?>
										<div class="row align-items-center">
											<div class="col-md-4">
												<div class="form-group">
													<label class="form-label"><?php echo $section; ?>:</label>
													<input type="file" class="form-control border-2"
														name="<?php echo strtolower($section); ?>_file"
														accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt"
														style="width: 60%;">
													<?php if ($data[strtolower($section) . '_file']): ?>
														<a href="<?php echo 'uploads/' . strtolower($section) . '_upload/' . $data[strtolower($section) . '_file']; ?>"
															target="_blank">Lihat File</a>
													<?php endif; ?>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="form-label">Start Date:</label>
													<input type="date" class="form-control border-2"
														name="<?php echo strtolower($section); ?>_start_date"
														value="<?php echo $data[strtolower($section) . '_start_date']; ?>"
														style="width: 60%;">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="form-label">End Date:</label>
													<input type="date" class="form-control border-2"
														name="<?php echo strtolower($section); ?>_end_date"
														value="<?php echo $data[strtolower($section) . '_end_date']; ?>"
														style="width: 60%;">
												</div>
											</div>
										</div>
									<?php endforeach; ?>
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
							<button type="button" class="btn btn-success save action-button float-end me-1"
								onclick="document.getElementById('save_step').value='step1'; this.form.submit();">Save</button>
							<button type="button"
								class="btn btn-primary next action-button float-end me-1">Next</button>
						</fieldset>


						<fieldset>
							<div class="form-card text-start">
								<div class="row">
									<div class="col-7">
										<h3 class="mb-4">Step 2 Preparation:</h3>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label">Select Type:</label>
											<select id="typeSelector" name="status" class="form-select shadow-none"
												style="width: 30%;">
												<?php if ($_SESSION['user']['role'] == 1): // Hanya untuk Administrator 
												?>
													<option value="padi" <?php echo ($data['status'] == 'padi') ? 'selected' : ''; ?>>Padi</option>
													<option value="mr" <?php echo ($data['status'] == 'mr') ? 'selected' : ''; ?>>MR</option>
													<option value="tender" <?php echo ($data['status'] == 'tender') ? 'selected' : ''; ?>>Tender</option>
												<?php endif; ?>
												<option value="picking" <?php echo ($data['status'] == 'picking' || !isset($data['status'])) ? 'selected' : ''; ?>>Picking</option>
												<option value="others" <?php echo ($data['status'] == 'others') ? 'selected' : ''; ?>>Others</option>
											</select>
										</div>
									</div>
								</div>

								<div id="formContainer">
									<!-- Picking Section (Tampil Default jika tidak ada status atau status = 'picking') -->
									<div id="pickingSection" class="form-section" style="display: <?php echo (empty($data['status']) || $data['status'] == 'picking') ? 'block' : 'none'; ?>;">
										<div class="row align-items-center">
											<div class="col-md-12">
												<label class="form-label">Picking</label>
												<textarea class="form-control border-2" id="summernote1" rows="5" name="picking"><?php echo htmlspecialchars($data['picking'] ?? ''); ?></textarea>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="form-label">Picking Start & End Date:</label>
													<div class="d-flex align-items-center">
														<input type="date" class="form-control border-2  me-2" name="picking_start_date" value="<?php echo $data['picking_start_date'] ?? ''; ?>">
														<span>/</span>
														<input type="date" class="form-control border-2  ms-2" name="picking_end_date" value="<?php echo $data['picking_end_date'] ?? ''; ?>">
													</div>
												</div>
											</div>
										</div>
									</div>

									<!-- Others Section -->
									<div id="othersSection" class="form-section" style="display: <?php echo ($data['status'] == 'others') ? 'block' : 'none'; ?>;">
										<div class="row align-items-center">
											<div class="col-md-12">
												<label class="form-label">Others</label>
												<textarea class="form-control border-2" id="summernote2" rows="5" name="others"><?php echo htmlspecialchars($data['others'] ?? ''); ?></textarea>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="form-label">Others Start & End Date:</label>
													<div class="d-flex align-items-center">
														<input type="date" class="form-control border-2 me-2" name="others_start_date" value="<?php echo $data['others_start_date'] ?? ''; ?>">
														<span>/</span>
														<input type="date" class="form-control border-2 ms-2" name="others_end_date" value="<?php echo $data['others_end_date'] ?? ''; ?>">
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php if ($_SESSION['user']['role'] == 1): // Hanya untuk Administrator 
									?>
										<div id="padiSection" class="form-section">
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label class="form-label">DP3:</label>
														<input type="file" class="form-control border-2" name="padi_oe"
															accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt">
														<?php if ($data['padi_oe']): ?>
															<a href="<?php echo 'uploads/padi_upload/' . $data['padi_oe']; ?>"
																target="_blank">Lihat File</a>
														<?php endif; ?>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="form-label">DP3 Start & End Date:</label>
														<div class="d-flex align-items-center">
															<input type="date"
																class="form-control border-2 custom-input me-2"
																name="padi_start_date"
																value="<?php echo $data['padi_start_date'] ?? ''; ?>">
															<span>/</span>
															<input type="date"
																class="form-control border-2 custom-input ms-2"
																name="padi_end_date"
																value="<?php echo $data['padi_end_date'] ?? ''; ?>">
														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label class="form-label">TOR:</label>
														<input type="file" class="form-control border-2" name="padi_tor"
															accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt">
														<?php if ($data['padi_tor']): ?>
															<a href="<?php echo 'uploads/padi_upload/' . $data['padi_tor']; ?>"
																target="_blank">Lihat File</a>
														<?php endif; ?>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="form-label">TOR Start & End Date:</label>
														<div class="d-flex align-items-center">
															<input type="date"
																class="form-control border-2 custom-input me-2"
																name="padi_tor_start_date"
																value="<?php echo $data['padi_tor_start_date'] ?? ''; ?>">
															<span>/</span>
															<input type="date"
																class="form-control border-2 custom-input ms-2"
																name="padi_tor_end_date"
																value="<?php echo $data['padi_tor_end_date'] ?? ''; ?>">
														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label class="form-label">TKDN:</label>
														<input type="file" class="form-control border-2" name="padi_tkdn"
															accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt">
														<?php if ($data['padi_tkdn']): ?>
															<a href="<?php echo 'uploads/padi_upload/' . $data['padi_tkdn']; ?>"
																target="_blank">Lihat File</a>
														<?php endif; ?>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="form-label">TKDN Start & End Date:</label>
														<div class="d-flex align-items-center">
															<input type="date"
																class="form-control border-2 custom-input me-2"
																name="padi_tkdn_start_date"
																value="<?php echo $data['padi_tkdn_start_date'] ?? ''; ?>">
															<span>/</span>
															<input type="date"
																class="form-control border-2 custom-input ms-2"
																name="padi_tkdn_end_date"
																value="<?php echo $data['padi_tkdn_end_date'] ?? ''; ?>">
														</div>
													</div>
												</div>
											</div>
										</div>

										<!-- MR Section -->
										<div id="mrSection" class="form-section" style="display: none;">
											<div class="row align-items-center">
												<div class="col-md-4">
													<div class="form-group">
														<label class="form-label">OE:</label>
														<input type="file" class="form-control border-2" name="mr_oe"
															style="width: 60%;"
															accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt">
														<?php if ($data['mr_oe']): ?>
															<a href="<?php echo 'uploads/mr_oe_upload/' . $data['mr_oe']; ?>"
																target="_blank">Lihat File</a>
														<?php endif; ?>
													</div>
													<div class="form-group">
														<label class="form-label">Tender:</label>
														<input type="file" class="form-control border-2"
															name="mr_tender_file" style="width: 60%;"
															accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt">
														<?php if ($data['mr_tender_file']): ?>
															<a href="<?php echo 'uploads/mr_tender_file_upload/' . $data['mr_tender_file']; ?>"
																target="_blank">Lihat File</a>
														<?php endif; ?>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="form-label">MR Start & End Date:</label>
														<div class="d-flex align-items-center">
															<input type="date"
																class="form-control border-2 custom-input me-2"
																name="mr_start_date"
																value="<?php echo $data['mr_start_date'] ?? ''; ?>">
															<span>/</span>
															<input type="date"
																class="form-control border-2 custom-input ms-2"
																name="mr_end_date"
																value="<?php echo $data['mr_end_date'] ?? ''; ?>">
														</div>
													</div>
												</div>
											</div>
										</div>

										<!-- Tender Section -->
										<div id="tenderSection" class="form-section" style="display: none;">
											<div class="row align-items-center">
												<div class="col-md-4">
													<div class="form-group">
														<label class="form-label">Tender Document:</label>
														<input type="file" class="form-control border-2" name="tender_file"
															style="width: 60%;"
															accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt">
														<?php if ($data['tender_file']): ?>
															<a href="<?php echo 'uploads/tender_file_upload/' . $data['tender_file']; ?>"
																target="_blank">Lihat File</a>
														<?php endif; ?>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="form-label">Tender Start & End Date:</label>
														<div class="d-flex align-items-center">
															<input type="date"
																class="form-control border-2 custom-input me-2"
																name="tender_start_date"
																value="<?php echo $data['tender_start_date'] ?? ''; ?>">
															<span>/</span>
															<input type="date"
																class="form-control border-2 custom-input ms-2"
																name="tender_end_date"
																value="<?php echo $data['tender_end_date'] ?? ''; ?>">
														</div>
													</div>
												</div>
											</div>
										</div>
								</div>
							<?php endif; ?>
							<button type="button" name="save"
								class="btn btn-success save action-button float-end me-1" value="Save"
								onclick="document.getElementById('save_step').value='step2'; this.form.submit();">Save</button>
							<button type="button" name="next"
								class="btn btn-primary next action-button float-end me-1" value="Next">Next</button>
							<button type="button" name="previous"
								class="btn btn-dark previous action-button-previous float-end me-1"
								value="Previous">Previous</button>
						</fieldset>


						<fieldset>
							<div class="form-card text-start">
								<div class="row">
									<div class="col-7">
										<h3 class="mb-4">Step 3 Implementation & Monitoring:</h3>
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-12">
										<button type="button" class="btn btn-primary"
											id="btnImplementation">Implementation</button>
										<button type="button" class="btn btn-secondary"
											id="btnMonitoring">Monitoring</button>
									</div>
								</div>

								<!-- Implementation Section -->
								<div id="implementationSection" class="form-section">
									<div class="form-group">
										<div class="col-md-12">
											<label class="form-label" for="summernote3">Implementation
												Description</label>
											<textarea class="form-control border-2" id="summernote3" rows="5"
												name="implementation_description">
						<?php echo $data['implementation_description']; ?>
					</textarea>
										</div>
										<br>
										<div class="row align-items-center">
											<div class="col-md-4">
												<div class="form-group">
													<label class="form-label">Evidence:</label>
													<input type="file" class="form-control border-2"
														name="implementation_file" style="width: 60%;"
														accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt">
													<?php if ($data['implementation_file']): ?>
														<a href="<?php echo 'uploads/implementation_file_upload/' . $data['implementation_file']; ?>"
															target="_blank">Lihat File</a>
													<?php endif; ?>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="form-label">Implementation Start & End Date:</label>
													<div class="d-flex align-items-center">
														<input type="date"
															class="form-control border-2 custom-input me-2"
															name="implementation_start_date"
															value="<?php echo $data['implementation_start_date'] ?? ''; ?>">
														<span>/</span>
														<input type="date"
															class="form-control border-2 custom-input ms-2"
															name="implementation_end_date"
															value="<?php echo $data['implementation_end_date'] ?? ''; ?>">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- Monitoring Section -->
								<div id="monitoringSection" class="form-section" style="display: none;">
									<div class="form-group">
										<div class="col-md-12">
											<label class="form-label" for="summernote4">Monitoring Description</label>
											<textarea class="form-control border-2" id="summernote4" rows="5"
												name="monitoring_description">
						<?php echo $data['monitoring_description']; ?>
					</textarea>
										</div>
										<br>
										<div class="row align-items-center">
											<div class="col-md-4">
												<div class="form-group">
													<label class="form-label">Evidence:</label>
													<input type="file" class="form-control border-2"
														name="monitoring_file" style="width: 60%;"
														accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt">
													<?php if ($data['monitoring_file']): ?>
														<a href="<?php echo 'uploads/monitoring_file_upload/' . $data['monitoring_file']; ?>"
															target="_blank">Lihat File</a>
													<?php endif; ?>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="form-label">Monitoring Start & End Date:</label>
													<div class="d-flex align-items-center">
														<input type="date"
															class="form-control border-2 custom-input me-2"
															name="monitoring_start_date"
															value="<?php echo $data['monitoring_start_date'] ?? ''; ?>">
														<span>/</span>
														<input type="date"
															class="form-control border-2 custom-input ms-2"
															name="monitoring_end_date"
															value="<?php echo $data['monitoring_end_date'] ?? ''; ?>">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<button type="button" name="save" class="btn btn-success save action-button float-end me-1"
								value="Save"
								onclick="document.getElementById('save_step').value='step3'; this.form.submit();">Save</button>
							<button type="button" name="next" class="btn btn-primary next action-button float-end me-1"
								value="Next">Next</button>
							<button type="button" name="previous"
								class="btn btn-dark previous action-button-previous float-end me-1"
								value="Previous">Previous</button>
						</fieldset>


						<fieldset>
							<div class="form-card text-start">
								<div class="row">
									<div class="col-7">
										<h3 class="mb-4">Step 4 Finalization:</h3>
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-12">
										<button type="button" class="btn btn-primary" id="btnUAT">Upload UAT</button>
										<button type="button" class="btn btn-secondary" id="btnBASTP">Upload
											BASTP</button>
										<button type="button" class="btn btn-success" id="btnBASTB">Upload
											BASTB</button>
									</div>
								</div>

								<!-- UAT Section -->
								<div id="uatSection" class="form-section">
									<div class="row align-items-center">
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label">Upload UAT File:</label>
												<input type="file" class="form-control border-2 me-2"
													name="uat_file"
													accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt">
												<?php if ($data['uat_file']): ?>
													<a href="<?php echo 'uploads/uat_upload/' . $data['uat_file']; ?>"
														target="_blank">Lihat File</a>
												<?php endif; ?>
											</div>
											<div class="form-group">
												<label class="form-label">UAT Date:</label>
												<div class="d-flex align-items-center">
													<input type="date" class="form-control border-2 custom-input me-2"
														name="uat_start_date"
														value="<?php echo $data['uat_start_date']; ?>">
													<span>/</span>
													<input type="date" class="form-control border-2 custom-input ms-2"
														name="uat_end_date"
														value="<?php echo $data['uat_end_date']; ?>">
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- BASTP Section -->
								<div id="bastpSection" class="form-section" style="display: none;">
									<div class="row align-items-center">
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label">Upload BASTP File:</label>
												<input type="file" class="form-control border-2 me-2" name="bastp_file"
													accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt">
												<?php if (!empty($data['bastp_file'])): ?>
													<a href="<?php echo 'uploads/bastp_upload/' . $data['bastp_file']; ?>"
														target="_blank">Lihat File</a>
												<?php endif; ?>
											</div>
											<div class="form-group">
												<label class="form-label">BASTP Date:</label>
												<div class="d-flex align-items-center">
													<input type="date" class="form-control border-2 custom-input me-2"
														name="bastp_start_date"
														value="<?php echo $data['bastp_start_date'] ?? ''; ?>">
													<span>/</span>
													<input type="date" class="form-control border-2 custom-input ms-2"
														name="bastp_end_date"
														value="<?php echo $data['bastp_end_date'] ?? ''; ?>">
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- BASTB Section -->
								<div id="bastbSection" class="form-section" style="display: none;">
									<div class="row align-items-center">
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label me-2">Upload BASTB File:</label>
												<input type="file" class="form-control border-2 me-2" name="bastb_file"
													accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt">
												<?php if (!empty($data['bastb_file'])): ?>
													<a href="<?php echo 'uploads/bastb_upload/' . $data['bastb_file']; ?>"
														target="_blank">Lihat File</a>
												<?php endif; ?>
											</div>
											<div class="form-group">
												<label class="form-label">BASTB Date:</label>
												<div class="d-flex align-items-center">
													<input type="date" class="form-control border-2 custom-input me-2"
														name="bastb_start_date"
														value="<?php echo $data['bastb_start_date'] ?? ''; ?>">
													<span>/</span>
													<input type="date" class="form-control border-2 custom-input ms-2"
														name="bastb_end_date"
														value="<?php echo $data['bastb_end_date'] ?? ''; ?>">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label">Status:</label>
									<select name="status" class="form-select shadow-none" style="width: 150px;">
										<option class="text-primary" value="1">Open</option>
										<option class="text-info" value="2">In Progress</option>
										<option class="text-secondary" value="3">Hold</option>
										<option class="text-success" value="4">Done</option>
										<option class="text-danger" value="5">Cancel</option>
									</select>
								</div>
							</div>
							<button type="button" name="save" class="btn btn-success save action-button float-end me-1"
								value="Save"
								onclick="document.getElementById('save_step').value='step4'; this.form.submit();">Save</button>
							<button type="button" name="previous"
								class="btn btn-dark previous action-button-previous float-end me-1"
								value="Previous">Previous</button>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
	$('#summernote1').summernote({
		placeholder: 'Masukkan Deskripsi',
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
		placeholder: 'Masukkan Deskripsi',
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
		placeholder: 'Masukkan Deskripsi',
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
	$('#summernote4').summernote({
		placeholder: 'Masukkan Deskripsi',
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
	document.getElementById('typeSelector').addEventListener('change', function() {
		var selectedType = this.value;
		document.getElementById('pickingSection').style.display = (selectedType === 'picking') ? 'block' : 'none';
		document.getElementById('othersSection').style.display = (selectedType === 'others') ? 'block' : 'none';
		document.getElementById('padiSection').style.display = selectedType === 'padi' ? 'block' : 'none';
		document.getElementById('mrSection').style.display = selectedType === 'mr' ? 'block' : 'none';
		document.getElementById('tenderSection').style.display = selectedType === 'tender' ? 'block' : 'none';
	});

	// Wizard navigation
	var current_fs, next_fs, previous_fs; //fieldsets
	var opacity;

	$(". next").click(function() {
		current_fs = $(this).parent();
		next_fs = $(this).parent().next();

		// Activate next step on progressbar using the index of next_fs
		$("#top-tab-list li").eq($("fieldset").index(next_fs)).addClass("active");

		// Show the next fieldset
		next_fs.show();
		// Hide the current fieldset with style
		current_fs.hide();
		setProgressBar(++current_fs.index());
	});

	$(".previous").click(function() {
		current_fs = $(this).parent();
		previous_fs = $(this).parent().prev();

		// De-activate current step on progressbar
		$("#top-tab-list li").eq($("fieldset").index(current_fs)).removeClass("active");

		// Show the previous fieldset
		previous_fs.show();
		// Hide the current fieldset
		current_fs.hide();
		setProgressBar(--current_fs.index());
	});

	function setProgressBar(index) {
		var percent = parseFloat(100 / $("fieldset").length) * (index + 1);
		$(".progress-bar").css("width", percent + "%");
	}
</script>

<style>
	.progress {
		height: 20px;
		background-color: #f3f3f3;
		border-radius: 5px;
		overflow: hidden;
	}

	.progress-bar {
		height: 100%;
		background-color: #007bff;
		transition: width 0.4s ease;
	}
</style>

<style>
	.custom-input {
		width: 150px;
		/* Atur lebar sesuai kebutuhan */
	}
</style>

<script>
	document.getElementById('btnImplementation').onclick = function() {
		document.getElementById('implementationSection').style.display = 'block';
		document.getElementById('monitoringSection').style.display = 'none';
	};

	document.getElementById('btnMonitoring').onclick = function() {
		document.getElementById('monitoringSection').style.display = 'block';
		document.getElementById('implementationSection').style.display = 'none';
	};
</script>

<script>
	document.getElementById('btnUAT').onclick = function() {
		document.getElementById('uatSection').style.display = 'block';
		document.getElementById('bastpSection').style.display = 'none';
		document.getElementById('bastbSection').style.display = 'none';
	};

	document.getElementById('btnBASTP').onclick = function() {
		document.getElementById('bastpSection').style.display = 'block';
		document.getElementById('uatSection').style.display = 'none';
		document.getElementById('bastbSection').style.display = 'none';
	};

	document.getElementById('btnBASTB').onclick = function() {
		document.getElementById('bastbSection').style.display = 'block';
		document.getElementById('uatSection').style.display = 'none';
		document.getElementById('bastpSection').style.display = 'none';
	};

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