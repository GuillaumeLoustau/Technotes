<?PHP
if (isset($_SESSION['id_membre']) && $_SESSION['id_membre'] != ""  && $_SESSION['id_membre'] != "0") 
{
	$membreGestion = new MembreGestion($BDD);
	$membre = $membreGestion->getOne($_SESSION['id_membre']);
	?>	
	<h2>MON COMPTE - <?PHP echo $membre->getPseudo(); ?></h2>
	<form name="fmoncompte" method="POST" action="index.php">
		<input type="hidden" name="action" value="moncompteEnregistrer" />
		<input type="hidden" name="id_membre" value="<?PHP echo $_SESSION['id_membre'];?>" />
		<table border=0>
			<tr>
				<td align="right"><span class="libelleForm">Email</span></td>
				<td><input class="inputInscription" type="text" name="email" value="<?PHP echo $membre->getEmail();?>"></td>
			</tr>
			<tr><td></td><td></td></tr>
			<tr>
				<td align="right"><span class="libelleForm">Mot de passe</span></td>
				<td><input class="inputInscription" type="password" name="motDePasse" value=""></td>
			</tr>
			<tr><td></td><td></td></tr>
			<tr>
				<td align="right"><span class="libelleForm">Confirmation du mot de passe</span></td>
				<td><input class="inputInscription" type="password" name="motDePasse2" value=""></td>
			</tr>
			<tr><td></td><td></td></tr>
			<tr>
				<td colspan="2" align="right">
					<input type="button" value="Enregistrer" onclick="javascript:verifie_formulaire_moncompte();">
				</td>	
			</tr>						
		</table>			
	</form>
<?PHP	
}
?>