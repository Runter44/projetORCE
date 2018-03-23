<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Page de Connexion - Orce</title>
    <link rel="stylesheet" type="text/css" href="Vue/style/pageDeConnexion.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <div id="container">
      <div id="title-container">
        <h1>Orce.</h1>
      </div>
      <form action="index.php?soumissionConnexion" method="post">
        <?php
          // Si il y a une erreur
          if (isset($_GET["erreur"])) {
            echo "<div class='erreur'>";
            if ($_GET["erreur"]==111) {
              echo "Votre identifiant ou votre mot de passe est invalide";
            }
            else if ($_GET["erreur"]==333) {
              echo "Veuillez renseigner tout les champs";
            }
            // Si l'utilisateur a essayé de charger une page sans être connecté
            else if ($_GET["erreur"]==666) {
              echo "Vous devez vous connecter pour acceder à cette page";
            }
            // Si l'utilisateur a essayé de se connecter avec des identifiants invalides
            else if ($_GET["erreur"]==4) {
              echo "Adresse mail ou mot de passe invalide";
            }
            echo "</div>";
          }
         ?>
           <div class="inputgroup"><input type="text" name="mail" placeholder="Login" />
            <input type="password" name="mdp" placeholder="Mot de passe"/>
          </div>
            <input type="submit" value="Connexion"/>
            <a href="?inscription"><button type="button">Inscription</button></a>
      </form>
      <p style="align: center"></p>
    </div>
  </body>
  <footer>
    <div>
      <img src="https://upload.wikimedia.org/wikipedia/fr/thumb/6/62/Universit%C3%A9_de_Nantes_%28logo%29.svg/1200px-Universit%C3%A9_de_Nantes_%28logo%29.svg.png" alt="Université de Nantes"/>
    </div>
  </footer>
</html>
