<?php
  require_once "../Model/DAO/DAOUtilisateur.php";
  $daoUtilisateur = new DAOUtilisateur();

  if (isset($_POST["idformation"])) {
    $niveauxFormation = $daoUtilisateur->recupererNiveauxParIDFormation($_POST["idformation"]);

    if (isset($niveauxFormation[0]["ID"])) {
      $printMatieresFormation = "";
      if (isset($niveauxFormation[0]["ID"])) {
      foreach ($niveauxFormation as $nivForm) {

        $UENiveauForm = $daoUtilisateur->recupererUEsParNiveauID($nivForm["ID"]);

          $printMatieresFormation = $printMatieresFormation."<h2>".$nivForm["nom"]."</h2>";

        if (isset($UENiveauForm[0]["ID"])) {
        foreach ($UENiveauForm as $UENiv) {

          $ModulesUEForm = $daoUtilisateur->recupererModulesParUEID($UENiv["ID"]);

          $printMatieresFormation = $printMatieresFormation."<h3>".$UENiv["nom"]."</h3>";

          if (isset($ModulesUEForm[0]["ID"])) {
            foreach ($ModulesUEForm as $modForm) {
                $printMatieresFormation = $printMatieresFormation."<p>".$modForm["nom"]." (".$modForm["ID"].")</p>";
            }
          } else {
            $printMatieresFormation = $printMatieresFormation."<p>Aucun module à afficher pour cette UE.</p>";
          }
        }
      } else {
        $printMatieresFormation = $printMatieresFormation."<p>Aucun UE à afficher pour ce niveau.</p>";
      }
      }
    } else {
      $printMatieresFormation = "<p>Rien à afficher pour cette formation.</p><br>";
    }
    } else {
      $printMatieresFormation = "<p>Rien à afficher pour cette formation.</p><br>";
    }

    echo $printMatieresFormation;
  }
?>
