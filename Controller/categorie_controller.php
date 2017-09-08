<?php 
require_once 'controller.php';
class Categorie_controller extends Controller {
	private $categorie_model;
	private $fiche_model;
	public function __construct(){
		$this->categorie_model = $this->loadModel("categorie");
		$this->fiche_model = $this->loadModel("fiche");
	}
	public function acceuil()
	{
		$donnees = $this->fiche_model->getAll();
		$fiches = array();
		foreach ($donnees as  $ligne) {
			$fiche = new Fiche($ligne["id_fiche"],$ligne["libelle_fiche"],$ligne["description"],$ligne["categories"]);
			$fiches[] = $fiche;
		}
		$donnees = $this->categorie_model->getAll();
		$categories = array();
		foreach ($donnees as  $ligne) {
			$categorie = new Categorie($ligne["id"],$ligne["name"],$ligne["id_pere"]);
			$categories[] = $categorie;
		}
		$this->loadVue("main",array("fiches"=>$fiches,"categories"=>$categories));
	}
	public function getAll()
	{
		$data = $this->categorie_model->getAll();
		// Build array of item references:
		$itemsByReference = array();
		foreach($data as $key => &$item) {
		   $itemsByReference[$item['id']] = &$item;
		   // Children array:
		   $itemsByReference[$item['id']]['children'] = array();
		}
		// Set items as children of the relevant parent item.
		foreach($data as $key => &$item)
		{
		   if($item['id_pere'] && isset($itemsByReference[$item['id_pere']]))
		   {
		   	  $temp = $item['id_pere'];
		   	  unset($item['id_pere']);
		      $itemsByReference [$temp]['children'][] = &$item;
		   }
		}
		$result = array();
	   // Remove items that were added to parents elsewhere:
		foreach($data as $key => &$item) {
		   if(empty($item['id_pere']) && array_key_exists("id_pere", $item)){
			    unset($item['id_pere']);
			    $result[] = $item;
			}
		}
		unset($data);
		unset($itemsByReference);
		echo json_encode($this->utf8ize($result));
	}
	public function ajouterCategorie(){
		$donnees = $_POST['donnees'];
		$categorie = new Categorie(null,$donnees['libelle'],intval($donnees['id_pere']));
		$this->categorie_model->ajouterCategorie($categorie);
		echo "true";
	}
	public function supprimerCategorie()
	{
		$id_categorie = $_POST['id_categorie'];
		$id_categorie = intval($id_categorie);
		$this->categorie_model->supprimerCategorie($id_categorie);
	}
	public function modifierCategorie(){
		$donnees = $_POST['donnees'];
		$categorie = new Categorie(intval($donnees['id']),$donnees['libelle'],intval($donnees['id_pere']));
		$this->categorie_model->modifierCategorie($categorie);
	}
	private function utf8ize($d) {
		    if (is_array($d))
		        foreach ($d as $k => $v) 
		            $d[$k] = $this->utf8ize($v);

		     else if(is_object($d))
		        foreach ($d as $k => $v) 
		            $d->$k = $this->utf8ize($v);

		     else 
		        return utf8_encode($d);

		    return $d;
	}
}
?>