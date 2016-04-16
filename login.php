<?php
include 'constants.php';
session_start();
$error = '';
if (isset($_POST['submit'])) {
	if (empty($_POST['username']) || empty($_POST['password'])) {
		$error = "Form tidak boleh kosong";
	} else {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$connection = new mysqli(SERVER, DBUSER, DBPASS, DBNAME);
		// $username = mysql_real_escape_string(stripslashes($username));
		$password = md5($password);
		$query = "SELECT user.id id, fullname, type FROM user JOIN usertype ON (usertype.id = user.usertype) WHERE password='$password' AND username='$username'";
		$result = $connection->query($query);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$_SESSION['logged_in'] = 1;
			$_SESSION['login_user'] = $username;
			$_SESSION['login_id'] = $row['id'];
			$_SESSION['fullname'] = $row['fullname'];
			$_SESSION['usertype'] = $row['type'];

			if ($_SESSION['usertype'] == 'dosen') {
				$query = "SELECT nip, namamatkul FROM user JOIN dosen USING (id) JOIN matkul ON (dosen.dosenmatkul = matkul.id) WHERE username = '$username'";
				$result = $connection->query($query);
				$row = $result->fetch_assoc();
				$_SESSION['nip'] = $row['nip'];
				$_SESSION['matkul'] = $row['namamatkul'];
			}
			// Redirect ke halaman utama
			header("location: home.php");
			// echo "sukses"; die();
		} else {
			$error = "Username/password salah";
		}
		// Tutup koneksi database
		$connection->close();
	}
}