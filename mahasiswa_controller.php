<?php
include 'constants.php';
function getConnection() {
	return new mysqli(SERVER, DBUSER, DBPASS, DBNAME);
}

function closeConnection($connection) {
	$connection->close();
}

function getMatkulList() {
	$connection = getConnection();
	$query = "SELECT id id, namamatkul FROM matkul WHERE id NOT IN (SELECT idmatkul id FROM ambilmatkul WHERE idmahasiswa = " . $_SESSION['login_id'] . ")";
	$result = $connection->query($query);
	closeConnection($connection);
	return $result;
}

function insertMatkul() {
	$connection = getConnection();
	$query = "INSERT INTO ambilmatkul (idmahasiswa, idmatkul) VALUES (" . $_SESSION['login_id'] . "," . $_POST['matkul'] . ")";
	$connection->query($query);
	$_SESSION['message'] = "Sukses registrasi mata kuliah";
	$_SESSION['type'] = "success";
	closeConnection($connection);
	header("location: mhs_matkul.php");
}

function getRegisterList() {
	$connection = getConnection();
	$query = "SELECT idmatkul, namamatkul FROM ambilmatkul JOIN matkul ON (ambilmatkul.idmatkul = matkul.id) WHERE idmahasiswa = " . $_SESSION['login_id'];
	$result = $connection->query($query);
	closeConnection($connection);
	return $result;
}

function deleteRegister() {
	$connection = getConnection();
	$query = "DELETE FROM ambilmatkul WHERE idmahasiswa = " . $_SESSION['login_id'] . " AND idmatkul = " . $_POST['delete_id'];
	$connection->query($query);
	$_SESSION['message'] = "Sukses hapus mata kuliah";
	$_SESSION['type'] = "success";
	header("location: mhs_matkul.php");
}

function getFileList($idmatkul) {
	$connection = getConnection();
	$query = "SELECT file.id id_materi, nama, filelocation FROM file WHERE iddosen = (SELECT id FROM dosen WHERE dosenmatkul = " . $idmatkul . ")";
	$result = $connection->query($query);
	closeConnection($connection);
	return $result;
}

function checkHadir() {
	$connection = getConnection();
	$query = "INSERT INTO aksesfile (idmahasiswa, idmateri, tanggalakses) VALUES (" . $_SESSION['login_id'] . "," . $_POST['id_materi'] . ", NOW())";
	$connection->query($query);
	closeConnection($connection);
	header("location: " . $_POST['file_location']);
}