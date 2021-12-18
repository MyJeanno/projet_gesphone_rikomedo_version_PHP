
<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once('../classes/user.php');
$user = new user();

if (!empty($_FILES['fichier']['name'])) {
	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$username = $_POST['login'];
	$pass = $_POST['pass'];
	$passcript = md5($pass);
	$type = $_POST['type'];

	$nom_fichier = $_FILES['fichier']['name'];
	$nom_tmp_fichier = $_FILES['fichier']['tmp_name'];
	$destination_fichier = '../Fichier/'.$nom_fichier;
	$extension = strchr($nom_fichier,".");
	$autorise = array('.JPEG','.jpeg','.JPG','.jpg','.PNG','.png','.gif');
	
	$user->setNomUser($nom);
	$user->setPrenomUser($prenom);
	$user->setName($username);
	$user->setPass($passcript);
	$user->setType($type);
	$user->setPermission("OUI");
	$user->setFichier($nom_fichier);
	$user->setUrl($destination_fichier);
	if(in_array($extension, $autorise)){
		if(move_uploaded_file($nom_tmp_fichier, $destination_fichier)){
			$user->Ajouter();
			echo "<script type='text/javascript'>alert('Fichier envoyé'); location.href = 'ListerUser.php'</script>";
		}else{
			echo "<script type='text/javascript'>alert('Une erreur est survenue'); location.href = 'ListerUser.php'</script>";
		}
		
	}else{
		echo "<script type='text/javascript'>alert('Seules les photos sont autorisées' ); location.href = 'ListerUser.php'</script>";
	}
	
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
	<!-- start: Header -->
  <?php include('../Layout/Layout.php');?>
	<div class="jumbotron" style="background-color: #191970">
	  <div class="container">
	   <hr>
	    <div class="row-fluid sortable">
		<div class="span4"></div>
		<div class="span6">
			<h1 style="color: white;">Liste des utilisateurs du système</h1>
		</div>
		<div class="span2 btn-group pull-right">
          <a href="#"><button class="btn-setting btn btn-success">Ajouter un utilisateur  <i class="icon-plus icon-white"></i></button></a>
        </div>
	   </div>	
      <hr>
	  </div>
    </div>

   	<div class="row-fluid sortable">		
		<div class="box span12">
			<div class="box-header" style="background-color: #778899;" data-original-title>
				<h2><i class="halflings-icon user"></i><span class="break"></span>User</h2>
				<div class="box-icon">
					<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
				</div>
			</div>
			<div class="box-content">
			<table class="table table-striped table-bordered bootstrap-datatable datatable">
			  <thead>
				  <tr style="background-color: cadetblue;">
					  <th>ID</th>
					  <th>Nom</th>
					  <th>Prénoms</th>
					  <th>Login</th>
					  <th>Password</th>
					  <th>Niveau</th>
					  <th>Permission</th>
					  <th>photo</th>
					  <th>Actions</th>
				  </tr>
			  </thead>   
			  <tbody>
				<?php 
		          $list=$user->ListerTout();
		          foreach ($list as $value){?> 
		    	<tr>
		    	    <td><?php echo $value['ID_USER'];?></td>
		    	    <td><?php echo $value['NOM_USER'];?></td>
		    	    <td><?php echo $value['PRENOM_USER'];?></td>
		    		<td> <?php echo $value['USER_NAME'];?></td>
		    		<td> <?php echo $value['PASSWORD'];?></td>
		    		<td> <?php echo $value['TYPE'];?></td>
		    		<td> <?php echo $value['PERMISSION'];?></td>
		    		<td><img class="avatar" height="100" width="100" src="<?php echo $value['url'];?>"></td>
		    		<td> 
					 <a class="btn btn-info" href="EditerUser.php?id=<?php echo $value['ID_USER'];?>"><i class="halflings-icon white edit"></i></a>
					<a class="btn btn-success" href="Activer.php?id=<?php echo $value['ID_USER'];?>"><i class="halflings-icon white ok"></i></a>
					 <a class="btn btn-danger" href="Desactiver.php?id=<?php echo $value['ID_USER'];?>"><i class="halflings-icon white remove"></i></a>
		    		</td>
		    	</tr>
		        <?php } ?>
			  </tbody>
			  </table>            
			</div>
		</div>	
	</div>

<div class="modal hide fade" id="myModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		 <h2>Ajouter un nouvel utilisateur</h2>
	</div>
<div class="modal-body" style="background-color: #B0E0E6">
	<form class="form-horizontal" method="POST" enctype="multipart/form-data" action="ListerUser.php">
		<div class="control-group info">
			<label class="control-label">Nom</label>
			<div class="controls">
			  <input type="text" required="true" name="nom">
			</div>
		</div>
		<div class="control-group info">
			<label class="control-label">Prénoms</label>
			<div class="controls">
			  <input type="text" required="true" name="prenom">
			</div>
		</div>
		<div class="control-group info">
			<label class="control-label">Nom d'utilisateur</label>
			<div class="controls">
			  <input type="text" required="true" name="login">
			</div>
		</div>
		<div class="control-group info">
			<label class="control-label">Password</label>
			<div class="controls">
			  <input type="text" required="true" name="pass">
			</div>
		</div>
		<div class="control-group info">
		<label class="control-label">Type</label>
		<div class="controls">
		  <select id="selectError" required="true" name="type" data-rel="chosen">
			<option></option>
			<option>User</option>
			<option>Admin</option>
			<option>Inter</option>
		  </select>
		</div>
	  </div>
	  <div class="control-group">
		  <label class="control-label" for="fileInput">Choisir un fichier</label>
		  <div class="controls">
			<input class="input-file uniform_on" name="fichier" id="fileInput" type="file">
		  </div>
	  </div>
	</div>
	<div class="modal-footer">
		<input type="submit" class="btn btn-primary" value="Enregistrer">
	    <button type="button" class="btn btn-default" data-dismiss="modal" area-hidden="true">Fermer
	    </button> 
	</div>
</form>
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