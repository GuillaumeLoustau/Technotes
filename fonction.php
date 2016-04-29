<?php
function envoyer_mail($to, $email_from, $subject, $message) {
	$message=stripslashes($message);

	$headers = "From: <$email_from>\n";
	$headers .= "X-Sender: <$email_from>\n";
	$headers .= "X-Mailer: PHP\n";
	$headers .= "X-Priority: 3\n";
	$headers .= "Return-Path: <$email_from>\n";

	$headers .= "MIME-version: 1.0\n";
	$headers .= "Content-type: multipart/mixed; ";
	$headers .= "boundary=\"Message-Boundary\"\n";
	$headers .= "Content-transfer-encoding: 7BIT\n";
	$body= "--Message-Boundary\n";
	$body.= "Content-Type: text/html; charset=ISO-8859-1\n";
	$body.= "Content-Transfer-Encoding: 7bit\n\n";
	$body.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
	$body.= "<html>\n";
	$body.= "<head>\n";
	$body.= "<meta content=\"text/html;charset=ISO-8859-1\" http-equiv=\"Content-Type\">\n";
	$body.= "</head>\n";
	$body.= "<body bgcolor=\"#ffffff\" text=\"#000000\">\n";
	$body.="$message";
	$body.="</body>\n</html>\n\n";
	//mail("$to", "$subject", "$body", "$headers");
}

function formaterDate($dateSql) {
	return date('d/m/Y', strtotime($dateSql));
}

function formaterDateH($dateSql) {
	return date('d/m/Y H:i:s', strtotime($dateSql));
}

function definirDroit($BDD, $id_role) {
	$requete2 = $BDD->prepare('SELECT * FROM `role_action` where id_role = :idRole and id_action = :idAction');
	$requete2->bindValue(':idRole', $id_role);
	$requete2->bindValue(':idAction', 1);
	$requete2->execute();		
	$droits=$requete2->fetch(PDO::FETCH_ASSOC);
	$_SESSION['membreConsulter'] = $droits['consulter'];
	$_SESSION['membreAjouter'] = $droits['ajouter'];
	$_SESSION['membreModifier'] = $droits['modifier'];
	$_SESSION['membreSupprimer'] = $droits['supprimer'];
	$requete2->closeCursor();
	$requete2 = $BDD->prepare('SELECT * FROM `role_action` where id_role = :idRole and id_action = :idAction');
	$requete2->bindValue(':idRole', $id_role);
	$requete2->bindValue(':idAction', 2);
	$requete2->execute();		
	$droits=$requete2->fetch(PDO::FETCH_ASSOC);	
	$_SESSION['technoteConsulter'] = $droits['consulter'];
	$_SESSION['technoteAjouter'] = $droits['ajouter'];
	$_SESSION['technoteModifier'] = $droits['modifier'];
	$_SESSION['technoteSupprimer'] = $droits['supprimer'];
	$requete2->closeCursor();
	$requete2 = $BDD->prepare('SELECT * FROM `role_action` where id_role = :idRole and id_action = :idAction');
	$requete2->bindValue(':idRole', $id_role);
	$requete2->bindValue(':idAction', 3);
	$requete2->execute();	
	$droits=$requete2->fetch(PDO::FETCH_ASSOC);	
	$_SESSION['questionConsulter'] = $droits['consulter'];
	$_SESSION['questionAjouter'] = $droits['ajouter'];
	$_SESSION['questionModifier'] = $droits['modifier'];
	$_SESSION['questionSupprimer'] = $droits['supprimer'];
	$requete2->closeCursor();
	$requete2 = $BDD->prepare('SELECT * FROM `role_action` where id_role = :idRole and id_action = :idAction');
	$requete2->bindValue(':idRole', $id_role);
	$requete2->bindValue(':idAction', 4);
	$requete2->execute();	
	$droits=$requete2->fetch(PDO::FETCH_ASSOC);	
	$_SESSION['motcleConsulter'] = $droits['consulter'];
	$_SESSION['motcleAjouter'] = $droits['ajouter'];
	$_SESSION['motcleModifier'] = $droits['modifier'];
	$_SESSION['motcleSupprimer'] = $droits['supprimer'];
	$requete2->closeCursor();
	$requete2 = $BDD->prepare('SELECT * FROM `role_action` where id_role = :idRole and id_action = :idAction');
	$requete2->bindValue(':idRole', $id_role);
	$requete2->bindValue(':idAction', 5);
	$requete2->execute();	
	$droits=$requete2->fetch(PDO::FETCH_ASSOC);	
	$_SESSION['commentaireConsulter'] = $droits['consulter'];	
	$_SESSION['commentaireAjouter'] = $droits['ajouter'];
	$_SESSION['commentaireModifier'] = $droits['modifier'];
	$_SESSION['commentaireSupprimer'] = $droits['supprimer'];			
	$requete2->closeCursor();
}
?>