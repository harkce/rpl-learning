<?php
session_start();
include('admin_controller.php');

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

if (isset($_POST['insert_matkul'])) {
	insertMatkul();
}

if (isset($_POST['delete_matkul'])) {
	deleteMatkul($_POST['id_matkul']);
}

if (isset($_POST['edit_matkul'])) {
	setEditMatkul();
}

if (isset($_POST['update_matkul'])) {
	updateMatkul();
}

if (isset($_POST['insert_dosen'])) {
	insertDosen();
}

if (isset($_POST['edit_dosen'])) {
	setEditDosen();
}

if (isset($_POST['update_dosen'])) {
	updateDosen();
}

if (isset($_POST['insert_kelas'])) {
	insertKelas();
}

if (isset($_POST['edit_kelas'])) {
	setEditKelas();
}

if (isset($_POST['update_kelas'])) {
	updateKelas();
}

if (isset($_POST['insert_mahasiswa'])) {
	insertMahasiswa();
}

if (isset($_POST['edit_mahasiswa'])) {
	setEditMahasiswa();
}

if (isset($_POST['delete_mhs'])) {
	deleteMahasiswa();
}

if (isset($_POST['update_mahasiswa'])) {
	updateMahasiswa();
}