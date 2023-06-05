<?php

include_once('include/session.php');
include_once('include/functions.php');
if($_POST['action']=='status')
{
$db->delete($_POST['table'],"id=".$_POST['del_id']); 
}
?>
