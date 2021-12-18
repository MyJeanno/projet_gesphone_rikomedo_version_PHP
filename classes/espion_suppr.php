<?php 
 require_once ('../connexion/access.php');
 //require_once ('user.php');
class Espion_suppr
{
	private $ID_SUPPR;
	private $ID_USER;
	private $DATE_SUPPR;
	private $MESSAGE
	private $con=NULL;
	
	function __construct()
	{
	   if($this->con==NULL){
       $ac=new Access();
       $this->con=$ac->connection();
      }	
       //$this->user= new user();
	}
    // Declaration des getteurs
	public function getIdSuppr(){
		return $this->ID_SUPPR;
	}
	public function getIdUser(){
		return $this->ID_USER;
	}
	public function getDateSuppr(){
		return $this->DATE_SUPPR;
	}
	public function getMessage(){
		return $this->MESSAGE;
	}
	public function getCon(){
		return $this->con;
	}

	//Declaration des setteurs
	public function setIdSuppr($id){
      $this->ID_SUPPR=$id;
	}
	public function setIdUser($code){
      $this->ID_USER=$code;
	}
	public function setDateSuppr($date){
      $this->DATE_SUPPR=$date;
	}
	public function setCon($con){
      $this->con=$con;
	}

	public function nowDate(){
    return date("Y-m-d H:i");
   } 

	
    //Fonction de creation d'un produit
	public function Ajouter($user,$connexion,$message){
	  $save=$this->con->prepare("INSERT INTO espion_suppr(ID_USER, DATE_SUPPR, MESSAGE)
	                             VALUES(:user,:dat,:mess)
	                            ");
      $save->execute(array(':user'=>$user,
                           ':dat'=>$connexion
                           ':mess'=>$message                            
      	                   ));
      return $save?"ok":"error";
	}

    //Fonction affichage de tous les clients
	public function ListerTout(){
      $show=$this->con->prepare("SELECT ID_SUPPR, NOM_USER, PRENOM_USER, DATE_SUPPR
      	                         FROM espion_suppr s, user u 
                                 WHERE s.ID_USER=u.ID_USER
                                 ORDER BY DATE_SUPPR DESC
      	                         ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

}


 ?>