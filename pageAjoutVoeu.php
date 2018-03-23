<!-- Fenêtre pop-up, visibles par tous utilisateurs lorsque celui-ci clique sur "ajouter"
(bouton situé à côté de chaque module). Lorsqu'il s'ajoute, il fait voeu d'enseigner le module séléctionnné.-->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ORCE</title>
  </head>
  <body>
    <h1>ORCE</h1>
    <?php
      if(isset($_GET["erreur"])){
        switch ($_GET["erreur"]) {
          case '1':
            echo "Veuillez remplir tous les champs du formulaire";
            break;
          case '2':
            echo "Vous ne pouvez pas faire de voeu pour ce cours";
            break;
          case '3':
            echo "";
            break;
          default:
            # code...
          break;
      }
    }
    ?>
    <form action="index.php?ajoutVoeuSub" method="post">
      Commentaire : <input type="text" name="commentaire" placeholder="Commentaire">
      Cours :
        <select name="ModuleID">
          <?php
            foreach($modules as $module){
              echo "<option class='module ".$module["UE_ID"]."' value='".$module["ID"]."'>".$module["nom"]."</option>";
            }
          ?>
      </select></br></br>
      Nombre de groupes TD : <input type="number" name="nbGroupesTP" placeholder="TP"></br></br>
      Nombre de groupes TP : <input type="number" name="nbGroupesTD" placeholder="TD"></br></br>
      Nombre de groupes CM : <input type="number" name="nbGroupesCM" placeholder="CM"></br></br>
      Nombre de groupes DS : <input type="number" name="nbGroupesDS" placeholder="DS"></br></br>
      <input type="submit" name="submit" value="envoyer">
    </form>
  </body>
</html>
