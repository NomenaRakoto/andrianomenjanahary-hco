<?php

 class Config{
	private $settings = [];
	private static $_instance;

	private function __construct($file){
		$this->settings =explode("\n",file_get_contents($file));
	}
	public static function getInstance($file)
	{
		if(is_null(self::$_instance))
		{
            self::$_instance = new Config($file);
		}
		return self::$_instance;
	}
	/**
	 * obtenir les configurations
	 * @param  int $key clé
	 * @return string      configuration
	 */
	public function get($key)
	{
		if(!isset($this->settings[$key]))
		{
			return null;
		}
		return trim($this->settings[$key]);
	}
}
?>