<?php include_once('include/session.php') ?>
<?php include_once('include/functions.php') ?>
<?php
if(!empty($_POST)){
  if($_POST['userId']=="")
  {
    $data = array(
          'role_id'       =>  $_POST['role_id'], 
          'email'         => $_POST['email'],
          'password'      =>  $_POST['password'],
          'first_name'    => $_POST['first_name'], 
          'last_name'     =>  $_POST['last_name'], 
          'designation'   =>  1, 
          'department_id' =>  $_POST['department_id'], 
          'created'       => date ('Y-m-d')
        );
        $opsId=$db->insert('users',$data);
        header("location:users.php");
  }
  else
  {
    $userId=$_POST['userId'];
    $data = array(
      'role_id'       =>  $_POST['role_id'], 
      'email'         => $_POST['email'],
      'password'      =>  $_POST['password'],
      'first_name'    => $_POST['first_name'], 
      'last_name'     =>  $_POST['last_name'], 
      'designation'   =>  1, 
      'department_id' =>  $_POST['department_id'], 
      'created'       => date ('Y-m-d')
    );
        $db->update('users',$data,'id='.$userId);
        header("location:users.php");

  }
}
if($_GET['id']!=''){
  $usersQuery=$db->display('users','id='.$_GET['id']);
  $row=$usersQuery->fetch_array();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Conversions - Client Panel | Client Add</title>

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
            <h1>Client Add</h1>
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
              <h3 class="card-title">User Details</h3>

              <!-- <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div> -->
            </div>
            <div class="card-body">
            <form method="post">
              <input type="hidden" value="<?php echo $row['id']?>" name="userId" />
              <div class="form-group">
                <label for="inputCompanyName">First Name</label>
                <input type="text" id="first_name" value="<?php echo $row['first_name']?>" name="first_name" class="form-control">
              </div>
              <div class="form-group">
                <label for="inputUsername">Last Name</label>
                <input id="last_name" name="last_name" value="<?php echo $row['last_name']?>" class="form-control" />
              </div>
              <div class="form-group">
                <label for="inputWebsite">Email Or UserName</label>
                <input id="email" name="email" value="<?php echo $row['email']?>" class="form-control" />
              </div>
              <div class="form-group">
                <label for="inputSeoPhoneNumber">Password</label>
                <input id="password" name="password" value="<?php echo $row['password']?>" class="form-control" />
              </div>
              <div class="form-group">
                <label for="inputCompanyName">Department</label>
                <select id="inputStatus" name="department_id" class="form-control custom-select">
                  <option selected disabled>Select one</option>
                  <?php $departments =$db->display('department');
                    if($departments->num_rows > 0){
                      while($departmentsData = $departments->fetch_array()) {?>
                      <option <?php if($departmentsData['id']==$row["department_id"]){?> selected <?php }?> value="<?php echo $departmentsData['id']?>"><?php echo $departmentsData['department']?></option>
                      <?php }}?>
                </select>
              </div>
              <div class="form-group">
                <label for="inputCompanyName">Roles</label>
                <select id="inputStatus" name="role_id" class="form-control custom-select">
                  <option selected disabled>Select one</option>
                  <?php $roles =$db->display('roles');
                    if($roles->num_rows > 0){
                      while($rolesData = $roles->fetch_array()) {?>
                      <option <?php if($rolesData['id']==$row["role_id"]){?> selected <?php }?> value="<?php echo $rolesData['id']?>"><?php echo $rolesData['role_name']?></option>
                      <?php }}?>
                </select>
              </div>
              <div class="row">
        <div class="col-3">
          <a href="users.php" class="btn btn-secondary">Cancel</a>
          <?php if($_GET['id']!=''){?>
                <input type="submit" value="Update User" class="btn btn-success float-right">
                <?php }else{?>
                <input type="submit" value="Create new User" class="btn btn-success float-right">
                  <?php }?>
        </div>
                      </form>
</div>
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
