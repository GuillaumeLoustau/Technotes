<?PHP
class Membre {

	protected 	$id_membre,
				$email,
				$pseudo,
				$mot_de_passe,
				$id_role,
				$date_creation;

	function __construct($tvaleurs) 
	{
		if (!empty($tvaleurs)) 
		{
			$this->setIdMembre($tvaleurs["id_membre"]);
			$this->setEmail($tvaleurs["email"]);
			$this->setPseudo($tvaleurs["pseudo"]);
			$this->setMotDePasse($tvaleurs["mot_de_passe"]);
			$this->setIdRole($tvaleurs["id_role"]);
			$this->setDateCreation($tvaleurs["date_creation"]);
		}
		else
		{
			$this->setIdMembre("");
			$this->setEmail("");
			$this->setPseudo("Visiteur");
			$this->setMotDePasse("");
			$this->setIdRole(3);
			$this->setDateCreation("");
		}
	}

	/**
	* Methode permettant de savoir si l'objet est nouveau
	* @return bool
	*/
	public function isNew()
	{
		return empty($this->id_membre);
	}
	
	/**
	* Methode verifiant la validite de l'objet avant un enregistrement
	* @return void
	*/
	public function isValid()
	{
		if (empty($this->id_role)) $this->id_role = 3;
	}

	// SETTERS //
	public function setIdMembre($id_membre)
	{
		$this->id_membre = (int) $id_membre;
	}
	public function setEmail($email)
	{
		$this->email = $email;
	}
	public function setPseudo($pseudo)
	{
		$this->pseudo = $pseudo;
	}
	public function setMotDePasse($mot_de_passe)
	{
		$this->mot_de_passe = $mot_de_passe;
	}
	public function setIdRole($id_role)
	{
		$this->id_role = (int) $id_role;
	}
	public function setDateCreation($date_creation)
	{
		$this->date_creation = $date_creation;
	}
	// GETTERS //
	public function getIdMembre()
	{
		return $this->id_membre;
	}
	public function getEmail()
	{
		return stripslashes($this->email);
	}
	public function getPseudo()
	{
		return stripslashes($this->pseudo);
	}
	public function getMotDePasse()
	{
		return $this->mot_de_passe;
	}
	public function getIdRole()
	{
		return $this->id_role;
	}
	public function getDateCreation()
	{
		return $this->date_creation;
	}
}

class MembreGestion {

	protected $BDD;

	function __construct($BDD) 
	{
		$this->BDD = $BDD;
	}
	
	/**
	* Methode verifiant l'existence d'un membre avec email et mot de passe à ajouter
	* @return bool
	*/
	public function isUnique($email, $pseudo)
	{
		$requete = $this->BDD->prepare('SELECT id_membre FROM `membre` where email = :email or pseudo = :pseudo');
		$requete->bindValue(':email', $email);
		$requete->bindValue(':pseudo',$pseudo);
		$requete->execute();
		if ($membre = $requete->fetch(PDO::FETCH_ASSOC)) return FALSE;
		else return TRUE;
	}

	/**
	* Methode verifiant l'existence d'un membre avec email 
	* @return bool
	*/
	public function isUniqueEmail($email, $idMembre)
	{
		$requete = $this->BDD->prepare('SELECT id_membre FROM `membre` where email = :email AND id_membre != :idMembre');
		$requete->bindValue(':email', $email);
		$requete->bindValue(':idMembre',$idMembre);
		$requete->execute();
		if ($membre = $requete->fetch(PDO::FETCH_ASSOC)) return FALSE;
		else return TRUE;
	}
	
	/**
	 * Méthode permettant d'enregistrer un membre
	 * @param  $oMembre Membre 
	 * @see self::add()
	 * @see self::modify()
	 * @return void
	 */
	public function save(Membre $oMembre)
	{
		$oMembre->isValid();
		$oMembre->isNew() ? $this->add($oMembre) : $this->update($oMembre);
	}

	/**
	 * Méthode permettant d'ajouter un membre
	 * @param $oMembre Membre 
	 * @return void
	 */
	 protected function add(Membre $oMembre)
	 {
		$requete = $this->BDD->prepare('INSERT INTO `membre` (email, pseudo, mot_de_passe, id_role, date_creation) VALUES (:email, :pseudo, :motDePasse, :idRole, :dateCreation)');
		$requete->bindValue(':email', $oMembre->getEmail());
		$requete->bindValue(':pseudo', $oMembre->getPseudo());
		$requete->bindValue(':motDePasse', $oMembre->getMotDePasse());
		$requete->bindValue(':idRole', $oMembre->getIdRole());
		$requete->bindValue(':dateCreation', $oMembre->getDateCreation());
		$requete->execute();
		$oMembre->setIdMembre($this->BDD->lastInsertId());
	}	
	 
	/**
	 * Méthode permettant de modifier un membre
	 * @param $oMembre Membre 
	 * @return void
	 */
	protected function update(Membre $oMembre)
	{
		$requete = $this->BDD->prepare('UPDATE `membre` SET email = :email, pseudo = :pseudo, mot_de_passe = :motDePasse, id_role = :idRole WHERE id_membre = :idMembre');
		$requete->bindValue(':email', $oMembre->getEmail());
		$requete->bindValue(':pseudo', $oMembre->getPseudo());
		$requete->bindValue(':motDePasse', $oMembre->getMotDePasse());
		$requete->bindValue(':idRole', $oMembre->getIdRole());
        $requete->bindValue(':idMembre', $oMembre->getIdMembre(), PDO::PARAM_INT);
		$requete->execute();
	}
	
	/**
	 * Méthode permettant de supprimer un membre
	 * @param $id_membre int L'identifiant à supprimer
	 * @return void
	 */
	public function delete($id_membre)
	{
		$this->BDD->exec('DELETE FROM `membre` WHERE id_membre = '.(int) $id_membre);
	}	
	
	/**
	 * Méthode retournant un membre précis
	 * @param $id_membre int L'identifiant à récupérer
	 * @return Membre le membre demandé
	 */
	public function getOne($id_membre)
	{
		$resultat = array();
		$requete = $this->BDD->prepare('SELECT * FROM `membre` WHERE id_membre = :idMembre');
		$requete->bindValue(':idMembre', (int) $id_membre, PDO::PARAM_INT);
		$requete->execute();
		$resultat = $requete->fetch(PDO::FETCH_ASSOC);
		return new Membre($resultat);
	}
	
	/**
	 * Méthode retournant un membre précis
	 * @param $email, $motDePasse à récupérer
	 * @return Membre le membre demandé
	 */
	public function getOneByEmailMdp($email, $motDePasse)
	{
		$requete = $this->BDD->prepare('SELECT * FROM `membre` where email = :email and mot_de_passe = :motDePasse');
		$requete->bindValue(':email', $email);
		$requete->bindValue(':motDePasse', md5($motDePasse));
		$requete->execute();
		$resultat = $requete->fetch(PDO::FETCH_ASSOC);
		return new Membre($resultat);
	}	
	
	/**
	 * Méthode renvoyant le nombre de membres total
	 * @return int
	 */
	public function count()
	{
		return $this->BDD->query('SELECT COUNT(id_membre) FROM `membre`')->fetchColumn();
	}
	
	/**
	 * Méthode retournant une liste de membre demandé
	 * @param $debut int Le premier membre à sélectionner
	 * @param $limite int Le nombre de membres à sélectionner
	 * @return array La liste des membres. Chaque entrée est une instance de Membre.
	 */
	 public function getList($debut = -1, $limite = -1) 
	 {
		$listeMembres = array();
		$sql = 'SELECT * FROM `membre` ORDER BY pseudo ASC';
		// On vérifie l'intégrité des paramètres fournis
		if ($debut != -1 || $limite != -1)
		{
			$sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
		}
		$requete = $this->BDD->query($sql);
		while ($tMembre = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$id_membre = $tMembre['id_membre'];
			$listeMembres[$id_membre] = new Membre($tMembre);
		}
		$requete->closeCursor();
		return $listeMembres;
	}

	/**
	 * Méthode retournant une liste de membre auteur
	 * @param $id_type int, le type de techquestion, 1 ou 2 
	 * @return array La liste des membres. Chaque entrée est une instance de Membre.
	 */
	 public function getListAuteurs($id_type) 
	 {
		$listeAuteurs = array();
		$sql = 'SELECT distinct m.* FROM `membre` m, `techquestion` t WHERE m.id_membre = t.id_membre AND t.id_type = '.$id_type.' ORDER BY m.pseudo ASC';
		$requete = $this->BDD->query($sql);
		while ($tAuteur = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$id_auteur = $tAuteur['id_membre'];
			$listeAuteurs[$id_auteur] = new Membre($tAuteur);
		}
		$requete->closeCursor();
		return $listeAuteurs;
	}
}
?>