<?php 
require_once ('../connexion/access.php');
class Employe
{
	private $ID_EMP;
	private $NOM_EMP;
	private $PRENOM_EMP;
	private $CIVILITE_EMP;
	private $DATE_NAIS;
	private $POSTE_EMP;
	private $con=null;
	
	function __construct()
	{
		 if($this->con==NULL){
       $ac=new Access();
       $this->con=$ac->connection();
      }	
	}

	public function getIdEmploye(){
		return $this->ID_EMP;
	}
	public function getNomEmploye(){
		return $this->NOM_EMP;
	}
	public function getPrenomEmploye(){
		return $this->PRENOM_EMP;
	}
	public function getCivilite(){
		return $this->CIVILITE_EMP;
	}
	public function getDateNaissance(){
		return $this->DATE_NAIS;
	}
	public function getPosteEmploye(){
		return $this->POSTE_EMP;
	}
	public function getCon(){
		return $this->con;
	}

	public function setIdEmploye($id){
		$this->ID_EMP=$id;
	}
	public function setNomEmploye($nom){
		$this->NOM_EMP=$nom;
	}
	public function setPrenomEmploye($prenom){
		$this->PRENOM_EMP=$prenom;
	}
	public function setCivilite($civil){
		$this->CIVILITE_EMP=$civil;
	}
	public function setDateNaissance($nais){
		$this->DATE_NAIS=$nais;
	}
	public function setPosteEmploye($post){
		$this->POSTE_EMP=$post;
	}
	public function setCon($con){
		$this->con=$con;
	}


	//Fonction affichage de tous les utilisateurs
	public function ListerTout(){
      $show=$this->con->prepare("SELECT * FROM employe");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	 //Fonction de creation d'un utilisateur
	public function Ajouter(){
	  $save=$this->con->prepare("INSERT INTO employe(NOM_EMP, PRENOM_EMP, CIVILITE_EMP, DATE_NAIS, POSTE_EMP)
	                             VALUES(:nom,:prenom,:civ,:nais,:post)");
      $save->execute(array(':nom'=>$this->getNomEmploye(),
      	                   ':prenom'=>$this->getPrenomEmploye(),
      	                   ':civ'=>$this->getCivilite(),
      	                   ':nais'=>$this->getDateNaissance(),
      	                   ':post'=>$this->getPosteEmploye()));
      return $save?"ok":"error";
	}


	 //Fonction pour selectionner un utilisateur à editer
	public function getOne($code){
	  $one=$this->con->prepare(" SELECT * FROM employe WHERE ID_EMP='".$code."'");
	  $one->execute();
	  $un=$one->fetch();
	  return $un;
	}

    //Fonction pour mettre a jour un utilisateur
	public function updateEmploye(){
	$up=$this->con->prepare("UPDATE employe SET NOM_EMP='".$this->getNomEmploye()."',
		                                        PRENOM_EMP='".$this->getPrenomEmploye()."',
	                                            CIVILITE_EMP='".$this->getCivilite()."',
	                                            DATE_NAIS='".$this->getDateNaissance()."',
	                                            POSTE_EMP='".$this->getPosteEmploye()."'
	                                            WHERE ID_EMP='".$this->getIdEmploye()."' ");
	$up->execute();
	return $up;	
	}

	//Fonction suppression d'un utilisateur
	public function delete($code){
	$del=$this->con->prepare("DELETE FROM employe WHERE ID_EMP='".$code."'");
	$del->execute();
	return $del;	
	}


}



 ?>