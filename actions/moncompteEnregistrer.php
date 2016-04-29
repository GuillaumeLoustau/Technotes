<?PHP
if (isset($_SESSION['id_membre']) && $_SESSION['id_membre'] != ""  && $_SESSION['id_membre'] != "0" ) 
{
	if(isset($_POST['id_membre']) && isset($_POST['email']) && isset($_POST['motDePasse']) && isset($_POST['motDePasse2']) && $_POST['email']!="") 
	{
		$membreGestion = new MembreGestion($BDD);
		if (!$membreGestion->isUniqueEmail($_POST['email'], $_SESSION['id_membre']))
		{
			$errorMessageJs = 'Email deja utilise.';
		}
		else 
		{
			$membre = $membreGestion->getOne($_SESSION['id_membre']);
			$membre->setEmail($_POST['email']);
			if ($_POST['motDePasse'] == $_POST['motDePasse2'] && $_POST['motDePasse']!="") $membre->setMotDePasse(md5($_POST['motDePasse']));
			$membreGestion->save($membre);
			$IdMembre=$membre->getIdMembre();
		}
	}
	else $errorMessageJs = 'Droit insuffisant. ';
} 
else $errorMessageJs = 'Connexion requise. ';
$action = "moncompteFormulaire";
?>