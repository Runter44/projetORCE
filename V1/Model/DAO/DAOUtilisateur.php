<?php
  /**
   *
   */
  require_once "DAO_config_file.php";
  class DAOUtilisateur
  {

    function __construct()
    {
      try{
        $this->connexion = new PDO('mysql:host=localhost;charset=UTF8;dbname=info2-2016-sidiserv-db','info2-2016-srv','sidisrv');  //on se connecte au sgbd
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);   //on active la gestion des erreurs et d'exceptions
      }catch(PDOException $e){
            throw new ConnexionException("Erreur de connexion");
      }
    }

    function getNom($IDUtilisateur) {
      try {
        $requete = $this->connexion->prepare("SELECT NOM FROM Utilisateur WHERE ID=:ID");
        $requete->execute(array(
          "ID" => $IDUtilisateur
        ));
        $user = $requete->fetch();
        return $user[0];
      } catch(PDOException $e) {
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function getPrenom($IDUtilisateur) {
      try {
        $requete = $this->connexion->prepare("SELECT PRENOM FROM Utilisateur WHERE ID=:ID");
        $requete->execute(array(
          "ID" => $IDUtilisateur
        ));
        $user = $requete->fetch();
        return $user[0];
      } catch(PDOException $e) {
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function getEmail($IDUtilisateur) {
      try {
        $requete = $this->connexion->prepare("SELECT LOGIN FROM Utilisateur WHERE ID=:ID");
        $requete->execute(array(
          "ID" => $IDUtilisateur
        ));
        $user = $requete->fetch();
        return $user[0];
      } catch(PDOException $e) {
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function updateNom($IDUtilisateur, $newNom) {
      try {
        $requete = $this->connexion->prepare("UPDATE Utilisateur SET nom=:NOM WHERE ID=:ID");
        $requete->execute(array(
          "NOM" => $newNom,
          "ID" => $IDUtilisateur
        ));
      } catch(PDOException $e) {
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function updatePrenom($IDUtilisateur, $newPrenom) {
      try {
        $requete = $this->connexion->prepare("UPDATE Utilisateur SET prenom=:PRENOM WHERE ID=:ID");
        $requete->execute(array(
          "PRENOM" => $newPrenom,
          "ID" => $IDUtilisateur
        ));
      } catch(PDOException $e) {
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function changerEmail($IDUtilisateur, $newEmail) {
      try {
        $requete = $this->connexion->prepare("UPDATE Utilisateur SET login=:LOGIN WHERE ID=:ID");
        $requete->execute(array(
          "LOGIN" => $newEmail,
          "ID" => $IDUtilisateur
        ));

      } catch(PDOException $e) {
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function ajouterFormation($nomFormation, $nbNiveaux) {
      try{
        $requete1 = $this->connexion->query("SELECT UUID()");
        $idTableau = $requete1->fetch();
        $IDFormation = $idTableau[0];
        $requete = $this->connexion->prepare("INSERT INTO Formation (ID, nom, nb_niveaux) VALUES (:ID, :nom, :nb_niveaux);");
        $requete->execute(array(
            "ID" => $IDFormation,
            "nom" => $nomFormation,
            "nb_niveaux" => $nbNiveaux
        ));
        return $IDFormation;
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException($e->getMessage());
      }
    }

    function getAllFormations() {
      try {
        $requete = $this->connexion->prepare("SELECT * FROM Formation;");
        $requete->execute();
        return $requete->fetchAll();
      } catch(PDOException $e) {
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function ajouterAdminAFormation($IDFormation, $IDUtilisateur){
      try{
        $requete = $this->connexion->prepare("INSERT INTO Utilisateur(Formation_ID, ID) VALUES (:Formation_ID, :Utilisateur_ID);");
        $requete->execute(array(
            "Formation_ID" => $IDFormation,
            "Utilisateur_ID" => $IDUtilisateur
        ));
      }
      catch(PDOException $e){
        throw new Exception($e->getMessage());
      }
    }

    function ajouterProfesseurAFormation($IDFormation, $IDUtilisateur){
      try{
        $requete = $this->connexion->prepare("INSERT INTO Utilisateur(Formation_ID, ID) VALUES (:Formation_ID, :Utilisateur_ID);");
        $requete->execute(array(
            "Formation_ID" => $IDFormation,
            "Utilisateur_ID" => $IDUtilisateur
        ));
      }
      catch(PDOException $e){
        throw new Exception($e->getMessage());
      }
    }

    function ajouterSecretaireAFormation($IDFormation, $IDUtilisateur){
      try{
        $requete = $this->connexion->prepare("INSERT INTO Utilisateur(Formation_ID, ID) VALUES (:Formation_ID, :Utilisateur_ID);");
        $requete->execute(array(
            "Formation_ID" => $IDFormation,
            "Utilisateur_ID" => $IDUtilisateur
        ));
      }
      catch(PDOException $e){
        throw new Exception($e->getMessage());
      }
    }

    function recupererTypeUtilisateur($IDUtilisateur){
      try{
        $requete = $this->connexion->prepare("SELECT * from Utilisateur WHERE ID=:ID");
        $requete->execute(array(
          "ID" => $IDUtilisateur
        ));
        $user = $requete->fetch(PDO::FETCH_ASSOC);
        return $user["type"];
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function recupererTitreUtilisateur($IDUtilisateur){
	try{
        $requete = $this->connexion->prepare("SELECT * from Utilisateur WHERE ID=:ID");
        $requete->execute(array(
          "ID" => $IDUtilisateur
        ));
        $user = $requete->fetch(PDO::FETCH_ASSOC);
        return $user["titre"];
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }
    function ajouterNiveau($nom, $numNiveau, $formID, $nbTD, $nbTP, $nbCM, $nbDS){
      try{
        $requete1 = $this->connexion->query("SELECT UUID()");
        $idTableau = $requete1->fetch();
        $IDNiveau = $idTableau[0];

        $requete = $this->connexion->prepare("INSERT INTO Niveau(ID, numNiveau, nom, Formation_ID, nbTD, nbCM, nbTP, nbDS) VALUES (:id, :numNiveau, :nom, :formID, :td, :cm, :tp, :ds)");
        $requete->execute(array(
          "id" => $IDNiveau,
          "numNiveau" => $numNiveau,
          "nom" => $nom,
          "formID" => $formID,
          "td" => $nbTD,
          "cm" => $nbCM,
          "tp" => $nbTP,
          "ds" => $nbDS
        ));
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function ajouterUE($nom, $niveauID){
      try{
        $requete1 = $this->connexion->query("SELECT UUID()");
        $idTableau = $requete1->fetch();
        $IDUE = $idTableau[0];

        $requete = $this->connexion->prepare("INSERT INTO UE(ID, nom, Niveau_ID) VALUES (:id, :nom, :Niveau_ID)");
        $requete->execute(array(
          "id" => $IDUE,
          "nom" => $nom,
          "Niveau_ID" => $niveauID
        ));
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    public function moduleExistant($idModule){
      try{
        $requete = $this->connexion->prepare("SELECT * FROM Module where ID=:id;");
        $requete->execute(array(
                        "id"=>$idModule
        ));
        $tab = $requete->fetch(PDO::FETCH_ASSOC);
        return count($tab) > 1;
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException($e->getMessage());
      }
    }

    function recupererFormationParIDUE($idUE){
      try{
        $requete = $this->connexion->prepare("SELECT * FROM Formation where ID=(SELECT Formation_ID FROM Niveau WHERE ID=(SELECT Niveau_ID FROM UE WHERE ID=:id))");
        $requete->execute(array(
                        "id"=>$idUE
        ));
        $tab = $requete->fetch(PDO::FETCH_ASSOC);
        // si a est vide, il renvoie false
        return $tab;
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException($e->getMessage());
      }
    }
    function ajouterModule($idModule, $nom, $UE_ID, $nbHeuresTD, $nbHeuresTP, $nbHeuresCM, $nbHeuresDS, $duree){
        try{
          $requete = $this->connexion->prepare("INSERT INTO Module(ID, nom, UE_ID, nbHeuresTD, nbHeuresTP, nbHeuresCM, nbHeuresDS, duree) VALUES (:ID, :nom, :UE_ID, :nbHeuresTD, :nbHeuresTP, :nbHeuresCM, :nbHeuresDS, :duree)");
          $requete->execute(array(
            "ID" => $idModule,
            "nom" => $nom,
            "UE_ID" => $UE_ID,
            "nbHeuresTD" => $nbHeuresTD,
            "nbHeuresTP" => $nbHeuresTP,
            "nbHeuresCM" => $nbHeuresCM,
            "nbHeuresDS" => $nbHeuresDS,
            "duree"      => $duree
          ));
        }
        catch(PDOException $e){
          $this->deconnexion();
          throw new Exception($e->getMessage());
        }
    }

    function ajouterVoeu($commentaire, $moduleID, $nbGroupesTP, $nbGroupesTD, $nbGroupesCM, $nbGroupesDS, $userID){
      try{
        $requete1 = $this->connexion->query("SELECT UUID()");
        $idTableau = $requete1->fetch();
        $IDVoeu = $idTableau[0];

        $requete = $this->connexion->prepare("INSERT INTO Voeu(ID, commentaire, Module_ID, nbGroupesTP, nbGroupesTD, nbGroupesCM, nbGroupesDS, ID) VALUES (:ID, :commentaire, :Module_ID, :nbGroupesTP, :nbGroupesTD, :nbGroupesCM, :nbGroupesDS, :Utilisateur_ID)");
        $requete->execute(array(
          "ID" => $IDVoeu,
          "commentaire" => $commentaire,
          "Module_ID" => $moduleID,
          "nbGroupesTP" => $nbGroupesTP,
          "nbGroupesTD" => $nbGroupesTD,
          "nbGroupesCM" => $nbGroupesCM,
          "nbGroupesDS" => $nbGroupesDS,
          "Utilisateur_ID" => $userID
        ));
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function recupererFormationsParIDAdministrateur($id){
      try{
        $requete = $this->connexion->prepare("SELECT Formation.ID, Formation.nom, Formation.nb_niveaux, Formation.date FROM Utilisateur, Formation WHERE Formation.ID = Utilisateur.Formation_ID AND Utilisateur.type=3 AND Utilisateur.ID = :userID;");
        $requete->execute(array(
          "userID" => $id
        ));
        return $requete->fetchAll();
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function recupererModuleParID($idModule){
      try{
        $requete = $this->connexion->prepare("SELECT * FROM Module WHERE ID=:idModule");
        $requete->execute(array(
          "idModule" => $idModule
        ));
        return $requete->fetch();
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

        function recupererFormationsParIDProfesseur($id){
          try{
            $requete = $this->connexion->prepare("SELECT Formation.ID, Formation.nom, Formation.nb_niveaux, Formation.date FROM Utilisateur, Formation WHERE Formation.ID = Utilisateur.formation_ID AND Utilisateur.titre = 'Enseignant' AND Utilisateur.ID = :userID");
            $requete->execute(array(
              "userID" => $id
            ));
            return $requete->fetchAll();
          }
          catch(PDOException $e){
            $this->deconnexion();
            throw new TableAccesException("Erreur de connexion");
          }
        }
    function recupererFormationsParIDSecretaire($id){
      try{
        $requete = $this->connexion->prepare("SELECT Formation.ID, Formation.nom, Formation.nb_niveaux, Formation.date FROM Utilisateur, Formation WHERE Formation.ID = Utilisateur.formation_ID AND Utilisateur.titre = 'Secretaire' AND Utilisateur.ID = :userID");
        $requete->execute(array(
          "userID" => $id
        ));
        return $requete->fetchAll();
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function recupererNiveauxParIDFormation($id){
      try{
        $requete = $this->connexion->prepare("SELECT * FROM Niveau WHERE Formation_ID = :id");
        $requete->execute(array(
          "id" => $id
        ));
        return $requete->fetchAll();
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function recupererNiveauParID($idNiveau){
      try{
        $requete = $this->connexion->prepare("SELECT * FROM Niveau WHERE ID = :id");
        $requete->execute(array(
          "id" => $idNiveau
        ));
        return $requete->fetchAll();
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function estAdminDeFormation($idUtilisateur, $idFormation){
      try{
        $requete = $this->connexion->prepare("SELECT * FROM Utilisateur WHERE Formation_ID = :formation_id AND ID = :utilisateur_ID AND type = 3;");
        $requete->execute(array(
          "formation_id" => $idFormation,
          "utilisateur_ID" => $idUtilisateur
        ));
        return count($requete->fetch()) >0;
      }
      catch(PDOException $e){
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function recupererUEsParNiveauID($niveauID){
      try{
        $requete = $this->connexion->prepare("SELECT * FROM UE WHERE Niveau_ID = :Niveau_ID;");
        $requete->execute(array(
          "Niveau_ID" => $niveauID
        ));
        return $requete->fetchAll();
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }
    function recupererModulesParUEID($UEID){
      try{
        $requete = $this->connexion->prepare("SELECT * FROM Module WHERE UE_ID = :UE_ID");
        $requete->execute(array(
          "UE_ID" => $UEID
        ));
        return $requete->fetchAll();
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function estProfDansUneFormation($idUtilisateur) {
      try {
        $requete = $this->connexion->prepare("SELECT * FROM Utilisateur WHERE ID=:UserID AND titre = 'Enseignant';");
        $requete->execute(array(
          "UserID" => $idUtilisateur
        ));
        $result = $requete->fetch();
        if ($result["ID"] != null) {
          return true;
        } else {
          return false;
        }

      } catch (Exception $e) {
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function estSecretaireDansUneFormation($idUtilisateur) {
      try {
        $requete = $this->connexion->prepare("SELECT * FROM Utilisateur WHERE ID=:UserID AND titre = 'Secretaire';");
        $requete->execute(array(
          "UserID" => $idUtilisateur
        ));
        $result = $requete->fetch();
        if ($result["ID"] != null) {
          return true;
        } else {
          return false;
        }

      } catch (Exception $e) {
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function estProfesseurDeFormation($idUtilisateur, $idFormation){
      try{
        $requete = $this->connexion->prepare("SELECT * FROM Utilisateur WHERE Formation_ID = :formation_id AND ID = :utilisateur_ID AND titre = 'Enseignant';");
        $requete->execute(array(
          "formation_id" => $idFormation,
          "utilisateur_ID" => $idUtilisateur
        ));
        return $requete->fetch();
      }
      catch(PDOException $e){
        throw new TableAccesException("Erreur de connexion");
      }
    }
    function estSecretaireDeFormation($idUtilisateur, $idFormation){
      try{
        $requete = $this->connexion->prepare("SELECT * FROM Utilisateur WHERE Formation_ID = :formation_id AND ID = :utilisateur_ID AND titre = 'Secretaire';");
        $requete->execute(array(
          "formation_id" => $idFormation,
          "utilisateur_ID" => $idUtilisateur
        ));
        return $requete->fetch();
      }
      catch(PDOException $e){
        throw new TableAccesException("Erreur de connexion");
      }
    }


    function recupererVoeuxParModuleID($idModule){
      try{
        $requete = $this->connexion->prepare("SELECT * FROM Voeu WHERE Module_ID = :Module_ID");
        $requete->execute(array(
          "Module_ID" => $idModule
        ));
        return $requete->fetchAll();
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function recupererVoeuxParUtilisateurID($idUtilisateur){
      try{
        $requete = $this->connexion->prepare("SELECT * FROM Voeu WHERE ID=:UserID");
        $requete->execute(array(
          "UserID" => $idUtilisateur
        ));
        return $requete->fetchAll();
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function recupererAllVoeuxUtilisateur($idUtilisateur) {
      try {
        $requete = $this->connexion->prepare("SELECT Module.nom, Voeu.Module_ID, Voeu.nbGroupesDS, Voeu.nbGroupesCM, Voeu.nbGroupesTD, Voeu.nbGroupesTP, Module.duree, Module.nbHeuresTD, Module.nbHeuresTP, Module.nbHeuresCM, Module.nbHeuresDS  FROM `Voeu`, Module WHERE Module.ID=Voeu.Module_ID AND Voeu.Utilisateur_ID=:UserID");
        $requete->execute(array(
          "UserID" => $idUtilisateur
        ));
        return $requete->fetchAll();
      } catch (Exception $e) {
        throw new Exception("Error Processing Request");
      }
    }

    function supprimerVoeuxSansHeures() {
      try {
        $requete = $this->connexion->prepare("DELETE FROM Voeu WHERE nbGroupesTD=0 AND nbGroupesTP=0 AND nbGroupesCM=0 AND nbGroupesDS=0");
        $requete->execute();
      } catch (Exception $e) {
        throw new Exception("Error Processing Request");
      }

    }

    function recupererUtilisateur($idUtilisateur){
      try{
        $requete = $this->connexion->prepare("SELECT * FROM Utilisateur WHERE ID = :ID");
        $requete->execute(array(
          "ID" => $idUtilisateur
        ));
        return $requete->fetch();
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function modifierVoeu($commentaire, $moduleID, $nbTP, $nbTD, $nbCM, $nbDS, $userID){
      try{
        $requete = $this->connexion->prepare("UPDATE Voeu SET commentaire = :commentaire, nbGroupesTD = :nbTD, nbGroupesTP = :nbTP, nbGroupesCM = :nbCM, nbGroupesDS = :nbDS WHERE Module_ID = :moduleID AND ID = :userID;");
        $requete->execute(array(
          "commentaire" => $commentaire,
          "moduleID" => $moduleID,
          "nbTP" => $nbTP,
          "nbTD" => $nbTD,
          "nbCM" => $nbCM,
          "nbDS" => $nbDS,
          "userID" => $userID
        ));
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new Exception($e->getMessage());
      }
    }

    function supprimerVoeu($voeuID){
      try{
        $requete = $this->connexion->prepare("DELETE FROM Voeu WHERE ID = :voeuID");
        $requete->execute(array(
          "voeuID" => $voeuID
        ));
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function supprimerModule($moduleID){
        try{
          $voeux = $this->recupererVoeuxParModuleID($moduleID);
          foreach ($voeux as $voeu) {
            $this->supprimerVoeu($voeu['ID']);
          }
          $requete = $this->connexion->prepare("DELETE FROM Module WHERE ID = :moduleID");
          $requete->execute(array(
            "moduleID" => $moduleID
          ));
        }
        catch(PDOException $e){
          //$this->deconnexion();
          throw new Exception($e->getMessage());
        }
    }

    function supprimerUE($ueID){
        try{
          $modules = $this->recupererModulesParUEID($ueID);
          foreach ($modules as $module) {
            $this->supprimerModule($module['ID']);
          }
          $requete2 = $this->connexion->prepare("DELETE FROM UE WHERE ID = :ueID");
          $requete->execute(array(
            "ueID" => $ueID
          ));
        }
        catch(PDOException $e){
          $this->deconnexion();
          throw new TableAccesException("Erreur de connexion");
        }
    }

    function supprimerNiveau($niveauID){
      try{
        $ues = $this->recupererUEsParNiveauID($niveauID);
        foreach ($ues as $ue) {
          $this->supprimerUE($ue['ID']);
        }
        $requete2 = $this->connexion->prepare("DELETE FROM Niveau WHERE ID = :niveauID");
        $requete2->execute(array(
          "niveauID" => $niveauID
        ));
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function supprimerFormation($formationID){
      try{
        $niveaux = recupererNiveauxParIDFormation($formationID);
        foreach ($niveaux as $niveau) {
          $this->supprimerNiveau($niveau['ID']);
        }
        $requete2 = $this->connexion->prepare("DELETE FROM Formation WHERE ID = :formationID");
        $requete2->execute(array(
          "formationID" => $formationID
        ));
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function recupererNbHeuresEnseignees($userID){
      try{
        $requete = $this->connexion->prepare("SELECT nbGroupesTD, nbGroupesTP, nbGroupesCM, nbGroupesDS, nbHeuresTD, nbHeuresTP, nbHeuresCM, nbHeuresDS FROM Enseignement, Module WHERE Enseignement.ID = :userID AND Module_ID = Module.ID");
        $requete->execute(array(
          "userID" => $userID
        ));
        $nbHeures = 0;
        $tabHeures = $requete->fetchAll();
        foreach ($tabHeures as $tab) {
          $nbHeures += $tab['nbGroupesTD'] * $tab['nbHeuresTD'] + $tab['nbGroupesTP'] * $tab['nbHeuresTP'] + $tab['nbGroupesCM'] * $tab['nbHeuresCM'] +$tab['nbGroupesDS'] * $tab['nbHeuresDS'];
        }
        return $nbHeures;
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function recupererNbHeuresVoeux($userID){
      try{
        $requete = $this->connexion->prepare("SELECT nbGroupesTD, nbGroupesTP, nbGroupesCM, nbGroupesDS, nbHeuresTD, nbHeuresTP, nbHeuresCM, nbHeuresDS FROM Voeu, Module WHERE Voeu.ID = :userID AND Module_ID = Module.ID");
        $requete->execute(array(
          "userID" => $userID
        ));
        $nbHeures = 0;
        $tabHeures = $requete->fetchAll();
        foreach ($tabHeures as $tab) {
          $nbHeures += $tab['nbGroupesTD'] * $tab['nbHeuresTD'] + $tab['nbGroupesTP'] * $tab['nbHeuresTP'] + $tab['nbGroupesCM'] * $tab['nbHeuresCM'] +$tab['nbGroupesDS'] * $tab['nbHeuresDS'];
        }
        return $nbHeures;
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function recupererNbPtVoeux($userID){
      try{
        $requete = $this->connexion->prepare("SELECT nbGroupesTD, nbGroupesTP, nbGroupesCM, nbGroupesDS, nbHeuresTD, nbHeuresTP, nbHeuresCM, nbHeuresDS FROM Voeu, Module WHERE Voeu.ID = :userID AND Module_ID = Module.ID");
        $requete->execute(array(
          "userID" => $userID
        ));
        $nbHeures = 0;
        $tabHeures = $requete->fetchAll();
        foreach ($tabHeures as $tab) {
          $nbHeures += $tab['nbGroupesTD'] * $tab['nbHeuresTD']*1 + $tab['nbGroupesTP'] * $tab['nbHeuresTP']*(0.6) + $tab['nbGroupesCM'] * $tab['nbHeuresCM']*1.5 +$tab['nbGroupesDS'] * $tab['nbHeuresDS']*1;
        }
        return $nbHeures;
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function voeuExistant($voeuID){
      try{
        $requete = $this->connexion->prepare("SELECT * FROM Voeu WHERE ID = :voeuID;");
        $requete->execute(array(
          "voeuID" => $voeuID
        ));
        $res = $requete->fetchAll();
        return count($res) > 0;
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function recupererVoeuParID($voeuID){
      try{
        $requete = $this->connexion->prepare("SELECT * FROM Voeu WHERE ID = :voeuID;");
        $requete->execute(array(
          "voeuID" => $voeuID
        ));
        $res = $requete->fetch();
        return $res;
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

        function recupererAdminParFormationID($formationID){
          try{
            $requete = $this->connexion->prepare("SELECT * FROM  Utilisateur WHERE Utilisateur.type = 3 AND Utilisateur.formation_ID = :formationID;");
            $requete->execute(array(
              "formationID" => $formationID
            ));
            return $requete->fetchAll();
          }
          catch(PDOException $e){
            $this->deconnexion();
            throw new TableAccesException("Erreur de connexion");
          }
        }

    function recupererSuperAdminParFormationID($formationID){
          try{
            $requete = $this->connexion->prepare("SELECT * FROM  Utilisateur WHERE Utilisateur.type = 4 AND Utilisateur.formation_ID = :formationID;");
            $requete->execute(array(
              "formationID" => $formationID
            ));
            return $requete->fetchAll();
          }
          catch(PDOException $e){
            $this->deconnexion();
            throw new TableAccesException("Erreur de connexion");
          }
    }

    function recupererProfsParFormationID($formationID){
      try{
        $requete = $this->connexion->prepare("SELECT * FROM Utilisateur WHERE Utilisateur.Formation_ID = :formationID AND Utilisateur.type = 0;");
        $requete->execute(array(
          "formationID" => $formationID
        ));
        return $requete->fetchAll();
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function recupererSecretairesParFormationID($formationID){
      try{
        $requete = $this->connexion->prepare("SELECT * FROM Utilisateur WHERE Utilisateur.Formation_ID = :formationID AND Utilisateur.titre = 'Enseignant';");
        $requete->execute(array(
          "formationID" => $formationID
        ));
        return $requete->fetchAll();
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function recupererVacatairesParFormationID($formationID){
      try{
        $requete = $this->connexion->prepare("SELECT * FROM Utilisateur WHERE Utilisateur.Formation_ID = :formationID AND Utilisateur.titre = 'Vacataire';");
        $requete->execute(array(
          "formationID" => $formationID
        ));
        return $requete->fetchAll();
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    function modifierModule($idModule, $nomModule, $nbHeuresTD, $nbHeuresTP, $nbHeuresCM, $nbHeuresDS, $duree){
      try{
        $requete = $this->connexion->prepare("UPDATE Module SET nom = :nomModule, nbHeuresTD = :nbTD, nbHeuresTP = :nbTP, nbHeuresCM = :nbCM, nbHeuresDS = :nbDS, duree = :duree WHERE ID = :moduleID;");
        $requete->execute(array(
          "nomModule" => $nomModule,
          "nbTD" => $nbHeuresTD,
          "nbTP" => $nbHeuresTP,
          "nbCM" => $nbHeuresCM,
          "nbDS" => $nbHeuresDS,
          "duree" => $duree,
          "moduleID" => $idModule
        ));
      }
      catch(PDOException $e){
        //$this->deconnexion();
        throw new Exception($e->getMessage());
      }
    }

    function retirerProfDeFormation($idUtilisateur, $idFormation){
        try{
          $requete = $this->connexion->prepare("DELETE FROM Utilisateur WHERE Formation_ID = :formID AND ID=:userID");
          $requete->execute(array(
            "formID" => $idFormation,
            "userID" => $idUtilisateur
          ));
        }
        catch(PDOException $e){
          //$this->deconnexion();
          throw new Exception($e->getMessage());
        }
    }

    function retirerAdministrateurDeFormation($idUtilisateur, $idFormation){
        try{
          $requete = $this->connexion->prepare("DELETE FROM Utilisateur WHERE Formation_ID = :formID AND ID=:userID");
          $requete->execute(array(
            "formID" => $idFormation,
            "userID" => $idUtilisateur
          ));
        }
        catch(PDOException $e){
          //$this->deconnexion();
          throw new Exception($e->getMessage());
        }
    }
    function retirerSecretaireDeFormation($idUtilisateur, $idFormation){
        try{
          $requete = $this->connexion->prepare("DELETE FROM Utilisateur WHERE Formation_ID = :formID AND ID=:userID");
          $requete->execute(array(
            "formID" => $idFormation,
            "userID" => $idUtilisateur
          ));
        }
        catch(PDOException $e){
          //$this->deconnexion();
          throw new Exception($e->getMessage());
        }
    }

  }
 ?>
