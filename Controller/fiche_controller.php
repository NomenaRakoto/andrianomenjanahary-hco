<?php 
require_once 'controller.php';
class Fiche_controller extends Controller {
	private $fiche_model;
	public function __construct()
	{
		$this->fiche_model = $this->loadModel("fiche");
	}

	/**
	 * Ajouter une fiche
	 * @return [type] [description]
	 */
	public function ajouterFiche()
	{
		$donnees = $_POST['donnees'];
		$categories = [];
		foreach ($donnees['categories'] as $key => $id_categorie) {
			$categories[] = new Categorie($id_categorie,null,null);
		}
		$fiche = new Fiche(null,$donnees['libelle'],$donnees["description"],$categories);
		$this->fiche_model->ajouterFiche($fiche);
	}
	/**
	 * Supprimer une fiche
	 * @return [type] [description]
	 */
	public function supprimerFiche()
	{
		$id_fiche = $_POST["id_fiche"];
		$this->fiche_model->supprimerFiche(intval($id_fiche));
	}
	/**
	 * Modifier une fiche
	 * @return [type] [description]
	 */
	public function modifierFiche()
	{
		$donnees = $_POST['donnees'];
		$categories = [];
		foreach ($donnees['categories'] as $key => $id_categorie) {
			$categories[] = new Categorie($id_categorie,null,null);
		}
		$fiche = new Fiche(intval($donnees['id_fiche']),$donnees['libelle'],$donnees['description'],$categories);
		$this->fiche_model->modifierFiche($fiche);
	}
	/**
	 * Get fiche catégorie
	 * @return [type] [description]
	 */
	public function getFicheCategories(){
		$id_fiche = $_POST['id_fiche'];
		$categories = $this->fiche_model->getFicheCategories($id_fiche);
		$data = array();
		foreach ($categories as $key => $categorie) {
			$data[] = $categorie['id_categorie'];
		}
		echo json_encode($data);
	}
	/**
	 * getAll fiches
	 * @return Array Fiche 
	 */
	public function getAll()
	{
		$donnees = $this->fiche_model->getAll();
		$fiches = array();
		foreach ($donnees as $ligne) {
			$fiche = new Fiche($ligne['id_fiche'],$ligne['libelle_fiche'],$ligne["description"], $ligne['categories']);
			$fiche = $fiche->toArray();
			$fiches[] = $fiche;
		}
		echo json_encode($fiches);

	}

}
?>