<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "crud";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
	die("Tidak bisa terkoneksi ke database");
}
$nik = "";
$nama_lengkap = "";
$jabatan = "";
$no_hp = "";
$alamat = "";
$sukses ="";
$error ="";

if(isset($_GET['op'])){
	$op = $_GET['op'];
}else{
	$op = "";
}

if($op=='delete'){
	$id = $_GET['id'];
	$sql1 = "delete from pegawai where id ='$id' ";
	$q1 = mysqli_query($koneksi, $sql1);
	if($q1){
		if($q1){
			$sukses = "Berhasil Menghapus Data";
		}else{
			$error = "Gagal Menghapus Data";
		}
	}
}


if($op == 'edit'){ //membaca data yang mau diedit
	$id = $_GET['id'];
	$sql1 = "select * from pegawai where id = '$id'";
	$q1 = mysqli_query($koneksi, $sql1);
	$r1 = mysqli_fetch_array($q1);
	$nik = $r1['nik'];
	$nama_lengkap = $r1['nama_lengkap'];
	$jabatan = $r1['jabatan'];
	$no_hp = $r1['no_hp'];
	$alamat = $r1['alamat'];
	if($nik == ''){
		$error = "Data tidak ditemukan";
	}
}


if(isset($_POST['simpan'])){ //create
	$nik = $_POST['nik'];
	$nama_lengkap = $_POST['nama_lengkap'];
	$jabatan = $_POST['jabatan'];
	$no_hp = $_POST['no_hp'];
	$alamat = $_POST['alamat'];
	if($nik && $nama_lengkap && $jabatan && $no_hp && $alamat){
		if($op=='edit'){ //update data
			$sql1 = "update  pegawai set nik = '$nik', nama_lengkap = '$nama_lengkap',jabatan = '$jabatan' ,no_hp = '$no_hp' , alamat = '$alamat' where id ='$id'";
			$q1 = mysqli_query($koneksi, $sql1);
			if($q1){
				$sukses = "Berhasil Update Data";
			}else{
				$error = "Gagal Update Data";
			}
		}else{ //insert data
			$sql1 = "insert into pegawai( nik,nama_lengkap,jabatan,no_hp,alamat ) values ('$nik' , '$nama_lengkap' , '$jabatan' , '$no_hp' , '$alamat')";
			$q1 = mysqli_query($koneksi, $sql1);
			if($q1){
				$sukses = "Berhasil Tambah Data";
			}else{
				$error = "Gagal Tambah Data";
			}
		}
		
	}else{
		$error = "Silahkan isi data dengan lengkap";
	}
} 


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CRUD PEGAWAI</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<style>
		.mx-auto{
			width: 1000px;
		}
		.card{
			margin-top: 10px;
		}
	</style>

</head>
<body>
	<div class="mx-auto" style="">
		<!-- Untuk memasukkan data -->
		<div class="card">
			<h5 class="card-header text-white bg-primary">Create / Edit Data</h5>
			<div class="card-body">
				<?php
				if($error){
				?>
					<div class="alert alert-danger" role="alert">
						<?php echo $error?>
					</div>
				<?php
					header("refresh:5;url=index.php");
				}
				?>
				<?php
				if($sukses){
				?>
					<div class="alert alert-success" role="alert">
						<?php echo $sukses?>
					</div>
				<?php
					header("refresh:5;url=index.php");
				}
				?>
				<form action="" method="POST">
					<div class="mb-3">
						<label for="nik" class="form-label">NIK</label>
						<input type="text" class="form-control" id="nik" name="nik" value="<?php echo $nik?>"  placeholder="NIK">
					</div>
					<div class="mb-3">
						<label for="nama_lengkap" class="form-label">Nama Lengkap</label>
						<input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo $nama_lengkap?>"  placeholder="Nama Lengkap">
					</div>
					<div class="mb-3">
						<label for="jabatan" class="form-label">Jabatan</label>
						<div class="col-sm-10">
							<select type="text" class="form-control" name="jabatan" id="jabatan">
								<option value="">- Pilih Jabatan -</option>
								<option value="prakomap" <?php if( $jabatan == "prakomap") echo "selected"?>>Pranata Komputer Ahli Pertama</option>
								<option value="prakomam" <?php if( $jabatan == "prakomam") echo "selected"?>>Pranata Komputer Ahli Madya</option>
							</select>
						</div>
					</div>
					<div class="mb-3">
						<label for="no_hp" class="form-label">No. Hp</label>
						<input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo $no_hp?>"  placeholder="No. Hp">
					</div>
					<div class="mb-3">
						<label for="alamat" class="form-label">Alamat</label>
						<input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat?>"  placeholder="Alamat">
					</div>
					<div class="col-12">
						<input type="submit" name="simpan" value="Simpan Data " class="btn btn-primary" id="">
					</div>
				</form>
			</div>
		</div>


		
		<!-- Untuk mengeluarkan data -->
		<div class="card">
			<h5 class="card-header text-white bg-secondary" >Data Pegawai</h5>
			<div class="card-body">
				<table class=" table table-striped">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">NIK</th>
							<th scope="col">Nama Lengkap</th>
							<th scope="col">Jabatan</th>
							<th scope="col">No. Hp</th>
							<th scope="col">Alamat</th>
							<th scope="col">Aksi</th>
						</tr>
						<tbody>
							<?php
								$sql2 = "select * from pegawai order by id asc";
								$q2 = mysqli_query($koneksi, $sql2);
								$urut =1;
								while($r2 = mysqli_fetch_array($q2)){
									$id = $r2['id'];
									$nik = $r2['nik'];
									$nama_lengkap = $r2['nama_lengkap'];
									$jabatan = $r2['jabatan'];
									$no_hp = $r2['no_hp'];
									$alamat = $r2['alamat'];

									?>

									<tr>
										<th scope="row"><?php echo $urut++?></th>
										<td scope="row"><?php echo $nik?></td>
										<td scope="row"><?php echo $nama_lengkap?></td>
										<td scope="row"><?php echo $jabatan?></td>
										<td scope="row"><?php echo $no_hp?></td>
										<td scope="row"><?php echo $alamat?></td>
										<td scope="row">
											<a href="index.php?op=edit&id=<?php echo $id?>"><button type="button" class="btn btn-warning">Edit</button></a>	
											<a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin hapus data ?')"><button type="button" class="btn btn-danger">Hapus</button></a>
										</td>
									</tr>
									<?php
								}
							?>
						</tbody>
					</thead>

				</table>
			</div>
		</div>
	</div>
	
</body>
</html>
