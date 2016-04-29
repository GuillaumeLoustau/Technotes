<?PHP
	if(isset($_POST['idMotcle']) ) 
	{
		if ( $_SESSION['motcleSupprimer']  == 1 )
		{
			$motcleGestion = new MotcleGestion($BDD);
			$motcleGestion->delete($_POST['idMotcle']);
		}
		else $errorMessageJs = "Droit de suppression inexistant ! ";
	}
	else $errorMessageJs = "Erreur identifiant ! ";
	$action = "motclesListe";
?>