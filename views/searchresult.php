<?php
// include database configuration file
include '../config/dbConfig.php';
include 'Cart.php';
$cart = new Cart;
//echo $cart->total_items();
// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your profile!";
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
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome <?= $first_name.' '.$last_name?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <style>
    .container{padding: 0px;}
    body{ background-color: #EEEEEE}
    .glyphicon .badge .navbar{font-size: 17px;}
    .navbar{font-size: 17px;}
    .badge{font-size: 17px;}
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
        <li class="active"><a href="home.php">Home</a></li>
        <li><a href="#">Page</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> <?= $first_name?></a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        <li><a href="viewCart.php" title="View Cart">
          <span class="glyphicon glyphicon-shopping-cart"></span> Cart:
          <span class="badge"><?php echo $cart->total_items();?></span>
        </a></li>
      </ul>
    </div>
  </nav>

<div class="container">
    <h1>Products</h1><br>
    
    

    <div id="products" class="row list-group">
        <?php
        //get rows query
        
          echo "<form class='form-inline' action='searchresult.php?action=search' method='post'>";
          echo "<div class='form-group'>";
          echo "<input type='text' class='form-control' name='search' placeholder='Search'>";
          echo "</div>";
          echo "<button type='submit' class='btn btn-default'>Search</button>";
          echo "</form>";
          echo "<br>";
          
          echo "<form class='form-inline' action='sortproductsresult.php?action=sort' method='post'>";
          echo "<div class='form-group'>";
          echo "<select class='form-control' name='table'>";
          echo "<option value='name'>Name</option>";
          echo "<option value='price'>Price</option>";
          echo "</select>";
          echo "</div>";
          echo "<div class='form-group'>";
          echo "<select class='form-control' name='sort'>";
          echo "<option value='ASC'>Ascending</option>";
          echo "<option value='DESC'>Descending</option>";
          echo "</select>";
          echo "</div>";
          echo "<button type='submit' class='btn btn-default'>Sort</button>";
          echo "</form>";
          echo "<br>";

          if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
            if($_REQUEST['action'] == 'search'){
                $searchTerm = $_POST['search'];
        
        $query = $db->query("SELECT * FROM products WHERE name LIKE '%".$searchTerm."%' OR description LIKE '%".$searchTerm."%' OR id LIKE '%".$searchTerm."%'");
        if($query->num_rows > 0){
            while($row = $query->fetch_assoc()){
        
         if ($row['status'] == '1'){
         ?>
        <div class="item col-lg-4 ">
            <div class="thumbnail">
            <img src="../images/<?php echo $row['image']; ?>">
                <div class="caption">
                    <h4 class="list-group-item-heading"><?php echo $row["name"]; ?></h4>
                    <p class="list-group-item-text" style="padding-bottom:10px"><?php echo $row["description"]; ?></p>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="lead"><?php echo '$'.$row["price"].' USD'; ?></p>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-success" href="cartAction.php?action=addToCart&id=<?php echo $row["id"]; ?>">Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php }} }}}else{ ?>
        <p>Product(s) not found.....</p>
        <?php } ?>
    </div>
</div>
</body>
</html>
