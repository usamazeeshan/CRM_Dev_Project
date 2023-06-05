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
              $login = $sheetData[$i][1];
              $password = $sheetData[$i][2];
              $extras = $sheetData[$i][3];
              $checkBacklinks =$db->display('cpanels',' backlink="'.$url.'"');
              if($checkBacklinks->num_rows == 0){
            $data = array(
              'url' => $url,
              'login' => $url,
              'password' => $url,
              'extras' => $url,
              'created' => date ('Y-m-d H:i:s')
            );
            $masterBacklinks = $db->insert('cpanels',$data);
          }
      }
    }
header("location:manage-cpanels.php");
}
if(isset($_POST['buttonDelete'])) {
	if(isset($_POST['backlinkIds'])) {
		foreach ($_POST['backlinkIds'] as $backlinkIds) {
			$db->delete('cpanels',"id=".$backlinkIds);
		}
	}
  header("location:manage-cpanels.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Conversions - Client Panel | Manage Cpanels</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
                            <h1>Manage Cpanel</h1>
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
                                        <a style="float:left" href="add-cpanel-info.php"
                                            class="btn btn-primary btn-sm">Add Cpanel</a>
                                        <a style="margin-left:5px;float:left" href="csv.php?cpanels=cpanels"
                                            class="btn btn-primary btn-sm">Sample File</a>
                                        <button style="margin-left:5px;float:left" type="button"
                                            class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#modal-default">
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
                                                    <th><input type="checkbox" id="checkBoxAll" class="checkBoxAll" />
                                                    </th>

                                                    <th>Client</th>
                                                    <th>Cpanel Url</th>
                                                    <th>Login</th>
                                                    <th>Password</th>

                                                    <th>Action</th>
                                                    <!-- <th>Status</th> -->
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $backlinks =$db->display('cpanels','is_deleted=0');
                    if($backlinks->num_rows > 0){
                      while($row = $backlinks->fetch_array()) {
                         $client =$db->display('clients', 'id='.$row["client_id"]);
                         $clientData = $client->fetch_array(); ?>
                                                <tr>
                                                    <td><input type="checkbox" class="chkCheckBoxId"
                                                            value="<?php echo $row['id']; ?>" name="backlinkIds[]" />
                                                    </td>
                                                    <td><?=$clientData['company_name']?></td>

                                                    <td><a href="<?php
                    $file = $row['url'];
                    $file_headers = @get_headers($file);
                    if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
                        echo 'http://www.'.$row['url'];
                    }
                    else {
                        echo $row['url'];
                    }

                    ?>" target="_blank"><?php echo $row['url']?></a></td>
                                                    <td><?=$row['login']?></td>
                                                    <td><?=$row['password']?></td>

                                                    <td><a href="add-cpanel-info.php?id=<?=$row['id']?>">Edit</a></td>
                                                    <!-- <td>status</td> -->
                                                    <td>
                                                        <a href="javascript:void(0);" id="<?php echo $row['id'];?>"
                                                            class="btnDeleteAction"><i class="fa fa-trash"
                                                                title="DELETE"></i></a>
                                                        <a href="javascript:void(0);" id="<?php echo $row['id'];?>"
                                                            class="view" data-toggle="modal"
                                                            data-target="#view-default<?php echo $row['id'];?>"><i class="fa fa-eye"
                                                                title="view"></i></a>
                                                                <div class="modal fade" id="view-default<?php echo $row['id'];?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">View Cpanel Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="card-body">
                            <form action="" method="post">
                                <input type="hidden" value="<?php echo $row['id']?>" name="cpanelId" />
                                <div class="form-group">
                                    <label for="inputPBNUrl">Client</label>
                                    <select disabled id="client_id" name="client_id" class="form-control custom-select">
                                        <option disabled>Select one</option>
                                        <?php $client =$db->display('clients',"is_deleted=0");
                                            if($client->num_rows > 0){
                                              while($clientData = $client->fetch_array()) {?>
                                        <option <?php if($clientData['id']==$row['client_id']){ echo "selected";}?>
                                            value="<?php echo $clientData['id']?>">
                                            <?php echo $clientData['company_name']?>
                                        </option>'
                                        <?php }}?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputPBNUrl">Url</label>
                                    <input readonly id="url" name="url" value="<?php echo $row['url']?>" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label for="inputCompanyName">Login</label>
                                    <input readonly id="login" name="login" value="<?php echo $row['login']?>"
                                        class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label for="inputWebsite">Password</label>
                                    <input readonly id="password" name="password" value="<?php echo $row['password']?>"
                                        class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label for="inputWebsite">Extra/Facebook/Insta</label>
                                    <textarea readonly id="extras" name="extras"
                                        class="form-control"> <?php echo $row['extras']?></textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                                                    </td>

                                                </tr>
                                                <?php }
                    }?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th><input type="checkbox" id="checkBoxAll" class="checkBoxAll" />
                                                    </th>

                                                    <th>Client</th>
                                                    <th>Cpanel Url</th>
                                                    <th>Login</th>
                                                    <th>Password</th>

                                                    <th>Action</th>
                                                    <!-- <th>Status</th> -->
                                                    <th>Delete</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <input type="submit" class="btn btn-danger btn-sm" name="buttonDelete"
                                            value="Delete All" onclick="return confirm('Are you sure?')" />
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
        $(function() {
            bsCustomFileInput.init();
        });
        </script>
        <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
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
        $('body').on('click', '.btnDeleteAction', function() {
            var tr = $(this).closest('tr');
            del_id = $(this).attr('id');
            if (confirm("Want to delete this?")) {
                $.ajax({
                    url: "<?php echo $base_url;?>/delete.php",
                    type: "POST",
                    cache: false,
                    data: '&table=cpanels&del_id=' + del_id + '&action=delete',
                    success: function(result) {
                        tr.fadeOut(1000, function() {
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