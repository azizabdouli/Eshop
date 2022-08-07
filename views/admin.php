
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
  <div class="container" style="margin:40px">

    <a class="btn btn-success" href="product.php">Add a product</a><br><br>

    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
      <li><a data-toggle="tab" href="#menu1">Customers</a></li>
      <li><a data-toggle="tab" href="#menu2">Ordered Items</a></li>
      <li><a data-toggle="tab" href="#menu3">Orders</a></li>
      <li><a data-toggle="tab" href="#menu4">Products</a></li>
      <li><a data-toggle="tab" href="#menu5">Customer orders</a></li>
    </ul>
    <div class="tab-content">
      <div id="home" class="tab-pane fade in active">
        <h3>HOME</h3>
        <p>You can check the different databases from here</p>
      </div>

    <?php
    $showtables= $mysqli->query("SHOW TABLES FROM db");

    $s=1;

    while($table = $showtables->fetch_array()) { // go through each row that was returned in $result

        $result = $mysqli->query("SELECT * FROM ".$table[0]);
        $num = $result->field_count;

        echo "<div id='menu".$s."' class='tab-pane fade'>";
          $s++;
        echo "<h1>".ucwords($table[0]) . "</h1><br>";;


        echo "<table class='table table-bordered' border='1'
        style='table-layout:fixed;border: 1px solid black;'>
        <tr>";
        while ($finfo = $result->fetch_field()) {
          echo "<th style='border: 1px solid black;'>".$finfo->name."</th>";
         
        }
        //if the menu is products, show the image
        if($table[0]=="customers" || $table[0]=="products" ){
          echo "<th style='border: 1px solid black;'>Supprimer</th>";
        echo "<th style='border: 1px solid black;'>Modifier</th>";
        }



        
        
        echo "</tr>";

        while($row = $result->fetch_array())
        {
            echo "<tr>";
            $i=0;
            while ($i < $num) {
              
                
              echo "<td style='overflow: hidden;text-overflow: ellipsis;
              word-wrap: break-word;border: 1px solid black;'>" . $row[$i] . "</td>";
              ;
              $i++;
              
              
            }
            if($table[0]=="customers" ){
            //echo a delete button
            echo "<td style='border: 1px solid black;'> <a  href='../controllers/deleteController.php?table=".$table[0]."&id=".$row[0]."' class='btn btn-danger' >Delete</a></td>";
            
          
          echo "<td style='border: 1px solid black;'> <a href='edituseradmin.php?table=".$table[0]."&id=".$row[0]."' class='btn btn-primary '>Modifier</a></td>";
        } else if ($table[0]=="products"){
          //echo a delete button
          echo "<td style='border: 1px solid black;'> <a  href='../controllers/deleteController.php?table=".$table[0]."&id=".$row[0]."' class='btn btn-danger' >Delete</a></td>";
          
        
        echo "<td style='border: 1px solid black;'> <a href='editproductadmin.php?table=".$table[0]."&id=".$row[0]."' class='btn btn-primary '>Modifier</a></td>";
      }  
          echo "</tr>";
            
        }
         
        echo "</table>";    // print the table that was returned on that row.

        echo "</div>";
    }


    $count = $mysqli->query("SELECT * FROM orders ;");


      echo "<div id='menu".$s."' class='tab-pane fade'>
      <h1> Customer orders</h1><br>";

      $x = 0;
      while($x < $count->num_rows){

        $x++;
        $view = $mysqli->query(
          "SELECT orders.id, customers.first_name, orders.total_price
          FROM orders
          INNER JOIN customers
          ON orders.customer_id=customers.id
          INNER JOIN order_items
          ON orders.id = ".$x."
          order by orders.created;");

          echo "<table class='table table-bordered' border='1'
          style='table-layout:fixed;border: 1px solid black;'>
          <tr>";

          while ($finfo1 = $view->fetch_field()) {
            echo "<th style='border: 1px solid black;'>".$finfo1->name."</th>";
          }
          echo "</tr>";
          $num1 = $view->field_count;

          $table1 = $view->fetch_array();
          

              echo "<tr>";
              $i1=0;
              while ($i1 < $num1) {
                echo "<td style='overflow: hidden;text-overflow: ellipsis;
                word-wrap: break-word;border: 1px solid black;'>" . $table1[$i1] . "</td>";
                $i1++;
              }
              echo "</tr>";

          echo "</table><button type='button' class='btn btn-info'
          data-toggle='collapse' data-target='#".$x."'>Show orders</button><br><br>";

          $view1 = $mysqli->query(
            "SELECT order_id, product_id, quantity
            FROM order_items
            WHERE order_id = ".$x.";");

            echo "<div id=".$x." class='collapse'>";

            echo "<table class='table table-bordered' border='1'
            style='table-layout:fixed;border: 1px solid black;'>
            <tr>";

            while ($finfo2 = $view1->fetch_field()) {
              echo "<th style='border: 1px solid black;'>".$finfo2->name."</th>";
            }
            echo "</tr>";
            $num2 = $view1->field_count;


            while($table2 = $view1->fetch_array())
            {

                echo "<tr>";
                $i2=0;
                while ($i2 < $num2) {
                  echo "<td style='overflow: hidden;text-overflow: ellipsis;
                  word-wrap: break-word;border: 1px solid black;'>" . $table2[$i2] . "</td>";
                  $i2++;
                }
                echo "</tr>";
              }

            echo "</table></div><br><br>";

      }
       echo "</div>";

       echo "</div>";
    ?>

  </div>

</div>
</body>
</html>
