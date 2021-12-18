<?php 
require_once ('../connexion/access.php');
class Permission
{
	private $ID_PERM;
	private $ID_EMP;
	private $MOTIF_PERM;
	private $UNITE_PERM;
	private $NOMBRE;
	private $DATE_DEMANDE;
	private $DATE_DEBUT;
	private $DATE_FIN;
	private $ETAT_DEMANDE;
	private $con=null;
	
	function __construct()
	{
		 if($this->con==NULL){
       $ac=new Access();
       $this->con=$ac->connection();
      }	
	}

	public function getIdPermission(){
		return $this->ID_PERM;
	}
	public function getIdEmploye(){
		return $this->ID_EMP;
	}
	public function getMotifPermission(){
		return $this->MOTIF_PERM;
	}
	public function getUnitePermission(){
		return $this->UNITE_PERM;
	}
	public function getNombreUnite(){
		return $this->NOMBRE;
	}
	public function getDatedemande(){
		return $this->DATE_DEMANDE;
	}
	public function getDateDebut(){
		return $this->DATE_DEBUT;
	}
	public function getDateFin(){
		return $this->DATE_FIN;
	}
	public function getEtatDemande(){
		return $this->ETAT_DEMANDE;
	}
	public function getCon(){
		return $this->con;
	}

	public function setIdPermission($id){
		$this->ID_EMP=$id;
	}
	public function setIdEmploye($id){
		$this->ID_EMP=$id;
	}
	public function setMotifPermission($motif){
		$this->MOTIF_PERM=$motif;
	}
	public function setUnitePermission($unite){
		$this->UNITE_PERM=$unite;
	}
	public function setNombreUnite($nbre){
		$this->NOMBRE=$nbre;
	}
	public function setDatedemande($dem){
		$this->DATE_DEMANDE=$dem;
	}
	public function setDateDebut($debut){
		$this->DATE_DEBUT=$debut;
	}
	public function setDateFin($fin){
		$this->DATE_FIN=$fin;
	}
	public function setEtatDemande($etat){
		$this->ETAT_DEMANDE=$etat;
	}
	public function setCon($con){
		$this->con=$con;
	}


	//Fonction affichage de tous les utilisateurs
	public function ListerTout(){
      $show=$this->con->prepare("SELECT * FROM permission");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	 //Fonction de creation d'un utilisateur
	public function Ajouter(){
	  $save=$this->con->prepare("INSERT INTO permission(ID_EMP, MOTIF_PERM, UNITE_PERM, NOMBRE, DATE_DEMANDE, DATE_DEBUT, DATE_FIN, ETAT_DEMANDE)
	                             VALUES(:emp,:motif,:un,:nbre,:dd,:debut,:fin,:etat)");
      $save->execute(array(':emp'=>$this->getIdEmploye(),
      	                   ':motif'=>$this->getMotifPermission(),
      	                   ':un'=>$this->getUnitePermission(),
      	                   ':nbre'=>$this->getNombreUnite(),
      	                   ':dd'=>$this->getDatedemande(),
      	                   ':debut'=>$this->getDateDebut(),
      	                   ':fin'=>$this->getDateFin(),
      	                   ':etat'=>$this->getEtatDemande()));
      return $save?"ok":"error";
	}


	 //Fonction pour selectionner un utilisateur à editer
	public function getOne($code){
	  $one=$this->con->prepare(" SELECT * FROM permission WHERE ID_PERM='".$code."'");
	  $one->execute();
	  $un=$one->fetch();
	  return $un;
	}

    //Fonction pour mettre a jour un utilisateur
	public function updatePermission(){
	$up=$this->con->prepare("UPDATE permission SET NOM_EMP='".$this->getNomEmploye()."',
			                                        PRENOM_EMP='".$this->getPrenomEmploye()."',
		                                            CIVILITE_EMP='".$this->getCivilite()."',
		                                            DATE_NAIS='".$this->getDateNaissance()."',
		                                            POSTE_EMP='".$this->getPosteEmploye()."'
		                                            WHERE ID_PERM='".$this->getIdEmploye()."' ");
	$up->execute();
	return $up;	
	}

	//Fonction suppression d'un utilisateur
	public function delete($code){
	$del=$this->con->prepare("DELETE FROM permission WHERE ID_PERM='".$code."'");
	$del->execute();
	return $del;	
	}


}



 ?>