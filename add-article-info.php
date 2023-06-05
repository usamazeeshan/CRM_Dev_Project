<?php include_once('include/session.php') ?>
<?php include_once('include/functions.php') ?>
<?php
if(!empty($_POST)){
  if($_POST['articleInfoId']=="")
  {
    $checkArticleInfos =$db->display('article_infos',' url="'.$_POST['url'].'" and pbn_id='.$_POST['pbn_id']);
    if($checkArticleInfos->num_rows == 0){
    $data = array(
          'pbn_id'  =>  $_POST['pbn_id'],
          'client_id'  =>  $_POST['client_id'],
          'url' => $_POST['url'],
          'created' => date ('Y-m-d H:i:s')
        );
        $backlinks = $db->insert('article_infos',$data);
      }
        header("location:article-infos.php");
  }
  else
  {
    $articleInfoId=$_POST['articleInfoId'];
    $checkArticleInfos =$db->display('article_infos',' url="'.$_POST['url'].'" and pbn_id='.$_POST['pbn_id']);
    if($checkArticleInfos->num_rows > 0){
      $data = array(
        'pbn_id'  =>  $_POST['pbn_id'],
        'client_id'  =>  $_POST['client_id'],
        'url' => $_POST['url'],
        'created' => date ('Y-m-d H:i:s')
      );
        $db->update('article_infos',$data,'id='.$articleInfoId);
      }else{
        $errorMsg = 'can update duplicate record';
      }
        header("location:article-infos.php");
  }
}
if($_GET['id']!=''){
  $ArticleInfosQuery=$db->display('article_infos','id='.$_GET['id']);
  $row=$ArticleInfosQuery->fetch_array();
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
            <h1>Article Add</h1>
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
              <h3 class="card-title">Article Details</h3>

              <!-- <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div> -->
            </div>
            <div class="card-body">
            <form action="" method="post">
            <input type="hidden" value="<?php echo $row['id']?>" name="articleInfoId" />
              <div class="form-group">
                <label for="inputPBNUrl">Pbn Url</label>
                <select id="pbn_id" name="pbn_id" class="form-control custom-select">

                  <?php $pbns =$db->display('pbns');
                    if($pbns->num_rows > 0){
                      while($pbnsData = $pbns->fetch_array()) {?>
                      <option <?php if($pbnsData['id']==$row['pbn_id'])?> value="<?php echo $pbnsData['id']?>"><?php echo $pbnsData['pbn_url']?></option>'
                      <?php }}?>
                </select>
              </div>
              <div class="form-group">
                <label for="inputCompanyName">Company Name</label>
                <select id="inputStatus" name="client_id" class="form-control custom-select">

                  <?php $clients =$db->display('clients');
                    if($clients->num_rows > 0){
                      while($clientData = $clients->fetch_array()) {?>
                      <option <?php if($clientData['id']==$row["client_id"]){?> selected <?php }?> value="<?php echo $clientData['id']?>"><?php echo $clientData['website']?></option>
                      <?php }}?>
                </select>
              </div>
              <div class="form-group">
                <label for="inputWebsite">Article Url</label>
                <input id="url" name="url" value="<?php echo $row['url']?>" class="form-control" />
              </div>
              <div class="row">
              <div class="col-3">
                <a href="article-infos.php" class="btn btn-secondary">Cancel</a>
                <?php if($_GET['id']!=''){?>
                <input type="submit" value="Update Article Info" class="btn btn-success float-right">
                <?php }else{?>
                <input type="submit" value="Create Article Info" class="btn btn-success float-right">
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

<script src="dist/js/jquery.multiselect.js"></script>
    <link rel="stylesheet" href="dist/css/jquery.multiselect.css">

    <script>
    jQuery('#pbn_id').multiselect({
        columns: 1,
        search: true,
        selectAll: true,
        placeholder: 'Select Source'
    });
    jQuery('#inputStatus').multiselect({
        columns: 1,
        search: true,
        selectAll: true,
        placeholder: 'Select Program'
    });
    </script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
