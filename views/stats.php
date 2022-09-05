
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
    
    
    
    //get how much each product is sold
    $sql = "SELECT product_id, SUM(quantity) AS quantity FROM order_items GROUP BY product_id";
    $result = $mysqli->query($sql);
    $quantity = array();
    $names = array();

    while($row = mysqli_fetch_assoc($result)){
        
        //fetch product names and quantity and put in quantity and names array
        $sql = "SELECT name FROM products WHERE id = ".$row['product_id'];
        $result2 = $mysqli->query($sql);
        $row2 = mysqli_fetch_assoc($result2);
        $quantity[] = $row['quantity'];
        $names[] = $row2['name'];

        
        

    }
    
    
    
 

}?>





<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script> <!-- api pdf -->
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script> <!-- api pdf -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> <!-- api stat -->
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


  
  
  
  <div class="container"><div class="row"><div class="col-md-12"><a href="admin.php" class="btn btn-primary btn-sm" style="margin-bottom: 10px;"><span class="glyphicon glyphicon-chevron-left"></span> Back</a></div></div></div>
  <div class="container"><div class="row"><div class="col-md-12"><button id="" class="btn btn-default" onclick="CreatePDFfromHTML()" type="button">Generate PDF</button></div></div></div>

<div id="pdf" class="inbox-center">
  <canvas id="myChart"1></canvas>
<script>
const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [//echo $names as strings in javascript
            <?php
            foreach($names as $name){
                echo "'".$name."',";
            }
            ?>
        ],
        datasets: [{
            label: 'Number of sold items',
            data: [//echo $quantity;
                <?php
                for($i=0;$i<count($quantity);$i++){
                    echo $quantity[$i].",";
                }
                ?>
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
<script type="text/javascript">
    document.getElementById('myChart').height = window.innerHeight;
    document.getElementById('myChart').width = window.innerWidth;
</script>
</div>


                                    

                                </div>
  
  <?php
  // include database configuration file
  include '../config/dbConfig.php';
    

   ?>
   <script type="text/javascript">
    function CreatePDFfromHTML() {
        var HTML_Width = $("#pdf").width();
        var HTML_Height = $("#pdf").height();
        var top_left_margin = 15;
        var PDF_Width = HTML_Width + (top_left_margin * 2);
        var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
        var canvas_image_width = HTML_Width;
        var canvas_image_height = HTML_Height;

        var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

        html2canvas($("#pdf")[0]).then(function(canvas) {
            var imgData = canvas.toDataURL("image/jpeg", 1.0);
            var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
            pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
            for (var i = 1; i <= totalPDFPages; i++) {
                pdf.addPage(PDF_Width, PDF_Height);
                pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height * i) + (top_left_margin * 4), canvas_image_width, canvas_image_height);
            }
            pdf.save("Stats");
        });
    }
</script>
</body>
</html>
