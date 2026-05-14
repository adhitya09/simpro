<?php
if ($_SESSION['user']['role'] != 1) {
	// Redirect jika bukan administrator
	header("Location: index.php?page=dashboard");
	exit;
}
?>

<!-- Nav Header Component Start -->
<div class="iq-navbar-header" style="height: 215px">
	<div class="container-fluid iq-container">
		<div class="row">
			<div class="col-md-12">
				<div
					class="flex-wrap d-flex justify-content-between align-items-center">
					<div>
						<h1>PIC</h1>
					</div>
					<div>
						<a href="index.php?page=PIC/tambahteknisi" class="btn btn-primary btn-soft-light">
							Add Data +
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
			<table id="datatable" class="table table-striped" data-toggle="data-table">
				<thead>
					<tr>
						<th data-field="id" data-width="1">No</th>
						<th data-field="foto" data-width="80">Photos</th>
						<th data-field="name" data-width="80">Name</th>
						<th data-field="departements">Departements</th>
						<th data-field="location">Work Location</th>
						<th data-field="type">Type</th>
						<th data-field="action" data-width="100">Action</th>
					</tr>
				</thead>
				<tbody>

					<?php
					$i = 1;
					$query = mysqli_query($koneksi, "select*from teknisi");
					while ($data = mysqli_fetch_array($query)) {
					?>
						<tr>

							<td><?php echo $i++; ?></td>
							<td>
								<img src="<?php
													$basePath = '/simpro/html/assets/images/teknisi/'; // Jalur relatif
													if ($data['foto']) {
														$fotoPath = $_SERVER['DOCUMENT_ROOT'] . $basePath . $data['foto']; // Jalur absolut di server
														if (file_exists($fotoPath)) {
															$foto = $basePath . $data['foto']; // Jalur relatif untuk browser
														} else {
															$foto = $basePath . 'no_image.jpg'; // Jika gambar tidak ada, tampilkan gambar default
														}
													} else {
														$foto = $basePath . 'no_image.jpg'; // Jika tidak ada foto, gunakan gambar default
													}
													echo $foto;
													?>" width="80">
							</td>
							<td><?php echo $data['nama']; ?></td>
							<td><?php echo $data['departement']; ?></td>
							<td><?php echo $data['work_location']; ?></td>
							<td><?php echo $data['type']; ?></td>
							<td>
								<a href="?page=PIC/ubahteknisi&&id=<?php echo $data['id_teknisi']; ?>" class="btn btn-warning" style="color: #FFF;"><i class="fa fa-pencil-square"></i></a>
								<a href="?page=PIC/hapusteknisi&&id=<?php echo $data['id_teknisi']; ?>" class="btn btn-danger" style="color: #FFF;" onclick="return confirm('Are you sure to delete this data?')"><i class="fa fa-remove"></i></a>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>