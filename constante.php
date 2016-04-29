<?PHP
	if(isset($_SESSION['id_membre'])) 
	{
		define('ID_MEMBRE',$_SESSION['id_membre']);
		define('ID_ROLE',$_SESSION['id_role']);
		define('PSEUDO',$_SESSION['pseudo']);
	}
	else {
		define('ID_MEMBRE',0);
		define('ID_ROLE',3);
		define('PSEUDO',"Visiteur");
	}
	
	if(!isset($_SESSION['membreConsulter'])) 
	{	
		definirDroit($BDD, ID_ROLE);
	}
?>