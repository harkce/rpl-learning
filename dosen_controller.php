<?php
include 'constants.php';
function getConnection() {
	return new mysqli(SERVER, DBUSER, DBPASS, DBNAME);
}

function closeConnection($connection) {
	$connection->close();
}

function getMateriList() {
	$connection = getConnection();
	$query = "SELECT * FROM file WHERE iddosen = " . $_SESSION['login_id'] . " AND filetype = 1";
	$result = $connection->query($query);
	closeConnection($connection);
	return $result;
}

function insertMateri() {
	if (empty($_POST['nama_materi'])) {
		$_SESSION['message'] = "Nama materi tidak boleh kosong";
		$_SESSION['type'] = "error";
		header("location: dosen_materi.php");
		die();
	}
	if (empty($_FILES['file_materi'])) {
		$_SESSION['message'] = "Pilih file materi yang akan diunggah";
		$_SESSION['type'] = "error";
		header("location: dosen_materi.php");
		die();
	}
	$target_dir = "materi/";
	$target_file = $target_dir . basename($_FILES["file_materi"]["name"]);
	$uploadOk = 1;
	$docFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	if (file_exists($target_file)) {
	    $_SESSION['message'] = "Nama file sudah ada";
		$_SESSION['type'] = "error";
	    $uploadOk = 0;
	    header("location: dosen_materi.php");
	    die();
	}
	if ($_FILES["file_materi"]["size"] > 5000000) {
	    $_SESSION['message'] = "Ukuran file terlalu besar. Maksimum unggah file berukuran 50MB";
		$_SESSION['type'] = "error";
	    $uploadOk = 0;
	    header("location: dosen_materi.php");
	    die();
	}
	if($docFileType != "pdf" && $docFileType != "doc" && $docFileType != "docx"
		&& $docFileType != "ppt" && $docFileType != "pptx" && $docFileType != "rar" && $docFileType != "zip" ) {
	    $_SESSION['message'] = "Format file yang boleh diunggah hanya PDF, DOC, DOCX, PPT, PPTX, RAR, dan ZIP";
		$_SESSION['type'] = "error";
	    $uploadOk = 0;
	    header("location: dosen_materi.php");
	    die();
	}
	if ($uploadOk == 0) {
    	$_SESSION['message'] = "Terjadi kesalahan saat mengunggah file";
		$_SESSION['type'] = "error";
	    header("location: dosen_materi.php");
	    die();
    } else {
    	if (move_uploaded_file($_FILES["file_materi"]["tmp_name"], $target_file)) {
    		$nama_materi = $_POST['nama_materi'];
    		$connection = getConnection();
    		$query = "INSERT INTO file (nama,filelocation,tanggalupload,filetype,iddosen) VALUES ('$nama_materi', '" . basename($_FILES["file_materi"]["name"]) . "', NOW(), 1, " . $_SESSION['login_id'] . ")";
    		$connection->query($query);
    		$_SESSION['message'] = "Sukses unggah file " . basename($_FILES["file_materi"]["name"]);
			$_SESSION['type'] = "success";
		    header("location: dosen_materi.php");
		    die();
	    } else {
	        $_SESSION['message'] = "Terjadi kesalahan saat mengunggah file";
			$_SESSION['type'] = "error";
		    header("location: dosen_materi.php");
		    die();
	    }
    }
}

function deleteMateri($id) {
	$connection = getConnection();
	$query = "DELETE FROM materi WHERE id = $id";
	$result = $connection->query($query);
	unlink("materi/" . $_POST['file_location']);
	$_SESSION['message'] = "Materi telah dihapus";
	$_SESSION['type'] = "success";
	header("location: dosen_materi.php");
	die();
}