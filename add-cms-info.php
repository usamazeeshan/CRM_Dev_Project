<?php include_once('include/session.php') ?>
<?php include_once('include/functions.php') ?>
<?php
if(!empty($_POST)){
  if($_POST['cmsId']=="")
  {
    $checkArticleInfos =$db->display('cms_details',' url="'.$_POST['url'].'" and login='.$_POST['login']);
    if($checkArticleInfos->num_rows == 0){
    $data = array(
          'client_id'  =>  $_POST['client_id'],
          'url' => $_POST['url'],
          'login' => $_POST['login'],
          'password' => $_POST['password'],
          'extras' => $_POST['extras'],
          'created' => date ('Y-m-d H:i:s')
        );
        $backlinks = $db->insert('cms_details',$data);
      }
        header("location:manage-cms.php");
  }
  else
  {
    $cmsId=$_POST['cmsId'];
    // $checkArticleInfos =$db->display('cms_details',' url="'.$_POST['url'].'" and login="'.$_POST['login'].'"');
    // echo $checkArticleInfos->num_rows;
    // echo 'gagan';
    // if($checkArticleInfos->num_rows > 0){
      $data = array(
        'client_id'  =>  $_POST['client_id'],
          'url' => $_POST['url'],
          'login' => $_POST['login'],
          'password' => $_POST['password'],
          'extras' => $_POST['extras'],
        'created' => date ('Y-m-d H:i:s')
      );
        $db->update('cms_details',$data,'id='.$cmsId);
        header("location:manage-cms.php");
    //   }else{
    //     $errorMsg = 'can update record';
    //     header("location:manage-cms.php?errorMsg=".$errorMsg."");
    //   }
  }
}
if($_GET['id']!=''){
  $ArticleInfosQuery=$db->display('cms_details','id='.$_GET['id']);
  $row=$ArticleInfosQuery->fetch_array();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Conversions - Client CMS Add</title>

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
                            <h1>Cpanel Add</h1>
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
                                <h3 class="card-title">CMS Details</h3>

                                <!-- <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div> -->
                            </div>
                            <div class="card-body">
                                <form action="" method="post">
                                    <input type="hidden" value="<?php echo $row['id']?>" name="cmsId" />
                                    <div class="form-group">
                                        <label for="inputPBNUrl">Client</label>
                                        <select id="client_id" name="client_id" class="form-control custom-select">
                                            <option disabled>Select one</option>
                                            <?php $client =$db->display('clients',"is_deleted=0");
                                            if($client->num_rows > 0){
                                              while($clientData = $client->fetch_array()) {?>
                                            <option <?php if($clientData['id']==$row['client_id']){ echo "selected";}?>
                                                value="<?php echo $clientData['id']?>"><?php echo $clientData['company_name']?>
                                            </option>'
                                            <?php }}?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPBNUrl">Url</label>
                                        <input id="url" name="url" value="<?php echo $row['url']?>"
                                            class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="inputCompanyName">Login</label>
                                        <input id="login" name="login" value="<?php echo $row['login']?>"
                                            class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="inputWebsite">Password</label>
                                        <input id="password" name="password" value="<?php echo $row['password']?>"
                                            class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="inputWebsite">Extra/Facebook/Insta</label>
                                        <textarea id="extras" name="extras"
                                            class="form-control"> <?php echo $row['extras']?></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <a href="manage-cms.php" class="btn btn-secondary">Cancel</a>
                                            <?php if($_GET['id']!=''){?>
                                            <input type="submit" value="Update CMS"
                                                class="btn btn-success float-right">
                                            <?php }else{?>
                                            <input type="submit" value="Create CMS"
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