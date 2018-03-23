<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ORCE</title>
  </head>
  <body>
    <h1>Ajouter un professeur dans une formation</h1>
    <?php
      if(isset($_GET["erreur"])){
        switch ($_GET["erreur"]) {
          case '1':
            echo "Veuillez entrer une adresse email";
            break;
          case '2':
            echo "Vous n'êtes pas administrateur de la formation";
            break;
          case '3':
            echo "Professeur inexistant";
            break;
          case '3':
            echo "Le professeur en question appartient déjà à cette formation";
            break;
          default:
            # code...
          break;
      }
    }?>
    <form action = "index.php?ajoutProfesseurFormationSub" method="post">
      <input type="text" name="professeur" value="">
      <input type="hidden" name="formation" value="<?php echo htmlspecialchars($_GET["formID"]);?>">
      <input type="submit" name="submit" value="envoyer">
    </form>
  </body>
</html>
