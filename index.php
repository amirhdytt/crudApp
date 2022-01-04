<?php 
	session_start();

	if( !isset($_SESSION["login"]) ) {
		header("location: login.php");
		exit;
	}

	require 'functions.php';

	// pagination
	// konfigurasi
	// $jumlahDataPerHalaman = 2;

	// count adalah fungsi menghasilkan outputan berapa baris di kembalikan
	// $jumlahData = count(query("SELECT * FROM mahasiswa"));
	// ceil adalah fungsi untuk membulatkan ke atas pada bilngan koma
	// $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
	

	// $halamanAktif = ( isset($_GET["halaman"]) ) ? $_GET["halaman"] : 1;
	// $awalData = ( $jumlahDataPerHalaman * $halamanAktif ) - $jumlahDataPerHalaman;


	$mahasiswa = query("SELECT * FROM mahasiswa");


	// tombol cari ditekan
	if( isset($_POST["cari"]) ) {
		$mahasiswa = cari($_POST["keyword"]);
	}


	// // ambil data dari tabel mahasiswa / query data mahasiswa
	// 	$result = mysqli_query($conn, "SELECT * FROM mahasiswa");

	// 	// ambil data (fetch) mahasiswa dari object result
	// 	// mysqli_fetch_row() // mengembalikan array numerik
	// 	// mysqli_fetch_assoc() // mengembalikan array asosiatif
	// 	// mysqli_fetch_array() // mengembalikan keduanya
	// 	// mysqli_fetch_object() //mengembalikan object

	// 	// while( $mhs = mysqli_fetch_assoc($result) ) {
	// 	// 	var_dump($mhs);
	// 	// }

 ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Halaman Admin</title>
	<style>
		.loader {
			width: 100px;
			position: absolute;
			top: 130px;
			left: 350px;
			z-index: -1;
			display: none;
		}

		table {
			width: 100%;
		}
	</style>
</head>

<body>

	<a href="logout.php">Logout</a>

	<h1>Daftar Mahasiswa</h1>
	<a href="tambah.php">Tambah Data Mahasiswa</a>
	<br>
	<a href="registrasi.php">Registrasi</a>
	<br><br>

	<form action="" method="post">

		<input type="text" name="keyword" size="40" autofocus placeholder="masukan keyword pencarian..." autocomplete="off"
			id="keyword">
		<button type="submit" name="cari" id="tombol-cari">Cari</button>

		<img src="img/loader.gif" class="loader" alt="">

	</form>

	<br>


	<div id="container">
		<table border="1" cellpadding="10" cellspacing="0">


			<tr>
				<th>No.</th>
				<th>Aksi</th>
				<th>Gambar</th>
				<th>NRP</th>
				<th>Nama</th>
				<th>Email</th>
				<th>Jurusan</th>
			</tr>

			<?php $i = 1; ?>
			<?php foreach($mahasiswa as $row ) : ?>
			<tr>
				<td><?= $i ; ?></td>
				<td>
					<a href="ubah.php?id=<?= $row["id"]; ?>">ubah</a> |
					<a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('yakin?');">hapus</a>
				</td>
				<td><img src="img/<?= $row["gambar"]; ?>" alt="" width="50"></td>
				<td><?= $row["nrp"]; ?></td>
				<td><?= $row["nama"]; ?></td>
				<td><?= $row["email"]; ?></td>
				<td><?= $row["jurusan"]; ?></td>
			</tr>
			<?php $i++; ?>
			<?php endforeach ?>

		</table>
	</div>

	<script src="js/jquery-3.5.1.min.js"></script>
	<script src="js/script.js"></script>

</body>

</html>