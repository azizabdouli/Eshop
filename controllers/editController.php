<?php

// include database configuration file
include '../config/dbConfig.php';

//edit user

if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
    if($_REQUEST['action'] == 'editUser'){
        //get user details from post request
        extract($_POST);

        $query = $db->query("UPDATE `customers` SET `first_name` = '".$first_name."', `email` = '".$email."', `last_name` = '".$last_name."', `address` = '".$address."', `phone` = '".$phone."' , `active` = '".$active."'  WHERE `customers`.`id` = ".$id);
        header("Location: ../views/admin.php");
    } else if ($_REQUEST['action'] == 'editProduct'){
    
        extract($_POST);
    
        $query = $db->query("UPDATE `products` SET `name` = '".$name."', `description` = '".$description."', `price` = '".$price."', `status` = '".$status."' WHERE `products`.`id` = ".$id);
        header("Location: ../views/admin.php");
    }
}else{
    $_SESSION['message'] = 'Edit failed!';
        header("location: ../views/error.php"); 
}




