<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Inscription - Orce</title>
    <link rel="stylesheet" type="text/css" href="Vue/style/pageDeConnexion.css">
  </head>
  <body>

    <div id="container" style="margin-top:100px">
      <?php
        if(isset($_GET["erreur"])){
          echo "<div class='erreur'>";
          switch ($_GET["erreur"]) {
            case '97':
              echo "Veuillez renseignez les champs obligatoires";
              break;
            case '888':
              echo "Un compte avec cet email existe déjà";
              break;
              case '999':
                echo "Veuillez entrer une adresse mail valide";
                break;
            default:
                echo "Bienvenue";
              break;
          }
          echo "</div>";
        } ?>
        <h1>Inscription au service</h1>
    <form action="?soumissionInscription" method="POST">
      <h6>Choix de la formation</h6>
	<select name="formation"><?php
		foreach($_SESSION['formation'] as $donnees){
	?>
           <option value="<?php echo $donnees['ID']; ?>"> <?php echo $donnees['nom']; ?></option>
	<?php
		}?>
	</select>
      <h6>Type d'utilisateur</h6>
      <div class="alignleft">
      <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-1">
        <input onClick="checkelement()" type="radio" id="option-1" class="mdl-radio__button" name="type_utilisateur" value="0" required>
        <span class="mdl-radio__label">Enseignant</span>
      </label>
    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-3">
      <input onClick="checkelement()" type="radio" id="option-3" class="mdl-radio__button" name="type_utilisateur" value="1" required>
      <span class="mdl-radio__label">Secretaire</span>
    </label><br/>
  <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-2">
      <input onClick="checkelement()" type="radio" id="option-2" class="mdl-radio__button" name="type_utilisateur" value="2" required>
      <span class="mdl-radio__label">Vacataire</span>
    </label>
  </div>
    <div id="target-1" >
      <h6>Nombre d'heures</h6>
      <div class="alignleft">
        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-4">
          <input onClick="checkelement()" type="radio" id="option-4" class="mdl-radio__button" name="typeDeProfesseur" value="0">
          <span class="mdl-radio__label">192h  </span>
        </label>
        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-5">
          <input onClick="checkelement()" type="radio" id="option-5" class="mdl-radio__button" name="typeDeProfesseur" value="1">
          <span class="mdl-radio__label">384h  </span>
        </label>
        
      </div>
    </div>
    <br/>
    <div id="target-2" >
      <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="nbHeures" name="nbHeures" placeholder="Nombre d'heures">
      </div>
    </div>
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <input class="mdl-textfield__input" type="text" name="mail" placeholder="Adresse e-mail" required>
      </div>
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <input class="mdl-textfield__input" type="text" name="prenom" placeholder="Prénom" required>
      </div>
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <input class="mdl-textfield__input" type="text" name="nom" placeholder="Nom" required>
      </div>
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <input class="mdl-textfield__input" type="password" name="mdp" required placeholder="Mot de passe">
      </div>
      <div class="centre">
      <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">
        Inscription
      </button>
      <a href="?connexion">
      <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">
          Retour
      </button>
      </a>
    </div>
    </form>
  </div>
</div>
</div>
</body>
<script type="text/javascript">
 function checkelement(){
    var triggerA = document.getElementById("option-1");
    var triggerB = document.getElementById("option-2");
    var triggerC = document.getElementById("option-3");
    var triggerD = document.getElementById("option-4");
    var triggerE = document.getElementById("option-5");
    var targetA = document.getElementById("target-1");
    var targetB = document.getElementById("target-2");
       if(triggerA.checked){
	  targetB.style.display = 'none';
          targetA.style.display = 'block';
       }else{
          targetA.style.display = 'none';
       }
       if(triggerB.checked){
         targetB.style.display = 'block';
       }
       if (triggerC.checked) {
         targetB.style.display = 'none';
       }
       if (triggerD.checked) {
         targetB.style.display = 'none';
       }
       if (triggerE.checked) {
         targetB.style.display = 'none';
       }
 }
</script>
<footer>
  <div>
    <img src="https://upload.wikimedia.org/wikipedia/fr/thumb/6/62/Universit%C3%A9_de_Nantes_%28logo%29.svg/1200px-Universit%C3%A9_de_Nantes_%28logo%29.svg.png" alt="Université de Nantes"/>
  </div>
</footer>

</html>
