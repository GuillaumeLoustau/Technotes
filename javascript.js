function verifie_formulaire_connexion() {
	ok=1;
	if(document.fconnexion.email.value==''){
		ok=0;
		alert('Veuillez renseigner votre email !');
	}
	else if(document.fconnexion.motDePasse.value==''){
		ok=0;
		alert('Veuillez renseigner votre mot de passe !');
	}
	if(ok=='1'){document.fconnexion.submit();}
}

function verifie_formulaire_inscription() {
	ok=1;
	if(document.finscription.email.value==''){
		ok=0;
		alert('Veuillez renseigner votre email !');
	}
	else if(document.finscription.pseudo.value==''){
		ok=0;
		alert('Veuillez renseigner votre pseudo !');
	}
	else if(document.finscription.motDePasse.value==''){
		ok=0;
		alert('Veuillez renseigner votre mot de passe !');
	}
	else if(document.finscription.motDePasse2.value==''){
		ok=0;
		alert('Veuillez confirmer votre mot de passe !');
	}	
	else if(document.finscription.motDePasse2.value!=document.finscription.motDePasse.value){
		ok=0;
		document.finscription.motDePasse.value="";
		document.finscription.motDePasse2.value="";
		alert('Veuillez confirmer votre mot de passe !');
	}
	if(ok=='1'){document.finscription.submit();}
}

function verifie_formulaire_technote() {
	ok=1;
	if(document.ftechnote.titre.value==''){
		ok=0;
		alert('Veuillez renseigner le titre !');
	}
	if(ok=='1'){document.ftechnote.action.value="technoteEnregistrer";document.ftechnote.submit();}
}

function formulaire_supprimer_technote() {
	if (confirm("Supprimer le technote ?")) { 
		document.ftechnote.action.value="technoteSupprimer";
		document.ftechnote.submit();
	}
}
function verifie_formulaire_question() {
	ok=1;
	if(document.fquestion.titre.value==''){
		ok=0;
		alert('Veuillez renseigner le titre !');
	}
	if(ok=='1'){document.fquestion.action.value="questionEnregistrer";document.fquestion.submit();}
}

function formulaire_supprimer_question() {
	if (confirm("Supprimer la question ?")) { 
		document.fquestion.action.value="questionSupprimer";
		document.fquestion.submit();
	}
}

function verifie_formulaire_motcle() {
	ok=1;
	if(document.fmotcle.libelle.value==''){
		ok=0;
		alert('Veuillez renseigner un libelle !');
	}
	if(ok=='1'){document.fmotcle.action.value="motcleEnregistrer";document.fmotcle.submit();}
}
function formulaire_supprimer_motcle() {
	if (confirm("Supprimer le mot cle ?")) { 
		document.fmotcle.action.value="motcleSupprimer";
		document.fmotcle.submit();
	}
}
function verifie_formulaire_moncompte() {
	ok=1;
	if(document.fmoncompte.email.value==''){
		ok=0;
		alert('Veuillez renseigner votre email !');
	}
	else if(document.fmoncompte.motDePasse2.value!=document.fmoncompte.motDePasse.value){
		ok=0;
		document.fmoncompte.motDePasse.value="";
		document.fmoncompte.motDePasse2.value="";
		alert('Veuillez confirmer votre mot de passe !');
	}
	if(ok=='1'){document.fmoncompte.submit();}
}

function verifie_formulaire_membre() {
	ok=1;
	if(ok=='1'){document.fmembre.action.value="membreEnregistrer";document.fmembre.submit();}
}
function formulaire_supprimer_membre() {
	if (confirm("Supprimer le membre ?")) { 
		document.fmembre.action.value="membreSupprimer";
		document.fmembre.submit();
	}
}