<?php 
    session_start();
    if (!isset($_SESSION["signed_in"])) {
        $_SESSION["signed_in"] = false;
    }

    $current_query = $_SERVER['QUERY_STRING'];
    
    if(!isset($_SESSION['query_history'])) {
    $_SESSION['query_history'] = [];
    array_push($_SESSION['query_history'], $current_query);
    } else {
    array_push($_SESSION['query_history'], $current_query);
    if(count($_SESSION['query_history']) > 5) {
        array_shift($_SESSION['query_history']);
    }
    }

    include "db.php";
?>