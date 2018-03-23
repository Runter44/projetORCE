<!-- Script qui présente la page de paramètres de l'utilisateur, s'il veux changer son nom, son mot de passe, etc, ... -->
<!DOCTYPE html>
<html>
  <head>
    <title>Paramètres du compte - Orce.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" type="text/css" href="Vue/style/global.css">
		<link rel="stylesheet" type="text/css" href="Vue/style/pageAfficherModules.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  	<script src="Vue/script/sorttable.js"></script>
		<meta charset="UTF-8">
  </head>
  <body>
    <div id="top-nav">
			<a href="?accueil" style="outline: none;"><h1>Orce.</h1></a>
			<div id="menu"><ul id="menupart1"><li><a href="home.php" id="sel"><li><a href="?parametres"><div class="text">Paramètres du compte</div><div class="under"></div></a>
					</li>
				</ul>
			</div>
			<p id="compteinfos"><?php
			if (isset($_SESSION["prenom"]) && isset($_SESSION["nom"])) {
				echo "Bienvenue, <br>".$_SESSION["prenom"]." ".$_SESSION["nom"];
			}
			?><div id="plus">+</div></p>
			<ul class="menuderoulant">
				<a href="?accueil"><li>Tous les enseignements</li></a><a href="?resumeEnseignements"><li>Enseignements</li></a><a href="?deconnexion"><li id="deco">Déconnexion</li></a>
			</ul>

			<?php echo  "<div id='heures'>".$mesHeuresSouhaitees."h | ".$mesPointsSouhaites."pt</div>"; ?>
    </div>
      <div id="container" class="container">
        <div class="h1paramCompte">
          <h1>Modifier les informations du compte</h1>
        </div>

        <?php
        if (isset($_GET["erreur"])) {
          echo "<div class='erreurParam'>";
          if ($_GET["erreur"]==1) {
            echo "Le mot de passe entré est incorrect.";
          }
          if ($_GET["erreur"]==5) {
            echo "La confirmation du mot de passe et le nouveau mot de passe doivent être identiques.";
          }
          if ($_GET["erreur"]==6) {
            echo "Le nouveau mot de passe doit être différent de l'ancien.";
          }
          if ($_GET["erreur"]==404) {
            echo "L'adresse mail est déjà utilisée.";
          }
          if ($_GET["erreur"]==405) {
            echo "L'adresse mail est invalide.";
          }
          echo "</div>";
        }
        if (isset($_GET["succes"])) {
          echo "<div class='succesParam'>";
          if ($_GET["succes"]==1) {
            echo "L'adresse e-mail a bien été modifiée.";
          }
          if ($_GET["succes"]==2) {
            echo "Le nom apparent a bien été modifié.";
          }
          if ($_GET["succes"]==3) {
            echo "Le mot de passe a bien été modifié.";
          }
          echo "</div>";
        }
         ?>

        <form class="modifParam" id="modifEmail" action="?parametresModifEmail" method="post">
          <table class="placementFormParam">
            <tr>
              <td id="tabHead" colspan="2"><h3>Modifier l'adresse e-mail</h3></td>
            </tr>
            <tr>
              <td id="tabGauche">Adresse e-mail actuelle</td>
              <td id="tabDroite"><?php echo "<div id=\"oldEmail\">".$_SESSION["email"]."</div>" ?></td>
            </tr>
            <tr>
              <td id="tabGauche"><label for="nouveauEmail">Nouvelle adresse e-mail</label></td>
              <td id="tabDroite"><input type="text" name="nouveauEmail" placeholder="email@example.com" required><br></td>
            </tr>
            <tr>
              <td id="tabGauche"><label for="pswEmail">Mot de passe du compte</label></td>
              <td id="tabDroite"><input type="password" name="pswEmail" placeholder="Mot de passe" required><br></td>
            </tr>
            <tr>
              <td colspan="2" id="tabFoot"><button type="submit" name="validerEmail">Changer l'e-mail</button></td>
            </tr>
        </table>
        </form>

        <form class="modifParam" id="modifNom" action="?parametresModifNom" method="post">
          <table class="placementFormParam">
            <tr>
              <td id="tabHead" colspan="2"><h3>Modifier le nom apparent</h3></td>
            </tr>
            <tr>
              <td id="tabGauche"><label for="newPrenom">Prénom</label></td>
              <td id="tabDroite"><input type="text" name="newPrenom" placeholder="<?php echo $_SESSION["prenom"] ?>" value="<?php echo $_SESSION["prenom"] ?>" required><br></td>
            </tr>
            <tr>
              <td id="tabGauche"><label for="newNom">Nom</label></td>
              <td id="tabDroite"><input type="text" name="newNom" placeholder="<?php echo $_SESSION["nom"] ?>" value="<?php echo $_SESSION["nom"] ?>" required><br></td>
            </tr>
            <tr>
              <td colspan="2" id="tabFoot"><button type="submit" name="validerNom">Changer le nom</button></td>
            </tr>
          </table>
        </form>

        <form class="modifParam" id="modifMdp" action="?parametresModifPwd" method="post">
          <table class="placementFormParam">
            <tr>
              <td id="tabHead" colspan="2"><h3>Modifier le mot de passe</h3></td>
            </tr>
            <tr>
              <td id="tabGauche"><label for="oldPsw">Mot de passe actuel</label></td>
              <td id="tabDroite"><input type="password" name="oldPsw" placeholder="Mot de passe actuel" required><br></td>
            </tr>
            <tr>
              <td id="tabGauche"><label for="newPsw">Nouveau mot de passe</label></td>
              <td id="tabDroite"><input type="password" name="newPsw" placeholder="Nouveau mot de passe" required><br></td>
            </tr>
            <tr>
              <td id="tabGauche"><label for="confNewPsw">Confirmez le mot de passe</label></td>
              <td id="tabDroite"><input type="password" name="confNewPsw" placeholder="Confirmation du mot de passe" required><br></td>
            </tr>
            <tr>
              <td colspan="2" id="tabFoot"><button type="submit" name="validerMdp">Changer le mot de passe</button></td>
            </tr>
          </table>
        </form>
        <?php
          if ($dansUneFormation) {
         ?>
         <form class="modifParam" id="ajoutAutreFormation" action="?joinFormation" method="post">
           <table class="placementFormParam">
             <tr>
               <td id="tabHead" colspan="2"><h3>Rejoindre un département supplémentaire</h3></td>
             </tr>
             <tr>
               <td id="tabGauche"><label for="formation">Département supplémentaire à rejoindre</label></td>
               <td id="tabDroite">
                 <select name="formation">
                   <option disabled selected>Sélectionnez le département à rejoindre...</option>
                   <?php
                   foreach ($tabFormations as $formation) {
                     if (!in_array($formation, $formationsUtilisateur)) {
                       echo "<option value=\"".$formation["ID"]."\">".$formation["nom"]."</option>";
                     }
                   }
                    ?>
                 </select>
               </td>
             </tr>
             <tr>
               <td colspan="2" id="tabFoot"><button type="submit" name="validerMdp">Rejoindre le département sélectionné</button></td>
             </tr>
           </table>
         </form>
        <form class="modifParam" id="supprFormation" action="?retirerFormation" method="post">
          <table class="placementFormParam">
            <tr>
              <td id="tabHead" colspan="2"><h3>Se retirer d'un département</h3></td>
            </tr>
            <tr>
              <td id="tabGauche"><label for="selectFormationRetirer">Département à retirer</label></td>
              <td id="tabDroite">
                <select name="selectFormationRetirer">
                  <?php
                  foreach ($formationsUtilisateur as $formation) {
                    echo "<option value=\"".$formation["ID"]."\">".$formation["nom"]."</option>";
                  }
                  ?>
                </select>
              </td>
            </tr>
            <tr>
              <td id="tabGauche"><label for="pswFormation">Mot de passe</label></td>
              <td id="tabDroite"><input type="password" name="pswFormation" placeholder="Mot de passe du compte" required><br></td>
            </tr>
            <tr>
              <td colspan="2" id="tabFoot"><button type="submit" name="validerMdp">Confirmer le retrait</button></td>
            </tr>
          </table>
        </form>
        <?php
        }
         ?>
      </div>
		</div>
  </body>
</html>
