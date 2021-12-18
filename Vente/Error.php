<?php 
$stock=$_GET['qte'];

 ?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" type="text/css" href="../css/style2.css">
</head>
<body>
	  <h1>Error page : Mise en garde</h1>
      <p class="couleur">Attention!!!! La quantité saisie est supérieure à la quantité disponible. Le stock disponible pour ce produit est : <strong><em style="color: black;"><?php echo $stock;?></em></strong></p>

</body>
</html>