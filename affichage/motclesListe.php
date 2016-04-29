<h2>Mots cl&eacute;s</h2>
<?PHP
if ($_SESSION['motcleConsulter'] == 1)
{
	if (isset($_POST["rechValide"]) ) $rechValide=$_POST["rechValide"]; else if (isset($_GET["rechValide"])) $rechValide=$_GET["rechValide"]; else  $rechValide="";
	?>
	<form name="frecherche" action="index.php" method="post">
		<input type="hidden" name="action" value="motclesListe"/>
		<select name ="rechValide">
			<option value = "" <?PHP if ($rechValide=="") echo "selected";?>>Tous</option>
			<option value = "0" <?PHP if ($rechValide=="0") echo "selected";?>>A valider</option>
			<option value = "1"<?PHP if ($rechValide=="1") echo "selected";?>>Valide</option>
		</select>
		<input type="submit" name="envoi" value="envoyer"/>
	</form>
	<table width="100%" cellpadding="2" border="0">
		<tr>
			<td width="50" valign="top" height="0"></td><td valign="top"></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">
				<?PHP if ($rechValide=="") {?> Les mots-cl&eacute;s non valid&eacute;s sont affich&eacute;s en <font color="#ff0000">rouge</font>. <?PHP }?>
				<br><br><?PHP if ($_SESSION['motcleAjouter'] == 1) echo "<a href=\"index.php?action=motcleFormulaire&idMotcle=&idMotclePere=0\" class=\"motCleLien\">Ajouter un mot-cl&eacute;</a>";?>
			</td>
		</tr>
			<?php
			$motcleGestion = new MotcleGestion($BDD);
			if ($rechValide!="") 
			{
				$listeMotcles1 = $motcleGestion->getList($rechValide);
				$font="";
			}
			else 
			{
				$listeMotcles1 = $motcleGestion->getListByIdPere(0, $rechValide);
				$font="#ff0000";
			}
			foreach ($listeMotcles1 as $idMotcle1=>$motcle1 )
			{
				if ($motcle1->getValide()==0) $fontInvalide=$font; else $fontInvalide="";
				$libelle = "<font color=\"".$fontInvalide."\">".$motcle1->getLibelle()."</font> (<span class=\"motCleLien\">".$motcle1->getNombreTq();
				if ($motcle1->getNombreTq()>1) $libelle .= " sujets li&eacute;s"; else $libelle .= " sujet li&eacute;";
				$libelle .="</span>)";
				if ($_SESSION['motcleModifier'] == 1) $libelle .= " - <a href=\"index.php?action=motcleFormulaire&idMotcle=".$idMotcle1."\" class=\"motCleLien\">Modifier</a>";
				if ($_SESSION['motcleAjouter'] == 1) $libelle .= " - <a href=\"index.php?action=motcleFormulaire&idMotclePere=".$idMotcle1."\" class=\"motCleLien\">Ajouter un fils</a>";
				?>
				<tr>
					<td valign="top" colspan="2"><?PHP echo $libelle; ?></td>
				</tr>
				<?PHP
				if ($rechValide=="")
				{
				?>
					<tr>
						<td valign="top"></td>
						<td valign="top">
							<table width="100%" cellpadding="2" border="0">
								<tr>
									<td width="50" valign="top" height="0"></td><td valign="top"></td>
								</tr>						
								<?php
								$listeMotcles2 = $motcleGestion->getListByIdPere($idMotcle1, $rechValide);
								foreach ($listeMotcles2 as $idMotcle2=>$motcle2 )
								{
									$libelle = "<font color=\"".$fontInvalide."\">".$motcle2->getLibelle()."</font> (<span class=\"motCleLien\">".$motcle2->getNombreTq();
									if ($motcle2->getNombreTq()>1) $libelle .= " sujets li&eacute;s"; else $libelle .= " sujet li&eacute;";
									$libelle .="</span>)";
									if ($_SESSION['motcleModifier'] == 1) $libelle .= " - <a href=\"index.php?action=motcleFormulaire&idMotcle=".$idMotcle2."\" class=\"motCleLien\">Modifier</a>";
									?>
									<tr>
										<td valign="top" colspan="2"><?PHP echo $libelle; ?></td>
									</tr>
									<?PHP
								}
								?>
							</table>
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