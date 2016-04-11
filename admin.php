<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
	header("location: login_page.php");
}

if (isset($_POST['insert_user'])) {
	insertUser();
}

if (isset($_POST['delete_user'])) {
	if ($_SESSION['login_user'] == $_POST['delete_username']) {
		$_SESSION['message'] = "Tidak diperbolehkan menghapus user sendiri";
		$_SESSION['type'] = "error";
		header("location: kelola_admin.php");
		die();
	}
	deleteUser($_POST['delete_username']);
}

if (isset($_POST['edit_user'])) {
	setEdit();
}

if (isset($_POST['update_user'])) {
	updateUser();
}

function getConnection() {
	return new mysqli("localhost", "root", "", "rpl");
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

function insertUser() {
	$connection = getConnection();
	$fullname = $_POST['fullname'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$fullname = mysql_real_escape_string(stripslashes($fullname));
	$username = mysql_real_escape_string(stripslashes($username));
	$password = md5(mysql_real_escape_string(stripslashes($password)));

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
		closeConnection($connection);
		header("location: edit_admin.php");
	} else {
		$password = md5($_POST['password']);
		print_r($_POST); die();
		$query = "UPDATE user SET fullname='$fullname', password='$password' WHERE id=$id";
		$result = $connection->query($query);
		$_SESSION['message'] = "User berhasil diupdate";
		$_SESSION['type'] = "success";
		closeConnection($connection);
		header("location: edit_admin.php");
	}
}