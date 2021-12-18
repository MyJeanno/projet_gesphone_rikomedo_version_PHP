<?php 
require_once ('../connexion/access.php');
class Presence
{
	private $ID_PRESENCE;
	private $ID_USER;
	private $DATE_PRESENCE;
	private $HEURE_ARRIVEE;
	private $HEURE_DEPART;
	private $FLAG;
	private $con=null;
	
	function __construct()
	{
		 if($this->con==NULL){
       $ac=new Access();
       $this->con=$ac->connection();
      }	
	}

	public function getIdPresence(){
		return $this->ID_PRESENCE;
	}
	public function getIdUser(){
		return $this->ID_USER;
	}
	public function getDatePresence(){
		return $this->DATE_PRESENCE;
	}
	public function getHeureArrivee(){
		return $this->HEURE_ARRIVEE;
	}
	public function getHeureDepart(){
		return $this->HEURE_DEPART;
	}
	public function getFlag(){
		return $this->FLAG;
	}
	public function getCon(){
		return $this->con;
	}

	public function setIdPresence($id){
		$this->ID_PRESENCE=$id;
	}
	public function setIdUser($id){
		$this->ID_USER=$id;
	}
	public function setDatePresence($dat){
		$this->DATE_PRESENCE=$dat;
	}
	public function setHeureArrivee($arrive){
		$this->HEURE_ARRIVEE=$arrive;
	}
	public function setHeureDepart($depart){
		$this->HEURE_DEPART=$depart;
	}
	public function setFlag($bool){
		$this->FLAG=$bool;
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
      $show=$this->con->prepare("SELECT ID_PRESENCE,NOM_USER,PRENOM_USER,DATE_PRESENCE,HEURE_ARRIVEE,HEURE_DEPART 
      	                         FROM presence p, user u 
      	                         WHERE u.ID_USER=p.ID_USER AND DATE_PRESENCE = CURDATE()");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	 public function showPresencePeriodique($d1, $d2, $id){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-",$d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT ID_PRESENCE,NOM_USER,PRENOM_USER,DATE_PRESENCE,HEURE_ARRIVEE,HEURE_DEPART
                                 FROM presence p, user u 
                                 WHERE u.ID_USER=p.ID_USER
                                 AND DATE_PRESENCE BETWEEN '".$d1_traite."' AND '".$d2_traite."' AND u.ID_USER = '".$id."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

	 //Fonction de creation d'un utilisateur
	public function Ajouter(){
	  $save=$this->con->prepare("INSERT INTO presence(ID_USER, DATE_PRESENCE, HEURE_ARRIVEE, HEURE_DEPART,FLAG)
	                             VALUES(:us,:d,:arr,:dep,:fla)");
      $save->execute(array(':us'=>$this->getIdUser(),
      	                   ':d'=>$this->getDatePresence(),
      	                   ':arr'=>$this->getHeureArrivee(),
      	                   ':dep'=>$this->getHeureDepart(),
      	                   ':fla'=>$this->getFlag()
      	                  ));
      return $save?"ok":"error";
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