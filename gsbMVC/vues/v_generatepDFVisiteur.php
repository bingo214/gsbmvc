<?php
function creerPDFFiche($lesFraisHorsForfait,$lesFraisForfaits){
    $listeMois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre','Décembre'];
    $mois = $_REQUEST['leMois'];
    $nom=$_SESSION['nom'];
    $prenom=$_SESSION['prenom'];
    require dirname(__DIR__) . DIRECTORY_SEPARATOR . "fpdf" . DIRECTORY_SEPARATOR . "fpdf.php";
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->Image("images/logo.jpg", 83, 10, 40, 28);
    $pdf->Ln(-13);
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->SetTextColor(16,80,122);
    $pdf->Cell(0, 100, utf8_decode("Remboursement de frais engages"), 0, 0, 'C');
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Ln(60);
    //Fiche Visiteur
    $pdf->Cell(50, 10, "Visiteur", 0, 0, 'L');
    $pdf->Cell(50, 10, utf8_decode(($nom . ' ' . $prenom)));
    $pdf->Ln(10);
    $pdf->Cell(50, 10, "Mois", 0, 0, 'L');
    // Récupération du mois sous forme de chaine et l'année, ex: novembre 2010
    // Fonction date(): Retourne une date sous forme d'une chaîne dont
    // le paramètre "n" est le format souhaité est signifie qu'il doit retourner les mois sans les zéros initiaux
    // Fonction strtotime: lit une date au format anglais fournie par le paramètre time,
    // et de la transformer en timestamp Unix (le nombre de secondes depuis le 1er Janvier 1970 à 00:00:00 UTC)
    // Fonction substr: Retourne un segment de chaîne 
    $pdf->Cell(50, 10, $listeMois[date('n', strtotime("01-" . substr($mois, 4, 2) . '-' . substr($mois, 0, 4))) - 1 ] . ' ' . substr($mois, 0, 4), 0, 0, 'C');
    $pdf->Ln(20);
    // Frais forfaitaires
    $pdf->SetTextColor(44,117,165);
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->Cell(45, 10, "Frais Forfaitaires", 1, 0, 'C');
    $pdf->Cell(45, 10, utf8_decode("Quantité"), 1, 0, 'C');
    $pdf->Cell(45, 10, "Montant Unitaire", 1, 0, 'C');
    $pdf->Cell(45, 10, "Total", 1, 0, 'C');
    $pdf->Ln(10);
    $totalFraisForfaits=0;
    // Parcours des frais forfaitaires reçus en paramètre
    foreach ($lesFraisForfaits as $fraisF){
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(45,10,utf8_decode($fraisF['libelle']),1,0,'L');
        $pdf->SetFont('Arial', '', 10);
        // Affichage des attributs concernés à chaque frais forfaits: 
        $pdf->Cell(45,10,$fraisF['quantite'],1,0,'C');
        $pdf->Cell(45,10,$fraisF['montant'],1,0,'C');
        $pdf->Cell(45,10,  ($fraisF['quantite']*$fraisF['montant']),1,0,'C');
        $pdf->Ln(10);
        $totalFraisForfaits+=$fraisF['quantite']*$fraisF['montant'];
    }
    $totalFraisHorsForfait = 0;
    $pdf->Ln(10);
    // Position en x avec 3 colonnes
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->SetTextColor(44,117,165);
    $pdf->Cell(180,10,"Autres Frais",1,0,'C');
    $pdf->Ln(10);
    $pdf->Cell(60, 10, "Date", 1, 0, 'C');
    $pdf->Cell(60, 10, "Libelle", 1, 0, 'C');
    $pdf->Cell(60, 10, "Montant", 1, 0, 'C');
    $pdf->Ln(10);
    foreach($lesFraisHorsForfait as $fraisHF){
         $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial', 'I', 10);
        // Affichage des attributs concernés à chaque frais forfaits: 
        $pdf->Cell(60, 10, $fraisHF['date'], 1, 0, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(60, 10, utf8_decode($fraisHF['libelle']), 1, 0, 'C');
        $pdf->Cell(60, 10, $fraisHF['montant'], 1, 0, 'C');
        $pdf->Ln(10);
        $totalFraisHorsForfait += $fraisHF['montant'];
    }
    $total=$totalFraisForfaits+$totalFraisHorsForfait;
    $pdf->Ln(10);
    $pdf->SetX($pdf->_getpageformat('A4')[0] -120);
    $pdf->Cell(50, 10, 'Total', 1, 0, 'C');
    $pdf->Cell(50, 10, $total, 1, 0, 'C');
    //Signature
    $pdf->Ln(10);
    $pdf->SetX($pdf->_getpageformat('A4')[0] - 70);
    // Format j: Jour du mois sans les zéros initiaux
    $pdf->Cell(50, 10, utf8_decode('Fait à Paris le ' . date('j') . ' ' . $listeMois[date('n') - 1] . ' ' . date('Y')));
    $pdf->Ln(7);
    $pdf->SetX($pdf->_getpageformat('A4')[0] - 70);
    $pdf->Cell(50, 10, utf8_decode('Vu l\'agent comptable'));
    $pdf->Ln(7);
    $pdf->SetX($pdf->_getpageformat('A4')[0] - 70);
    $pdf->Cell(50, 10, utf8_decode(strtoupper('signature')));
    $pdf->Ln(7);
   //$pdf->Image("images/signature.jpg",40,40,40,36);
    $pdf->SetX($pdf->_getpageformat('A4')[0] - 70);
    $pdf->Image('images/signature.jpg',115); 
    ob_end_clean();
    $pdf->Output();
}
?>