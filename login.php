<?php

session_start();
$error = '';
if (isset($_POST['submit'])) {
	if (empty($_POST['username']) || empty($_POST['password'])) {
		$error = "Form tidak boleh kosong";
	} else {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$connection = new mysqli("localhost", "root", "", "rpl");
		$username = mysql_real_escape_string(stripslashes($username));
		$password = md5(mysql_real_escape_string(stripslashes($password)));
		$query = "SELECT fullname, type FROM user JOIN usertype ON (usertype.id = user.usertype) WHERE password='$password' AND username='$username'";
		$result = $connection->query($query);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$_SESSION['logged_in'] = 1;
			$_SESSION['login_user'] = $username;
			$_SESSION['fullname'] = $row['fullname'];
			$_SESSION['usertype'] = $row['type'];
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