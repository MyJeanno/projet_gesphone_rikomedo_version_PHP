<?php 
require_once ('../connexion/access.php');
class Message
{
	private $ID_MESSAGE;
	private $ID_USER;
	private $DESTINATAIRE;
	private $CONTENU;
	private $DATE_ENVOI;
	private $ETAT_MESSAGE;
	private $con=null;
	
	function __construct()
	{
		 if($this->con==NULL){
       $ac=new Access();
       $this->con=$ac->connection();
      }	
	}

	public function getIdMessage(){
		return $this->ID_MESSAGE;
	}
	public function getIdUser(){
		return $this->ID_USER;
	}
	public function getDestinataire(){
		return $this->DESTINATAIRE;
	}
	public function getContenu(){
		return $this->CONTENU;
	}
	public function getDateEnvoi(){
		return $this->DATE_ENVOI;
	}
	public function getEtatMessage(){
		return $this->ETAT_MESSAGE;
	}
	public function getCon(){
		return $this->con;
	}

	public function setIdMessage($id){
		$this->ID_MESSAGE=$id;
	}
	public function setIdUser($user){
		$this->ID_USER=$user;
	}
	public function setDestinataire($d){
		$this->DESTINATAIRE=$d;
	}
	public function setContenu($c){
		$this->CONTENU=$c;
	}
	public function setDateEnvoi($de){
		$this->DATE_ENVOI=$de;
	}
	public function setEtatMessage($et){
		$this->ETAT_MESSAGE=$et;
	}
	public function setCon($con){
		$this->con=$con;
	}

	public function nowDate(){
    return date("Y-m-d H:i:s");
   }

	public function Ajouter(){
	  $save=$this->con->prepare("INSERT INTO message(ID_USER,DESTINATAIRE,CONTENU,DATE_ENVOI,ETAT_MESSAGE)
	                             VALUES(?,?,?,?,?)
	                            ");
      $save->execute(array($this->getIdUser(),
                           $this->getDestinataire(),
                           $this->getContenu(),
                           $this->getDateEnvoi(),
                           $this->getEtatMessage()                           
      	                   ));
      return $save?"ok":"error";
	}

	public function ListerUserAdmin(){
      $show=$this->con->prepare("SELECT ID_USER, NOM_USER, PRENOM_USER FROM user");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  public function ListerUser(){
      $show=$this->con->prepare("SELECT ID_USER, NOM_USER, PRENOM_USER FROM user WHERE TYPE='Admin'");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  public function updateMessage($sender,$receveur){
	$up=$this->con->prepare("UPDATE message SET ETAT_MESSAGE='Lu'
	                                        WHERE ID_USER='".$sender."'
	                                        AND DESTINATAIRE='".$receveur."'"
	                                        );
	$up->execute();
	return $up;	
	}


	public function ListerTout($moi,$autre){
      $show=$this->con->prepare("SELECT m.ID_USER,NOM_USER,PRENOM_USER,DESTINATAIRE,CONTENU,DATE_ENVOI,url
                                 FROM message m, user u 
                                 WHERE m.ID_USER = u.ID_USER
                                 AND DESTINATAIRE = '".$moi."'
                                 AND m.ID_USER = '".$autre."'
                                 UNION 
         						 SELECT m.ID_USER,NOM_USER,PRENOM_USER,DESTINATAIRE,CONTENU,DATE_ENVOI,url
                                 FROM message m, user u 
                                 WHERE m.ID_USER = u.ID_USER
                                 AND DESTINATAIRE = '".$autre."'
                                 AND m.ID_USER = '".$moi."'
                                 ORDER BY DATE_ENVOI ASC
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	public function ListerUserMessage($id){
      $show=$this->con->prepare("SELECT m.ID_USER,NOM_USER,PRENOM_USER,DESTINATAIRE,CONTENU,DATE_ENVOI,url
                                 FROM message m, user u 
                                 WHERE m.ID_USER = u.ID_USER
                                 AND DESTINATAIRE = '".$id."'
                                 AND ETAT_MESSAGE = 'Non lu'
                                 GROUP BY m.ID_USER
                                 ORDER BY DATE_ENVOI DESC
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	 public function messageNonLu($id){
      $show=$this->con->prepare("SELECT count(DISTINCT m.ID_USER) as total
                                 FROM message m, user u 
                                 WHERE m.ID_USER = u.ID_USER
                                 AND DESTINATAIRE = '".$id."'
                                 AND ETAT_MESSAGE = 'Non lu'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['total']."";
    } 
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

	
}



 ?>