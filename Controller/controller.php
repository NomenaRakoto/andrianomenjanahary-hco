<?php 
/**
 * classe abstraite
 */
require_once __DIR__.'/../Model/categorie_model.php';
require_once __DIR__.'/../Model/fiche_model.php';
abstract class Controller
{
	/**
	 * Load a model
	 * @param  string $model nom du model
	 * @return [type]        [description]
	 */
	protected function loadModel($model)
	{
		require_once __DIR__.'/../Model/'.$model.'_model.php';
		$model = ucfirst($model)."_model";
		return new $model();
	}
	/**
	 * Load a view
	 * @param  [type] $vue  nom de la vue
	 * @param  [type] $data Variable will be visible to the view
	 * @return [type]       [description]
	 */
	protected function loadVue($vue,$data){
		foreach ($data as $key => $value) {
			$$key = $value;
		}
		require_once __DIR__."/../View/".$vue.'.php';
	}
}
?>