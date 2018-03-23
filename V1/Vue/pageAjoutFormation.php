<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Orce - Inscription</title>
<link rel="stylesheet" type="text/css" href="Vue/style/pageDeConnexion.css">
<!-- <link rel="stylesheet" type="text/css" href="Vue/style/global.css"> -->

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<body>
  <div id="container">
    <div class="mdl-card__title">
      <h2 class="mdl-card__title-text" id="titrebleu">Ajout de formation</h2>
    </div>
    <form action="index.php?ajoutFormationSub" method="POST">
      <?php if (isset($_GET["erreur"])) {
        switch ($_GET["erreur"]) {
          case '1':
            echo "<div class=\"erreur\">Veuillez entre un nom pour la formation</div>";
            break;

          case '2':
            echo "<div class=\"erreur\">Si vous n'êtes pas administrateur de la formation, veuillez entre l'adresse mail d'un administrateur</div>";
            break;
          case '3':
            echo "<div class=\"erreur\">L'adresse mail de l'administrateur est invalide</div>";
            break;

          default:
            # code...
            break;
        }
      } ?>
        <input type="text" name="nom_formation" value="<?php echo htmlspecialchars($_GET["ajoutFormation"]);?>"  placeholder="Nom de la formation">
        <input type="hidden" id="checkbox-1" name="admin" value="true">
      <!--<label for="checkbox-1">
        <input type="checkbox" id="checkbox-1" name="admin" value="true">
        <span>Je suis administrateur</span>
      </label>
      <p>Attention ! Assurez-vous d'avoir l'accord du chef de la formation avant d'ajouter la formation.</p>
        <?php if(isset($_GET["adminInexistant"]) && isset($_GET["adminmail"]) ){
          echo "L'utilisateur ".htmlspecialchars($_GET["adminmail"]);?>
           n'existe pas, souhaitez-vous l'inviter à rejoindre ORCE ?
          <input type="radio" name="invitationORCE" value="oui" onchange="maj();" checked> Oui
          <input type="radio" id="nonButton" name="invitationORCE" onchange="maj();" value="non"> Non<br>
          <?php
        }
        ?>

        <input id="mail_admin" type="text" name="mail_admin" placeholder="Adresse mail de l'administrateur" value="<?php if(isset($_GET["adminmail"])){echo htmlspecialchars($_GET["adminmail"]);} ?>" />

        -->
        <div id="listeNiveaux">
            <div class="niveau">
                  <input type="text" name="nomNiveau0" placeholder="Nom du niveau">
                  <h2 id="petitTitreBleu">Nombre de groupes :</h2><br />
                  <div class="nbCours">
                    <input type="number" min="0" max="100"name="nbCMNiveau0" placeholder="CM">
                    <input type="number" min="0" max="100" name="nbTDNiveau0" placeholder="TD">
                    <input type="number" min="0" max="100" name="nbTPNiveau0" placeholder="TP">
                    <input type="number" min="0" max="100" name="nbDSNiveau0" placeholder="DS">
                  </div>
            </div>
        </div>
        <input type="hidden" value=1 name="nbNiveaux" id="nbNiveaux"/>
        <button id="boutonNiveau" type="button"> Ajouter un niveau</button>


      <div class="centre">
        <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored bouton">
          Ajout de la formation
        </button>
      </div>
      <a href="?accueil" class="retour"><button type="button" id="boutonNiveau">Retour</button></a>
    </form>
  </div>
  <script type="text/javascript">
  <?php if(isset($_GET["adminInexistant"])){
    ?>
      document.getElementById("mail_admin").style.display = "none";
    <?php
  }
  ?>
    function maj(){
      if (document.getElementById("nonButton").checked) {
        document.getElementById("mail_admin").style.display = "block";
      }else{
        document.getElementById("mail_admin").style.display = "none";
      }
    }


    var nbNiveaux = document.getElementById("nbNiveaux").value;
    var listeNiveaux = document.getElementById("listeNiveaux");
    function ajouterNiveau() {
      if (nbNiveaux < 9) {
        var nouveauNiveau = document.createElement("div");
        nouveauNiveau.className = "nbCours";

        var nomNiveau = document.createElement("input");
        nomNiveau.type = "text";
        nomNiveau.name = "nomNiveau"+nbNiveaux;
        nomNiveau.placeholder = "Année "+(parseInt(nbNiveaux)+1);

        var nbCMNiveau = document.createElement("input");
        nbCMNiveau.type = "number";
        nbCMNiveau.setAttribute("min", "0");
        nbCMNiveau.setAttribute("max", "100");
        nbCMNiveau.name = "nbCMNiveau"+nbNiveaux;
        nbCMNiveau.placeholder = "CM";

        var nbTDNiveau = document.createElement("input");
        nbTDNiveau.type = "number";
        nbTDNiveau.setAttribute("min", "0");
        nbTDNiveau.setAttribute("max", "100");
        nbTDNiveau.name = "nbTDNiveau"+nbNiveaux;
        nbTDNiveau.placeholder = "TD";

        var nbTPNiveau = document.createElement("input");
        nbTPNiveau.type = "number";
        nbTPNiveau.setAttribute("min", "0");
        nbTPNiveau.setAttribute("max", "100");
        nbTPNiveau.name = "nbTPNiveau"+nbNiveaux;
        nbTPNiveau.placeholder = "TP";

        var nbDSNiveau = document.createElement("input");
        nbDSNiveau.type = "number";
        nbDSNiveau.setAttribute("min", "0");
        nbDSNiveau.setAttribute("max", "100");
        nbDSNiveau.name = "nbDSNiveau"+nbNiveaux;
        nbDSNiveau.placeholder = "DS";

        nouveauNiveau.appendChild(nomNiveau);
        nouveauNiveau.appendChild(nbCMNiveau);
        nouveauNiveau.appendChild(nbTDNiveau);
        nouveauNiveau.appendChild(nbTPNiveau);
        nouveauNiveau.appendChild(nbDSNiveau);
        listeNiveaux.appendChild(nouveauNiveau);

        document.getElementById("nbNiveaux").value++;
        nbNiveaux = document.getElementById("nbNiveaux").value;
      }

    }

    document.getElementById('boutonNiveau').addEventListener("click", ajouterNiveau);
  </script>
</body>
</html>
