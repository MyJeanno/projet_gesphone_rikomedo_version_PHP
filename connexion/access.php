<?php 

class Access
{
	// Connexion a la base de donnee Mysql
  public function connection(){
   try{
    $bdd = new pdo('mysql:host=localhost; dbname=phone','root','');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }catch(PDOException $e){
    echo "Une erreur est survenue".$e->getMessage();
  }
  return $bdd;
 } 
}

?>