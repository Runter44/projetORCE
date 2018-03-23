<?php
/**
 *
 */
 require_once("Model/DAO/DAOInscription.php");
 require_once("Controleur/ControleurAuthentification.php");
 require_once "Vue/Vue.php";

class ControleurInscription
{

  private $vue;
  private $dao;

  function __construct()
  {
    $this->vue = new Vue();
    $this->dao = new DAOInscription();
  }

  function afficherPageInscription(){
    $_SESSION['formation'] = $this->dao->getListeFormation();
    $this->vue->pageInscription($_SESSION['formation']);
    echo $this->dao->getFormation($_SESSION['formation'][0]);
  }

  function inscrireUtilisateur(){ //type utilisateur = 0 pour professeur et = 1 pour secretaire et = 2 pour professeur vacataire

    $verif = false;
    if (isset($_POST["type_utilisateur"]) &&
     isset($_POST["mail"]) &&
     isset($_POST["prenom"]) &&
     isset($_POST["nom"]) &&
     isset($_POST["mdp"]) &&
     isset($_POST["formation"])) {

      if($_POST['type_utilisateur'] != '' && $_POST['nom'] != '' && $_POST['prenom'] != '' && $_POST['mail'] != '' && $_POST['mdp'] != '') {
	$typeUtilisateur = 0;
        //Remettre une regex pour l'adresse mail valide
        if ($this->dao->utilisateurExistant($_POST['mail'])) {
          if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        //On hashe le mdp de l'utilisateur avant de le rentrer dans la base de donnée lors de la création de son compte
        $hashed_password = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
        //Si on a affaire à un professeur
        if ($_POST["type_utilisateur"] == 0 || $_POST["type_utilisateur"] == 2) {
          // On vérifie si le professeur a bien complété le champ type de professeur et le nombre d'heures qu'il doit effectuer
          if (((isset($_POST['typeDeProfesseur'])) && ($_POST["type_utilisateur"] == 0)) || ((isset($_POST['nbHeures'])) && ($_POST["type_utilisateur"] == 2))) {
            if ($_POST["type_utilisateur"] == 0) {
	      $typeUtilisateur = 0;
              $nbHeures = $_POST['typeDeProfesseur'];
              if ($_POST['typeDeProfesseur'] == 192) {
                $nbHeures = 192; //Professeur avec 192h à faire
		$titre = "Enseignant";
              }
              else{
                $nbHeures = 384; //Professeur avec 384h à faire
                $titre = "Enseignant";
               }
            }
            else{
	      $typeUtilisateur = 2;
              $nbHeures = $_POST['nbHeures'];
              $titre = "Vacataire"; //Professeur Vacataire
            }
            // On créé l'utilisateur Professeur du bon type dans la base de donnée
            
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            try {
	      $formation = $_POST['formation'];
              if (!$this->dao->inscrireUtilisateur($formation, $_POST['mail'], $hashed_password, $nom, $prenom, $typeUtilisateur, $titre, $nbHeures)){
                header("Location: index.php?inscription&erreur");
              } else {
                $verif = true;
                $controleurAuthentification = new ControleurAuthentification();
                $controleurAuthentification->authentification();
              }
            } catch (ConnexionException $e){
              header("Location: index.php?inscription&erreur");
            }
          }
          else {
            header("Location: index.php?inscription&erreur");
          }
        }else if($_POST["type_utilisateur"] == 1){
	   $typeUtilisateur = 1;
          // On créé l'utilisateur Secrétaire approprié
          $titre = "Secrétaire"; //La Secrétaire n'a pas de sous-type de professeur, on le met donc à zéro
          $nbHeures = 0; //Elle n'a donc pas non plus de nombre d'heures maximum à atteindre dans le cadre de cours (différence avec les heures des professeurs)
          try {
            if (!$this->dao->inscrireUtilisateur($formation, $_POST['mail'], $hashed_password, $nom, $prenom, $typeUtilisateur, $titre, $nbHeures)){
              header("Location: index.php?inscription&erreur");
            } else {
              $verif = true;
              $controleurAuthentification = new ControleurAuthentification();
              $controleurAuthentification->authentification();
            }
          } catch (ConnexionException $e){
            header("Location: index.php?inscription&erreur");
          }
        }else{
          // Le type utilisateur n'est pas reconnu
          header("Location: index.php?inscription&erreur=567");
        }
      }
      else {
        header("Location: index.php?inscription&erreur=999");
      }
      }
      else {
        header("Location: index.php?inscription&erreur=888");
      }
      }
    }else {
      header("Location: index.php?inscription&erreur=97");
    }
    return $verif;
  }

}
 ?>
