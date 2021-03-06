<?php
  require_once 'Model/fpdf181/fpdf.php';
  $pdf = new FPDF();
  $pdf->AddPage();
  $pdf->SetFont('Arial','B',16);
  $phrase1 = 'Résumé des enseignements de '.$_SESSION["prenom"].' '.$_SESSION["nom"].'.';
  $pdf->Write(5, utf8_decode($phrase1));
  $pdf->SetFont('Arial','',13);
  $phrase2 = 'Vous enseignez actuellement '.$nbHeuresTotal.'h avec tous vos voeux, soit environ '.round($nbHeuresTotal/24, 2).'h par semaine.';
  $pdf->Write(5, utf8_decode("\n\n\n"));
  $pdf->Write(5, utf8_decode($phrase2));
  $pdf->SetFont('Arial','',11);
  $i = 1;
  $pdf->Write(5, utf8_decode("\n"));
  foreach ($voeuxUtilisateur as $voeu) {
    $dateDebut = new DateTime($voeu["date_debut"]);
    $dateFin = new DateTime($voeu["date_fin"]);
    $intervalle = $dateDebut->diff($dateFin);
    $nbSemaines = round($intervalle->format("%a")/7);
    $totalHeures = $voeu["nbGroupesDS"]*$voeu["nbHeuresDS"]+$voeu["nbGroupesCM"]*$voeu["nbHeuresCM"]+$voeu["nbGroupesTD"]*$voeu["nbHeuresTD"]+$voeu["nbGroupesTP"]*$voeu["nbHeuresTP"];
    $heuresSemaine = round($totalHeures/$nbSemaines, 2);

    $pdf->SetFont('Arial','B',11);
    $phrase3 = 'Voeu n°'.$i.' : '.$voeu["nom"]." (".$voeu["Module_ID"].") : ".$totalHeures."h (".$heuresSemaine."h par semaine)";
    $pdf->Write(5, utf8_decode("\n\n"));
    $pdf->Write(5, utf8_decode($phrase3));
    $pdf->Write(5, utf8_decode("\n\n"));
    $pdf->SetFont('Arial','',11);
    if ($voeu["nbGroupesDS"] > 0) {
      $phrase4 = '   - '.$voeu["nbGroupesDS"].' groupes de DS ayant '.$voeu["nbHeuresDS"].'h de cours, soit '.round($voeu["nbGroupesDS"]*$voeu["nbHeuresDS"]).'h au total.';
      $pdf->Write(5, utf8_decode($phrase4));
      $pdf->Write(5, utf8_decode("\n"));
    }
    if ($voeu["nbGroupesCM"] > 0) {
      $phrase4 = '   - '.$voeu["nbGroupesCM"].' groupes de CM ayant '.$voeu["nbHeuresCM"].'h de cours, soit '.round($voeu["nbGroupesCM"]*$voeu["nbHeuresCM"]).'h au total.';
      $pdf->Write(5, utf8_decode($phrase4));
      $pdf->Write(5, utf8_decode("\n"));
    }
    if ($voeu["nbGroupesTD"] > 0) {
      $phrase4 = '   - '.$voeu["nbGroupesTD"].' groupes de TD ayant '.$voeu["nbHeuresTD"].'h de cours, soit '.round($voeu["nbGroupesTD"]*$voeu["nbHeuresTD"]).'h au total.';
      $pdf->Write(5, utf8_decode($phrase4));
      $pdf->Write(5, utf8_decode("\n"));
    }
    if ($voeu["nbGroupesTP"] > 0) {
      $phrase4 = '   - '.$voeu["nbGroupesTP"].' groupes de TP ayant '.$voeu["nbHeuresTP"].'h de cours, soit '.round($voeu["nbGroupesTP"]*$voeu["nbHeuresTP"]).'h au total.';
      $pdf->Write(5, utf8_decode($phrase4));
      $pdf->Write(5, utf8_decode("\n"));
    }
    $i++;
  }
  $pdf->SetTitle(utf8_decode('Résumé des enseignements de '.$_SESSION["prenom"].' '.$_SESSION["nom"]));
  $pdf->Output('D', 'enseignements.pdf');
 ?>
