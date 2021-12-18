<?php 
require_once ('../connexion/access.php');
require_once ('client.php');
class Encaissement
{
	private $ID_ENC;
	private $NUM_CLI;
  private $ID_USER;
	private $MONT_ENC;
	private $DATE_ENC;
  private $HEURE_ENC;
  private $SOLDE_ENCAISSE;
  private $ETAT_ENCAISSE;
	private $con=Null;
	
	function __construct()
	{
		if($this->con==NULL){
       $ac=new Access();
       $this->con=$ac->connection();
      }	
       $this->cli= new client();	  
	}
    
    //Declaration des getteurs
  public function getIdUser(){
    return $this->ID_USER;
  }
	public function getIdEncaisser(){
		return $this->ID_ENC;
	}
	public function getNumClient(){
    return $this->NUM_CLI;
  }
  public function getMontEncaisser(){
    return $this->MONT_ENC;
  }
	public function getDateEncaisser(){
		return $this->DATE_ENC;
	}
  public function getHeureEncaisser(){
    return $this->HEURE_ENC;
  }
   public function getSoldeEncaisse(){
    return $this->SOLDE_ENCAISSE;
  }
  public function getEtatEncaisse(){
    return $this->ETAT_ENCAISSE;
  }
	public function getCon(){
		return $this->con;
	}

	//Declaration des setteurs
  public function setIdUser($id){
    $this->ID_USER=$id;
  }
    public function setIdEncaisser($id){
     $this->ID_ENC=$id;
    }
    public function setNumClient($num){
      $this->NUM_CLI=$num;
	}
  public function setMontEncaisser($mont){
      $this->MONT_ENC=$mont;
  }
  public function setDateEncaisser($date){
   $this->DATE_ENC=$date;
  }
  public function setHeureEncaisser($heure){
   $this->HEURE_ENC=$heure;
  }
  public function setSoldeEncaisse($solde){
   $this->SOLDE_ENCAISSE=$solde;
  }
   public function setEtatEncaisse($etat){
   $this->ETAT_ENCAISSE=$etat;
  }
  public function setCon($con){
   $this->con=$con;
  }

    //Implementation du CRUD 

   public function nowDate(){
    return date("Y-m-d");
   } 

   public function nowHour(){
    return date("H:i:s");
   } 

  //Fonction de creation d'une nouvelle dotation
	public function Ajouter($num, $mont, $date){
	  $save=$this->con->prepare("INSERT INTO encaissement(NUM_CLI, MONT_ENC, DATE_ENC)
	                             VALUES(:num,:mont,:dat)");
      $save->execute(array(':num'=>$num,
      	                   ':mont'=>$mont,
      	                   ':dat'=>$date
      	                   ));    
      return $save?"ok":"error";
	}

  //Fonction de creation d'une nouvelle dotation
  public function Ajouter2(){
    $save=$this->con->prepare("INSERT INTO encaissement(NUM_CLI, ID_USER, MONT_ENC, DATE_ENC,HEURE_ENC,SOLDE_ENCAISSE,ETAT_ENCAISSE)
                               VALUES(:num,:us,:mont,:dat,:hour,:solde,:etat)");
      $test=$save->execute(array(':num'=>$this->getNumClient(),
                           ':us'=>$this->getIdUser(),
                           ':mont'=>$this->getMontEncaisser(),
                           ':dat'=>$this->getDateEncaisser(),
                           ':hour'=>$this->getHeureEncaisser(),
                           ':solde'=>$this->getSoldeEncaisse(),
                           ':etat'=>$this->getEtatEncaisse()
                           ));                      
      return $save?"ok":"error";
  }

  //Fonction de creation d'un produit
  public function AjouterSuppression($user,$connexion,$message,$cible){
    $save=$this->con->prepare("INSERT INTO espion_suppr(ID_USER, DATE_SUPPR, MESSAGE, ELEMENT_CIBLE)
                               VALUES(:user,:dat,:mess,:elt)
                              ");
      $save->execute(array(':user'=>$user,
                           ':dat'=>$connexion,
                           ':mess'=>$message,
                           ':elt'=>$cible                            
                           ));
      return $save?"ok":"error";
  }

  //Fonction affichage de toutes les dotations
  public function ListerTout(){
      $show=$this->con->prepare("SELECT ID_ENC,c.NUM_CLI,NOM_CLI,PRENOM_CLI,MONT_ENC,DATE_ENC,HEURE_ENC,PRENOM_USER,ETAT_ENCAISSE
                                 FROM client c, encaissement e, user u
                                 WHERE e.NUM_CLI=c.NUM_CLI AND e.ID_USER=u.ID_USER
                                 AND DATE_ENC= CURDATE()
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

    //Fonction affichage de toutes les dotations
  public function ListerEncaissement($id){
      $show=$this->con->prepare("SELECT ID_ENC,c.NUM_CLI,NOM_CLI,PRENOM_CLI,MONT_ENC,DATE_ENC,HEURE_ENC,PRENOM_USER,ETAT_ENCAISSE
                                 FROM client c, encaissement e, user u
                                 WHERE e.NUM_CLI=c.NUM_CLI 
                                 AND e.ID_USER=u.ID_USER
                                 AND u.ID_USER = '".$id."'
                                 AND ETAT_ENCAISSE='NON VERSE'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage de tous les encaissements
  public function ListerMesEncaissementJour($id){
      $show=$this->con->prepare("SELECT ID_ENC,c.NUM_CLI,NOM_CLI,PRENOM_CLI,MONT_ENC,DATE_ENC,HEURE_ENC,PRENOM_USER,ETAT_ENCAISSE
                                 FROM client c, encaissement e, user u
                                 WHERE e.NUM_CLI=c.NUM_CLI 
                                 AND e.ID_USER=u.ID_USER
                                 AND u.ID_USER = '".$id."'
                                 AND DATE_ENC= CURDATE()
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

   //Fonction affichage de toutes les dotations
  public function ListerEncaissementVerser($id){
      $show=$this->con->prepare("SELECT ID_ENC,c.NUM_CLI,NOM_CLI,PRENOM_CLI,MONT_ENC,DATE_ENC,HEURE_ENC,ETAT_ENCAISSE
                                 FROM client c, encaissement e, user u
                                 WHERE e.NUM_CLI=c.NUM_CLI 
                                 AND e.ID_USER=u.ID_USER
                                 AND u.ID_USER = '".$id."'
                                 AND ETAT_ENCAISSE='VERSE'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage de toutes les dotations
  public function ListerEncaisseClient($id){
      $show=$this->con->prepare("SELECT ID_ENC,c.NUM_CLI,NOM_CLI,PRENOM_CLI,MONT_ENC,DATE_ENC,HEURE_ENC
                                 FROM client c, encaissement e
                                 WHERE e.NUM_CLI=c.NUM_CLI AND ID_ENC='".$id."'
                                 AND DATE_ENC=CURDATE()
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage de tous les clients
  public function ListerLibelleProd(){
      $show=$this->con->prepare("SELECT CODE_PROD, LIBELLE_PROD FROM produit");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction pour mettre a jour un produit
  public function updateSoldeCli($id,$mont){
  $up=$this->con->prepare("UPDATE client SET SOLDE_CLIENT = SOLDE_CLIENT-'".$mont."' WHERE NUM_CLI='".$id."' ");
  $up->execute();
  return $up; 
  }

  public function updateEtatVersement($id){
  $up=$this->con->prepare("UPDATE encaissement SET ETAT_ENCAISSE = 'VERSE' WHERE ID_USER='".$id."' ");
  $up->execute();
  return $up; 
  }

  public function updateVersementConfirmer($id){
  $up=$this->con->prepare("UPDATE encaissement SET ETAT_ENCAISSE = 'CONFIRME' WHERE ID_USER='".$id."' ");
  $up->execute();
  return $up; 
  }

  //Fonction pour mettre a jour un produit
  public function updateSoldeCliVte($id,$rest,$echeance){
  $up=$this->con->prepare("UPDATE client SET SOLDE_CLIENT = SOLDE_CLIENT+'".$rest."',
                                             ECHEANCE = '".$echeance."',
                                             AUTORISATION = 'NON'
                                             WHERE NUM_CLI='".$id."' ");
  $up->execute();
  return $up; 
  }

	//Fonction pour mettre a jour une versement
	public function updateEncaisse(){
	$up=$this->con->prepare("UPDATE encaissement SET MONT_ENC='".$this->getMontEncaisser()."',
  	                                              DATE_ENC='".$this->getDateEncaisser()."'
  	                                              WHERE ID_ENC='".$this->getIdEncaisser()."' ");
	$up->execute();
	return $up;	
	}

   //Fonction pour selectionner une versement à editer
  public function getOne($code){
    $one=$this->con->prepare(" SELECT * FROM encaissement WHERE ID_ENC='".$code."'");
    $one->execute();
    $un=$one->fetch();
    return $un;
  }

  //Fonction suppression d'un produit
  public function delete($code){
  $del=$this->con->prepare("DELETE FROM encaissement WHERE ID_ENC='".$code."'");
  $del->execute();
  return $del;  
  }

  //Afficher libelle d'un produit
    public function showNomClient($id){
      $show=$this->con->prepare("SELECT NOM_CLI FROM client WHERE NUM_CLI='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NOM_CLI']."";
    } 
  }

  //Calcul du total d'une vente
    public function showTotalEncaissementJour(){
      $show=$this->con->prepare("SELECT SUM(MONT_ENC) FROM encaissement WHERE DATE_ENC=CURDATE()");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(MONT_ENC)']."";
    } 
  }

   //Calcul du total d'une vente
    public function showTotalEncaisseEmployeJour($user){
      $show=$this->con->prepare("SELECT SUM(MONT_ENC) FROM encaissement WHERE ID_USER='".$user."' AND ETAT_ENCAISSE='NON VERSE' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(MONT_ENC)']."";
    } 
  }

  //Calcul du total d'une vente
    public function totalEncaisseEmployeJourNV($user){
      $show=$this->con->prepare("SELECT SUM(MONT_ENC) FROM encaissement WHERE ID_USER='".$user."' AND DATE_ENC= CURDATE()");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(MONT_ENC)']."";
    } 
  }

  //Calcul du total d'une vente
    public function showSoldeClient($num){
      $show=$this->con->prepare("SELECT SOLDE_CLIENT FROM client WHERE NUM_CLI='".$num."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SOLDE_CLIENT']."";
    } 
  }

   public function showAutorisationClient($num){
      $show=$this->con->prepare("SELECT AUTORISATION FROM client WHERE NUM_CLI='".$num."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['AUTORISATION']."";
    } 
  }

  //Calcul du total d'une vente
    public function showEcheanceClient($num){
      $show=$this->con->prepare("SELECT ECHEANCE FROM client WHERE NUM_CLI='".$num."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['ECHEANCE']."";
    } 
  }

   public function showLastDateEncaisse($num){
      $show=$this->con->prepare("SELECT DATE_ENC FROM encaissement
                                 WHERE NUM_CLI='".$num."'
                                 AND ID_ENC = (SELECT MAX(ID_ENC) FROM encaissement)");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['DATE_ENC']."";
    } 
  }

  public function updateSoldEncaisse($mont,$cli,$id){
  $up=$this->con->prepare("UPDATE encaissement
                           SET SOLDE_ENCAISSE=((SOLDE_ENCAISSE)-('".$mont."'))
                           WHERE NUM_CLI = '".$cli."'
                           AND ID_ENC >= '".$id."' ");
  $up->execute();
  return $up; 
  }

  //Fonction affichage de toutes les dotations
  public function SommeListerEncaisseEmploye(){
      $show=$this->con->prepare("SELECT PRENOM_USER, SUM(MONT_ENC) as paye
                                 FROM encaissement e, user u
                                 WHERE e.ID_USER=u.ID_USER
                                 AND ETAT_ENCAISSE='NON VERSE'
                                 GROUP BY u.ID_USER");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  public function SommeListerEncaisseEmployeJour(){
      $show=$this->con->prepare("SELECT PRENOM_USER, SUM(MONT_ENC) as paye
                                 FROM encaissement e, user u
                                 WHERE e.ID_USER=u.ID_USER
                                 /*AND ETAT_ENCAISSE='NON VERSE'*/
                                 AND DATE_ENC = CURDATE()
                                 GROUP BY u.ID_USER");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }


   public function updateSoldVteEncaisse($mont,$d,$cli){
  $up=$this->con->prepare("UPDATE vente SET SOLDE_VENTE=((SOLDE_VENTE)-('".$mont."'))
                                               WHERE DATE_VENTE >= '".$d."'
                                               AND NUM_CLI = '".$cli."' ");
  $up->execute();
  return $up; 
  }

  //Fonction pour mettre a jour un produit
  public function updateSoldeEncaisseDel($mont,$cli,$id){
  $up=$this->con->prepare("UPDATE encaissement SET SOLDE_ENCAISSE=((SOLDE_ENCAISSE)+('".$mont."'))
                                               WHERE NUM_CLI = '".$cli."'
                                               AND ID_ENC > '".$id."' ");
  $up->execute();
  return $up; 
  }


  //Afficher libelle d'un produit
    public function showNumClient($id){
      $show=$this->con->prepare("SELECT NUM_CLI FROM encaissement WHERE ID_ENC='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NUM_CLI']."";
    } 
  }

  //Afficher libelle d'un produit
    public function showOldSomme($id){
      $show=$this->con->prepare("SELECT MONT_ENC FROM encaissement WHERE ID_ENC='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['MONT_ENC']."";
    } 
  }

  //Fonction affichage des ventes au cours d'une periode donnée
  public function EncaissePeriodique($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d"); 
      $show=$this->con->prepare("SELECT ID_ENC,NOM_CLI,MONT_ENC,DATE_ENC
                                 FROM client c, encaissement e
                                 WHERE e.NUM_CLI=c.NUM_CLI
                                 AND DATE_ENC BETWEEN '".$d1_traite."' AND '".$d2_traite."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Calcule du prix total de vente garde au cours d'une periode
   function PrixPeriodeEncaisse($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT SUM(MONT_ENC) as somme
                                 FROM client c, encaissement e
                                 WHERE e.NUM_CLI=c.NUM_CLI
                                 AND DATE_ENC BETWEEN '".$d1_traite."' AND '".$d2_traite."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }

  //Fonction affichage des dotations par produit
  public function ListerDotProdP($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d"); 
      $show=$this->con->prepare("SELECT p.ID_PROD, DESIGNATION, SUM(QTE_DOTATION) as somme,SUM(QTE_DOTATION)*PRIX as total                               
                                 FROM produit p, dotation d
                                 WHERE d.ID_PROD=p.ID_PROD
                                 AND DATE_DOTATION BETWEEN '".$d1_traite."' AND '".$d2_traite."' 
                                 AND TYPE_DOTATION='Pharmacie'
                                 GROUP BY p.ID_PROD
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

   //Fonction affichage des dotations par produit
  public function ListerDotProdG($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d"); 
      $show=$this->con->prepare("SELECT p.ID_PROD, DESIGNATION, SUM(QTE_DOTATION) as somme,SUM(QTE_DOTATION)*PRIX as total                               
                                 FROM produit p, dotation d
                                 WHERE d.ID_PROD=p.ID_PROD
                                 AND DATE_DOTATION BETWEEN '".$d1_traite."' AND '".$d2_traite."' 
                                 AND TYPE_DOTATION='Garde'
                                 GROUP BY p.ID_PROD
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Calcul du prix total de l'approvisionnement
   function PrixTotalProdP($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT SUM((PRIX)*(QTE_DOTATION)) as somme
                                 FROM dotation d, produit p
                                 WHERE P.ID_PROD=d.ID_PROD
                                 AND DATE_DOTATION BETWEEN '".$d1_traite."' AND '".$d2_traite."' 
                                 AND TYPE_DOTATION='Pharmacie'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }

  //Calcul du prix total de l'approvisionnement
   function PrixTotalProdG($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT SUM((PRIX)*(QTE_DOTATION)) as somme
                                 FROM dotation d, produit p
                                 WHERE P.ID_PROD=d.ID_PROD
                                 AND DATE_DOTATION BETWEEN '".$d1_traite."' AND '".$d2_traite."' 
                                 AND TYPE_DOTATION='Garde'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }


  //Afficher quantite d'une dotation
    public function showQuantiteDotation($id){
      $show=$this->con->prepare("SELECT QTE_DOTATION FROM dotation WHERE ID_DOTATION='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['QTE_DOTATION']."";
    } 
  }

  //Afficher Id produit d'une dotation
    public function showIdProduitDote($id){
      $show=$this->con->prepare("SELECT ID_PROD FROM dotation WHERE ID_DOTATION='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['ID_PROD']."";
    } 
  }

   //Afficher type d'une dotation
    public function showTypeDote($id){
      $show=$this->con->prepare("SELECT TYPE_DOTATION FROM dotation WHERE ID_DOTATION='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['TYPE_DOTATION']."";
    } 
  }

	//Calcule le nombre total de dotation au cour d'une periode donnée
   function compterDotationPeriode($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT count('ID_DOTATION') as valeur
                                 FROM dotation
                                 WHERE DATE_DOTATION BETWEEN '".$d1_traite."' AND '".$d2_traite."' 
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['valeur']."";
    } 
  }

  //Calcule du prix total de la dotation pharmacie
   function PrixDotationPharma($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT SUM((PRIX)*(QTE_DOTATION)) as somme
                                 FROM dotation d, produit p
                                 WHERE P.ID_PROD=d.ID_PROD
                                 AND TYPE_DOTATION='Pharmacie'
                                 AND DATE_DOTATION BETWEEN '".$d1_traite."' AND '".$d2_traite."' 
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }

  //Calcul du prix total de la dotation garde
   function PrixDotationGarde($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT SUM((PRIX)*(QTE_DOTATION)) as somme
                                 FROM dotation d, produit p
                                 WHERE P.ID_PROD=d.ID_PROD
                                 AND TYPE_DOTATION='Garde'
                                 AND DATE_DOTATION BETWEEN '".$d1_traite."' AND '".$d2_traite."' 
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }

  //Calcul du prix total de la dotation garde
   function PrixDotPhVGarde2($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT SUM((PRIX)*(QTE_DOTATION)) as somme
                                 FROM dotation d, produit p
                                 WHERE P.ID_PROD=d.ID_PROD
                                 AND TYPE_DOTATION='PharmaVsGarde'
                                 AND DATE_DOTATION BETWEEN '".$d1_traite."' AND '".$d2_traite."' 
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }

   //Calcul du prix total de la dotation garde
   function PrixDotPharmaVgarde($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT SUM((PRIX)*(QTE_DOTATION)) as somme
                                 FROM dotation d, produit p
                                 WHERE P.ID_PROD=d.ID_PROD
                                 AND TYPE_DOTATION='PharmaVsGarde'
                                 AND DATE_DOTATION BETWEEN '".$d1_traite."' AND '".$d2_traite."' 
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }

  //Calcule le nombre total de dotation au cour d'une periode donnée pour une pharmacie
   function DotationPeriodePharma($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT count('ID_DOTATION') as valeur
                                 FROM dotation
                                 WHERE DATE_DOTATION BETWEEN '".$d1_traite."' AND '".$d2_traite."' 
                                 AND TYPE_DOTATION='Pharmacie'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['valeur']."";
    } 
  }
	
}



 ?>