<?php
  /**
   *
   */

   require_once("Model/DAO/DAOAuthentification.php");
   require_once "Vue/Vue.php";

  class ControleurAuthentification
  {

    private $vue;
    private $dao;

    function __construct()
    {
      $this->vue = new Vue();
      $this->dao = new DAOAuthentification();
    }

    public function estConnecte(){
      // Vérifier qu'il est impossible de créer une session manuellement du coté utilisateur
  		return isset($_SESSION["id_utilisateur"]);
    }

    public function deconnexion(){
      session_destroy();
    }

    public function afficherPageDeConnexion(){
      $this->vue->pageDeConnexion();
    }

    public function authentification(){
      $login = $_POST["mail"];
      $mot_de_passe = $_POST["mdp"];
      if ($this->dao->verifierIdentifiants($mot_de_passe, $login)) {
        $_SESSION["id_utilisateur"] = $this->dao->recupererIDParPseudoUtilisateur($login);
    		header("Location: index.php?accueil");
  		} else {
  			header("Location: index.php?connexion&erreur=4");
  		}
    }



  }

 ?>
