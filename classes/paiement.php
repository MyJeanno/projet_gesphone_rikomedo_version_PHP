<?php 
require_once ('../connexion/access.php');
class Paiement
{
  	private $ID_PAIE;
  	private $ID_ACTION;
    private $LIBELLE_MOIS;
    private $MOIS_FIN;
    private $LIBELLE_ANNE;
    private $DATE_PAIE;
    private $MONTANT;
    private $ETAT_PAIEMENT;
	  private $con=Null;
	
	function __construct()
	{
		if($this->con==NULL){
       $ac=new Access();
       $this->con=$ac->connection();
      }	
	}
    
    //Declaration des getteurs
	public function getIdPaiement(){
		return $this->ID_PAIE;
	}
  public function getIdAction(){
    return $this->ID_ACTION;
  }
  public function getMoisPaiement(){
    return $this->LIBELLE_MOIS;
  }
   public function getMoisPaiementFinal(){
    return $this->MOIS_FIN;
  }
  public function getAnnePaiement(){
    return $this->LIBELLE_ANNE;
  }
	public function getDatePaiement(){
    return $this->DATE_PAIE;
  }	
  public function getCommissionMois(){
    return $this->MONTANT;
  } 
   public function getEtatPaie(){
    return $this->ETAT_PAIEMENT;
  } 
	public function getCon(){
		return $this->con;
	}

	//Declaration des setteurs
    public function setIdPaiment($id){
     $this->ID_PAIE=$id;
    }
    public function setIdAction($idA){
     $this->ID_ACTION=$idA;
    }
     public function setMoisPaiement($mois){
     $this->LIBELLE_MOIS=$mois;
    }
    public function setMoisPaiementFinal($final){
     $this->MOIS_FIN=$final;
    }
    public function setAnneePaiement($annee){
     $this->LIBELLE_ANNE=$annee;
    }
    public function setDatePaiement($date){
      $this->DATE_PAIE=$date;
	   }
    public function setMontantPaiement($mont){
      $this->MONTANT=$mont;
    }
    public function setEtatpaie($etat){
      $this->ETAT_PAIEMENT=$etat;
    }
  public function setCon($con){
     $this->con=$con;
  }

  //Fonction de creation d'une nouvelle dotation
	public function Ajouter(){
	  $save=$this->con->prepare("INSERT INTO paiement(ID_ACTION, LIBELLE_MOIS, MOIS_FIN, LIBELLE_ANNE, DATE_PAIE,MONTANT,ETAT_PAIEMENT)
	                             VALUES(:id,:mois,:fin,:annee,:d,:mont,:etat)");
      $save->execute(array(':id'=>$this->getIdAction(),
                           ':mois'=>$this->getMoisPaiement(),
                           ':fin'=>$this->getMoisPaiementFinal(),
                           ':annee'=>$this->getAnnePaiement(),
      	                   ':d'=>$this->getDatePaiement(),
                           ':mont'=>$this->getCommissionMois(),
                           ':etat'=>$this->getEtatPaie()
                         ));    
      return $save?"ok":"error";
	}

  public function updateEtatPaiement($id){
  $up=$this->con->prepare("UPDATE paiement SET ETAT_PAIEMENT ='Payé' WHERE ID_PAIE='".$id."' ");
  $up->execute();
  return $up; 
  }

   public function updateEtatPaiement2($id){
  $up=$this->con->prepare("UPDATE paiement SET ETAT_PAIEMENT ='Calculé' WHERE ID_PAIE='".$id."' ");
  $up->execute();
  return $up; 
  }

  //Fonction affichage de toutes les dotations
  public function ListerTout(){
      $show=$this->con->prepare("SELECT ID_PAIE,NOM_ACTION,PRENOM_ACTION,LIBELLE_MOIS,MOIS_FIN,LIBELLE_ANNE,DATE_PAIE,MONTANT,ETAT_PAIEMENT
                                 FROM actionnaire a,paiement p 
                                 WHERE a.ID_ACTION=p.ID_ACTION AND ETAT_PAIEMENT='Calculé'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

   //Fonction affichage de toutes les dotations
  public function ListerToutBis(){
      $show=$this->con->prepare("SELECT ID_PAIE,NOM_ACTION,PRENOM_ACTION,LIBELLE_MOIS,MOIS_FIN,LIBELLE_ANNE,DATE_PAIE,MONTANT,ETAT_PAIEMENT
                                 FROM actionnaire a,paiement p 
                                 WHERE a.ID_ACTION=p.ID_ACTION AND ETAT_PAIEMENT='Payé'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction pour selectionner un produit à editer
  public function getOne($code){
    $one=$this->con->prepare(" SELECT * FROM paiement WHERE ID_PAIE='".$code."'");
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

   public function delete($code){
  $del=$this->con->prepare("DELETE FROM paiement WHERE ID_PAIE=trim('".$code."')");
  $del->execute();
  return $del;  
  }

  //Fonction pour mettre a jour une dotation
  public function updatePaiement(){
  $up=$this->con->prepare("UPDATE paiement SET ID_ACTION='".$this->getIdAction()."',
                                                LIBELLE_MOIS='".$this->getMoisPaiement()."',
                                                MOIS_FIN='".$this->getMoisPaiementFinal()."',
                                                LIBELLE_ANNE='".$this->getAnnePaiement()."',
                                                DATE_PAIE='".$this->getDatePaiement()."',
                                                MONTANT='".$this->getCommissionMois()."'
                                                WHERE ID_PAIE='".$this->getIdPaiement()."' ");
  $up->execute();
  return $up; 
  }

   public function ListerPaieMois($mois){
      $show=$this->con->prepare("SELECT ID_PAIE,NOM_ACTION,PRENOM_ACTION,LIBELLE_MOIS,LIBELLE_ANNE,DATE_PAIE,MONTANT,ETAT_PAIEMENT
                                 FROM actionnaire a,paiement p 
                                 WHERE a.ID_ACTION=p.ID_ACTION AND LIBELLE_MOIS='".$mois."' AND ETAT_PAIEMENT ='Payé'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

   public function TotalCommission($mois){
      $show=$this->con->prepare("SELECT SUM(MONTANT) FROM paiement WHERE LIBELLE_MOIS='".$mois."' AND ETAT_PAIEMENT ='Payé' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(MONTANT)']."";
    } 
  }

  public function ShowLastMonth($id){
      $show=$this->con->prepare("SELECT MOIS_FIN FROM paiement WHERE ID_PAIE=(select MAX(ID_PAIE) from paiement WHERE ID_ACTION='".$id."')");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['MOIS_FIN']."";
    } 
  }

  public function ShowIdMonth($lib){
      $show=$this->con->prepare("SELECT ID_MOIS FROM mois WHERE LIBELLE_MOIS='".$lib."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['ID_MOIS']."";
    } 
  }

  public function ShowMoisSignature($id){
      $show=$this->con->prepare("SELECT MONTH(DATE_OPE) FROM operation WHERE ID_ACTION='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['MONTH(DATE_OPE)']."";
    } 
  }

  public function ShowNextMonth($id){
      $show=$this->con->prepare("SELECT LIBELLE_MOIS FROM mois WHERE ID_MOIS='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['LIBELLE_MOIS']."";
    } 
  }

  public function ShowTotalCommission(){
      $show=$this->con->prepare("SELECT SUM(MONTANT) FROM paiement WHERE ETAT_PAIEMENT='Calculé' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(MONTANT)']."";
    } 
  }

  public function ShowTotalCommPayer(){
      $show=$this->con->prepare("SELECT SUM(MONTANT) FROM paiement WHERE ETAT_PAIEMENT='Payé' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(MONTANT)']."";
    } 
  }

  public function MoisPaie($id){
      $show=$this->con->prepare("SELECT LIBELLE_MOIS FROM paiement WHERE ID_PAIE='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['LIBELLE_MOIS']."";
    } 
  }

  public function MoisPaieFinal($id){
      $show=$this->con->prepare("SELECT MOIS_FIN FROM paiement WHERE ID_PAIE='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['MOIS_FIN']."";
    } 
  }

  public function AnneePaie($id){
      $show=$this->con->prepare("SELECT LIBELLE_ANNE FROM paiement WHERE ID_PAIE='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['LIBELLE_ANNE']."";
    } 
  }

  public function CommissionPaie($id){
      $show=$this->con->prepare("SELECT MONTANT FROM paiement WHERE ID_PAIE='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['MONTANT']."";
    } 
  }

  public function IdActionPaie($id){
      $show=$this->con->prepare("SELECT ID_ACTION FROM paiement WHERE ID_PAIE='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['ID_ACTION']."";
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

  public function showSoldeActionnaire($code){
      $show=$this->con->prepare("SELECT SOLDE_ACTION FROM actionnaire WHERE ID_ACTION='".$code."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SOLDE_ACTION']."";
    } 
  }

  public function showTauxActionnaire($code){
      $show=$this->con->prepare("SELECT TAUX FROM actionnaire WHERE ID_ACTION='".$code."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['TAUX']."";
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


  //Fonction affichage de tous les clients
  public function ListerMoisEdit(){
      $show=$this->con->prepare("SELECT LIBELLE_MOIS FROM mois ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage de tous les clients
  public function ListerAnneeEdit(){
      $show=$this->con->prepare("SELECT LIBELLE_ANNE FROM annee ");
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

   public function ListerMois(){
      $show=$this->con->prepare("SELECT ID_MOIS, LIBELLE_MOIS FROM mois");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  public function ListerAnnee(){
      $show=$this->con->prepare("SELECT ID_ANNEE, LIBELLE_ANNE FROM annee");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  public function showLastOpera($code){
      $show=$this->con->prepare("SELECT MONTANT_OPE FROM operation WHERE ID_OPE='".$code."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['MONTANT_OPE']."";
    } 
  }
}


 ?>