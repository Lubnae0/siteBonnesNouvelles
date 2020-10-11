<?php 
class adminController{
	
	public function __construct() {

	}
			
	public function run(){	
		
		# Un contrôleur se termine en écrivant une vue
		require_once(CHEMIN_VUES . 'accueil.php');
	}
	
}