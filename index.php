<?php
	# Prise du temps actuel au début du script
	$time_start = microtime(true);

	# Variables globales du site
	define('CHEMIN_VUES','views/');
    define('EMAIL','jeanluc.collinet@ipl.be');
	$date = date("j/m/Y");

    $ini = parse_ini_file ( 'conf/conf.ini', FALSE,  INI_SCANNER_NORMAL);

    define('BDD',$ini['db_name']);
    define('USERNAME',$ini['db_user']);
    define('PASSWORD',$ini['db_password']);


	# Require des classes automatisé
	function chargerClasse($classe) {
		require 'models/' . $classe . '.class.php';
	}
	spl_autoload_register('chargerClasse'); 

	# Ecrire ici le header de toutes pages HTML
	require_once(CHEMIN_VUES . 'header.php');
	
	# Ecrire ici le menu du site de toutes pages HTML
	require_once(CHEMIN_VUES . 'menu.php');

	# Tester si une variable GET 'action' est précisée dans l'URL index.php?action=...
	$action = (isset($_GET['action'])) ? htmlentities($_GET['action']) : 'default';

	function caseGenese(){
        require_once('controllers/GeneseController.php');
        return new GeneseController();
    }

    function caseLivres(){
        require_once('controllers/LivresController.php');
        return new LivresController();
    }

    function caseContact(){
        require_once('controllers/ContactController.php');
        return new ContactController();
    }

    function caseAccueil(){
        require_once('controllers/AccueilController.php');
        return new AccueilController();
    }

    function caseFilms(){
	    require_once ('controllers/FilmsController.php');
	    return new FilmsController();
    }

	# Quelle action est demandée ?
	switch($action) {
		case 'genese':
			$controller = caseGenese();
			break;
		case 'livres':
			$controller = caseLivres();
			break;
		case 'contact':
			$controller = caseContact();
			break;
        case 'films':
            $controller = caseFilms();
            break;
		default: # Par défaut, le contrôleur de l'accueil est sélectionné
			$controller = caseAccueil();
			break;
	}
	# Exécution du contrôleur correspondant à l'action demandée
	$controller->run();
	
	# Ecrire ici le footer du site de toutes pages HTML
	require_once(CHEMIN_VUES . 'footer.php');

?>