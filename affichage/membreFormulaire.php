<?PHP
if (isset($_POST['id_membre'])) $id_membre=$_POST['id_membre']; else if (isset($_GET['id_membre'])) $id_membre=$_GET['id_membre']; else $id_membre="";
if ($id_membre!="") 
{
	$membreGestion = new MembreGestion($BDD);
	$membre = $membreGestion->getOne($id_membre);
	?>	
	<h2>COMPTE - <?PHP echo $membre->getPseudo(); ?></h2>
	<form name="fmembre" method="POST" action="index.php">
		<input type="hidden" name="action" value="membreEnregistrer" />
		<input type="hidden" name="id_membre" value="<?PHP echo $id_membre;?>" />
		<table border=0>
			<tr>
				<td align="right"><span class="libelleForm">Email</span></td>
				<td><?PHP echo $membre->getEmail();?></td>
			</tr>
			<tr><td></td><td></td></tr>
			<tr>
				<td align="right"><span class="libelleForm">Gestion des droits</span></td>
				<td>
					<select name ="idRole">
						<option value="3">Ind&eacute;finis</option>
						<option value="3" <?PHP if ($membre->getIdRole()==3) echo "selected"; ?>>Visiteur</option>
						<option value="2" <?PHP if ($membre->getIdRole()==2) echo "selected"; ?>>Membre</option>
						<option value="1" <?PHP if ($membre->getIdRole()==1) echo "selected"; ?>>Administrateur</option>
					</select>
				</td>
			</tr>
			<tr><td></td><td></td></tr>
			<tr>
				<td colspan="2" align="right">
					<?PHP if ($_SESSION["membreModifier"]==1) { ?><input type="button" value="Enregistrer" onclick="javascript:verifie_formulaire_membre();"><?PHP } ?>
					<?PHP if ($_SESSION["membreSupprimer"]==1) { ?><input type="button" value="Supprimer" onclick="javascript:formulaire_supprimer_membre();"><?PHP } ?>
				</td>	
			</tr>						
		</table>			
	</form>
<?PHP	
}
?>