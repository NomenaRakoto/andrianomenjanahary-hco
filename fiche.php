<?php 
class Fiche {
	private $id;
	private $libelle;
	private $description;
	private $categories = [];

	public function __construct($id,$libelle, $description,$categories)
	{
		$this->id = $id;
		$this->libelle = $libelle;
		$this->description = $description;
		$this->categories = $categories;
	}
	public function setId($id){
		$this->id = $id;
	}
	public function setLibelle($libelle)
	{
		$this->libelle = $libelle;
	}
	public function setDescription($description)
	{
		$this->description = $description;
	}
	public function setCategories($categories)
	{
		$this->categories = $categories;
	}
	public function getId()
	{
		return $this->id;
	}
	public function getLibelle()
	{
		return $this->libelle;
	}
	public function getDescription()
	{
		return $this->description;
	}
	public function getCategories()
	{
		return $this->categories;
	}
	public function toArray()
	{
		return array("id_fiche"=>$this->id,"libelle_fiche"=>$this->libelle,"categories"=>$this->concatCategorie());
	}
	public function concatCategorie()
	{
		$result = "";
		foreach($this->categories as $categorie)
		{
			$result.="|".$categorie->getLibelle();
		}
		return substr($result, 1);
	}
}
?>