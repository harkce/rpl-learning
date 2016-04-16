<?php
include 'constants.php';
function getConnection() {
	return new mysqli(SERVER, DBUSER, DBPASS, DBNAME);
}

function closeConnection($connection) {
	$connection->close();
}

function getAdminList() {
	$connection = getConnection();
	$query = "SELECT * FROM user WHERE usertype = 1";
	$result = $connection->query($query);
	closeConnection($connection);
	return $result;
}

function getDosenList() {
	$connection = getConnection();
	$query = "SELECT * FROM user JOIN dosen USING (id) WHERE usertype = 2";
	$result = $connection->query($query);
	closeConnection($connection);
	return $result;
}

function getMahasiswaList() {
	$connection = getConnection();
	$query = "SELECT * FROM user JOIN mahasiswa USING (id) WHERE usertype = 3";
	$result = $connection->query($query);
	closeConnection($connection);
	return $result;
}

function getMatkulList() {
	$connection = getConnection();
	$query = "SELECT * FROM matkul";
	$result = $connection->query($query);
	closeConnection($connection);
	return $result;
}

function getKelasList() {
	$connection = getConnection();
	$query = "SELECT * FROM kelas";
	$result = $connection->query($query);
	closeConnection($connection);
	return $result;
}

function insertUser() {
	$connection = getConnection();
	$fullname = $_POST['fullname'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	// $fullname = mysql_real_escape_string(stripslashes($fullname));
	// $username = mysql_real_escape_string(stripslashes($username));
	$password = md5($password);

	if (empty($fullname) || empty($username) || empty($password)) {
		$_SESSION['message'] = "Form tidak boleh kosong";
		$_SESSION['type'] = "error";
		closeConnection($connection);
		header("location: kelola_admin.php");
	} else {
		$check = "SELECT * FROM user WHERE username='$username'";
		$check = $connection->query($check);
		if ($check->num_rows > 0) {
			$_SESSION['message'] = "Username sudah digunakan";
			$_SESSION['type'] = "error";
			closeConnection($connection);
			header("location: kelola_admin.php");
		} else {
			$query = "INSERT INTO user (username, password, fullname, usertype) VALUES ('$username', '$password', '$fullname', 1)";
			$result = $connection->query($query);
			$_SESSION['message'] = "User berhasil ditambahkan";
			$_SESSION['type'] = "success";
			closeConnection($connection);
			header("location: kelola_admin.php");
		}
	}

}

function deleteUser($username) {
	$connection = getConnection();
	$query = "DELETE FROM user WHERE username='$username'";
	$result = $connection->query($query);
	$_SESSION['message'] = "User berhasil dihapus";
	$_SESSION['type'] = "success";
	closeConnection($connection);
	header("location: kelola_admin.php");
}

function setEdit() {
	$_SESSION['edit_id'] = $_POST['id'];
	$_SESSION['edit_fullname'] = $_POST['fullname'];
	$_SESSION['edit_username'] = $_POST['username'];
	header("location: edit_admin.php");
	closeConnection($connection);
	die();
}

function updateUser() {
	$connection = getConnection();
	$id = $_POST['id'];
	$fullname = $_POST['fullname'];
	if (empty($fullname)) {
		$_SESSION['message'] = "Field nama tidak boleh kosong";
		$_SESSION['type'] = "error";
		header("location: edit_admin.php");
	} elseif (empty($_POST['password'])) {
		$query = "UPDATE user SET fullname='$fullname' WHERE id=$id";
		echo $query;
		$result = $connection->query($query);
		$_SESSION['edit_fullname'] = $fullname;
		$_SESSION['message'] = "User berhasil diupdate";
		$_SESSION['type'] = "success";
		$_SESSION['fullname'] = $fullname;
		closeConnection($connection);
		header("location: edit_admin.php");
	} else {
		$password = md5($_POST['password']);
		print_r($_POST); die();
		$query = "UPDATE user SET fullname='$fullname', password='$password' WHERE id=$id";
		$result = $connection->query($query);
		$_SESSION['message'] = "User berhasil diupdate";
		$_SESSION['type'] = "success";
		$_SESSION['fullname'] = $fullname;
		closeConnection($connection);
		header("location: edit_admin.php");
	}
}

function insertMatkul() {
	$connection = getConnection();
	$nama_matkul = $_POST['nama_matkul'];
	// $nama_matkul  =mysql_real_escape_string(stripslashes($nama_matkul));

	if (empty($nama_matkul)) {
		$_SESSION['message'] = "Form tidak boleh kosong";
		$_SESSION['type'] = "error";
		closeConnection($connection);
		header("location: kelola_matkul.php");
	} else {
		$query = "INSERT INTO matkul (namamatkul) values ('$nama_matkul')";
		$query = $connection->query($query);
		$_SESSION['message'] = "Mata Kuliah berhasil ditambahkan";
		$_SESSION['type'] = "success";
		closeConnection($connection);
		header("location: kelola_matkul.php");
	}
}

function deleteMatkul($id_matkul) {
	$connection = getConnection();
	$query = "DELETE FROM matkul WHERE id='$id_matkul'";
	$result = $connection->query($query);
	$_SESSION['message'] = "Mata kuliah berhasil dihapus";
	$_SESSION['type'] = "success";
	closeConnection($connection);
	header("location: kelola_matkul.php");
}

function setEditMatkul() {
	$_SESSION['editmk_id'] = $_POST['id_matkul'];
	$_SESSION['editmk_nama'] = $_POST['nama_matkul'];
	header("location: edit_matkul.php");
}

function updateMatkul() {
	$connection = getConnection();
	$id = $_POST['id'];
	$namamk = $_POST['nama_matkul'];
	if (empty($namamk)) {
		$_SESSION['message'] = "Nama mata kuliah tidak boleh kosong";
		$_SESSION['type'] = "error";
		header("location: edit_matkul.php");
	} else {
		$connection = getConnection();
		$query = "UPDATE matkul SET namamatkul = '$namamk' WHERE id = $id";
		$connection->query($query);
		closeConnection($connection);
		$_SESSION['message'] = "Sukses update nama mata kuliah";
		$_SESSION['type'] = "success";
		$_SESSION['editmk_nama'] = $namamk;
		header("location: edit_matkul.php");
	}
}

function insertDosen() {
	$connection = getConnection();
	$fullname = $_POST['fullname'];
	$nip = $_POST['nip'];
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	$matkul = $_POST['matkul'];
	if (empty($fullname) || empty($nip) || empty($username) || empty($password) || empty($nip)) {
		$_SESSION['message'] = "Form tidak boleh kosong";
		$_SESSION['type'] = "error";
		closeConnection($connection);
		header("location: kelola_dosen.php");
		die();
	} else {
		$check = "SELECT * FROM user WHERE username='$username'";
		$check = $connection->query($check);
		if ($check->num_rows > 0) {
			$_SESSION['message'] = "Username sudah digunakan";
			$_SESSION['type'] = "error";
			closeConnection($connection);
			header("location: kelola_dosen.php");
		} else {
			$query = "INSERT INTO user (username, password, fullname, usertype) VALUES ('$username', '$password', '$fullname', 2)";
			$result = $connection->query($query);
			$query = "SELECT id FROM user WHERE username = '$username'";
			$result = $connection->query($query);
			$row = $result->fetch_assoc();
			$userid = $row['id'];
			$query = "INSERT INTO dosen VALUES ($userid, $nip, $matkul)";
			$connection->query($query);
			$_SESSION['message'] = "User berhasil ditambahkan";
			$_SESSION['type'] = "success";
			closeConnection($connection);
			header("location: kelola_dosen.php");
		}
	}
}

function setEditDosen() {
	$_SESSION['editdosen_id'] = $_POST['id'];
	$_SESSION['editdosen_nama'] = $_POST['fullname'];
	$_SESSION['editdosen_nip'] = $_POST['nip'];
	$_SESSION['editdosen_user'] = $_POST['username'];
	$_SESSION['editdosen_idmatkul'] = $_POST['id_matkul'];
	header("location: edit_dosen.php");
}

function updateDosen() {
	if ($_POST['matkul'] == 'x' || empty($_POST['fullname']) || empty($_POST['nip'])) {
		$_SESSION['message'] = "Form tidak boleh kosong";
		$_SESSION['type'] = "error";
		header("location: edit_dosen.php");
		die();
	} else {
		$id = $_POST['id'];
		$fullname = $_POST['fullname'];
		$nip = $_POST['nip'];
		$dosenmatkul = $_POST['matkul'];
		$_SESSION['editdosen_nama'] = $fullname;
		$_SESSION['editdosen_nip'] = $nip;
		$_SESSION['editdosen_idmatkul'] = $dosenmatkul;
		$connection = getConnection();
		if (!empty($_POST['password'])) {
			$password = md5($_POST['password']);
			$query = "UPDATE user SET password = '$password' WHERE id = $id";
			$connection->query($query);
		}
		$query = "UPDATE user SET fullname = '$fullname' WHERE id = $id";
		$connection->query($query);
		$query = "UPDATE dosen SET nip = '$nip', dosenmatkul = '$dosenmatkul' WHERE id = $id";
		$connection->query($query);
		closeConnection($connection);
		$_SESSION['message'] = "Data dosen berhasil diupdate";
		$_SESSION['type'] = "success";
		header("location: edit_dosen.php");
	}
}

function insertKelas() {
	if (empty($_POST['nama_kelas'])) {
		$_SESSION['message'] = "Form tidak boleh kosong";
		$_SESSION['type'] = "error";
		header("location: kelola_kelas.php");
		die();
	} else {
		$connection = getConnection();
		$nama_kls = $_POST['nama_kelas'];
		$querycheck = "SELECT * FROM kelas WHERE namakelas = '$nama_kls'";
		$tmp = $connection->query($querycheck);
		if ($tmp->num_rows > 0) {
			$_SESSION['message'] = "Kelas dengan nama <b>" . $nama_kls . "</b> sudah ada";
			$_SESSION['type'] = "error";
			closeConnection($connection);
			header("location: kelola_kelas.php");
			die();
		} else {
			$query = "INSERT INTO kelas (namakelas) VALUES ('$nama_kls')";
			$connection->query($query);
			$_SESSION['message'] = "Sukses tambah kelas <b>" . $nama_kls . "</b>";
			$_SESSION['type'] = "success";
			closeConnection($connection);
			header("location: kelola_kelas.php");
			die();
		}
	}
}

function setEditKelas() {
	$_SESSION['editkelas_id'] = $_POST['id_kelas'];
	$_SESSION['editkelas_nama'] = $_POST['nama_kelas'];
	header("location: edit_kelas.php");
}

function updateKelas() {
	if (empty($_POST['nama_kelas'])) {
		$_SESSION['message'] = "Form tidak boleh kosong";
		$_SESSION['type'] = "error";
		header("location: kelola_kelas.php");
		die();
	} else {
		$connection = getConnection();
		$nama_kls = $_POST['nama_kelas'];
		$querycheck = "SELECT * FROM kelas WHERE namakelas = '$nama_kls'";
		$tmp = $connection->query($querycheck);
		if ($tmp->num_rows > 0) {
			$_SESSION['message'] = "Kelas dengan nama <b>" . $nama_kls . "</b> sudah ada";
			$_SESSION['type'] = "error";
			closeConnection($connection);
			header("location: edit_kelas.php");
			die();
		} else {
			$id = $_POST['id'];
			$query = "UPDATE kelas SET namakelas = '$nama_kls' WHERE id = $id";
			$connection->query($query);
			$_SESSION['message'] = "Sukses update kelas <b>" . $nama_kls . "</b>";
			$_SESSION['type'] = "success";
			$_SESSION['editkelas_nama'] = $nama_kls;
			closeConnection($connection);
			header("location: edit_kelas.php");
			die();
		}
	}
}

function insertMahasiswa() {
	$connection = getConnection();
	$fullname = $_POST['fullname'];
	$nim = $_POST['nim'];
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	$kelas = $_POST['kelas'];
	if (empty($fullname) || empty($nip) || empty($username) || empty($password) || empty($nip)) {
		$_SESSION['message'] = "Form tidak boleh kosong";
		$_SESSION['type'] = "error";
		closeConnection($connection);
		header("location: kelola_mahasiswa.php");
		die();
	} else {
		$check = "SELECT * FROM user WHERE username='$username'";
		$check = $connection->query($check);
		if ($check->num_rows > 0) {
			$_SESSION['message'] = "Username sudah digunakan";
			$_SESSION['type'] = "error";
			closeConnection($connection);
			header("location: kelola_mahasiswa.php");
			die();
		} else {
			$query = "INSERT INTO user (username, password, fullname, usertype) VALUES ('$username', '$password', '$fullname', 3)";
			$result = $connection->query($query);
			$query = "SELECT id FROM user WHERE username = '$username'";
			$result = $connection->query($query);
			$row = $result->fetch_assoc();
			$userid = $row['id'];
			$query = "INSERT INTO mahasiswa VALUES ($userid, '$nim', $kelas)";
			$connection->query($query);
			$_SESSION['message'] = "User berhasil ditambahkan";
			$_SESSION['type'] = "success";
			closeConnection($connection);
			header("location: kelola_mahasiswa.php");
			die();
		}
	}
}