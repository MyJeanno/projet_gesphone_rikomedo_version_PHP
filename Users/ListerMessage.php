
<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once ('../connexion/access.php');
require_once('../classes/message.php');
$mess = new message();

if(isset($_GET['sender'])){
	$envoyeur = $_GET['sender'];
	$mess->updateMessage($envoyeur, $_SESSION['id']);
}

if(isset($_POST['send'])){
	$receiver = $_POST['receive'];
	$sender = $_SESSION['id'];
	$message = $_POST['message'];
	$dEnvoi = $mess->nowDate();

	$mess->setIdUser($sender);
    $mess->setDestinataire($receiver);
	$mess->setContenu($message);
    $mess->setDateEnvoi($dEnvoi);
    $mess->setEtatMessage("Non lu");
    $mess->Ajouter();
    header('location:ListerMessage.php?sender='.$receiver);
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
	 <?php include('../Layout/Layout.php');?><br>
	<div class="row-fluid sortable">
		<div class="span1"></div>
		<div class="box black span10" onTablet="span10" onDesktop="span10">
			<div class="box-header">
				<h2><i class="halflings-icon white comment"></i><span class="break"></span>Discussion instantanée</h2>
				<div class="box-icon">
					<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
				</div>
			</div>
			<div class="box-content">
				<ul class="chat metro blue">
					<?php 
					$l = $mess->ListerTout($_SESSION['id'],$envoyeur);
					foreach ($l as $v){ ?>
					<li <?php if($_SESSION['id']==$v['ID_USER']){ ?>class="left" <?php }else{ ?> class="right" <?php } ?>>
						<img class="avatar" alt="<?php echo $v['PRENOM_USER'];?>" src="<?php echo $v['url'] ?>">
						<span class="message"><span class="arrow"></span>
							<span class="from"><?php echo $v['NOM_USER']." ".$v['PRENOM_USER'] ; ?></span>
							<span class="time"><?php echo $v['DATE_ENVOI']; ?></span>
							<span class="text">
								<?php echo $v['CONTENU']; ?>
							</span>
						</span>	                                  
					</li>
					<?php } ?>							
				</ul>
				<form method="POST">
					<div class="chat-form black">
						<textarea name="message"></textarea>
						<input type="hidden" name="receive" value="<?php echo $envoyeur ?>">
						<button type="submit" name="send" class="btn btn-primary">Send message</button>
					</div>	
				</form>
			</div>
		</div><!--/span-->
		<div class="span1"></div>
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