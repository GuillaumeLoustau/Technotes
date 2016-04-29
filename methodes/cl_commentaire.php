<?PHP
class Commentaire {

	protected 	$id_commentaire,
				$id_pere,
				$contenu, 
				$id_techquestion,
				$id_membre,
				$date_creation;

	function __construct($tvaleurs) 
	{
		if (!empty($tvaleurs)) 
		{
			$this->setIdCommentaire($tvaleurs["id_commentaire"]);
			$this->setIdPere($tvaleurs["id_pere"]);
			$this->setContenu($tvaleurs["contenu"]);
			$this->setIdTechquestion($tvaleurs["id_techquestion"]);
			$this->setIdMembre($tvaleurs["id_membre"]);
			$this->setDateCreation($tvaleurs["date_creation"]);
		}
		else
		{
			$this->setIdCommentaire("");
			$this->setIdPere(0);
			$this->setContenu("");
			$this->setIdTechquestion("");
			$this->setIdMembre("");
			$this->setDateCreation("");
		}
	}

	/**
	* Methode permettant de savoir si l'objet est nouveau
	* @return bool
	*/
	public function isNew()
	{
		return empty($this->id_commentaire);
	}

	/**
	* Methode verifiant la validite de l'objet avant un enregistrement
	* @return void
	*/
	public function isValid()
	{
		if(empty($this->id_pere)) $this->id_pere = 0 ;
		if(!empty($this->contenu)) $this->contenu = trim (preg_replace('/\s+/', ' ', $this->contenu) );
		if(empty($this->id_techquestion)) $this->id_techquestion = 0;
		if(empty($this->id_membre))$this->id_membre = 0;
	}

	// SETTERS //
	public function setIdCommentaire($id_commentaire)
	{
		$this->id_commentaire = $id_commentaire;
	}
	public function setIdTechquestion($id_techquestion)
	{
		$this->id_techquestion = (int) $id_techquestion;
	}
	public function setContenu($contenu)
	{
		$this->contenu = $contenu;
	}
	public function setIdPere($id_pere)
	{
		$this->id_pere = (int) $id_pere;
	}
	public function setIdMembre($id_membre)
	{
		$this->id_membre = (int) $id_membre;
	}
	public function setDateCreation($date_creation)
	{
		$this->date_creation = $date_creation;
	}
	// GETTERS //
	public function getIdCommentaire()
	{
		return $this->id_commentaire;
	}
	public function getIdTechquestion()
	{
		return $this->id_techquestion;
	}
	public function getContenu()
	{
		return stripslashes($this->contenu);
	}
	public function getIdPere()
	{
		return $this->id_pere;
	}
	public function getIdMembre()
	{
		return $this->id_membre;
	}
	public function getDateCreation()
	{
		return $this->date_creation;
	}
}

class CommentaireGestion {

	protected $BDD;

	function __construct($BDD) 
	{
		$this->BDD = $BDD;
	}
	
	/**
	 * Méthode permettant d'enregistrer un commentaire
	 * la modification d'un commentaire n'est pas autorisé.
	 * @param  $oCommentaire Commentaire 
	 * @see self::add()
	 * @return void
	 */
	public function save(Commentaire $oCommentaire)
	{
		$oCommentaire->isValid();
		$this->add($oCommentaire);
	}

	/**
	 * Méthode permettant d'ajouter un Commentaire
	 * @param $oCommentaire Commentaire 
	 * @return void
	 */
	 protected function add(Commentaire $oCommentaire)
	 {
		$requete = $this->BDD->prepare('INSERT INTO `commentaire` (contenu , id_techquestion , id_pere , id_membre, date_creation) VALUES (:contenu, :idTechquestion , :idPere , :idMembre, :dateCreation)');
		$requete->bindValue(':contenu', $oCommentaire->getContenu());
		$requete->bindValue(':idTechquestion', $oCommentaire->getIdTechquestion());
		$requete->bindValue(':idPere', $oCommentaire->getIdPere());
		$requete->bindValue(':idMembre', $oCommentaire->getIdMembre());
		$requete->bindValue(':dateCreation', $oCommentaire->getDateCreation());
		$requete->execute();
		$oCommentaire->setIdCommentaire($this->BDD->lastInsertId());
	}
	
	/**
	 * Méthode permettant de supprimer un techquestion
	 * @param $id_techquestion int L'identifiant à supprimer
	 * @return void
	 */
	public function delete($id_commentaire)
	{
		$this->BDD->exec('DELETE FROM `commentaire` WHERE id_pere = '.(int)$id_commentaire); 
		$this->BDD->exec('DELETE FROM `commentaire` WHERE id_commentaire = '.(int) $id_commentaire);
	}	
		
	/**
	 * Méthode retournant un commentaire précis
	 * @param $id_commentaire int L'identifiant à récupérer
	 * @return Commentaire le commentaire demandé
	 */
	public function getOne($id_commentaire)
	{
		$resultat = array();
		$requete = $this->BDD->prepare('SELECT * FROM `commentaire` WHERE id_commentaire = :id_commentaire ');
		$requete->bindValue(':id_commentaire', $id_commentaire);
		$requete->execute();
		$resultat = $requete->fetch(PDO::FETCH_ASSOC);
		return new Commentaire($resultat);
	}

}


?>