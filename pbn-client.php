<?php include_once('include/session.php') ?>
<?php include_once('include/functions.php') ?>
<?php
if(isset($_POST['buttonDelete'])) {
	if(isset($_POST['clientIds'])) {
		foreach ($_POST['clientIds'] as $clientIds) {
			$db->delete('clients',"id=".$clientIds); 
		}
	}
  header("location:client.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Conversions - Client Panel | Clients</title>

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
            <h1>Client</h1>
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
                <div class="col-2">
                  <a href="add-client.php" class="btn btn-block btn-primary btn-sm">Add Client</a>
                </div>
                <!-- <h3 class="card-title">Client</h3> -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form method="post">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                  <th><input type="checkbox" id="checkBoxAll" class="checkBoxAll" /></th>
                    <th>Company Name</th>
                    
                    <th>Website</th>
  

                    <th>Total Articles</th>
                    <th>Action</th>
                    <!-- <th>Status</th> -->
                    <th>Delete</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $clients =$db->display('clients');
                    if($clients->num_rows > 0){
                      while($row = $clients->fetch_array()) {?>
                  <tr>
                    <?php $countArticles =$db->display('article_infos', ' client_id='.$row["id"]); ?>
                    <td><input type="checkbox" class="chkCheckBoxId" value="<?php echo $row['id']; ?>" name="clientIds[]" /></td>
                    <td><a href="articles.php?client=<?=$row['company_name']?>"><?php echo $row['company_name'];?></a></td>
                    
                    <td><?php echo $row['website'];?></td>
                    
                    <td><a href="articles.php?client=<?=$row['company_name']?>"><?php echo $countArticles->num_rows ;?></a></td>
                    <td><a href="add-client.php?id=<?=$row['id']?>">Edit</td>
                    <!-- <td><a href="javascript:void(0);" id="<?php echo $row['id'];?>" class="btnStatusAction"><i class="fa fa-trash" title="Status"></i></a> </td> -->
                    <td><a href="javascript:void(0);" id="<?php echo $row['id'];?>" class="btnDeleteAction"><i class="fa fa-trash" title="DELETE"></i></a> </td>
                  </tr>
                  <?php }
                    }?>
                  </tbody>
                  <tfoot>
                  <tr>
                  <th><input type="checkbox" id="checkBoxAll" class="checkBoxAll" /></th>
                    <th>Company Name</th>
                    
                    <th>Website</th>

                    <th>Total Articles</th>

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
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, 
      "lengthChange": true, 
      "autoWidth": false,
      "pageLength": 100,
      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

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
						data:'&table=clients&del_id='+del_id+'&action=delete',
						success:function(result){
							tr.fadeOut(1000, function(){
								$(this).remove();
							});
						}
					});
		}
	});

  $('body').on('click','.btnStatusAction',function(){ 
				 var tr = $(this).closest('tr');
					del_id = $(this).attr('id');
					$.ajax({
						url: "<?php echo $base_url;?>/status.php",
						type: "POST",
						cache: false,
						data:'&table=clients&del_id='+del_id+'&action=status',
						success:function(result){
							tr.fadeOut(1000, function(){
								$(this).remove();
							});
						}
					});
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
