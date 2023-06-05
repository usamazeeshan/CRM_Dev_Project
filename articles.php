<?php
include_once('include/session.php');
include_once('include/functions.php');

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if (isset($_POST["import"]) && $_POST["import"]=='upload') {
  $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  $arr_file = explode('.', $_FILES['filename']['name']);
        $extension = end($arr_file);
        if('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $reader->load($_FILES['filename']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        if (!empty($sheetData)) {
          for ($i=1; $i<count($sheetData); $i++) {
              $url = $sheetData[$i][0];
              $checkBacklinks =$db->display('article_infos',' backlink_url="'.$url.'" and client_id='.$_POST['client_id']);
              if($checkBacklinks->num_rows == 0){
                $data = array(
                'pbn_id'  =>  $_POST['pbn_id'],
                'client_id'  =>  $_POST['client_id'],
                'url' => $url,
                'created' => date ('Y-m-d H:i:s')
              );
              $backlinks = $db->insert('backlinks',$data);
          }
      }
    }
header("location:view-backlinks.php?client_id=".$_GET["client_id"]);
}

if(isset($_POST['buttonDelete'])) {
	if(isset($_POST['backlinksIds'])) {
		foreach ($_POST['backlinksIds'] as $backlinksIds) {
			$db->delete('backlinks',"id=".$backlinksIds);
		}
	}
  header("location:view-backlinks.php?client=".$_GET["client"]);
}

?>
<?php $client = $db->display('clients', ' company_name="'.$_GET["client"].'"');
                    if($client!=""){
                      $clientData = $client->fetch_array();
                    } ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Conversions - Client Panel | Backlinks</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
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
            <h1>Client Backlinks</h1>
          </div>
          <?php include_once('include/breadcrumb.php') ?>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"> <?php echo $clientData['company_name'];?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
              <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>UserName</th>
                      <th>Seo Email</th>
                      <th>Seo Password</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><?php echo $clientData['username'];?></td>
                      <td>
                      <?php echo $clientData['seo_email'];?>
                      </td>
                      <td><?php echo $clientData['seo_password'];?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <!-- <div class="card-footer">
                Footer
              </div> -->
              <!-- /.card-footer-->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
              <div class="col-3">
              <!-- <a style="float:left" href="add-backlinks.php" class="btn btn-primary btn-sm">Add Backlinks</a> -->
              <a style="float:left" href="csv.php?backlinks=backlinks" class="btn btn-primary btn-sm">Sample File</a>
              <button style="margin-left:5px;float:left" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-default">
              Export
                </button>
            </div>
                <!-- <h3 class="card-title">DataTable with default features</h3> -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form method="post">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                  <th>
                    <input type="checkbox" id="checkBoxAll" class="checkBoxAll" /></th>

                    <th>Sr. No.</th>
                    <!-- <th>Client</th> -->
                    <!-- <th>PBN</th> -->
                    <th>Article Url</th>
                    <th>Created</th>
                    <th>Action</th>
                    <!-- <th>Status</th> -->
                    <th>Delete</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  $srNumber =1;
                    if($_GET["client"]!=''){
                      $backlinks =$db->display('article_infos',' client_id='.$clientData["id"].' and is_deleted=0');
                    }else{
                      $backlinks =$db->display('article_infos','is_deleted=0');
                    }
                    if($backlinks->num_rows > 0){
                      while($row = $backlinks->fetch_array()) {?>
                  <tr>
                    <?php
                    $pbns = $db->display('pbns', ' id='.$row["pbn_id"]);
                    if($pbns!=""){
                      $pbnsData = $pbns->fetch_array();
                    }
                    $client = $db->display('clients', ' id='.$row["client_id"]);
                    if($client!=""){
                      $clientData = $client->fetch_array();
                    } ?>
                    <td><input type="checkbox" class="chkCheckBoxId" value="<?php echo $row['id']; ?>" name="articleInfoIds[]" /></td>
                    <td><?php echo $srNumber ?></td>
                    <!-- <td><?php //echo $clientData['company_name']?></td> -->
                    <!-- <td><?php //echo $pbnsData['pbn_url']?></td> -->
                    <td><?php echo $row['url']?></td>
                    <td><?php echo $row['created']?></td>
                    <td><a href="add-article-info.php?id=<?=$row['id']?>">Edit</td>
                    <!-- <td>status</td> -->
                    <td><a href="javascript:void(0);" id="<?php echo $row['id'];?>" class="btnDeleteAction"><i class="fa fa-trash" title="DELETE"></i></a> </td>
                  </tr>
                  <?php $srNumber++;}
                    }?>
                  </tbody>
                  <tfoot>
                  <tr>
                  <th><input type="checkbox" id="checkBoxAll" class="checkBoxAll" /></th>
                  <th>Sr. No.</th>

                  <!-- <th>Client</th> -->
                  <!-- <th>PBN</th> -->
                    <th>Article Url</th>
                    <th>Created</th>

                    <th>Action</th>
                    <!-- <th>Status</th> -->
                    <th>Delete</th>
                  </tr>
                  </tfoot>
                </table>
                <input type="submit" class="btn btn-danger btn-sm" name="buttonDelete" value="Delete All" onclick="return confirm('Are you sure?')" />
              </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include_once('include/footer.php') ?>
  <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Default Modal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="import" value="upload" />
            <div class="modal-body">
              <div class="form-group">
                <label for="inputCompanyName">Company Name</label>
                <select id="languageSelect" multiple name="client_id" class="form-control custom-select">
                  <?php $clients =$db->display('clients');
                    if($clients->num_rows > 0){
                      while($clientData = $clients->fetch_array()) {?>
                      <option <?php if($clientData['id']==$_GET["client_id"]){?> selected <?php }?> value="<?php echo $clientData['id']?>"><?php echo $clientData['website']?></option>
                      <?php }}?>
                </select>
              </div>
              <div class="form-group">
                    <div class="custom-file">
                      <input type="file" name="filename" class="custom-file-input" id="customFile">
                      <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                  </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Export</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

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
    jQuery('#languageSelect').multiselect({
        columns: 1,
        search: true,
        selectAll: true,
        placeholder: 'Select Source'
    });
    jQuery('#programSelect').multiselect({
        columns: 1,
        search: true,
        selectAll: true,
        placeholder: 'Select Program'
    });
    </script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false,
      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
  $('body').on('click','.btnDeleteAction',function(){
				 var tr = $(this).closest('tr');
					del_id = $(this).attr('id');
		if(confirm("Want to delete this?"))
		{
					$.ajax({
						url: "<?php echo $base_url;?>/delete.php",
						type: "POST",
						cache: false,
						data:'&table=article_infos&del_id='+del_id+'&action=delete',
						success:function(result){
							tr.fadeOut(1000, function(){
								$(this).remove();
							});
						}
					});
		}
	});
  $(document).ready(function() {
		$('.checkBoxAll').click(function() {
			if ($(this).is(":checked"))
				$('.chkCheckBoxId').prop('checked', true);
			else
				$('.chkCheckBoxId').prop('checked', false);
		});
	});
</script>
</body>
</html>
