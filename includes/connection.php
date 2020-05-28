<?php 

// Establishing Connection
global $connection;
$connection = mysqli_connect('localhost', 'root', '', 'adainfront');
if (!$connection) {
    echo 'Error in connecting database';
}

?>