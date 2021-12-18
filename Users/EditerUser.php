<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once('../classes/user.php');
$user = new user();

$nom="";$pass="";$type="";$code="";

if(isset($_GET['id'])){
   $id = $_GET['id'];
   $row = $user->getOne($id);
   $code=$row['ID_USER'];
   $nom=$row['USER_NAME'];
   $pass=$row['PASSWORD'];
   $type=$row['TYPE'];	
}

if(isset($_POST['send'])){
	$code = $_POST['code'];
	$nom = $_POST['nom'];
	$pass = $_POST['pass'];
	$passcript = md5($pass);
	$type = $_POST['type'];

	$taille_fichier = $_FILES['fichier']['size'];
	//var_dump($taille_fichier);
	//exit();
	$nom_fichier = $_FILES['fichier']['name'];
	$nom_tmp_fichier = $_FILES['fichier']['tmp_name'];
	$destination_fichier = '../Fichier/'.$nom_fichier;
	$extension = strchr($nom_fichier,".");
	$autorise = array('.JPEG','.jpeg','.JPG','.jpg','.PNG','.png','.gif');

	$user->setIdUser($code);
	$user->setName($nom);
	$user->setPass($passcript);
	$user->setType($type);
	$user->setFichier($nom_fichier);
	$user->setUrl($destination_fichier);
	if(in_array($extension, $autorise)){
		if(move_uploaded_file($nom_tmp_fichier, $destination_fichier)){
			$user->updateUser();
			echo "<script type='text/javascript'>alert('Fichier envoyé'); location.href = 'ListerUser.php'</script>";
		}else{
			echo "<script type='text/javascript'>alert('Une erreur est survenue'); location.href = 'EditerUser.php'</script>";
		}
		
	}else{
		echo "<script type='text/javascript'>alert('Seules les photos sont autorisées' ); location.href = 'EditerUser.php'</script>";
	}
	header('location:ListerUser.php');

}
?>

<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>RIKOMEDO</title>
	<meta name="description" content="Bootstrap Metro Dashboard">
	<meta name="author" content="Dennis Ji">
	<meta name="keyword" content="Metro, Metro UI, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link id="bootstrap-style" href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
	<link id="base-style" href="../css/style.css" rel="stylesheet">
	<link id="base-style-responsive" href="../css/style-responsive.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>	
	<link rel="shortcut icon" href="../img/favicon.ico">
<html>
</head>

<body> 
<?php include('../Layout/Layout.php');?>
	<!-- start: Header -->
	<div class="jumbotron" style="background-color: #191970"> 	
	  <div class="container">
	   <hr>
	    <div class="row-fluid">
		<div class="span4"></div>
		<div class="span8">
			<h1 style="color: white;">Editer un utilisateur</h1>
		</div>
	   </div>	
      <hr>
	  </div>
    </div>

	 <div class="row-fluid sortable">
	 	<div class="span2"></div>
		<div class="box span8">
			<div class="box-header" style="background-color: #778899;" data-original-title>
				<h2><i class="halflings-icon edit"></i><span class="break"></span>Formulaire users</h2>
				<div class="box-icon">
					<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
					<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
				</div>
			</div>
			<div class="box-content">
				<form class="form-horizontal" method="POST" enctype="multipart/form-data" action="EditerUser.php" style="background-color: #B0E0E6">
						  <fieldset>
						  <div class="control-group info">
							  <div class="controls">
								<input type="hidden" class="span6" name="code" value=" <?php echo $code;?>">
							  </div>
							</div>
							<div class="control-group info">
							  <label class="control-label">User name</label>
							  <div class="controls">
								<input type="text" class="span6" name="nom" value="<?php echo $nom;?> ">
							  </div>
							</div>
							<div class="control-group info">
							  <label class="control-label">Password</label>
							  <div class="controls">
								<input type="text" class="span6" name="pass" value="<?php echo $pass;?> ">
							  </div>
							</div>
							<div class="control-group info">
							  <label class="control-label">Type</label>
							  <div class="controls">
								<select id="selectError" <?php if($_SESSION['niveau']!="Admin"){ ?> disabled ="true" <?php } ?> name="type" value=" <?php echo $type;?>">
								<?php 
						          if($type!=""){
						           switch($type){
							       case "User":{?>
								   <option></option>
								   <option selected>User</option> 
								   <option>Admin</option>
								   <option>Inter</option>
								<?php break;}

								case "Admin":{?>
								   <option></option>
								   <option>User</option> 
								   <option selected>Admin</option>
								   <option>Inter</option>
								<?php break;}

								  default:{?>
								   <option></option>
						           <option >User</option> 
					               <option>Admin</option>
					               <option selected>Inter</option>
								<?php
								}
							}
								}else{?>
									<option></option>
						           <option >User</option> 
						           <option>Admin</option>
						           <option>Inter</option>
									 <?php
									 }
							     ?>
									</select>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="fileInput">Choisir un fichier</label>
							  <div class="controls">
								<input type="file" required class="input-file uniform_on" name="fichier" id="fileInput" >
								<input type="hidden" name="TAILLE_MAX" value="5120000">
							  </div>
						    </div> 						         
							<div class="form-actions">
							  <button type="submit" name="send" class="btn btn-primary">Editer</button>
							  <a class="btn btn-info" href="ListerUser.php">Retour à la liste</a>
							</div>
						  </fieldset>
						</form>
					</div>
				</div>
				<div class="span2"></div>
			</div>

		<p>
		<span style="text-align:left;float:left">&copy; Ora-Tech technologie<a href="#"> Copyright 2017. Tous droits réservés.</a></span>	
		</p>

		<script src="../js/jquery-1.9.1.min.js"></script>

	    <script src="../js/jquery-migrate-1.0.0.min.js"></script>
	
		<script src="../js/jquery-ui-1.10.0.custom.min.js"></script>
	
		<script src="../js/jquery.ui.touch-punch.js"></script>
	
		<script src="../js/modernizr.js"></script>
	
		<script src="../js/bootstrap.min.js"></script>
	
		<script src="../js/jquery.cookie.js"></script>
	
		<script src='../js/fullcalendar.min.js'></script>
	
		<script src='../js/jquery.dataTables.min.js'></script>

		<script src="../js/excanvas.js"></script>

		<script src="../js/jquery.flot.js"></script>

		<script src="../js/jquery.flot.pie.js"></script>

		<script src="../js/jquery.flot.stack.js"></script>

		<script src="js/jquery.flot.resize.min.js"></script>
	
		<script src="../js/jquery.chosen.min.js"></script>
	
		<script src="../js/jquery.uniform.min.js"></script>
		
		<script src="../js/jquery.cleditor.min.js"></script>
	
		<script src="../js/jquery.noty.js"></script>
	
		<script src="../js/jquery.elfinder.min.js"></script>
	
		<script src="../js/jquery.raty.min.js"></script>
	
		<script src="../js/jquery.iphone.toggle.js"></script>
	
		<script src="../js/jquery.uploadify-3.1.min.js"></script>
	
		<script src="../js/jquery.gritter.min.js"></script>
	
		<script src="../js/jquery.imagesloaded.js"></script>
	
		<script src="../js/jquery.masonry.min.js"></script>
	
		<script src="../js/jquery.knob.modified.js"></script>
	
		<script src="../js/jquery.sparkline.min.js"></script>
	
		<script src="../js/counter.js"></script>
	
		<script src="../js/retina.js"></script>

		<script src="../js/custom.js"></script>
	<!-- end: JavaScript-->
</body>
</html>