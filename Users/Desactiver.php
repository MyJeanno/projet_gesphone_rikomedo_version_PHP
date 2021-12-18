<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once('../classes/user.php');
$user = new user();

if(isset($_GET['id'])){
   $id = $_GET['id'];
   $user->desactiver($id);
   header('location:ListerUser.php');
}
 


?>