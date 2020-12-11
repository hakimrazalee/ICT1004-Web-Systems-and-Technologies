<?php

if(!isset($_SESSION['fname'])){
header('Location: login.php');
die(); 
} else if ($_SESSION['role'] == 'Member'){
echo "<script type='text/javascript'>alert('Unauthorized Entry Detected!')</script>";
header('Location: index.php');

die();
}
?>