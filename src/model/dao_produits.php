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
			$resultats = $requete->fetch(PDO::FETCH_ASSOC);
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

	 public static function add($user) {		
		if ($pdo = self::connect()) {
			$sql = "INSERT INTO ". self::TABLE_NAME  
					."(libelle, prix_unitaire, reference)" 
					."VALUES (:libelle, :prix_unitaire, :reference)";


			$stmt= $pdo->prepare($sql);
			$stmt->execute($user);
			$idUser=$pdo->lastInsertId();
			return self::find($idUser);
		}
		return null;	 
	}

	public static function update($user) {			
		$params = array();
		$clauseWhere = "";
		
		foreach ($user as $attr => $val ){
			if ($attr == "id_produit") $clauseWhere = "id_produit = $val";						
			else {
				$valeur = (is_numeric($val))?$val:"'$val'";
				$params[] = "$attr = $valeur";
			}
		}	
		$clauseUpdate = implode(", ", $params);
		if (($pdo = self::connect()) && !empty($clauseUpdate) && !empty($clauseWhere)) {
			$sql = "UPDATE ". self::TABLE_NAME  
					." SET $clauseUpdate WHERE $clauseWhere" ;

 			$x =$pdo->exec($sql);
			return self::find($user["id_produit"]);
		}
		return null;	 
	}

	public static function delete($id) {		
		if (($pdo = self::connect()) && !empty($id)) {
			$sql = "DELETE FROM ".self::TABLE_NAME ." WHERE `id_produit` = $id";
			return $pdo->exec($sql);  // returns 0 or 1
		}
		return false;
	}

}
