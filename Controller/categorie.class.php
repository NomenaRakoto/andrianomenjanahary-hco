<?php 
/**
 * Class Categorie
 */
class Categorie
{
	private $id;
	private $libelle;
	private $id_pere;
	public function __construct($id,$libelle,$id_pere){
		$this->id = $id;
		$this->libelle = $libelle;
		$this->id_pere = $id_pere;
	}
	public function setId($id){
		$this->id = $id;
	}
	public function setLibelle($libelle)
	{
		$this->libelle = $libelle;
	}
	public function setId_pere($id_pere)
	{
		$this->id_pere = $id_pere;
	}
	public function getId()
	{
		return $this->id;
	}
	public function getLibelle()
	{
		return $this->libelle;
	}
	public function getId_pere()
	{
		return $this->id_pere;
	}
}
?>