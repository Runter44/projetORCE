<?php
  /**
   *
   */

  require_once "password.php";
  require_once "DAO_config_file.php";

  class DAOInscription
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

    /**
     * @return void
     */
    public function deconnexion()
    {
      $this->connexion=null;
    }
 
    public function inscrireUtilisateur($formation, $mail, $hashed_mdp, $nom, $prenom, $type_utilisateur, $titre, $nbHeures){
      try{
        $requete = $this->connexion->prepare("INSERT INTO Utilisateur (ID, formation_ID, login, mdp, nom, prenom, type, titre, nbHeures) VALUES (UUID(), :formation_ID,:login,:mdp,:nom,:prenom, :type, :titre, :nbHeures);");
        $requete->execute(array(
		      "formation_ID"=>$formation,
                      "login"=>$mail,
                      "mdp"=>$hashed_mdp,
                      "nom"=>$nom,
                      "prenom"=>$prenom,
                      "type"=>$type_utilisateur,
                      "titre"=>$titre,
                      "nbHeures"=> $nbHeures));
        return true;
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    public function utilisateurExistant($mail){
      try{
        $requete = $this->connexion->prepare("SELECT * FROM Utilisateur where login=:login;");
        $requete->execute(array(
                        "login"=>$mail
        ));
        $tab = $requete->fetchAll(PDO::FETCH_ASSOC);
        return count($tab) <= 0;
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException($e->getMessage());
      }
    }

    public function getListeFormation(){
	try{
        $requete = $this->connexion->query("SELECT ID,nom FROM Formation;");
        return $requete->fetchAll();
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException($e->getMessage());
      }
    }

    public function getFormation($nom){
	try{
        $requete = $this->connexion->prepare("SELECT ID FROM Formation where nom=:nom;");
        $requete->execute(array(
                        "nom"=>$nom
        ));
	$formation = $requete->fetch();
	return $formation[0];
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException($e->getMessage());
      }
    }

    public function updateMotDePasse($IDUtilisateur, $hashed_pwd) {
      try {
        $requete = $this->connexion->prepare("UPDATE Utilisateur SET mdp=:mdp WHERE ID=:ID;");
        $requete->execute(array(
          "mdp" => $hashed_pwd,
          "ID" => $IDUtilisateur
        ));
      } catch(PDOException $e) {
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

  }
