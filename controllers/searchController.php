<?php

// include database configuration file
include '../config/dbConfig.php';

//search for users with action
if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
    if($_REQUEST['action'] == 'search'){
        // get search term
        $searchTerm = $_POST['search'];
        // search for users by first name or last name or email or phone number
        $query = $db->query("SELECT * FROM customers WHERE first_name LIKE '%".$searchTerm."%' OR last_name LIKE '%".$searchTerm."%' OR email LIKE '%".$searchTerm."%' OR phone LIKE '%".$searchTerm."%'");
        //redirect to the results page with the results if found else redirect to the search page with no results found
        if($query->num_rows > 0){
            header('Location: ../views/searchresults.php?query='.$query.'');
        }else{
            header('Location: ../views/searchresults.php?query=no_results');
        }
        
    }
}

        