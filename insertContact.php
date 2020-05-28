<?php

include('includes/connection.php');

// Get data from Add Contact form via AJAX
$name = $_POST['name'];
$dob = $_POST['dob'];
$mobiles = implode(',',$_POST['number']);
$emails = implode(',',$_POST['emails']);

// Fetching Details from Database
$stmt = "SELECT mobiles FROM phonebook ";
$query = mysqli_query($connection, $stmt);


while($result = mysqli_fetch_array($query)){
    $existMobiles = explode(',',$result['mobiles']);
    $sameNumber = array_intersect($_POST['number'],$existMobiles);
    if(count($sameNumber) > 0){
        $existNumList = implode(',',$sameNumber);
        echo "<div class='alert alert-danger'>
                Sorry! User already exists on this/these ".$existNumList." number(s).
              </div>";
        exit();
    }else{
        $inserSTMT = "INSERT INTO phonebook(name,dob,mobiles,emails) VALUES('$name','$dob','$mobiles','$emails')";
        $runQuery = mysqli_query($connection, $inserSTMT);
        if($runQuery){
            echo "<div class='alert alert-success'>
                    Contact Added Successfully!
                  </div>";
            exit();
        }else{
            echo "<div class='alert alert-danger'>
                    Something went wrong. Please try after sometime.
                  </div>";
            exit();
        }
        
    }
}



?>