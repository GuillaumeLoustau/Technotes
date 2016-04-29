<?PHP
	if (isset($_POST['idMotcle'])) $idMotcle=$_POST['idMotcle']; else if (isset($_GET['idMotcle'])) $idMotcle=$_GET['idMotcle']; else $idMotcle="";
	if (isset($_POST['idMotclePere'])) $idMotclePere=$_POST['idMotclePere']; else if (isset($_GET['idMotclePere'])) $idMotclePere=$_GET['idMotclePere']; else $idMotclePere=0;
	$motcleGestion = new MotcleGestion($BDD);
	if ($idMotcle!="") 
	{
		$motcle = $motcleGestion->getOne($idMotcle);
		$tFils = $motcleGestion->getListChildren($idMotcle);
		$tSynonimes = $motcleGestion->getListSynonims($idMotcle);
		if ($motcle->getValide() == 0 ) $titre_tmp = "<font color = \"#ff0000\">".$motcle->getLibelle()."</font>";
		else $titre_tmp = $motcle->getLibelle();
		$idFirstSynonim = $motcleGestion->getIdFirstSynonim($motcle);
	}
	else 
	{
		$motcle = new Motcle(array());
		$motcle->setIdPere($idMotclePere);
		$tFils = array();
		$tSynonimes = array();
		$titre_tmp = "<font color = \"#ff0000\">Nouveau</font>";
		$idFirstSynonim = 0;
	}
	$tPeres = $motcleGestion->getListFathers();
?>	
<h2>MOT-CLE - <?PHP echo $titre_tmp; ?></h2>
<form name="fmotcle" method="POST" action="index.php">
	<input type="hidden" name="action" value="motcleEnregistrer" />
	<input type="hidden" name="idMotcle" value="<?PHP echo $idMotcle;?>" />
	<input type="hidden" name="valide" value="<?PHP echo $motcle->getValide();?>" />
	<input type="hidden" name="idSynonime" value="<?PHP echo $motcle->getIdSynonime();?>" />
	<input type="hidden" name="nombreTq" value="<?PHP echo $motcle->getNombreTq();?>" />
	<table border=0>
		<?PHP
		if (count($tFils)>0)
		{
		?>
			<tr>
				<td align="right"></td>
				<td><input type="hidden" name="idMotclePere" value="0" /></td>
			</tr>
			<?PHP
		}
		else 
		{
		?>
			<tr>
				<td align="right"><span class="libelleForm">Cat&eacute;gorie</span></td>
				<td>
					<select name="idMotclePere" onChange="javascript:alert('ATTENTION ! Un mot-cle appartenant a une categorie ne peut avoir de sous-categories.');">
						<option value="" <?PHP if ($motcle->getIdPere()=="0") echo "selected";?>></option>
						<?PHP
						foreach ($tPeres as $k=>$v)
						{
							echo "<option value=\"$k\" "; 
							if ($motcle->getIdPere()==$k) echo "selected";
							echo ">$v</option>";
						}
						?>
					</select>
				</td>
			</tr>
			<?PHP
		}
		?>
		<tr>
			<td align="right"><span class="libelleForm">Libell&eacute;</span></td>
			<td><input class="inputInscription" type="text" name="libelle" value="<?PHP echo $motcle->getLibelle();?>"></td>
		</tr>
		<tr><td></td><td></td></tr>
		<tr>
			<td align="right"><span class="libelleForm">Synonimes</span></td>
			<td></td>
		</tr>
		<?PHP
		//Le mot clé est lié à des synonimes - Ce n'est pas le synonime "premier"
		//On affiche tous les synonimes avec un lien pour retourner sur le premier
		if ($idFirstSynonim!=0  && $idFirstSynonim != $idMotcle) 
		{
			?>
			<tr>
				<td align="right"></td>
				<td bgcolor="grey">
					<span class="libelleForm">
						Cocher la case pour d&eacute;lier le mot-cl&eacute; de ses synonimes<br>
						<input type="checkbox" name="idFirstSynonim" value="<?PHP echo $idFirstSynonim;?>" /> <?PHP echo $motcleGestion->getLibellesSynonims($motcle);?>
						<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?action=motcleFormulaire&idMotcle=<?PHP echo $idFirstSynonim;?>" class="motCleLien">Modifier la liste de synonimes</a>
					</span>
				</td>
			</tr>
			<?PHP
		}
		else if (count($tSynonimes)>0) 
		{
			//Le mot cle est un synonime premier. On permet de supprimer certains de ses synonimes
			?>
			<tr>
				<td align="right"></td>
				<td bgcolor="grey">
					<span class="libelleForm">
						Cocher les cases des synonimes pour les d&eacute;lier<br><?PHP
						foreach ($tSynonimes as $k=>$v)
						{
							echo "<input type=\"checkbox\" name=\"synonime_".$k."\" value=\"".$k."\" /> ".$v." <a href=\"index.php?action=motcleFormulaire&idMotcle=".$k."\" class=\"motCleLien\">Modifier</a><br>";
						}
						?>
					</span>
				</td>
			</tr>
			<?PHP
		}
		?>
		<tr>
			<td align="right"></td>
			<td>
				<span class="libelleForm">
					Saisir les nouveaux synonimes s&eacute;par&eacute;s par des virgules<br>
					<input class="inputInscription" type="text" name="synonimes" value="" />
				</span>
			</td>
		</tr>
		<tr><td></td><td></td></tr>
		<?PHP
		if (count($tFils)>0) 
		{
		?>
			<tr>
				<td align="right"><span class="libelleForm">Sous-cat&eacute;gories</span></td>
				<td bgcolor="grey">
				<?PHP
				foreach ($tFils as $k=>$v)
				{
					echo "<input type=\"checkbox\" name=\"fils_".$k."\" value=\"".$k."\" /> ".$v."<br>";
				}
				?>
				</td>
			</tr>
			<?PHP
		}
		?>
		<tr>
			<td colspan="2" align="right">
				<?PHP if ( $motcle->getValide() == 0 && ( ($idMotcle!="" && $_SESSION['motcleModifier'] == 1) || ($idMotcle=="" && $_SESSION['motcleAjouter'] == 1) ) ) { ?><input type="button" value="Enregistrer et Valider" onclick="javascript:document.fmotcle.valide.value=1;verifie_formulaire_motcle();"><?PHP } ?>
				<?PHP if ( ($idMotcle!="" && $_SESSION['motcleModifier'] == 1) || ($idMotcle=="" && $_SESSION['motcleAjouter'] == 1) ) { ?><input type="button" value="Enregistrer" onclick="javascript:verifie_formulaire_motcle();"><?PHP } ?>
				<?PHP if ($idMotcle!="" && $_SESSION['motcleSupprimer'] == 1) { ?><input type="button" value="Supprimer" onclick="javascript:formulaire_supprimer_motcle();"><?PHP } ?>
			</td>	
		</tr>						
	</table>			
</form>