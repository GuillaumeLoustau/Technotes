<?PHP
if(isset($_POST['idMotcle']) && isset($_POST['libelle']) && isset($_POST['idMotclePere']) ) 
{

	if ( ($_SESSION['motcleAjouter']  == 1 && $_POST['idMotcle'] == "" ) || ($_SESSION['motcleModifier'] == 1 &&  $_POST['idMotcle'] != ""  ) )
	{
		$motcleGestion = new MotcleGestion($BDD);

		$idMotcle=$_POST['idMotcle']; 
				
		//On recherche si le mot clé existe déjà  
		$idMotcle_tmp = $motcleGestion->isAlreadyExisting($_POST['libelle'], $idMotcle);
		//si le mot clé existe déjà
		if ($idMotcle_tmp!=0) 
		{	
			$_POST['idMotcle'] = $idMotcle_tmp;
			$errorMessageJs = 'Le mot cle existe deja. Verifier sa conformite. ';
		}
		else
		{
			$tvaleurs = array("id_motcle" => $idMotcle, "libelle" => $_POST['libelle'],  "valide" => $_POST['valide'], "id_pere" => $_POST['idMotclePere'], "id_synonime" => $_POST['idSynonime'], "nombre_tq" => $_POST['nombreTq'], "date_creation" => date('Y-m-d H:i:s'));
			$motcle = new Motcle($tvaleurs);
			$motcleGestion->save($motcle);
			$idMotcle = $motcle->getIdMotcle();
			
			//Pour réafficher le formulaire du mot cle y compris s'il vient d'être créé
			$_POST['idMotcle'] = $idMotcle;

			//if (isset($_POST['idFirstSynonim'])) Le mot clé est lié à des synonimes - Ce n'est pas le synonime "premier"
			if (isset($_POST['idFirstSynonim'])) $motcleGestion->unlinkSynonim($motcle, $_POST['idFirstSynonim']);
			
			//Le mot cle est un synonime premier. On permet de supprimer certains de ses synonimes
			$tSynonimesASupprimer = $motcleGestion->getListSynonims($idMotcle);
			if ($tSynonimesASupprimer)
			{
				foreach ($tSynonimesASupprimer as $k=>$v)
				{
					$checked = "synonime_".$k;
					if (isset($_POST[$checked])) $motcleGestion->unlinkSynonim($motcle, $_POST[$checked]);
				}
			}
			
			$tSynonimesAAjouter = explode(",", $_POST['synonimes']);
			if ($tSynonimesAAjouter)
			{
				foreach ($tSynonimesAAjouter as $v)
				{
					$motcleGestion->addSynonim($motcle, $v);
				}
			}
			$tFilsASupprimer = $motcleGestion->getListChildren($idMotcle);
			if ($tFilsASupprimer)
			{
				foreach ($tFilsASupprimer as $k=>$v)
				{
					$checked = "fils_".$k;
					if (isset($_POST[$checked])) $motcleGestion->unlinkChild($_POST[$checked]);
				}
			}
		}
	}
	else $errorMessageJs = "Droit inexistant ! ";
}
else $errorMessageJs = "Erreur identifiant ! ";
$action = "motcleFormulaire";
?>