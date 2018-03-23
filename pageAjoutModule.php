<!-- Fenêtre pop-up qui s'affiche lorsque l'on clique sur le bouton "ajouter module" situé en haut des modules
d'une formation. -->

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Formulaire d'ajout de Module</title>
    <link rel="stylesheet" type="text/css" href="Vue/style/global.css">
  </head>
  <body>
    <h1 id="titre"><b>ORCE</b></h1>
      <?php
        if(isset($_GET["erreur"])){
          switch ($_GET["erreur"]) {
            case '1':
              echo "Veuillez remplir tous les champs du formulaire";
              break;
            case '2':
              echo "Ce module existe déjà";
              break;
            case '3':
              echo "Vous n'avez pas le droit d'ajouter un module dans cette formation";
              break;
            default:
              # code...
            break;
        }
      }?>
      <form class="" action="index.php?ajoutModuleSub" method="post">
        ID du Module : <input type="text" name="ID" placeholder="ID"></br></br>
        Nom : <input type="text" name="nom" placeholder="nom"></br></br>
        Formation :
        <select onchange="afficherNiveaux(this.value);" name="formation">
          <?php
            foreach($formations as $formation){
                echo "<option value='".$formation['ID']."'>".$formation['nom']."</option>";
            }
          ?>
        </select><br /><br />
        Niveau :
        <select name="niveau" onchange="afficherUEs(this.value);">
          <?php
            foreach($niveaux as $niveau){
              echo "<option class='niveau ".$niveau['Formation_ID']."' value='".$niveau['ID']."'>".$niveau['nom']."</option>";
            }
          ?>
        </select><br /><br />
        UE :
        <select name="UE_ID">
          <?php
            foreach($ues as $ue){
              echo "<option class='ue ".$ue["Niveau_ID"]."' value='".$ue["ID"]."'>".$ue["nom"]."</option>";
            }
          ?>
        </select><br /><br />
        Nombre d'heures TDs : <input type="number" name="nbHeuresTD" placeholder="TD"></br></br>
        Nombre d'heures TPs : <input type="number" name="nbHeuresTP" placeholder="TP"></br></br>
        Nombre d'heures CMs : <input type="number" name="nbHeuresCM" placeholder="CM"></br></br>
        Nombre d'heures DS : <input type="number" name="nbHeuresDS" placeholder="DS"></br></br>
        Période : <input type="number" name="periode" min="1" max="4" placeholder="1 à 4"></br></br>

        <input type="submit" name="submit" value="envoyer">
      </form>
      <script type="text/javascript">
        function afficherNiveaux(idFormation){
          var tmp = document.getElementsByClassName(idFormation);
          var tmpBis = document.getElementsByClassName("niveau");
          for(i=0;i<tmpBis.length;i++){
            tmpBis[i].style.display = "none";
            tmpBis[i].disabled = "true";
          }
          for(i=0;i<tmp.length;i++){
            tmp[i].style.display = "block";
            tmpBis[i].disabled = false;
          }
        }
        function afficherUEs(id){
          var tmp = document.getElementsByClassName(id);
          var tmpBis = document.getElementsByClassName("ue");
          for(i=0;i<tmpBis.length;i++){
            tmpBis[i].style.display = "none";
            tmpBis[i].disabled = "true";
          }
          for(i=0;i<tmp.length;i++){
            tmp[i].style.display = "block";
            tmpBis[i].disabled = false;
          }
        }
      </script>
  </body>
</html>
