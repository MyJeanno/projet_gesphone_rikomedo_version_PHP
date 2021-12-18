<?php 
require_once ('../connexion/access.php');
class Ecart
{
	private $ID_ECART;
	private $ID_USER;
	private $MONTANT_REEL;
	private $MONTANT_PHYSIQUE;
	private $DATE_ECART;
	private $ORIGINE_ECART;
	private $ECART_MONTANT;
	private $AVIS_ECART;
	private $con=null;
	
	function __construct()
	{
		 if($this->con==NULL){
       $ac=new Access();
       $this->con=$ac->connection();
      }	
	}

	public function getIdEcart(){
		return $this->ID_ECART;
	}
	public function getIdUser(){
		return $this->ID_USER;
	}
	public function getMontantReel(){
		return $this->MONTANT_REEL;
	}
	public function getMontantPhysique(){
		return $this->MONTANT_PHYSIQUE;
	}
	public function getDateEcart(){
		return $this->DATE_ECART;
	}
	public function getOrigineEcart(){
		return $this->ORIGINE_ECART;
	}
	public function getMontantEcart(){
		return $this->ECART_MONTANT;
	}
	public function getAvisEcart(){
		return $this->AVIS_ECART;
	}
	public function getCon(){
		return $this->con;
	}

	public function setIdEcart($idp){
		$this->ID_ECART=$idp;
	}
	public function setIdUser($id){
		$this->ID_USER=$id;
	}
	public function setMontantReel($reel){
		$this->MONTANT_REEL=$reel;
	}
	public function setMontantPhysique($phy){
		$this->MONTANT_PHYSIQUE=$phy;
	}
	public function setDateEcart($datecart){
		$this->DATE_ECART=$datecart;
	}
	public function setOrigineEcart($origin){
		$this->ORIGINE_ECART=$origin;
	}
	public function setMontantEcart($mont){
		$this->ECART_MONTANT=$mont;
	}
	public function setAvisEcart($avis){
		$this->AVIS_ECART=$avis;
	}
	public function setCon($con){
		$this->con=$con;
	}

	public function nowDate(){
	    return date("Y-m-d");
	} 

	public function nowHour(){
	    return date("H:i:s");
	} 


	//Fonction affichage de tous les utilisateurs
	public function ListerTout(){
      $show=$this->con->prepare("SELECT ID_ECART,NOM_USER,PRENOM_USER,MONTANT_REEL,MONTANT_PHYSIQUE,DATE_ECART,ORIGINE_ECART,ECART_MONTANT,AVIS_ECART 
      	                         FROM ecart e, user u 
      	                         WHERE e.ID_USER=u.ID_USER AND AVIS_ECART = 'NON REGLE'");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}


	//Fonction affichage de tous les utilisateurs
	public function ListerTout2(){
      $show=$this->con->prepare("SELECT ID_ECART,NOM_USER,PRENOM_USER,MONTANT_REEL,MONTANT_PHYSIQUE,DATE_ECART,ORIGINE_ECART,ECART_MONTANT,AVIS_ECART 
      	                         FROM ecart e, user u 
      	                         WHERE e.ID_USER=u.ID_USER AND AVIS_ECART = 'REGLE'");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	 //Fonction de creation d'un utilisateur
	public function Ajouter(){
	  $save=$this->con->prepare("INSERT INTO ecart(ID_USER, MONTANT_REEL, MONTANT_PHYSIQUE, DATE_ECART,ORIGINE_ECART, ECART_MONTANT,AVIS_ECART)
	                             VALUES(:us,:reel,:phys,:dat,:origi,:mont,:avis)");
      $save->execute(array(':us'=>$this->getIdUser(),
      	                   ':reel'=>$this->getMontantReel(),
      	                   ':phys'=>$this->getMontantPhysique(),
      	                   ':dat'=>$this->getDateEcart(),
      	                   ':origi'=>$this->getOrigineEcart(),
      	                   ':mont'=>$this->getMontantEcart(),
      	                   ':avis'=>$this->getAvisEcart()
      	                  ));
      return $save?"ok":"error";
	}

	public function updateReglementEcart($id){
	  $up=$this->con->prepare("UPDATE ecart SET DATE_REGLEMENT = CURDATE(), AVIS_ECART = 'REGLE' WHERE ID_ECART='".$id."' ");
	  $up->execute();
	  return $up; 
	  }

	  public function updateAnnulerEcart($id){
	  $up=$this->con->prepare("UPDATE ecart SET DATE_REGLEMENT = CURDATE(), AVIS_ECART = 'NON REGLE' WHERE ID_ECART='".$id."' ");
	  $up->execute();
	  return $up; 
	  }


  public function ListerNomUser(){
      $show=$this->con->prepare("SELECT ID_USER, NOM_USER, PRENOM_USER FROM user ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }


    public function showEtatPresence($id){
      $show=$this->con->prepare("SELECT FLAG FROM presence WHERE ID_USER='".$id."' AND DATE_PRESENCE = CURDATE()");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['FLAG']."";
    } 
  }


	 //Fonction pour selectionner un utilisateur à editer
	public function getOne($code){
	  $one=$this->con->prepare(" SELECT * FROM presence WHERE ID_PRESENCE='".$code."'");
	  $one->execute();
	  $un=$one->fetch();
	  return $un;
	}

    //Fonction pour mettre a jour un utilisateur
	public function updatePresence(){
	$up=$this->con->prepare("UPDATE presence SET HEURE_DEPART='".$this->getHeureDepart()."' WHERE ID_USER='".$this->getIdUser()."' AND DATE_PRESENCE = CURDATE() ");
	$up->execute();
	return $up;	
	}

	//Fonction suppression d'un utilisateur
	public function delete($code){
	$del=$this->con->prepare("DELETE FROM presence WHERE ID_PRESENCE='".$code."'");
	$del->execute();
	return $del;	
	}


}



 ?>