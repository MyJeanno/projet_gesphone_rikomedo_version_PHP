<?php 
require_once('../classes/user.php');
require_once('../classes/message.php');
$mess = new message();
$user = new user();
$totalMessage = $mess->messageNonLu($_SESSION['id']);

 ?>
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
				<i class="halflings-icon white envelope"></i>
				<?php if($totalMessage!=0){ ?>
				<span class="label label-important"> <?php echo $totalMessage ?> </span>
			  <?php } ?>
			  </a>
			  <ul class="dropdown-menu messages">
				<li class="dropdown-menu-title">
				  <span>Vous avez <?php echo $totalMessage ?> nouveaux messages</span>
				  <a href="#refresh"><i class="icon-repeat"></i></a>
				</li> 
				<li>
				  <?php 
				  $l = $mess->ListerUserMessage($_SESSION['id']);
				  foreach ($l as $v){ ?>
					<a href="../Users/ListerMessage.php?sender=<?php echo $v['ID_USER'] ?>">
					<span class="avatar"><img src="<?php echo $v['url'] ?>" alt="<?php echo $v['PRENOM_USER'];?>"></span>
					<span class="header">
					  <span class="from">
						  <?php echo $v['NOM_USER']." ".$v['PRENOM_USER'] ; ?>
						 </span>
					  <span class="time">    
						</span>
					</span>
						<span class="message">
							Nouveau message non lu
						</span>  
					</a>
				  <?php } ?>
				</li>                               
				<li>
					<a href="../Users/ChoixUser.php" class="dropdown-menu-sub-footer">View all messages</a>
				</li> 
			  </ul>
			</li>
			
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
							   <li>
									<a href="../Commande/ListeCommande.php">
					<span class="header">
					  <span class="title">créer une nouvelle commande</span>
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
					<a href="../Encaissement/EncaisserClient.php">
					<span class="header">
					  <span class="title">Encaisser une somme</span>
				   </span>
					 </a>
				</li>
				<li>
					<a href="../Encaissement/ListEncaissement.php">
					<span class="header">
					  <span class="title">Tous les encaissements du jour</span>
					</span>
							</a>
						</li>
						<li>
						<a href="../Encaissement/MesEncaissementJour.php">
						<span class="header">
						  <span class="title">Mes encaissements de la journée</span>
						</span>
							</a>
						</li>
						<li>
							<a href="../Encaissement/MesEncaissement.php">
								<span class="header">
									<span class="title">Tous mes encaissements non versés</span>
								</span>
							</a>
						</li>
						<?php if($_SESSION['niveau']=="Admin"){ ?>
						<li>
							<a href="../Encaissement/ListeSommeEncaisseEmployeJour.php">
								<span class="header">
									<span class="title">Encaissement journalier par employé</span>
								</span>
							</a>
						</li> 
						<li>
							<a href="../Encaissement/ListeSommeEncaisseEmploye.php">
								<span class="header">
									<span class="title">Encaissements non versés par employé</span>
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
							<a href="../Encaissement/ValidationVersement.php">
							  <span class="header">
								<span class="title">Validation des encaissements</span>
							  </span>
							</a>
					   </li>
						<li>
							<a href="../Encaissement/listEcartNR.php">
							  <span class="header">
								<span class="title">Liste des écarts d'encaissement</span>
							  </span>
							</a>
					   </li>
						<li>
							<a href="../Encaissement/listEcartRegle.php">
							  <span class="header">
								<span class="title">Liste des écarts reglés</span>
							  </span>
							</a>
					   </li>
					   <?php } ?>
						<li>
					<a href="../Client/SoldeClient.php">
					<span class="header">
					  <span class="title">Solde client</span>
					</span>
						  </a>
					 </li>
					 <?php if($_SESSION['niveau']=="Admin"){ ?>
					 <li>
						  <a href="../Client/ActiverClient.php">
							  <span class="header">
								  <span class="title">Activer client</span>
							  </span>
						  </a>
					 </li>
					 
					 <li>
						  <a href="../Client/ListeClient.php">
					<span class="header">
					  <span class="title">Enregistrer un nouveau client</span>
					</span>
						</a>
				   </li>
				   <li>
						<a href="../Encaissement/FormRelevePerso.php">
							<span class="header">
								<span class="title">Relevé personnel client</span>
							</span>
						</a>
				   </li>
				   <?php } ?>
				   <li>
						<a href="../Encaissement/ListerPresence.php">
							<span class="header">
								<span class="title">Liste de présence</span>
							</span>
						</a>
				   </li>
				   <?php if($_SESSION['niveau']=="Admin"){ ?>
				   <li>
						<a href="../Encaissement/PresencePeriodique.php">
							<span class="header">
								<span class="title">Présence périodique</span>
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
									<a href="../Transfert/ChoixCommandeT.php">
											<span class="icon red"><i class="icon-shopping-cart"></i></span>
											<span class="message">Transfert de produits</span>
									</a>
								</li>
								<li>
									<a href="../Appro/RecapAppro.php">
									<span class="icon red"><i class="icon-shopping-cart"></i></span>
									<span class="message">Récap des appro</span>
													</a>
								</li>
				    <?php if($_SESSION['niveau']=="Admin"){ ?>    
								<li>
									<a href="../Transfert/ListeTransfert.php">
					<span class="icon red"><i class="icon-shopping-cart"></i></span>
					<span class="message">Lister les mutations de stock</span>
				
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
					<a href="../Vente/ChoixCommandeDet.php">
					<span class="header">
					  <span class="title">Effectuer une vente en détail</span>
					</span>
					  </a>
				</li>
								<li>
									<a href="../Vente/RecuEncourClient.php">
					<span class="header">
					  <span class="title">Délivrer le reçu des ventes</span>
					</span>
									</a>
								</li>
								<?php if($_SESSION['niveau']=="Admin" || $_SESSION['niveau']=="Inter"){ ?>
				<li>
					<a href="../Vente/ChoixCommande.php">
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
						  <li>
								<a href="../Vente/RecapVenteCommande.php">
				  <span class="header">
					<span class="title">Récap des ventes par commande</span>
				  </span>
								</a>
						  </li>
						   <li>
							  <a href="../Vente/ListSommeVenteEmploye.php">
								  <span class="header">
									  <span class="title">Lister les ventes du jour par employé</span>
								  </span>
							  </a>
						  </li>
						  <li>
							  <a href="../Vente/ValidationVenteVerser.php">
								  <span class="header">
									  <span class="title">Validation des ventes non versées</span>
								  </span>
							  </a>
						  </li>
							   
						  <?php } ?>
						  <li>
							  <a href="../Vente/ListeVenteUser.php">
								  <span class="header">
									  <span class="title">Mes ventes non versées</span>
								  </span>
							  </a>
						  </li>
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
							   <?php if($_SESSION['niveau']=="Admin"){ ?>
								<li>
									<a href="../Vente/GlobalVision.php">
					<span class="header">
					  <span class="title">Situation gobale de la jourrnée</span>
					</span>
									</a>
								</li>
							  <?php } ?>
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
							  
							   <?php if($_SESSION['niveau']=="Admin"){ ?>
								 <li>
									<a href="../Vente/VentePeriodiqueModel.php">
					<span class="header">
					  <span class="title">Ventes périodiques par modèle</span>
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
									<a href="../Vente/ChoixVente.php">
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
							  
							   <?php } ?>  
					<li>
						<a href="../Vente/Rollback.php">
					<span class="header">
					  <span class="title">Annuler une vente non validée</span>
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
			  <?php if($_SESSION['niveau']=="Admin"){ ?>                                         
								<li>
									<a href="../Actionnaire/ListeActionnaire.php">
										<span class="message"> Enrégistrer un actionnaire</span>  
									</a>
								</li>
								 <li>
									<a href="../Vente/Administration.php">
									  <span class="header">
										<span class="title">Vérif modification vente</span>
									  </span>
									</a>
							   </li>
								<li>
									<a href="../Vente/SupervisionModif.php">
									  <span class="header">
										<span class="title">Vérif modification appro</span>
									  </span>
									</a>
							   </li>
							   <li>
									<a href="../Operations/PageOpera.php">
										<span class="message"> Effectuer une opération</span>  
									</a>
								</li>  
								 <li>
									<a href="../Operations/ListeOperation1.php">
										<span class="message"> Liste des dépôts d'actions</span>  
									</a>
								</li>  
								 <li>
									<a href="../Operations/ListeOperation2.php">
										<span class="message"> Liste des retraits d'actions</span>  
									</a>
								</li>
							<?php } ?>
								 
							   
								<li>
									<a href="../Operations/ListePaiement.php">
										<span class="message">Payer les commissions calculées</span>  
									</a>
								</li>  
								<?php if($_SESSION['niveau']=="Admin"){ ?> 
								<li>
									<a href="../Operations/PaiementAction.php">
										<span class="message"> Paiement de commissions</span>  
									</a>
								</li>
								
								<li>
									<a href="../Operations/ListeCommpayer.php">
										<span class="message">Liste des commissions payées</span>  
									</a>
								</li> 

								<li>
									<a href="../Operations/PaiementMensuel.php">
										<span class="message">Règlement mensuel</span>  
									</a>
								</li>
								 <li>
									<a href="../Operations/PageOpportunite.php">
										<span class="message"> Enregister une opportunité</span>  
									</a>
								</li>
								<li>
									<a href="../Operations/ListeOpportunite.php">
										<span class="message">  Liste des opportunités ouvertes</span>  
									</a>
								</li>
								<li>
									<a href="../Operations/ListeOppCalculer.php">
										<span class="message">  Liste des opportunités calculées</span>  
									</a>
								</li>    
								 <li>
									<a href="../Operations/ListeOppCloture.php">
										<span class="message">  Liste des opportunités clôturées</span>  
									</a>
								</li> 
								 <?php } ?>                                             
			</ul>
		  </li>
				   
		  <li class="dropdown hidden-phone">
			  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<span> dépenses</span>
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

		  <li class="dropdown">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
			  <i class="halflings-icon white user"></i> Paramètres
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
			<li><a href="../Users/backup.php"><i class="halflings-icon book"></i> Sauvegarder</a></li>
			<li><a href="../Users/CreerAnnee.php"><i class="halflings-icon move"></i> Créer Année</a></li>
			<?php }else{?>
			<li><a href="../Users/ListerUserModif.php"><i class="halflings-icon user"></i> Modifier profil</a></li>  <?php } ?>
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