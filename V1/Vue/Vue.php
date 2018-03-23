<?php
  /** Classe de la vue
   *
   */
  class Vue
  {

    function __construct()
    {
    }

      function pageDeConnexion(){
        include 'pageDeConnexion.php';
      }

      function pageInscription($formation){
        include 'pageInscription.php';
      }

      function pageAjoutFormation(){
        include 'pageAjoutFormation.php';
      }

      function pageParametresCompte($mesHeuresSouhaitees, $mesPointsSouhaites, $formationsUtilisateur, $dansUneFormation, $tabFormations) {
        include 'pageParametres.php';
      }

      function pageResumeEnseignements($mesHeuresSouhaitees, $mesPointsSouhaites, $voeuxUtilisateur, $nbHeuresTotal) {
        include 'pageResumeEnseignements.php';
      }

      function pageRejoindreFormation($tabFormations, $prenomAdmin, $nomAdmin) {
        include 'pageRejoindreFormation.php';
      }

      function genererPdf($voeuxUtilisateur, $nbHeuresTotal) {
        include 'genererPdf.php';
      }

      function pageAccueil(){
        echo "page d'accueil <a href='?deconnexion'>deco </a>";
        echo " <a href='?ajoutFormation'> formation </a>";
        echo " <a href='?ajoutModule'> module </a>";
        echo " <a href='?ajoutUE'> UE </a>";
        echo " <a href='?ajoutVoeu'> Voeu </a>";
        echo " <a href='?afficherModules'> Vue videoproj </a>";
      }

      function pageAjoutModule($formations, $niveaux, $ues){
        include 'pageAjoutModule.php';
      }

      function pageAjoutUE($formations, $niveaux){
        include 'pageAjoutUE.php';
      }

      function pageAjoutVoeu($modules){
        include 'pageAjoutVoeu.php';
      }

      function pageAfficherModules($mesHeuresSouhaitees, $mesPointsSouhaites, $formations){
        include 'pageAfficherModules.php';
      }

      function pageAfficherAjoutProfesseurFormation(){
        include 'pageAjoutProfesseurDansFormation.php';
      }

      function pageAfficherAjoutSecretaireFormation(){
        include 'pageAjoutSecretaireDansFormation.php';
      }
  }

 ?>
