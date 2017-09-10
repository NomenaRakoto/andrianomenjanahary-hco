<?php 
/**
 * fiche modele
 * Assure la recuperation des données depuis la base de données pour les fiches
 * Casse héritant du class abstraite Model
 */
require_once "model.php";
require_once __DIR__."/../Controller/fiche.class.php";
class Fiche_model extends Model {

	/**
	 * obtenir toutes les fiches
	 * @return array
	 */
	public function getAll(){
		$requete = "SELECT id_fiche,libelle_fiche,description FROM fiches";
		$fiches = $this->executerRequete($requete);
		$donnees = array();
		while( $ligne = mysqli_fetch_assoc($fiches) ) {
			$ligne['categories'] = $this->getCategoriesFiche($ligne['id_fiche']);
			$donnees[] = $ligne;
		}
		return $donnees;
	}

	/**
	 * Obtenir tous les catégories d'une fiche
	 * @param  int $id_fiche id de la fiche
	 * @return array         catégories de la fiche
	 */
	public function getCategoriesFiche($id_fiche)
	{
		$requete = "SELECT 
					  CF.id_categorie AS id_categorie,
					  C.libelle AS libelle
					FROM categorie_fiche CF
					INNER JOIN categories C ON C.id=CF.id_categorie
					WHERE CF.id_fiche=?";
		$categories = $this->executerRequete($requete,array(intval($id_fiche)));
		$donnees = array();
		while($ligne = mysqli_fetch_assoc($categories))
		{
			$donnees[] = new Categorie($ligne['id_categorie'],$ligne['libelle'],null);
		}
		return $donnees;
	}

	/**
	 * Supprimer une fiche
	 * @param int $id_fiche id de la fiche
	 */
	public function SupprimerFiche($id_fiche)
	{
		$requete = "DELETE FROM fiches
				    WHERE id_fiche=?
				    LIMIT 1
				   ";
		$this->executerRequete($requete,array($id_fiche));
		return true;
	}

	/**
	 * Modifier une fiche
	 * @param  Fiche  $fiche Objet fiche
	 * @return booléenne        
	 */
	public function modifierFiche(Fiche $fiche)
	{
		$requete = "UPDATE fiches
					SET libelle_fiche=?
						,description=?
					WHERE id_fiche=?
					LIMIT 1
		           ";
		$this->executerRequete($requete,array($fiche->getLibelle(),$fiche->getDescription(),$fiche->getId()));

		//Modification catégorie
		$requete = "DELETE FROM categorie_fiche WHERE id_fiche=?";
		$this->executerRequete($requete,array($fiche->getId()));

		//ajouter les catégories
		$categories = $fiche->getCategories();
		foreach ($categories as $key => $categorie) {
			$requete = "INSERT INTO categorie_fiche 
						SET 
							id_fiche=?,
							id_categorie=?";
			$this->executerRequete($requete,array($fiche->getId(),$categorie->getId()));
		}
		return true;
	}
	/**
	 * Ajouter une fiche
	 * @param  Fiche  $fiche Objet fiche
	 * @return booléenne      
	 */
	public function ajouterFiche(Fiche $fiche)
	{
		$requete = "INSERT INTO fiches
					SET 
						libelle_fiche=?,
						description=?";
		$this->executerRequete($requete,array($fiche->getLibelle(),$fiche->getDescription()));
		$fiche->setId($this->connexion->insert_id);
		//ajouter les catégories
		$categories = $fiche->getCategories();
		foreach ($categories as $key => $categorie) {
			$requete = "INSERT INTO categorie_fiche 
						SET 
							id_fiche=?,
							id_categorie=?";
			$this->executerRequete($requete,array($fiche->getId(),$categorie->getId()));
		}
		return true;
	}
	/**
	 * Obtenir une fiche
	 * @param  int $id_fiche id d'une fiche
	 * @return array           information concernant la fiche
	 */
	public function getFiche($id_fiche)
	{
		$requete = "SELECT 
						id_fiche,
						libelle_fiche
					FROM fiches 
					WHERE id_fiche=?";
		$fiche = $this->executerRequete($requete,array($id_fiche));
		if( $ligne = mysqli_fetch_assoc($fiche) ) {
			$ligne['categories'] = $this->getCategories($ligne['id_fiche']);
			return $ligne;
		}
		return null;
	}
	public function getFicheCategories($id_fiche)
	{
		$requete = "SELECT 
						id_categorie
					FROM categorie_fiche 
					WHERE id_fiche=?";
		$categories = $this->executerRequete($requete,array($id_fiche));
		$data = array();
		foreach ($categories as $key => $categorie) {
			$data[] = $categorie;
		}
		return $data;
	}
}
?>