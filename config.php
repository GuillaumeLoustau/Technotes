<?PHP
define('BDD_HOST',"localhost");
define('BDD_NAME',"technotes");
define('BDD_USER',"root");
define('BDD_PWD',"");
	
$BDD = new PDO("mysql:host=".BDD_HOST.";dbname=".BDD_NAME.";charset=utf8", BDD_USER, BDD_PWD);

?>