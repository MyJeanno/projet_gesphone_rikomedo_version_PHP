<?php 
require_once ('../connexion/access.php');
require_once ('produit.php');
require_once ('client.php');
require_once("../mailer/class.phpmailer.php"); 
require_once("../mailer/class.smtp.php");
class Vente
{
  	private $ID_VENTE;
  	private $NUM_CLI;
    private $NUM_ID;
    private $NUM_ID_VTE;
    private $NUM_ID_DET;
    private $ID_USER;
  	private $CODE_PROD;
    private $ID_COM;
  	private $DATE_VENTE;
    private $HEURE_VENTE;
    private $QTE_VENTE;
    private $PRIX_REMISE;
    private $PRIX_GROS;
    private $PRIX_TOTAL;
    private $MONT_PAYE;
    private $TYPE_VENTE;
    private $ETAT_TELEPHONE;
    private $COULEUR_TEL;
    private $MEMOIRE_TEL;
    private $ETAT_VENTE;
    private $IMEI_TELEPHONE;
    private $CIVILITE_CLIENT;
    private $CLIENT_DETAIL;
    private $SOLDE_VENTE;
    private $CONFIRMATION_VENTE;
	  private $con=Null;
	
	function __construct()
	{
		if($this->con==NULL){
       $ac=new Access();
       $this->con=$ac->connection();
      }	
       $this->prod= new produit();
       $this->cli= new client();	  
	}
    
    //Declaration des getteurs
  public function getIdUser(){
    return $this->ID_USER;
  }
	public function getIdVente(){
		return $this->ID_VENTE;
	}
  public function getNumVente(){
    return $this->NUM_ID;
  }
  public function getNumVente2(){
    return $this->NUM_ID_VTE;
  }
  public function getNumVenteDetail(){
    return $this->NUM_ID_DET;
  }
	public function getNumClient(){
    return $this->NUM_CLI;
  }
  public function getCodeProd(){
    return $this->CODE_PROD;
  }
  public function getIdCommande(){
    return $this->ID_COM;
  }
	public function getDateVente(){
		return $this->DATE_VENTE;
	}	
  public function getHeureVente(){
    return $this->HEURE_VENTE;
  } 
  public function getQuantite(){
    return $this->QTE_VENTE;
  }
  public function getPrixRemise(){
    return $this->PRIX_REMISE;
  }
  public function getPrixGros(){
    return $this->PRIX_GROS;
  }
  public function getPrixTotal(){
    return $this->PRIX_TOTAL;
  }
  public function getMontPayer(){
    return $this->MONT_PAYE;
  }
  public function getTypeVente(){
    return $this->TYPE_VENTE;
  }
  public function getEtatTelephone(){
    return $this->ETAT_TELEPHONE;
  }
  public function getCouleurTelephone(){
    return $this->COULEUR_TEL;
  }
  public function getMemoireTelephone(){
    return $this->MEMOIRE_TEL;
  }
  public function getEtatVte(){
    return $this->ETAT_VENTE;
  }
  public function getIMEI(){
    return $this->IMEI_TELEPHONE;
  }
  public function getCiviliteClient(){
    return $this->CIVILITE_CLIENT;
  }
  public function getClientDetail(){
    return $this->CLIENT_DETAIL;
  }
  public function getSoldeVente(){
    return $this->SOLDE_VENTE;
  }
  public function getConfirmationVente(){
    return $this->CONFIRMATION_VENTE;
  }
	public function getCon(){
		return $this->con;
	}

	//Declaration des setteurs
    public function setIdUser($id){
    $this->ID_USER=$id;
  }
    public function setIdVente($id){
     $this->ID_VENTE=$id;
    }
    public function setNumVente($vte){
     $this->NUM_ID=$vte;
    }
     public function setNumVente2($vte2){
     $this->NUM_ID_VTE=$vte2;
    }
    public function setNumVenteDetail($det){
     $this->NUM_ID_DET=$det;
    }
    public function setNumClient($num){
      $this->NUM_CLI=$num;
	}
  public function setCodeProd($code){
      $this->CODE_PROD=$code;
  }
  public function setIdCommande($c){
      $this->ID_COM=$c;
  }
    public function setDateVente($date){
     $this->DATE_VENTE=$date;
    } 
    public function setHeureVente($heure){
     $this->HEURE_VENTE=$heure;
    } 
    public function setQuantite($qte){
     $this->QTE_VENTE=$qte;
    }
    public function setPrixRemise($pr){
     $this->PRIX_REMISE=$pr;
    }
    public function setPrixGros($pri){
     $this->PRIX_GROS=$pri;
    }
    public function setPrixTotal($total){
     $this->PRIX_TOTAL=$total;
    }
     public function setMontPayer($mont){
     $this->MONT_PAYE=$mont;
    }
    public function setTypeVente($type){
     $this->TYPE_VENTE=$type;
    }
    public function setEtatVte($etat){
     $this->ETAT_VENTE=$etat;
    }
    public function setEtatTelephone($phone){
     $this->ETAT_TELEPHONE=$phone;
    }
    public function setCouleurTelephone($couleur){
     $this->COULEUR_TEL=$couleur;
    }
    public function setMemoireTelephone($memoire){
     $this->MEMOIRE_TEL=$memoire;
    }
    public function setIMEI($imei){
     $this->IMEI_TELEPHONE=$imei;
    }
    public function setCiviliteClient($civil){
     $this->CIVILITE_CLIENT=$civil;
    }
    public function setClientDetail($client){
     $this->CLIENT_DETAIL=$client;
    }
    public function setSoldeVente($solde){
     $this->SOLDE_VENTE=$solde;
    }
    public function setConfirmationVente($conf){
     $this->CONFIRMATION_VENTE=$conf;
    }
    public function setCon($con){
     $this->con=$con;
    }

    //Implementation du CRUD 

    public function nowDate(){
    return date("Y-m-d");
   }

   public function nowDate2(){
    return date("d-m-Y");
   } 

   public function nowHour(){
    return date("H:i:s");
   } 

    //Fonction conversion en lettre
public $leChiffreSaisi;
public $enLettre='';
public $chiffre=array(1=>"un",2=>"deux",3=>"trois",4=>"quatre",5=>"cinq",6=>"six",7=>"sept",8=>"huit",9=>"neuf",10=>"dix",11=>"onze",12=>"douze",13=>"treize",14=>"quatorze",15=>"quinze",16=>"seize",17=>"dix-sept",18=>"dix-huit",19=>"dix-neuf",20=>"vingt",30=>"trente",40=>"quarante",50=>"cinquante",60=>"soixante",70=>"soixante-dix",80=>"quatre-vingt",90=>"quatre-vingt-dix");
#Fonction de conversion appelée dans la feuille principale
function Conversion($sasie)
{
$this->enLettre='';
$sasie=trim($sasie);

#suppression des espaces qui pourraient exister dans la saisie
$nombre='';
$laSsasie=explode(' ',$sasie);
foreach ($laSsasie as $partie)
$nombre.=$partie;

#suppression des zéros qui précéderaient la saisie
$nb=strlen($nombre);
for ($i=0;$i<=$nb;)
{
if(substr($nombre,$i,1)==0)
{
$nombre=substr($nombre,$i+1);
$nb=$nb-1;
}
elseif(substr($nombre,$i,1)<>0)
{
$nombre=substr($nombre,$i);
break;
}
}
#echo $nombre;
#$this->SupZero($nombre);
#le nombre de caract que comporte le nombre saisi de sa forme sans espace et sans 0 au début
$nb=strlen($nombre);
#echo $nb.'<br/ >';
#$this->leChiffreSaisi=$nombre;
#conversion du chiffre saisi en lettre selon les cas
switch ($nb)
{
case 0:
$this->enLettre='zéro';
case 1:
if ($nombre==0)
{
$this->enLettre='zéro';
break;
}
elseif($nombre<>0)
{
$this->Unite($nombre);
break;
}

case 2:
$unite=substr($nombre,1);
$dizaine=substr($nombre,0,1);
$this->Dizaine(0,$nombre,$unite,$dizaine);
break;

case 3:
$unite=substr($nombre,2);
$dizaine=substr($nombre,1,1);
$centaine=substr($nombre,0,1);
$this->Centaine(0,$nombre,$unite,$dizaine,$centaine);
break;

#cas des milles
case ($nb>3 and $nb<=6):
$unite=substr($nombre,$nb-1);
$dizaine=substr($nombre,($nb-2),1);
$centaine=substr($nombre,($nb-3),1);
$mille=substr($nombre,0,($nb-3));
$this->Mille($nombre,$unite,$dizaine,$centaine,$mille);
break;

#cas des millions
case ($nb>6 and $nb<=9):
$unite=substr($nombre,$nb-1);
$dizaine=substr($nombre,($nb-2),1);
$centaine=substr($nombre,($nb-3),1);
$mille=substr($nombre,-6);
$million=substr($nombre,0,$nb-6);
$this->Million($nombre,$unite,$dizaine,$centaine,$mille,$million);
break;

#cas des milliards
/*case ($nb>9 and $nb<=12):
$unite=substr($nombre,$nb-1);
$dizaine=substr($nombre,($nb-2),1);
$centaine=substr($nombre,($nb-3),1);
$mille=substr($nombre,-6);
$million=substr($nombre,-9);
$milliard=substr($nombre,0,$nb-9);
Milliard($nombre,$unite,$dizaine,$centaine,$mille,$million,$milliard);
break;*/

}
if (!empty($this->enLettre))
  return $this->enLettre;
}

#Gestion des miiliards
/*
function Milliard($nombre,$unite,$dizaine,$centaine,$mille,$million,$milliard)
{

}
*/

#Gestion des millions

function Million($nombre,$unite,$dizaine,$centaine,$mille,$million)
{
#si les mille comportent un seul chiffre
#$cent represente les 3 premiers chiffres du chiffre ex: 321 dans 12502321
#$mille represente les 3 chiffres qui suivent les cents ex: 502 dans 12502321
#reste represente les 6 premiers chiffres du chiffre ex: 502321 dans 12502321

$cent=substr($nombre,-3);
$reste=substr($nombre,-6);

if (strlen($million)==1)
{
$mille=substr($nombre,1,3);
$this->enLettre.=$this->chiffre[$million];
  if ($million == 1){
    $this->enLettre.=' million ';
  }else{
    $this->enLettre.=' millions ';
  }
}
elseif (strlen($million)==2)
{
$mille=substr($nombre,2,3);
$nombre=substr($nombre,0,2);
//echo $nombre;
$this->Dizaine(0,$nombre,$unite,$dizaine);
$this->enLettre.='millions ';
}
elseif (strlen($million)==3)
{
$mille=substr($nombre,3,3);
$nombre=substr($nombre,0,3);
$this->Centaine(0,$nombre,$unite,$dizaine,$centaine);
$this->enLettre.='millions ';
}

#recuperation des cens dans nombre

#suppression des zéros qui précéderaient le $reste
$nb=strlen($reste);
for ($i=0;$i<=$nb;)
{
if(substr($reste,$i,1)==0)
{
$reste=substr($reste,$i+1);
$nb=$nb-1;
}
elseif(substr($reste,$i,1)<>0)
{
$reste=substr($reste,$i);
break;
}
}
$nb=strlen($reste);
#si tous les chiffres apres les milions =000000 on affiche x million
if ($nb==0)
;
else
{
#Gestion des milles
#suppression des zéros qui précéderaient les milles dans $mille
$nb=strlen($mille);
for ($i=0;$i<=$nb;)
{
if(substr($mille,$i,1)==0)
{
$mille=substr($mille,$i+1);
$nb=$nb-1;
}
elseif(substr($mille,$i,1)<>0)
{
$mille=substr($mille,$i);
break;
}
}
#le nombre de caract que comporte le nombre saisi de sa forme sans espace et sans 0 au début
$nb=strlen($mille);
#echo '<br />nb='.$nb.'<br />';
if ($nb==0)
;
#AffichageResultat($enLettre);
elseif ($nb==1)
{
if ($mille==1)
$this->enLettre.='mille ';
else
{
$this->Unite($mille);
$this->enLettre.='mille ';
}
}
elseif ($nb==2)
{
$this->Dizaine(1,$mille,$unite,$dizaine);
$this->enLettre.='mille ';
}
elseif ($nb==3)
{
$this->Centaine(1,$mille,$unite,$dizaine,$centaine);
$this->enLettre.='mille ';
}
#Gestion des cents
#suppression des zéros qui précéderaient les cents dans $cent
$nb=strlen($cent);
for ($i=0;$i<=$nb;)
{
if(substr($cent,$i,1)==0)
{
$cent=substr($cent,$i+1);
$nb=$nb-1;
}
elseif(substr($cent,$i,1)<>0)
{
$cent=substr($cent,$i);
break;
}
}
#le nombre de caract que comporte le nombre saisi de sa forme sans espace et sans 0 au début
$nb=strlen($cent);
#echo '<br />nb='.$nb.'<br />';
if ($nb==0)
;
#AffichageResultat($enLettre);
elseif ($nb==1)
$this->Unite($cent);
elseif ($nb==2)
$this->Dizaine(0,$cent,$unite,$dizaine);
elseif ($nb==3)
$this->Centaine(0,$cent,$unite,$dizaine,$centaine);
}
}

#Gestion des milles

function Mille($nombre,$unite,$dizaine,$centaine,$mille)
{
#si les mille comportent un seul chiffre
#$cent represente les 3 premiers chiffres du chiffre ex: 321 dans 12321
if (strlen($mille)==1)
{
$cent=substr($nombre,1);
#si ce chiffre=1
if ($mille==1)
$this->enLettre.='';
#si ce chiffre<>1
elseif($mille<>1)
$this->enLettre.=$this->chiffre[$mille];
}
elseif (strlen($mille)>1)
{
if (strlen($mille)==2)
{
$cent=substr($nombre,2);
$nombre=substr($nombre,0,2);
#echo $nombre;
$this->Dizaine(1,$nombre,$unite,$dizaine);
}
if (strlen($mille)==3)
{
$cent=substr($nombre,3);
$nombre=substr($nombre,0,3);
#echo $nombre;
$this->Centaine(1,$nombre,$unite,$dizaine,$centaine);
}
}

$this->enLettre.='mille ';
#recuperation des cens dans nombre
#suppression des zéros qui précéderaient la saisie
$nb=strlen($cent);
for ($i=0;$i<=$nb;)
{
if(substr($cent,$i,1)==0)
{
$cent=substr($cent,$i+1);
$nb=$nb-1;
}
elseif(substr($cent,$i,1)<>0)
{
$cent=substr($cent,$i);
break;
}
}
#le nombre de caract que comporte le nombre saisi de sa forme sans espace et sans 0 au début
$nb=strlen($cent);
#echo '<br />nb='.$nb.'<br />';
if ($nb==0)
;//AffichageResultat($enLettre);
elseif ($nb==1)
$this->Unite($cent);
elseif ($nb==2)
$this->Dizaine(0,$cent,$unite,$dizaine);
elseif ($nb==3)
$this->Centaine(0,$cent,$unite,$dizaine,$centaine);

}

#Gestion des centaines

function Centaine($inmillier,$nombre,$unite,$dizaine,$centaine)
{

$unite=substr($nombre,2);
$dizaine=substr($nombre,1,1);
$centaine=substr($nombre,0,1);
#comme 700
if ($unite==0 and $dizaine==0)
{
if ($centaine==1)
$this->enLettre.='cent';
elseif ($centaine<>1)
    {
        if ($inmillier == 0)
          $this->enLettre.=($this->chiffre[$centaine].' cents').' ';
        if ($inmillier == 1)
          $this->enLettre.=($this->chiffre[$centaine].' cent').' ';
    }
}
#comme 705
elseif ($unite<>0 and $dizaine==0)
{
if ($centaine==1)
$this->enLettre.=('cent '.$this->chiffre[$unite]).' ';
elseif ($centaine<>1)
$this->enLettre.=($this->chiffre[$centaine].' cent '.$this->chiffre[$unite]).' ';
}
//comme 750
elseif ($unite==0 and $dizaine<>0)
{
#recupération des dizaines
$nombre=substr($nombre,1);
//echo '<br />nombre='.$nombre.'<br />';
if ($centaine==1)
{
$this->enLettre.='cent ';
$this->Dizaine(0,$nombre,$unite,$dizaine).' ';
}
elseif ($centaine<>1)
{
$this->enLettre.=$this->chiffre[$centaine].' cent ';
$this->Dizaine(0,$nombre,$unite,$dizaine).' ';

}

}
#comme 695
elseif ($unite<>0 and $dizaine<>0)
{
$nombre=substr($nombre,1);

if ($centaine==1)
{
$this->enLettre.='cent ';
$this->Dizaine(0,$nombre,$unite,$dizaine).' ';
}

elseif ($centaine<>1)
{
$this->enLettre.=($this->chiffre[$centaine].' cent ');
$this->Dizaine(0,$nombre,$unite,$dizaine).' ';
}
}

}


#Gestion des dizaines

function Dizaine($inmillier,$nombre,$unite,$dizaine)
{
$unite=substr($nombre,1);
$dizaine=substr($nombre,0,1);

#comme 70
if ($unite==0)
{
$val=$dizaine.'0';
$this->enLettre.=$this->chiffre[$val];
    if ($inmillier == 0 && $val == 80){
      $this->enLettre.='s ';
    }
    $this->enLettre.=' ';
}
#comme 71
elseif ($unite<>0)
#dizaine different de 9
if ($dizaine<>9 and $dizaine<>7)
{
if ($dizaine==1)
{
$val=$dizaine.$unite;
$this->enLettre.=$this->chiffre[$val].' ';
}
else
{
$val=$dizaine.'0';
if ($unite == 1 && $dizaine <> 8){
$this->enLettre.=($this->chiffre[$val].' et '.$this->chiffre[$unite]).' ';
}else{
$this->enLettre.=($this->chiffre[$val].'-'.$this->chiffre[$unite]).' ';
}
}
}
#dizaine =9
elseif ($dizaine==9)
$this->enLettre.=($this->chiffre[80].'-'.$this->chiffre['1'.$unite]).' ';
elseif ($dizaine==7)
{
if ($unite == 1){
  $this->enLettre.=($this->chiffre[60].' et '.$this->chiffre['1'.$unite]).' ';
}else{
  $this->enLettre.=($this->chiffre[60].'-'.$this->chiffre['1'.$unite]).' ';
}
}
}
#Gestion des unités

function Unite($unite)
{
$this->enLettre.=($this->chiffre[$unite]).' ';
}

  //Fonction de creation d'une nouvelle dotation
	public function Ajouter(){
	  $save=$this->con->prepare("INSERT INTO vente(NUM_CLI,NUM_ID,NUM_ID_VTE,NUM_ID_DET,ID_USER, CODE_PROD,ID_COM,DATE_VENTE,HEURE_VENTE,QTE_VENTE,PRIX_GROS,PRIX_TOTAL,MONT_PAYE,TYPE_VENTE, ETAT_TELEPHONE,COULEUR_TEL,MEMOIRE_TEL,ETAT_VENTE,IMEI_TELEPHONE,CIVILITE_CLIENT, CLIENT_DETAIL,SOLDE_VENTE,CONFIRMATION_VENTE)
	                             VALUES(:num,:vte,:vte2,:vtedet,:user,:code,:id,:dat,:heure,:qte,:prig,:pri,:mont,:type,:phone,:color,:memo,:etat,:imei,:civil,:detail,:solde,:confirm)");
    $param = array(':num'=>$this->getNumClient(),
                           ':vte'=>$this->getNumVente(),
                           ':vte2'=>$this->getNumVente2(),
                           ':vtedet'=>$this->getNumVenteDetail(),
                           ':user'=>$this->getIdUser(),
                           ':code'=>$this->getCodeProd(),
                           ':id'=>$this->getIdCommande(),
                           ':dat'=>$this->getDateVente(),
                           ':heure'=>$this->getHeureVente(),
                           ':qte'=>$this->getQuantite(),
                           ':prig'=>$this->getPrixGros(),
                           ':pri'=>$this->getPrixTotal(),
                           ':mont'=>$this->getMontPayer(),
                           ':type'=>$this->getTypeVente(),
                           ':phone'=>$this->getEtatTelephone(),
                           ':color'=>$this->getCouleurTelephone(),
                           ':memo'=>$this->getMemoireTelephone(),
                           ':etat'=>$this->getEtatVte(),
                           ':imei'=>$this->getIMEI(),
                           ':civil'=>$this->getCiviliteClient(),
                           ':detail'=>$this->getClientDetail(),
                           ':solde'=>$this->getSoldeVente(),
                           ':confirm'=>$this->getConfirmationVente()
                         );
    //var_dump($param);
    //exit();
      $save->execute($param);    
      return $save?"ok":"error";
	}

  //Fonction de creation d'un produit
  public function AjouterSuppression($user,$connexion,$message,$cible){
    $save=$this->con->prepare("INSERT INTO espion_suppr(ID_USER, DATE_SUPPR, MESSAGE, ELEMENT_CIBLE)
                               VALUES(:user,:dat,:mess,:elt)
                              ");
      $save->execute(array(':user'=>$user,
                           ':dat'=>$connexion,
                           ':mess'=>$message,
                           ':elt'=>$cible                            
                           ));
      return $save?"ok":"error";
  }

  public function AjouterSuppressionBis($user,$connexion,$prod,$pinitial,$prodf,$pmodif,$message,$cible){
    $save=$this->con->prepare("INSERT INTO espion_suppr(ID_USER, DATE_SUPPR, PROD_MODIFIE,PRIX_INITIAL,LIB_PROD,PRIX_MODIFIE,MESSAGE, ELEMENT_CIBLE)
                               VALUES(:user,:dat,:prod,:init,:pf,:modif,:mess,:elt)
                              ");
      $save->execute(array(':user'=>$user,
                           ':dat'=>$connexion,
                           ':prod'=>$prod, 
                           ':init'=>$pinitial,
                           ':pf'=>$prodf,
                           ':modif'=>$pmodif,
                           ':mess'=>$message,
                           ':elt'=>$cible
                           ));
      return $save?"ok":"error";
  }


  //Fonction affichage de toutes les dotations
  public function ListerTout(){
      $show=$this->con->prepare("SELECT ID_VENTE,NOM_CLI,LIBELLE_PROD,ETAT_TELEPHONE,DATE_VENTE,QTE_VENTE,PRIX_GROS,
                                 PRIX_TOTAL,MONT_PAYE
                                 FROM produit p, client c, vente v
                                 WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI
                                 ORDER BY DATE_VENTE desc");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  public function updateEtatVersementVente($id){
  $up=$this->con->prepare("UPDATE vente SET CONFIRMATION_VENTE = 'VERSE' WHERE ID_USER='".$id."' ");
  $up->execute();
  return $up; 
  }

  public function updateVersementConfirmer($id){
  $up=$this->con->prepare("UPDATE vente SET CONFIRMATION_VENTE = 'CONFIRME' WHERE ID_USER='".$id."' ");
  $up->execute();
  return $up; 
  }

  //Fonction affichage de toutes les dotations
  public function ListerRollback($id){
      $show=$this->con->prepare("SELECT * FROM produit p, client c, vente v, user u
                                 WHERE v.CODE_PROD=p.CODE_PROD 
                                 AND v.NUM_CLI=c.NUM_CLI 
                                 AND v.ID_USER=u.ID_USER
                                 AND ETAT_VENTE = 'Now'
                                 AND u.ID_USER = '".$id."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

   //Fonction affichage de toutes les dotations
  public function ListerAchatReleve($cli,$d1,$d2){
      $show=$this->con->prepare("SELECT ID_VENTE,NOM_CLI,PRENOM_CLI,DATE_VENTE,HEURE_VENTE,LIBELLE_PROD,PRIX_GROS,QTE_VENTE, PRIX_TOTAL,MONT_PAYE,SOLDE_VENTE
                                 FROM produit p, client c, vente v
                                 WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI
                                 AND c.NUM_CLI='".$cli."'
                                 AND DATE_VENTE between '".$d1."' AND '".$d2."'
                                 UNION
                                (Select null,NOM_CLI,PRENOM_CLI,DATE_ENC,HEURE_ENC,'Encaissement',null,null, null,MONT_ENC,SOLDE_ENCAISSE
                                 from client c, encaissement e
                                 Where c.NUM_CLI=e.NUM_CLI
                                 AND c.NUM_CLI='".$cli."'
                                 AND DATE_ENC between '".$d1."' AND '".$d2."')
                                 ORDER BY DATE_VENTE ASC, HEURE_VENTE ASC
                                ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage de toutes les dotations
  public function ListerFirstAchatReleve($cli,$d1,$d2){
      $show=$this->con->prepare("SELECT ID_VENTE,NOM_CLI,PRENOM_CLI,DATE_VENTE,HEURE_VENTE,LIBELLE_PROD,PRIX_GROS,QTE_VENTE, PRIX_TOTAL,MONT_PAYE,SOLDE_VENTE
                                 FROM produit p, client c, vente v
                                 WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI
                                 AND c.NUM_CLI='".$cli."'
                                 AND DATE_VENTE between '".$d1."' AND '".$d2."'
                                 UNION
                                (Select null,NOM_CLI,PRENOM_CLI,DATE_ENC,HEURE_ENC,'null',null,null, null,MONT_ENC,SOLDE_ENCAISSE
                                 from client c, encaissement e
                                 Where c.NUM_CLI=e.NUM_CLI
                                 AND c.NUM_CLI='".$cli."'
                                 AND DATE_ENC between '".$d1."' AND '".$d2."')
                                 ORDER BY DATE_VENTE ASC, HEURE_VENTE ASC
                                 Limit 0, 1
                                ");
      $show->execute();
      $res=$show->fetch();
      return $res;
  }

  //Fonction affichage de toutes les dotations
  public function ListerVenteJour(){
      $show=$this->con->prepare("SELECT ID_VENTE,NOM_CLI,PRENOM_CLI,LIBELLE_PROD,PRENOM_USER,ETAT_TELEPHONE,DATE_VENTE,HEURE_VENTE,QTE_VENTE,
                                 PRIX_GROS,PRIX_TOTAL,MONT_PAYE
                                 FROM produit p, client c, vente v, user u
                                 WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI AND v.ID_USER=u.ID_USER
                                 AND TYPE_VENTE='En gros'
                                 AND DATE_VENTE=CURDATE()
                                 ORDER BY DATE_VENTE desc");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Calcul du total d'une vente
    public function showTotalVenteEmployeNV($user){
      $show=$this->con->prepare("SELECT SUM(MONT_PAYE) FROM vente WHERE ID_USER='".$user."' AND CONFIRMATION_VENTE='NON VERSE' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(MONT_PAYE)']."";
    } 
  }

  public function venteParCommande(){
      $show=$this->con->prepare("SELECT c.ID_COM, NUM_COM, MONTANT_COM, SUM(PRIX_TOTAL) as total
                                 FROM vente v, commande c 
                                 WHERE c.ID_COM=v.ID_COM 
                                 GROUP BY ID_COM
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }


  //Fonction affichage de toutes les dotations
  public function ListerVenteJourUser($id){
      $show=$this->con->prepare("SELECT ID_VENTE,c.NUM_CLI,NOM_CLI,PRENOM_CLI,CLIENT_DETAIL,LIBELLE_PROD,ETAT_TELEPHONE,DATE_VENTE,HEURE_VENTE,QTE_VENTE,
                                 PRIX_GROS,PRIX_TOTAL,MONT_PAYE,CONFIRMATION_VENTE
                                 FROM produit p, client c, vente v, user u
                                 WHERE v.CODE_PROD=p.CODE_PROD 
                                 AND v.NUM_CLI=c.NUM_CLI 
                                 AND v.ID_USER=u.ID_USER
                                 AND u.ID_USER = '".$id."'
                                 AND CONFIRMATION_VENTE='NON VERSE'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Calcul du total d'une vente
    public function showTotalVteGrosJourUser($user){
      $show=$this->con->prepare("SELECT SUM(MONT_PAYE)
                                 FROM vente 
                                 WHERE ID_USER='".$user."'
                                 AND CONFIRMATION_VENTE='NON VERSE'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(MONT_PAYE)']."";
    } 
  }

  //Fonction affichage de toutes les dotations
  public function ModifierVenteAnterieure(){
      $show=$this->con->prepare("SELECT ID_VENTE,NOM_CLI,PRENOM_CLI,CLIENT_DETAIL,LIBELLE_PROD,PRENOM_USER,ETAT_TELEPHONE,TYPE_VENTE,DATE_VENTE,QTE_VENTE,
                                PRIX_GROS,PRIX_TOTAL,MONT_PAYE
                                 FROM produit p, client c, vente v, user u
                                 WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI AND v.ID_USER=u.ID_USER
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }


  public function ModifVteParNum($id){
      $show=$this->con->prepare("SELECT ID_VENTE,NOM_CLI,PRENOM_CLI,LIBELLE_PROD,PRENOM_USER,ETAT_TELEPHONE,TYPE_VENTE,DATE_VENTE,QTE_VENTE,
                                PRIX_GROS,PRIX_TOTAL,MONT_PAYE,NUM_COM
                                 FROM produit p, client c, vente v, user u, commande cm
                                 WHERE v.CODE_PROD=p.CODE_PROD 
                                 AND v.NUM_CLI=c.NUM_CLI 
                                 AND v.ID_USER=u.ID_USER
                                 AND cm.ID_COM=v.ID_COM
                                 AND NUM_ID = '".$id."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  public function ModifVteParNum2($id){
      $show=$this->con->prepare("SELECT ID_VENTE,CLIENT_DETAIL,LIBELLE_PROD,PRENOM_USER,ETAT_TELEPHONE,TYPE_VENTE,DATE_VENTE,QTE_VENTE,
                                PRIX_GROS,PRIX_TOTAL,MONT_PAYE,NUM_COM
                                 FROM produit p, client c, vente v, user u, commande cm
                                 WHERE v.CODE_PROD=p.CODE_PROD 
                                 AND v.NUM_CLI=c.NUM_CLI 
                                 AND v.ID_USER=u.ID_USER
                                 AND cm.ID_COM=v.ID_COM
                                 AND NUM_ID_DET = '".$id."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  public function ListerVenteJourDetail(){
      $show=$this->con->prepare("SELECT ID_VENTE,CLIENT_DETAIL,LIBELLE_PROD,PRENOM_USER,IMEI_TELEPHONE,ETAT_TELEPHONE,COULEUR_TEL,DATE_VENTE,
                                 HEURE_VENTE,QTE_VENTE,PRIX_GROS,PRIX_TOTAL,MONT_PAYE
                                 FROM produit p, client c, vente v, user u
                                 WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI AND v.ID_USER=u.ID_USER
                                 AND TYPE_VENTE='En detail'
                                 AND DATE_VENTE=CURDATE()
                                 ORDER BY DATE_VENTE desc");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

   //Fonction affichage de toutes les dotations
  public function SommeListerVenteJour(){
      $show=$this->con->prepare("SELECT c.NUM_CLI,NOM_CLI, PRENOM_CLI, PRENOM_USER, SUM(PRIX_TOTAL) AS total, SUM(MONT_PAYE) as paye,
                                 (SUM(PRIX_TOTAL)-SUM(MONT_PAYE)) as reste
                                 FROM produit p, client c, vente v, user u
                                 WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI AND v.ID_USER=u.ID_USER
                                 AND DATE_VENTE=CURDATE() AND TYPE_VENTE='En gros'
                                 GROUP BY NUM_CLI");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage de toutes les dotations
  public function SommeListerVteEmployeJour(){
      $show=$this->con->prepare("SELECT PRENOM_USER, SUM(MONT_PAYE) as paye
                                 FROM vente v, user u
                                 WHERE v.ID_USER=u.ID_USER
                                 AND DATE_VENTE=CURDATE()
                                 GROUP BY u.ID_USER");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }


  //Fonction affichage de toutes les dotations
  public function ListerVenteJourClient(){
      $show=$this->con->prepare("SELECT NUM_CLI,NOM_CLI,DATE_VENTE,SUM(TOTAL_VENTE),SUM(MONT_PAYE)
                                 FROM produit p, client c, vente v
                                 WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI
                                 AND DATE_VENTE=CURDATE()
                                 GROUP BY NUM_CLI
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage de toutes les dotations
  public function ImprimerVenteClient($c){
      $show=$this->con->prepare("SELECT LIBELLE_PROD,QTE_VENTE,PRIX_GROS,PRIX_TOTAL
                                 FROM produit p, client c, vente v
                                 WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI
                                 ORDER BY ID_VENTE  DESC  LIMIT $c
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage de toutes les dotations
  public function ImprimerAchatClient($cli,$num){
      $show=$this->con->prepare("SELECT LIBELLE_PROD,ETAT_TELEPHONE,NUM_COM,QTE_VENTE,PRIX_GROS,PRIX_TOTAL
                                 FROM produit p, client c, vente v, commande cm
                                 WHERE v.CODE_PROD=p.CODE_PROD 
                                 AND v.NUM_CLI=c.NUM_CLI
                                 AND cm.ID_COM=v.ID_COM
                                 AND c.NUM_CLI = '".$cli."' 
                                 AND NUM_ID = '".$num."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage de toutes les dotations
  public function ImprimerAchatClient2($cli,$num){
      $show=$this->con->prepare("SELECT LIBELLE_PROD,ETAT_TELEPHONE,QTE_VENTE,PRIX_GROS,PRIX_TOTAL
                                 FROM produit p, client c, vente v
                                 WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI
                                 AND c.NUM_CLI = '".$cli."' AND NUM_ID_VTE = '".$num."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage de toutes les dotations
  public function ImprimerVenteClientDetail($num){
      $show=$this->con->prepare("SELECT LIBELLE_PROD,COULEUR_TEL,IMEI_TELEPHONE,QTE_VENTE,PRIX_GROS,PRIX_TOTAL
                                 FROM produit p, client c, vente v
                                 WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI
                                 AND NUM_ID_DET = '".$num."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

	//Fonction pour mettre a jour une dotation
	public function updateVente(){
	$up=$this->con->prepare("UPDATE vente SET CODE_PROD='".$this->getCodeProd()."',
		                                        QTE_VENTE='".$this->getQuantite()."',
                                            PRIX_GROS='".$this->getPrixGros()."',
                                            PRIX_TOTAL='".$this->getPrixTotal()."',
                                            DATE_VENTE='".$this->getDateVente()."',
                                            DATE_VENTE='".$this->getDateVente()."',
                                            ID_COM='".$this->getIdCommande()."'
                                            WHERE ID_VENTE='".$this->getIdVente()."' ");
	$up->execute();
	return $up;	
	}

  //Fonction pour mettre a jour une dotation
  public function updateVenteDet2(){
  $up=$this->con->prepare("UPDATE vente SET CODE_PROD='".$this->getCodeProd()."',
                                            QTE_VENTE='".$this->getQuantite()."',
                                            PRIX_GROS='".$this->getPrixGros()."',
                                            PRIX_TOTAL='".$this->getPrixTotal()."',
                                            DATE_VENTE='".$this->getDateVente()."',
                                            MONT_PAYE='".$this->getMontPayer()."',
                                            ID_COM='".$this->getIdCommande()."'
                                            WHERE ID_VENTE='".$this->getIdVente()."' ");
  $up->execute();
  return $up; 
  }

  public function ListerUserControle(){
      $show=$this->con->prepare("SELECT ID_SUPPR, PRENOM_USER,DATE_SUPPR,PROD_MODIFIE,PRIX_INITIAL,LIB_PROD,PRIX_MODIFIE,MESSAGE,
                                 ELEMENT_CIBLE
                                 FROM espion_suppr s, user u
                                 WHERE s.ID_USER=u.ID_USER
                                 AND MESSAGE = 'Vente modifiée'
                                 ORDER BY DATE_SUPPR DESC
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction pour mettre a jour une dotation
  public function updateVtePaiement($solde,$mont,$idV){
  $up=$this->con->prepare("UPDATE vente SET MONT_PAYE='".$mont."', SOLDE_VENTE='".$solde."' WHERE ID_VENTE='".$idV."' ");
  $up->execute();
  return $up; 
  }

  //Fonction pour mettre a jour une dotation
  public function updateVteDetailPaiement($mont,$idV){
  $up=$this->con->prepare("UPDATE vente SET MONT_PAYE='".$mont."' WHERE ID_VENTE='".$idV."' ");
  $up->execute();
  return $up; 
  }

  public function updateSoldeAchat($mont,$cli){
  $up=$this->con->prepare("UPDATE vente SET SOLDE_VENTE=SOLDE_VENTE-'".$mont."' WHERE NUM_CLI='".$cli."' ");
  $up->execute();
  return $up; 
  }

  //Fonction pour mettre a jour un etat de vente
  public function updateEtatVte($num){
  $up=$this->con->prepare("UPDATE vente SET ETAT_VENTE='Done' WHERE ETAT_VENTE='Now' AND NUM_ID='".$num."' ");
  $up->execute();
  return $up; 
  }

  //Fonction pour mettre a jour un etat de vente
  public function updateEtatVte2($num){
  $up=$this->con->prepare("UPDATE vente SET ETAT_VENTE='Done' WHERE ETAT_VENTE='Now' AND NUM_ID_VTE='".$num."' ");
  $up->execute();
  return $up; 
  }

  //Fonction pour mettre a jour un etat de vente
  public function updateEtatVteDetail(){
  $up=$this->con->prepare("UPDATE vente SET ETAT_VENTE='Done' WHERE ETAT_VENTE='Now' AND TYPE_VENTE='En detail'");
  $up->execute();
  return $up; 
  }

  //Fonction pour mettre a jour un etat de vente
  public function updateEtatRecuVte($cli){
  $up=$this->con->prepare("UPDATE vente SET RECU_VENTE='Etabli' WHERE NUM_CLI='".$cli."' ");
  $up->execute();
  return $up; 
  }

  //Fonction pour mettre a jour un le stock d'un produit
  public function updateStockProduitVte($qte, $prod){
  $up=$this->con->prepare("UPDATE produit SET QTE_STOCK=((QTE_STOCK)-('".$qte."')) WHERE CODE_PROD='".$prod."' ");
  $up->execute();
  return $up; 
  }

  //Fonction pour mettre a jour un le stock d'un produit
  public function updateStockProduitVte2($qte, $prod){
  $up=$this->con->prepare("UPDATE produit SET STOCK_DETAIL=((STOCK_DETAIL)-('".$qte."')) WHERE CODE_PROD='".$prod."' ");
  $up->execute();
  return $up; 
  }

  //Fonction pour mettre a jour un le stock d'un produit
  public function updateStockProduitDiffVte($qte, $prod){
  $up=$this->con->prepare("UPDATE produit SET QTE_STOCK=((QTE_STOCK)+('".$qte."')) WHERE CODE_PROD='".$prod."' ");
  $up->execute();
  return $up; 
  }

  //Fonction pour mettre a jour un le stock d'un produit
  public function updateStockProduitDiffVteDet($qte, $prod){
  $up=$this->con->prepare("UPDATE produit SET STOCK_DETAIL=((STOCK_DETAIL)+('".$qte."')) WHERE CODE_PROD='".$prod."' ");
  $up->execute();
  return $up; 
  }

  //Fonction pour mettre a jour un le stock d'un produit
  public function updateStockProduitDiffVte2($qte, $prod){
  $up=$this->con->prepare("UPDATE produit SET QTE_STOCK=((QTE_STOCK)-('".$qte."')) WHERE CODE_PROD='".$prod."' ");
  $up->execute();
  return $up; 
  }

  //Fonction pour mettre a jour un le stock d'un produit
  public function updateStockProduitDiffVteDet1($qte, $prod){
  $up=$this->con->prepare("UPDATE produit SET STOCK_DETAIL=((STOCK_DETAIL)-('".$qte."')) WHERE CODE_PROD='".$prod."' ");
  $up->execute();
  return $up; 
  }


  //Fonction pour mettre a jour un le stock d'un produit
  public function updateStockProduitVte22($qte, $prod){
  $up=$this->con->prepare("UPDATE produit SET STOCK_DETAIL=((STOCK_DETAIL)-('".$qte."')) WHERE CODE_PROD='".$prod."' ");
  $up->execute();
  return $up; 
  }

  //Fonction pour mettre a jour un le stock d'un produit
  public function updateStockProduitVteDet($qte, $prod){
  $up=$this->con->prepare("UPDATE produit SET STOCK_DETAIL=((STOCK_DETAIL)-('".$qte."')) WHERE CODE_PROD='".$prod."' ");
  $up->execute();
  return $up; 
  }

  //Fonction pour mettre a jour un le stock d'un produit
  public function updateClientVte($num){
  $up=$this->con->prepare("UPDATE tampon SET NUM_ID='".$num."' ");
  $up->execute();
  return $up; 
  }

   //Fonction pour mettre a jour un le stock d'un produit
  public function updateClientVte2($num){
  $up=$this->con->prepare("UPDATE tampon SET NUM_ID_VTE='".$num."' ");
  $up->execute();
  return $up; 
  }

  //Fonction pour mettre a jour un le stock d'un produit
  public function updateClientVteDetail($num,$civil,$nom,$vdet){
  $up=$this->con->prepare("UPDATE tampon SET NUM_CLI='".$num."',CIVILITE_CLIENT='".$civil."',CLIENT_DETAIL='".$nom."',NUM_ID_DET='".$vdet."' ");
  $up->execute();
  return $up; 
  }


  //Fonction pour mettre a jour un le stock d'un produit
  public function updateNumVte(){
  $up=$this->con->prepare("UPDATE tampon SET NUM_ID=NUM_ID+1 ");
  $up->execute();
  return $up; 
  }

  //Fonction pour mettre a jour un le stock d'un produit
  public function updateNumVteDetail(){
  $up=$this->con->prepare("UPDATE tampon SET NUM_ID_DET=NUM_ID_DET+1 ");
  $up->execute();
  return $up; 
  }

  //Afficher prix d'un produit
    public function showClientEncour(){
      $show=$this->con->prepare("SELECT NUM_CLI FROM tampon");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NUM_CLI']."";
    } 
  }

  //Afficher prix d'un produit
    public function showCiviliteClientEncour(){
      $show=$this->con->prepare("SELECT CIVILITE_CLIENT FROM tampon");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['CIVILITE_CLIENT']."";
    } 
  }

  //Afficher prix d'un produit
    public function showClientDetailEncour(){
      $show=$this->con->prepare("SELECT CLIENT_DETAIL FROM tampon");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['CLIENT_DETAIL']."";
    } 
  }

   //Afficher prix d'un produit
    public function quantiteTotalVendu(){
      $show=$this->con->prepare("SELECT SUM(QTE_VENTE) FROM vente");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(QTE_VENTE)']."";
    } 
  }

   //Afficher prix d'un produit
    public function quantiteTotalApprovisionner(){
      $show=$this->con->prepare("SELECT (SUM(QTE_STOCK)+ SUM(STOCK_DETAIL)) as somme FROM produit");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }

  //Afficher prix d'un produit
    public function showNumVteEncour(){
      $show=$this->con->prepare("SELECT NUM_ID FROM tampon");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NUM_ID']."";
    } 
  }

  //Afficher prix d'un produit
    public function showNumVteEncour2(){
      $show=$this->con->prepare("SELECT NUM_ID_VTE FROM tampon");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NUM_ID_VTE']."";
    } 
  }

   //Afficher prix d'un produit
    public function showSoldeBisVente($cli){
      $show=$this->con->prepare("SELECT SOLDE_VENTE
                                 From vente 
                                 where `TYPE_VENTE`='En gros' 
                                 AND NUM_CLI='".$cli."'
                                 AND ID_VENTE=(select Max(ID_VENTE) from vente)");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SOLDE_VENTE']."";
    } 
  }

  //Afficher prix d'un produit
    public function showNumVteDetEncour(){
      $show=$this->con->prepare("SELECT NUM_ID_DET FROM tampon");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NUM_ID_DET']."";
    } 
  }

  //Fonction pour mettre a jour un le stock d'un produit
  public function updateStockProduitVteD($qte, $prod, $kilo){
  $up=$this->con->prepare("UPDATE produit SET QTE_STOCK=(((QTE_STOCK)*('".$kilo."'))-('".$qte."'))/('".$kilo."') WHERE CODE_PROD='".$prod."' ");
  //var_dump($up);
    //exit;
  $up->execute();
  return $up; 
  }

  //Fonction pour mettre a jour un le stock d'un produit
  public function updateStockProduitVteTest($qte, $prod, $kilo){
  $up=$this->con->prepare("UPDATE produit SET QTE_TEST=(((QTE_TEST)*('".$kilo."'))-('".$qte."'))/('".$kilo."') WHERE CODE_PROD='".$prod."' ");
  //var_dump($up);
    //exit;
  $up->execute();
  return $up; 
  }

   //Fonction2 pour mettre a jour un le stock d'un produit après une suppression 
  public function updateStockProdDelVte($qte,$id){
  $up=$this->con->prepare("UPDATE produit SET QTE_STOCK=((QTE_STOCK)+('".$qte."'))
                                              WHERE CODE_PROD='".$id."' ");
  $up->execute();
  return $up; 
  }

  public function updateStockProdDelVteDet($qte,$id){
  $up=$this->con->prepare("UPDATE produit SET STOCK_DETAIL=((STOCK_DETAIL)+('".$qte."'))
                                              WHERE CODE_PROD='".$id."' ");
  $up->execute();
  return $up; 
  }

  //Fonction2 pour mettre a jour un le stock d'un produit après une suppression 
  public function updateSoldeClientDelVte($qte,$id){
  $up=$this->con->prepare("UPDATE client SET SOLDE_CLIENT=((SOLDE_CLIENT)-('".$qte."'))
                                              WHERE NUM_CLI='".$id."' ");
  $up->execute();
  return $up; 
  }

  //Fonction2 pour mettre a jour un le stock d'un produit après une suppression 
  public function updateSoldeClientMAVte($qte,$id){
  $up=$this->con->prepare("UPDATE client SET SOLDE_CLIENT=((SOLDE_CLIENT)+('".$qte."'))
                                              WHERE NUM_CLI='".$id."' ");
  $up->execute();
  return $up; 
  }

  //Fonction2 pour mettre a jour un le stock d'un produit après une suppression 
  public function updateSoldeMAVte($mont,$id,$cli){
  $up=$this->con->prepare("UPDATE vente SET SOLDE_VENTE=((SOLDE_VENTE)+('".$mont."'))
                                              WHERE ID_VENTE >= '".$id."'
                                              AND NUM_CLI = '".$cli."' ");
  $up->execute();
  return $up; 
  }

  //Fonction2 pour mettre a jour un le stock d'un produit après une suppression 
  public function updateSoldeMAVteRollback($mont,$id,$cli){
  $up=$this->con->prepare("UPDATE vente SET SOLDE_VENTE=((SOLDE_VENTE)-('".$mont."'))
                                              WHERE ID_VENTE >= '".$id."'
                                              AND NUM_CLI = '".$cli."' ");
  $up->execute();
  return $up; 
  }

   public function updateSoldEncaissement($mont,$d,$cli){
  $up=$this->con->prepare("UPDATE encaissement SET SOLDE_ENCAISSE=((SOLDE_ENCAISSE)+('".$mont."'))
                                               WHERE DATE_ENC >= '".$d."'
                                               AND NUM_CLI = '".$cli."' ");
  $up->execute();
  return $up; 
  }

  //Fonction2 pour mettre a jour un le stock d'un produit après une suppression 
  public function updateStockProdDelVte2($qte,$id){
  $up=$this->con->prepare("UPDATE produit SET STOCK_DETAIL=((STOCK_DETAIL)+('".$qte."'))
                                              WHERE CODE_PROD='".$id."' ");
  $up->execute();
  return $up; 
  }


   //Fonction pour selectionner une dotation à editer
  public function getOne($code){
    $one=$this->con->prepare(" SELECT * FROM vente WHERE ID_VENTE='".$code."'");
    $one->execute();
    $un=$one->fetch();
    return $un;
  }

  //Fonction suppression d'un produit
  public function delete($code){
  $del=$this->con->prepare("DELETE FROM vente WHERE ID_VENTE='".$code."'");
  $del->execute();
  return $del;  
  }

  //Fonction suppression d'un produit
  public function deleteAll($code,$cli){
  $del=$this->con->prepare("DELETE FROM vente WHERE NUM_ID='".$code."' AND NUM_ID='".$cli."'");
  $del->execute();
  return $del;  
  }

   //Afficher libelle d'un produit
    public function showNomClient($id){
      $show=$this->con->prepare("SELECT NOM_CLI FROM client WHERE NUM_CLI='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NOM_CLI']."";
    } 
  }


   //Afficher libelle d'un produit
    public function showPrenomClient($id){
      $show=$this->con->prepare("SELECT PRENOM_CLI FROM client WHERE NUM_CLI='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['PRENOM_CLI']."";
    } 
  }

  //Afficher libelle d'un produit
    public function showNomClientEdit($id){
      $show=$this->con->prepare("SELECT CLIENT_DETAIL FROM vente WHERE ID_VENTE='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['CLIENT_DETAIL']."";
    } 
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

  public function showOldPriceProd($id){
      $show=$this->con->prepare("SELECT PRIX_GROS FROM vente WHERE ID_VENTE='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['PRIX_GROS']."";
    }
  }

   //Afficher libelle d'un produit
    public function showTypeUser($id){
      $show=$this->con->prepare("SELECT TYPE FROM user WHERE ID_USER='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['TYPE']."";
    } 
  }

  //Fonction affichage de tous les clients
  public function ListerRecuVente(){
      $show=$this->con->prepare("SELECT NUM_ID, PRENOM_USER, c.NUM_CLI, NOM_CLI, PRENOM_CLI, DATE_VENTE, HEURE_VENTE 
                                 FROM vente v, client c, user u 
                                 WHERE v.NUM_CLI=c.NUM_CLI AND v.ID_USER=u.ID_USER AND DATE_VENTE=CURDATE() AND TYPE_VENTE='En gros' AND NUM_ID > 0
                                 GROUP BY NUM_ID
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage de tous les clients
  public function ListerRecuVenteBis(){
      $show=$this->con->prepare("SELECT NUM_ID_VTE, c.NUM_CLI, NOM_CLI, PRENOM_CLI, DATE_VENTE, HEURE_VENTE 
                                 FROM vente v, client c 
                                 WHERE v.NUM_CLI=c.NUM_CLI AND DATE_VENTE=CURDATE() AND TYPE_VENTE='En gros' AND NUM_ID_VTE > 0
                                 GROUP BY NUM_ID_VTE
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage de tous les clients
  public function ListerRecuVenteDet(){
      $show=$this->con->prepare("SELECT NUM_ID_DET, CLIENT_DETAIL, DATE_VENTE, HEURE_VENTE 
                                 FROM vente
                                 WHERE TYPE_VENTE='En detail'
                                 GROUP BY NUM_ID_DET
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage de tous les clients
  public function RecuVenteClient($num){
      $show=$this->con->prepare("SELECT LIBELLE_PROD, QTE_VENTE, PRIX_TOTAL, MONT_PAYE 
                                 FROM vente v, produit p, client c 
                                 WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI
                                 AND NUM_ID = '".$num."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage de tous les clients
  public function ListerDetailAchatClient($cli,$num){
      $show=$this->con->prepare("SELECT LIBELLE_PROD, QTE_VENTE, PRIX_GROS, PRIX_TOTAL, MONT_PAYE 
                                 FROM vente v, produit p, client c 
                                 WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI
                                 AND c.NUM_CLI = '".$cli."' AND NUM_ID = '".$num."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage de tous les clients
  public function ListerDetailAchatClient2($cli,$num){
      $show=$this->con->prepare("SELECT LIBELLE_PROD, QTE_VENTE, PRIX_GROS, PRIX_TOTAL, MONT_PAYE 
                                 FROM vente v, produit p, client c 
                                 WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI
                                 AND c.NUM_CLI = '".$cli."' AND NUM_ID_VTE = '".$num."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage de tous les clients
  public function RecuVenteClientDet($num){
      $show=$this->con->prepare("SELECT LIBELLE_PROD, QTE_VENTE, PRIX_GROS, PRIX_TOTAL 
                                 FROM vente v, produit p, client c 
                                 WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI
                                 AND NUM_ID_DET = '".$num."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Calcul du total d'une vente
    public function showTotalVteCourante($id){
      $show=$this->con->prepare("SELECT SUM(PRIX_TOTAL) 
                                 FROM vente 
                                 WHERE ID_USER = '".$id."'
                                 AND ETAT_VENTE='Now' 
                                 AND TYPE_VENTE='En gros'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(PRIX_TOTAL)']."";
    } 
  }

   public function showIdUtilEncours($numV){
      $show=$this->con->prepare("SELECT ID_USER 
                                 FROM vente 
                                 WHERE NUM_ID = '".$numV."'
                                 AND ETAT_VENTE='Now'
                                 LIMIT 1 
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['ID_USER']."";
    } 
  }

  //Calcul du total d'une vente
    public function showTotalVteCouranteCli($id,$cli){
      $show=$this->con->prepare("SELECT SUM(PRIX_TOTAL) 
                                 FROM vente 
                                 WHERE ID_USER = '".$id."'
                                 AND ETAT_VENTE='Now' 
                                 AND NUM_CLI='".$cli."' 
                                 AND TYPE_VENTE='En gros'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(PRIX_TOTAL)']."";
    } 
  }

  public function showTotalVteCouranteCli2($id,$cli){
      $show=$this->con->prepare("SELECT PRIX_TOTAL 
                                 FROM vente 
                                 WHERE ID_USER = '".$id."'
                                 AND ETAT_VENTE='Now' 
                                 AND NUM_CLI='".$cli."' 
                                 AND TYPE_VENTE='En gros'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['PRIX_TOTAL']."";
    } 
  }

  //Calcul du total d'une vente
    public function showTotalVteRollback($id){
      $show=$this->con->prepare("SELECT PRIX_TOTAL FROM vente WHERE ID_VENTE = '".$id."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['PRIX_TOTAL']."";
    } 
  }

  //Calcul du total d'une vente
    public function showClientVteRollback($id){
      $show=$this->con->prepare("SELECT NUM_CLI FROM vente WHERE ID_VENTE = '".$id."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NUM_CLI']."";
    } 
  }

   //Calcul du total d'une vente
    public function showTotalVteCouranteDetail($id){
      $show=$this->con->prepare("SELECT SUM(PRIX_TOTAL) 
                                 FROM vente 
                                 WHERE ID_USER = '".$id."'
                                 AND ETAT_VENTE='Now' 
                                 AND TYPE_VENTE='En detail'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(PRIX_TOTAL)']."";
    } 
  }

  //Calcul du total d'une vente
    public function showTotalVteDetailJour(){
      $show=$this->con->prepare("SELECT SUM(MONT_PAYE) FROM vente WHERE TYPE_VENTE='En detail' AND DATE_VENTE= CURDATE()");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(MONT_PAYE)']."";
    } 
  }

  //Calcul du total d'une vente
    public function showTotalVteGrosJour(){
      $show=$this->con->prepare("SELECT SUM(MONT_PAYE) FROM vente WHERE TYPE_VENTE='En gros' AND DATE_VENTE= CURDATE()");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(MONT_PAYE)']."";
    } 
  }

  //Calcul du total d'une vente
    public function showTotalAchatClient($id){
      $show=$this->con->prepare("SELECT SUM(TOTAL_VENTE) FROM vente WHERE ID_VENTE > '".$id."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(TOTAL_VENTE)']."";
    } 
  }

  //Calcul du total d'une vente
    public function CountLineVte(){
      $show=$this->con->prepare("SELECT COUNT(ID_VENTE) FROM vente WHERE ETAT_VENTE='Now'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['COUNT(ID_VENTE)']."";
    } 
  }

  //Calcul du total d'une vente
    public function LastNumIdVte(){
      $show=$this->con->prepare("SELECT NUM_ID_DET FROM vente WHERE ETAT_VENTE='Now' AND TYPE_VENTE='En detail' limit 1");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NUM_ID_DET']."";
    } 
  }


  //Afficher libelle d'un produit
    public function showQteVendu($id){
      $show=$this->con->prepare("SELECT QTE_VENTE FROM vente WHERE ID_VENTE='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['QTE_VENTE']."";
    } 
  }

  //Afficher libelle d'un produit
    public function showPriceNewProd($id){
      $show=$this->con->prepare("SELECT PRIX_DETAIL FROM produit WHERE CODE_PROD='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['PRIX_DETAIL']."";
    } 
  }

  //Afficher libelle d'un produit
    public function showOldTotal($id){
      $show=$this->con->prepare("SELECT PRIX_TOTAL FROM vente WHERE ID_VENTE='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['PRIX_TOTAL']."";
    } 
  }

   //Afficher libelle d'un produit
    public function showMontantNotNull($id){
      $show=$this->con->prepare("SELECT ID_VENTE FROM vente WHERE NUM_ID_DET='".$id."' AND MONT_PAYE > 0 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['ID_VENTE']."";
    } 
  }

  public function updateVenteDetMontant($id, $mont){
  $up=$this->con->prepare("UPDATE vente SET MONT_PAYE=MONT_PAYE - '".$mont."'
                                            WHERE ID_VENTE='".$id."' ");
  $up->execute();
  return $up; 
  }

  //Afficher libelle d'un produit
    public function showNumVteDet($id){
      $show=$this->con->prepare("SELECT NUM_ID_DET FROM vente WHERE ID_VENTE='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NUM_ID_DET']."";
    } 
  }

  //Afficher le dernier enregistrement d'une vente
    public function showLastId(){
      $one=$this->con->prepare("SELECT * FROM vente WHERE ID_VENTE = (SELECT MAX( ID_VENTE) FROM vente WHERE `ETAT_VENTE`='Now' AND TYPE_VENTE='En gros')");
      $one->execute();
      $un=$one->fetch();
    return $un;
  }

  //Afficher le dernier enregistrement d'une vente
    public function showLastIdvte($id){
      $show=$this->con->prepare("SELECT ID_VENTE FROM vente WHERE ID_VENTE = (SELECT MAX( ID_VENTE) FROM vente WHERE NUM_ID='".$id."')");
      $show->execute();
      $res=$show->fetchAll();
     foreach($res as $val){
      return  $val['ID_VENTE']."";
    } 
  }

  //Afficher le dernier enregistrement d'une vente
    public function showLastIdvte2($id){
      $show=$this->con->prepare("SELECT ID_VENTE FROM vente WHERE ID_VENTE = (SELECT MAX( ID_VENTE) FROM vente WHERE NUM_ID_VTE='".$id."')");
      $show->execute();
      $res=$show->fetchAll();
     foreach($res as $val){
      return  $val['ID_VENTE']."";
    } 
  }

  //Afficher le dernier enregistrement d'une vente
    public function showLastVteDetail($num){
      $one=$this->con->prepare("SELECT * FROM vente WHERE NUM_ID_DET = '".$num."' limit 1 ");
      $one->execute();
      $un=$one->fetch();
    return $un;
  }


  //Afficher le dernier enregistrement d'une vente
    public function showLasTMontant($num){
      $show=$this->con->prepare("SELECT SUM(MONT_PAYE) as montant FROM vente WHERE NUM_ID='".$num."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['montant']."";
    } 
  }

  //Afficher le dernier enregistrement d'une vente
    public function showLasTMontantTotal($num){
      $show=$this->con->prepare("SELECT SUM(PRIX_TOTAL) as montant FROM vente WHERE NUM_ID='".$num."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['montant']."";
    } 
  }

  //Afficher le dernier enregistrement d'une vente
    public function showLasTMontantBis($num){
      $show=$this->con->prepare("SELECT SUM(MONT_PAYE) as montant FROM vente WHERE NUM_ID_VTE='".$num."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['montant']."";
    } 
  }

  //Afficher le dernier enregistrement d'une vente
    public function showLasTMontantDetail($num){
      $show=$this->con->prepare("SELECT SUM(MONT_PAYE) as montant FROM vente WHERE NUM_ID_DET='".$num."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['montant']."";
    } 
  }

   public function showPTotalVte($num){
      $show=$this->con->prepare("SELECT SUM(PRIX_TOTAL) as total FROM vente WHERE NUM_ID_DET='".$num."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['total']."";
    } 
  }

  public function showDatevente($num){
      $show=$this->con->prepare("SELECT DATE_VENTE FROM vente WHERE NUM_ID_DET='".$num."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['DATE_VENTE']."";
    } 
  }

  public function showDateVenteG($num){
      $show=$this->con->prepare("SELECT DATE_VENTE FROM vente WHERE NUM_ID='".$num."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['DATE_VENTE']."";
    } 
  }

  public function showHeureVente($num){
      $show=$this->con->prepare("SELECT HEURE_VENTE FROM vente WHERE NUM_ID_DET='".$num."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['HEURE_VENTE']."";
    } 
  }

  public function showHeureVenteG($num){
      $show=$this->con->prepare("SELECT HEURE_VENTE FROM vente WHERE NUM_ID='".$num."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['HEURE_VENTE']."";
    } 
  }

  //Afficher le dernier enregistrement d'une vente
    public function showLasTMontantDetailTotal($num){
      $show=$this->con->prepare("SELECT SUM(MONT_PAYE) as montant FROM vente WHERE NUM_ID_DET='".$num."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['montant']."";
    } 
  }


   //Afficher le dernier enregistrement d'une vente
    public function showLasTMontant2(){
      $show=$this->con->prepare("SELECT MONT_PAYE FROM vente WHERE ID_VENTE = (SELECT MAX( ID_VENTE) FROM vente ) ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['MONT_PAYE']."";
    } 
  }



  //Afficher le dernier enregistrement d'une vente
    public function showLasTClient(){
      $show=$this->con->prepare("SELECT NUM_CLI FROM vente WHERE ID_VENTE = (SELECT MAX( ID_VENTE) FROM vente )");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NUM_CLI']."";
    } 
  }

  //Afficher le dernier enregistrement d'une vente
    public function showLasTNomClient($num){
      $show=$this->con->prepare("SELECT NOM_CLI FROM client WHERE NUM_CLI = '".$num."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NOM_CLI']."";
    } 
  }


  //Afficher le dernier enregistrement d'une vente
    public function showNumClientVte($num){
      $show=$this->con->prepare("SELECT NUM_CLI FROM vente WHERE NUM_ID = '".$num."' limit 1 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NUM_CLI']."";
    } 
  }

  //Afficher le dernier enregistrement d'une vente
    public function showNumClientVteBis($num){
      $show=$this->con->prepare("SELECT NUM_CLI FROM vente WHERE NUM_ID_VTE = '".$num."' limit 1 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NUM_CLI']."";
    } 
  }

  //Afficher le dernier enregistrement d'une vente
    public function showNomClientDetail($num){
      $show=$this->con->prepare("SELECT CLIENT_DETAIL FROM vente WHERE NUM_ID_DET = '".$num."' limit 1 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['CLIENT_DETAIL']."";
    } 
  }

  //Afficher le dernier enregistrement d'une vente
    public function showCivilClientDetail($num){
      $show=$this->con->prepare("SELECT CIVILITE_CLIENT FROM vente WHERE NUM_ID_DET = '".$num."' limit 1 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['CIVILITE_CLIENT']."";
    } 
  }

  //Afficher le dernier enregistrement d'une vente
    public function showLasTPrenomClient($num){
      $show=$this->con->prepare("SELECT PRENOM_CLI FROM client WHERE NUM_CLI = '".$num."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['PRENOM_CLI']."";
    } 
  }

  //Afficher le dernier enregistrement d'une vente
    public function showIdVendeur($num){
      $show=$this->con->prepare("SELECT ID_USER FROM vente WHERE NUM_ID = '".$num."' limit 1 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['ID_USER']."";
    } 
  }

  //Afficher le dernier enregistrement d'une vente
    public function showNomVendeur($num){
      $show=$this->con->prepare("SELECT PRENOM_USER FROM user WHERE ID_USER = '".$num."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['PRENOM_USER']."";
    } 
  }

  //Afficher le dernier enregistrement d'une vente
    public function showTotalAchatReleve($num,$d1,$d2){
      $show=$this->con->prepare("SELECT SUM(PRIX_TOTAL) FROM vente 
                                WHERE NUM_CLI = '".$num."'
                                AND DATE_VENTE between '".$d1."' AND '".$d2."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(PRIX_TOTAL)']."";
    } 
  }

  //Afficher le dernier enregistrement d'une vente
    public function showTotalPayeReleve($num,$d1,$d2){
      $show=$this->con->prepare("SELECT SUM(MONT_PAYE) FROM vente 
                                WHERE NUM_CLI = '".$num."'
                                AND DATE_VENTE between '".$d1."' AND '".$d2."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(MONT_PAYE)']."";
    } 
  }

  //Afficher le dernier enregistrement d'une vente
    public function showTotalEncaisseReleve($num,$d1,$d2){
      $show=$this->con->prepare("SELECT SUM(MONT_ENC) FROM encaissement 
                                WHERE NUM_CLI = '".$num."'
                                AND DATE_ENC between '".$d1."' AND '".$d2."' ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(MONT_ENC)']."";
    } 
  }


  //Afficher libelle d'un produit
    public function showIdProduit($id){
      $show=$this->con->prepare("SELECT CODE_PROD FROM vente WHERE ID_VENTE='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['CODE_PROD']."";
    } 
  }

   //Afficher libelle d'un produit
    public function showTypeVente($id){
      $show=$this->con->prepare("SELECT TYPE_VENTE FROM vente WHERE ID_VENTE='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['TYPE_VENTE']."";
    } 
  }

  //Afficher libelle d'un produit
    public function showTotalVteProduit($id){
      $show=$this->con->prepare("SELECT SUM(PRIX_TOTAL) as somme FROM vente WHERE NUM_ID='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }

  //Afficher libelle d'un produit
    public function showTotalVteLine($id){
      $show=$this->con->prepare("SELECT PRIX_TOTAL FROM vente WHERE ID_VENTE='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['PRIX_TOTAL']."";
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
    public function showStockProduitDetNew($id){
      $show=$this->con->prepare("SELECT STOCK_DETAIL FROM produit WHERE CODE_PROD='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['STOCK_DETAIL']."";
    } 
  }

  //Afficher libelle d'un produit
    public function showNumVteDelelte($id){
      $show=$this->con->prepare("SELECT NUM_ID FROM vente WHERE ID_VENTE='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NUM_ID']."";
    } 
  }

  //Afficher libelle d'un produit
    public function showMntantVteProduit($id){
      $show=$this->con->prepare("SELECT SUM(MONT_PAYE) as mont FROM vente WHERE NUM_ID='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['mont']."";
    } 
  }

  //Afficher libelle d'un produit
    public function showMntantVteLine($id){
      $show=$this->con->prepare("SELECT MONT_PAYE FROM vente WHERE ID_VENTE='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['MONT_PAYE']."";
    } 
  }

  //Afficher libelle d'un produit
    public function showSommeMntantVte($cli,$vte){
      $show=$this->con->prepare("SELECT SUM(MONT_PAYE) FROM vente WHERE NUM_CLI='".$cli."' AND NUM_ID='".$vte."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SUM(MONT_PAYE)']."";
    } 
  }

  //Afficher libelle d'un produit
    public function showStateVte($cli,$vte){
      $show=$this->con->prepare("SELECT ETAT_VENTE FROM vente WHERE NUM_CLI='".$cli."' AND NUM_ID='".$vte."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['ETAT_VENTE']."";
    } 
  }

  //Calcul du total d'une vente
    public function showSoldeClient($num){
      $show=$this->con->prepare("SELECT SOLDE_CLIENT FROM client WHERE NUM_CLI='".$num."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['SOLDE_CLIENT']."";
    } 
  }

  //Afficher libelle d'un produit
    public function showNumClientVteProduit($id){
      $show=$this->con->prepare("SELECT NUM_CLI FROM vente WHERE ID_VENTE='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['NUM_CLI']."";
    } 
  }

  //Afficher prix d'un produit
    public function showPrixGrosProduit($id){
      $show=$this->con->prepare("SELECT PRIX_GROS FROM produit WHERE CODE_PROD='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['PRIX_GROS']."";
    } 
  }

  //Afficher prix d'un produit
    public function showPrixDetailProduit($id){
      $show=$this->con->prepare("SELECT PRIX_DETAIL FROM produit WHERE CODE_PROD='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['PRIX_DETAIL']."";
    } 
  }

  public function ListerNomClient(){
      $show=$this->con->prepare("SELECT NUM_CLI, NOM_CLI, PRENOM_CLI FROM client WHERE TYPE_CLI='Grossiste' OR TYPE_CLI='Commercial'");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage de tous les clients
  public function ListerNomUser(){
      $show=$this->con->prepare("SELECT ID_USER, USER_NAME FROM user");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage de tous les clients
  public function ListerNomPhone(){
      $show=$this->con->prepare("SELECT CODE_PROD, LIBELLE_PROD FROM produit ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }


  //Fonction affichage des ventes au cours d'une periode donnée
  public function VentePeriodique($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d"); 
      $show=$this->con->prepare("SELECT ID_VENTE,NOM_CLI,PRENOM_CLI,LIBELLE_PROD,PRENOM_USER,DATE_VENTE,HEURE_VENTE,QTE_VENTE,PRIX_GROS,PRIX_TOTAL,MONT_PAYE
                                 FROM produit p, client c, vente v, user u
                                 WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI AND v.ID_USER=u.ID_USER
                                 AND DATE_VENTE BETWEEN '".$d1_traite."' AND '".$d2_traite."'
                                 AND TYPE_VENTE='En gros'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  public function VentePeriodiqueM1($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d"); 
      $show=$this->con->prepare("SELECT LIBELLE_PROD,SUM(QTE_VENTE) as SOMMEQTE,SUM(PRIX_TOTAL) as total
                                 FROM produit p, vente v
                                 WHERE v.CODE_PROD=p.CODE_PROD
                                 AND DATE_VENTE BETWEEN '".$d1_traite."' AND '".$d2_traite."'
                                 GROUP BY LIBELLE_PROD
                                 HAVING SUM(QTE_VENTE)> 0
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage des ventes au cours d'une periode donnée
  public function VentePeriodiqueDet($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d"); 
      $show=$this->con->prepare("SELECT ID_VENTE,NOM_CLI,LIBELLE_PROD,DATE_VENTE,HEURE_VENTE,QTE_VENTE,PRIX_TOTAL,MONT_PAYE
                                 FROM produit p, client c, vente v
                                 WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI
                                 AND DATE_VENTE BETWEEN '".$d1_traite."' AND '".$d2_traite."'
                                 AND TYPE_VENTE='En detail'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage des ventes au cours d'une periode donnée
  public function VenteDetailPeriodique($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d"); 
      $show=$this->con->prepare("SELECT ID_VENTE,CLIENT_DETAIL,LIBELLE_PROD,PRENOM_USER,DATE_VENTE,HEURE_VENTE,QTE_VENTE,PRIX_GROS,PRIX_TOTAL,MONT_PAYE
                                 FROM produit p, client c, vente v, user u
                                 WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI AND v.ID_USER=u.ID_USER
                                 AND DATE_VENTE BETWEEN '".$d1_traite."' AND '".$d2_traite."'
                                 AND TYPE_VENTE='En detail'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage des ventes au cours d'une periode donnée
  public function ClassementVenteClient($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d"); 
      $show=$this->con->prepare("SELECT NOM_CLI,PRENOM_CLI,SUM(PRIX_TOTAL) as total, SUM(MONT_PAYE) as montant
                                 FROM produit p, client c, vente v
                                 WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI
                                 AND TYPE_CLI='Commercial'
                                 AND DATE_VENTE BETWEEN '".$d1_traite."' AND '".$d2_traite."'
                                 GROUP BY c.NUM_CLI
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Fonction affichage des ventes au cours d'une periode donnée
  public function ClassementVenteCliGros($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d"); 
      $show=$this->con->prepare("SELECT NOM_CLI,PRENOM_CLI,SUM(PRIX_TOTAL) as total, SUM(MONT_PAYE) as montant
                                 FROM produit p, client c, vente v
                                 WHERE v.CODE_PROD=p.CODE_PROD AND v.NUM_CLI=c.NUM_CLI
                                 AND TYPE_CLI='Grossiste'
                                 AND DATE_VENTE BETWEEN '".$d1_traite."' AND '".$d2_traite."'
                                 GROUP BY c.NUM_CLI
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Calcule du prix total de vente garde au cours d'une periode
   function PrixPeriodeVente($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT SUM(MONT_PAYE) as somme
                                 FROM vente
                                 WHERE DATE_VENTE BETWEEN '".$d1_traite."' AND '".$d2_traite."'
                                 AND TYPE_VENTE='En gros'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }

  function PrixPeriodeVenteM($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT SUM(PRIX_TOTAL) as somme
                                 FROM vente
                                 WHERE DATE_VENTE BETWEEN '".$d1_traite."' AND '".$d2_traite."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }

  //Calcule du prix total de vente garde au cours d'une periode
   function PrixDetailPeriodeVente($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT SUM(MONT_PAYE) as somme
                                 FROM vente
                                 WHERE DATE_VENTE BETWEEN '".$d1_traite."' AND '".$d2_traite."'
                                 AND TYPE_VENTE='En detail'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }

  //Calcule du prix total de vente garde au cours d'une periode
   function PrixTotalPeriodeVente($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT SUM(PRIX_TOTAL) as total
                                 FROM vente
                                 WHERE DATE_VENTE BETWEEN '".$d1_traite."' AND '".$d2_traite."'
                                 AND TYPE_VENTE='En gros'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['total']."";
    } 
  }

  //Calcule du prix total de vente garde au cours d'une periode
   function PrixTotalFacture(){
      $show=$this->con->prepare("SELECT SUM(TOTAL_VENTE) as somme
                                 FROM vente
                                 WHERE DATE_VENTE = CURDATE()
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }

  //Calcule du prix total de vente garde au cours d'une periode
   function PrixTotalNet(){
      $show=$this->con->prepare("SELECT (SUM(TOTAL_VENTE)-SUM(REMISE_VENTE)) as net
                                 FROM vente
                                 WHERE DATE_VENTE = CURDATE()
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['net']."";
    } 
  }

  //Calcule du prix total de vente garde au cours d'une periode
   function TotalResteApayer(){
      $show=$this->con->prepare("SELECT (SUM(TOTAL_VENTE)-SUM(MONT_PAYE)) as reste
                                 FROM vente
                                 WHERE DATE_VENTE = CURDATE()
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['reste']."";
    } 
  }





  //-----------------Total vendu par mois-----------------------------------------//

                //------Mois de Janvier------------//   
   function TotalPrixJanvier($annee){
      $show=$this->con->prepare("SELECT SUM(PRIX_TOTAL) as somme
                                 FROM vente
                                 WHERE MONTH(DATE_VENTE)=1
                                 AND YEAR(DATE_VENTE)='".$annee."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
     foreach($res as $val){
      return  intval($val['somme']."");
    } 
  }

  function TotalPrixFevrier($annee){
      $show=$this->con->prepare("SELECT SUM(PRIX_TOTAL) as somme
                                 FROM vente
                                 WHERE MONTH(DATE_VENTE)=2
                                 AND YEAR(DATE_VENTE)='".$annee."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
     foreach($res as $val){
      return  intval($val['somme']."");
    } 
  }

  function TotalPrixMars($annee){
      $show=$this->con->prepare("SELECT SUM(PRIX_TOTAL) as somme
                                 FROM vente
                                 WHERE MONTH(DATE_VENTE)=3
                                 AND YEAR(DATE_VENTE)='".$annee."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
     foreach($res as $val){
      return  intval($val['somme']."");
    } 
  }

  function TotalPrixAvril($annee){
      $show=$this->con->prepare("SELECT SUM(PRIX_TOTAL) as somme
                                 FROM vente
                                 WHERE MONTH(DATE_VENTE)=4
                                 AND YEAR(DATE_VENTE)='".$annee."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
     foreach($res as $val){
      return  intval($val['somme']."");
    } 
  }

  function TotalPrixMai($annee){
      $show=$this->con->prepare("SELECT SUM(PRIX_TOTAL) as somme
                                 FROM vente
                                 WHERE MONTH(DATE_VENTE)=5
                                 AND YEAR(DATE_VENTE)='".$annee."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
     foreach($res as $val){
      return  intval($val['somme']."");
    } 
  }

  function TotalPrixJuin($annee){
      $show=$this->con->prepare("SELECT SUM(PRIX_TOTAL) as somme
                                 FROM vente
                                 WHERE MONTH(DATE_VENTE)=6
                                 AND YEAR(DATE_VENTE)='".$annee."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
     foreach($res as $val){
      return  intval($val['somme']."");
    } 
  }
  
  function TotalPrixJuillet($annee){
      $show=$this->con->prepare("SELECT SUM(PRIX_TOTAL) as somme
                                 FROM vente
                                 WHERE MONTH(DATE_VENTE)=7
                                 AND YEAR(DATE_VENTE)='".$annee."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
     foreach($res as $val){
      return  intval($val['somme']."");
    } 
  }

  function TotalPrixAout($annee){
      $show=$this->con->prepare("SELECT SUM(PRIX_TOTAL) as somme
                                 FROM vente
                                 WHERE MONTH(DATE_VENTE)=8
                                 AND YEAR(DATE_VENTE)='".$annee."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
     foreach($res as $val){
      return  intval($val['somme']."");
    } 
  }

  function TotalPrixSeptembre($annee){
      $show=$this->con->prepare("SELECT SUM(PRIX_TOTAL) as somme
                                 FROM vente
                                 WHERE MONTH(DATE_VENTE)=9
                                 AND YEAR(DATE_VENTE)='".$annee."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
     foreach($res as $val){
      return  intval($val['somme']."");
    } 
  }

  function TotalPrixOctobre($annee){
      $show=$this->con->prepare("SELECT SUM(PRIX_TOTAL) as somme
                                 FROM vente
                                 WHERE MONTH(DATE_VENTE)=10
                                 AND YEAR(DATE_VENTE)='".$annee."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
     foreach($res as $val){
      return  intval($val['somme']."");
    } 
  }

  function TotalPrixNovembre($annee){
      $show=$this->con->prepare("SELECT SUM(PRIX_TOTAL) as somme
                                 FROM vente
                                 WHERE MONTH(DATE_VENTE)=11
                                 AND YEAR(DATE_VENTE)='".$annee."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
     foreach($res as $val){
      return  intval($val['somme']."");
    } 
  }

  function TotalPrixDecembre($annee){
      $show=$this->con->prepare("SELECT SUM(PRIX_TOTAL) as somme
                                 FROM vente
                                 WHERE MONTH(DATE_VENTE)=12
                                 AND YEAR(DATE_VENTE)='".$annee."'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
     foreach($res as $val){
      return  intval($val['somme']."");
    } 
  }

  //Mail d'envoi de demande au service helpdesk 
public function mailEnvoiIncident($to){
$message="<img class='img-responsive' width='100' height='100' src='http://localhost:80/GesPhone/images/log.JPEG'> <br/><br/>
          Bonjour,<br/>
          Une vente vient d'être effectué. <a href='http://localhost:80/GesPhone/index.php'>Se connecter </a>
           ";  
$mail = new PHPMailer;
$mail->CharSet = "UTF-8";
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPDebug  = 2;
$mail->SMTPAuth = true;
$mail->Username = 'jeannostyle17@gmail.com';
$mail->Password = 'coollovejean';
$mail->SMTPSecure = 'tls';
$mail->SMTPAutoTLS = false;
$mail->Port = 587 ;
$mail->SetFrom('jeannostyle17@gmail.com', 'GesPhone');
$mail->addAddress($to);
$mail->addReplyTo('jeannostyle17@gmail.com');
$mail->WordWrap = 70;
$mail->isHTML(false);
$mail->Subject = "Notification de vente";
$mail->Body    = $message;
$mail->AltBody = 'bonjour';
if(!$mail->send()) {
    //echo 'Erreur';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message reussi';
}

}


  //Fonction affichage des dotations par produit
  public function ListerDotProdP($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d"); 
      $show=$this->con->prepare("SELECT p.ID_PROD, DESIGNATION, SUM(QTE_DOTATION) as somme,SUM(QTE_DOTATION)*PRIX as total                               
                                 FROM produit p, dotation d
                                 WHERE d.ID_PROD=p.ID_PROD
                                 AND DATE_DOTATION BETWEEN '".$d1_traite."' AND '".$d2_traite."' 
                                 AND TYPE_DOTATION='Pharmacie'
                                 GROUP BY p.ID_PROD
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

   //Fonction affichage des dotations par produit
  public function ListerDotProdG($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d"); 
      $show=$this->con->prepare("SELECT p.ID_PROD, DESIGNATION, SUM(QTE_DOTATION) as somme,SUM(QTE_DOTATION)*PRIX as total                               
                                 FROM produit p, dotation d
                                 WHERE d.ID_PROD=p.ID_PROD
                                 AND DATE_DOTATION BETWEEN '".$d1_traite."' AND '".$d2_traite."' 
                                 AND TYPE_DOTATION='Garde'
                                 GROUP BY p.ID_PROD
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      return $res;
  }

  //Calcul du prix total de l'approvisionnement
   function PrixTotalProdP($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT SUM((PRIX)*(QTE_DOTATION)) as somme
                                 FROM dotation d, produit p
                                 WHERE P.ID_PROD=d.ID_PROD
                                 AND DATE_DOTATION BETWEEN '".$d1_traite."' AND '".$d2_traite."' 
                                 AND TYPE_DOTATION='Pharmacie'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }

  //Calcul du prix total de l'approvisionnement
   function PrixTotalProdG($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT SUM((PRIX)*(QTE_DOTATION)) as somme
                                 FROM dotation d, produit p
                                 WHERE P.ID_PROD=d.ID_PROD
                                 AND DATE_DOTATION BETWEEN '".$d1_traite."' AND '".$d2_traite."' 
                                 AND TYPE_DOTATION='Garde'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }


  //Afficher quantite d'une dotation
    public function showQuantiteDotation($id){
      $show=$this->con->prepare("SELECT QTE_DOTATION FROM dotation WHERE ID_DOTATION='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['QTE_DOTATION']."";
    } 
  }

  //Afficher Id produit d'une dotation
    public function showIdProduitDote($id){
      $show=$this->con->prepare("SELECT ID_PROD FROM dotation WHERE ID_DOTATION='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['ID_PROD']."";
    } 
  }

   //Afficher type d'une dotation
    public function showTypeDote($id){
      $show=$this->con->prepare("SELECT TYPE_DOTATION FROM dotation WHERE ID_DOTATION='".$id."'");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['TYPE_DOTATION']."";
    } 
  }

	//Calcule le nombre total de dotation au cour d'une periode donnée
   function compterDotationPeriode($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT count('ID_DOTATION') as valeur
                                 FROM dotation
                                 WHERE DATE_DOTATION BETWEEN '".$d1_traite."' AND '".$d2_traite."' 
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['valeur']."";
    } 
  }

  //Calcule du prix total de la dotation pharmacie
   function PrixDotationPharma($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT SUM((PRIX)*(QTE_DOTATION)) as somme
                                 FROM dotation d, produit p
                                 WHERE P.ID_PROD=d.ID_PROD
                                 AND TYPE_DOTATION='Pharmacie'
                                 AND DATE_DOTATION BETWEEN '".$d1_traite."' AND '".$d2_traite."' 
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }

  //Calcul du prix total de la dotation garde
   function PrixDotationGarde($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT SUM((PRIX)*(QTE_DOTATION)) as somme
                                 FROM dotation d, produit p
                                 WHERE P.ID_PROD=d.ID_PROD
                                 AND TYPE_DOTATION='Garde'
                                 AND DATE_DOTATION BETWEEN '".$d1_traite."' AND '".$d2_traite."' 
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }

  //Calcul du prix total de la dotation garde
   function PrixDotPhVGarde2($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT SUM((PRIX)*(QTE_DOTATION)) as somme
                                 FROM dotation d, produit p
                                 WHERE P.ID_PROD=d.ID_PROD
                                 AND TYPE_DOTATION='PharmaVsGarde'
                                 AND DATE_DOTATION BETWEEN '".$d1_traite."' AND '".$d2_traite."' 
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }

   //Calcul du prix total de la dotation garde
   function PrixDotPharmaVgarde($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT SUM((PRIX)*(QTE_DOTATION)) as somme
                                 FROM dotation d, produit p
                                 WHERE P.ID_PROD=d.ID_PROD
                                 AND TYPE_DOTATION='PharmaVsGarde'
                                 AND DATE_DOTATION BETWEEN '".$d1_traite."' AND '".$d2_traite."' 
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['somme']."";
    } 
  }

  //Calcule le nombre total de dotation au cour d'une periode donnée pour une pharmacie
   function DotationPeriodePharma($d1,$d2){
      $d1_traite = date_format(date_create(str_replace("/", "-",$d1)), "Y-m-d");
      $d2_traite = date_format(date_create(str_replace("/", "-", $d2)), "Y-m-d");
      $show=$this->con->prepare("SELECT count('ID_DOTATION') as valeur
                                 FROM dotation
                                 WHERE DATE_DOTATION BETWEEN '".$d1_traite."' AND '".$d2_traite."' 
                                 AND TYPE_DOTATION='Pharmacie'
                                 ");
      $show->execute();
      $res=$show->fetchAll();
      foreach($res as $val){
      return  $val['valeur']."";
    } 
  }
	
}



 ?>