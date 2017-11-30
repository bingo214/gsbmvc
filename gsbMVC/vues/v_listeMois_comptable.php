 <div id="contenu">
       <h3>Liste des mois avec des fiches de frais à valider</h3>
    <form method="GET" action="index.php">
        <label for="lstMois">Mois :</label>
        <!--Liste déroulante des mois qui ont des fiches de frais non validées -->
        <select name="lstmois" id="lstMois">
        <!--Parcours du tableau associatif $aValider -->
        <?php foreach($aValider as $annee => $mois){ ?>
        <!--   -->
            <?php foreach($mois as $le_mois){ ?>
            <!--value= annee+item, exemple:2015+10... si lstmois existe et est égal à annee, on met l'attribut "selected"; sinon, on met une chaine vide -->
            <option value="<?php echo $annee . $le_mois ?>" <?php echo (isset($_GET['lstmois']) && $_GET['lstmois'] == $annee . $le_mois) ? 'selected': ''; ?>><?php echo $le_mois . " / " . $annee; ?></option>
            <?php } ?>
        <?php } ?>
        </select>
        
        <input type="hidden" name="uc" value="validationFrais">
        <input type="hidden" name="action" value="demandeValiderFrais">
        <input type="hidden" name="part" value="2">
        <!-- si part égal à 2:-->
        <div id="liste_visiteurs">
        <?php if($part === "2"){ ?>
            <br/>
            <label for="lstvisiteurs">Liste des visiteurs : </label>
            <!--On affiche la liste des visiteurs concernées par le mois choisi précédemment-->
            <select name="lstvisiteurs" id="lstVisiteurs">
                <!--Pour chaque visiteur,on affiche dans la balise option leur nom et prénom -->
                <?php foreach($visiteurs as $visiteur){ ?>
                    <option value="<?php echo $visiteur->id; ?>" <?php echo (isset($_GET['lstvisiteurs']) && $_GET['lstvisiteurs'] === $visiteur->id) ? 'selected' : ''; ?>><?php echo $visiteur->nom . " " . $visiteur->prenom; ?></option>
                <?php } ?>
            </select>
        <?php } ?>
        </div>
           
        <button type="submit">Valider</button>
        
        </form>
    <div id="liste_infos">
    <?php if(isset($afficherFiche) && $afficherFiche){ ?>
        <h2>Les frais hors forfait</h2>
        <p>
            Etat : <?= $libelleEtat ?> depuis le <?= $dateModif ?><br />
            Montant validé : <?= $montantValide; ?>
        </p>
        <table style="width:100%">
            <thead>
            <tr>
                <th>Libellé</th>
                <th>Montant</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                <!--Pour chaque fiche hors forfait: -->
                <?php foreach($fiche["horsForfait"] as $frais){ ?>
                    <tr>
                        
                        <td><?php echo $frais['libelle']; ?></td>
                        <td><?php echo $frais['montant']; ?>?</td>
                        <td>
                            <form method="POST" action="index.php?uc=validationFrais&action=reporterFrais">
                                <button type="submit">Reporter</button>
                                <input type="hidden" name="lstmois" value="<?php echo $_GET['lstmois']; ?>">
                                <input type="hidden" name="lstvisiteurs" value="<?php echo $_GET['lstvisiteurs']; ?>">
                                <input type="hidden" name="idfrais" value="<?php echo $frais['id']; ?>">
                                <input type="hidden" name="libelle" value="<?php echo $frais['libelle']; ?>">
                                <input type="hidden" name="montant" value="<?php echo $frais['montant']; ?>">
                            </form>
                            <form method="POST" action="index.php?uc=validationFrais&action=supprimerFrais">
                                <button type="submit">Supprimer</button>
                                <input type="hidden" name="lstmois" value="<?php echo $_GET['lstmois']; ?>">
                                <input type="hidden" name="lstvisiteurs" value="<?php echo $_GET['lstvisiteurs']; ?>">
                                <input type="hidden" name="idfrais" value="<?php echo $frais['id']; ?>">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <p>&nbsp;</p>
        <h2>Les frais forfaitaires</h2>
        <table style="width:100%">
            <form method="POST" action="index.php?uc=validationFrais&action=actualiserFrais">
            <thead>
            <tr>
                <th>Libellé</th>
                <th>Quantité</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($fiche['forfait'] as $ficheF){ ?>
                    
                    <tr>
                        <td><?php echo $ficheF['libelle']; ?></td>
                        <td><input type="text" name="frais[<?php echo $ficheF['idfrais']; ?>]" value="<?php echo $ficheF['quantite']; ?>"></td>
                    </tr>
                   
                <?php } ?>

                <tr>
                    <td colspan="2">
                        <button type="submit" style="width:100%">Actualiser</button>
                        <input type="hidden" name="idvisiteur" value="<?php echo $_GET['lstvisiteurs']; ?>">
                        <input type="hidden" name="mois" value="<?php echo $_GET['lstmois']; ?>">
                    </td>
                </tr>
            </tbody>
            </form>
        </table>
        <form style="text-align: center" method="POST" action="index.php?uc=validationFrais&action=validerFicheFrais">
            <p><button type="submit">Valider la fiche</button></p>
            <input type="hidden" name="idvisiteur" value="<?php echo $_GET['lstvisiteurs']; ?>">
            <input type="hidden" name="mois" value="<?php echo $_GET['lstmois']; ?>">
        </form>
    <?php } ?></div>
</div>
      
      </div>
        
  
     