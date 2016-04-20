<?php
session_start();
include('mahasiswa_controller.php');

if (!isset($_SESSION['logged_in'])) {
	header("location: login_page.php");
}

if (isset($_POST['insert_matkul'])) {
	insertMatkul();
}

if (isset($_POST['delete_register'])) {
	deleteRegister();
}

if (isset($_POST['check_hadir'])) {
	checkHadir();
}