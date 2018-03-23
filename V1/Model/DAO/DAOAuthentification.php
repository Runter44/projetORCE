<?php
  /**
   *
   */

   require_once "password.php";
   require_once "DAO_config_file.php";
  class DAOAuthentification
  {

    function __construct()
    {
      try{
        $this->connexion = new PDO('mysql:host=localhost;charset=UTF8;dbname=info2-2016-sidiserv-db','info2-2016-srv','sidisrv');  //on se connecte au sgbd
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);   //on active la gestion des erreurs et d'exceptions
      }catch(PDOException $e){
            throw new Exception($e->getMessage());
      }
    }

    /**
     * @return void
     */
    public function deconnexion()
    {
      $this->connexion=null;
    }


    public function verifierIdentifiants($mdp, $pseudo){
      try{
        $requete = $this->connexion->prepare("SELECT * from Utilisateur WHERE login=:login");
        $requete->execute(array(
          "login" => $pseudo
        ));
        $user = $requete->fetch(PDO::FETCH_ASSOC);
        return password_verify($mdp, $user["mdp"]);
      }
      catch(PDOException $e){
        $this->deconnexion();
        throw new TableAccesException("Erreur de connexion");
      }
    }

    public function recupererIDParPseudoUtilisateur($pseudo){
      try{
        $requete = $this->connexion->prepare("SELECT * from Utilisateur where login=:pseudo");
        $requete->execute(array(
          "pseudo" => $pseudo
        ));

        $user = $requete->fetch(PDO::FETCH_ASSOC);
        return $user["ID"];
      }
      catch(PDOException $e){
        throw new Exception($e->getMessage());
      }
    }



  }

 ?>
