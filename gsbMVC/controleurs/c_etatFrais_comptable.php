<?php
include("vues/v_sommaire_comptable.php");
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];

switch($action){
    
    case "demandeValiderFrais": {
        

        $part = isset($_GET['part'])? $_GET['part'] : '1';
        
        $liste_mois = $pdo->getLesMoisNonValides();
        
        $aValider = [];
        
        
        foreach($liste_mois as $mois){
            $anneeCourante = substr($mois["mois"], 0, 4);
            $moisCourant = substr($mois["mois"], 4, 2);
            
            if(!array_key_exists($anneeCourante, $aValider)){
                
                $aValider[$anneeCourante] = [];
            }
            
            if(!in_array($moisCourant, $aValider[$anneeCourante])){
                
                $aValider[$anneeCourante][] = $moisCourant;
            }
        }
        
       if($part === "2"){
            
            $visiteurs = $pdo->getVisiteursParDate($_GET['lstmois']);
            
           }
        
        if(isset($_GET['lstvisiteurs'])){
            
            $afficherFiche = true;
            $LesInfoFicheFrais= $pdo->getLesInfosFicheFrais($_GET['lstvisiteurs'],$_GET['lstmois']);
            
            $libelleEtat= $LesInfoFicheFrais['libEtat'];
            $montantValide=$LesInfoFicheFrais['montantValide'];
            $dateModif=$LesInfoFicheFrais['dateModif'];
            
            $fiche["forfait"] = $pdo->getLesFraisForfait($_GET['lstvisiteurs'], $_GET['lstmois']);
            
            $fiche["horsForfait"] = $pdo->getLesFraisHorsForfait($_GET['lstvisiteurs'], $_GET['lstmois']);
                       
        }
        include("vues/v_listeMois_Comptable.php");
        break;
    }
         case "validerFicheFrais": {
        $pdo->validerFicheFrais($_POST['idvisiteur'], $_POST['mois']);
        
        header('location:index.php?uc=validationFrais&action=demandeValiderFrais');
        break;
    }

    case "actualiserFrais": {
        $pdo->majFraisForfait($_POST['idvisiteur'], $_POST['mois'], $_POST['frais']);
        // Affichage du message "informations actualisées" dans la vue précédente
         
        header("location:index.php?uc=validationFrais&action=demandeValiderFrais&part=2&lstmois={$_POST['mois']}&lstvisiteurs={$_POST['idvisiteur']}");
        break;
    }

    case "supprimerFrais": {
        $pdo->majFraisHorsForfait($_POST['idfrais']);
        
        header("location:index.php?uc=validationFrais&action=demandeValiderFrais&part=2&lstmois={$_POST['lstmois']}&lstvisiteurs={$_POST['lstvisiteurs']}");
        break;
    }

    case "reporterFrais": {
        $mois = $_POST['lstmois'];
        $visiteur = $_POST['lstvisiteurs'];
        $idFrais = $_POST['idfrais'];
        $libelle = $_POST['libelle'];
        $montant = $_POST['montant'];
        $pdo->reporterHorsForfait($idFrais, $visiteur, $mois, $libelle, $montant);
        header("location:index.php?uc=validationFrais&action=demandeValiderFrais&part=2&lstmois=$mois&lstvisiteurs=$visiteur");
        break;
    }

   
}