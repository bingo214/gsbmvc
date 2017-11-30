<?php
if(isset($_GET['action']) && $_GET['action'] !== 'generatePDF') {
    include("vues/v_sommaire_comptable.php");
}
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];
switch($action){

    case 'demandeSuiviPaiement':
        //var_dump($idUtilisateur);
        $fiches = $pdo->getFichesValidees();
        // Une demande de suivi de fiche a été saisie
        if(isset($_GET['fiche'])){
            $infos = explode('-', $_GET['fiche']);
            if(isset($infos[0]) && isset($infos[1])){
                $laFiche['forfait'] = $pdo->getLesFraisForfait($infos[1], $infos[0]);
                $laFiche['hors_forfait'] = $pdo->getLesFraisHorsForfait($infos[1], $infos[0]);
                $laFiche['mois'] = $infos[0];//le Mois
                $laFiche['visiteur'] = $infos[1];// idVisiteur
            }else {
                $laFiche['forfait'] = $laFiche['hors_forfait'] = [];
            }
        }

        require "vues/v_Suivi_Paiement.php";
        break;

    case 'generatePDF':
        // Si "fiche" existe:
        if(isset($_GET['fiche'])){
           // Explode() Coupe une chaîne en segments, elle retourne un tableau de chaînes
            $infos = explode('-', $_GET['fiche']);
            if(isset($infos[0]) && isset($infos[1])){ // infos[0]= mois et infos[1]= idvisiteur
                $laFiche['visiteur'] = $pdo->getVisiteur($infos[1]);
                $laFiche['forfait'] = $pdo->getLesFraisForfait($infos[1], $infos[0]);
                $laFiche['hors_forfait'] = $pdo->getLesFraisHorsForfait($infos[1], $infos[0]);
                
            }else {
                $laFiche['forfait'] = $laFiche['hors_forfait'] = [];
            }

            if(empty($laFiche['forfait']) && empty($laFiche['hors_forfait'])){
                setFlash("La fiche demandée n'existe pas");
                header('location:index.php?uc=suiviPaiement&action=demandeSuiviPaiement');
                die();
            }
        }
        require "vues/v_generatePDF.php";
        creerPDFFiche($laFiche);
        break;

    case 'metEnPaiement':
        $pdo->mettreEnPaiement($_POST['visiteur'], $_POST['mois']);
        alert("La fiche a bien été mise en paiement");
        header('location:index.php?uc=suiviPaiement&action=demandeSuiviPaiement');
        break;
}