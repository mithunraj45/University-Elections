<?php

$conn = mysqli_connect("localhost","root","","university_election") or die("Connection failed");

if($_POST['type'] == ""){
    $sql = "SELECT * FROM degree_info";

    $query = mysqli_query($conn,$sql) or die("Query Unsuccessful.");

    $str = "";
    while($row = mysqli_fetch_assoc($query)){
      $str .= "<option value='{$row['degree_id']}'>{$row['degree_name']}</option>";
    }
}else if($_POST['type'] == "stateData"){

    $sql = "SELECT * FROM branch_info WHERE degree_id = {$_POST['id']}";

    $query = mysqli_query($conn,$sql) or die("Query Unsuccessful.");

    $str = "<option value=''>Select any branch</option>";
    $str .= "<option value='999'>All branches</option>";
    while($row = mysqli_fetch_assoc($query)){
      $str .= "<option value='{$row['branch_id']}'>{$row['branch_name']}</option>";
    }
}

echo $str;

?>