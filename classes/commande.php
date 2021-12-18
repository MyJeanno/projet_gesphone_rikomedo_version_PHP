<?php 
require_once ('../connexion/access.php');
class Commande
{
	private $ID_COM;
	private $NUM_COM;
	private $DATE_RECEPTION;
	private $MONTANT_COM;
	private $con=NULL;
	
	function __construct()
	{
	   if($this->con==NULL){
       $ac=new Access();
       $this->con=$ac->connection();
      }	

	}
    // Declaration des getteurs
	public function getIdCommande(){
		return $this->ID_COM;
	}
	public function getNumeroCommande(){
		return $this->NUM_COM;
	}
	public function getDateReception(){
		return $this->DATE_RECEPTION;
	}
	public function getMontantCommande(){
		return $this->MONTANT_COM;
	}
	public function getCon(){
		return $this->con;
	}

	//Declaration des setteurs
	public function setIdCommande($id){
      $this->ID_COM=$id;
	}
	public function setNumeroCommande($num){
      $this->NUM_COM=$num;
	}
	public function setDateReception($d){
      $this->DATE_RECEPTION=$d;
	}
	public function setMontantCommande($mont){
      $this->MONTANT_COM=$mont;
	}
	public function setCon($con){
      $this->con=$con;
	}

	
    //Fonction de creation d'un produit
	public function Ajouter(){
	  $save=$this->con->prepare("INSERT INTO commande(NUM_COM, DATE_RECEPTION, MONTANT_COM)
	                             VALUES(:num,:d,:mont)
	                            ");
      $save->execute(array(':num'=>$this->getNumeroCommande(),
      	                   ':d'=>$this->getDateReception(),
      	                   ':mont'=>$this->getMontantCommande()                           
      	                   ));
      return $save?"ok":"error";
	}

    //Fonction affichage de tous les clients
	public function ListerTout(){
      $show=$this->con->prepare("SELECT * FROM commande ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
	}

	public function updateCommande(){
	$up=$this->con->prepare("UPDATE commande SET NUM_COM='".$this->getNumeroCommande()."',
	                                             DATE_RECEPTION='".$this->getDateReception()."',
	                                             MONTANT_COM='".$this->getMontantCommande()."'
	                                             WHERE ID_COM='".$this->getIdCommande()."' ");
	$up->execute();
	return $up;	
	}

	public function delete($code){
	$del=$this->con->prepare("DELETE FROM commande WHERE ID_COM=trim('".$code."')");
	$del->execute();
	return $del;	
	}

	public function getOne($code){
	  $one=$this->con->prepare(" SELECT * FROM commande WHERE ID_COM='".$code."'");
	  $one->execute();
	  $un=$one->fetch();
	  return $un;
	}

	public function ListerCommande(){
      $show=$this->con->prepare("SELECT ID_COM, NUM_COM, DATE_RECEPTION FROM commande ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

	 public function ListerCommandeEncours(){
      $show=$this->con->prepare("SELECT ID_COM, NUM_COM FROM commande ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

}


 ?>