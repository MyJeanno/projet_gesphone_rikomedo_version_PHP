<?php 
require_once ('../connexion/access.php');
require_once("../mailer/class.phpmailer.php"); 
require_once("../mailer/class.smtp.php");
class Actionnaire
{
  	private $ID_ACTION;
  	private $NOM_ACTION;
    private $PRENOM_ACTION;
    private $CONTACT;
    private $SOLDE_ACTION;
  	private $SOLDE_OPORT;
  	private $TAUX;
	  private $con=Null;
	
	function __construct()
	{
		if($this->con==NULL){
       $ac=new Access();
       $this->con=$ac->connection();
      }	
	}
    
    //Declaration des getteurs
	public function getIdAction(){
		return $this->ID_ACTION;
	}
  public function getNomAction(){
    return $this->NOM_ACTION;
  }
  public function getPrenomAction(){
    return $this->PRENOM_ACTION;
  }
  public function getContact(){
    return $this->CONTACT;
  }
	public function getSoldeAction(){
    return $this->SOLDE_ACTION;
  }
  public function getSoldeOpportunite(){
    return $this->SOLDE_OPORT;
  }
	public function getTauxAction(){
		return $this->TAUX;
	}	
	public function getCon(){
		return $this->con;
	}

	//Declaration des setteurs
    public function setIdAction($id){
     $this->ID_ACTION=$id;
    }
    public function setNomAction($nom){
     $this->NOM_ACTION=$nom;
    }
     public function setPrenomAction($prenom){
     $this->PRENOM_ACTION=$prenom;
    }
    public function setContact($contact){
     $this->CONTACT=$contact;
    }
    public function setSoldeAction($solde){
      $this->SOLDE_ACTION=$solde;
	}
  public function setSoldeOpportunite($opp){
      $this->SOLDE_OPORT=$opp;
  }
  public function setTauxAction($taux){
     $this->TAUX=$taux;
  } 
  public function setCon($con){
     $this->con=$con;
  }

  //Fonction de creation d'une nouvelle dotation
	public function Ajouter(){
	  $save=$this->con->prepare("INSERT INTO actionnaire(NOM_ACTION, PRENOM_ACTION, CONTACT, SOLDE_ACTION, SOLDE_OPORT,TAUX)
	                             VALUES(:nom,:prenom,:cont,:solde,:oppo,:tx)");
      $save->execute(array(':nom'=>$this->getNomAction(),
                           ':prenom'=>$this->getPrenomAction(),
                           ':cont'=>$this->getContact(),
      	                   ':solde'=>$this->getSoldeAction(),
      	                   ':oppo'=>$this->getSoldeOpportunite(),
                           ':tx'=>$this->getTauxAction()
                         ));    
      return $save?"ok":"error";
	}

  //Fonction affichage de toutes les dotations
  public function ListerTout(){
      $show=$this->con->prepare("SELECT * FROM actionnaire WHERE SOLDE_ACTION > 0");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  public function ListerTout2(){
      $show=$this->con->prepare("SELECT * FROM actionnaire");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

	//Fonction pour mettre a jour une dotation
	public function updateActionnaire(){
	$up=$this->con->prepare("UPDATE actionnaire SET NOM_ACTION='".$this->getNomAction()."',
      		                                        PRENOM_ACTION='".$this->getPrenomAction()."',
                                                  CONTACT='".$this->getContact()."',
                                                  TAUX='".$this->getTauxAction()."'
                                                  WHERE ID_ACTION='".$this->getIdAction()."' ");
	$up->execute();
	return $up;	
	}

  //Fonction suppression d'un client
  public function delete($code){
  $del=$this->con->prepare("DELETE FROM actionnaire WHERE ID_ACTION=trim('".$code."')");
  $del->execute();
  return $del;  
  }

   //Fonction pour selectionner un produit à editer
  public function getOne($code){
    $one=$this->con->prepare(" SELECT * FROM actionnaire WHERE ID_ACTION='".$code."'");
    $one->execute();
    $un=$one->fetch();
    return $un;
  }
	
}



 ?>