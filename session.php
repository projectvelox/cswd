<?php
   session_start();
   
   $user_check = $_SESSION['login_user'];
   $con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");
   $ses_sql = mysqli_query($con,"select * from cswd_account_listing where username = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $row['username'];
   $login_fullname = $row['firstname'] . " " . $row['lastname'];
   $login_access_level = $row['account_name'];
   
   if(!isset($_SESSION['login_user'])){
      header("location:index.php");
   }
?>