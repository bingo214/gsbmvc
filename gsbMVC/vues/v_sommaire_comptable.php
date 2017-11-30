<!-- Division pour le sommaire -->
    <div id="menuGauche">
     <div id="infosUtil">
    
        <h2>
    
</h2>
    
      </div>  
        <ul id="menuList">
			<li >
				  Comptable :<br>
				<?php echo $_SESSION['prenom']."  ".$_SESSION['nom']  ?>
			</li>
          <li class="smenu">
                    <a href="index.php?uc=validationFrais&action=demandeValiderFrais">Valider les fiches de frais</a>
                </li>
                <li class="smenu">
                    <a href="index.php?uc=suiviPaiement&action=demandeSuiviPaiement">Suivi de paiement</a>
                </li>
                <li class="smenu">
              <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
           </li>
        
    </div>
    
