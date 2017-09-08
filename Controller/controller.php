<?php 
require_once __DIR__.'/../Model/categorie_model.php';
require_once __DIR__.'/../Model/fiche_model.php';
abstract class Controller
{
	protected function loadModel($model)
	{
		require_once __DIR__.'/../Model/'.$model.'_model.php';
		$model = ucfirst($model)."_model";
		return new $model();
	}
	protected function loadVue($vue,$data){
		foreach ($data as $key => $value) {
			$$key = $value;
		}
		require_once __DIR__."/../View/".$vue.'.php';
	}
}
?>