<?php

// include database configuration file
include '../config/dbConfig.php';

if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
    if($_REQUEST['action'] == 'addToProducts'){


        $filename = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"];
    $folder = "../images/" . $filename;
        extract($_POST);
     
        $query = $db->query("INSERT INTO `products` (`name`, `image`, `description`, `price`, `created`, `modified`) VALUES
        ('".$name."', '".$filename."', '".$description."',".$price.", '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."');");

move_uploaded_file($tempname, $folder);

        header("Location: ../views/admin.php");
    }
    }else{
        header("Location: ../views/home.php");
    }


    