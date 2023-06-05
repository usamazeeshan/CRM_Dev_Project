<?php

include_once('include/session.php');
include_once('include/functions.php');
if($_POST['action']=='delete')
{
    $data = array(
        'is_deleted'  =>  1, 
      );
$db->update($_POST['table'],$data,"id=".$_POST['del_id']); 
}
?>
