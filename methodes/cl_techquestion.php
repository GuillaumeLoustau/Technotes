<?PHP
class Techquestion {

	protected 	$id_techquestion,
				$titre,
				$contenu, 
				$statut,
				$id_type,
				$id_membre,
				$date_creation;

	function __construct($tvaleurs) 
	{
		if (!empty($tvaleurs)) 
		{
			$this->setIdTechquestion($tvaleurs["id_techquestion"]);
			$this->setTitre($tvaleurs["titre"]);
			$this->setContenu($tvaleurs["contenu"]);
			$this->setStatut($tvaleurs["statut"]);
			$this->setIdType($tvaleurs["id_type"]);
			$this->setIdMembre($tvaleurs["id_membre"]);
			$this->setDateCreation($tvaleurs["date_creation"]);
		}
		else
		{
			$this->setIdTechquestion("");
			$this->setTitre("");
			$this->setContenu("");
			$this->setStatut(0);
			$this->setidType(1);
			$this->setIdMembre(0);
			$this->setDateCreation("");
		}
	}

	/**
	* Methode permettant de savoir si l'objet est nouveau
	* @return bool
	*/
	public function isNew()
	{
		return empty($this->id_techquestion);
	}

	/**
	* Methode verifiant la validite de l'objet avant un enregistrement
	* @return void
	*/
	public function isValid()
	{
		if (empty($this->titre)) $this->titre = "TITRE A REMPLACER";
		else $this->titre = trim (preg_replace('/\s+/', ' ', $this->titre) ); // Suppression des espaces
		if (!empty($this->contenu)) $this->contenu = trim (preg_replace('/\s+/', ' ', $this->contenu) ); // Suppression des espaces
		if (empty($this->statut)) $this->statut = 0;
		if (empty($this->id_type)) $this->id_type = 1;
		if (empty($this->id_membre)) $this->id_membre = 0;
	}

	// SETTERS //
	public function setIdTechquestion($id_techquestion)
	{
		$this->id_techquestion = (int) $id_techquestion;
	}
	public function setTitre($titre)
	{
		$this->titre = $titre;
	}
	public function setContenu($contenu)
	{
		$this->contenu = htmlspecialchars($contenu);
	}
	public function setStatut($statut)
	{
		$this->statut = (int) $statut;
	}
	public function setidType($id_type)
	{
		$this->id_type = (int) $id_type;
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
	public function getIdTechquestion()
	{
		return $this->id_techquestion;
	}
	public function getTitre()
	{
		return stripslashes($this->titre);
	}
	public function getContenu()
	{
		return htmlspecialchars_decode($this->contenu);
	}
	public function getStatut()
	{
		return $this->statut;
	}
	public function getidType()
	{
		return $this->id_type;
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

class TechquestionGestion {

	protected $BDD;

	function __construct($BDD) 
	{
		$this->BDD = $BDD;
	}
	
	/**
	 * Méthode permettant d'enregistrer un techquestion
	 * @param  $oTechquestion Techquestion 
	 * @see self::add()
	 * @see self::modify()
	 * @return void
	 */
	public function save(Techquestion $oTechquestion)
	{
		$oTechquestion->isValid();
		$oTechquestion->isNew() ? $this->add($oTechquestion) : $this->update($oTechquestion);
	}

	/**
	 * Méthode permettant d'ajouter un techquestion
	 * @param $oTechquestion Techquestion 
	 * @return void
	 */
	 protected function add(Techquestion $oTechquestion)
	 {
		$requete = $this->BDD->prepare('INSERT INTO `techquestion` (titre, contenu, statut, id_type, id_membre, date_creation) VALUES (:titre, :contenu, :statut, :idType, :idMembre, :dateCreation)');
		$requete->bindValue(':titre', $oTechquestion->getTitre());
		$requete->bindValue(':contenu', $oTechquestion->getContenu());
		$requete->bindValue(':statut', $oTechquestion->getStatut());
		$requete->bindValue(':idType', $oTechquestion->getidType());
		$requete->bindValue(':idMembre', $oTechquestion->getIdMembre());
		$requete->bindValue(':dateCreation', $oTechquestion->getDateCreation());
		$requete->execute();
		$oTechquestion->setIdTechquestion($this->BDD->lastInsertId());
	}	

	/**
	 * Méthode permettant de modifier un techquestion
	 * @param $oTechquestion Techquestion 
	 * @return void
	 */
	protected function update(Techquestion $oTechquestion)
	{
		$requete = $this->BDD->prepare('UPDATE `techquestion` SET titre = :titre, contenu = :contenu, statut = :statut, id_membre = :idMembre WHERE id_techquestion = :idTechquestion');
		$requete->bindValue(':titre', $oTechquestion->getTitre());
		$requete->bindValue(':contenu', $oTechquestion->getContenu());
		$requete->bindValue(':statut', $oTechquestion->getStatut());
		$requete->bindValue(':idMembre', $oTechquestion->getIdMembre());
        $requete->bindValue(':idTechquestion', $oTechquestion->getIdTechquestion(), PDO::PARAM_INT);
		$requete->execute();
	}

	/**
	 * Méthode permettant de supprimer un techquestion
	 * @param $id_techquestion int L'identifiant à supprimer
	 * @return void
	 */
	public function delete($id_techquestion)
	{
		$this->BDD->exec('DELETE FROM `mc_tq` WHERE id_techquestion = '.(int) $id_techquestion);
		$this->BDD->exec('DELETE FROM `commentaire` WHERE id_techquestion = '.(int) $id_techquestion);
		$this->BDD->exec('DELETE FROM `techquestion` WHERE id_techquestion = '.(int) $id_techquestion);
	}	
		
	/**
	 * Méthode retournant un techquestion précis
	 * @param $id_techquestion int L'identifiant à récupérer
	 * @return Techquestion le techquestion demandé
	 */
	public function getOne($id_techquestion)
	{
		$resultat = array();
		$requete = $this->BDD->prepare('SELECT * FROM `techquestion` WHERE id_techquestion = :idTechquestion ');
		$requete->bindValue(':idTechquestion', $id_techquestion);
		$requete->execute();
		$resultat = $requete->fetch(PDO::FETCH_ASSOC);
		return new Techquestion($resultat);
	}
	
	/**
	 * Méthode renvoyant le nombre de techquestions total
	 * @return int
	 */
	public function count()
	{
		return $this->BDD->query('SELECT COUNT(id_techquestion) FROM `techquestion`')->fetchColumn();
	}
	
	/**
	 * Méthode retournant une liste de techquestion demandé
	 * @param $debut int Le premier techquestion à sélectionner
	 * @param $limite int Le nombre de techquestions à sélectionner
	 * @return array La liste des techquestions. Chaque entrée est une instance de Techquestion.
	 */
	 public function getList($debut = -1, $limite = -1)
	 {
		$listeTechquestions = array();
		$sql = 'SELECT * FROM `techquestion` ORDER BY titre ASC';
		// On vérifie l'intégrité des paramètres fournis
		if ($debut != -1 || $limite != -1)
		{
			$sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
		}
		$requete = $this->BDD->query($sql);
		while ($tTechquestion = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$id_techquestion = $tTechquestion['id_techquestion'];
			$listeTechquestions[$id_techquestion] = new Techquestion($tTechquestion);
		}
		$requete->closeCursor();
		return $listeTechquestions;
	}
	
	/**
	 * Méthode retournant une liste de techquestion demandé
	 * @param $ordre String  
	 * @param $direction String, ASC ou DESC
	 * @param $libellesMotCles String 
	 * @param $id_auteur int
	 * @param $date1 Date
	 * @param $date2 Date 
	 * @return array La liste des techquestions. 
	 */
	 public function getListRecherche($id_type, $ordre, $direction, $id_auteur='', $date1='', $date2='', $statut, $libellesMotCles='')
	 {
		if ($ordre == "") $ordre ='t.date_creation';
		if ($direction == "") $direction ='ASC';
		$listeTechquestions = array();
		$sql = 'SELECT distinct t.*, m.pseudo FROM `membre` m, `techquestion` t ';
		if ($libellesMotCles) 
		{
			$sql .= ' left join `mc_tq` mt on t.id_techquestion = mt.id_techquestion ';
		}
		$sql .= ' WHERE t.id_type = '.$id_type.' AND t.id_membre = m.id_membre '; 
		if ($id_auteur)
		{
			$sql .= ' AND t.id_membre = '.$id_auteur.' '; 
		}
		if ($statut!="")
		{
			$sql .= ' AND t.statut = '.$statut.' '; 
		}
		if ($date1!='' && $date2!='')
		{
			$tdate = explode('/', $date1); $date1 = $tdate[2]; if ($tdate[1]<9) $date1.='0'; $date1.=(int)$tdate[1]; if ($tdate[0]<9) $date1.='0'; $date1.=(int)$tdate[0];
			$tdate = explode('/', $date2); $date2 = $tdate[2]; if ($tdate[1]<9) $date2.='0'; $date2.=(int)$tdate[1]; if ($tdate[0]<9) $date2.='0'; $date2.=(int)$tdate[0];
			$sql .= ' AND DATE_FORMAT(t.date_creation,\'%Y%m%d\') >= \''.$date1.'\' AND DATE_FORMAT(t.date_creation,\'%Y%m%d\') <= \''.$date2.'\' '; 
		}
		else if ($date1 !='')
		{
			$tdate = explode('/', $date1); $date1 = $tdate[2]; if ($tdate[1]<9) $date1.='0'; $date1.=(int)$tdate[1]; if ($tdate[0]<9) $date1.='0'; $date1.=(int)$tdate[0];
			$sql .= ' AND DATE_FORMAT(t.date_creation,\'%Y%m%d\') like \''.$date1.'\' '; 
		}
		if ($libellesMotCles) 
		{
			//$libellesMotCles="A, +B, +C, D, + E, F"; => et (B ou syn B) et (C ou syn C) et (E ou syn E) et (1 ou A ou D ou F ou syn A ou syn B ou syn C)
			$motcleGestion = new MotcleGestion($this->BDD);
			$trouve = 1;
			$tMotcles=explode(',', $libellesMotCles);
			//On parcourt le tableau pour faire 2 tableaux, un avec les motslés obligatoires, un avec les autres
			$tMotclesEt = array();
			$tMotclesOu = array();
			foreach ($tMotcles as $elt)
			{
				$elt = trim (preg_replace('/\s+/', ' ', $elt) );
				if ($elt[0] == "+") 
				{
					//on enlève le + et les espaces restants
					$elt = trim (substr($elt, 1) );
					//on recherche si le mot-clé existe. 
					$id = $motcleGestion->isAlreadyExisting($elt, "");
					//Si le mot clé n'est pas trouvé, on interrompt la boucle car ce mot cle est obligatoire, donc la recherche ne retournera rien
					if ($id == 0) {$sql .= ' AND mt.id_motcle = -1 ';  $trouve = 0; break 1;}
					else 
					{
						$tMotclesEt[]=$id;
					}
				}
				else 
				{
					//on recherche si le mot-clé existe. 
					$id = $motcleGestion->isAlreadyExisting($elt, "");
					if ($id != 0) $tMotclesOu[]=$id;
				}
			}
			//$libellesMotCles="A, +B, +C, D, + E, F"; => et (B ou syn B) et (C ou syn C) et (E ou syn E) et (A ou D ou F ou syn A ou syn B ou syn C)
			if ($tMotclesEt && $trouve == 1) 
			{
				foreach ($tMotclesEt as $id)
				{
					$sql .= ' AND ( mt.id_motcle = '.$id.' ';
					//recherche Synonime
					$tSynonimes = $motcleGestion->getListSynonims($id);
					if ($tSynonimes)
					{
						foreach ($tSynonimes as $k => $v)
						{
							$sql .= ' OR mt.id_motcle = '.$k.' ';
						}
					}
					$sql .= ' ) ';
				}
			}
			//$libellesMotCles="A, +B, +C, D, + E, F"; => et (B ou syn B) et (C ou syn C) et (E ou syn E) et (A ou D ou F ou syn A ou syn B ou syn C)
			if ($tMotclesOu && $trouve == 1) 
			{
				$sql .= ' AND ( 1 ';
				foreach ($tMotclesEt as $id)
				{
					$sql .= ' OR mt.id_motcle = '.$id.' ';
					//recherche Synonime
					$tSynonimes = $motcleGestion->getListSynonims($id);
					if ($tSynonimes)
					{
						foreach ($tSynonimes as $k => $v)
						{
							$sql .= ' OR mt.id_motcle = '.$k.' ';
						}
					}
				}
				$sql .= ' ) ';
			}
		}
		$sql .= ' ORDER BY '.$ordre.' '.$direction;
		$requete = $this->BDD->query($sql);
		$motcleGestion = new MotcleGestion($this->BDD);
		while ($tTechquestion = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$id_techquestion = $tTechquestion['id_techquestion'];
			$tTechquestion['motcles'] = "";
			$listeMotcles = $motcleGestion->getListMotcles($id_techquestion);
			if ($listeMotcles) 
			{
				foreach ($listeMotcles as $k=>$v) 
				{
					$tTechquestion['motcles'] .= $v['libelle']." - ";
				}
			}
			$listeTechquestions[$id_techquestion]=$tTechquestion;
		}
		$requete->closeCursor();
		return $listeTechquestions;
	}	
		
}
?>