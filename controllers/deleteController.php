<?php
include '../config/db.php';


//query to delete user
//get the table from the url
$table = $_GET['table'];

if ($table=="customers") {
  $id = $_GET['id'];
  $query = "DELETE FROM customers WHERE id='$id'";
  $result = $mysqli->query($query);
  if ($result) {
    header("location: ../views/admin.php");
  }
  else {
    $_SESSION['message'] = 'Delete failed!';
        header("location: ../views/error.php");  
  }
}
else if ($table=="products") {
  $id = $_GET['id'];
  $query = "DELETE FROM products WHERE id='$id'";
  $result = $mysqli->query($query);
  if ($result) {
    header("location: ../views/admin.php");
  }
  else {
    $_SESSION['message'] = 'Delete failed!';
        header("location: ../views/error.php");  
  }
}



