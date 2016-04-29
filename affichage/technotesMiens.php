<h2>Mes technotes</h2>
<?PHP
if ($_SESSION['id_membre'])
{
?>
	<form name="frecherche" action="index.php" method="post">
		<input type="hidden" name="action" value="technotesMiens"/>
		<span class="recherche">
			Tri par 
			<select name="ordreReq" class="selectRecherche">
				<option value="t.date_creation" <?PHP if(!isset($_POST['ordreReq']) || $_POST['ordreReq']== 't.date_creation') {echo 'selected';} ?>>date</option>
				<option value="t.titre" <?PHP if(isset($_POST['ordreReq']) && $_POST['ordreReq']== 't.titre') {echo 'selected';} ?>>titre</option>
				<option value="m.pseudo" <?PHP if(isset($_POST['ordreReq']) && $_POST['ordreReq']== 'm.pseudo') {echo 'selected';} ?>>auteur</option>
			</select>
			<select name="directionReq" class="selectRecherche">
				<option value="ASC" <?PHP if(!isset($_POST['directionReq']) || $_POST['directionReq']== 'ASC') {echo 'selected';} ?>>croissant</option>
				<option value="DESC" <?PHP if(isset($_POST['directionReq']) && $_POST['directionReq']== 'DESC') {echo 'selected';} ?>>d&eacute;croissant</option>
			</select>
			<br>Recherche Cr&eacute;&eacute; entre <input type ="text" name = "date1Req" value = "<?PHP if(isset($_POST['date1Req'])) {echo $_POST['date1Req'];} ?>"> et le <input type ="text" name = "date2Req" value = "<?PHP if(isset($_POST['date1Req'])) {echo $_POST['date2Req'];} ?>">
			Mot-cl&eacute;s <input type ="text" name = "motsclesReq" value = "<?PHP if(isset($_POST['motsclesReq'])) {echo $_POST['motsclesReq'];} ?>">
			Statut <select name="statutReq" class="selectRecherche">
				<option value="" <?PHP if(!isset($_POST['statutReq']) || $_POST['statutReq']== '') {echo 'selected';} ?>>Tous</option>
				<option value="1" <?PHP if(isset($_POST['statutReq']) && $_POST['statutReq']== '1') {echo 'selected';} ?>>Publi&eacute;</option>
				<option value="0" <?PHP if(isset($_POST['statutReq']) && $_POST['statutReq']== '0') {echo 'selected';} ?>>Non publi&eacute;</option>
			</select>
			<input type="hidden" name="id_auteurReq" value="<?PHP echo $_SESSION['id_membre'];?>"/>
		<input type="submit" name="envoi" value="envoyer"/>
	</span>	
		
	<table width="100%" cellpadding="3">
		<tr>
			<td valign="top" colspan="3">
				<?PHP 
				if ($_SESSION['technoteAjouter'] == 1) echo "<a href=\"index.php?action=technoteFormulaire&id_techquestion=\" class=\"technoteLien\">Ajouter un technote</a>";
				?>
			</td>
		</tr>
		<tr>
			<td width="80" valign="top"><span class="titreColonne">Date</span></td>
			<td valign="top"><span class="titreColonne">Technotes - <i>mot cles</i></span></td>
		</tr>

		<?PHP
			if(isset($_POST['ordreReq'])) $ordre_tmp = $_POST['ordreReq']; else $ordre_tmp ='';
			if(isset($_POST['directionReq'])) $direction_tmp = $_POST['directionReq']; else $direction_tmp ='';
			if(isset($_POST['date1Req'])) $date1_tmp = $_POST['date1Req']; else $date1_tmp ='';
			if(isset($_POST['date2Req'])) $date2_tmp = $_POST['date2Req']; else $date2_tmp ='';
			if(isset($_POST['motsclesReq'])) $motscles_tmp = $_POST['motsclesReq']; else $motscles_tmp ='';
			if(isset($_POST['statutReq'])) $statut_tmp = $_POST['statutReq']; else $statut_tmp ='';
			
			$techquestionGestion = new TechquestionGestion($BDD);
			$listeTechquestions = $techquestionGestion->getListRecherche(1, $ordre_tmp, $direction_tmp, $_SESSION['id_membre'], $date1_tmp, $date2_tmp, $statut_tmp, $motscles_tmp);
			if ($listeTechquestions) 
			{
				foreach ($listeTechquestions as $id_techquestion=>$donnees)
				{
				?>
					<tr>
						<td valign="top"><span class="contenuCellule"><?PHP echo formaterDate($donnees['date_creation']); ?></span></td>
						<td valign="top">
							<a class="contenuCellule" href ="index.php?action=technoteConsultation&id_techquestion=<?PHP echo $id_techquestion; ?>"><?PHP echo $donnees['titre']; ?></a>
							<br/><span class="motClesListe"><?PHP echo $donnees['motcles']; ?></span>
							<?PHP if ( ( $_SESSION['technoteModifier'] == 1) || ( $_SESSION['technoteAjouter'] == 1 && $_SESSION['id_membre'] == $donnees['id_membre'] ) ) { ?><a class="lienMenu" href ="index.php?action=technoteFormulaire&id_techquestion=<?PHP echo $id_techquestion; ?>">modifier</a> <?PHP }?>
						</td>
					</tr>
					<?PHP
				}
			}
		?>
	</table>
	<?PHP
}
?>