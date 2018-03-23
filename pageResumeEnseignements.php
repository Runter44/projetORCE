<!-- Ce script calcul le nombre d'heures sur lequel un utilisateur est positioné, par modules -->
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

  //afichage des tableax par périodes
  echo "<h2 id=\"heuresEnseignementResume\">Vous enseignez ".$nbHeuresTotal." heures avec tous vos voeux, soit environ ".round($nbHeuresTotal/24, 2)."h par semaine.</h2>";
  ?><br><br>
  <!-- période 1 -->
  <h1 class="intitulePeriode">Voeux de la période 1 (Première partie des Semestres 1/3)</h1>
  <?php
  $count = 0;
  foreach ($voeuxUtilisateur as $voeu) {
    if ($voeu["periode"] == 1) {
      $count++;
      ?>
      <h1 class="intituleEns"><?php echo $voeu["nom"]." (".$voeu["Module_ID"].")" ?></h1>
      <table class="tableauEns">
        <tr class="intituleEns">
          <!-- <td colspan="5"><?php echo $voeu["nom"]." (".$voeu["Module_ID"].")" ?></td> -->
        </tr>
        <tr>
          <td></td>
          <td>DS</td>
          <td>CM</td>
          <td>TD</td>
          <td>TP</td>
        </tr>
        <tr>
          <td>Nombre de groupes</td>
          <td><?php echo $voeu["nbGroupesDS"] ?></td>
          <td><?php echo $voeu["nbGroupesCM"] ?></td>
          <td><?php echo $voeu["nbGroupesTD"] ?></td>
          <td><?php echo $voeu["nbGroupesTP"] ?></td>
        </tr>
        <tr>
          <td>Nombre d'heures par groupe</td>
          <td><?php echo $voeu["nbHeuresDS"] ?></td>
          <td><?php echo $voeu["nbHeuresCM"] ?></td>
          <td><?php echo $voeu["nbHeuresTD"] ?></td>
          <td><?php echo $voeu["nbHeuresTP"] ?></td>
        </tr>
        <tr>
          <td>Total</td>
          <td><?php echo $voeu["nbGroupesDS"]*$voeu["nbHeuresDS"] ?></td>
          <td><?php echo $voeu["nbGroupesCM"]*$voeu["nbHeuresCM"] ?></td>
          <td><?php echo $voeu["nbGroupesTD"]*$voeu["nbHeuresTD"] ?></td>
          <td><?php echo $voeu["nbGroupesTP"]*$voeu["nbHeuresTP"] ?></td>
        </tr>
      </table><br>
      <?php
    }
  }
  if ($count == 0) {
    echo "<p class='aucunVoeuResume'>Aucun voeu pour cette période !</p>";
  }
  $count = 0;
  ?>
  <!-- période 2 -->
  <h1 class="intitulePeriode">Voeux de la période 2 (Seconde partie des Semestres 1/3)</h1>
  <?php
  foreach ($voeuxUtilisateur as $voeu) {
    if ($voeu["periode"] == 2) {
      $count++;
      ?>
      <h1 class="intituleEns"><?php echo $voeu["nom"]." (".$voeu["Module_ID"].")" ?></h1>
      <table class="tableauEns">
        <tr class="intituleEns">
          <!-- <td colspan="5"><?php echo $voeu["nom"]." (".$voeu["Module_ID"].")" ?></td> -->
        </tr>
        <tr>
          <td></td>
          <td>DS</td>
          <td>CM</td>
          <td>TD</td>
          <td>TP</td>
        </tr>
        <tr>
          <td>Nombre de groupes</td>
          <td><?php echo $voeu["nbGroupesDS"] ?></td>
          <td><?php echo $voeu["nbGroupesCM"] ?></td>
          <td><?php echo $voeu["nbGroupesTD"] ?></td>
          <td><?php echo $voeu["nbGroupesTP"] ?></td>
        </tr>
        <tr>
          <td>Nombre d'heures par groupe</td>
          <td><?php echo $voeu["nbHeuresDS"] ?></td>
          <td><?php echo $voeu["nbHeuresCM"] ?></td>
          <td><?php echo $voeu["nbHeuresTD"] ?></td>
          <td><?php echo $voeu["nbHeuresTP"] ?></td>
        </tr>
        <tr>
          <td>Total</td>
          <td><?php echo $voeu["nbGroupesDS"]*$voeu["nbHeuresDS"] ?></td>
          <td><?php echo $voeu["nbGroupesCM"]*$voeu["nbHeuresCM"] ?></td>
          <td><?php echo $voeu["nbGroupesTD"]*$voeu["nbHeuresTD"] ?></td>
          <td><?php echo $voeu["nbGroupesTP"]*$voeu["nbHeuresTP"] ?></td>
        </tr>
      </table><br>
      <?php
    }
  }
  if ($count == 0) {
    echo "<p class='aucunVoeuResume'>Aucun voeu pour cette période !</p>";
  }
  $count = 0;
  ?>
  <!-- période 3 -->
  <h1 class="intitulePeriode">Voeux de la période 3 (Première partie des Semestres 2/4)</h1>
  <?php
  foreach ($voeuxUtilisateur as $voeu) {
    if ($voeu["periode"] == 3) {
      $count++;
      ?>
      <h1 class="intituleEns"><?php echo $voeu["nom"]." (".$voeu["Module_ID"].")" ?></h1>
      <table class="tableauEns">
        <tr class="intituleEns">
          <!-- <td colspan="5"><?php echo $voeu["nom"]." (".$voeu["Module_ID"].")" ?></td> -->
        </tr>
        <tr>
          <td></td>
          <td>DS</td>
          <td>CM</td>
          <td>TD</td>
          <td>TP</td>
        </tr>
        <tr>
          <td>Nombre de groupes</td>
          <td><?php echo $voeu["nbGroupesDS"] ?></td>
          <td><?php echo $voeu["nbGroupesCM"] ?></td>
          <td><?php echo $voeu["nbGroupesTD"] ?></td>
          <td><?php echo $voeu["nbGroupesTP"] ?></td>
        </tr>
        <tr>
          <td>Nombre d'heures par groupe</td>
          <td><?php echo $voeu["nbHeuresDS"] ?></td>
          <td><?php echo $voeu["nbHeuresCM"] ?></td>
          <td><?php echo $voeu["nbHeuresTD"] ?></td>
          <td><?php echo $voeu["nbHeuresTP"] ?></td>
        </tr>
        <tr>
          <td>Total</td>
          <td><?php echo $voeu["nbGroupesDS"]*$voeu["nbHeuresDS"] ?></td>
          <td><?php echo $voeu["nbGroupesCM"]*$voeu["nbHeuresCM"] ?></td>
          <td><?php echo $voeu["nbGroupesTD"]*$voeu["nbHeuresTD"] ?></td>
          <td><?php echo $voeu["nbGroupesTP"]*$voeu["nbHeuresTP"] ?></td>
        </tr>
      </table><br>
      <?php
    }
  }
  if ($count == 0) {
    echo "<p class='aucunVoeuResume'>Aucun voeu pour cette période !</p>";
  }
  $count = 0;
  ?>
  <!-- période 2 -->
  <h1 class="intitulePeriode">Voeux de la période 4 (Seconde partie des Semestres 2/4)</h1>
  <?php
  foreach ($voeuxUtilisateur as $voeu) {
    if ($voeu["periode"] == 4) {
      $count++;
      ?>
      <h1 class="intituleEns"><?php echo $voeu["nom"]." (".$voeu["Module_ID"].")" ?></h1>
      <table class="tableauEns">
        <tr class="intituleEns">
          <!-- <td colspan="5"><?php echo $voeu["nom"]." (".$voeu["Module_ID"].")" ?></td> -->
        </tr>
        <tr>
          <td></td>
          <td>DS</td>
          <td>CM</td>
          <td>TD</td>
          <td>TP</td>
        </tr>
        <tr>
          <td>Nombre de groupes</td>
          <td><?php echo $voeu["nbGroupesDS"] ?></td>
          <td><?php echo $voeu["nbGroupesCM"] ?></td>
          <td><?php echo $voeu["nbGroupesTD"] ?></td>
          <td><?php echo $voeu["nbGroupesTP"] ?></td>
        </tr>
        <tr>
          <td>Nombre d'heures par groupe</td>
          <td><?php echo $voeu["nbHeuresDS"] ?></td>
          <td><?php echo $voeu["nbHeuresCM"] ?></td>
          <td><?php echo $voeu["nbHeuresTD"] ?></td>
          <td><?php echo $voeu["nbHeuresTP"] ?></td>
        </tr>
        <tr>
          <td>Total</td>
          <td><?php echo $voeu["nbGroupesDS"]*$voeu["nbHeuresDS"] ?></td>
          <td><?php echo $voeu["nbGroupesCM"]*$voeu["nbHeuresCM"] ?></td>
          <td><?php echo $voeu["nbGroupesTD"]*$voeu["nbHeuresTD"] ?></td>
          <td><?php echo $voeu["nbGroupesTP"]*$voeu["nbHeuresTP"] ?></td>
        </tr>
      </table><br>
      <?php
    }
  }
  if ($count == 0) {
    echo "<p class='aucunVoeuResume'>Aucun voeu pour cette période !</p>";
  }
  $count = 0;
  ?><br><br>
  <!-- Bouton pour télécharger le résumé de la page en format PDF-->
  <div id="telecharger">
    <a href="?genererPdfEnseignements"><button type="button">Télécharger sous format PDF</button></a>
  </div>
</div>
</body>
</html>
