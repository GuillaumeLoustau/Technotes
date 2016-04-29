<?PHP
	if(isset($_POST['email']) && isset($_POST['motDePasse'])) 
	{
		$membreGestion = new MembreGestion($BDD);
		$membre = $membreGestion->getOneByEmailMdp($_POST['email'], $_POST['motDePasse']);
		if ($membre->getIdMembre())
		{
			session_destroy();
			session_start();
			$_SESSION['id_membre'] = $membre->getIdMembre();
			$_SESSION['id_role'] = $membre->getIdRole();
			$_SESSION['pseudo'] = $membre->getPseudo();
			definirDroit($BDD, $membre->getIdRole());
		}
		else
		{
			$errorMessageJs = 'Utilisateur inexistant';
		}
 	}

?>