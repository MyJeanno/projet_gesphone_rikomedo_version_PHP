<?php 
require_once ('../connexion/access.php');
class User
{
	private $ID_USER;
	private $NOM_USER;
	private $PRENOM_USER;
	private $USER_NAME;
	private $PASSWORD;
	private $TYPE;
	private $PERMISSION;
	private $fichier;
	private $url;
	private $con=null;
	
	function __construct()
	{
		 if($this->con==NULL){
       $ac=new Access();
       $this->con=$ac->connection();
      }	
	}

	public function getIdUser(){
		return $this->ID_USER;
	}
	public function getNom(){
		return $this->NOM_USER;
	}
	public function getPrenom(){
		return $this->PRENOM_USER;
	}
	public function getName(){
		return $this->USER_NAME;
	}
	public function getPass(){
		return $this->PASSWORD;
	}
	public function getType(){
		return $this->TYPE;
	}
	public function getPermission(){
		return $this->PERMISSION;
	}
	public function getFichier(){
		return $this->fichier;
	}
	public function getUrl(){
		return $this->url;
	}
	public function getCon(){
		return $this->con;
	}

	public function setIdUser($id){
		$this->ID_USER=$id;
	}
	public function setNomUser($nom){
		$this->NOM_USER=$nom;
	}
	public function setPrenomUser($prenom){
		$this->PRENOM_USER=$prenom;
	}
	public function setName($name){
		$this->USER_NAME=$name;
	}
	public function setPass($pass){
		$this->PASSWORD=$pass;
	}
	public function setType($type){
		$this->TYPE=$type;
	}
	public function setPermission($p){
		$this->PERMISSION=$p;
	}
	public function setFichier($f){
		$this->fichier=$f;
	}
	public function setUrl($u){
		$this->url=$u;
	}
	public function setCon($con){
		$this->con=$con;
	}


	//Fonction affichage de tous les utilisateurs
	public function ListerTout(){
      $show=$this->con->prepare("SELECT * FROM user");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	public function ListerToutUser($id){
      $show=$this->con->prepare("SELECT * FROM user WHERE ID_USER='".$id."' ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	 //Fonction de creation d'un utilisateur
	public function Ajouter(){
	  $save=$this->con->prepare("INSERT INTO user(NOM_USER, PRENOM_USER, USER_NAME, PASSWORD, TYPE, PERMISSION,fichier,url)
	                             VALUES(?,?,?,?,?,?,?,?)");
      $save->execute(array($this->getNom(),
      	                   $this->getPrenom(),
      	                   $this->getName(),
      	                   $this->getPass(),
      	                   $this->getType(),
      	                   $this->getPermission(),
      	                   $this->getFichier(),
      	                   $this->getUrl()
      	               ));
      return $save?"ok":"error";
	}


	 //Fonction pour selectionner un utilisateur à editer
	public function getOne($code){
	  $one=$this->con->prepare(" SELECT * FROM user WHERE ID_USER='".$code."'");
	  $one->execute();
	  $un=$one->fetch();
	  return $un;
	}

    //Fonction pour mettre a jour un utilisateur
	public function desactiver($id){
	$up=$this->con->prepare("UPDATE user SET    PERMISSION='NON'
	                                            WHERE ID_USER='".$id."' ");
	$up->execute();
	return $up;	
	}


    //Fonction pour mettre a jour un utilisateur
	public function activer($id){
	$up=$this->con->prepare("UPDATE user SET    PERMISSION='OUI'
	                                            WHERE ID_USER='".$id."' ");
	$up->execute();
	return $up;	
	}

	//Fonction pour mettre a jour un utilisateur
	public function updateUser(){
	$up=$this->con->prepare("UPDATE user SET    USER_NAME='".$this->getName()."',
		                                        PASSWORD='".$this->getPass()."',
	                                            TYPE='".$this->getType()."',
	                                            fichier='".$this->getFichier()."',
	                                            url='".$this->getUrl()."'
	                                            WHERE ID_USER='".$this->getIdUser()."' ");
	$up->execute();
	return $up;	
	}

	//Fonction suppression d'un utilisateur
	public function delete($code){
	$del=$this->con->prepare("DELETE FROM user WHERE ID_USER='".$code."'");
	$del->execute();
	return $del;	
	}


}



 ?>