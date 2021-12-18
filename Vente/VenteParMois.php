<?php
session_start();
if(!(isset($_SESSION['niveau']))){
	header('location:../index.php');
}
require_once('../classes/vente.php');
require_once('../classes/annee.php');
$ann = new annee();
$vte = new vente();

$AnneeID = ""; $totalYear = 0;

$moisActuel = (int)date("m");
$yearActuel = (int)date("Y");

  //var_dump($yearActuel);
  //exit();

if(isset($_POST['annee'])){
    $annee=intval($_POST['annee']);

    $AnneeID = $ann->ListerAnneeId($annee);

    $Janvier = $vte->TotalPrixJanvier($AnneeID);
	$Fevrier = $vte->TotalPrixFevrier($AnneeID);
	$Mars = $vte->TotalPrixMars($AnneeID);
	$Avril = $vte->TotalPrixAvril($AnneeID);
	$Mai = $vte->TotalPrixMai($AnneeID);
	$Juin = $vte->TotalPrixJuin($AnneeID);
	$Juillet = $vte->TotalPrixJuillet($AnneeID);
	$Aout = $vte->TotalPrixAout($AnneeID);
	$Septembre = $vte->TotalPrixSeptembre($AnneeID);
	$Octobre = $vte->TotalPrixOctobre($AnneeID);
	$Novembre = $vte->TotalPrixNovembre($AnneeID);
	$Decembre = $vte->TotalPrixDecembre($AnneeID);
    /*
	$tab = array($Janvier, $Fevrier, $Mars, $Avril, $Mai, $Juin, $Juillet,
	        $Aout, $Septembre, $Octobre, $Novembre, $Decembre);
	$cpt=0;        
	foreach ($tab as $tot) {
	     if ($tot >0) {
	     	$cpt++;
	     }
	}        
    */
	$totalYear = $Janvier + $Fevrier + $Mars + $Avril + $Mai + $Juin + $Juillet
	             + $Aout + $Septembre + $Octobre + $Novembre + $Decembre;

	 if($AnneeID == 2018)
	 {
	 	$moyenne = (int)($totalYear/11);
	 }else if($AnneeID != $yearActuel)
	    {
	    	$moyenne = (int)($totalYear/12);
	    }else
	        {
	        	$moyenne = (int)($totalYear/$moisActuel);
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
<?php include('../Layout/Layout.php');?>
	
	<div class="jumbotron" style="background-color: #191970">
	  <div class="container">
	   <hr>
	    <div class="row-fluid sortable">
	   <form class="form-horizontal" method="POST" action="VenteParMois.php">	
	      <div class="span4">
	       <div class="form-group info">
			  <label class="span4"  style="color: white;">Année souhaitée</label>
			    <div class="span8">
			    <select type="text" name="annee" id="selectError1" data-rel="chosen">
				 <option></option>
				 <?php 
                    $l=$ann->ListerTouteAnnee();
		            foreach ($l as $value){?> 
					 <option value="<?php echo $value['ID_ANNEE'] ?>"><?php echo $value['LIBELLE_ANNE']?></option>
                    <?php }?>
				</select>
				</div>
		  </div>
		</div>
		 <div class="span2">
          <div class="form-group">
            <button class="btn btn-info" name="affichage">Afficher <i class="icon-search icon-white"></i></button>
          </div> 
        </div>
        <div class="span6">
        	<h1 style="color: white;">CA total <?php echo $AnneeID ?> : <?php echo strrev(wordwrap(strrev((int)$totalYear), 3, ' ', true));?> </h1>
        </div>
	 </form>
	   </div>	
      <hr>
	  </div>
    </div>

	 <div class="row-fluid sortable">
	 	<div class="span2"></div>
		<div class="box span8">
			<div class="box-header" style="background-color: #778899;" data-original-title>
				<h2 style="color: white;"><i class="halflings-icon edit"></i><span class="break"></span>Statatistique des ventes par mois</h2>
				<div class="box-icon">
					<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
					<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
				</div>
			</div>
			<div class="box-content">
				<div id="stat-container-batton" style="width:100%; height:400px;"></div>
			</div>
			</div>
			<div class="span2"></div>
		</div>

		<script src="../js/jquery-1.9.1.min.js"></script>

	    <script type='text/javascript' src="../highcharts/js/jquery.min.js"></script>
	    <script type="text/javascript" src="../highcharts/js/highcharts.js" ></script>
	    <script type="text/javascript" src="../highcharts/js/themes/grid.js" ></script>
	    <script type="text/javascript" src="../highcharts/js/modules/exporting.js" ></script>

	    <script type="text/javascript">
                $(function () {
                    $('#stat-container-batton').highcharts({
                        chart: {
                            type: 'column',
                            margin: [ 50, 50, 100, 80]
                        },
                        title: {
                            text: 'Total CA des ventes selon les mois: <?php echo strrev(wordwrap(strrev((int)$totalYear), 3, ' ', true));?> F CFA'
                        },
                        xAxis: {
                            categories: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet',
                                         'Août','Septembre','Octobre','Novembre','Décembre'],
                            labels: {
                                rotation: -45,
                                align: 'right',
                                style: {
                                    fontSize: '13px',
                                    fontFamily: 'Verdana, sans-serif'
                                }
                            }
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Prix total en FCFA'
                            }
                        },
                        legend: {
                            enabled: true
                        },
                        tooltip: {
                            formatter: function() {
                                return 'La vente total de '+ this.x + ' est : '+'<b>'+ Highcharts.numberFormat(this.y, 0)+'</b>';   
                            }
                        },
                        series: [{
                            name: 'Moyenne de vente mensuelle : <?php echo strrev(wordwrap(strrev((int)$moyenne), 3, ' ', true));?> F CFA',
                            data: [<?php echo $Janvier;?>,<?php echo $Fevrier;?>,<?php echo $Mars;?>,
                                  <?php echo $Avril;?>,<?php echo $Mai;?>,<?php echo $Juin;?>,
                                  <?php echo $Juillet;?>,<?php echo $Aout;?>,<?php echo $Septembre;?>,
                                  <?php echo $Octobre;?>,<?php echo $Novembre;?>,<?php echo $Decembre;?>
                                  ],
                            dataLabels: {
                                enabled: true,
                                rotation: -90,
                                color: '#FFFFFF',
                                align: 'right',
                                x: 4,
                                y: 10,
                                style: {
                                fontSize: '13px',
                                fontFamily: 'Verdana, sans-serif'
                                }
                            }
                        }]
                    });
                });

        </script>
	

		<p>
		  <span style="text-align:left;float:left">&copy; Ora-Tech technologie<a href="#"> Copyright 2017. Tous droits réservés.</a></span>	
		</p>

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