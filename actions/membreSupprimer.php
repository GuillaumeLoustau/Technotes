<?PHP
	if(isset($_POST['id_membre']) ) 
	{
		if ( $_SESSION['membreSupprimer']  == 1 )
		{
			$membreGestion = new MembreGestion($BDD);
			$membreGestion->delete($_POST['id_membre']);
		}
		else $errorMessageJs = "Droit de suppression inexistant ! ";
	}
	else $errorMessageJs = "Erreur identifiant ! ";
	$action = "membresListe";
?>