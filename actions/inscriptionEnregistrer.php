<?PHP
	session_destroy();
	session_start();

	if(isset($_POST['email']) && isset($_POST['motDePasse']) && isset($_POST['pseudo']) && $_POST['email']!="" && $_POST['motDePasse']!="" && $_POST['pseudo']!="") 
	{
		$membreGestion = new MembreGestion($BDD);
		if (!$membreGestion->isUnique($_POST['email'], $_POST['pseudo']))
		{
			$errorMessageJs = 'Email ou pseudo existant en base. Veuillez recommencer.';
		}
		else 
		{
			$tvaleurs = array("id_membre" => "", "email" => $_POST['email'],  "pseudo" => $_POST['pseudo'],"mot_de_passe" => md5($_POST['motDePasse']), "id_role" => 2, "date_creation" => date('Y-m-d H:i:s'));
			$membre = new Membre($tvaleurs);
			$membreGestion->save($membre);
			$IdMembre=$membre->getIdMembre();
			if ($IdMembre!="")
			{
				$message = "Bonjour, vous &egrave;tes inscrit au serveur de technotes. <br>Votre pseudo : ".$_POST['pseudo']."<br>Votre mot de passe : ".$_POST['motDePasse']."<br>A bient&ocirc;t!";
				envoyer_mail($_POST['email'], "admin@technotes.fr", "Inscription au Serveur de technotes", $message);
				$_SESSION['id_membre'] = $IdMembre;
				$_SESSION['id_role'] = 2;
				$_SESSION['pseudo'] = $_POST['pseudo'];
				definirDroit($BDD, 2);
			}
			else
			{
				$errorMessageJs = 'Echec lors de votre inscritpion. Veuillez recommencer. ';
			}
		}
	}
?>