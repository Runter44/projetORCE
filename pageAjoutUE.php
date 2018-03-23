<!-- Fenêre pop-up qui s'affiche lorsque l'administrateur clique sur le bouton "ajouter UE", elle permet
de créer une nouvelle UE -->

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Formulaire d'ajout d'UE</title>
  </head>
  <body>
    <h1 id="titre"><b>ORCE</h1>
    <?php
      if(isset($_GET["erreur"])){
        switch ($_GET["erreur"]) {
          case '1':
            echo "Veuillez remplir tous les champs du formulaire";
            break;
          case '2':
            echo "Vous n'avez pas les droits nécessaires";
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
    <form class="" action="index.php?ajoutUESub" method="post">
      <select onchange="afficherNiveaux(this.value)" name="formation">
        <?php
          foreach($formations as $formation){
              echo "<option value='".$formation['ID']."'>".$formation['nom']."</option>";
          }
        ?>
      </select>
      Nom : <input type="text" name="nom" placeholder="nom">
      Niveau : <select name="niveau">
                <?php
                  foreach($niveaux as $niveau){
                    echo "<option class='niveau ".$niveau['Formation_ID']."' value='".$niveau['ID']."'>".$niveau['nom']."</option>";
                  }
                ?>
              </select>
      <input type="submit" name="submit" value="envoyer">
    </form>

    <script>
      function afficherNiveaux(idFormation){
        var tmp = document.getElementsByClassName(idFormation);
        var tmpBis = document.getElementsByClassName("niveau");
        for(i=0;i<tmpBis.length;i++){
          tmpBis[i].style.display = "none";
        }
        for(i=0;i<tmp.length;i++){
          tmp[i].style.display = "block";
        }
      }
    </script>

  </body>
</html>
