<?php
class Db
{
    private static $instance = null;
    private $_db;

    /*  ORIGINAL CONSTRUCTOR */
	
	/*	private function __construct()
    {
        try {
            $this->_db = new PDO('mysql:host=localhost;dbname=bdbn', 'root', '');
            $this->_db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$this->_db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
        } 
		catch (PDOException $e) {
		    die('Erreur de connexion à la base de données : '.$e->getMessage());
        }
    }*/
	
	/*  CONSTRUCTOR AZURE COMPLIANT */
	private function __construct()
				{
					$connectstr_dbhost = '';
					$connectstr_dbname = '';
					$connectstr_dbusername = '';
					$connectstr_dbpassword = '';
			
					foreach ($_SERVER as $key => $value) {
						if (strpos($key, "MYSQLCONNSTR_localdb") !== 0) {
							continue;
						}
						
				$connectstr_dbhost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
				$connectstr_dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
				$connectstr_dbusername = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
				$connectstr_dbpassword = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
					}
			        try {
			            $this->_db = new PDO("mysql:host=$connectstr_dbhost;dbname=bdbn", $connectstr_dbusername, $connectstr_dbpassword);
			            $this->_db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
						$this->_db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
			        } 
					catch (PDOException $e) {
					    die('Erreur de connexion à la base de données : '.$e->getMessage());
			        }
    }


	# Pattern Singleton
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Db();
        }
        return self::$instance;
    }

	# Fonction qui exécute un SELECT dans la table des livres 
	# et qui renvoie un tableau d'objet(s) de la classe Livre
	public function select_livres() {
		# Définition du query
		$query = 'SELECT * FROM livres ORDER BY no DESC';
		
		# Exécution du query
		$result = $this->_db->query($query); 

		# Parcours de l'ensemble des résultats et construction d'un tableau d'objet(s) de la classe Livre
		$tableau = array();
		if ($result->rowcount()!=0) {
			while ($row = $result->fetch()) {		
				$tableau[] = new Livre($row->no,$row->titre,$row->auteur);
			}
		}	
		# pour debug : affichage ici possible de l'array à l'aide de var_dump($tableau);
		# var_dump($tableau);
		return $tableau;
	}	
}