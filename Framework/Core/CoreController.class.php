<?php
	use Jenssegers\Blade\Blade;

	class CoreController{

		// Load model
		public static function model($model){
			// Require model file
			require_once('../app/models/'.$model.'.php');

			// Instantiate model
			return new $model();
		}
		// Load view
		public static function view($view,$data=[]){
			// Check for view file
			if(file_exists('../app/views/'.$view.'.php')){
				require_once '../app/views/' . $view . '.php';
			}
			else{
				// View does not exist
				die('View doesn\'t exist');
			}
		}
	}
?>