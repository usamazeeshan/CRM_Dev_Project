<?php include_once('include/session.php') ?>
<?php include_once('include/functions.php') ?>
<?php
if(!empty($_POST)){
  if($_POST['clientId']=="")
  {
    $checkPBNs = $db->display('pbns',' pbn_url="'.$_POST['pbn_url'].'"');
    if($checkPBNs->num_rows == 0){
    $data = array(
      'pbn_url'  =>  $_POST['pbn_url'], 
      'username' => $_POST['username'],
      'password'  =>  $_POST['password'],
      'created' => date ('Y-m-d H:i:s')
    );
        $clientId=$db->insert('pbns',$data);
  }else{
    $errorMsg = 'can\'t insert duplicate record';
  }
        header("location:pbns.php");
  }
  else
  {

    $data = array(
      'pbn_url'  =>  $_POST['pbn_url'], 
      'username' => $_POST['username'],
      'password'  =>  $_POST['password'],
      'created' => date ('Y-m-d H:i:s')
    );
        $db->update('pbns',$data,'id='.$_POST['clientId']);
        header("location:pbns.php");
  }
}

if($_GET['id']!=''){
  $pbnsQuery=$db->display('pbns','id='.$_GET['id']);
  $row=$pbnsQuery->fetch_array();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Conversions - Client Panel | PBN Add</title>

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
            <h1>PBN Add</h1>
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
              <h3 class="card-title">PBN Details</h3>

              <!-- <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div> -->
            </div>
            <div class="card-body">
            <form method="post">
              <input type="hidden" value="<?php echo $row['id']?>" name="clientId" />
              <div class="form-group">
                <label for="inputCompanyName">PBN URL</label>
                <input type="text" id="pbn_url" value="<?php echo $row['pbn_url']?>" name="pbn_url" class="form-control">
              </div>
              <div class="form-group">
                <label for="inputUsername">Username</label>
                <input id="userName" name="username" value="<?php echo $row['username']?>" class="form-control" />
              </div>
              <div class="form-group">
                <label for="inputWebsite">Password</label>
                <input id="password" name="password" value="<?php echo $row['password']?>" class="form-control" />
              </div>
              <div class="row">
        <div class="col-3">
          <a href="pbns.php" class="btn btn-secondary">Cancel</a>
          <?php if($_GET['id']!=''){?>
                <input type="submit" value="Update PBN" class="btn btn-success float-right">
                <?php }else{?>
                <input type="submit" value="Create new PBN" class="btn btn-success float-right">
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
