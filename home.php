<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
	header("location: login_page.php");
}
switch ($_SESSION['usertype']) {
	case 'admin':
		header("location: admin_home.php");
		break;
	
	case 'dosen':
		header("location: dosen_home.php");
		break;

	case 'mahasiswa':
		header("location: mahasiswa_home.php");
		break;

	default:
		break;
}