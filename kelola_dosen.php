?php
include 'admin.php';
if ($_SESSION['logged_in'] != 1) {
	header("location: login_page.php");
}
if ($_SESSION['usertype'] != 'admin') {
	header("location: home.php");
}
$dosen_list = getDosenList();
?>