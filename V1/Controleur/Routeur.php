<?php
  /** Classe qui permet de router les requetes HTTP de l'utilisateur
   *
   */
   session_start();
  require_once 'Controleur/ControleurAuthentification.php';
  require_once 'Controleur/ControleurInscription.php';
  require_once 'Controleur/ControleurUtilisateur.php';

  class Routeur{
    private $controleurAuthentification;
    private $ControleurInscription;
    private $controleurUtilisateur;
    function __construct()
    {
      $this->controleurAuthentification = new ControleurAuthentification();
      $this->controleurInscription = new ControleurInscription();
      $this->controleurUtilisateur = new ControleurUtilisateur();
      // Si l'utilisateur souhaite arriver sur la page d'accueil
      if(empty($_GET)) {
        // Si l'utilisateur est connecté
        if($this->controleurAuthentification->estConnecte()){
          // On le redirige vers sa page d'accueil
          header("Location: ?accueil");
        }else{
          // Sinon, s'il n'est pas connecté
          // On le redirige vers la page d'authentification
          header("Location: ?connexion");
        }
      }
      // Si l'utilisateur souhaite afficher la page de connexion
      else if (isset($_GET['connexion'])) {
        // On verifie si l'utilisateur est connecté
        // Si l'utilisateur est connecté
        if($this->controleurAuthentification->estConnecte()){
          // On le redirige vers sa page d'accueil
          header("Location: ?accueil");
        }else{
          // Sinon, s'il n'est pas connecté
          // On peut afficher la page d'authentification
          $this->controleurAuthentification->afficherPageDeConnexion();
        }
      }
      // Si l'utilisateur soumet le formulaire de connexion
      else if (isset($_GET['soumissionConnexion'])) {
        $this->controleurAuthentification->authentification();
      }
      // Si l'utilisateur soumet le formulaire d'inscription
      else if (isset($_GET['inscription'])) {
        $this->controleurInscription->afficherPageInscription();
      }
      else if (isset($_GET['soumissionInscription'])) {
        $this->controleurInscription->inscrireUtilisateur();
      }
      else if (isset($_GET['deconnexion'])) {
        $this->controleurAuthentification->deconnexion();
        header("Location: ?connexion");
      }
      // Si l'utilisateur souhaite afficher une autre page mais qu'il n'est pas connecté
      else if (!$this->controleurAuthentification->estConnecte()) {
        // On redirige l'utilisateur vers la page de connexion
        // On passe l'erreur 666 : tentative d'accès non authorisé
        header("Location: ?connexion&erreur=666");
      }
      // Si l'utilisateur souhaite se rendre sur la page d'accueil
      else if (isset($_GET['accueil'])){
        $this->controleurUtilisateur->afficherPageAfficherModules();
      }
      // Si l'utilisateur souhaite ajouter une formation
      else if (isset($_GET['ajoutFormation'])){
        $this->controleurUtilisateur->afficherPageAjoutFormation();
      }
      // Si l'utilisateur a soumis le formulaire d'ajout de formation
      else if (isset($_GET['ajoutFormationSub'])){
        $this->controleurUtilisateur->ajouterFormation();
      }
      else if (isset($_GET['ajoutUE'])) {
        $this->controleurUtilisateur->afficherPageAjoutUE();
      }
      else if (isset($_GET['ajoutUESub'])) {
        $this->controleurUtilisateur->ajouterUE();
      }
      else if (isset($_GET['ajoutModule'])) {
        $this->controleurUtilisateur->afficherPageAjoutModule();
      }
      else if (isset($_GET['ajoutModuleSub'])) {
        $this->controleurUtilisateur->ajouterModule();
      }
      else if (isset($_GET['ajoutVoeu'])) {
        $this->controleurUtilisateur->afficherPageAjoutVoeu();
      }
      else if (isset($_GET['ajoutVoeuSub'])) {
        $this->controleurUtilisateur->ajouterVoeu();
      }
      else if (isset($_GET['afficherModules'])) {
        $this->controleurUtilisateur->afficherPageAfficherModules();
      }
      else if (isset($_GET['modifierVoeuSub'])) {
        $this->controleurUtilisateur->modifierVoeu();
      }
      else if(isset($_GET['supprimerVoeuSub'])){
        $this->controleurUtilisateur->supprimerVoeu();
      }
      else if (isset($_GET['ajoutProfesseurFormationSub'])) {
        $this->controleurUtilisateur->ajouterProfesseurAFormation();
      }
      else if(isset($_GET['ajoutProfesseurFormation'])){
        $this->controleurUtilisateur->afficherPageAjoutProfesseurFormation();
      }
      else if(isset($_GET['ajoutSecretaireFormation'])){
        $this->controleurUtilisateur->afficherPageAjoutSecretaireFormation();
      }
      else if(isset($_GET['ajoutSecretaireFormationSub'])){
        $this->controleurUtilisateur->ajouterSecretaireAFormation();
      }
      else if(isset($_GET['modifierModuleSub'])){
        $this->controleurUtilisateur->modifierModule();
      }
      else if(isset($_GET['supprimerModule'])){
        $this->controleurUtilisateur->supprimerModule();
      }
      else if (isset($_GET['parametres'])) {
        $this->controleurUtilisateur->afficherPageParametresCompte();
      }
      else if (isset($_GET['parametresModifNom'])) {
        $this->controleurUtilisateur->updateNomPrenom();
      }
      else if (isset($_GET['parametresModifEmail'])) {
        $this->controleurUtilisateur->updateEmail();
      }
      else if (isset($_GET['parametresModifPwd'])) {
        $this->controleurUtilisateur->updatePswd();
      }
      else if (isset($_GET['resumeEnseignements'])) {
        $this->controleurUtilisateur->pageResumeEnseignements();
      }
      else if (isset($_GET['rejoindreFormation'])) {
        $this->controleurUtilisateur->afficherPageRejoindreFormation();
      }
      else if (isset($_GET['joinFormation'])) {
        $this->controleurUtilisateur->rejoindreFormationProf();
      }
      else if (isset($_GET['retirerFormation'])) {
        $this->controleurUtilisateur->retirerFormation();
      } elseif (isset($_GET['genererPdfEnseignements'])) {
        $this->controleurUtilisateur->genererPdfEnseignements();
      }
      else {
        header("Location: ?connexion");
      }
    }
  }
