<?php
require_once 'categorie_controller.php';
require_once 'fiche_controller.php'; 
class Router {
	private $categorie_ctrl;
	private $fiche_ctrl;

	public function __construct()
	{
		$this->categorie_control = new Categorie_controller();
		$this->fiche_control = new Fiche_controller();
	}
	/**
	 * Router requete
	 * @return [type] [description]
	 */
	public function routeRequete(){
		if(!isset($_GET['action']))
		{
			$this->categorie_control->acceuil();
		}
		else {
			$action = $_GET['action'];
			switch($action)
			{
				case 'getallcategories' : 
				{
					$this->categorie_control->getAll();
					break;
				}
				case 'ajoutercategorie' : 
				{
					$this->categorie_control->ajouterCategorie();
					break;

				}
				case 'supprimercategorie' :
				{
					$this->categorie_control->supprimerCategorie();
					break;
				}
				case 'modifiercategorie' : 
				{
					$this->categorie_control->modifierCategorie();
					break;
				}
				case 'getCategorieList' : 
				{
					$this->categorie_control->getCategorieList();
					break;
				}
				case 'getfiches' :
				{
					$this->fiche_control->getAll();
					break;
				}
				case 'ajouterFiche' :
				{
					$this->fiche_control->ajouterFiche();
					break;
				}
				case 'supprimerFiche' : 
				{
					$this->fiche_control->supprimerFiche();
					break;
				}
				case 'modifierFiche' : 
				{
					$this->fiche_control->modifierFiche();
					break;
				}
				case 'getFicheCategories' : 
				{
					$this->fiche_control->getFicheCategories();
					break;
				}
				default : 
				{
					$this->categorie_control->acceuil();
					break;
				}
			}
		}
	}
} 
?>