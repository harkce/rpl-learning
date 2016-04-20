<?php
include 'admin.php';
if ($_SESSION['logged_in'] != 1) {
  header("location: login_page.php");
}
if ($_SESSION['usertype'] != 'admin') {
  header("location: home.php");
}
$mahasiswa_list = getMahasiswaList();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RPL Learning | Kelola Mahasiswa</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/skin-red.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- page style -->
    <style type="text/css">
    	.noline {
    		display:inline;
    		margin:0px;
    		padding:0px;
	    }
	</style>
  </head>
  <body class="hold-transition skin-red sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>RPL</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>RPL</b>Learning</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="dist/img/userimage.png" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo $_SESSION['fullname']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="dist/img/userimage.png" class="img-circle" alt="User Image">
                    <p>
                      <?php echo $_SESSION['fullname']; ?>
                      <small><?php echo ucfirst($_SESSION['usertype']); ?></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profil</a>
                    </div>
                    <div class="pull-right">
                      <a href="logout.php" class="btn btn-default btn-flat">Logout</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
              </li>
            </ul>
          </div>
        </nav>
      </header>

      <!-- =============================================== -->

      <!-- Left side column. contains the sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="dist/img/userimage.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?php echo $_SESSION['fullname']; ?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> <?php echo ucfirst($_SESSION['usertype']); ?></a>
            </div>
          </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">Menu</li>
            <li>
              <a href="home.php">
                <i class="fa fa-home"></i> <span>Beranda</span>
              </a>
            </li>
            <li class="treeview active">
              <a href="#">
                <i class="fa fa-user"></i>
                <span>Pengelolaan User</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="kelola_admin.php"><i class="fa fa-circle-o"></i> Admin</a></li>
                <li><a href="kelola_dosen.php"><i class="fa fa-circle-o"></i> Dosen</a></li>
                <li class="active"><a href="kelola_mahasiswa.php"><i class="fa fa-circle-o"></i> Mahasiswa</a></li>
              </ul>
            </li>
            <li>
              <a href="kelola_kelas.php">
                <i class="fa fa-th"></i> <span>Pengelolaan Kelas</span>
              </a>
            </li>
            <li>
              <a href="kelola_matkul.php">
                <i class="fa fa-files-o"></i> <span>Pengelolaan Mata Kuliah</span>
              </a>
            </li>
            <li class="header">Pengaturan</li>
            <li>
              <a href="#">
                <i class="fa fa-gear"></i> <span>Profil</span>
              </a>
            </li>
            <li>
              <a href="logout.php">
                <i class="fa fa-sign-out"></i> <span>Logout</span>
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Pengelolaan Mahasiswa
          </h1>
          <ol class="breadcrumb">
            <li><i class="fa fa-user"></i> Pengelolaan User</li>
            <li class="active"> Mahasiswa</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

        	<?php
        		if (isset($_SESSION['message']) && isset($_SESSION['type'])):
        		if ($_SESSION['type'] == "success"):
          ?>
        	<div class="alert alert-success alert-dismissable">
        		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        		<h4><i class="icon fa fa-check"></i> Sukses!</h4>
		        <?php echo $_SESSION['message']; ?>
          </div>
          <?php elseif ($_SESSION['message'] != ''): ?>
          <div class="alert alert-danger alert-dismissable">
        		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        		<h4><i class="icon fa fa-ban"></i> Peringatan!</h4>
		        <?php echo $_SESSION['message']; ?>
          </div>
          <?php
            endif;
            unset($_SESSION['message']);
            unset($_SESSION['type']);
            endif;
          ?>

          <div class="row">
        		<div class="col-lg-6">
        			<div class="box box-danger">
			          <div class="box-header with-border">
			          	<h3 class="box-title">Tambah Mahasiswa</h3>
			           	<div class="box-tools pull-right">
				            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
			           	</div>
			          </div>
			          <div class="box-body">
			           	<form role="form" method="post" action="admin.php">
			          		<div class="form-group">
                      <label>Nama Lengkap</label>
                      <input type="text" class="form-control" name="fullname" placeholder="Masukkan nama lengkap">
                    </div>
                    <div class="form-group">
                      <label>NIM</label>
                      <input type="number" min="1000000000" max="9999999999" class="form-control" name="nim" placeholder="Masukkan NIM">
                    </div>
                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" class="form-control" name="username" placeholder="Username untuk login">
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <label>Kelas</label>
                      <select name="kelas" class="form-control" placeholder="Pilih mata kuliah">
                        <option>Pilih kelas</option>
                        <?php $kelas_list = getKelasList(); while($row = $kelas_list->fetch_assoc()): ?><option value="<?php echo $row['id']; ?>"><?php echo $row['namakelas']; ?></option>
                      <?php endwhile; ?></select>
                    </div>
				            <div class="box-footer">
				              <button type="submit" class="btn btn-danger pull-right" name="insert_mahasiswa">Tambah</button>
				            </div>
			            </form>
			          </div><!-- /.box-body -->
			        </div><!-- /.box -->
        		</div>
        		
        		<div class="col-lg-6">
        			<div class="box box-danger">
			            <div class="box-header with-border">
			            	<h3 class="box-title">Daftar Mahasiswa</h3>
			            	<div class="box-tools pull-right">
				                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
			            	</div>
			            </div>
			            <div class="box-body">
			            	<table id="userdata" class="table table-bordered table-striped">
			            		<thead>
			            			<tr>
			            				<th>ID</th>
				                  <th>Nama</th>
				                  <th>Username</th>
				                  <th>Aksi</th>
				                </tr>
			            		</thead>
			            		<tbody>
			            			<?php while($row = $mahasiswa_list->fetch_assoc()): ?><tr>
			            				<th><?php echo $row['id']; ?></th>
			            				<th><?php echo $row['fullname']; ?></th>
			            				<th><?php echo $row['username']; ?></th>
			            				<th>
			            					<form role="form" method="post" action="admin.php" class="noline">
			            						<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
			            						<input type="hidden" name="fullname" value="<?echo $row['fullname']; ?>">
                              <input type="hidden" name="nim" value="<?php echo $row['nim']; ?>">
			            						<input type="hidden" name="username" value="<?php echo $row['username']; ?>">
                              <input type="hidden" name="id_kelas" value="<?php echo $row['kelas']; ?>">
			            						<button type="submit" class="btn btn-info" name="edit_mahasiswa"><i class="fa fa-edit"></i></button>
			            					</form>
			            					<form role="form" method="post" action="admin.php" class="noline">
			            						<input type="hidden" name="delete_username" value="<?php echo $row['username']; ?>">
				            					<button <?php if ($row['username'] == $_SESSION['login_user']) echo "disabled=" . '"true"' ?> type="submit" class="btn btn-danger" name="delete_user"><i class="fa fa-trash"></i></button>
                          					</form>
                          				</th>
                          			</tr>
			            		<?php endwhile; ?></tbody>
			            	</table>
			            </div><!-- /.box-body -->
			        </div><!-- /.box -->
        		</div>
        	</div>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.3.0
        </div>
        <strong>Copyright &copy; 2016 <a href="http://cingkleung.com">IF-38-08</a>.</strong> All rights reserved.
      </footer>

    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->
    <script>
    $(function() {
    	$("#userdata").DataTable();
    });
    </script>
  </body>
</html>
