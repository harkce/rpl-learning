<?php
session_start();
include 'dosen_controller.php';

if (!isset($_SESSION['logged_in'])) {
	header("location: login_page.php");
}

if (isset($_POST['insert_materi'])) {
	insertMateri();
}

if (isset($_POST['delete_materi'])) {
	deleteMateri($_POST['materi_id']);
}