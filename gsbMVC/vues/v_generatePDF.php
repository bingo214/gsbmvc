<?php
function creerPDFFiche($laFiche){
    $fiche = explode('-', $_GET['fiche']);
    $listeMois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    $mois = $fiche[0];
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
    $pdf->Cell(50, 10, utf8_decode(ucfirst($laFiche['visiteur']['nom']) . ' ' . ucfirst($laFiche['visiteur']['prenom'])), 0, 0, 'C');
    $pdf->Ln(10);
    $pdf->Cell(50, 10, "Mois", 0, 0, 'L');
    $pdf->Cell(50, 10, $listeMois[date('n', strtotime("01-" . substr($mois, 4, 2) . '-' . substr($mois, 0, 4))) - 1 ] . ' ' . substr($mois, 0, 4), 0, 0, 'C');
    $pdf->Ln(20);
    $pdf->SetTextColor(44,117,165);
    // Frais forfaitaires
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->Cell(45, 10, "Frais Forfaitaires", 1, 0, 'C');
    $pdf->Cell(45, 10, utf8_decode("Quantité"), 1, 0, 'C');
    $pdf->Cell(45, 10, "Montant Unitaire", 1, 0, 'C');
    $pdf->Cell(45, 10, "Total", 1, 0, 'C');
    $pdf->Ln(10);
    $totalFraisForfaits=0;
    foreach($laFiche['forfait'] as $forfait){
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(45,10,utf8_decode($forfait['libelle']), 1,0,'C');
         $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(45,10,$forfait['quantite'],1,0,'C');
        $pdf->Cell(45,10,$forfait['montant'], 1,0,'C');
        $pdf->Cell(45,10,$forfait['quantite']*$forfait['montant'],1,0,'C');
        $pdf->Ln(10);
         $totalFraisForfaits+=$forfait['quantite']*$forfait['montant'];
    }
     $totalFraisHorsForfait = 0;
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->SetTextColor(44,117,165);
    // Position en x avec 3 colonnes
    $pdf->Cell(180,10,"Autres Frais",1,0,'C');
    $pdf->Ln(10);
    $pdf->Cell(60, 10, "Date", 1, 0, 'C');
    $pdf->Cell(60, 10, "Libelle", 1, 0, 'C');
    $pdf->Cell(60, 10, "Montant", 1, 0, 'C');
    $pdf->Ln(10);
    foreach($laFiche['hors_forfait'] as $forfait){
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(60, 10, $forfait['date'], 1, 0, 'C');
         $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(60, 10, utf8_decode($forfait['libelle']), 1, 0, 'C');
        $pdf->Cell(60, 10, $forfait['montant'], 1, 0, 'C');
        $pdf->Ln(10);
        $totalFraisHorsForfait += $forfait['montant'];
    }
    $total=$totalFraisForfaits+$totalFraisHorsForfait;
    $pdf->Ln(7);
    $pdf->SetX($pdf->_getpageformat('A4')[0] -120);
    $pdf->Cell(50, 10, 'Total', 1, 0, 'C');
    $pdf->Cell(50, 10, $total, 1, 0, 'C');
    //Signature
    $pdf->Ln(12);
    $pdf->SetX($pdf->_getpageformat('A4')[0] - 70);
    $pdf->Cell(50, 10, utf8_decode('Fait à Paris le ' . date('j') . ' ' . $listeMois[date('n') - 1] . ' ' . date('Y')));
    $pdf->Ln(7);
    $pdf->SetX($pdf->_getpageformat('A4')[0] - 70);
    $pdf->Cell(50, 10, utf8_decode('Vu l\'agent comptable'));
    $pdf->Ln(7);
    $pdf->SetX($pdf->_getpageformat('A4')[0] - 70);
    $pdf->Cell(50, 10, utf8_decode(strtoupper('signature')));
    $pdf->Ln(7);
    $pdf->Image("images/signature.jpg",115);
    ob_end_clean();
    $pdf->Output();
}
