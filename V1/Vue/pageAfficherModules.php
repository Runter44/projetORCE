<!Doctype html>
<html>
	<head>
		<title>Orce.</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" type="text/css" href="Vue/style/global.css">
		<link rel="stylesheet" type="text/css" href="Vue/style/pageAfficherModules.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  	<script src="Vue/script/sorttable.js"></script>
		<meta charset="UTF-8">
	</head>
	<body>
		<div id="top-nav">
			<a href="?accueil" style="outline: none;"><h1>Orce.</h1></a>
			<div id="menu"><ul id="menupart1"><li><a href="home.php" id="sel"><li><a href="?accueil"><div class="text">Tous les enseignements</div><div class="under"></div></a>
					</li>
				</ul>
			</div>
			<p id="compteinfos"><?php
			if (isset($_SESSION["prenom"]) && isset($_SESSION["nom"])) {
				echo "Bienvenue, <br>".$_SESSION["prenom"]." ".$_SESSION["nom"];
				foreach ($formations as $formation) {
					if($formation["estSuperAdmin"]){
						echo "<br/>Super Administrateur";
					}else if($formation["estAdmin"]){
						echo "<br/>Administrateur";
					}
				}
			}
			?><div id="plus">+</div></p>
			<ul class="menuderoulant">
				<a href="?parametres"><li>Paramètres du compte</li></a><a href="?resumeEnseignements"><li>Enseignements</li></a><?php foreach($formations as $formation){if($formation["estAdmin"]){echo '<a href="?pannelAdministrateur"><li>Pannel Administrateur</li></a>';}}?><a href="?deconnexion"><li id="deco">Déconnexion</li></a>
			</ul>

			<?php echo  "<div id='heures'>".$mesHeuresSouhaitees."h | ".$mesPointsSouhaites."pt</div>"; ?>
		</div>
		<div id="container" class="container">
			<?php
				
				if(count($formations) > 0){
					foreach ($formations as $formation) {
						echo  "<h1>".$formation["nom"]."</h1>";
						if($formation["estAdmin"] || $formation["estSecretaire"]){
							?>
							<div class="formation-container">
							<div class="afficherReglages"><button>Réglages</buton></div>
							<div class="reglages">
							<span>
								<button type="button" class="boutonAjouter">Ajouter un enseignant</button>
								<div class="fenetreModale">
									<div class="fenetre-header">
										Ajouter un enseignant<a class="close"><svg aria-label="Close" class="octicon octicon-x js-menu-close" height="16" role="img" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48z"></path></svg></a>
									</div>
									<div class="fenetre-body">
										<form action = "index.php?ajoutProfesseurFormationSub" method="post">
								      <input type="text" name="professeur" placeholder="prenom.nom@email.fr"><br/><br/>
								      <input type="hidden" name="formation" value="<?php echo htmlspecialchars($formation["ID"]);?>">

										<button type="submit">Ajouter l'enseignant</button>
									</form>
									</div>
								</div>
								<div class="derriereFenetreModale"></div>
							</span>
							<span>
								<button type="button" class="boutonAjouter">Ajouter un secretaire</button>
								<div class="fenetreModale">
									<div class="fenetre-header">
										Ajouter un secretaire<a class="close"><svg aria-label="Close" class="octicon octicon-x js-menu-close" height="16" role="img" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48z"></path></svg></a>
									</div>
									<div class="fenetre-body">
										<form action = "index.php?ajoutSecretaireFormationSub" method="post">
								      <input type="text" name="secretaire" placeholder="prenom.nom@email.fr"><br/><br/>
								      <input type="hidden" name="formation" value="<?php echo htmlspecialchars($formation["ID"]);?>">
											<button type="submit">Ajouter le secretaire</button>
								    </form>
									</form>
									</div>
								</div>
								<div class="derriereFenetreModale"></div>
							</span>
							<?php
							echo " <a href='?ajoutNiveau&formID=".$formation["ID"]."'><button>Ajouter un niveau</button></a><br /></div></div>";
						}
						if(count($formation["niveaux"]) <= 0){
							echo "<div class='vide'><p class='errorMessage'>Aucun niveau pour cette formation.</p>";
							if($formation["estAdmin"] || $formation["estSecretaire"]){
								echo "<a href='?ajoutNiveau'><button>Ajouter un niveau</button></a>";
							}
							echo "</div>";
						}else{
							foreach ($formation["niveaux"] as $niveau) {
								echo  "<h2>".$niveau["nom"]."</h2>";
								if(count($niveau["ues"]) <= 0){
									echo "<div class='vide'><p class='errorMessage'>Aucune UE à afficher pour ce niveau.</p>";
									if($formation["estAdmin"] || $formation["estSecretaire"]){
										?>
											<span>
												<button class="boutonAjouter">Ajouter une UE</button>
												<div class="fenetreModale">
													<div class="fenetre-header">
														Ajouter une UE <a class="close"><svg aria-label="Close" class="octicon octicon-x js-menu-close" height="16" role="img" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48z"></path></svg></a>
													</div>
													<div class="fenetre-body">
														<form class="" action="index.php?ajoutUESub" method="post">
															<input type="hidden" value="<?php echo $niveau["ID"];?>" name="niveau"/>
												      Nom : <input type="text" name="nom" placeholder="nom"><br/>
												      <button type="button" class="boutonAnnuler">Annuler</button>
												      <button type="submit">Ajouter l'UE</button>
												    </form>
													</div>
												</div>
											</span>
										<?php
									}
									echo "</div>";
								}else{
									if($formation["estAdmin"] || $formation["estSecretaire"]){
										?>
										<span>
											<button class="boutonAjouter">Ajouter une UE</button>
											<div class="fenetreModale">
												<div class="fenetre-header">
													Ajouter une UE<a class="close"><svg aria-label="Close" class="octicon octicon-x js-menu-close" height="16" role="img" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48z"></path></svg></a>
												</div>
												<div class="fenetre-body">
													<form class="" action="index.php?ajoutUESub" method="post">
														<input type="hidden" value="<?php echo $niveau["ID"];?>" name="niveau"/>
														Nom : <input type="text" name="nom" placeholder="nom"><br/>
														<button type="button" class="boutonAnnuler">Annuler</button>
														<button type="submit">Ajouter l'UE</button>
													</form>
												</div>
											</div>
										</span>
										<?php
									}

							foreach ($niveau["ues"] as $ue) {
				?>
				<h4><?php echo $ue["nom"];?>

				</h4>
				<?php if($formation["estProf"]){
					echo "<p> Vous enseignez ".$ue["nbHeures"]."h dans cette unité d'enseignement soit environ ".round($ue["nbHeures"]/24, 2)."h par semaine.</p>";
				}?>
				<?php if($formation["estAdmin"] || $formation["estSecretaire"]){ ?>
				<span>
					<button class="boutonAjouter">Ajouter un module</button>
					<div class="fenetreModale">
						<div class="fenetre-header">
							Ajouter un module <a class="close"><svg aria-label="Close" class="octicon octicon-x js-menu-close" height="16" role="img" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48z"></path></svg></a>
						</div>
						<div class="fenetre-body">
							<form class="" action="index.php?ajoutModuleSub" method="post">
				        ID du Module : <input type="text" name="ID" placeholder="ID"></br></br>
				        Nom : <input type="text" name="nom" placeholder="nom"></br></br>

								<input type="hidden" name="UE_ID" value="<?php echo $ue['ID']; ?>"/>
				        Nombre d'heures TDs : <input type="number" name="nbHeuresTD" placeholder="TD"></br></br>
				        Nombre d'heures TPs : <input type="number" name="nbHeuresTP" placeholder="TP"></br></br>
				        Nombre d'heures CMs : <input type="number" name="nbHeuresCM" placeholder="CM"></br></br>
				        Nombre d'heures DS : <input type="number" name="nbHeuresDS" placeholder="DS"></br></br>
				        Durée : <input type="text" name="duree" ></br></br>
				        <button type="submit">Ajouter un module</button>
				      </form>
						</div>

					</div>
					<div class="derriereFenetreModale"></div>
				</span>
				<?php } ?>
				<table class="module sortable">
					<tr class="titre-tableau">
						<th>
							ID
						</th>
						<th class="title">
							Module
						</th>
						<th>
						</th>
						<th>
							TP
						</th>
						<th>
							TD
						</th>
						<th>
							CM
						</th>
						<th>
							DS
						</th>
						<th class="total">
							Total
						</th>
						<?php
							if($formation["estProf"]){
								?>
									<th>
										Vœu
									</th>
								<?php
							}
						?>
						<?php
							if($formation["estAdmin"] || $formation["estSecretaire"]){
								?>
									<th>
										Admin
									</th>
								<?php
							}
						?>
					</tr>
	        <?php


	                foreach ($ue["modules"] as $module) {

	                  // On calcule le nombre de groupes restants pour chacun des types de cours
	                  $nbGroupesTPRestants = $niveau["nbTP"];
	                  $nbGroupesTDRestants = $niveau["nbTD"];
	                  $nbGroupesCMRestants = $niveau["nbCM"];
	                  $nbGroupesDSRestants = $niveau["nbDS"];

	                  // On récupère les profs par groupes
	                  $profsTP = array();
	                  $profsTD = array();
	                  $profsCM = array();
	                  $profsDS = array();
	                  foreach ($module["voeux"] as $voeu) {
	                    $nbGroupesTPRestants = $nbGroupesTPRestants - $voeu["nbGroupesTP"];
	                    $nbGroupesTDRestants = $nbGroupesTDRestants - $voeu["nbGroupesTD"];
	                    $nbGroupesDSRestants = $nbGroupesDSRestants - $voeu["nbGroupesDS"];
	                    $nbGroupesCMRestants = $nbGroupesCMRestants - $voeu["nbGroupesCM"];
	                    for($i = 0;$i<$voeu["nbGroupesTP"];$i++){
	                      $profsTP[] = $voeu["nomProf"];
	                    }
	                    for($i = 0;$i<$voeu["nbGroupesTD"];$i++){
	                      $profsTD[] = $voeu["nomProf"];
	                    }
	                    for($i = 0;$i<$voeu["nbGroupesCM"];$i++){
	                      $profsCM[] = $voeu["nomProf"];
	                    }
	                    for($i = 0;$i<$voeu["nbGroupesDS"];$i++){
	                      $profsDS[] = $voeu["nomProf"];
	                    }
	                  }
	                  $couleurTP = "rgb(255,255,255)";
	                  $rouge = "#f15755";
	                  $vert = "#6fac61";
	                  $orange = "#f9cc63";

	                  $couleurTP = "rgb(255,255,255)";
	                  if(($nbGroupesTPRestants/$niveau["nbTP"])>=1 || ($nbGroupesTPRestants/$niveau["nbTP"])<0 ){
	                    $couleurTP = $rouge;
	                  }elseif ($nbGroupesTPRestants == 0) {
	                    $couleurTP = $vert;
	                  }else{
	                    $couleurTP = $orange;
	                  }
	                  $couleurTD = "rgb(255,255,255)";
	                  if(($nbGroupesTDRestants/$niveau["nbTD"])>=1 || ($nbGroupesTDRestants/$niveau["nbTD"])<0 ){
	                    $couleurTD = $rouge;
	                  }elseif ($nbGroupesTDRestants == 0) {
	                    $couleurTD = $vert;
	                  }else{
	                    $couleurTD = $orange;
	                  }
	                  $couleurCM = "rgb(255,255,255)";
	                  if(($nbGroupesCMRestants/$niveau["nbCM"])>=1 || ($nbGroupesCMRestants/$niveau["nbCM"])<0 ){
	                    $couleurCM = $rouge;
	                  }elseif ($nbGroupesCMRestants == 0) {
	                    $couleurCM = $vert;
	                  }else{
	                    $couleurCM = $orange;
	                  }
	                  $couleurDS = "rgb(255,255,255)";
	                  if(($nbGroupesDSRestants/$niveau["nbDS"])>=1 || ($nbGroupesDSRestants/$niveau["nbDS"])<0 ){
	                    $couleurDS = $rouge;
	                  }elseif ($nbGroupesDSRestants == 0) {
	                    $couleurDS = $vert;
	                  }else{
	                    $couleurDS = $orange;
	                  }
	                  ?>
	                    <tr>
												<td style="text-align:left;">
	                        <?php echo $module["ID"];?>
												</td>
	                      <td class="title">
	                        <?php echo $module["nom"];?>
	                      </td>
												<td>
													<?php if(count($module["voeux"])){ ?>
													<button class="developper">Détails</button>
													<?php } ?>
												</td>
	                      <td >
	                        <div style="background-color:<?php echo $couleurTP;?>;color:white; border-radius:5px;padding:7px;">
	                        <?php echo $nbGroupesTPRestants." groupe(s) restant(s)";?>
	                        </div>
													<ul class="enseignants">
		                        <?php
		                        foreach ($profsTP as $prof) {
		                          echo "<li style='background-color:rgb(241, 248, 255);border-radius:5px;font-size:13px;border: 1px solid rgb(200, 225, 255);margin-top:5px;list-style:none;padding:3px;'>$prof</li>";
		                        }
		                        ?>
													</ul>
	                      </td>
	                      <td>
	                        <div style="background-color:<?php echo $couleurTD;?>;color:white; border-radius:5px;padding:7px;">
	                          <?php echo $nbGroupesTDRestants." groupe(s) restant(s)";?>
	                        </div>
													<ul class="enseignants">
		                        <?php
		                        foreach ($profsTD as $prof) {
		                          echo "<li style='background-color:rgb(241, 248, 255);border-radius:5px;font-size:13px;border: 1px solid rgb(200, 225, 255);margin-top:5px;list-style:none;padding:3px;'>$prof</li>";
		                        }
		                        ?>
													</ul>
	                      </td>
	                      <td>
	                        <div style="background-color:<?php echo $couleurCM;?>;color:white; border-radius:5px;padding:7px;">
	                            <?php echo $nbGroupesCMRestants." groupe(s) restant(s)";?>
	                        </div>
													<ul class="enseignants">
		                        <?php
		                        foreach ($profsCM as $prof) {
		                          echo "<li style='background-color:rgb(241, 248, 255);border-radius:5px;font-size:13px;border: 1px solid rgb(200, 225, 255);margin-top:5px;list-style:none;padding:3px;'>$prof</li>";
		                        }
		                        ?>
													</ul>
	                      </td>
	                      <td>
	                        <div style="background-color:<?php echo $couleurDS;?>;color:white; border-radius:5px;padding:7px;">
	                        	<?php echo $nbGroupesDSRestants." groupe(s) restant(s)";?>
	                      	</div>
													<ul class="enseignants">
		                        <?php
		                        foreach ($profsDS as $prof) {
		                          echo "<li style='background-color:rgb(241, 248, 255);border-radius:5px;font-size:13px;border: 1px solid rgb(200, 225, 255);margin-top:5px;list-style:none;padding:3px;'>$prof</li>";
		                        }
		                        ?>
													</ul>
	                      </td>
	                      <td class="total">
	                        <?php echo ($module["nbHeuresDS"]*$niveau["nbDS"]+$module["nbHeuresTP"]*$niveau["nbTP"]+$module["nbHeuresTD"]*$niveau["nbTD"]+$module["nbHeuresCM"]*$niveau["nbCM"]);?>
	                      </td>
												<?php
														// On vérifie si l'utilisateur est professeur
														if($formation["estProf"]){
															?>
	                      <td>
													<?php
		                          // On vérifie si l'utilisateur a déjà formulé un vœu pour cette formation
		                          $aDejaFormuleVoeu = false;
		                          foreach ($module["voeux"] as $voeu) {
		                            if($voeu["Utilisateur_ID"] == $_SESSION["id_utilisateur"]){
		                              $aDejaFormuleVoeu = true;
		                              ?>
		                              <button type="button" class="boutonAjouter">Modifier</button>
		                              <div class="fenetreModale" style="display:none;">
		                                <div class="fenetre-header">
		                                  Modifier un vœu <a class="close"><svg aria-label="Close" class="octicon octicon-x js-menu-close" height="16" role="img" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48z"></path></svg></a>
		                                </div>
		                                <div class="fenetre-body">
		                                  <h4><?php echo $module["ID"]." - ".$module["nom"]; ?></h4>
		                                  <form action="index.php?modifierVoeuSub" method="post">
		                                    <input type="hidden"  name="ModuleID" value="<?php echo $module["ID"];?>"/>
		                                    <table class="tableauVoeux">
		                                      <tr>
		                                        <th></th>
		                                        <th>TP</th>
		                                        <th>TD</th>
		                                        <th>CM</th>
		                                        <th>DS</th>
		                                        <th>Total</th>
		                                      </tr>
		                                      <tr>
		                                        <td>Nombre de groupes</td>
		                                        <td><input type="number" min="0" max="<?php echo $niveau["nbTP"]?>" name="nbGroupesTP" value="<?php echo $voeu["nbGroupesTP"];?>"/></td>
		                                        <td><input type="number" min="0" max="<?php echo $niveau["nbTD"]?>" name="nbGroupesTD" value="<?php echo $voeu["nbGroupesTD"];?>"/></td>
		                                        <td><input type="number" min="0" max="<?php echo $niveau["nbCM"]?>" name="nbGroupesCM" value="<?php echo $voeu["nbGroupesCM"];?>"/></td>
		                                        <td><input type="number" min="0" max="<?php echo $niveau["nbDS"]?>" name="nbGroupesDS" value="<?php echo $voeu["nbGroupesDS"]; ?>"/></td>
		                                        <td class="nbGroupesTotal"><span>0</span></td>
		                                      </tr>
		                                      <tr>
		                                        <td>Nombre d'heures</td>
		                                        <td class="nbHeuresTP">
		                                            <span><?php echo ($voeu["nbGroupesTP"]*$module["nbHeuresTP"]);?></span>
		                                            <input type="hidden" value="<?php echo $module["nbHeuresTP"]?>"/>
		                                        </td>
		                                        <td class="nbHeuresTD">
		                                            <span><?php echo ($voeu["nbGroupesTD"]*$module["nbHeuresTD"]);?></span>
		                                            <input type="hidden" value="<?php echo $module["nbHeuresTD"]?>"/>
		                                        </td>
		                                        <td class="nbHeuresCM">
		                                            <span><?php echo ($voeu["nbGroupesCM"]*$module["nbHeuresCM"]);?></span>
		                                            <input type="hidden" value="<?php echo $module["nbHeuresCM"]?>"/>
		                                        </td>
		                                        <td class="nbHeuresDS">
		                                            <span><?php echo ($voeu["nbGroupesDS"]*$module["nbHeuresDS"]);?></span>
		                                            <input type="hidden" value="<?php echo $module["nbHeuresDS"]?>"/>
		                                        </td>
		                                        <td class="nbHeuresTotal">
		                                          <span>0</span>
		                                        </td>
		                                      </tr>
		                                      <tr>
		                                        <td>Nombre de points</td>
		                                        <td class="nbPointsTP">
		                                            <span><?php echo round($voeu["nbGroupesTP"]*$module["nbHeuresTP"]*(2/3));?></span>
		                                        </td>
		                                        <td class="nbPointsTD">
		                                            <span><?php echo round($voeu["nbGroupesTD"]*$module["nbHeuresTD"]*(1));?></span>
		                                        </td>
		                                        <td class="nbPointsCM">
		                                            <span><?php echo round($voeu["nbGroupesCM"]*$module["nbHeuresCM"]*(3/4));?></span>
		                                        </td>
		                                        <td class="nbPointsDS">
		                                            <span><?php echo round($voeu["nbGroupesDS"]*$module["nbHeuresDS"]*(1));?></span>
		                                        </td>
		                                        <td class="nbPointsTotal">
		                                          <span>0</span>
		                                        </td>
		                                      </tr>
		                                    </table>
		                                    <div>
		                                      <textarea name="commentaire" placeholder="Votre commentaire (Facultatif)..."><?php echo $voeu["commentaire"]; ?></textarea>
		                                    </div>
																				<a href="?supprimerVoeuSub&VoeuID=<?php echo $voeu["ID"];?>"><button type="button">
			                                      Supprimer le voeu
			                                    </button></a>

		                                    <button>
		                                      Modifier mon voeu
		                                    </button>
		                                  </form>
		                                </div>
		                              </div>
		                              <div class="derriereFenetreModale"></div>
		                              <?

		                            }
		                          }
		                          if(!$aDejaFormuleVoeu){
		                              ?>
		                              <button type="button" class="boutonAjouter">Ajouter</button>
		                              <div class="fenetreModale" style="display:none;">
		                                <div class="fenetre-header">
																			<p>Ajouter un voeu</p> <a class="close"><svg aria-label="Close" class="octicon octicon-x js-menu-close" height="16" role="img" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48z"></path></svg></a>
																		</div>
		                                <div class="fenetre-body">
		                                  <h4><?php echo $module["ID"]." - ".$module["nom"]; ?></h4>
		                                  <form action="index.php?ajoutVoeuSub" method="post">
		                                    <input type="hidden"  name="ModuleID" value="<?php echo $module["ID"];?>"/>
		                                    <table class="tableauVoeux">
		                                      <tr>
		                                        <th></th>
		                                        <th>TP</th>
		                                        <th>TD</th>
		                                        <th>CM</th>
		                                        <th>DS</th>
		                                        <th>Total</th>
		                                      </tr>
		                                      <tr>
		                                        <td>Nombre de groupes</td>
		                                        <td><input type="number" min="0" max="<?php echo $niveau["nbTP"]?>" name="nbGroupesTP" value="0"/></td>
		                                        <td><input type="number" min="0" max="<?php echo $niveau["nbTD"]?>" name="nbGroupesTD" value="0"/></td>
		                                        <td><input type="number" min="0" max="<?php echo $niveau["nbCM"]?>" name="nbGroupesCM" value="0"/></td>
		                                        <td><input type="number" min="0" max="<?php echo $niveau["nbDS"]?>" name="nbGroupesDS" value="0"/></td>
		                                        <td class="nbGroupesTotal"><span>0</span></td>
		                                      </tr>
		                                      <tr>
		                                        <td>Nombre d'heures</td>
		                                        <td class="nbHeuresTP">
		                                            <span>0</span>
		                                            <input type="hidden" value="<?php echo $module["nbHeuresTP"]?>"/>
		                                        </td>
		                                        <td class="nbHeuresTD">
		                                            <span>0</span>
		                                            <input type="hidden" value="<?php echo $module["nbHeuresTD"]?>"/>
		                                        </td>
		                                        <td class="nbHeuresCM">
		                                            <span>0</span>
		                                            <input type="hidden" value="<?php echo $module["nbHeuresCM"]?>"/>
		                                        </td>
		                                        <td class="nbHeuresDS">
		                                            <span>0</span>
		                                            <input type="hidden" value="<?php echo $module["nbHeuresDS"]?>"/>
		                                        </td>
		                                        <td class="nbHeuresTotal">
		                                          <span>0</span>
		                                        </td>
		                                      </tr>
		                                      <tr>
		                                        <td>Nombre de points</td>
		                                        <td class="nbPointsTP">
		                                            <span>0</span>
		                                        </td>
		                                        <td class="nbPointsTD">
		                                            <span>0</span>
		                                        </td>
		                                        <td class="nbPointsCM">
		                                            <span>0</span>
		                                        </td>
		                                        <td class="nbPointsDS">
		                                            <span>0</span>
		                                        </td>
		                                        <td class="nbPointsTotal">
		                                          <span>0</span>
		                                        </td>
		                                      </tr>
		                                    </table>
		                                    <div>
		                                      <textarea name="commentaire" placeholder="Votre commentaire (Facultatif)..."></textarea>
		                                    </div>
		                                    <button>
		                                      Valider mon voeu
		                                    </button>
																				<button>
																					Annuler
																				</button>
		                                  </form>
		                                </div>
		                              </div>
		                              <div class="derriereFenetreModale"></div>
		                              <?php
		                            }?>

	                      </td>
												<?php
											}

													if($formation["estAdmin"] || $formation["estSecretaire"]){
														?>
															<td>
																<button class="boutonAjouter">Modifier module</button>
																<div class="fenetreModale">
																	<div class="fenetre-header">
																		Modifier Module <a class="close"><svg aria-label="Close" class="octicon octicon-x js-menu-close" height="16" role="img" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48z"></path></svg></a>
																	</div>
																	<div class="fenetre-body">
																		<form action="index.php?modifierModuleSub" method="post">
																			<input type="hidden" name="UE_ID" value="<?php echo $ue['ID']; ?>"/>
																			<input type="hidden" name="ID" value="<?php echo $module['ID']; ?>"/>
																			Nom : <input type="text" name="nom" value="<?php echo $module['nom']; ?>" /><br/><br />
															        Nombre d'heures TDs : <input type="number" name="nbHeuresTD" placeholder="TD" value="<?php echo $module['nbHeuresTD']; ?>" ></br></br>
															        Nombre d'heures TPs : <input type="number" name="nbHeuresTP" placeholder="TP" value="<?php echo $module['nbHeuresTP']; ?>" ></br></br>
															        Nombre d'heures CMs : <input type="number" name="nbHeuresCM" placeholder="CM" value="<?php echo $module['nbHeuresCM']; ?>" ></br></br>
															        Nombre d'heures DS : <input type="number" name="nbHeuresDS" placeholder="DS"  value="<?php echo $module['nbHeuresDS']; ?>" ></br></br>
															        Duree : <input type="text" name="duree" value="<?php echo $module['duree']; ?>"></br></br>
																			<a href="?supprimerModule&moduleID=<?php echo $module['ID']; ?>&UE_ID=<?php echo $ue['ID']; ?>"><button type="button">Supprimer Module</button></a>

																			<button>Modifier</button>
																		</form>
																	</div>
																</div>
	                              <div class="derriereFenetreModale">
																</div>
															</td>
														<?php
													}
												?>
	                    </tr>
	                  <?php
	                }}?>
										</table>
									<?php
	            }
						}}
					}	
			}else{ ?>
				<div class="vide">
						<p class="errorMessage">Vous n'êtes inscrit dans aucune formation</p>
						<a href="?rejoindreFormation"><button>Rejoindre une formation</button><a>
						<span>
							<a href="?ajoutFormation"><button class="boutonAjouter">Créer une formation</button></a>
							<div class="fenetreModale">
								<div class="fenetre-header">
									Nouvelle formation<a class="close"><svg aria-label="Close" class="octicon octicon-x js-menu-close" height="16" role="img" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48z"></path></svg></a>
								</div>
								<div class="fenetre-body">
									<form action="index.php?ajoutFormationSub" method="POST">
							      <?php if (isset($_GET["erreur"])) {
							        switch ($_GET["erreur"]) {
							          case '1':
							            echo "Veuillez entre un nom pour la formation";
							            break;

							          case '2':
							            echo "Si vous n'êtes pas administrateur de la formation, veuillez entre l'adresse mail d'un administrateur";
							            break;
							          case '3':
							            echo "L'adresse mail de l'administrateur est invalide";
							            break;

							          default:
							            # code...
							            break;
							        }
							      } ?>
							        <input type="text" name="nom_formation" value="">
							      <label for="checkbox-1">
							        <input type="checkbox" id="checkbox-1" class="mdl-checkbox__input" name="admin" value="true">
							        <span>Je suis administrateur</span>
							      </label>
							      <p style="max-width:400px;">Attention ! Assurez-vous d'avoir l'accord du chef <br/> de la formation avant d'ajouter la formation.</p>
							        <?php if(isset($_GET["adminInexistant"]) && isset($_GET["adminmail"]) ){
							          echo "L'utilisateur ".htmlspecialchars($_GET["adminmail"]);?>
							           n'existe pas, souhaitez-vous l'inviter à rejoindre ORCE ?
							          <input type="radio" name="invitationORCE" value="oui" onchange="maj();" checked> Oui
							          <input type="radio" id="nonButton" name="invitationORCE" onchange="maj();" value="non"> Non<br>
							          <?php
							        }
							        ?>

							        <input id="mail_admin" type="text" name="mail_admin" placeholder="Adresse mail de l'administrateur" value="<?php if(isset($_GET["adminmail"])){echo htmlspecialchars($_GET["adminmail"]);} ?>" />
												<br/><br/>
											<div id="listeNiveaux">
							            <div class="niveau">
							                  <input type="text" name="nomNiveau0">
							                  <input type="number" min="0" max="100"name="nbCMNiveau0">
							                  <input type="number" min="0" max="100" name="nbTDNiveau0">
							                  <input type="number" min="0" max="100" name="nbTPNiveau0">
							            </div>
							        </div><br/>
							        <input type="hidden" value=1 name="nbNiveaux" id="nbNiveaux"/>
							        <button id="boutonNiveau" type="button"> Ajouter un niveau</button>

											<button type="button" class="boutonAnnuler">Annuler</button> <br/><br/>
							        <button type="submit">
							          Ajout de la formation
							        </button>

							    </form>
							  </div>
							  <script type="text/javascript">
							  <?php if(isset($_GET["adminInexistant"])){
							    ?>
							      document.getElementById("mail_admin").style.display = "none";
							    <?php
							  }
							  ?>
							    function maj(){
							      if (document.getElementById("nonButton").checked) {
							        document.getElementById("mail_admin").style.display = "block";
							      }else{
							        document.getElementById("mail_admin").style.display = "none";
							      }
							    }


							    var nbNiveaux = document.getElementById("nbNiveaux").value;
							    var listeNiveaux = document.getElementById("listeNiveaux");
							    function ajouterNiveau() {
							      if (nbNiveaux < 9) {
							        var nouveauNiveau = document.createElement("div");
							        nouveauNiveau.className = "niveau";

							        var nomNiveau = document.createElement("input");
							        nomNiveau.type = "text";
							        nomNiveau.name = "nomNiveau"+nbNiveaux;
							        nomNiveau.placeholder = "Année "+(parseInt(nbNiveaux)+1);

							        var nbCMNiveau = document.createElement("input");
							        nbCMNiveau.type = "number";
							        nbCMNiveau.setAttribute("min", "0");
							        nbCMNiveau.setAttribute("max", "100");
							        nbCMNiveau.name = "nbCMNiveau"+nbNiveaux;
							        nbCMNiveau.placeholder = "Nombre de groupe de CM";

							        var nbTDNiveau = document.createElement("input");
							        nbTDNiveau.type = "number";
							        nbTDNiveau.setAttribute("min", "0");
							        nbTDNiveau.setAttribute("max", "100");
							        nbTDNiveau.name = "nbTDNiveau"+nbNiveaux;
							        nbTDNiveau.placeholder = "Nombre de groupe de TD";

							        var nbTPNiveau = document.createElement("input");
							        nbTPNiveau.type = "number";
							        nbTPNiveau.setAttribute("min", "0");
							        nbTPNiveau.setAttribute("max", "100");
							        nbTPNiveau.name = "nbTPNiveau"+nbNiveaux;
							        nbTPNiveau.placeholder = "Nombre de groupe de TP";

							        nouveauNiveau.appendChild(nomNiveau);
							        nouveauNiveau.appendChild(nbCMNiveau);
							        nouveauNiveau.appendChild(nbTDNiveau);
							        nouveauNiveau.appendChild(nbTPNiveau);
							        listeNiveaux.appendChild(nouveauNiveau);

							        document.getElementById("nbNiveaux").value++;
							        nbNiveaux = document.getElementById("nbNiveaux").value;
							      }

							    }

							    document.getElementById('boutonNiveau').addEventListener("click", ajouterNiveau);
							  </script>
								</div>
							</div>
						</div>
				</span>
				<?php
			}?>
		</div>
    <script type="text/javascript">
    $(document).ready(function(){
			$(".fenetreModale").css("display", "none");
			$(".afficherReglages").parent().find(".reglages").hide();
			$(".afficherReglages").click(function(){
				$(this).parent().find(".reglages").toggle();
			});
      $(".fenetreModale .tableauVoeux input[type=number]").on("change", actualiserTableauVoeux);
      $(".boutonAjouter").on("click", ouvrirFenetreModale);
      $(".fenetreModale .boutonAnnuler").on("click", fermerFenetreModale);
      $(".fenetreModale .close").on("click", fermerFenetreModale);
      $(".developper").on("click", function() {
				var enseignants = $(this).closest("tr").find('.enseignants');
				console.log(enseignants.html());
				enseignants.toggleClass("active");
				if($(this).text()=="Détails"){
					$(this).text("Cacher");
				}else{
					$(this).text("Détails");
				}
			});


      function actualiserTableauVoeux(){
        var nbHeuresDS = $(this).parentsUntil(".tableauVoeux").find(".nbHeuresDS input").val();
        var nbHeuresTP = $(this).parentsUntil(".tableauVoeux").find(".nbHeuresTP input").val();
        var nbHeuresTD = $(this).parentsUntil(".tableauVoeux").find(".nbHeuresTD input").val();
        var nbHeuresCM = $(this).parentsUntil(".tableauVoeux").find(".nbHeuresCM input").val();

        var nbGroupesTD = $(this).parentsUntil(".tableauVoeux").find("input[name=nbGroupesTD]").val();
        var nbGroupesTP = $(this).parentsUntil(".tableauVoeux").find("input[name=nbGroupesTP]").val();
        var nbGroupesCM = $(this).parentsUntil(".tableauVoeux").find("input[name=nbGroupesCM]").val();
        var nbGroupesDS = $(this).parentsUntil(".tableauVoeux").find("input[name=nbGroupesDS]").val();

        $(this).parentsUntil(".tableauVoeux").find(".nbGroupesTotal span").text((nbGroupesTD*1+nbGroupesTP*1+nbGroupesCM*1+nbGroupesDS*1));

        $(this).parentsUntil(".tableauVoeux").find(".nbHeuresDS span").text(nbHeuresDS*nbGroupesDS);
        $(this).parentsUntil(".tableauVoeux").find(".nbHeuresTD span").text(nbHeuresTD*nbGroupesTD);
        $(this).parentsUntil(".tableauVoeux").find(".nbHeuresCM span").text(nbHeuresCM*nbGroupesCM);
        $(this).parentsUntil(".tableauVoeux").find(".nbHeuresTP span").text(nbHeuresTP*nbGroupesTP);
        $(this).parentsUntil(".tableauVoeux").find(".nbHeuresTotal span").text(nbHeuresTP*nbGroupesTP+nbHeuresDS*nbGroupesDS+nbHeuresTD*nbGroupesTD+nbHeuresCM*nbGroupesCM);

        $(this).parentsUntil(".tableauVoeux").find(".nbPointsDS span").text(nbHeuresDS*nbGroupesDS*1);
        $(this).parentsUntil(".tableauVoeux").find(".nbPointsTD span").text(nbHeuresTD*nbGroupesTD*1);
        $(this).parentsUntil(".tableauVoeux").find(".nbPointsTP span").text(nbHeuresTP*nbGroupesTP*Math.round((2/3)*10)/10);
        $(this).parentsUntil(".tableauVoeux").find(".nbPointsCM span").text(nbHeuresCM*nbGroupesCM*1.5);
        $(this).parentsUntil(".tableauVoeux").find(".nbPointsTotal span").text(nbHeuresTP*nbGroupesTP*Math.round((2/3)*10)/10+nbHeuresDS*nbGroupesDS*1+nbHeuresTD*nbGroupesTD*1+nbHeuresCM*nbGroupesCM*1.5);
      }

      function fermerFenetreModale(){
        $(this).parentsUntil(".fenetreModale").parent().css("display", "none");
        $(".derriereFenetreModale").css("display", "none");
      }
      function ouvrirFenetreModale(){
        $(this).parent().find(".fenetreModale").css("display", "block");
        $(this).parent().find(".fenetre-body").css("display", "block");
        $(this).parent().find(".derriereFenetreModale").css("display", "block");
      }
    });
    </script>
	</body>
	<!--<footer>
		<p id="menu-bas"></p>
    <img src="https://upload.wikimedia.org/wikipedia/fr/thumb/6/62/Universit%C3%A9_de_Nantes_%28logo%29.svg/1200px-Universit%C3%A9_de_Nantes_%28logo%29.svg.png"  />
	</footer>-->
</html>
