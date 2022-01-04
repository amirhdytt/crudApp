<?php 

	// koneksi ke database
		$conn = mysqli_connect("localhost", "root", "", "phpdasar");


		function query($query) {
			global $conn;
			// object
			$result = mysqli_query($conn, $query);
			$rows = [];
			// mengubah object ke array
			while( $row = mysqli_fetch_assoc($result) ) {
			// array asosiatif yang didalam array numerik
				$rows[] = $row;
			}
			return $rows;
		}


		function tambah($data) {
			// ambil data dari tiap elemen dalam form
			global $conn;

			$nrp = htmlspecialchars($data["nrp"]);
			$nama  = htmlspecialchars($data["nama"]);
			$email = htmlspecialchars($data["email"]);
			$jurusan = htmlspecialchars($data["jurusan"]);

			// upload gambar
			$gambar = upload();
			if( !$gambar ) {
				return false;
			}


			// query insert data
			$query = "INSERT INTO mahasiswa
						VALUES
					('', '$nrp', '$nama', '$email', '$jurusan', '$gambar')";
			mysqli_query($conn, $query);

			return mysqli_affected_rows($conn);
		}





		function upload() {
			// ambil data dari superglobal ke dalam variabel
			$namaFile = $_FILES['gambar']['name'];
			$ukuranFile = $_FILES['gambar']['size'];
			$error = $_FILES['gambar']['error'];
			$tmpName = $_FILES['gambar']['tmp_name'];

			// cek apakah tidak ada gambar yang di upload 
			if( $error === 4 ) {
				echo "<script>
						alert('pilih gambar terlebih dahulu');
					  </script>";
					  return false;
			}

			// cek apakah yang diupload adalah gambar
			$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
			// memisahkan string menurut tanda pisah
			$ekstensiGambar = explode('.', $namaFile);
			var_dump($ekstensiGambar);
			$ekstensiGambar = strtolower(end($ekstensiGambar));
			// mencari nilai yang teradapat dalam sebuah array
			if( !in_array($ekstensiGambar, $ekstensiGambarValid)) {
				echo "<script>
						alert('yang anda upload bukan gambar');
					  </script>";
					  return false;
			}

			// cek jika ukurannya terlalu besar
			if( $ukuranFile > 1000000 ) {
				echo "<script>
						alert('ukuran gambar terlalu besar');
					  </script>";
					  return false;
			}


			// lolos pengecekan, gambar siap diupload
			// generate nama gambar baru 

			$namaFileBaru = uniqid();
			$namaFileBaru .= '.';
			$namaFileBaru .= $ekstensiGambar;



			move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
			return $namaFileBaru;

		}


		function hapus($id) {
			global $conn;
			mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");
			return mysqli_affected_rows($conn);
		}


		function ubah($data) {
			global $conn;

			$id = $data["id"];
			$nrp = htmlspecialchars($data["nrp"]);
			$nama  = htmlspecialchars($data["nama"]);
			$email = htmlspecialchars($data["email"]);
			$jurusan = htmlspecialchars($data["jurusan"]);
			$gambarLama = htmlspecialchars($data["gambarLama"]);


			// cek apakah user pilih gambar baru atau tidak
			if( $_FILES['gambar']['error'] === 4 ) {
				$gambar = $gambarLama;
			} else {
				$gambar = upload();
			}


			// query insert data
			$query = "UPDATE mahasiswa SET 
						nrp = '$nrp',
						nama = '$nama',
						email = '$email',
						jurusan = '$jurusan',
						gambar = '$gambar'
					  WHERE id = $id
						";

			mysqli_query($conn, $query);

			return mysqli_affected_rows($conn);
		}


		function Cari($keyword) {
			$query = "SELECT * FROM mahasiswa WHERE
					  nama LIKE '%$keyword%' OR
					  nrp LIKE '%$keyword%' OR
					  email LIKE '%$keyword%' OR
					  jurusan LIKE '%$keyword%' 
					 ";
			return query($query);
		}


		function registrasi($data) {
			global $conn;

			$username = strtolower(stripcslashes($data["username"]));
			$password = mysqli_real_escape_string($conn, $data["password"]);
			$password2 = mysqli_real_escape_string($conn, $data["password2"]);


			// cek username sudah ada atau belum
			$result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");


			if( mysqli_fetch_assoc($result) ) {
				echo "<script>
					alert('username sudah teradftar');
				  </script>";
				  return false;
			}

			// cek konfimasi password
			if( $password !== $password2 ) {
				echo "<script>
					alert('konfimasi password tidak sesuai');
				  </script>";
				return false;
			}


			// enkripsi password
			$password = password_hash($password, PASSWORD_DEFAULT);


			// tambahkan user baru ke database
			mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");
			return mysqli_affected_rows($conn);
		}



 ?>