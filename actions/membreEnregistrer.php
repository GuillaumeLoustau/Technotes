<?PHP
if(isset($_POST['id_membre']) ) 
{
	if ( $_SESSION['membreModifier'] == 1 &&  $_POST['id_membre'] != ""   )
	{
		$membreGestion = new MembreGestion($BDD);
		$membre = $membreGestion->getOne($_POST['id_membre']);
		$membre->setIdRole($_POST['idRole']);
		$membreGestion->save($membre);
	}
	else $errorMessageJs = 'Droit insuffisant. ';
} 
else $errorMessageJs = 'Erreur identifiant. ';
$action = "membreFormulaire";
?>