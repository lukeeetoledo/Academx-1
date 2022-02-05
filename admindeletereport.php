<?php
include 'config.php';

if(isset($_GET['token'])){
  $ID=$_GET['token'];
  $sql="DELETE FROM amx_report_tbl WHERE post_id= '$ID';";
  $result = mysqli_multi_query($conn, $sql);
  if($result){
    header("location:adminreported.php");
  }else{
      echo $conn->error;//getting the error
  }
}
else{
  header("location:adminreported.php");//redirect
}

?>