
<?php
/* Displays user information and some useful messages */
session_start();
include '../config/db.php';
// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ||  $_SESSION['email']!=='admin@eshop.com') {
  $_SESSION['message'] = "You must log in as an admin to view this page!";
  header("location: error.php");
}
else {
    // Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    $address = $_SESSION['address'];
    $phone = $_SESSION['phone'];
    

    

    
    
    

}?>





<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <style>
    .container{padding: 0px;}
    body{ background-color: #EEEEEE}
    .glyphicon .badge .navbar{font-size: 17px;}
    .navbar{font-size: 17px;}
    .badge{font-size: 17px;}
    th, td {padding: 15px;text-align: center;}
    table, th, td {border: 2px solid black;}
    input[type="number"]{width: 20%;}
    </style>

</head>
</head>
<body>
  <nav class="navbar navbar-inverse"  style="border-radius: 0px;">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">E-Shop</a>
      </div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">Page</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?= $first_name?></a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </a></li>
      </ul>
    </div>
  </nav>
  
  <?php
  // include database configuration file
  include '../config/dbConfig.php';
    

  if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
      if($_REQUEST['action'] == 'sort'){
          //extract($_POST);
            $sort = $_POST['sort'];
            $table = $_POST['table'];
        

            $query = "SELECT * FROM customers ORDER BY $table $sort";
          
          //display the sorted data in the table
            $result = $db->query($query);
            if($result->num_rows > 0){
                echo '<div class="container"><div class="row"><div class="col-md-12"><a href="admin.php" class="btn btn-primary btn-sm" style="margin-bottom: 10px;"><span class="glyphicon glyphicon-chevron-left"></span> Back</a></div></div></div>';
              echo '<div class="container">';
              echo '<div class="row">';
              echo '<div class="col-md-12">';
              echo '<div class="table-responsive">';
              echo '<table class="table table-striped table-bordered">';
              echo '<thead>';
              echo '<tr>';
              echo '<th>ID</th>';
              echo '<th>First Name</th>';
              echo '<th>Last Name</th>';
              echo '<th>Email</th>';
              echo '<th>Phone</th>';
              echo '<th>Address</th>';
              echo '<th>Action</th>';
              echo '</tr>';
              echo '</thead>';
              echo '<tbody>';
                while($row = $result->fetch_assoc()){
                    echo '<tr>';
                    echo '<td>'.$row['id'].'</td>';
                    echo '<td>'.$row['first_name'].'</td>';
                    echo '<td>'.$row['last_name'].'</td>';
                    echo '<td>'.$row['email'].'</td>';
                    echo '<td>'.$row['address'].'</td>';
                    echo '<td>'.$row['phone'].'</td>';
                    echo '<td><a href="edituseradmin.php?id='.$row['id'].'"><span class="glyphicon glyphicon-edit"></span></a> <a href="../controllers/deleteController.php?id='.$row['id'].'"><span class="glyphicon glyphicon-trash"></span></a></td>';
                    echo '</tr>';
                }
                echo '</table>';
            }else{
                echo '<div class="alert alert-info">No Data Found</div>';
            }


          
          
      }
  } ?>
</body>
</html>
