<?php 
/**
 * Class abstraite
 */
require_once "connexion.php";
abstract class Model {
	protected $connexion;

	function __construct()
	{
		$this->connexion = Connexion::getInstance()->getConnexion();

	}
	/**
	 * Exécuter une requete
	 * @param  [type] $requete [description]
	 * @param  array $params  les paramètre de la requete
	 * @return [type]          [description]
	 */
	protected function executerRequete($requete , $params = null){

		if($params == null)
		{
			//exécution de la requete s'il n'y a pas de paramètre
			$resultat = $this->connexion->query($requete);
		}
		else
		{
			//préparation de la requête
			$prepare = $this->connexion->prepare($requete);
			$type_param = "";
			$a_params = array();
			$types="";
			for($i=0;$i<count($params);$i++)
			{
				$a_params[] = &$params[$i];
				$type = gettype($params[$i]);
				switch($type)
				{
					case 'integer' :
					{
						$types.="i";
						break;
					}
					case 'double' :
					{
						$types.="d";
						break;
					}
					default : 
					{
						$types.="s";
						break;
					}
				}
			}
			$ref_types=&$types;
			array_unshift($a_params, $ref_types);
			call_user_func_array(array($prepare, "bind_param"),$a_params);
			$prepare->execute();
			$resultat = $prepare->get_result();
		}
		return $resultat;
	}
}
?>