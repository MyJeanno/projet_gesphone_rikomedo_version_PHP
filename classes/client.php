<?php 
require_once ('../connexion/access.php');
class Client
{
	private $NUM_CLI;
	private $NOM_CLI;
	private $PRENOM_CLI;
	private $TYPE_CLI;
	private $CONTACT_CLI;
	private $SOLDE_CLIENT;
	private $INACTIF;
	private $AUTORISATION;
	private $con=NULL;
	
	function __construct()
	{
	   if($this->con==NULL){
       $ac=new Access();
       $this->con=$ac->connection();
      }	

	}
    // Declaration des getteurs
	public function getNumClient(){
		return $this->NUM_CLI;
	}
	public function getNomClient(){
		return $this->NOM_CLI;
	}
	public function getPrenomClient(){
		return $this->PRENOM_CLI;
	}
	public function getTypeClient(){
		return $this->TYPE_CLI;
	}
	public function getContactClient(){
		return $this->CONTACT_CLI;
	}
	public function getSoldeClient(){
		return $this->SOLDE_CLIENT;
	}
	public function getACtif(){
		return $this->INACTIF;
	}
	public function getAutorisation(){
		return $this->AUTORISATION;
	}
	public function getCon(){
		return $this->con;
	}

	//Declaration des setteurs
	public function setNumClient($num){
      $this->NUM_CLI=$num;
	}
	public function setNomClient($nom){
      $this->NOM_CLI=$nom;
	}
	public function setPrenomClient($prenom){
      $this->PRENOM_CLI=$prenom;
	}
	public function setTypeClient($type){
      $this->TYPE_CLI=$type;
	}
	public function setContactClient($contact){
      $this->CONTACT_CLI=$contact;
	}
	public function setSoldeClient($solde){
      $this->SOLDE_CLIENT=$solde;
	}
	public function setActif($actif){
      $this->INACTIF=$actif;
	}
	public function setAutorisation($auto){
      $this->AUTORISATION=$auto;
	}
	public function setCon($con){
      $this->con=$con;
	}

	
    //Fonction de creation d'un produit
	public function Ajouter(){
	  $save=$this->con->prepare("INSERT INTO client(NUM_CLI,NOM_CLI, PRENOM_CLI, TYPE_CLI, CONTACT_CLI, SOLDE_CLIENT,INACTIF,AUTORISATION)
	                             VALUES(?,?,?,?,?,?,?,?)
	                            ");
      $save->execute(array($this->getNumClient(),
      	                   $this->getNomClient(),
      	                   $this->getPrenomClient(),
      	                   $this->getTypeClient(),
                           $this->getContactClient(),
                           $this->getSoldeClient(),
                           $this->getACtif(),
                           $this->getAutorisation()                             
      	                   ));
      return $save?"ok":"error";
	}

    //Fonction affichage de tous les clients
	public function ListerTout(){
      $show=$this->con->prepare("SELECT * FROM client ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	//Fonction affichage de tous les clients
	public function ListerTout2(){
      $show=$this->con->prepare("SELECT * FROM client WHERE INACTIF='Oui'");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	public function activer($id){
	$up=$this->con->prepare("UPDATE client SET AUTORISATION='OUI'
	                                           WHERE NUM_CLI='".$id."' ");
	$up->execute();
	return $up;	
	}

	public function desactiver($id){
	$up=$this->con->prepare("UPDATE client SET AUTORISATION='NON'
	                                           WHERE NUM_CLI='".$id."' ");
	$up->execute();
	return $up;	
	}

	//Fonction affichage de tous les clients
	public function ListerDateAchat($cli){
      $show=$this->con->prepare("SELECT NUM_ID, DATE_VENTE 
      	                         FROM vente 
      	                         WHERE NUM_CLI = '".$cli."' AND NUM_ID > 0
      	                         GROUP BY NUM_ID
      	                         ORDER BY DATE_VENTE ASC ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}


//Fonction affichage de tous les clients
	public function ListerDateAchat2($cli){
      $show=$this->con->prepare("SELECT NUM_ID_VTE, DATE_VENTE 
      	                         FROM vente 
      	                         WHERE NUM_CLI = '".$cli."' AND NUM_ID_VTE > 0
      	                         GROUP BY NUM_ID_VTE
      	                         ORDER BY DATE_VENTE ASC ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	//Fonction affichage de tous les clients
	public function ListerDetailAchatClient($cli,$num){
      $show=$this->con->prepare("SELECT LIBELLE_PROD, QTE_VENTE, PRIX_GROS, PRIX_TOTAL, MONT_PAYE 
      	                         FROM vente v, produit p, client c 
      	                         WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI
      	                         AND c.NUM_CLI = '".$cli."' AND NUM_ID = '".$num."'
      	                         ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	//Fonction affichage de tous les clients
	public function ListerDetailAchatClientBis($cli,$num){
      $show=$this->con->prepare("SELECT LIBELLE_PROD, QTE_VENTE, PRIX_GROS, PRIX_TOTAL, MONT_PAYE 
      	                         FROM vente v, produit p, client c 
      	                         WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI
      	                         AND c.NUM_CLI = '".$cli."' AND NUM_ID_VTE = '".$num."'
      	                         ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}


	//Fonction pour mettre a jour un produit
	public function updateClient(){
	$up=$this->con->prepare("UPDATE client SET NOM_CLI='".$this->getNomClient()."',
	                                           PRENOM_CLI='".$this->getPrenomClient()."',
	                                           TYPE_CLI='".$this->getTypeClient()."', 
	                                           CONTACT_CLI='".$this->getContactClient()."'                                
	                                           WHERE NUM_CLI='".$this->getNumClient()."' ");
	$up->execute();
	return $up;	
	}

	//Fonction suppression d'un client
	public function delete($code){
	$del=$this->con->prepare("DELETE FROM client WHERE NUM_CLI=trim('".$code."')");
	$del->execute();
	return $del;	
	}

	public function desactiverClient($code){
	$del=$this->con->prepare("UPDATE client SET INACTIF='Non' WHERE NUM_CLI=trim('".$code."')");
	$del->execute();
	return $del;	
	}

	public function activerClient($code){
	$del=$this->con->prepare("UPDATE client SET INACTIF='Oui' WHERE NUM_CLI=trim('".$code."')");
	$del->execute();
	return $del;	
	}

	 //Fonction pour selectionner un produit à editer
	public function getOne($code){
	  $one=$this->con->prepare(" SELECT * FROM client WHERE NUM_CLI='".$code."'");
	  $one->execute();
	  $un=$one->fetch();
	  return $un;
	}

	//Calcul du total d'une vente
    public function showTotalSoldeClient(){
      $show=$this->con->prepare("SELECT SUM(SOLDE_CLIENT) FROM client WHERE INACTIF='Oui'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(SOLDE_CLIENT)']."";
    } 
  }

	//Afficher libelle d'un produit
    public function showNomClient(){
      $show=$this->con->prepare("SELECT NOM_CLI FROM client");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NOM_CLI']."";
    } 
  }

  //Fonction pour mettre a jour un produit
	public function updateSoldeClient($qte,$id){
	$up=$this->con->prepare("UPDATE client SET SOLDE_CLIENT=((SOLDE_CLIENT)-('".$qte."'))
	                                            WHERE NUM_CLI='".$id."' ");
	$up->execute();
	return $up;	
	}

	//Fonction pour mettre a jour un produit
	public function updateSoldeClidelEncaisse($qte,$id){
	$up=$this->con->prepare("UPDATE client SET SOLDE_CLIENT=((SOLDE_CLIENT)+('".$qte."'))
	                                            WHERE NUM_CLI='".$id."' ");
	$up->execute();
	return $up;	
	}

  //Afficher libelle d'un produit
    public function showSoldeClient($id){
      $show=$this->con->prepare("SELECT SOLDE_CLIENT FROM client WHERE NUM_CLI='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SOLDE_CLIENT']."";
    } 
  }

  //Fonction qui retourne le nombre d'incidents enregistrés
	public function compter(){
	  $list=$this->con->prepare("SELECT count(*) as total FROM client");
	  $list->execute();
	  $cpt=$list->fetchAll();
	  foreach($cpt as $val){
	  return  $val['total']."";
	  } 
	}

	//Fonction pour generer l'identifiant automatiquement
	public function genererRef(){
	    $to=$this->compter()+2;	  
    	if($to<10){
		return "CLRK00".$to;
		}
		 if($to<100){
		return "CLRK0".$to;
		}
		if($to<1000){
		return "CLRK".$to;
		}
	}

	//Afficher libelle d'un produit
    public function showProduit(){
      $show=$this->con->prepare("SELECT ID_PROD, DESIGNATION FROM produit");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }


}


 ?>