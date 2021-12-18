<?php 
require_once ('../connexion/access.php');
class Transfert
{
	private $CODE_TRANSF;
  private $CODE_PROD;
	private $DATE_TRANSF;
	private $QTE_TRANSF;
  private $DESTINATION;
	private $con=NULL;
	
	function __construct()
	{
	   if($this->con==NULL){
       $ac=new Access();
       $this->con=$ac->connection();
      }	

	}
    // Declaration des getteurs
	public function getIdTransf(){
		return $this->CODE_TRANSF;
	}
  public function getCodeProd(){
    return $this->CODE_PROD;
  }
	public function getDateTransf(){
		return $this->DATE_TRANSF;
	}
	public function getQteTransf(){
		return $this->QTE_TRANSF;
	}
  public function getDestinationTransf(){
    return $this->DESTINATION;
  }
  public function getCon(){
		return $this->con;
	}

	//Declaration des setteurs
	public function setIdTransf($id){
      $this->CODE_TRANSF=$id;
	}
  public function setCodeProd($code){
      $this->CODE_PROD=$code;
  }
	public function setDateTransf($date){
      $this->DATE_TRANSF=$date;
	}
	public function setQteTransf($qte){
      $this->QTE_TRANSF=$qte;
	}
  public function setDestinationTransf($dest){
      $this->DESTINATION=$dest;
  }
	public function setCon($con){
      $this->con=$con;
	}

	public function nowDate(){
    return date("Y-m-d H:i");
   } 

	
	public function Ajouter(){
	  $save=$this->con->prepare("INSERT INTO transfert(CODE_PROD,DATE_TRANSF,QTE_TRANSF,DESTINATION)
	                             VALUES(:cod,:dat,:qte,:type)
	                            ");
      $save->execute(array(':cod'=>$this->getCodeProd(),
                           ':dat'=>$this->getDateTransf(),
                           ':qte'=>$this->getQteTransf(),
                           ':type'=>$this->getDestinationTransf()                           
      	                   ));
      return $save?"ok":"error";
	}

    //Fonction affichage de tous les clients
	public function ListerTout(){
      $show=$this->con->prepare("SELECT CODE_TRANSF, LIBELLE_PROD, QTE_TRANSF, DATE_TRANSF, DESTINATION
                                 FROM transfert t, produit p 
                                 WHERE t.CODE_PROD=p.CODE_PROD
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	//Fonction pour mettre a jour un produit
	public function updateTransfert(){
	$up=$this->con->prepare("UPDATE transfert SET QTE_TRANSF='".$this->getQteTransf()."', 
                                                DESTINATION='".$this->getDestinationTransf()."'           
				                                        WHERE CODE_TRANSF='".$this->getIdTransf()."' ");
	$up->execute();
	return $up;	
	}

	//Afficher libelle d'un produit
    public function showQteTransfert($id){
      $show=$this->con->prepare("SELECT QTE_TRANSF FROM transfert WHERE CODE_TRANSF='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['QTE_TRANSF']."";
    } 
  }

  //Afficher libelle d'un produit
    public function showIdProduit($id){
      $show=$this->con->prepare("SELECT CODE_PROD FROM transfert WHERE CODE_TRANSF='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['CODE_PROD']."";
    } 
  }

  //Afficher libelle d'un produit
    public function showTypeTransfert($id){
      $show=$this->con->prepare("SELECT DESTINATION FROM transfert WHERE CODE_TRANSF='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['DESTINATION']."";
    } 
  }

  public function inserrerAppro($user,$prod,$com,$qte,$type,$dtr,$prov){
    $save=$this->con->prepare("INSERT INTO approvisionnement(ID_USER,CODE_PROD,ID_COM,QTE_APPRO,TYPE_APPRO,DATE_APPRO,PROVENANCE)
                               VALUES(?,?,?,?,?,?,?)");
      $save->execute(array($user,$prod,$com,$qte,$type,$dtr,$prov));
      return $save?"ok":"error";
  }

	//Fonction suppression d'un client
	public function delete($code){
	$del=$this->con->prepare("DELETE FROM transfert WHERE CODE_TRANSF='".$code."'");
	$del->execute();
	return $del;	
	}

	 //Fonction pour selectionner un produit à editer
	public function getOne($code){
	  $one=$this->con->prepare(" SELECT * FROM transfert WHERE CODE_TRANSF='".$code."'");
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
    public function showProduit(){
      $show=$this->con->prepare("SELECT ID_PROD, DESIGNATION FROM produit");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }


}


 ?>