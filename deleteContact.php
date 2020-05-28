<?php
    include('includes/connection.php');
    
    $id = $_GET['id'];
    
    $stmt = " DELETE FROM phonebook WHERE id = $id ";
    
    mysqli_query($connection, $stmt);
    
    header('location:index.php');
?>