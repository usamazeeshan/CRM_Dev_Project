<?php
session_start();
require_once ('include/DataSource.php');
if(!empty($_POST["login"])) {
    if($_POST['username']!='' && $_POST['password']!=''){
        $username =  $_POST['username'];
        $password =  $_POST['password'];
        $sql = $db->display("users","email='".$username."' and password='".$password."'");
        $user = $sql->fetch_array();
        if($user) {
                if(!empty($_POST["remember"])) {
                    setcookie ("user_login",$_POST["username"],time()+ (10 * 365 * 24 * 60 * 60));
                    $_SESSION["LOG_USER"] = $user["first_name"];
                    $_SESSION["adminName"] = $user["email"];
                    $_SESSION["ID"] = $user["id"];
                    $_SESSION["ADMIN_USER"] = "Active";
                    header('Location: dashboard.php');
                } else {
                    if(isset($_COOKIE["user_login"])) {
                        setcookie ("user_login","");
                    }
                    $_SESSION["LOG_USER"] = $user["first_name"];
                    $_SESSION["adminName"] = $user["email"];
                    $_SESSION["ADMIN_USER"] = "Active";
                    $_SESSION["ID"] = $user["id"];
                    header('Location: dashboard.php');
                }
        } else {
            $message = "Invalid Login";
            header('Location: index.php?msg='.$message);
        }
    }else{
        $message = "Please enter username and password";
        header('Location: index.php?msg='.$message);
    }
    
}
?>