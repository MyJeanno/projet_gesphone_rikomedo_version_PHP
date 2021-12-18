<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once('../classes/client.php');
$cli = new client();

if(isset($_GET['id'])){
   $id = $_GET['id'];
   $cli->activer($id);
   header('location:ListeClient.php');
}
 


?>