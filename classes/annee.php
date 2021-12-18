<?php 
require_once ('../connexion/access.php');
class Annee
{
	private $ID_ANNEE;
	private $LIBELLE_ANNE;
	private $con=null;
	
	function __construct()
	{
		 if($this->con==NULL){
       $ac=new Access();
       $this->con=$ac->connection();
      }	
	}

	public function getIdAnnee(){
		return $this->ID_ANNEE;
	}
	public function getLibelleAnnee(){
		return $this->LIBELLE_ANNE;
	}
	public function getCon(){
		return $this->con;
	}

	public function setIdAnnee($id){
		$this->ID_ANNEE=$id;
	}
	public function setLibelleAnnee($lib){
		$this->LIBELLE_ANNE=$lib;
	}
	public function setCon($con){
		$this->con=$con;
	}


	//Fonction affichage de tous les utilisateurs
	public function ListerTout(){
      $show=$this->con->prepare("SELECT * FROM annee");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	 public function ListerTouteAnnee(){
      $show=$this->con->prepare("SELECT ID_ANNEE, LIBELLE_ANNE FROM annee");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

   public function ListerAnneeId($id){
      $show=$this->con->prepare("SELECT LIBELLE_ANNE FROM annee WHERE ID_ANNEE='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['LIBELLE_ANNE']."";
    } 
  }

	 //Fonction de creation d'un utilisateur
	public function Ajouter(){
	  $save=$this->con->prepare("INSERT INTO annee(LIBELLE_ANNE)
	                             VALUES(:libelle)");
      $save->execute(array(':libelle'=>$this->getLibelleAnnee()));
      return $save?"ok":"error";
	}
}



 ?>