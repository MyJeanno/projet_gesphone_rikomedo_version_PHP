<?php 
require_once ('../connexion/access.php');
class Depense
{
	private $CODE_DEP;
	private $MOTIF_DEP;
	private $DATE_DEP;
	private $MONTANT_DEP;
	private $con=NULL;
	
	function __construct()
	{
	   if($this->con==NULL){
       $ac=new Access();
       $this->con=$ac->connection();
      }	

	}
    // Declaration des getteurs
	public function getCodeDep(){
		return $this->CODE_DEP;
	}
	public function getMotifDep(){
		return $this->MOTIF_DEP;
	}
	public function getDateDep(){
		return $this->DATE_DEP;
	}
	public function getMontantDep(){
		return $this->MONTANT_DEP;
	}
	public function getCon(){
		return $this->con;
	}

	//Declaration des setteurs
	public function setCodeDep($code){
      $this->CODE_DEP=$code;
	}
	public function setMotifDep($motif){
      $this->MOTIF_DEP=$motif;
	}
	public function setDateDep($date){
      $this->DATE_DEP=$date;
	}
	public function setMontantDep($mont){
      $this->MONTANT_DEP=$mont;
	}
	public function setCon($con){
      $this->con=$con;
	}

	//Implementation du CRUD 

    //Fonction de creation d'un produit
	public function Ajouter(){
	  $save=$this->con->prepare("INSERT INTO depense(MOTIF_DEP,DATE_DEP,MONTANT_DEP)
	                             VALUES(:motif,:dat,:mont)");
      $save->execute(array(':motif'=>$this->getMotifDep(),
                           ':dat'=>$this->getDateDep(),
                           ':mont'=>$this->getMontantDep()  	                   
      	                   ));
      return $save?"ok":"error";
	}

    //Fonction affichage de tous les produits
	public function ListerTout(){
      $show=$this->con->prepare("SELECT * FROM depense WHERE DATE_DEP=CURDATE()");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	//Fonction pour mettre a jour un produit
	public function updateDepense(){
	$up=$this->con->prepare("UPDATE depense SET MOTIF_DEP='".$this->getMotifDep()."',
	                                            DATE_DEP='".$this->getDateDep()."',
	                                            MONTANT_DEP='".$this->getMontantDep()."'	                                        
	                                            WHERE CODE_DEP='".$this->getCodeDep()."' ");
	$up->execute();
	return $up;	
	}

	//Fonction suppression d'un produit
	public function delete($code){
	$del=$this->con->prepare("DELETE FROM depense WHERE CODE_DEP='".$code."'");
	$del->execute();
	return $del;	
	}

	 //Fonction pour selectionner un produit à editer
	public function getOne($code){
	  $one=$this->con->prepare(" SELECT * FROM depense WHERE CODE_DEP='".$code."'");
	  $one->execute();
	  $un=$one->fetch();
	  return $un;
	}

	//Calcul du total des depenses du jour
    public function showTotalDepJour(){
      $show=$this->con->prepare("SELECT SUM(MONTANT_DEP) FROM depense WHERE DATE_DEP=CURDATE()");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(MONTANT_DEP)']."";
    } 
  }

	//Fonction affichage des ventes au cours d'une periode donnée
    public function DepensePeriodique($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d"); 
      $show=$this->con->prepare("SELECT * FROM depense 
                                 WHERE DATE_DEP BETWEEN '".$d1_traite."' AND '".$d2_traite."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Calcule du prix total de vente garde au cours d'une periode
   function TotalDepensePeriode($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT SUM(MONTANT_DEP) as somme
                                 FROM depense
                                 WHERE DATE_DEP BETWEEN '".$d1_traite."' AND '".$d2_traite."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }

	//Afficher libelle d'un produit
    public function showProduit(){
      $show=$this->con->prepare("SELECT CODE_PROD, DESIGNATION FROM produit");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Afficher libelle d'un produit
    public function showLibelleProduit($id){
      $show=$this->con->prepare("SELECT DESIGNATION FROM produit WHERE CODE_PROD='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['DESIGNATION']."";
    } 
  }

	


}


 ?>