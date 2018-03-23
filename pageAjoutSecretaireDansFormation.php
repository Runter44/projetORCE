<!-- Fenêtre pop-up qui s'affiche lorsqu'un administrateur veut ajouter un administrateur dans une formation
(lorsqu'il déroule le menu des réglages)
S'appellait avant sécrétaire, nous avons gardé le titre du fichier telquel pour ne pas avoir à le modifier dans
chaque fichier de redirection -->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ORCE</title>
  </head>
  <body>
    <h1>Ajouter un administrateur dans une formation</h1>
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
            echo "Administrateur inexistant";
            break;
          case '4':
            echo "L'administrateur en question appartient déjà à cette formation";
            break;
          default:
            # code...
          break;
      }
    }?>
    <form action = "index.php?ajoutSecretaireFormationSub" method="post">
      <input type="text" name="secretaire" value="">
      <input type="hidden" name="formation" value="<?php echo htmlspecialchars($_GET["formID"]);?>">
      <input type="submit" name="submit" value="envoyer">
    </form>
  </body>
</html>
