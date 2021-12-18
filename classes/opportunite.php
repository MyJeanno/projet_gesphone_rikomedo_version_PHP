<?php 
require_once ('../connexion/access.php');
class Opportunite
{
  	private $ID_OPP;
  	private $ID_ACTION;
    private $DATE_DEBUT;
    private $DATE_FIN;
    private $NBRE_JOUR;
    private $MONTANT_OPP;
    private $TAUX;
    private $COMMISSION;
    private $DATE_CLOTURE;
    private $ETAT_OPP;
	  private $con=Null;
	
	function __construct()
	{
		if($this->con==NULL){
       $ac=new Access();
       $this->con=$ac->connection();
      }	
	}
    
    //Declaration des getteurs
	public function getIdOpportunite(){
		return $this->ID_OPP;
	}
  public function getIdAction(){
    return $this->ID_ACTION;
  }
  public function getDateDebut(){
    return $this->DATE_DEBUT;
  }
  public function getDateFin(){
    return $this->DATE_FIN;
  }
	public function getNbreJour(){
    return $this->NBRE_JOUR;
  }	
  public function getMontOpportunite(){
    return $this->MONTANT_OPP;
  } 
  public function getTauxOpportunite(){
    return $this->TAUX;
  } 
  public function getCommission(){
    return $this->COMMISSION;
  } 
  public function getDateCloture(){
    return $this->DATE_CLOTURE;
  } 
  public function getEtatOpportuinite(){
    return $this->ETAT_OPP;
  } 
	public function getCon(){
		return $this->con;
	}

	//Declaration des setteurs
    public function setIdOpportunite($id){
     $this->ID_OPP=$id;
    }
    public function setIdAction($idA){
     $this->ID_ACTION=$idA;
    }
     public function setDateDebut($dateD){
     $this->DATE_DEBUT=$dateD;
    }
    public function setDateFin($dateF){
     $this->DATE_FIN=$dateF;
    }
    public function setNbreJour($nbre){
      $this->NBRE_JOUR=$nbre;
	  }
    public function setMontOpportunite($mont){
      $this->MONTANT_OPP=$mont;
    }
    public function setTauxOpportunite($tx){
      $this->TAUX=$tx;
    }
    public function setCommission($comm){
      $this->COMMISSION=$comm;
    }
    public function setDateCloture($dcl){
      $this->DATE_CLOTURE=$dcl;
    }
    public function setEtatOpportunite($etat){
      $this->ETAT_OPP=$etat;
    }
    public function setCon($con){
     $this->con=$con;
  }

  //Fonction de creation d'une nouvelle dotation
	public function Ajouter(){
	  $save=$this->con->prepare("INSERT INTO opportunite(ID_ACTION, DATE_DEBUT, DATE_FIN, NBRE_JOUR,MONTANT_OPP,TAUX,COMMISSION,ETAT_OPP)
	                             VALUES(:id,:debut,:fin,:jour,:mont,:tx,:com,:et)");
      $save->execute(array(':id'=>$this->getIdAction(),
                           ':debut'=>$this->getDateDebut(),
                           ':fin'=>$this->getDateFin(),
      	                   ':jour'=>$this->getNbreJour(),
                           ':mont'=>$this->getMontOpportunite(),
                           ':tx'=>$this->getTauxOpportunite(),
                           ':com'=>$this->getCommission(),
                           ':et'=>$this->getEtatOpportuinite()
                         )); 
     
      return $save?"ok":"error";                       
	}

  //Fonction pour mettre a jour une dotation
  public function updateOpportunite(){
  $up=$this->con->prepare("UPDATE opportunite SET NBRE_JOUR='".$this->getNbreJour()."',
                                                  TAUX='".$this->getTauxOpportunite()."',
                                                  COMMISSION='".$this->getCommission()."',
                                                  DATE_CLOTURE='".$this->getDateCloture()."',
                                                  ETAT_OPP='".$this->getEtatOpportuinite()."'
                                                  WHERE ID_OPP='".$this->getIdOpportunite()."' ");
  $up->execute();
  return $up; 
  }

  public function updateEtatOpportune($id){
  $up=$this->con->prepare("UPDATE opportunite SET ETAT_OPP ='Cloturé' WHERE ID_OPP='".$id."' ");
  $up->execute();
  return $up; 
  }

  public function updateEtatOpportune2($id){
  $up=$this->con->prepare("UPDATE opportunite SET ETAT_OPP ='Calculé' WHERE ID_OPP='".$id."' ");
  $up->execute();
  return $up; 
  }

  public function TotalOppOuverte(){
      $show=$this->con->prepare("SELECT SUM(MONTANT_OPP) FROM opportunite WHERE ETAT_OPP='Ouvert' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(MONTANT_OPP)']."";
    } 
  }

  public function TotalOppCalculer(){
      $show=$this->con->prepare("SELECT SUM(MONTANT_OPP) FROM opportunite WHERE ETAT_OPP='Calculé' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(MONTANT_OPP)']."";
    } 
  }

   public function TotalCommOppCalculer(){
      $show=$this->con->prepare("SELECT SUM(COMMISSION) FROM opportunite WHERE ETAT_OPP='Calculé' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(COMMISSION)']."";
    } 
  }

  public function TotalCommOppayer(){
      $show=$this->con->prepare("SELECT SUM(COMMISSION) FROM opportunite WHERE ETAT_OPP='Cloturé' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(COMMISSION)']."";
    } 
  }

  //Fonction affichage de toutes les dotations
  public function ListerTout(){
      $show=$this->con->prepare("SELECT ID_OPP,NOM_ACTION,PRENOM_ACTION,DATE_DEBUT,DATE_FIN,MONTANT_OPP,COMMISSION,ETAT_OPP
                                 FROM actionnaire a,opportunite o
                                 WHERE a.ID_ACTION=o.ID_ACTION AND ETAT_OPP='Ouvert'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage de toutes les dotations
  public function ListerToutCloture(){
      $show=$this->con->prepare("SELECT ID_OPP,NOM_ACTION,PRENOM_ACTION,DATE_DEBUT,DATE_FIN,MONTANT_OPP,COMMISSION,DATE_CLOTURE,NBRE_JOUR,ETAT_OPP
                                 FROM actionnaire a,opportunite o
                                 WHERE a.ID_ACTION=o.ID_ACTION AND ETAT_OPP='Calculé'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

   //Fonction affichage de toutes les dotations
  public function ListerToutCloture2(){
      $show=$this->con->prepare("SELECT ID_OPP,NOM_ACTION,PRENOM_ACTION,DATE_DEBUT,DATE_FIN,MONTANT_OPP,COMMISSION,DATE_CLOTURE,ETAT_OPP
                                 FROM actionnaire a,opportunite o
                                 WHERE a.ID_ACTION=o.ID_ACTION AND ETAT_OPP='Cloturé'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

   public function IdActionOpp($id){
      $show=$this->con->prepare("SELECT ID_ACTION FROM opportunite WHERE ID_OPP='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['ID_ACTION']."";
    } 
  }

   public function DateDebut($id){
      $show=$this->con->prepare("SELECT DATE_DEBUT FROM opportunite WHERE ID_OPP='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['DATE_DEBUT']."";
    } 
  }

  public function DateFin($id){
      $show=$this->con->prepare("SELECT DATE_CLOTURE FROM opportunite WHERE ID_OPP='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['DATE_CLOTURE']."";
    } 
  }

  public function MontantCommission($id){
      $show=$this->con->prepare("SELECT MONTANT_OPP FROM opportunite WHERE ID_OPP='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['MONTANT_OPP']."";
    } 
  }

  public function commission($id){
      $show=$this->con->prepare("SELECT COMMISSION FROM opportunite WHERE ID_OPP='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['COMMISSION']."";
    } 
  }

  public function nbrejour($id){
      $show=$this->con->prepare("SELECT NBRE_JOUR FROM opportunite WHERE ID_OPP='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NBRE_JOUR']."";
    } 
  }


   //Fonction pour selectionner un produit à editer
  public function getOne($code){
    $one=$this->con->prepare(" SELECT * FROM opportunite WHERE ID_OPP='".$code."'");
    $one->execute();
    $un=$one->fetch();
    return $un;
  }

  //Fonction pour selectionner un produit à editer
  public function getOne2($code){
    $one=$this->con->prepare(" SELECT * FROM actionnaire WHERE ID_ACTION='".$code."'");
    $one->execute();
    $un=$one->fetch();
    return $un;
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


  public function showLastOpera($code){
      $show=$this->con->prepare("SELECT MONTANT_OPE FROM operation WHERE ID_OPE='".$code."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['MONTANT_OPE']."";
    } 
  }

  public function showNomActionnaire($code){
      $show=$this->con->prepare("SELECT NOM_ACTION FROM actionnaire WHERE ID_ACTION='".$code."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NOM_ACTION']."";
    } 
  }

   public function showPrenomActionnaire($code){
      $show=$this->con->prepare("SELECT PRENOM_ACTION FROM actionnaire WHERE ID_ACTION='".$code."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['PRENOM_ACTION']."";
    } 
  }
	
}



 ?>