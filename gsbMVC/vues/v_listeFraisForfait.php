<div id="contenu">
      <h2>Renseigner ma fiche de frais du mois <?php echo $numMois."-".$numAnnee ?></h2>
         
      <form method="POST"  action="index.php?uc=gererFrais&action=validerMajFraisForfait">
      <div class="corpsForm">
          
          <fieldset>
            <legend>Elements forfaitises
            </legend>
			<?php
				foreach ($lesFraisForfait as $unFrais)
				{
					$idFrais = $unFrais['idfrais'];
					$libelle = $unFrais['libelle'];
					$quantite = $unFrais['quantite'];
			?>
					<p>
						<label for="idFrais"><?php echo $libelle ?></label>
                                                <?php if($unFrais['idfrais'] === 'km'): ?>
                                                <select name="lesFrais[<?= $unFrais['idfrais'] ?>]">
                                                    <?php foreach($puissances as $puissance): ?>
                                                        <option value="<?= $puissance['id'] ?>"><?= $puissance['libelle'] ?> - <?= $puissance['montant'] ?>?</option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <input type="text" name="puissance_qte" value="<?= $quantite ?>">
						<?php else: ?>
                                                    <input type="text" id="idFrais" name="lesFrais[<?php echo $idFrais?>]" size="10" maxlength="5" value="<?php echo $quantite?>" >
                                                <?php endif; ?>
                                        </p>
			
			<?php
				}
			?>
			
			
			
			
           
          </fieldset>
      </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>
        
      </form>
  