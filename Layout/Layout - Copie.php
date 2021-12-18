
 <div class="jumbotron" style="background-color: #FFFFFF;">
		 <div class="container-fluid">
		    <div class="row-fluid">
		  	<div class="span4">
		  		<img src="../images/haut5.PNG">
		  	</div>
		  	<div class="span6"></div>
		  	<div class="span2">
		  		<img height="100" width="100" src="../images/log.jpg">
		  	</div>
		  </div>
	 </div>
 </div>
 <div class="navbar" id="haut2">
	<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="../Layout/Accueil.php"><i class="icon-home"></i><span> Home</span></a>
								
				<!-- start: Header Menu -->
				<div class="nav-no-collapse header-nav">
					<ul class="nav pull-right">
						<li class="dropdown hidden-phone">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
								<span>Produit</span>
							</a>
							<ul class="dropdown-menu tasks">
								<?php if($_SESSION['niveau']=="Admin"){ ?>
								<li>
                                    <a href="../Produit/ListeProduit.php">
										<span class="header">
											<span class="title">Ajouter un produit</span>
										</span>
                                    </a>
                                </li>                                
                                <li>
                                    <a href="../Produit/StockProduit.php">
										<span class="header">
											<span class="title">Consulter stock produit</span>
										</span>
                                    </a>
                               </li>                              
                                <li>
                                    <a href="../Produit/SeuilAppro.php">
										<span class="header">
											<span class="title">Vérifier seuil d'appro en gros</span>
										</span>
                                    </a>
                               </li>
                               <?php } ?>
                               <li>
                                    <a href="../Produit/SeuilApproDetail.php">
										<span class="header">
											<span class="title">Vérifier seuil d'appro en détail</span>
										</span>
                                    </a>
                               </li>
                               <li>
                                    <a href="../Produit/RapportProduit.php">
										<span class="header">
											<span class="title">Visualiser le stock global</span>
										</span>
                                    </a>
                               </li>
                               <li>
                                    <a href="../Produit/RapportProduitDetail.php">
										<span class="header">
											<span class="title">Imprimer le stock détail</span>
										</span>
                                    </a>
                               </li>         							
							</ul>
						</li>
					    <li class="dropdown hidden-phone">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
								<span>Encaissement</span>
							</a>
							<ul class="dropdown-menu tasks">
								<li>
                                    <a href="../Encaissement/FormEncaisser.php">
										<span class="header">
											<span class="title">Encaisser une somme</span>
										</span>
                                    </a>
                                </li>
								<li>
                                    <a href="../Encaissement/ListEncaissement.php">
										<span class="header">
											<span class="title">Encaissement du jour</span>
										</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../Encaissement/EncaissePeriodique.php">
										<span class="header">
											<span class="title">Encaissement périodique</span>
										</span>
                                    </a>
                               </li>
                                <li>
                                    <a href="../Client/SoldeClient.php">
										<span class="header">
											<span class="title">Solde client</span>
										</span>
                                    </a>
                               </li>
                               <?php if($_SESSION['niveau']=="Admin"){ ?>
                               <li>
                                    <a href="../Client/ListeClient.php">
										<span class="header">
											<span class="title">Enregistrer un nouveau client</span>
										</span>
                                    </a>
                               </li>
                               <?php } ?>									
							</ul>
						</li>
						<li class="dropdown hidden-phone">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
								<span> Approvisionner</span>
							</a>
							<ul class="dropdown-menu notifications">
							  <?php if($_SESSION['niveau']=="Admin"){ ?>							
								<li>
                                    <a href="../Appro/Approvisionner.php">
										<span class="icon blue"><i class="icon-user"></i></span>
										<span class="message">Approvisionner le stock</span>
                                    </a>
                                </li>   
								<li>
                                    <a href="../Appro/ListAppro.php">
										<span class="icon red"><i class="icon-shopping-cart"></i></span>
										<span class="message">Liste des appro en gros</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../Transfert/Transferer.php">
										<span class="icon red"><i class="icon-shopping-cart"></i></span>
										<span class="message">Transfert de produits</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../Transfert/ListeTransfert.php">
										<span class="icon red"><i class="icon-shopping-cart"></i></span>
										<span class="message">Lister les mutations de stock</span>
                                    </a>
                                </li>
                                <?php } ?>
                                <li>
                                    <a href="../Appro/ListApproDetail.php">
										<span class="icon red"><i class="icon-shopping-cart"></i></span>
										<span class="message">Liste des appro en détail</span>
                                    </a>
                                </li>
								<li>
                                    <a href="../Appro/ApproPeriodique.php">
										<span class="icon green"><i class="icon-comment-alt"></i></span>
										<span class="message">Appro périodique en gros</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../Appro/ApproPeriodiqueDetail.php">
										<span class="icon green"><i class="icon-comment-alt"></i></span>
										<span class="message">Appro périodique en détail</span>
                                    </a>
                                </li>                    		
							</ul>
						</li>
						<!-- start: Notifications Dropdown -->
						<li class="dropdown hidden-phone">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
								<span>Ventes</span>
							</a>
							<ul class="dropdown-menu tasks">
								<li>
                                    <a href="../Vente/VendreProduitDetail.php">
										<span class="header">
											<span class="title">Effectuer une vente en détail</span>
										</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../Vente/FormRecu.php">
										<span class="header">
											<span class="title">Délivrer le reçu des ventes</span>
										</span>
                                    </a>
                                </li>
                                <?php if($_SESSION['niveau']=="Admin" || $_SESSION['niveau']=="Inter"){ ?>
								<li>
                                    <a href="../Vente/VendreProduit.php">
										<span class="header">
											<span class="title">Effectuer une vente en gros</span>
										</span>
                                    </a>
                                </li>
								<?php } ?>
								<?php if($_SESSION['niveau']=="Admin"){ ?>
                                <li>
                                    <a href="../Vente/ListeSommeVente.php">
										<span class="header">
											<span class="title">Lister les ventes du jour</span>
										</span>
                                    </a>
                                </li>
                               
                                <?php } ?>
                                 <li>
                                    <a href="../Vente/ListeVente.php">
										<span class="header">
											<span class="title">Détails des ventes en gros de la journée</span>
										</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../Vente/ListeVenteDetail.php">
										<span class="header">
											<span class="title">Détails des ventes en détail de la journée</span>
										</span>
                                    </a>
                               </li>
                                <li>
                                    <a href="../Vente/GlobalVision.php">
										<span class="header">
											<span class="title">Situation gobale de la jourrnée</span>
										</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../Vente/VentePeriodique.php">
										<span class="header">
											<span class="title">Ventes en gros périodique</span>
										</span>
                                    </a>
                               </li>
                               <li>
                                    <a href="../Vente/VentePeriodiqueDetail.php">
										<span class="header">
											<span class="title">Ventes en détail périodique</span>
										</span>
                                    </a>
                               </li>
                               <li>
                                    <a href="../Vente/ClassementCom.php">
										<span class="header">
											<span class="title">Classement des commerciaux</span>
										</span>
                                    </a>
                               </li>
                               <li>
                                    <a href="../Vente/ClassementGros.php">
										<span class="header">
											<span class="title">Classement des grossistes</span>
										</span>
                                    </a>
                               </li>
                               <li>
                                    <a href="../Vente/ModifierVente.php">
										<span class="header">
											<span class="title">Modifier une vente antérieure</span>
										</span>
                                    </a>
                               </li>
                                <li>
                                    <a href="../Vente/VenteParMois.php">
										<span class="header">
											<span class="title">Statistiques des ventes</span>
										</span>
                                    </a>
                               </li>								
							</ul>
						</li>
						<!-- end: Notifications Dropdown -->
						<!-- start: Message Dropdown -->
						<li class="dropdown hidden-phone">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
								<span> Actions</span>
							</a>
							<ul class="dropdown-menu messages">								                           
								<li>
                                    <a href="../Depense/ListeDepense.php">
                                        <span class="message"> Effectuer une dépense</span>  
                                    </a>
                                </li>
                                <li>
                                    <a href="../Depense/DepenseJour.php">
                                        <span class="message"> Dépenses du jour</span>  
                                    </a>
                                </li>   
                                <li>
                                    <a href="../Depense/DepensePeriodique.php">
                                        <span class="message"> Dépenses périodiques</span>  
                                    </a>
                                </li>                          							
						</ul>
					</li>
					<!-- end: Message Dropdown -->
					<!-- start: User Dropdown -->
					<li class="dropdown">
						<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="halflings-icon white user"></i> Déconnexion
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li class="dropdown-menu-title">
									<span>Account Settings</span>
						</li>
						<?php if($_SESSION['niveau']=="Admin"){ ?>
						<li><a href="../Users/ListerUser.php"><i class="halflings-icon user"></i> Profile</a></li>
						<li><a href="../Users/ListerSession.php"><i class="halflings-icon warning-sign"></i> Supervision</a></li>
						<li><a href="../Users/Administration.php"><i class="halflings-icon lock"></i> Administration</a></li>
						<li><a href="../Users/backup.php"><i class="halflings-icon lock"></i> Sauvegarder</a></li>
						<?php } ?>
						<li><a href="../Layout/LogOut.php"><i class="halflings-icon off"></i> Logout</a></li>
						</ul>
					</li>
					<!-- end: User Dropdown -->
				</ul>
			</div>
			<!-- end: Header Menu -->				
		</div>
	</div>
</div>