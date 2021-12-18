<?php 
require_once ('../connexion/access.php');
class Operation
{
  	private $ID_OPE;
  	private $ID_ACTION;
    private $DATE_OPE;
    private $TYPE_OPE;
    private $MONTANT_OPE;
	  private $con=Null;
	
	function __construct()
	{
		if($this->con==NULL){
       $ac=new Access();
       $this->con=$ac->connection();
      }	
	}
    
    //Declaration des getteurs
	public function getIdOperation(){
		return $this->ID_OPE;
	}
  public function getIdAction(){
    return $this->ID_ACTION;
  }
  public function getDateOperation(){
    return $this->DATE_OPE;
  }
  public function getTypeOperation(){
    return $this->TYPE_OPE;
  }
	public function getMontantOperation(){
    return $this->MONTANT_OPE;
  }	
	public function getCon(){
		return $this->con;
	}

	//Declaration des setteurs
    public function setIdOperation($id){
     $this->ID_OPE=$id;
    }
    public function setIdAction($idA){
     $this->ID_ACTION=$idA;
    }
     public function setDateOperation($date){
     $this->DATE_OPE=$date;
    }
    public function setTypeOperation($type){
     $this->TYPE_OPE=$type;
    }
    public function setMontantOperation($montant){
      $this->MONTANT_OPE=$montant;
	}
  public function setCon($con){
     $this->con=$con;
  }

  //Fonction de creation d'une nouvelle dotation
	public function Ajouter(){
	  $save=$this->con->prepare("INSERT INTO operation(ID_ACTION, DATE_OPE, TYPE_OPE, MONTANT_OPE)
	                             VALUES(:id,:d,:type,:mont)");
      $save->execute(array(':id'=>$this->getIdAction(),
                           ':d'=>$this->getDateOperation(),
                           ':type'=>$this->getTypeOperation(),
      	                   ':mont'=>$this->getMontantOperation()
                         ));    
      return $save?"ok":"error";
	}

  //Fonction affichage de toutes les dotations
  public function ListerTout(){
      $show=$this->con->prepare("SELECT ID_OPE,NOM_ACTION,PRENOM_ACTION,DATE_OPE,TYPE_OPE,MONTANT_OPE
                                 FROM actionnaire a,operation e 
                                 WHERE a.ID_ACTION=e.ID_ACTION AND TYPE_OPE='DEPOT'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

   public function RecuDepotClient($id){
      $show=$this->con->prepare("SELECT ID_OPE,NOM_ACTION,PRENOM_ACTION,DATE_OPE,TYPE_OPE,MONTANT_OPE
                                 FROM actionnaire a,operation e 
                                 WHERE a.ID_ACTION=e.ID_ACTION AND ID_OPE='".$id."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  public function IdActionPaie($id){
      $show=$this->con->prepare("SELECT ID_ACTION FROM operation WHERE ID_OPE='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['ID_ACTION']."";
    } 
  }

   public function TotalDepot(){
      $show=$this->con->prepare("SELECT SUM(MONTANT_OPE) FROM operation");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(MONTANT_OPE)']."";
    } 
  }

  public function showSoldeActionnaire($code){
      $show=$this->con->prepare("SELECT SOLDE_ACTION FROM actionnaire WHERE ID_ACTION='".$code."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SOLDE_ACTION']."";
    } 
  }

  public function ListerToutRetrait(){
      $show=$this->con->prepare("SELECT ID_OPE,NOM_ACTION,PRENOM_ACTION,DATE_OPE,TYPE_OPE,MONTANT_OPE
                                 FROM actionnaire a,operation e 
                                 WHERE a.ID_ACTION=e.ID_ACTION AND TYPE_OPE='RETRAIT'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

	//Fonction pour mettre a jour une dotation
	public function updateOperation(){
	$up=$this->con->prepare("UPDATE operation SET ID_ACTION='".$this->getIdAction()."',
      		                                        DATE_OPE='".$this->getDateOperation()."',
                                                  TYPE_OPE='".$this->getTypeOperation()."',
                                                  MONTANT_OPE='".$this->getMontantOperation()."'
                                                  WHERE ID_OPE='".$this->getIdOperation()."' ");
	$up->execute();
	return $up;	
	}

  //Fonction pour mettre a jour une dotation
  public function updateSoldeActionnaire($mont,$id){
  $up=$this->con->prepare("UPDATE actionnaire SET SOLDE_ACTION=SOLDE_ACTION+'".$mont."' WHERE ID_ACTION='".$id."' ");
  $up->execute();
  return $up; 
  }

  //Fonction pour mettre a jour une dotation
  public function updateDepotAction($mont,$id){
  $up=$this->con->prepare("UPDATE actionnaire SET SOLDE_ACTION=SOLDE_ACTION+'".$mont."' WHERE ID_ACTION='".$id."' ");
  $up->execute();
  return $up; 
  }

  //Fonction pour mettre a jour une dotation
  public function updateRetrait($mont,$id){
  $up=$this->con->prepare("UPDATE actionnaire SET SOLDE_ACTION=SOLDE_ACTION-'".$mont."' WHERE ID_ACTION='".$id."' ");
  $up->execute();
  return $up; 
  }

  //Fonction affichage de tous les clients
  public function ListerNomPrenomActionnaire(){
      $show=$this->con->prepare("SELECT ID_ACTION,NOM_ACTION,PRENOM_ACTION FROM actionnaire ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction suppression d'un client
  public function delete($code){
  $del=$this->con->prepare("DELETE FROM operation WHERE ID_OPE=trim('".$code."')");
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

  //Fonction pour selectionner un produit à editer
  public function getOne2($code){
    $one=$this->con->prepare(" SELECT * FROM operation WHERE ID_OPE='".$code."'");
    $one->execute();
    $un=$one->fetch();
    return $un;
  }

  public function showLastOpera($code){
      $show=$this->con->prepare("SELECT MONTANT_OPE FROM operation WHERE ID_OPE='".$code."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['MONTANT_OPE']."";
    } 
  }

  public function showNomActionnaire($id){
      $show=$this->con->prepare("SELECT NOM_ACTION FROM actionnaire WHERE ID_ACTION='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NOM_ACTION']."";
    } 
  }

   public function showPrenomActionnaire($id){
      $show=$this->con->prepare("SELECT PRENOM_ACTION FROM actionnaire WHERE ID_ACTION='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['PRENOM_ACTION']."";
    } 
  }
	
}



 ?>