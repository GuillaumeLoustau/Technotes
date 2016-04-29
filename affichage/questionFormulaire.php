<?PHP
if (isset($_POST['id_techquestion'])) $id_techquestion=$_POST['id_techquestion']; else if (isset($_GET['id_techquestion'])) $id_techquestion=$_GET['id_techquestion']; else $id_techquestion="";
$techquestionGestion = new TechquestionGestion($BDD);
if ($id_techquestion!="") 
{
	$techquestion = $techquestionGestion->getOne($id_techquestion);
	$motcleGestion = new MotcleGestion($BDD);
	$motcles_tmp = $motcleGestion->getStringMotcles($id_techquestion);
	$membreGestion = new MembreGestion($BDD);
	$membre = $membreGestion->getOne($techquestion->getIdMembre());
	$id_auteur_tmp = $techquestion->getIdMembre();
	$id_type_tmp = $techquestion->getIdType();
	$statut_tmp = $techquestion->getStatut();
	$date_creation_tmp = $techquestion->getDateCreation();
}
else 
{
	$techquestion = new Techquestion(array());
	$id_auteur_tmp = $_SESSION['id_membre'];
	$id_type_tmp = 1;
	$statut_tmp = 0;
	$motcles_tmp = "";
	$date_creation_tmp = "";
}

?>	
<h2>Question - <?PHP if ($id_techquestion=="") echo "Nouvelle"; else { echo $techquestion->getTitre();?> pos&eacute;e par <?PHP echo $membre->getPseudo();?> le <?PHP echo formaterDate($techquestion->getDateCreation()); } ?> </h2>
<form name="fquestion" method="POST" action="index.php">
	<input type="hidden" name="action" value="questionEnregistrer" />
	<input type="hidden" name="id_techquestion" value="<?PHP echo $id_techquestion;?>" />
	<input type="hidden" name="idType" value="<?PHP echo $id_type_tmp;?>" />
	<input type="hidden" name="idAuteur" value="<?PHP echo $id_auteur_tmp; ?>" />
	<input type="hidden" name="dateCreation" value="<?PHP echo $date_creation_tmp;?>" />
	<table border=0>
		<tr>
			<td align="right"><span class="libelleForm">Titre</span></td>
			<td><input class="inputTechquestion" type="text" name="titre" value="<?PHP echo $techquestion->getTitre();?>"></td>
		</tr>
		<tr><td></td><td></td></tr>
		<tr>
			<td align="right"><span class="libelleForm">Statut</span></td>
			<td>
				<select name = "statut">
					<option value = "0" <?PHP if ($statut_tmp=="0") echo "selected"; ?>>Non r&eacute;solue</option>
					<option value = "1" <?PHP if ($statut_tmp=="1") echo "selected"; ?>>R&eacute;solue</option>
				</select>
			</td>
		</tr>
		<tr><td></td><td></td></tr>
		<tr>
			<td align="right"><span class="libelleForm">Mot-cl&eacute;s</span></td>
			<td>
				<input class="inputTechquestion" type="text" name="motcles" value="<?PHP echo $motcles_tmp;?>">
				<br><i>Saisir les mots-cl&eacute; s&eacute;par&eacute;s par des virgules</i>
			</td>
		</tr>
		<tr><td></td><td></td></tr>
		<tr>
			<td align="right"><span class="libelleForm">Contenu</span></td>
			<td><textarea class="ckeditor" id="contenu"  name="contenu"><?PHP echo $techquestion->getContenu();?></textarea></td>
		</tr>
		<tr><td></td><td></td></tr>		
		<tr>
			<td colspan="2" align="right">
				<!-- 
					Le droit 'questionAjouter' autorise un membre à ajouter une question et à modifier ses questions. 
					Le droit 'questionModifier' autorise la modification de toutes les questions. 
				-->
				<?PHP if ( $id_techquestion!="" && $_SESSION['questionConsulter'] == 1  ) { ?>  <input type="button" value="Visualiser" onclick="javascript:document.fquestion.action.value = 'questionConsultation';document.fquestion.submit();">  <?PHP } ?>
				<?PHP if ( $id_techquestion!="" && ( $_SESSION['questionModifier'] == 1 ||  ( $_SESSION['questionAjouter'] == 1 &&  $_SESSION['id_membre'] == $id_auteur_tmp )  ) ) { ?><input type="button" value="Enregistrer" onclick="javascript:verifie_formulaire_question();">  <?PHP } ?>
				<?PHP if ( $id_techquestion=="" && $_SESSION['questionAjouter'] == 1 ) { ?>  <input type="button" value="Ajouter" onclick="javascript:verifie_formulaire_question();">  <?PHP } ?>
				<?PHP if ( $id_techquestion!="" && ( $_SESSION['questionSupprimer'] == 1 ||  ( $_SESSION['questionAjouter'] == 1 &&  $_SESSION['id_membre'] == $id_auteur_tmp ) ) ) { ?>  <input type="button" value="Supprimer" onclick="javascript:formulaire_supprimer_question();">  <?PHP } ?>
			</td>	
		</tr>						
	</table>			
</form>

