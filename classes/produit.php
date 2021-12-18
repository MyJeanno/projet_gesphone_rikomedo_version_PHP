<?php 
require_once ('../connexion/access.php');
class Produit
{
	private $CODE_PROD;
	private $LIBELLE_PROD;
	private $PRIX_DETAIL;
	private $QTE_STOCK;
	private $STOCK_DETAIL;
	private $con=NULL;
	
	function __construct()
	{
	   if($this->con==NULL){
       $ac=new Access();
       $this->con=$ac->connection();
      }	
	}
    // Declaration des getteurs
	public function getCodeProd(){
		return $this->CODE_PROD;
	}
	public function getLibelleProd(){
		return $this->LIBELLE_PROD;
	}
	public function getPrixDetailProd(){
		return $this->PRIX_DETAIL;
	}
	public function getStockProd(){
		return $this->QTE_STOCK;
	}
	public function getStockProdDetail(){
		return $this->STOCK_DETAIL;
	}
	public function getCon(){
		return $this->con;
	}

	//Declaration des setteurs
	public function setCodeProd($code){
      $this->CODE_PROD=$code;
	}
	public function setLibelleProd($lib){
      $this->LIBELLE_PROD=$lib;
	}
	public function setPrixDetailProd($prixd){
      $this->PRIX_DETAIL=$prixd;
	}
	public function setStockProd($stock){
      $this->QTE_STOCK=$stock;
	}
	public function setStockProdDetail($detail){
      $this->STOCK_DETAIL=$detail;
	}
	public function setCon($con){
      $this->con=$con;
	}

	//Implementation du CRUD 

    //Fonction de creation d'un produit
	public function Ajouter(){
	  $save=$this->con->prepare("INSERT INTO produit(LIBELLE_PROD,PRIX_DETAIL,QTE_STOCK,STOCK_DETAIL)
	                             VALUES(:lib,:prid,:qte,:detail)");
      $p=$save->execute(array(':lib'=>$this->getLibelleProd(),
                           ':prid'=>$this->getPrixDetailProd(),
                           ':qte'=>$this->getStockProd(),
                           ':detail'=>$this->getStockProdDetail()  	                   
      	                   ));
      return $save?"ok":"error";
	}

	//Fonction de creation d'un produit
   public function AjouterSuppression($user,$connexion,$prod,$pinitial,$prodf,$pmodif,$message,$cible,$origine){
    $save=$this->con->prepare("INSERT INTO espion_suppr(ID_USER, DATE_SUPPR, PROD_MODIFIE,PRIX_INITIAL,LIB_PROD,PRIX_MODIFIE,MESSAGE, ELEMENT_CIBLE,ORIGINE)
                               VALUES(?,?,?,?,?,?,?,?,?)
                              ");
      $save->execute(array($user,$connexion,$prod,$pinitial,$prodf,$pmodif,$message,$cible,$origine 
                           ));
      return $save?"ok":"error";
  }

    //Fonction affichage de tous les produits
	public function ListerTout(){
      $show=$this->con->prepare("SELECT * FROM produit");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	//Fonction affichage de tous les produits
	public function ListerToutActif(){
      $show=$this->con->prepare("SELECT * FROM produit WHERE ACTIF='Oui'");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	public function ProduitApprovisionner(){
      $show=$this->con->prepare("SELECT * FROM produit WHERE QTE_STOCK >0 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	public function ProduitApproDetail(){
      $show=$this->con->prepare("SELECT * FROM produit WHERE STOCK_DETAIL >0 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	//Fonction affichage de tous les produits
	public function SeuiApprovi(){
      $show=$this->con->prepare("SELECT * FROM produit WHERE ACTIF = 'Oui' AND QTE_STOCK <= 5 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	//Fonction affichage de tous les produits
	public function SeuiApproviDet(){
      $show=$this->con->prepare("SELECT * FROM produit WHERE ACTIF = 'Oui' AND STOCK_DETAIL <= 2 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	//Fonction pour mettre a jour un produit
	public function updateProduit(){
	$up=$this->con->prepare("UPDATE produit SET LIBELLE_PROD='".$this->getLibelleProd()."',
	                                            PRIX_DETAIL='".$this->getPrixDetailProd()."'	
	                                            WHERE CODE_PROD='".$this->getCodeProd()."' ");
	$up->execute();
	return $up;	
	}

	//Fonction pour mettre a jour un produit
	public function updateStockProduit($qte,$id){
	$up=$this->con->prepare("UPDATE produit SET QTE_STOCK=((QTE_STOCK)+('".$qte."'))
	                                            WHERE CODE_PROD='".$id."' ");
	$up->execute();
	return $up;	
	}

	//Fonction pour mettre a jour un produit
	public function updateStockProduitTranfert($qte,$id){
	$up=$this->con->prepare("UPDATE produit SET QTE_STOCK=((QTE_STOCK)+('".$qte."')), STOCK_DETAIL=((STOCK_DETAIL)-('".$qte."'))
	                                            WHERE CODE_PROD='".$id."' ");
	$up->execute();
	return $up;	
	}

	//Fonction pour mettre a jour un produit
	public function updateStockProduitTranfert2($qte,$id){
	$up=$this->con->prepare("UPDATE produit SET QTE_STOCK=((QTE_STOCK)-('".$qte."')), STOCK_DETAIL=((STOCK_DETAIL)+('".$qte."'))
	                                            WHERE CODE_PROD='".$id."' ");
	$up->execute();
	return $up;	
	}

	//Fonction pour mettre a jour un produit
	public function updateStockProduitDet($qte,$id){
	$up=$this->con->prepare("UPDATE produit SET STOCK_DETAIL=((STOCK_DETAIL)+('".$qte."'))
	                                            WHERE CODE_PROD='".$id."' ");
	$up->execute();
	return $up;	
	}

	 //Fonction2 pour mettre a jour un le stock d'un produit après une suppression 
	public function updateStockProduitDelete($qte,$id){
	$up=$this->con->prepare("UPDATE produit SET QTE_STOCK=((QTE_STOCK)-('".$qte."'))
	                                            WHERE CODE_PROD='".$id."' ");
	$up->execute();
	return $up;	
	}

	 //Fonction2 pour mettre a jour un le stock d'un produit après une suppression 
	public function updateStockProduitDeleteTransfert($qte,$id){
	$up=$this->con->prepare("UPDATE produit SET QTE_STOCK=((QTE_STOCK)-('".$qte."')), STOCK_DETAIL=STOCK_DETAIL+'".$qte."'
	                                            WHERE CODE_PROD='".$id."' ");
	$up->execute();
	return $up;	
	}

	 //Fonction2 pour mettre a jour un le stock d'un produit après une suppression 
	public function updateStockProduitDeleteTransfert2($qte,$id){
	$up=$this->con->prepare("UPDATE produit SET QTE_STOCK=((QTE_STOCK)+('".$qte."')), STOCK_DETAIL=STOCK_DETAIL-'".$qte."'
	                                          WHERE CODE_PROD='".$id."' ");
	$up->execute();
	return $up;	
	}

	//Fonction2 pour mettre a jour un le stock d'un produit après une suppression 
	public function updateStockProduitDeleteDet($qte,$id){
	$up=$this->con->prepare("UPDATE produit SET STOCK_DETAIL=((STOCK_DETAIL)-('".$qte."'))
	                                            WHERE CODE_PROD='".$id."' ");
	$up->execute();
	return $up;	
	}

	//Fonction suppression d'un produit
	public function delete($code){
	$del=$this->con->prepare("DELETE FROM produit WHERE CODE_PROD='".$code."'");
	$del->execute();
	return $del;	
	}

	 //Fonction pour selectionner un produit à editer
	public function getOne($code){
	  $one=$this->con->prepare(" SELECT * FROM produit WHERE CODE_PROD='".$code."'");
	  $one->execute();
	  $un=$one->fetch();
	  return $un;
	}

	 //Fonction affichage de tous les produits
	public function ListerLibelleProduit(){
      $show=$this->con->prepare("SELECT LIBELLE_PROD FROM produit");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
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
      $show=$this->con->prepare("SELECT LIBELLE_PROD FROM produit WHERE CODE_PROD='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['LIBELLE_PROD']."";
    } 
  }

  //Afficher libelle d'un produit
    public function showStockProduit($id){
      $show=$this->con->prepare("SELECT QTE_STOCK FROM produit WHERE CODE_PROD='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['QTE_STOCK']."";
    } 
  }

  //Afficher libelle d'un produit
    public function showStockProduit2($id){
      $show=$this->con->prepare("SELECT STOCK_DETAIL FROM produit WHERE CODE_PROD='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['STOCK_DETAIL']."";
    } 
  }

  //Afficher libelle d'un produit
    public function PrixTotalStockProduit(){
      $show=$this->con->prepare("SELECT SUM(QTE_STOCK*PRIX_DETAIL) as somme FROM produit ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }


}


 ?>