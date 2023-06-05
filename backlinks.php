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
              $username = $sheetData[$i][1];
              $password = $sheetData[$i][2];
              $checkBacklinks =$db->display('backlinks',' backlink_url="'.$url.'" and client_id='.$_POST['client_id']);
              if($checkBacklinks->num_rows == 0){
                $data = array(
                'client_id'  =>  $_POST['client_id'],
                'backlink_url' => $url,
                'username'  =>  $username,
                'password' => $password,
                'created' => date ('Y-m-d H:i:s')
              );
              $backlinks = $db->insert('backlinks',$data);
          }
      }
    }
header("location:backlinks.php");
}
if(isset($_POST['buttonDelete'])) {
	if(isset($_POST['backlinksIds'])) {
		foreach ($_POST['backlinksIds'] as $backlinksIds) {
			$db->delete('backlinks',"id=".$backlinksIds); 
		}
	}
  header("location:backlinks.php");
}
?>
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


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
              <div class="col-3">
              <a style="float:left" href="add-backlinks.php" class="btn btn-primary btn-sm">Add Backlinks</a>
              <a style="margin-left:5px;float:left" href="csv.php" class="btn btn-primary btn-sm">Sample File</a>
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
                  <th><input type="checkbox" id="checkBoxAll" class="checkBoxAll" /></th>

                    <th>Company Name</th>
                    <th>Backlink Url</th>
                    <th>UserName</th>
                    <th>Password</th>
                    <th>Action</th>
                    <!-- <th>Status</th> -->
                    <th>Delete</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php $backlinks =$db->display('backlinks');
                    if($backlinks->num_rows > 0){
                      while($row = $backlinks->fetch_array()) {?>
                  <tr>
                    <?php $client = $db->display('clients', ' id='.$row["client_id"]);
                    if($client!=""){
                      $clientData = $client->fetch_array();
                    } ?>
                    <td><input type="checkbox" class="chkCheckBoxId" value="<?php echo $row['id']; ?>" name="backlinksIds[]" /></td>
                    <td><?php echo $clientData['company_name']?></td>
                    <td><?php echo $row['backlink_url']?></td>
                    <td><?php echo $row['username']?></td>
                    <td><?php echo $row['password']?></td>
                    <td><a href="add-backlinks.php?id=<?=$row['id']?>">Edit</td>
                    <!-- <td>status</td> -->
                    <td><a href="javascript:void(0);" id="<?php echo $row['id'];?>" class="btnDeleteAction"><i class="fa fa-trash" title="DELETE"></i></a> </td>
                    
                  </tr>
                  <?php }
                    }?>
                  </tbody>
                  <tfoot>
                  <tr>
                  <th><input type="checkbox" id="checkBoxAll" class="checkBoxAll" /></th>

                  <th>Company Name</th>
                    <th>Backlink Url</th>
                    <th>UserName</th>
                    <th>Password</th>
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
                <select id="inputStatus" name="client_id" class="form-control custom-select">
                  <option selected disabled>Select one</option>
                  <?php $clients =$db->display('clients');
                    if($clients->num_rows > 0){
                      while($clientData = $clients->fetch_array()) {?>
                      <option <?php if($clientData['id']==$row['client_id'])?> value="<?php echo $clientData['id']?>"><?php echo $clientData['website']?></option>'
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
      "responsive": true, "lengthChange": false, "autoWidth": false,
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
						data:'&table=backlinks&del_id='+del_id+'&action=delete',
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
