<?php 
//require_once ('../connexion/access.php');
//require_once ('user.php');
class Session
{
	private $ID_SESSION;
	private $ID_USER;
	private $DATE_CONNEXION;
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
	public function getIdSession(){
		return $this->ID_SESSION;
	}
	public function getIdUser(){
		return $this->ID_USER;
	}
	public function getDateConnexion(){
		return $this->DATE_CONNEXION;
	}
	public function getCon(){
		return $this->con;
	}

	//Declaration des setteurs
	public function setIdSession($id){
      $this->ID_SESSION=$id;
	}
	public function setIdUser($code){
      $this->ID_USER=$code;
	}
	public function setDateConnexion($date){
      $this->DATE_CONNEXION=$date;
	}
	public function setCon($con){
      $this->con=$con;
	}

	public function nowDate(){
    return date("Y-m-d H:i");
   } 

	
    //Fonction de creation d'un produit
	public function Ajouter($user,$connexion){
	  $save=$this->con->prepare("INSERT INTO session(ID_USER, DATE_CONNEXION)
	                             VALUES(:user,:dat)
	                            ");
      $save->execute(array(':user'=>$user,
                           ':dat'=>$connexion                            
      	                   ));
      return $save?"ok":"error";
	}

    //Fonction affichage de tous les clients
	public function ListerTout(){
      $show=$this->con->prepare("SELECT ID_SESSION, NOM_USER, PRENOM_USER, DATE_CONNEXION
      	                         FROM session s, user u 
                                 WHERE s.ID_USER=u.ID_USER
                                 ORDER BY DATE_CONNEXION DESC
      	                         ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	public function showTotalVteModif(){
      $show=$this->con->prepare("SELECT SUM(PRIX_MODIFIE-PRIX_INITIAL) 
      	                         FROM espion_suppr 
      	                         WHERE ORIGINE = 'V'
      	                         ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(PRIX_MODIFIE-PRIX_INITIAL)']."";
    } 
  }

	public function ListerUserControle2(){
      $show=$this->con->prepare("SELECT ID_SUPPR,PRENOM_USER,DATE_SUPPR,PROD_MODIFIE,PRIX_INITIAL,LIB_PROD,PRIX_MODIFIE,MESSAGE,
      	                         ELEMENT_CIBLE
      	                         FROM espion_suppr s, user u
                                 WHERE s.ID_USER=u.ID_USER
                                 AND MESSAGE = 'Approvisionnement modifié'
                                 ORDER BY DATE_SUPPR DESC
      	                         ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	//Fonction affichage de tous les clients
	public function ListerUserControle(){
      $show=$this->con->prepare("SELECT NOM_USER, PRENOM_USER, DATE_SUPPR, MESSAGE, ELEMENT_CIBLE
      	                         FROM espion_suppr s, user u 
                                 WHERE s.ID_USER=u.ID_USER
                                 ORDER BY DATE_SUPPR DESC
      	                         ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	//Fonction suppression d'un client
	public function delete($code){
	$del=$this->con->prepare("DELETE FROM approvisionnement WHERE ID_APPRO='".$code."'");
	$del->execute();
	return $del;	
	}

}


 ?>