<div class="data-table-area mg-tb-15">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="sparkline13-list">
					<div class="sparkline13-hd">
						<div class="main-sparkline13-hd">
							<h1>Officer Update</h1>
						</div>
					</div>
					<div class="login-btn-inner">
						<?php
						$id = $_SESSION['user']['id_user'];
						$qq = mysqli_query($koneksi, "select*from user where id_user=$id");
						$dt = mysqli_fetch_array($qq);

						if (isset($_POST['simpan'])) {
							$nama = $_POST['nama'];
							$username = $_POST['username'];
							$role = $_POST['role'];
							$email = $_POST['email'];
							$password = $_POST['password'];
							$foto = "";

							$query = mysqli_query($koneksi, "update user set nama='$nama', username='$username', email='$email', role='$role' where id_user=$id");

							if ($password != "") {
								$password = md5($password);
								$query = mysqli_query($koneksi, "update user set password='$password' where id_user=$id");
							}
							if ($_FILES['foto']['name'] != "") {
								move_uploaded_file($_FILES['foto']['tmp_name'], '/simpro/html/assets/images/user/' . $_FILES['foto']['name']);
								$foto = $_FILES['foto']['name'];
								$query = mysqli_query($koneksi, "update user set foto='$foto' where id_user=$id");
								unlink("/simpro/html/assets/images/user/" . $dt['foto']);
							}
							if ($query) {

								echo '<div class="alert alert-success">Change Data Successfully.</div>';
								echo '<meta http-equiv="refresh" content="1;url=?page=dashboard">';
							} else {
								echo '<div class="alert alert-danger">Change Data Failed.</div>';
							}
						}
						?>
						<form method="post" enctype="multipart/form-data">
							<table class="table table-bordered table-striped">
								<tr>
									<td width="180" style="vertical-align: middle">Name</td>
									<td><input required type="text" name="nama" value="<?php echo $dt['nama']; ?>" class="form-control"></td>
								</tr>
								<tr>
									<td width="180" style="vertical-align: middle">Email</td>
									<td><input required type="text" name="email" value="<?php echo $dt['email']; ?>" class="form-control"></td>
								</tr>
								<tr>
									<td width="180" style="vertical-align: middle">Username</td>
									<td><input required type="text" name="username" value="<?php echo $dt['username']; ?>" class="form-control"></td>
								</tr>
								<tr>
									<td width="180" style="vertical-align: middle">Password</td>
									<td><input type="password" name="password" class="form-control">
										<i style="color : red; font-weight: bold;">*If the password is not changed, just leave it blank.</i>
									</td>
								</tr>
								<tr>
									<td width="180" style="vertical-align: middle">Role</td>
									<td>
										<select name="role" class="form-control">
											<option value="1" <?php if ($dt['role'] == 1) echo 'selected'; ?>>Administrator</option>
											<option value="2" <?php if ($dt['role'] == 2) echo 'selected'; ?>>PIC</option>
										</select>
									</td>
								</tr>
								<tr>
									<td width="180" style="vertical-align: middle">Photos</td>
									<td><input type="file" name="foto" class="form-control">
										<i style="color : red; font-weight: bold;">*If the photo is not replaced, just leave it blank.</i>
										<?php
										if ($dt['foto']) {
										?>
											<br>
											<img src="/simpro/html/assets/images/user/<?php echo $dt['foto']; ?>" alt="image" width="150">
										<?php
										} else {
										?>
											<br>
											<img src="/simpro/html/assets/images/user/no_user.jpg" alt="image" width="150">
										<?php
										}
										?>
									</td>
								</tr>
								<tr>
									<td></td>
									<td>
										<button type="submit" name="simpan" class="btn btn-primary" value="simpan">Update</button>
										<button type="reset" class="btn btn-custon-two btn-danger">Reset</button>
									</td>
								</tr>
							</table>
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>