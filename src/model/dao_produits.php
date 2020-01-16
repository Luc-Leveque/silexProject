<?php			// dao_user.php
class DaoProduits {
	const TABLE_NAME = "produit";
	static $pdo;
	 public static function connect() {		
		 if (!isset($pdo) ){
			$hote = 'localhost';
			$nom_bdd = 'ceudajaxjs';
			$utilisateur = 'root';
			$mot_de_passe ='';
			self::$pdo = new PDO('mysql:host='.$hote.';dbname='.$nom_bdd, $utilisateur, $mot_de_passe, 
								array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
			self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		 }
		 return self::$pdo;
	 }
	
	 public static function find($id) {		
		if ($pdo = self::connect()) {
			$requete = $pdo->prepare("SELECT * FROM ".self::TABLE_NAME ." WHERE `id_produit` = :id");
			$requete->bindParam(':id', $id);	
			$requete->execute();
			$resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
			return $resultats;
		}
		return null;	 
	}
	
	
	 public static function findAll() {		
		if ($pdo = self::connect()) {
			$requete = $pdo->prepare("SELECT * FROM ".self::TABLE_NAME );
			$requete->execute();
			$resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
			return $resultats;
		}
		return null;
	 }

}
