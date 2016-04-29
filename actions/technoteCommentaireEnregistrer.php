<?PHP
if(isset($_POST['id_commentaire_pere']) ) 
{
	if ( $_SESSION['commentaireAjouter']   )
	{
		$contenu = "contenuCommentaire".$_POST['id_commentaire_pere'];

		$commentaireGestion = new CommentaireGestion($BDD);
		$tvaleurs = array("id_commentaire" => "", "id_membre" => $_SESSION['id_membre'], "id_pere" => $_POST['id_commentaire_pere'], "contenu" => $_POST[$contenu], "id_techquestion" => $_POST['id_techquestion'], "date_creation" => date('Y-m-d H:i:s'));
		echo $tvaleurs['date_creation'];
		$commentaire = new Commentaire($tvaleurs);
		$commentaireGestion->save($commentaire);
	}
	else $errorMessageJs = "Droit inexistant ! ";
}
else $errorMessageJs = "Erreur identifiant ! ";
$action = "technoteConsultation";
?>