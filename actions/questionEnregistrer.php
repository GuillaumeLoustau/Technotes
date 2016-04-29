<?PHP
if(isset($_POST['id_techquestion']) ) 
{
	if ( ($_SESSION['questionAjouter']  == 1 && $_POST['id_techquestion'] == "" ) || ($_SESSION['questionModifier'] == 1 &&  $_POST['id_techquestion'] != ""  ) || ( $_POST['id_techquestion'] != "" &&  $_SESSION['questionAjouter'] == 1 &&  $_SESSION['id_membre'] == $_POST['idAuteur'] ) )
	{
		$id_techquestion=$_POST['id_techquestion']; 

		$techquestionGestion = new TechquestionGestion($BDD);
		
		$tvaleurs = array("id_techquestion" => $id_techquestion, "titre" => $_POST['titre'], "contenu" => $_POST['contenu'], "statut" => $_POST["statut"], "id_type" => $_POST['idType'], "id_membre" => $_POST['idAuteur']);
		
		if ( $id_techquestion != "" )
		{	
			$tvaleurs["date_creation"]=$_POST['dateCreation'];
		}
		else 
		{
			$tvaleurs["date_creation"]=date('Y-m-d H:i:s');
		}
		$techquestion = new Techquestion($tvaleurs);
		$techquestionGestion->save($techquestion);
		
		$id_techquestion = $techquestion->getIdTechquestion(); 
		$_POST['id_techquestion'] = $id_techquestion;

		if ( $id_techquestion!="")
		{
			$motcleGestion = new MotcleGestion($BDD);
			$motcles_tmp = $motcleGestion->linkMotclesToTechquestion($id_techquestion, $_POST['motcles']);
		}
	}
	else $errorMessageJs = "Droit inexistant ! ";
}
else $errorMessageJs = "Erreur identifiant ! ";
$action = "questionFormulaire";
?>
