<?PHP
	$id_techquestion="";
	if(!isset($_GET['id_techquestion']) && !isset($_POST['id_techquestion']))
	{
		require("affichage/pageAbsente.php");
	}
	else if (isset($_POST['id_techquestion'])) $id_techquestion=$_POST['id_techquestion'];
	else $id_techquestion=$_GET['id_techquestion'];
		
	if ($id_techquestion!="")
	{
		$techquestionGestion = new TechquestionGestion($BDD);
		$techquestion = $techquestionGestion->getOne($id_techquestion);
		$motcleGestion = new MotcleGestion($BDD);
		$motcles = $motcleGestion->getStringMotcles($id_techquestion);
		$membreGestion = new MembreGestion($BDD);
		$membre = $membreGestion->getOne($techquestion->getIdMembre());
		
		$sql_com = "SELECT c.* , m.pseudo FROM commentaire c, membre m WHERE c.id_membre = m.id_membre AND c.id_pere = 0 AND c.id_techquestion=".$id_techquestion;
		$reponse_com = $BDD->query($sql_com);
		?>
		<h2>Question - <?PHP echo $techquestion->getTitre(); ?></h2>
		<div id ="technote">
		  <form name="fAjCommentaireQuestion" action="index.php" method="post">
			<input type="hidden" name="action" value="questionCommentaireEnregistrer" />
			<input type="hidden" name="id_techquestion" value="<?PHP echo $id_techquestion; ?>" />
			<input type="hidden" name="id_commentaire_pere" value="0" />
			<p>
				Par <span class="auteurTechquestion"><?PHP echo $membre->getPseudo(); ?></span> le <span class="dateCreationTechquestion"><?PHP echo formaterDate($techquestion->getDateCreation()); ?></span>
				<br><span class="motClesTechquestion">Mots cl&eacute;s associés : <?PHP echo $motcles; ?></span>
			</p>
			<div id ="contenuTechnote"><?PHP echo $techquestion->getContenu(); ?></div>
			<p class="lienCommentaire"><a class="lienCommentaire" href="#" onclick="javascript:if (document.getElementById('commentairePere0').style.display == 'none') document.getElementById('commentairePere0').style.display = 'block'; else document.getElementById('commentairePere0').style.display = 'none';"> Commenter</a></p>
			<div id="commentairePere0" style="display:none;text-align:center;">
				<textarea class="commentaire" name="contenuCommentaire0" rows="6" cols="80%"></textarea>
				<input type="button" name="ok0" value="Envoyer" onclick="javascript : if(document.fAjCommentaireQuestion.contenuCommentaire0.value=='') alert('Veuillez saisir un commentaire !!'); else{document.fAjCommentaireQuestion.id_commentaire_pere.value=0; document.fAjCommentaireQuestion.submit();}">
			</div> <!-- #commentairePere0 -->
			<div id ="commentaires">
			<?PHP
				while($donnees_com = $reponse_com->fetch())
				{
					$sql_ss_com = "SELECT c.* , m.pseudo FROM commentaire c, membre m WHERE c.id_membre = m.id_membre AND c.id_pere = ".$donnees_com['id_commentaire']." AND c.id_techquestion=".$id_techquestion;
					$reponse_ss_com = $BDD->query($sql_ss_com);
					?>
					<!-- <div class ="commentaire">-->
						<p>
							<span class="auteurCommentaire"><?PHP echo $donnees_com['pseudo']; ?></span> - <span class="dateCreationCommentaire"><?PHP echo formaterDateH($donnees_com['date_creation']); ?></span>
							- <?PHP echo $donnees_com['contenu']; ?>
							<?PHP
							while($donnees_ss_com = $reponse_ss_com->fetch())
							{
							?>
								<br><span class="auteurCommentaire"><?PHP echo $donnees_ss_com['pseudo']; ?></span> - <span class="dateCreationCommentaire"><?PHP echo formaterDateH($donnees_ss_com['date_creation']); ?></span>
								- <?PHP echo $donnees_ss_com['contenu']; ?>
								<?PHP
							}
							?>
							<p class="lienCommentaire"><a class="lienCommentaire" href="#" onclick="javascript:if (document.getElementById('commentairePere<?PHP echo $donnees_com['id_commentaire']; ?>').style.display == 'none') document.getElementById('commentairePere<?PHP echo $donnees_com['id_commentaire']; ?>').style.display = 'block'; else document.getElementById('commentairePere<?PHP echo $donnees_com['id_commentaire']; ?>').style.display = 'none';"> R&eacute;pondre</a></p>
							<div id="commentairePere<?PHP echo $donnees_com['id_commentaire']; ?>" style="display:none;text-align:center;">
								<textarea class="commentaire" name="contenuCommentaire<?PHP echo $donnees_com['id_commentaire']; ?>"></textarea>
								<input type="button" name="ok<?PHP echo $donnees_com['id_commentaire']; ?>" value="Envoyer" onclick="javascript : if(document.fAjCommentaireQuestion.contenuCommentaire<?PHP echo $donnees_com['id_commentaire']; ?>.value=='') alert('Veuillez saisir un commentaire !!'); else{document.fAjCommentaireQuestion.id_commentaire_pere.value=<?PHP echo $donnees_com['id_commentaire']; ?>; document.fAjCommentaireQuestion.submit();}">
							</div> <!-- #commentairePere<?PHP echo $donnees_com['id_commentaire']; ?> -->
						</p>
					<!--</div>-->
					<?PHP
				}	
				?>
			</div> <!-- #commentaire -->
			<p></p>
		  </form>
		</div> <!-- #technote -->
		<?PHP
	}
	?>
	