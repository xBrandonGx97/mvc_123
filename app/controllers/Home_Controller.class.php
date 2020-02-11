<?php
#	use Classes\Utils\Browser;
	use Classes\Utils\User;
	use Classes\Base\Langs;

	Class Home_Controller Extends CoreController{
		public static function index(){
			self::view('home/index');
		}
	}
?>