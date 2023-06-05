<?php include_once('include/session.php') ?>
<?php include_once('include/functions.php') ?>
<?php
if(!empty($_POST)){
  if($_POST['clientId']=="")
  {
    $checkBacklinks =$db->display('clients',' website="'.$_POST['website'].'"');

    if($checkBacklinks->num_rows == 0){

    $data = array(
      'company_name'  =>  $_POST['company_name'],
      'username' => $_POST['username'],
      'website'  =>  $_POST['website'],
      'seo_phone' => $_POST['seo_phone'],
      'seo_landline' => $_POST['seo_landline'],
      'seo_email'  =>  $_POST['seo_email'],
      'seo_password'  =>  $_POST['seo_password'],
      'created' => date ('Y-m-d H:i:s'),
    );
        $clientId=$db->insert('clients',$data);
        header("location:client.php");
  }else{
    header("location:add-client.php?error=duplicate entry");
  }
  }
  else
  {
    $clientId=$_POST['clientId'];
    $data = array(
      'company_name'  =>  $_POST['company_name'],
      'username' => $_POST['username'],
      'website'  =>  $_POST['website'],
      'seo_phone' => $_POST['seo_phone'],
      'seo_landline' => $_POST['seo_landline'],
      'seo_email'  =>  $_POST['seo_email'],
      'seo_password'  =>  $_POST['seo_password'],
      'created' => date ('Y-m-d H:i:s'),
    );
        $db->update('clients',$data,'id='.$clientId);
        header("location:client.php");
  }
}

if($_GET['id']!=''){
  $clientsQuery=$db->display('clients','id='.$_GET['id']);
  $row=$clientsQuery->fetch_array();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Conversions - Client Panel | Client Add</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
                                <h3 class="card-title">Client Details</h3>

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
                                        <label for="inputCompanyName">Company Name</label>
                                        <input type="text" id="companyName" value="<?php echo $row['company_name']?>"
                                            name="company_name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputUsername">Username</label>
                                        <input id="userName" name="username" value="<?php echo $row['username']?>"
                                            class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="inputWebsite">Website</label>
                                        <input id="website" name="website" value="<?php echo $row['website']?>"
                                            class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="inputSeoPhoneNumber">Seo Phone Number</label>
                                        <input id="seo_phone" name="seo_phone" value="<?php echo $row['seo_phone']?>"
                                            class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="inputSeoPhoneNumber">Other Phone Number</label>
                                        <input id="seo_phone" name="seo_landline"
                                            value="<?php echo $row['seo_landline']?>" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="inputClientCompany">Seo Email</label>
                                        <input id="seo_email" name="seo_email" value="<?php echo $row['seo_email']?>"
                                            class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="inputClientCompany">Seo Email Password</label>
                                        <input id="seo_password" name="seo_password"
                                            value="<?php echo $row['seo_password']?>" class="form-control" />
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <a href="client.php" class="btn btn-secondary">Cancel</a>
                                            <?php if($_GET['id']!=''){?>
                                            <input type="submit" value="Update Client"
                                                class="btn btn-success float-right">
                                            <?php }else{?>
                                            <input type="submit" value="Create new Client"
                                                class="btn btn-success float-right">
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