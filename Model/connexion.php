<?php
require_once __DIR__."/../Config/config.php";
 class Connexion{
	private $config;
	private static $_instance;
	private $connexion;

	private function __construct(){
		//obtenir les configurations depuis le fichier : server,user,password,db_name
		$this->config = Config::getInstance(__DIR__."/../Config/config.ini");
		$this->connexion = new mysqli($this->config->get(0),$this->config->get(1),$this->config->get(2),$this->config->get(3));
		if($this->connexion->connect_errno)
		{
			die("Erreur de la connexion : ".$this->connexion->connect_error);
		}
		else
		{
			return true;
		}
	}
	public static function getInstance()
	{
		if(is_null(self::$_instance))
		{
            self::$_instance = new Connexion();
		}
		return self::$_instance;
	}
	/**
	 * Obtenir la connexion à la base de données
	 * @return connexion
	 */
	public function getConnexion()
	{
		return $this->connexion;
	}
}
?>