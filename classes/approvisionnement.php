<?php 
require_once ('../connexion/access.php');
class Approvisionnement
{
	private $ID_APPRO;
  private $ID_USER;
	private $CODE_PROD;
  private $ID_COM;
	private $QTE_APPRO;
	private $TYPE_APPRO;
	private $DATE_APPRO;
  private $PROVENANCE;
	private $con=NULL;
	
	function __construct()
	{
	   if($this->con==NULL){
       $ac=new Access();
       $this->con=$ac->connection();
      }	

	}
    // Declaration des getteurs
	public function getIdAppro(){
		return $this->ID_APPRO;
	}
	public function getCodeProd(){
		return $this->CODE_PROD;
	}
  public function getIdUser(){
    return $this->ID_USER;
  }
  public function getIdCommande(){
    return $this->ID_COM;
  }
	public function getQteAppro(){
		return $this->QTE_APPRO;
	}
	public function getTypeAppro(){
		return $this->TYPE_APPRO;
	}
	public function getDateAppro(){
		return $this->DATE_APPRO;
	}
  public function getProvenance(){
    return $this->PROVENANCE;
  }
	public function getCon(){
		return $this->con;
	}

	//Declaration des setteurs
	public function setIdAppro($id){
      $this->ID_APPRO=$id;
	}
	public function setCodeProd($code){
      $this->CODE_PROD=$code;
	}
  public function setIdUser($id){
      $this->ID_USER=$id;
  }
  public function setIdCommande($id){
      $this->ID_COM=$id;
  }
	public function setQteAppro($qte){
      $this->QTE_APPRO=$qte;
	}
	public function setTypeAppro($type){
      $this->TYPE_APPRO=$type;
	}
	public function setDateAppro($date){
      $this->DATE_APPRO=$date;
	}
  public function setProvenance($p){
      $this->PROVENANCE=$p;
  }
	public function setCon($con){
      $this->con=$con;
	}

	public function nowDate(){
    return date("Y-m-d");
   } 

	
    //Fonction de creation d'un produit
	public function Ajouter(){
	  $save=$this->con->prepare("INSERT INTO approvisionnement(ID_USER,CODE_PROD, ID_COM, QTE_APPRO, TYPE_APPRO, DATE_APPRO,PROVENANCE)
	                             VALUES(?,?,?,?,?,?,?)
	                            ");
      $save->execute(array($this->getIdUser(),
                           $this->getCodeProd(),
                           $this->getIdCommande(),
                           $this->getQteAppro(),
                           $this->getTypeAppro(),
                           $this->getDateAppro(),
                           $this->getProvenance()                             
      	                   ));
      return $save?"ok":"error";
	}

    //Fonction affichage de tous les clients
	public function ListerTout(){
      $show=$this->con->prepare("SELECT ID_APPRO, PRENOM_USER, LIBELLE_PROD, QTE_APPRO, TYPE_APPRO, DATE_APPRO, NUM_COM
      	                         FROM approvisionnement a, produit p, commande c, user u
                                 WHERE a.CODE_PROD=p.CODE_PROD
                                 AND a.ID_COM = c.ID_COM 
                                 AND u.ID_USER = a.ID_USER 
                                 AND TYPE_APPRO = 'Gros' 
                                 AND DATE_APPRO = CURDATE()
                                 
                                 ORDER BY DATE_APPRO DESC
      	                         ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

  public function ListerApproCommande($num){
      $show=$this->con->prepare("SELECT p.CODE_PROD, LIBELLE_PROD, QTE_STOCK
                                 FROM approvisionnement a, produit p, commande c
                                 WHERE a.CODE_PROD=p.CODE_PROD
                                 AND a.ID_COM = c.ID_COM 
                                 AND TYPE_APPRO = 'Gros' 
                                 AND c.ID_COM = '".$num."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  public function ListerApproCommandeT($num){
      $show=$this->con->prepare("SELECT p.CODE_PROD, LIBELLE_PROD, QTE_STOCK, STOCK_DETAIL
                                 FROM approvisionnement a, produit p, commande c 
                                 WHERE a.CODE_PROD=p.CODE_PROD
                                 AND a.ID_COM = c.ID_COM 
                                 AND TYPE_APPRO = 'Gros' 
                                 AND c.ID_COM = '".$num."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  public function ListerApproCommande2($num){
      $show=$this->con->prepare("SELECT p.CODE_PROD, LIBELLE_PROD, PRIX_DETAIL, STOCK_DETAIL
                                 FROM approvisionnement a, produit p, commande c 
                                 WHERE a.CODE_PROD=p.CODE_PROD
                                 AND a.ID_COM = c.ID_COM 
                                 AND TYPE_APPRO = 'Detail' 
                                 AND c.ID_COM = '".$num."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  public function ApproParCommande($num){
      $show=$this->con->prepare("SELECT LIBELLE_PROD, SUM(QTE_APPRO) as total
                                 FROM approvisionnement a, produit p 
                                 WHERE a.CODE_PROD=p.CODE_PROD 
                                 AND ID_COM = '".$num."'
                                 AND PROVENANCE = 'A'
                                 GROUP BY LIBELLE_PROD
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

   public function TotalApproParCommande($num){
      $show=$this->con->prepare("SELECT SUM(QTE_APPRO) as total 
                                FROM approvisionnement 
                                WHERE ID_COM = '".$num."'
                                ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['total']."";
    } 
  }

	//Fonction affichage de tous les clients
	public function ListerToutAll(){
      $show=$this->con->prepare("SELECT ID_APPRO, LIBELLE_PROD, QTE_APPRO, TYPE_APPRO, DATE_APPRO
      	                         FROM approvisionnement a, produit p 
                                 WHERE a.CODE_PROD=p.CODE_PROD
                                 ORDER BY DATE_APPRO DESC
      	                         ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

  //Afficher libelle d'un produit
    public function LastNumCommande(){
      $show=$this->con->prepare("SELECT NUM_COM FROM commande WHERE ID_COM = (SELECT MAX(ID_COM) FROM Commande) ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NUM_COM']."";
    } 
  }

   public function ShowNumCommande($id){
      $show=$this->con->prepare("SELECT NUM_COM FROM commande WHERE ID_COM = '".$id."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NUM_COM']."";
    } 
  }

  public function ShowDateCommande($id){
      $show=$this->con->prepare("SELECT DATE_RECEPTION FROM commande WHERE ID_COM = '".$id."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['DATE_RECEPTION']."";
    } 
  }

  public function ListerCommande(){
      $show=$this->con->prepare("SELECT ID_COM, NUM_COM, DATE_RECEPTION FROM commande ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  public function showIdCommande($id){
      $show=$this->con->prepare("SELECT NUM_COM FROM commande WHERE ID_COM = '".$id."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NUM_COM']."";
    } 
  }

  public function LastIdCommande(){
      $show=$this->con->prepare("SELECT ID_COM FROM commande WHERE ID_COM = (SELECT MAX(ID_COM) FROM Commande) ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['ID_COM']."";
    } 
  }

  //Fonction affichage de tous les clients
  public function ListerToutDet(){
      $show=$this->con->prepare("SELECT ID_APPRO, PRENOM_USER, LIBELLE_PROD, QTE_APPRO, TYPE_APPRO, DATE_APPRO, NUM_COM
                                 FROM approvisionnement a, produit p, commande c, user u
                                 WHERE a.CODE_PROD=p.CODE_PROD 
                                 AND a.ID_COM = c.ID_COM 
                                 AND u.ID_USER = a.ID_USER 
                                 AND TYPE_APPRO = 'Detail' 
                                 AND DATE_APPRO = CURDATE()
                                
                                 ORDER BY DATE_APPRO DESC
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }



	//Fonction pour mettre a jour un le stock d'un produit
	public function updateStockProduit($prod,$qte,$price){
	$up=$this->con->prepare("UPDATE produit SET QTE_STOCK=QTE_STOCK + '".$qte."',PRIX_DETAIL='".$price."',ACTIF='Oui' WHERE CODE_PROD='".$prod."' ");
	$up->execute();
	return $up;	
	}

	//Fonction pour mettre a jour un le stock d'un produit
	public function updateStockProduitDetail($prod,$qte,$price){
	$up=$this->con->prepare("UPDATE produit SET STOCK_DETAIL=STOCK_DETAIL + '".$qte."',PRIX_DETAIL='".$price."',ACTIF='Oui' WHERE CODE_PROD='".$prod."' ");
	$up->execute();
	return $up;	
	}

	//Fonction pour mettre a jour un produit
	public function updateApprovi(){
	$up=$this->con->prepare("UPDATE approvisionnement SET QTE_APPRO='".$this->getQteAppro()."', 
				                                          DATE_APPRO='".$this->getDateAppro()."'           
				                                          WHERE ID_APPRO='".$this->getIdAppro()."' ");
	$up->execute();
	return $up;	
	}

	//Afficher libelle d'un produit
    public function showQteAppro($id){
      $show=$this->con->prepare("SELECT QTE_APPRO FROM approvisionnement WHERE ID_APPRO='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['QTE_APPRO']."";
    } 
  }

  public function ListerNomPhone(){
      $show=$this->con->prepare("SELECT CODE_PROD, LIBELLE_PROD FROM produit ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Afficher libelle d'un produit
    public function showIdProduit($id){
      $show=$this->con->prepare("SELECT CODE_PROD FROM approvisionnement WHERE ID_APPRO='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['CODE_PROD']."";
    } 
  }

	//Fonction suppression d'un client
	public function delete($code){
	$del=$this->con->prepare("DELETE FROM approvisionnement WHERE ID_APPRO='".$code."'");
	$del->execute();
	return $del;	
	}

	 //Fonction pour selectionner un produit à editer
	public function getOne($code){
	  $one=$this->con->prepare(" SELECT * FROM approvisionnement WHERE ID_APPRO='".$code."'");
	  $one->execute();
	  $un=$one->fetch();
	  return $un;
	}

	//Afficher libelle d'un produit
    public function showLibelleProduit($id){
      $show=$this->con->prepare("SELECT LIBELLE_PROD FROM produit WHERE CODE_PROD='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['LIBELLE_PROD']."";
    } 
  }

	//Afficher libelle d'un produit
    public function showNomClient(){
      $show=$this->con->prepare("SELECT NOM_CLI FROM client");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NOM_CLI']."";
    } 
  }

  //Fonction affichage des ventes au cours d'une periode donnée
  public function QteApproPeriodique($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d"); 
      $show=$this->con->prepare("SELECT p.CODE_PROD,LIBELLE_PROD,SUM(QTE_APPRO) as quantite
                                 FROM approvisionnement a, produit p 
                                 WHERE a.CODE_PROD=p.CODE_PROD 
                                 AND TYPE_APPRO='Gros'
                                 AND DATE_APPRO BETWEEN '".$d1_traite."' AND '".$d2_traite."'
                                 AND PROVENANCE = 'A'
                                 GROUP BY p.CODE_PROD
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage des ventes au cours d'une periode donnée
  public function QteApproPeriodiqueDet($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d"); 
      $show=$this->con->prepare("SELECT p.CODE_PROD,LIBELLE_PROD,SUM(QTE_APPRO) as quantite
                                 FROM approvisionnement a, produit p 
                                 WHERE a.CODE_PROD=p.CODE_PROD 
                                 AND TYPE_APPRO='Detail'
                                 AND DATE_APPRO BETWEEN '".$d1_traite."' AND '".$d2_traite."'
                                 AND PROVENANCE = 'A'
                                 GROUP BY p.CODE_PROD
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

   //Calcule du prix total de vente garde au cours d'une periode
   function PrixPeriodeAppro($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT SUM(MONT_ENC) as somme
                                 FROM client c, encaissement e
                                 WHERE e.NUM_CLI=c.NUM_CLI
                                 AND DATE_ENC BETWEEN '".$d1_traite."' AND '".$d2_traite."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }

  //Calcule du prix total de vente garde au cours d'une periode
   function TotalPeriodeAppro($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT SUM(PRIX_DETAIL*QTE_APPRO) as somme
                                 FROM approvisionnement a, produit p 
                                 WHERE a.CODE_PROD=p.CODE_PROD AND TYPE_APPRO='Gros'
                                 AND DATE_APPRO BETWEEN '".$d1_traite."' AND '".$d2_traite."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }

  //Calcule du prix total de vente garde au cours d'une periode
   function TotalPeriodeApproDet($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT SUM(PRIX_DETAIL*QTE_APPRO) as somme
                                 FROM approvisionnement a, produit p 
                                 WHERE a.CODE_PROD=p.CODE_PROD AND TYPE_APPRO='Detail'
                                 AND DATE_APPRO BETWEEN '".$d1_traite."' AND '".$d2_traite."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }

	//Afficher libelle d'un produit
    public function showProduit(){
      $show=$this->con->prepare("SELECT ID_PROD, DESIGNATION FROM produit");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }


}


 ?>