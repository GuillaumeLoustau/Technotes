<?PHP
	if(isset($_POST['id_techquestion'])  && $_POST['id_techquestion'] !="" ) 
	{
		if ( $_SESSION['technoteSupprimer']  == 1 || ($_SESSION['technoteAjouter'] == 1 &&  $_SESSION['id_membre'] == $_POST['idAuteur']  ) )
		{
			$techquestionGestion = new TechquestionGestion($BDD);
			$techquestionGestion->delete($_POST['id_techquestion']);
		}
		else $errorMessageJs = "Droit de suppression inexistant ! ";
	}
	else $errorMessageJs = "Erreur identifiant ! ";
	$action = "technotesListe";
?>