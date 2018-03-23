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
			<div id="menu"><ul id="menupart1"><li><a href="home.php" id="sel"><li><a href="?resumeEnseignements"><div class="text">Résumé des enseignements</div><div class="under"></div></a>
					</li>
				</ul>
			</div>
			<p id="compteinfos"><?php
			if (isset($_SESSION["prenom"]) && isset($_SESSION["nom"])) {
				echo "Bienvenue, <br>".$_SESSION["prenom"]." ".$_SESSION["nom"];
			}
			?><div id="plus">+</div></p>
			<ul class="menuderoulant">
				<a href="?accueil"><li>Tous les enseignements</li></a><a href="?parametres"><li>Paramètres du compte</li></a><a href="?deconnexion"><li id="deco">Déconnexion</li></a>
			</ul>

			<?php echo  "<div id='heures'>".$mesHeuresSouhaitees."h | ".$mesPointsSouhaites."pt</div>"; ?>
    </div>
    <div id="container" class="container">
      <div class="h1paramCompte">
        <h1>Résumé des enseignements sur lesquels vous êtes positionnés</h1>
      </div>
      <?php
      echo "<h2 id=\"heuresEnseignementResume\">Vous enseignez ".$nbHeuresTotal." heures avec tous vos voeux, soit environ ".round($nbHeuresTotal/24, 2)."h par semaine.</h2>";
      foreach ($voeuxUtilisateur as $voeu) {
        $dateDebut = new DateTime($voeu["date_debut"]);
        $dateFin = new DateTime($voeu["date_fin"]);
        $intervalle = $dateDebut->diff($dateFin);
        $nbSemaines = round($intervalle->format("%a")/7);
        $totalHeures = $voeu["nbGroupesDS"]*$voeu["nbHeuresDS"]+$voeu["nbGroupesCM"]*$voeu["nbHeuresCM"]+$voeu["nbGroupesTD"]*$voeu["nbHeuresTD"]+$voeu["nbGroupesTP"]*$voeu["nbHeuresTP"];
        $heuresSemaine = round($totalHeures/$nbSemaines, 2);
        // echo $voeu["nom"]." (".$voeu["Module_ID"].") - ".$voeu["nbGroupesDS"]." heures de DS, ".$voeu["nbGroupesCM"]." heures de CM, ".$voeu["nbGroupesTD"]." heures de TD, ".$voeu["nbGroupesTP"]." heures de TP.<br>";
        echo "<h3 id=\"nomEnseignementResume\">".$voeu["nom"]." (".$voeu["Module_ID"].")</h3>";
        if ($voeu["nbGroupesDS"] > 0) {
          echo "<p id=\"descEnseignementResume\"><u>DS :</u> <b>".$voeu["nbGroupesDS"]." groupes</b> ayant <b>".$voeu["nbHeuresDS"]."h</b> de cours, soit <b>".round($voeu["nbGroupesDS"]*$voeu["nbHeuresDS"])."h</b>.</p>";
        }
        if ($voeu["nbGroupesCM"] > 0) {
          echo "<p id=\"descEnseignementResume\"><u>CM :</u> <b>".$voeu["nbGroupesCM"]." groupes</b> ayant <b>".$voeu["nbHeuresCM"]."h</b> de cours, soit <b>".round($voeu["nbGroupesCM"]*$voeu["nbHeuresCM"])."h</b>.</p>";
        }
        if ($voeu["nbGroupesTD"] > 0) {
          echo "<p id=\"descEnseignementResume\"><u>TD :</u> <b>".$voeu["nbGroupesTD"]." groupes</b> ayant <b>".$voeu["nbHeuresTD"]."h</b> de cours, soit <b>".round($voeu["nbGroupesTD"]*$voeu["nbHeuresTD"])."h</b>.</p>";
        }
        if ($voeu["nbGroupesTP"] > 0) {
          echo "<p id=\"descEnseignementResume\"><u>TP :</u> <b>".$voeu["nbGroupesTP"]." groupes</b> ayant <b>".$voeu["nbHeuresTP"]."h</b> de cours, soit <b>".round($voeu["nbGroupesTP"]*$voeu["nbHeuresTP"])."h</b>.</p>";
        }
        if (($voeu["nbGroupesDS"] == 0) && ($voeu["nbGroupesCM"] == 0) && ($voeu["nbGroupesTD"] == 0) && ($voeu["nbGroupesTP"] == 0)) {
          echo "<p id=\"descEnseignementResume\">Votre voeu sur ce module ne comporte aucune heure.</p>";
        } else {
          echo "<br>";
          echo "<p id=\"descEnseignementResume\"><u>Total :</u> ".$totalHeures."h - environ ".$heuresSemaine."h par semaine pendant le module.</p>";
        }
      }
       ?><br><br>
       <div id="telecharger">
         <a href="?genererPdfEnseignements"><button type="button">Télécharger sous format PDF</button></a>
       </div>
    </div>
  </body>
</html>
