<!-- L'affichage de cette page se fait lorsqu'un utilisateur vient de s'incrire, ou qu'il n'est dans
aucune formation -->
<!DOCTYPE html>
<html>
  <head>
    <title>Rejoindre une formation - Orce.</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" type="text/css" href="Vue/style/global.css">
		<link rel="stylesheet" type="text/css" href="Vue/style/pageAfficherModules.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.0.js"></script>
  	<script src="Vue/script/sorttable.js"></script>
    <script type="text/javascript">
      function changeFormation() {
        var valeur = document.getElementById('selectFormation').value;
        document.getElementById('nomAdminFormationSelect').innerHTML = valeur;
        $.ajax({
          url : "Vue/traitementFormation.php",
          type : "POST",
          data : 'idformation='+valeur,
          dataType : "html",
          success : function(data){
            document.getElementById('nomAdminFormationSelect').innerHTML = data;
            if (data != "<p>Rien à afficher pour ce département.</p><br>") {
              afficherBoutonRejoindre();
            } else {
              cacherBoutonRejoindre();
            }
          }
        });
      };
      function afficherBoutonRejoindre() {
        document.getElementById("boutonRejoindreFormation").style.display = "inline-block";
      }
      function cacherBoutonRejoindre() {
        document.getElementById("boutonRejoindreFormation").style.display = "none";
      }

    </script>
  </head>
  <body>
    <div id="top-nav">
			<a href="?accueil" style="outline: none;"><h1>Orce.</h1></a>
			<div id="menu"><ul id="menupart1"><li><a href="home.php" id="sel"><li><a href="?rejoindreFormation"><div class="text">Rejoindre un département</div><div class="under"></div></a>
					</li>
				</ul>
			</div>
			<p id="compteinfos"><?php
			if (isset($_SESSION["prenom"]) && isset($_SESSION["nom"])) {
				echo "Bienvenue, <br>".$_SESSION["prenom"]." ".$_SESSION["nom"];
			}
			?><div id="plus">+</div></p>
			<ul class="menuderoulant">
				<a href="?accueil"><li>Tous les enseignements</li></a><a href="?parametres"><li>Paramètres du compte</li></a><a href="?resumeEnseignements"><li>Enseignements</li></a><a href="?deconnexion"><li id="deco">Déconnexion</li></a>
			</ul>
    </div>
    <div id="container" class="container">
      <div class="h1paramCompte">
        <h1>Rejoindre un département existant</h1>
        <p>Vous pourrez toujours rejoindre un département supplémentaire ou le quitter à partir du menu Paramètres du compte.</p>
      </div>
      <?php
      if (isset($_GET["erreur"])) {
        echo "<div class='erreurParam'>";
        if ($_GET["erreur"]==1) {
          echo "Vous ne pouvez pas rejoindre un nouveau département car un département vous est déjà assigné.";
        }
        echo "</div>";
      }
       ?>
      <form class="rejFormation" action="?joinFormation" method="post">
        <select id="selectFormation" name="formation" onchange="changeFormation();">
          <option disabled selected>Sélectionnez le département à rejoindre...</option>
          <?php
          foreach ($tabFormations as $formation) {
            echo "<option value=\"".$formation["ID"]."\">".$formation["nom"]."</option>";
          }
          ?>
        </select><br><div id="nomAdminFormationSelect"></div>
        <button id="boutonRejoindreFormation" type="submit" name="Envoyer">Rejoindre le département sélectionné</button>
      </form>
    </div>
  </body>
</html>
