<?php 
/**
 * Catégorie modele
 * Assure la récupération des données depuis la bdd pour les catégories
 */
require_once "model.php";
require_once __DIR__."/../categorie.php";
class Categorie_model extends Model{
	public function getAll(){
		$donnees = array();
		$requete = "SELECT 
					libelle AS name,
					id AS id,
					id_pere
					FROM categories";
		$categories = $this->executerRequete($requete);
		while ($ligne = mysqli_fetch_assoc($categories)) {
			$donnees[] = $ligne;
		}
		return $donnees;
	}

	public function supprimerCategorie($id_categorie)
	{
		$requete = "DELETE FROM categories
					WHERE id=?
					LIMIT 1";
		$this->executerRequete($requete,array($id_categorie));
		$requete = "DELETE FROM categories
					WHERE id_pere=?
					LIMIT 1";
		$this->executerRequete($requete,array($id_categorie));
		return true;
	}
	public function ajouterCategorie(Categorie $categorie)
	{

		$requete ="INSERT INTO categories
				  SET 
				  	 libelle=?,
				  	 id_pere=?
				 ";
		$this->executerRequete($requete,array($categorie->getLibelle(),$categorie->getId_pere()));
	}
	public function modifierCategorie(Categorie $categorie)
	{
		$requete = "UPDATE categories
					SET
						libelle=?,
						id_pere=?
					WHERE id=?";
		$this->executerRequete($requete,array($categorie->getLibelle(),$categorie->getId_pere(),$categorie->getId()));
		return true;
	}
	public function getCategorie($id_categorie)
	{
		$requete = "SELECT 
						libelle,
						id_pere
					FROM categories
					WHERE id=?";
		$categorie = $this->executerRequete($requete,$id_categorie);
		$donnees = array();
		if($ligne=mysqli_fetch_assoc($categorie))
		{
			$donnees = $ligne;
		}
		return $donnees;
	}
}
?>