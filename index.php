<?php
session_start();

require_once("config.php");
include_once("fonction.php");
include_once("methodes/cl_membre.php");
include_once("methodes/cl_motcle.php");
include_once("methodes/cl_commentaire.php");
include_once("methodes/cl_techquestion.php");

if(isset($_POST['action'])) $action = $_POST['action']; else if(isset($_GET['action'])) $action = $_GET['action']; else $action = "accueil";

$errorMessageJs = "";

if($action == "connexion") require("actions/connexion.php");
else if($action == "deconnexion") require("actions/deconnexion.php");
else if($action == "inscriptionEnregistrer") require("actions/inscriptionEnregistrer.php");

require_once("constante.php");

if($action == "motcleEnregistrer") require("actions/motcleEnregistrer.php");
else if($action == "motcleSupprimer") require("actions/motcleSupprimer.php");
else if($action == "technoteEnregistrer") require("actions/technoteEnregistrer.php");
else if($action == "technoteCommentaireEnregistrer") require("actions/technoteCommentaireEnregistrer.php");
else if($action == "technoteSupprimer") require("actions/technoteSupprimer.php");
else if($action == "questionEnregistrer") require("actions/questionEnregistrer.php");
else if($action == "questionCommentaireEnregistrer") require("actions/questionCommentaireEnregistrer.php");
else if($action == "questionSupprimer") require("actions/questionSupprimer.php");
else if($action == "moncompteEnregistrer") require("actions/moncompteEnregistrer.php");
else if($action == "membreEnregistrer") require("actions/membreEnregistrer.php");
else if($action == "membreSupprimer") require("actions/membreSupprimer.php");

$javascriptOnLoad="";
if ($errorMessageJs !="") $javascriptOnLoad="alert('".$errorMessageJs."');";
?>

<!doctype html>
<html lang="fr">
	<head>
	<meta charset="UTF-8" />
		<link rel="stylesheet" href="style.css" />
		<script type="text/javascript" src="javascript.js"></script>
		<script type="text/javascript" src="ckeditor_4.5.8_full/ckeditor/ckeditor.js"></script>
		<title>Mon serveur de technotes</title>
	</head>
	<body <?PHP if($javascriptOnLoad!="") echo "onload=\"".$javascriptOnLoad."\"";?>>
	<div id="global">
		<header>
			<table width="100%" border=0>
				<tr><td>
					<table width="100%" border=0>
						<tr>
							<td width="320"><?PHP if(ID_MEMBRE!=0) echo "Bonjour ".PSEUDO; else {?><a class="menu1" href="index.php?action=inscriptionFormulaire">M'inscrire</a><?PHP }?></td>
							<td><a href="index.php"><h1>Mon serveur de technotes</h1></a></td>
							<td width="320" align="right"><?PHP if(ID_MEMBRE==0) {?>
								<form name="fconnexion" method="POST" action="index.php">
									<table border="0" cellpadding="2" cellspacing ="0">
										<tr>
											<td align="right"><span class="menu1">Email</span></td>
											<td><input class="inputConnexion" type="text" name="email" value=""></td>
											<td></td>
										</tr>
										<tr>
											<td align="right"><span class="menu1">Mot de passe</span></td>
											<td><input class="inputConnexion" type="password" name="motDePasse" value=""></td>
											<td>
												<input type="button" value="OK" onclick="javascript:verifie_formulaire_connexion('');">
												<input type="hidden" name="action" value="connexion">
											</td>
										</tr>
									</table>
								</form>
								<?PHP } else { ?><a class="menu1" href="index.php?action=deconnexion">D&eacute;connexion</a><?PHP } ?>
							</td>
						</tr>
					</table>
				</td></tr>
				<tr><td class="menutd">
					<!-- Menu -->
					<span class="menu">
					<?PHP 
						if(isset($_SESSION['technoteConsulter']) && $_SESSION['technoteConsulter']==1) echo "<a class=\"menu\" href=\"index.php?action=technotesListe\">TECHNOTES</a> | ";
						if(isset($_SESSION['technoteAjouter']) && $_SESSION['technoteAjouter']==1) echo "<a class=\"menu\" href=\"index.php?action=technoteFormulaire&id_techquestion=\">AJOUTER UN TECHNOTE</a> | "; 
						if(isset($_SESSION['questionConsulter']) && $_SESSION['questionConsulter']==1) echo "<a class=\"menu\" href=\"index.php?action=questionsListe\">QUESTIONS</a> | ";
						if(isset($_SESSION['questionAjouter']) && $_SESSION['questionAjouter']==1) echo "<a class=\"menu\" href=\"index.php?action=questionFormulaire\">POSER UNE QUESTION</a> | ";
						if(isset($_SESSION['motcleConsulter']) && $_SESSION['motcleConsulter']==1) echo "<a class=\"menu\" href=\"index.php?action=motclesListe\">MOT-CLES</a> | ";
						if(isset($_SESSION['membreConsulter']) && $_SESSION['membreConsulter']==1) echo "<a class=\"menu\" href=\"index.php?action=membresListe\">MEMBRES</a> | "; 
						if(isset($_SESSION['id_membre']) ) echo "<a class=\"menu\" href=\"index.php?action=technotesMiens\">MES TECHNOTES</a> | "; 
						if(isset($_SESSION['id_membre']) ) echo "<a class=\"menu\" href=\"index.php?action=moncompteFormulaire\">MON COMPTE</a> | ";
					?>
					</span>
				</td></tr>
				<tr><td><br></td></tr>
			<table>
		</header>
		<div id="contenu">
			<?php
			//GESTION DE L'AFFICHAGE

			if ($action == "inscriptionFormulaire") { if (file_exists("affichage/inscriptionFormulaire.php")) require ("affichage/inscriptionFormulaire.php"); else require ("affichage/pageAbsente.php");} 
			else if ($action == "motclesListe") { if (file_exists("affichage/motclesListe.php")) require ("affichage/motclesListe.php"); else require ("affichage/pageAbsente.php");}
			else if ($action == "motcleFormulaire") { if (file_exists("affichage/motcleFormulaire.php")) require ("affichage/motcleFormulaire.php"); else require ("affichage/pageAbsente.php");}
			else if ($action == "technotesListe") { if (file_exists("affichage/technotesListe.php")) require ("affichage/technotesListe.php"); else require ("affichage/pageAbsente.php");} 
			else if ($action == "technotesMiens") { if (file_exists("affichage/technotesMiens.php")) require ("affichage/technotesMiens.php"); else require ("affichage/pageAbsente.php");} 
			else if ($action == "technoteConsultation") { if (file_exists("affichage/technoteConsultation.php")) require ("affichage/technoteConsultation.php"); else require ("affichage/pageAbsente.php");} 
			else if ($action == "technoteFormulaire") { if (file_exists("affichage/technoteFormulaire.php")) require ("affichage/technoteFormulaire.php"); else require ("affichage/pageAbsente.php");}
			else if ($action == "questionsListe") { if (file_exists("affichage/questionsListe.php")) require ("affichage/questionsListe.php"); else require ("affichage/pageAbsente.php");} 
			else if ($action == "questionConsultation") { if (file_exists("affichage/questionConsultation.php")) require ("affichage/questionConsultation.php"); else require ("affichage/pageAbsente.php");} 
			else if ($action == "questionFormulaire") { if (file_exists("affichage/questionFormulaire.php")) require ("affichage/questionFormulaire.php"); else require ("affichage/pageAbsente.php");}
			else if ($action == "membresListe") { if (file_exists("affichage/membresListe.php")) require ("affichage/membresListe.php"); else require ("affichage/pageAbsente.php");} 
			else if ($action == "membreFormulaire") { if (file_exists("affichage/membreFormulaire.php")) require ("affichage/membreFormulaire.php"); else require ("affichage/pageAbsente.php");} 				
			else if ($action == "moncompteFormulaire") { if (file_exists("affichage/moncompteFormulaire.php")) require ("affichage/moncompteFormulaire.php"); else require ("affichage/pageAbsente.php");} 				
			?>
		</div> <!-- #contenu -->
		<footer id="piedPrincipal">
			Technote r&eacute;alis&eacute; avec PHP, HTML5 et CSS.
		</footer>
	</div> <!-- #global -->

</body>
</html>