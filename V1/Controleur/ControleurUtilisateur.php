<?php

require_once "Vue/Vue.php";
require_once "Model/DAO/DAOUtilisateur.php";
require_once "Model/DAO/DAOInscription.php";
require_once "Model/DAO/DAOAuthentification.php";

class ControleurUtilisateur{

  private $vue;
  private $dao;

  function __construct()
  {
    $this->vue = new Vue();
    $this->daoUtilisateur = new DAOUtilisateur();
    $this->daoInscription = new DAOInscription();
    $this->daoAuthentification = new DAOAuthentification();
    if (isset($_SESSION["id_utilisateur"])) {
      $_SESSION["nom"] = $this->daoUtilisateur->getNom($_SESSION["id_utilisateur"]);
      $_SESSION["prenom"] = $this->daoUtilisateur->getPrenom($_SESSION["id_utilisateur"]);
      $_SESSION["email"] = $this->daoUtilisateur->getEmail($_SESSION["id_utilisateur"]);
    }
  }

  public function updateNomPrenom() {
    $this->daoUtilisateur->updatePrenom($_SESSION["id_utilisateur"], $_POST["newPrenom"]);
    $this->daoUtilisateur->updateNom($_SESSION["id_utilisateur"], $_POST["newNom"]);
    header('Location: ?parametres&succes=2');
  }

  public function updateEmail() {
    if ($this->daoAuthentification->verifierIdentifiants($_POST["pswEmail"], $_SESSION["email"])) {
      if ($this->daoInscription->utilisateurExistant($_POST['nouveauEmail'])) {
        header('Location: ?parametres&erreur=404');
      } else {
        if (filter_var($_POST['nouveauEmail'], FILTER_VALIDATE_EMAIL)) {
          $this->daoUtilisateur->changerEmail($_SESSION["id_utilisateur"], $_POST['nouveauEmail']);
          header('Location: ?parametres&succes=1');
        } else {
          header('Location: ?parametres&erreur=405');
        }
      }
    } else {
      header('Location: ?parametres&erreur=1');
    }
  }

  public function updatePswd() {
    if ($this->daoAuthentification->verifierIdentifiants($_POST["oldPsw"], $_SESSION["email"])) {
      if (($_POST["newPsw"]==$_POST["confNewPsw"])) {
        if ($_POST["oldPsw"]!=$_POST["newPsw"]) {
          $hashed_pwd = password_hash($_POST['newPsw'], PASSWORD_BCRYPT);
          $this->daoInscription->updateMotDePasse($_SESSION["id_utilisateur"], $hashed_pwd);
          header('Location: ?parametres&succes=3');
        } else {
          header('Location: ?parametres&erreur=6');
        }
      } else {
        header('Location: ?parametres&erreur=5');
      }
    } else {
      header('Location: ?parametres&erreur=1');
    }

  }

  public function afficherPageAccueil(){
    $this->vue->pageAccueil();
  }

  public function pageResumeEnseignements() {
    $this->daoUtilisateur->supprimerVoeuxSansHeures();
    $mesHeuresSouhaitees = $this->daoUtilisateur->recupererNbHeuresVoeux($_SESSION["id_utilisateur"]);
    $mesPointsSouhaites = $this->daoUtilisateur->recupererNbPtVoeux($_SESSION["id_utilisateur"]);
    $voeuxUtilisateur = $this->daoUtilisateur->recupererAllVoeuxUtilisateur($_SESSION["id_utilisateur"]);
    $nbHeuresTotal = $this->daoUtilisateur->recupererNbHeuresVoeux($_SESSION["id_utilisateur"]);
    $this->vue->pageResumeEnseignements($mesHeuresSouhaitees, $mesPointsSouhaites, $voeuxUtilisateur, $nbHeuresTotal);
  }

  public function genererPdfEnseignements() {
    $voeuxUtilisateur = $this->daoUtilisateur->recupererAllVoeuxUtilisateur($_SESSION["id_utilisateur"]);
    $nbHeuresTotal = $this->daoUtilisateur->recupererNbHeuresVoeux($_SESSION["id_utilisateur"]);
    $voeuxUtilisateur = $this->daoUtilisateur->recupererAllVoeuxUtilisateur($_SESSION["id_utilisateur"]);
    $nbHeuresTotal = $this->daoUtilisateur->recupererNbHeuresVoeux($_SESSION["id_utilisateur"]);
    $this->vue->genererPdf($voeuxUtilisateur, $nbHeuresTotal, $voeuxUtilisateur, $nbHeuresTotal);
  }

  public function afficherPageAjoutFormation(){
    $this->vue->pageAjoutFormation();
  }

  public function afficherPageRejoindreFormation() {
    $tabFormations = $this->daoUtilisateur->getAllFormations();
    $prenomAdmin = $this->daoUtilisateur->getPrenom($_SESSION['id_utilisateur']);
    $nomAdmin = $this->daoUtilisateur->getNom($_SESSION['id_utilisateur']);
    $this->vue->pageRejoindreFormation($tabFormations, $prenomAdmin, $nomAdmin);
  }

  public function rejoindreFormationProf() {
    $idFormation = $_POST["formation"];
    if (!$this->daoUtilisateur->estProfesseurDeFormation($_SESSION["id_utilisateur"], $idFormation)) {
      $this->daoUtilisateur->ajouterProfesseurAFormation($idFormation, $_SESSION["id_utilisateur"]);
      header('Location: ?accueil');
    } else {
      header('Location: ?rejoindreFormation&erreur=1');
    }
  }

  public function retirerFormation() {
    if ($this->daoAuthentification->verifierIdentifiants($_POST["pswFormation"], $this->daoUtilisateur->getEmail($_SESSION["id_utilisateur"]))) {
      if ($this->daoUtilisateur->recupererTypeUtilisateur($_SESSION["id_utilisateur"]) == 0) { //Si il est prof
        $this->daoUtilisateur->retirerProfDeFormation($_SESSION["id_utilisateur"], $_POST["selectFormationRetirer"]);
        header('Location: ?accueil');
      } else { //Si il est secrétaire
        $this->daoUtilisateur->retirerSecretaireDeFormation($_SESSION["id_utilisateur"], $_POST["selectFormationRetirer"]);
        header('Location: ?accueil');
      }
    } else {
      header('Location: ?parametres&erreur=1');
    }


  }

  /*
  Pseudo code
  Si le nom de formation est OK
  Si l'admin est OK (Si c'est un prof et qu'il est admin ou si le mail renseigné est ok)
  Créer la formation
  ajouter l'utilisateur correctement
  */
  public function ajouterFormation(){
    // On vérifie que les champs indispensables ont bien été transmis
    if (isset($_POST["nom_formation"]) && !empty($_POST["nom_formation"]) && isset($_POST["nbNiveaux"]) && !empty($_POST["nbNiveaux"])) {
      $nomFormation = htmlspecialchars($_POST["nom_formation"]);
      // Si l'utilisateur est prof
      if($this->daoUtilisateur->recupererTypeUtilisateur($_SESSION["id_utilisateur"]) == "0"){
        // Si l'utilisateur se désigne comme administrateur de la formation
        if(isset($_POST["admin"]) && $_POST["admin"] == true){
            // On créer la formation
            $idFormation = $this->daoUtilisateur->ajouterFormation($nomFormation, $_POST["nbNiveaux"]);
            // On lui ajoute des niveau
            for ($i=0; $i <= $_POST['nbNiveaux']; $i++) {//le nombre de niveaux créés dans le formulaire
              if (isset($_POST['nomNiveau'.$i]) && isset($_POST['nbTDNiveau'.$i]) && isset($_POST['nbTPNiveau'.$i]) && isset($_POST['nbCMNiveau'.$i])) {
                  $nomniveau = htmlspecialchars($_POST["nomNiveau".$i]);
                  $numniveau = $i+1;
                  $nbtd = htmlspecialchars($_POST['nbTDNiveau'.$i]);
                  $nbtp = htmlspecialchars($_POST['nbTPNiveau'.$i]);
                  $nbcm = htmlspecialchars($_POST['nbCMNiveau'.$i]);
                  $nbDS = htmlspecialchars($_POST['nbDSNiveau'.$i]);
                  $this->daoUtilisateur->ajouterNiveau($nomniveau, $numniveau, $idFormation, $nbtd, $nbtp, $nbcm, $nbDS);
              }
            }
            // On désigne l'utilisateur comme professeur de la formation qu'il a créé.
            $this->daoUtilisateur->ajouterProfesseurAFormation($idFormation, $_SESSION["id_utilisateur"]);
          // On désigne l'utilisateur comme administrateur de la formation qu'il a créé.
          $this->daoUtilisateur->ajouterAdminAFormation($idFormation, $_SESSION["id_utilisateur"]);
          // Sinon si le mail de l'admin est vide
        }elseif(isset($_POST["mail_admin"]) && !empty($_POST["mail_admin"])){
            // Si l'utilisateur existe on l'ajoute
            if($this->daoInscription->utilisateurExistant($_POST["mail_admin"])){
              // On récupère son ID
              $idAdministrateur = $this->daoAuthentification->recupererIDParPseudoUtilisateur($_POST["mail_admin"]);
              // On créer la formation
              $idFormation = $this->daoUtilisateur->ajouterFormation($nomFormation, $_POST["nbNiveaux"]);
              // On lui ajoute des niveau
              for ($i=0; $i <= $_POST['nbNiveaux']; $i++) {//le nombre de niveaux créés dans le formulaire
                if (isset($_POST['nomNiveau'.$i]) && isset($_POST['nbTDNiveau'.$i]) && isset($_POST['nbTPNiveau'.$i]) && isset($_POST['nbCMNiveau'.$i])) {
                    $nomniveau = htmlspecialchars($_POST["nomNiveau".$i]);
                    $numniveau = $i+1;
                    $nbtd = htmlspecialchars($_POST['nbTDNiveau'.$i]);
                    $nbtp = htmlspecialchars($_POST['nbTPNiveau'.$i]);
                    $nbcm = htmlspecialchars($_POST['nbCMNiveau'.$i]);
                    $nbDS = htmlspecialchars($_POST['nbCMNiveau'.$i]);
                    $this->daoUtilisateur->ajouterNiveau($nomniveau, $numniveau, $idFormation, $nbtd, $nbtp, $nbcm, $nbDS);
                }
              }
              // On désigne l'utilisateur comme professeur de la formation qu'il a créé.
              $this->daoUtilisateur->ajouterProfesseurAFormation($idFormation, $_SESSION["id_utilisateur"]);
              // On le désigne comme administrateur de la formation.
              $this->daoUtilisateur->ajouterAdminAFormation($idFormation, $idAdministrateur);
              if($_SESSION["id_utilisateur"] != $idAdministrateur){
                // On le désigne comme professeur de la formation.
                $this->daoUtilisateur->ajouterProfesseurAFormation($idFormation, $idAdministrateur);
              }
            }
            elseif (!filter_var($_POST['mail_admin'], FILTER_VALIDATE_EMAIL)) {
              header("Location: ?ajoutFormation=".$_POST["nom_formation"]."&erreur=3&adminmail=".$_POST["mail_admin"]);
            }
            // Sinon, si l'utilisateur a souhaité invité quelqu'un à rejoindre ORCE
            elseif (isset($_POST["invitationORCE"]) && $_POST["invitationORCE"] == "oui") {

              // A FINIR
              // On envoie un mail à l'utilisateur
              $to = $_POST['mail_admin']; // note the comma

              // Subject
              $subject = "Vous avez ete invité à rejoindre la formation ".$nomFormation;

              // Message
              $message = "
              <html>
              <head>
                <title>Vous avez été invité à rejoindre la formation $nomFormation</title>
              </head>
              <body>
                <p>Vous avez été invité à rejoindre la formation $nomFormation !</p>
              </body>
              </html>
              ";

              // To send HTML mail, the Content-type header must be set
              $headers[] = 'MIME-Version: 1.0';
              $headers[] = 'Content-type: text/html; charset=utf-8';

              // Additional headers
              $headers[] = 'To: '.$_POST['mail_admin'];
              $headers[] = "From: ORCE <no-reply@orce.com>";

              // Mail it
              mail($to, $subject, $message, implode("\r\n", $headers));
              // On envoie un mail d'invitation à ORCE
            }
            // Sinon, on demande à l'utilisateur s'il veut l'inviter à rejoindre ORCE
            else{
              header("Location: ?ajoutFormation=".$_POST["nom_formation"]."&adminInexistant&adminmail=".$_POST["mail_admin"]);
            }

        }else{
          header("Location: ?ajoutFormation&erreur=2");
        }
      // Si l'utilisateur est secrétaire
      }else{
        // Verifications à faire pour l'admin
        // Ajout de la formation
        // Ajout de l'administrateur
        // On l'ajoute comme secrétaire
        $this->daoUtilisateur->ajouterSecretaireAFormation($idFormation, $_SESSION["id_utilisateur"]);
      }
      // echo "breakpoint";
      header("Location: ?accueil");
    }else{
      header("Location: ?ajoutFormation&erreur=1");
    }
  }

  public function afficherPageAjoutUE(){
    $formations=$this->daoUtilisateur->recupererFormationsParIDAdministrateur($_SESSION["id_utilisateur"]);
    $niveaux = array();
    foreach ($formations as $formation) {
      $niveauxBruts = $this->daoUtilisateur->recupererNiveauxParIDFormation($formation["ID"]);
      foreach ($niveauxBruts as $niveauBrut) {
        $niveaux[] = $niveauBrut;
      }
    }
    $this->vue->PageAjoutUE($formations, $niveaux);
  }

  public function ajouterUE(){
    // On vérifie que les champs indispensables ont bien été transmis
    if (isset($_POST["nom"]) && !empty($_POST["nom"]) && isset($_POST["niveau"]) && !empty($_POST["niveau"])) {
      $_POST["nom"] = htmlspecialchars($_POST["nom"]);
      $_POST["niveau"] = htmlspecialchars($_POST["niveau"]);
      //On vérifie que le professeur est bien administrateur de la formation qu'li souhaite modifier
      if ($this->daoUtilisateur->estAdminDeFormation($_SESSION['id_utilisateur'], $this->daoUtilisateur->recupererNiveauParID($_POST['niveau'])[0]['Formation_ID'])) {
        //On ajoute l'UE à la formation
        $this->daoUtilisateur->ajouterUE($_POST['nom'], $_POST['niveau']);
        header("Location: ?accueil");
      }
      else{
        header("Location: ?ajoutUE&erreur=2");
      }
    }
    else {
      header("Location: ?ajoutUE&erreur=1");
    }
  }

  public function afficherPageAjoutModule(){
    //On renseigne les différentes formations, niveaux et ues que peut sélectionner l'utilisateur
    $formations=$this->daoUtilisateur->recupererFormationsParIDAdministrateur($_SESSION["id_utilisateur"]);
    foreach ($formations as $formation) {
      $niveauxBruts = $this->daoUtilisateur->recupererNiveauxParIDFormation($formation["ID"]);
      foreach ($niveauxBruts as $niveauBrut) {
        $niveaux[] = $niveauBrut;
      }
    }
    foreach ($niveaux as $niveau) {
      $uesBruts = $this->daoUtilisateur->recupererUEsParNiveauID($niveau['ID']);
      foreach ($uesBruts as $ueBrut) {
        $ues[] = $ueBrut;
      }
    }
    //On ajoute le module à l'ue sélectionnée par l'utilisateur
    $this->vue->PageAjoutModule($formations, $niveaux, $ues);
  }

  public function ajouterModule(){
    // On verifie si tous les champs sont bien remplis
    if(
      isset($_POST["ID"]) &&
      !empty($_POST["ID"]) &&
      isset($_POST["nom"]) &&
      !empty($_POST["nom"]) &&
      isset($_POST["UE_ID"]) &&
      !empty($_POST["UE_ID"]) &&
      isset($_POST["nbHeuresTD"]) &&
      !empty($_POST["nbHeuresTD"]) &&
      isset($_POST["nbHeuresTP"]) &&
      !empty($_POST["nbHeuresTP"]) &&
      isset($_POST["nbHeuresCM"]) &&
      !empty($_POST["nbHeuresCM"]) &&
      isset($_POST["nbHeuresDS"]) &&
      !empty($_POST["nbHeuresDS"]) &&
      isset($_POST["duree"]) &&
      !empty($_POST["duree"])

    ){
      // On traite tous les champs
      $idModule = htmlspecialchars($_POST["ID"]);
      $nomModule = htmlspecialchars($_POST["nom"]);
      $idUE = htmlspecialchars($_POST["UE_ID"]);
      $nbHeuresTD = htmlspecialchars($_POST["nbHeuresTD"]);
      $nbHeuresTP = htmlspecialchars($_POST["nbHeuresTP"]);
      $nbHeuresCM = htmlspecialchars($_POST["nbHeuresCM"]);
      $nbHeuresDS = htmlspecialchars($_POST["nbHeuresDS"]);
      $debut = htmlspecialchars($_POST['debut']);
      $fin = htmlspecialchars($_POST['fin']);
      // Si le module n'existe pas déjà
      if(!$this->daoUtilisateur->moduleExistant($idModule)){
        // On vérifie que l'utilisateur a les privilege sur la formation à laquelle il tente d'ajouter un module
        if(
          $this->daoUtilisateur->estAdminDeFormation($_SESSION["id_utilisateur"], $this->daoUtilisateur->recupererFormationParIDUE($idUE)["ID"]) ||
          $this->daoUtilisateur->estSecretaireDeFormation($_SESSION["id_utilisateur"], $this->daoUtilisateur->recupererFormationParIDUE($idUE)["ID"])
        ){
          $this->daoUtilisateur->ajouterModule($idModule, $nomModule, $idUE, $nbHeuresTD, $nbHeuresTP, $nbHeuresCM, $nbHeuresDS, $debut, $fin);
          header("Location: ?accueil");
        }else{
            header("Location: ?ajoutModule&erreur=3");
        }
      }else{
          header("Location: ?ajoutModule&erreur=2");
      }
    }else{
        header("Location: ?ajoutModule&erreur=1");
    }
  }

  public function afficherPageAjoutVoeu(){
    $formations=$this->daoUtilisateur->recupererFormationsParIDProfesseur($_SESSION["id_utilisateur"]);
    $niveaux = array();
    foreach ($formations as $formation) {
      $niveauxBruts = $this->daoUtilisateur->recupererNiveauxParIDFormation($formation["ID"]);
      foreach ($niveauxBruts as $niveauBrut) {
        $niveaux[] = $niveauBrut;
      }
    }

    foreach ($niveaux as $niveau) {
      $uesBruts = $this->daoUtilisateur->recupererUEsParNiveauID($niveau['ID']);
      foreach ($uesBruts as $ueBrut) {
        $ues[] = $ueBrut;
      }
    }

    foreach ($ues as $ue) {
      $modulesBruts = $this->daoUtilisateur->recupererModulesParUEID($ue['ID']);
      foreach ($modulesBruts as $moduleBrut) {
        $modules[] = $moduleBrut;
      }
    }
    $this->vue->pageAjoutVoeu($modules);
  }


  public function ajouterVoeu(){
    //On vérifie que l'utilisateur a bien entré tous les champs du formulaire
    if (isset($_POST['commentaire']) &&
     isset($_POST['ModuleID']) &&
     !empty($_POST['ModuleID']) &&
     isset($_POST['nbGroupesTP']) &&
     isset($_POST['nbGroupesTD']) &&
     isset($_POST['nbGroupesCM']) &&
     isset($_POST['nbGroupesDS'])
   ) {
      // On sécurise tous les champs
      $commentaire = htmlspecialchars($_POST['commentaire']);
      $moduleID = htmlspecialchars($_POST['ModuleID']);
      $nbGroupesTP = htmlspecialchars($_POST['nbGroupesTP']);
      $nbGroupesTD = htmlspecialchars($_POST['nbGroupesTD']);
      $nbGroupesCM = htmlspecialchars($_POST['nbGroupesCM']);
      $nbGroupesDS = htmlspecialchars($_POST['nbGroupesDS']);

      // On récupère l'id de la formation
      $ue_id = $this->daoUtilisateur->recupererModuleParID($moduleID)["UE_ID"];
      $formationid = $this->daoUtilisateur->recupererFormationParIDUE($ue_id)["ID"];
      // On vérifie si le professeur fait un voeu pour une des formations dans lesquelles il est autorisé à enseigner
      if ($this->daoUtilisateur->estProfesseurDeFormation($_SESSION['id_utilisateur'], $formationid)) {
        $this->daoUtilisateur->ajouterVoeu($commentaire, $moduleID, $nbGroupesTP, $nbGroupesTD, $nbGroupesCM, $nbGroupesDS, $_SESSION['id_utilisateur']);
        header("Location: ?accueil");
      }
      else{
        header("Location: ?ajoutVoeu&erreur=2");
      }
    }
    else{
      header("Location: ?ajoutVoeu&erreur=1");
    }
  }

  function afficherPageAfficherModules(){
    // On calcule le nombre d'heures totalisées par les vœux
    $mesHeuresSouhaitees = $this->daoUtilisateur->recupererNbHeuresVoeux($_SESSION["id_utilisateur"]);
    $mesPointsSouhaites = $this->daoUtilisateur->recupererNbPtVoeux($_SESSION["id_utilisateur"]);
    $formationsBrut=$this->daoUtilisateur->recupererFormationsParIDProfesseur($_SESSION["id_utilisateur"]);
    $formationsBrut+=$this->daoUtilisateur->recupererFormationsParIDSecretaire($_SESSION["id_utilisateur"]);
    $niveaux = array();
    $formations = array();
    foreach ($formationsBrut as $formation) {
      $niveauxBruts = $this->daoUtilisateur->recupererNiveauxParIDFormation($formation["ID"]);
      // On initialise la variable niveaux pour le formation
      $niveaux = array();
      foreach ($niveauxBruts as $niveauBrut) {
        // On initalise la variable ue

        $ues = array();
        $uesBruts = $this->daoUtilisateur->recupererUEsParNiveauID($niveauBrut['ID']);
        foreach ($uesBruts as $ueBrut) {
          // On initalise la variable modules
          $modules = array();
          $modulesBruts = $this->daoUtilisateur->recupererModulesParUEID($ueBrut['ID']);
          foreach ($modulesBruts as $moduleBrut) {
            $voeux = array();
            $voeuxBruts = $this->daoUtilisateur->recupererVoeuxParModuleID($moduleBrut['ID']);
            foreach ($voeuxBruts as $voeuBrut) {
              $prof = $this->daoUtilisateur->recupererUtilisateur($voeuBrut['Utilisateur_ID']);
              $voeuBrut["nomProf"] = substr($prof["prenom"],0,1).". ".$prof["nom"] ;
              $voeux[] = $voeuBrut;
            }
            $moduleBrut["voeux"] = $voeux;
            $modules[] = $moduleBrut;
          }
          $ueBrut["modules"] = $modules;
          $ueBrut["nbHeures"] = $this->calculerNombreHeuresParUE($ueBrut["ID"]);
          $ues[] = $ueBrut;
        }
        $niveauBrut["ues"] = $ues;
        $niveaux[] = $niveauBrut;
      }
      // On stocke la variable niveau dans la formation
      $formation["niveaux"] = $niveaux;

      $formation["estSuperAdmin"]=false;
      $listeSuperAdmins = $this->daoUtilisateur->recupererSuperAdminParFormationID($formation["ID"]);
      foreach ($listeSuperAdmins as $superAdmin){
	if($superAdmin["ID"] == $_SESSION["id_utilisateur"]){
		$formation["estSuperAdmin"] = true;
	}
      }
      
       $formation["estAdmin"] = false;
       $listeAdmins = $this->daoUtilisateur->recupererAdminParFormationID($formation["ID"]);
      
      	foreach ($listeAdmins as $admin) {
        	if($admin["ID"] == $_SESSION["id_utilisateur"]){
        	  $formation["estAdmin"] = true;
        	}
      	}	
      
      $listeProfs = $this->daoUtilisateur->recupererProfsParFormationID($formation["ID"]);
      $formation["estProf"] = false;
      foreach ($listeProfs as $prof) {
        if($prof["ID"] == $_SESSION["id_utilisateur"]){
          $formation["estProf"] = true;
        }
      }
      $listeSecretaires = $this->daoUtilisateur->recupererSecretairesParFormationID($formation["ID"]);
      $formation["estSecretaire"] = false;
      foreach ($listeSecretaires as $secretaires) {
        if($secretaires["ID"] == $_SESSION["id_utilisateur"]){
          $formation["estSecretaire"] = true;
        }
      }
      $formations[] = $formation;
    }
    $this->vue->pageAfficherModules($mesHeuresSouhaitees, $mesPointsSouhaites,$formations);
  }

  function calculerHeuresTravaillees(){
    $nbHeures = 0;
    $tableau = $this->daoUtilisateur->recupererNbHeuresParIDUtilisateur($_SESSION['id_utilisateur']);
    foreach ($tableau as $tab) {
      $nbHeures += $tab['nombres_heures'];
    }
    return $nbHeures;
  }

  function modifierVoeu(){
    //On vérifie que les chmaps nécessaires soient bien renseignés
    if (isset($_POST['commentaire']) &&
     isset($_POST['ModuleID']) &&
     !empty($_POST['ModuleID']) &&
     isset($_POST['nbGroupesTP']) &&
     isset($_POST['nbGroupesTD']) &&
     isset($_POST['nbGroupesCM']) &&
     isset($_POST['nbGroupesDS'])
     ) {
      // On sécurise tous les champs
      $commentaire = htmlspecialchars($_POST['commentaire']);
      $moduleID = htmlspecialchars($_POST['ModuleID']);
      $nbGroupesTP = htmlspecialchars($_POST['nbGroupesTP']);
      $nbGroupesTD = htmlspecialchars($_POST['nbGroupesTD']);
      $nbGroupesCM = htmlspecialchars($_POST['nbGroupesCM']);
      $nbGroupesDS = htmlspecialchars($_POST['nbGroupesDS']);

      // On récupère l'id de la formation
      $ue_id = $this->daoUtilisateur->recupererModuleParID($moduleID)["UE_ID"];
      $formationid = $this->daoUtilisateur->recupererFormationParIDUE($ue_id)["ID"];
      // On vérifie si le professeur fait un voeu pour une des formations dans lesquelles il est autorisé à enseigner
      if ($this->daoUtilisateur->estProfesseurDeFormation($_SESSION['id_utilisateur'], $formationid)) {
        $this->daoUtilisateur->modifierVoeu($commentaire, $moduleID, $nbGroupesTP, $nbGroupesTD, $nbGroupesCM, $nbGroupesDS, $_SESSION['id_utilisateur']);
        header("Location: ?afficherModules");
      }
      else{
        header("Location: ?ajoutVoeu&erreur=2");
      }
    }
    else{
      header("Location: ?ajoutVoeu&erreur=1");
    }
  }

  function supprimerVoeu(){
    //On vérifie si le voeu existe
    if ($this->daoUtilisateur->voeuExistant($_GET['VoeuID'])) {
      $voeu = $this->daoUtilisateur->recupererVoeuParID($_GET['VoeuID']);
      //On vérifie si le voeu appartient bien à l'utilisateur courant
      if ($voeu['Utilisateur_ID'] == $_SESSION['id_utilisateur']) {
        $this->daoUtilisateur->supprimerVoeu($voeu['ID']);
        header("Location: ?afficherPageAccueil");
      }
      else{
        header("Location: ?supprimerVoeu&erreur=2");
      }
    }
    else{
      header("Location: ?supprimerVoeu&erreur=1");
    }
  }

  function afficherPageAjoutProfesseurFormation(){
    $this->vue->pageAfficherAjoutProfesseurFormation();
  }

  function afficherPageParametresCompte() {
    $mesHeuresSouhaitees = $this->daoUtilisateur->recupererNbHeuresVoeux($_SESSION["id_utilisateur"]);
    $mesPointsSouhaites = $this->daoUtilisateur->recupererNbPtVoeux($_SESSION["id_utilisateur"]);
    if ($this->daoUtilisateur->recupererTitreUtilisateur($_SESSION["id_utilisateur"]) == "Enseignant") {
      $formationsUtilisateur = $this->daoUtilisateur->recupererFormationsParIDProfesseur($_SESSION["id_utilisateur"]);
    } else {
      $formationsUtilisateur = $this->daoUtilisateur->recupererFormationsParIDSecretaire($_SESSION["id_utilisateur"]);
    }
    $dansUneFormation = (($this->daoUtilisateur->estProfDansUneFormation($_SESSION["id_utilisateur"])) || ($this->daoUtilisateur->estSecretaireDansUneFormation($_SESSION["id_utilisateur"])));
    $tabFormations = $this->daoUtilisateur->getAllFormations();
    $this->vue->pageParametresCompte($mesHeuresSouhaitees, $mesPointsSouhaites, $formationsUtilisateur, $dansUneFormation, $tabFormations);
  }

  function ajouterProfesseurAFormation(){
    //On vérifie si les champs sont bien remplis
    if (isset($_POST["professeur"]) && !empty($_POST["professeur"]) && isset($_POST["formation"]) && !empty($_POST["formation"])) {
      $professeurLogin = htmlspecialchars($_POST["professeur"]);
      $formation = htmlspecialchars($_POST["formation"]);
      //On vérifie si l'utilisateur est administrateur de la formation qu'il souhaite modifier
      if ($this->daoUtilisateur->estAdminDeFormation($_SESSION["id_utilisateur"], $formation)) {
        //On vérifie si l'email du professeur ajouté existe
        if ($this->daoAuthentification->recupererIDParPseudoUtilisateur($professeurLogin)) {
          //On vérifié si il n'est pas déjà professeur dans la formation
          $professeur = $this->daoUtilisateur->recupererUtilisateur($this->daoAuthentification->recupererIDParPseudoUtilisateur($professeurLogin));
          //Si le professeur n'appartient pas à la formation, on l'ajoute
          if(!$this->daoUtilisateur->estProfesseurDeFormation($professeur["ID"], $formation)){
            $this->daoUtilisateur->ajouterProfesseurAFormation($formation, $professeur["ID"]);
          }else{
            header("Location: ?ajoutProfesseurFormation&erreur=4");
          }
        }
        else{
          header("Location: ?ajoutProfesseurFormation&erreur=3");
        }
      }
      else{
        header("Location: ?ajoutProfesseurFormation&erreur=2");
      }
    }
    else{
      header("Location: ?ajoutProfesseurFormation&erreur=1");
    }
  }

  function afficherPageAjoutSecretaireFormation(){
    $this->vue->pageAfficherAjoutSecretaireFormation();
  }

  function ajouterSecretaireAFormation(){
    //On vérifie si les champs sont renseignés
    if (isset($_POST["secretaire"]) && !empty($_POST["secretaire"]) && isset($_POST["formation"]) && !empty($_POST["formation"])) {
      $secretaireLogin = htmlspecialchars($_POST["secretaire"]);
      $formation = htmlspecialchars($_POST["formation"]);
      //On vérifie si l'utilisateur est administrateur de la formation qu'il souhaite modifier
      if ($this->daoUtilisateur->estAdminDeFormation($_SESSION['id_utilisateur'], $formation)) {
        //On vérifie si l'email de la secrétaire ajoutée existe
        if ($this->daoAuthentification->recupererIDParPseudoUtilisateur($secretaireLogin)) {
          $secretaire = $this->daoUtilisateur->recupererUtilisateur($this->daoAuthentification->recupererIDParPseudoUtilisateur($secretaireLogin));
          //Si la secrétaire n'appartient pas à la formation, on l'ajoute
          if(!$this->daoUtilisateur->estSecretaireDeFormation($secretaire["ID"], $formation)){
            $this->daoUtilisateur->ajouterSecretaireAFormation($formation, $secretaire["ID"]);
              header("Location: ?accueil");
          }else{
            header("Location: ?ajoutSecretaireFormation&erreur=4");
          }
        }
        else{
          header("Location: ?ajoutSecretaireFormation&erreur=3");
        }
      }
      else{
        header("Location: ?ajoutSecretaireFormation&erreur=2");
      }
    }
    else{
      header("Location: ?ajoutProfesseurFormation&erreur=1");
    }
  }
  function calculerNombreHeuresParUE($idUE){
    // On récupère les voeux de l'utilisateur pour chaque module
    $nbHeures = 0;
    $modules = $this->daoUtilisateur->recupererModulesParUEID($idUE);

    foreach ($modules as $module) {
      $voeux = $this->daoUtilisateur->recupererVoeuxParModuleID($module["ID"]);
      // Pas optimal
      foreach ($voeux as $voeu) {
        if($voeu["Utilisateur_ID"] == $_SESSION["id_utilisateur"]){
          $nbHeures += $voeu["nbGroupesDS"]*$module["nbHeuresDS"]+$voeu["nbGroupesCM"]*$module["nbHeuresCM"]+$voeu["nbGroupesTP"]*$module["nbHeuresTP"]+$voeu["nbGroupesTD"]*$module["nbHeuresTD"];
        }
      }
    }
    return $nbHeures;
  }
  function modifierModule(){
    // On verifie si tous les champs sont bien remplis
    if(
      isset($_POST["ID"]) &&
      !empty($_POST["ID"]) &&
      isset($_POST["nom"]) &&
      !empty($_POST["nom"]) &&
      isset($_POST["UE_ID"]) &&
      !empty($_POST["UE_ID"]) &&
      isset($_POST["nbHeuresTD"]) &&
      !empty($_POST["nbHeuresTD"]) &&
      isset($_POST["nbHeuresTP"]) &&
      !empty($_POST["nbHeuresTP"]) &&
      isset($_POST["nbHeuresCM"]) &&
      !empty($_POST["nbHeuresCM"]) &&
      isset($_POST["nbHeuresDS"]) &&
      !empty($_POST["nbHeuresDS"]) &&
      isset($_POST["duree"]) &&
      !empty($_POST["duree"])
    ){
      // On traite tous les champs
      $idModule = htmlspecialchars($_POST["ID"]);
      $nomModule = htmlspecialchars($_POST["nom"]);
      $idUE = htmlspecialchars($_POST["UE_ID"]);
      $nbHeuresTD = htmlspecialchars($_POST["nbHeuresTD"]);
      $nbHeuresTP = htmlspecialchars($_POST["nbHeuresTP"]);
      $nbHeuresCM = htmlspecialchars($_POST["nbHeuresCM"]);
      $nbHeuresDS = htmlspecialchars($_POST["nbHeuresDS"]);
      $duree = htmlspecialchars($_POST['duree']);
      // Si le module existe
      if($this->daoUtilisateur->moduleExistant($idModule)){
        // On vérifie que l'utilisateur a les privilege sur la formation à laquelle il tente d'ajouter un module
        if(
          $this->daoUtilisateur->estAdminDeFormation($_SESSION["id_utilisateur"], $this->daoUtilisateur->recupererFormationParIDUE($idUE)["ID"]) ||
          $this->daoUtilisateur->estSecretaireDeFormation($_SESSION["id_utilisateur"], $this->daoUtilisateur->recupererFormationParIDUE($idUE)["ID"])
        ){
          $this->daoUtilisateur->modifierModule($idModule, $nomModule, $nbHeuresTD, $nbHeuresTP, $nbHeuresCM, $nbHeuresDS, $duree);
          header("Location: ?afficherModules");
        }else{
            header("Location: ?ajoutModule&erreur=3");
        }
      }else{
          header("Location: ?ajoutModule&erreur=2");
      }
    }else{
        header("Location: ?ajoutModule&erreur=1");
    }
  }

  function supprimerModule(){
    $moduleID = $_GET['moduleID'];
    // Si le module existe
    if($this->daoUtilisateur->moduleExistant($moduleID)){
      // On vérifie que l'utilisateur a les privilege sur la formation à laquelle il tente d'ajouter un module
      if(
        $this->daoUtilisateur->estAdminDeFormation($_SESSION["id_utilisateur"], $this->daoUtilisateur->recupererFormationParIDUE($_GET["UE_ID"])["ID"]) ||
        $this->daoUtilisateur->estSecretaireDeFormation($_SESSION["id_utilisateur"], $this->daoUtilisateur->recupererFormationParIDUE($_GET("UE_ID"))["ID"])
      ){
        $this->daoUtilisateur->supprimerModule($moduleID);
        header("Location: ?afficherModules");
      }else{
          header("Location: ?ajoutModule&erreur=2");
      }
    }else{
        header("Location: ?ajoutModule&erreur=1");
    }
  }

}

?>
