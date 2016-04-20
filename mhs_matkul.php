<?php
include 'mahasiswa.php';
if ($_SESSION['logged_in'] != 1) {
  header("location: login_page.php");
}
if ($_SESSION['usertype'] != 'mahasiswa') {
  header("location: home.php");
}
$matkul_list = getMatkulList();
$register_list = getRegisterList();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RPL Learning | Registrasi Mata Kuliah</title>
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
                      <small><?php echo ucfirst($_SESSION['nim']); ?></small>
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
              <a href="#"><i class="fa fa-circle text-success"></i> <?php echo ucfirst($_SESSION['usertype']) . " - " . $_SESSION['nim'];?></a>
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
            <li class="active">
              <a href="mhs_matkul.php">
                <i class="fa fa-sign-in"></i>
                <span>Registrasi Mata Kuliah</span>
              </a>
            </li>
            <li>
              <a href="mhs_materi.php">
                <i class="fa fa-file-o"></i> <span>Materi</span>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-pencil"></i> <span>Evaluasi</span>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-tasks"></i> <span>Tugas</span>
              </a>
            </li>
            <li class="header">Laporan</li>
            <li>
              <a href="#">
                <i class="fa fa-users"></i> <span>Kehadiran Mahasiswa</span>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-edit"></i> <span>Hasil Evaluasi</span>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-files-o"></i> <span>Pengumpulan Tugas</span>
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
            Registrasi Mata Kuliah
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-sign-in"></i> Registrasi Mata Kuliah</a></li>
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
                  <h3 class="box-title">Registrasi</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <form role="form" method="post" action="mahasiswa.php">
                <div class="box-body">
                  <div class="form-group">
                    <label>Mata Kuliah</label>
                    <select name="matkul" class="form-control" placholder="Pilih mata kuliah"><?php while($row = $matkul_list->fetch_assoc()): ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['namamatkul']; ?></option>
                    <?php endwhile; ?></select>
                  </div>
                </div>
                <div class="box-footer">
                  <button type="submit" class="btn btn-danger pull-right" name="insert_matkul">Tambah</button>
                </div>
                </form>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Daftar Mata Kuliah</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <table id="userdata" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <td>No</td>
                        <td>Nama Matkul</td>
                        <td>Aksi</td>
                      </tr>
                    </thead>
                    <tbody><?php $i = 1; while ($row = $register_list->fetch_assoc()): ?>
                      <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td><?php echo $row['namamatkul']; ?></td>
                        <td><form role="form" method="post" action="mahasiswa.php" class="noline">
                              <input type="hidden" name="delete_id" value="<?php echo $row['idmatkul']; ?>">
                              <button type="submit" class="btn btn-danger" name="delete_register"><i class="fa fa-trash"></i></button>
                        </form></td>
                      </tr>
                    <?php endwhile; ?></tbody>
                  </table>
                </div>
              </div>
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
