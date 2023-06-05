<?php include_once('include/session.php') ?>
<?php include_once('include/functions.php') ?>
<?php
if(!empty($_POST)){
  if($_POST['backlinksId']=="")
  {
    $data = array(
          'backlink' => $_POST['backlink'],
          'created' => date ('Y-m-d H:i:s')
        );
        $backlinks = $db->insert('master_backlinks',$data);
        header("location:manage-backlink.php");
  }
  else
  {
    $backlinksId=$_POST['backlinksId'];
      $data = array(
        'backlink' => $_POST['backlink'],
        'created' => date ('Y-m-d H:i:s')
        );
        $db->update('master_backlinks',$data,'id='.$backlinksId);
        header("location:manage-backlink.php");
  }
}
if($_GET['id']!=''){
  $backlinksQuery=$db->display('master_backlinks','id='.$_GET['id']);
  $row=$backlinksQuery->fetch_array();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Conversions - Client Panel | Backlink Add</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
<?php include_once('include/header.php') ?>
<?php include_once('include/sidebar.php') ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Backlink Add</h1>
          </div>
          <?php include_once('include/breadcrumb.php') ?>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-10">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Backlink Details</h3>

              <!-- <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div> -->
            </div>
            <div class="card-body">
            <form action="" method="post">
            <input type="hidden" value="<?php echo $row['id']?>" name="backlinksId" />
              
              <div class="form-group">
                <label for="inputUsername">Backlink Url</label>
                <input id="backlink" name="backlink" type="text" value="<?php echo $row['backlink']?>" class="form-control" />
              </div>
              
              <div class="row">
              <div class="col-3">
                <a href="manage-backlink.php" class="btn btn-secondary">Cancel</a>
                <?php if($_GET['id']!=''){?>
                <input type="submit" value="Update Backlink" class="btn btn-success float-right">
                <?php }else{?>
                <input type="submit" value="Create new Backlink" class="btn btn-success float-right">
                  <?php }?>
              </div>
              </div>
            </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include_once('include/footer.php') ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
