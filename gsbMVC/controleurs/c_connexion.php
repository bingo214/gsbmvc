<?php
if(!isset($_REQUEST['action'])){
	$_REQUEST['action'] = 'demandeConnexion';
}
$action = $_REQUEST['action'];
switch($action){
	case 'demandeConnexion':{
		include("vues/v_connexion.php");
		break;
	}
	case 'valideConnexion':{
		$login = $_REQUEST['login'];
		$mdp = $_REQUEST['mdp'];
                $mdpC=md5($mdp);
		$visiteur = $pdo->getInfosVisiteur($login,$mdpC);
		if(!is_array( $visiteur)){
			ajouterErreur("Login ou mot de passe incorrect");
			include("vues/v_erreurs.php");
			include("vues/v_connexion.php");
		}
		else{
			$id = $visiteur['id'];
			$nom =  $visiteur['nom'];
			$prenom = $visiteur['prenom'];
                        $comptable=$visiteur['comptable'];
                        if($comptable == 0){
			connecter($id,$nom,$prenom);
			include("vues/v_sommaire_visiteur.php");
                        }
                        else{
                            connecter($id,$nom,$prenom);
                            include("vues/v_sommaire_comptable.php");
                        }
		}
		break;
	}
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>