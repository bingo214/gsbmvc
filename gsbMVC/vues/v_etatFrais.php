<div style=" <?php echo (isset($visiteur) ? "margin-left: 17%;" : ''); ?>">
<h3>Fiche de frais du mois <?php echo $numMois."-".$numAnnee?> <?php echo (isset($visiteur) ? $visiteur : ''); ?>:
    </h3>
    <div class="encadre">
    <p>
        Etat : <?php echo $libEtat ?> depuis le <?php echo $dateModif?> <br> Montant valide : <?php echo $montantValide?>
              
                     
    </p>
  	<table class="listeLegere">
  	   <caption>Elements forfaitises </caption>
        <tr>
         <?php
         foreach ( $lesFraisForfait as $unFraisForfait ) 
		 {
			$libelle = $unFraisForfait['libelle'];
		?>	
			<th> <?php echo $libelle?></th>
		 <?php
        }
		?>
		</tr>
        <tr>
        <?php
          foreach (  $lesFraisForfait as $unFraisForfait  ) 
		  {
				$quantite = $unFraisForfait['quantite'];
		?>
                <td class="qteForfait"><?php echo $quantite?> </td>
		 <?php
          }
		?>
		</tr>
    </table>
  	<table class="listeLegere">
  	   <caption>Descriptif des elements hors forfait -<?php echo $nbJustificatifs ?> justificatifs reçus -
       </caption>
             <tr>
                <th class="date">Date</th>
                <th class="libelle">Libelle</th>
                <th class='montant'>Montant</th>                
             </tr>
        <?php      
          foreach ( $lesFraisHorsForfait as $unFraisHorsForfait ) 
		  {
			$date = $unFraisHorsForfait['date'];
			$libelle = $unFraisHorsForfait['libelle'];
			$montant = $unFraisHorsForfait['montant'];
		?>
             <tr>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
             </tr>
        <?php 
          }
		?>
    </table>
                    <h3><a href="index.php?uc=etatFrais&action=generatePDF&idVisiteur=<?php echo $_SESSION['idVisiteur']?>&leMois=<?php echo $leMois;?>">
                            <img src="images/icon_pdf.png" width="28px">Télécharger PDF</a></h3>
        
  </div>
  </div>














