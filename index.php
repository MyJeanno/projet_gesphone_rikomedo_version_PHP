<?php 
session_start(); 
require_once ('connexion/access.php');
require_once('classes/session.php');
$sess = new session();
$acc = new access();
$message="";
if(isset($_POST['send'])){
  $name=$_POST['username'];
  $pass=$_POST['password'];
  $passCripter=md5($pass);
  $verif=$acc->connection();
  $show=$verif->prepare("SELECT * FROM user
                           WHERE USER_NAME='".$name."'
                           AND PASSWORD='".$passCripter."'
                           AND PERMISSION ='OUI' ");
      $show->execute();
      $res=$show->fetch();
      $rows=$show->rowCount();
      
    if($rows==1){
      $_SESSION['id']=$res['ID_USER'];
      $_SESSION['login']=$name;
      $_SESSION['niveau']=$res['TYPE'];
      $sess->Ajouter($_SESSION['id'],date("Y-m-d H:i"));
      header('location:Layout/Accueil.php');
    }else $message="Nom d'utilisateur ou mot de passe incorrect";
  }
?>



<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="assets/bootstrap.css" rel="stylesheet">
	<link href="assets/style.css" rel="stylesheet">
</head>
<body id="corps">

<div class="row" id="long">
  <div class="col-md-5"></div>
  <div class="col-md-3">
    <img src="images/log.JPG" width="120" height="120" class="img-circle">
  </div>
  <div class="col-md-4"></div>
 </div>
<form action="index.php" method="POST">
 <div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-4">	
  <div class="form-group">
  	<hr>
    <label style="color: white;">Nom d'utilisateur</label>
    <input type="text" name="username" required="true" class="form-control" placeholder="Entrer votre nom d'utilisateur">
  </div>
  <div class="form-group">
    <label style="color: white;">Mot de passe</label>
    <input type="password" name="password" required="true" class="form-control" placeholder="Entrer votre mot de passe">
  </div>
  <div class="form-group">
    <button type="submit" name="send" class="btn btn-primary btn-lg btn-block">Connexion</button>
    <hr> 
  </div>
  <div class="form-group">
    <label style="color: red;"><?php echo $message;?></label>
  </div>
  </div>
  <div class="col-md-4"></div>
 </div>
</form>

</body>
</html>