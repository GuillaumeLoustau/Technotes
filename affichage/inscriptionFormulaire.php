	<h2>INSCRIPTION</h2>
			<form name="finscription" method="POST" action="index.php">
				<table border=0>
					<tr>
						<td align="right"><span class="libelleForm">Email</span></td>
						<td><input class="inputInscription" type="text" name="email" value=""></td>
					</tr>
					<tr>
						<td align="right"><span class="libelleForm">Pseudo</span></td>
						<td><input class="inputInscription" type="text" name="pseudo" value=""></td>
					</tr>
					<tr>
						<td align="right"><span class="libelleForm">Mot de passe</span></td>
						<td><input class="inputInscription" type="password" name="motDePasse" value=""></td>
					</tr>
					<tr>
						<td align="right"><span class="libelleForm">Mot de passe Confirmation</span></td>
						<td><input class="inputInscription" type="password" name="motDePasse2" value=""></td>
					</tr>
					<tr>
						<td colspan="2" align="right">
							<input type="button" value="OK" onclick="javascript:verifie_formulaire_inscription('');">
							<input type="hidden" name="action" value="inscriptionEnregistrer">
						</td>	
					</tr>						
				</table>			
			</form>