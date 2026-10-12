<?php
$host = "sql300.infinityfree.com";
$username = "if0_43155899";
$password = "Feranmi1318";
$database = "if0_43155899_studentreg";

$conn = new mysqli($host,$username,$password,$database);

if($conn->connect_error){
  die("Database connection failed:");
}
?>