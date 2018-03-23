<?php
// Ce script sert a générer le pdf de la page de récapitulatif des heures effectuées, par professeurs,
// sur leurs différents modules
  require_once 'Model/fpdf181/fpdf.php';

  $pdf = new FPDF();
  $pdf->AddPage();

  $pdf->SetFont('Arial','B',16);
  $phrase1 = 'Résumé des enseignements de '.$_SESSION["prenom"].' '.$_SESSION["nom"].'.';
  $pdf->Write(5, utf8_decode($phrase1));
  $pdf->SetFont('Arial','',13);
  $phrase2 = 'Vous enseignez actuellement '.$nbHeuresTotal.'h avec tous vos voeux, soit environ '.round($nbHeuresTotal/24, 2).'h par semaine.';
  $pdf->Write(5, utf8_decode("\n\n"));
  $pdf->Write(5, utf8_decode($phrase2));
  $pdf->SetFont('Arial','',11);
  $i = 1;
  $pdf->Write(5, utf8_decode("\n\n"));

  /*TABLEAUX PAR PERIODE*/
  /*PERIODE 1*/
  $pdf->SetFont('Arial','B',18);
  $pdf->Write(5, utf8_decode("Voeux de la période n°1 :\n\n"));
  $i = 0;
  foreach ($voeuxUtilisateur as $voeu) {
    if ($voeu["periode"] == 1) {
      $pdf->SetFont('Arial','B',16);
      $pdf->Write(5,utf8_decode($voeu["nom"]." (".$voeu["Module_ID"].")\n\n"));
      $pdf->SetFont('Arial','',12);
      /*Tableau de voeux*/
      /*Ligne en tete*/
      $pdf->Cell(60,6,"",0,0,'R');
      $pdf->Cell(10,6,"DS",0,0,'C');
      $pdf->Cell(10,6,"CM",0,0,'C');
      $pdf->Cell(10,6,"TD",0,0,'C');
      $pdf->Cell(10,6,"TP",0,1,'C');
      /*Ligne groupes*/
      $pdf->Cell(60,6,"Nombre de groupes",0,0,'R');
      $pdf->Cell(10,6,$voeu["nbGroupesDS"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbGroupesCM"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbGroupesTD"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbGroupesTP"],0,1,'C');
      /*Ligne heures par groupe*/
      $pdf->Cell(60,6,"Nombre d'heures par groupe",0,0,'R');
      $pdf->Cell(10,6,$voeu["nbHeuresDS"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbHeuresCM"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbHeuresTD"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbHeuresTP"],0,1,'C');
      /*Ligne total*/
      $pdf->Cell(60,6,"Total d'heures",0,0,'R');
      $pdf->Cell(10,6,round($voeu["nbGroupesDS"]*$voeu["nbHeuresDS"]),0,0,'C');
      $pdf->Cell(10,6,round($voeu["nbGroupesCM"]*$voeu["nbHeuresCM"]),0,0,'C');
      $pdf->Cell(10,6,round($voeu["nbGroupesTD"]*$voeu["nbHeuresTD"]),0,0,'C');
      $pdf->Cell(10,6,round($voeu["nbGroupesTP"]*$voeu["nbHeuresTP"]),0,1,'C');
      $pdf->Write(5,utf8_decode("\n\n"));
      $i++;
    }
  }
  /*S'il n'y pas de voeux, message d'erreur*/
  if ($i == 0) {
    $pdf->SetFont('Arial','I',12);
    $pdf->Write(5, utf8_decode("Aucun voeu pour cette période !\n\n"));
  }


  /*PERIODE 2*/
  $pdf->SetFont('Arial','B',18);
  $pdf->Write(5, utf8_decode("Voeux de la période n°2 :\n\n"));
  $i = 0;
  foreach ($voeuxUtilisateur as $voeu) {
    if ($voeu["periode"] == 2) {
      $pdf->SetFont('Arial','B',16);
      $pdf->Write(5,utf8_decode($voeu["nom"]." (".$voeu["Module_ID"].")\n\n"));
      $pdf->SetFont('Arial','',12);
      /*Tableau de voeux*/
      /*Ligne en tete*/
      $pdf->Cell(60,6,"",0,0,'R');
      $pdf->Cell(10,6,"DS",0,0,'C');
      $pdf->Cell(10,6,"CM",0,0,'C');
      $pdf->Cell(10,6,"TD",0,0,'C');
      $pdf->Cell(10,6,"TP",0,1,'C');
      /*Ligne groupes*/
      $pdf->Cell(60,6,"Nombre de groupes",0,0,'R');
      $pdf->Cell(10,6,$voeu["nbGroupesDS"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbGroupesCM"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbGroupesTD"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbGroupesTP"],0,1,'C');
      /*Ligne heures par groupe*/
      $pdf->Cell(60,6,"Nombre d'heures par groupe",0,0,'R');
      $pdf->Cell(10,6,$voeu["nbHeuresDS"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbHeuresCM"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbHeuresTD"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbHeuresTP"],0,1,'C');
      /*Ligne total*/
      $pdf->Cell(60,6,"Total d'heures",0,0,'R');
      $pdf->Cell(10,6,round($voeu["nbGroupesDS"]*$voeu["nbHeuresDS"]),0,0,'C');
      $pdf->Cell(10,6,round($voeu["nbGroupesCM"]*$voeu["nbHeuresCM"]),0,0,'C');
      $pdf->Cell(10,6,round($voeu["nbGroupesTD"]*$voeu["nbHeuresTD"]),0,0,'C');
      $pdf->Cell(10,6,round($voeu["nbGroupesTP"]*$voeu["nbHeuresTP"]),0,1,'C');
      $pdf->Write(5,utf8_decode("\n\n"));
      $i++;
    }
  }
  /*S'il n'y pas de voeux, message d'erreur*/
  if ($i == 0) {
    $pdf->SetFont('Arial','I',12);
    $pdf->Write(5, utf8_decode("Aucun voeu pour cette période !\n\n"));
  }


  /*PERIODE 3*/
  $pdf->SetFont('Arial','B',18);
  $pdf->Write(5, utf8_decode("Voeux de la période n°3 :\n\n"));
  $i = 0;
  foreach ($voeuxUtilisateur as $voeu) {
    if ($voeu["periode"] == 3) {
      $pdf->SetFont('Arial','B',16);
      $pdf->Write(5,utf8_decode($voeu["nom"]." (".$voeu["Module_ID"].")\n\n"));
      $pdf->SetFont('Arial','',12);
      /*Tableau de voeux*/
      /*Ligne en tete*/
      $pdf->Cell(60,6,"",0,0,'R');
      $pdf->Cell(10,6,"DS",0,0,'C');
      $pdf->Cell(10,6,"CM",0,0,'C');
      $pdf->Cell(10,6,"TD",0,0,'C');
      $pdf->Cell(10,6,"TP",0,1,'C');
      /*Ligne groupes*/
      $pdf->Cell(60,6,"Nombre de groupes",0,0,'R');
      $pdf->Cell(10,6,$voeu["nbGroupesDS"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbGroupesCM"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbGroupesTD"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbGroupesTP"],0,1,'C');
      /*Ligne heures par groupe*/
      $pdf->Cell(60,6,"Nombre d'heures par groupe",0,0,'R');
      $pdf->Cell(10,6,$voeu["nbHeuresDS"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbHeuresCM"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbHeuresTD"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbHeuresTP"],0,1,'C');
      /*Ligne total*/
      $pdf->Cell(60,6,"Total d'heures",0,0,'R');
      $pdf->Cell(10,6,round($voeu["nbGroupesDS"]*$voeu["nbHeuresDS"]),0,0,'C');
      $pdf->Cell(10,6,round($voeu["nbGroupesCM"]*$voeu["nbHeuresCM"]),0,0,'C');
      $pdf->Cell(10,6,round($voeu["nbGroupesTD"]*$voeu["nbHeuresTD"]),0,0,'C');
      $pdf->Cell(10,6,round($voeu["nbGroupesTP"]*$voeu["nbHeuresTP"]),0,1,'C');
      $pdf->Write(5,utf8_decode("\n\n"));
      $i++;
    }
  }
  /*S'il n'y pas de voeux, message d'erreur*/
  if ($i == 0) {
    $pdf->SetFont('Arial','I',12);
    $pdf->Write(5, utf8_decode("Aucun voeu pour cette période !\n\n"));
  }

  /*PERIODE 4*/
  $pdf->SetFont('Arial','B',18);
  $pdf->Write(5, utf8_decode("Voeux de la période n°4 :\n\n"));
  $i = 0;
  foreach ($voeuxUtilisateur as $voeu) {
    if ($voeu["periode"] == 4) {
      $pdf->SetFont('Arial','B',16);
      $pdf->Write(5,utf8_decode($voeu["nom"]." (".$voeu["Module_ID"].")\n\n"));
      $pdf->SetFont('Arial','',12);
      /*Tableau de voeux*/
      /*Ligne en tete*/
      $pdf->Cell(60,6,"",0,0,'R');
      $pdf->Cell(10,6,"DS",0,0,'C');
      $pdf->Cell(10,6,"CM",0,0,'C');
      $pdf->Cell(10,6,"TD",0,0,'C');
      $pdf->Cell(10,6,"TP",0,1,'C');
      /*Ligne groupes*/
      $pdf->Cell(60,6,"Nombre de groupes",0,0,'R');
      $pdf->Cell(10,6,$voeu["nbGroupesDS"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbGroupesCM"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbGroupesTD"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbGroupesTP"],0,1,'C');
      /*Ligne heures par groupe*/
      $pdf->Cell(60,6,"Nombre d'heures par groupe",0,0,'R');
      $pdf->Cell(10,6,$voeu["nbHeuresDS"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbHeuresCM"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbHeuresTD"],0,0,'C');
      $pdf->Cell(10,6,$voeu["nbHeuresTP"],0,1,'C');
      /*Ligne total*/
      $pdf->Cell(60,6,"Total d'heures",0,0,'R');
      $pdf->Cell(10,6,round($voeu["nbGroupesDS"]*$voeu["nbHeuresDS"]),0,0,'C');
      $pdf->Cell(10,6,round($voeu["nbGroupesCM"]*$voeu["nbHeuresCM"]),0,0,'C');
      $pdf->Cell(10,6,round($voeu["nbGroupesTD"]*$voeu["nbHeuresTD"]),0,0,'C');
      $pdf->Cell(10,6,round($voeu["nbGroupesTP"]*$voeu["nbHeuresTP"]),0,1,'C');
      $pdf->Write(5,utf8_decode("\n\n"));
      $i++;
    }
  }
  /*S'il n'y pas de voeux, message d'erreur*/
  if ($i == 0) {
    $pdf->SetFont('Arial','I',12);
    $pdf->Write(5, utf8_decode("Aucun voeu pour cette période !\n\n"));
  }

  // Positionnement à 1,5 cm du bas
//  $pdf->SetY(10);
  // Police Arial italique 8
  $pdf->SetFont('Arial','I',8);
  // Numéro de page
  $today = date("d/m/Y à H:i:s");
  $pdf->Cell(0,10,utf8_decode("Page ".$pdf->PageNo()." - Le ".$today),0,1,'C');

  $pdf->SetTitle(utf8_decode('Résumé des enseignements de '.$_SESSION["prenom"].' '.$_SESSION["nom"]));



  $pdf->Output('D', 'resume-enseignements.pdf');?>
