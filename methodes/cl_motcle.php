<?PHP
class Motcle {

	protected 	$id_motcle,
				$libelle,
				$valide,
				$id_pere,
				$id_synonime,
				$nombre_tq,
				$date_creation;

	function __construct($tvaleurs) 
	{
		if (!empty($tvaleurs)) 
		{
			$this->setIdMotcle($tvaleurs["id_motcle"]);
			$this->setLibelle($tvaleurs["libelle"]);
			$this->setValide($tvaleurs["valide"]);
			$this->setIdPere($tvaleurs["id_pere"]);
			$this->setIdSynonime($tvaleurs["id_synonime"]);
			$this->setDateCreation($tvaleurs["date_creation"]);
			$this->setNombreTq($tvaleurs["nombre_tq"]);
		}
		else
		{
			$this->setIdMotcle("");
			$this->setLibelle("");
			$this->setValide(0);
			$this->setIdPere(0);
			$this->setIdSynonime(0);
			$this->setDateCreation("");
			$this->setNombreTq(0);
		}
	}

	/**
	* Methode permettant de savoir si l'objet est nouveau
	* @return bool
	*/
	public function isNew()
	{
		return empty($this->id_motcle);
	}

	/**
	* Methode verifiant la validite de l'objet avant un enregistrement
	* @return void
	*/
	public function isValid()
	{
		if (empty($this->libelle)) $this->libelle = "A SUPPRIMER";
		else $this->libelle = trim (preg_replace('/\s+/', ' ', $this->libelle) ); // Suppression des espaces
		if (empty($this->valide)) $this->valide = 0;
		if (empty($this->id_pere)) $this->id_pere = 0;
		if (empty($this->id_synonime)) $this->id_synonime = 0;
		if (empty($this->nombre_tq)) $this->nombre_tq = 0;
	}

	// SETTERS //
	public function setIdMotcle($id_motcle)
	{
		$this->id_motcle = (int) $id_motcle;
	}
	public function setLibelle($libelle)
	{
		$this->libelle = $libelle;
	}
	public function setValide($valide)
	{
		$this->valide = $valide;
	}
	public function setIdPere($id_pere)
	{
		$this->id_pere = $id_pere;
	}
	public function setIdSynonime($id_synonime)
	{
		$this->id_synonime = (int) $id_synonime;
	}
	public function setDateCreation($date_creation)
	{
		$this->date_creation = $date_creation;
	}
	public function setNombreTq($nombre_tq)
	{
		$this->nombre_tq = $nombre_tq;
	}
	// GETTERS //
	public function getIdMotcle()
	{
		return $this->id_motcle;
	}
	public function getLibelle()
	{
		return stripslashes($this->libelle);
	}
	public function getValide()
	{
		return $this->valide;
	}
	public function getIdPere()
	{
		return $this->id_pere;
	}
	public function getIdSynonime()
	{
		return $this->id_synonime;
	}
	public function getDateCreation()
	{
		return $this->date_creation;
	}
	public function getNombreTq()
	{
		return $this->nombre_tq;
	}
}

class MotcleGestion {

	protected $BDD;

	function __construct($BDD) 
	{
		$this->BDD = $BDD;
	}
	
	/**
	* Methode verifiant l'existence d'un motcle
	* @return bool
	*/
	public function isUnique($libelle, $id_motcle)
	{
		$libelle = mb_strtolower(trim (preg_replace('/\s+/', ' ', $libelle) ) ,'UTF-8'); // Suppression des espaces
		if ($id_motcle!="") $requete = $this->BDD->prepare('SELECT id_motcle FROM `motcle` where LOWER(libelle) = :libelle and id_motcle != :idMotcle');
		else $requete = $this->BDD->prepare('SELECT id_motcle FROM `motcle` where LOWER(libelle) = :libelle');
		$requete->bindValue(':libelle', $libelle);
		if ($id_motcle!="") $requete->bindValue(':idMotcle', $id_motcle);
		$requete->execute();
		if ($requete->fetch(PDO::FETCH_ASSOC)) return FALSE;
		else return TRUE;
	}

	/**
	* Methode verifiant l'existence d'un motcle
	* @param  $libelle le libelle du mot cle 
	* @param  $id_motcle l'identifiant du mot cle courant
	* @return int 
	*/
	public function isAlreadyExisting($libelle, $id_motcle)
	{
		$libelle = mb_strtolower(trim (preg_replace('/\s+/', ' ', $libelle) ) ,'UTF-8'); // Suppression des espaces
		if ( $libelle=="" || $libelle==" ") return -1;
		if ($id_motcle!="") $requete = $this->BDD->prepare('SELECT id_motcle FROM `motcle` where LOWER(libelle) = :libelle and id_motcle != :idMotcle');
		else $requete = $this->BDD->prepare('SELECT id_motcle FROM `motcle` where LOWER(libelle) = :libelle ');
		
		$requete->bindValue(':libelle', $libelle);
		if ($id_motcle!="") $requete->bindValue(':idMotcle', $id_motcle);
		$requete->execute();
		if ($resultat = $requete->fetch(PDO::FETCH_ASSOC)) return $resultat['id_motcle'];
		else return 0;
	}

	/**
	 * Méthode permettant d'enregistrer un motcle
	 * @param  $oMotcle Motcle 
	 * @see self::add()
	 * @see self::modify()
	 * @return void
	 */
	public function save(Motcle $oMotcle)
	{
		$oMotcle->isValid();
		$oMotcle->isNew() ? $this->add($oMotcle) : $this->update($oMotcle);
	}

	/**
	 * Méthode permettant d'ajouter un motcle
	 * @param $oMotcle Motcle 
	 * @return void
	 */
	 protected function add(Motcle $oMotcle)
	 {
		$requete = $this->BDD->prepare('INSERT INTO `motcle` (libelle, valide, id_pere, id_synonime, date_creation) VALUES (:libelle, :valide, :idPere, :idSynonime, :dateCreation)');
		$requete->bindValue(':libelle', $oMotcle->getLibelle());
		$requete->bindValue(':valide', $oMotcle->getValide());
		$requete->bindValue(':idPere', $oMotcle->getIdPere());
		$requete->bindValue(':idSynonime', $oMotcle->getIdSynonime());
		$requete->bindValue(':dateCreation', $oMotcle->getDateCreation());
		$requete->execute();
		$oMotcle->setIdMotcle($this->BDD->lastInsertId());
	}	

	/**
	 * Méthode permettant de modifier un motcle
	 * @param $oMotcle Motcle 
	 * @return void
	 */
	protected function update(Motcle $oMotcle)
	{
		$requete = $this->BDD->prepare('UPDATE `motcle` SET libelle = :libelle, valide = :valide, id_pere = :idPere, id_synonime = :idSynonime WHERE id_motcle = :idMotcle');
		$requete->bindValue(':libelle', $oMotcle->getLibelle());
		$requete->bindValue(':valide', $oMotcle->getValide());
		$requete->bindValue(':idPere', $oMotcle->getIdPere());
		$requete->bindValue(':idSynonime', $oMotcle->getIdSynonime());
        $requete->bindValue(':idMotcle', $oMotcle->getIdMotcle(), PDO::PARAM_INT);
		$requete->execute();
		if ($oMotcle->getIdPere() != "0")
		{
			$this->unlinkChildren($oMotcle->getIdMotcle());
		}	
	}

	/**
	 * Méthode permettant de supprimer un motcle
	 * @param $id_motcle int L'identifiant à supprimer
	 * @return void
	 */
	public function delete($id_motcle)
	{
		$this->BDD->exec('DELETE FROM `mc_tq` WHERE id_motcle = '.(int) $id_motcle);
		$this->BDD->exec('UPDATE `motcle` SET id_synonime = 0 WHERE id_motcle = '.$id_motcle);
		$this->BDD->exec('UPDATE `motcle` SET id_pere = 0 WHERE id_motcle = '.$id_motcle);
		$this->BDD->exec('DELETE FROM `motcle` WHERE id_motcle = '.(int) $id_motcle);
	}	
		
	/**
	 * Méthode permettant de trouver le synonime premier d'un mot cle
	 * @param $oMotcle Motcle 
	 * @return int
	 */
	public function getIdFirstSynonim(Motcle $oMotcle)
	{
		$sql = 'SELECT id_synonime FROM `motcle` WHERE id_motcle = '.$oMotcle->getIdMotcle();
		$requete = $this->BDD->query($sql);
		$donnes = $requete->fetch(PDO::FETCH_ASSOC);
		$id_synonime = $donnes['id_synonime'];
		$requete->closeCursor();
		if ($id_synonime==0) return $oMotcle->getIdMotcle();
		else return $id_synonime;
	}

	/**
	 * Méthode permettant de trouver le synonime premier d'un mot cle
	 * @param  $idMotcle int 
	 * @return int
	 */
	public function getIdFirstSynonimById($idMotcle)
	{
		$sql = 'SELECT id_synonime FROM `motcle` WHERE id_motcle = '.$idMotcle;
		$requete = $this->BDD->query($sql);
		$donnes = $requete->fetch(PDO::FETCH_ASSOC);
		$id_synonime = $donnes['id_synonime'];
		$requete->closeCursor();
		if ($id_synonime==0) return $idMotcle;
		else return $id_synonime;
	}

	/**
	 * Méthode permettant de retourner une chaine des synonimes d'un mot cle
	 * @param $oMotcle Motcle 
	 * @return String
	 */
	public function getLibellesSynonims($oMotcle)
	{
		$libellesSynonims = "";
		$idFirstSynonim = $this->getIdFirstSynonim($oMotcle);

		if ($idFirstSynonim != $oMotcle->getIdMotcle())
		{
			$sql = 'SELECT libelle FROM `motcle` WHERE id_motcle = '.$idFirstSynonim;
			$requete = $this->BDD->query($sql);
			$resultat = $requete->fetch(PDO::FETCH_ASSOC);
			$libellesSynonims .= $resultat['libelle']. " | ";
			$requete->closeCursor();
		}
		$sql = 'SELECT libelle FROM `motcle` WHERE id_synonime = '.$idFirstSynonim.' and id_motcle != '.$oMotcle->getIdMotcle().' and id_motcle != '.$idFirstSynonim.' ORDER BY libelle ASC';
		$requete = $this->BDD->query($sql);
		while ($tMotcle = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$libellesSynonims .= $tMotcle['libelle']. " | ";
		}
		$requete->closeCursor();
		return $libellesSynonims;
	}
	
	/**
	 * Méthode permettant de supprimer le lien entre un mot cle et un synonime
	 * @param $oMotcle Motcle 
	 * @param $idSynonime int L'identifiant du synonime
	 * @return void
	 */
	public function unlinkSynonim(Motcle $oMotcle, $idSynonime)
	{
		$idFirstSynonim = $this->getIdFirstSynonim($oMotcle);
		$idMotcle = $oMotcle->getIdMotcle();
		if ($idFirstSynonim == $idSynonime) 
		{
			$this->BDD->exec('UPDATE `motcle` SET id_synonime = 0 WHERE id_motcle = '.$idMotcle);
		}
		else 
		{
			$this->BDD->exec('UPDATE `motcle` SET id_synonime = 0 WHERE id_motcle = '.$idSynonime);
		}
	}

	/**
	 * Méthode permettant d'ajouter un motcle et de le lier comme synonime d'un autre
	 * @param $oMotcle Motcle 
	 * @param $libelleSynonime String le libelle du nouveau motcle
	 * @return int
	 */
	public function addSynonim(Motcle $oMotcle, $libelleSynonime)
	{
		$id_synonime=0;
		if ($libelleSynonime!=="")
		{
			$id_synonime=$this->isAlreadyExisting($libelleSynonime, "");
			if ($id_synonime == 0)
			{
				$tvaleurs = array("id_motcle" => "", "libelle" => $libelleSynonime,  "valide" => 0, "id_pere" => $oMotcle->getIdPere(), "id_synonime" => $this->getIdFirstSynonim($oMotcle), "nombre_tq" => 0, "date_creation" => date('Y-m-d H:i:s'));
				$motcle = new Motcle($tvaleurs);
				$this->save($motcle);
				$id_synonime=$motcle->getIdMotcle();
			}
			else if ($id_synonime != -1 )
			{
				if ($this->getIdFirstSynonimById($id_synonime) == $id_synonime) 
				{
					$this->BDD->exec('UPDATE `motcle` SET id_synonime = '.$this->getIdFirstSynonim($oMotcle).', id_pere='.$oMotcle->getIdPere().' WHERE id_synonime = '.$id_synonime);
				}
				$this->BDD->exec('UPDATE `motcle` SET id_synonime = '.$this->getIdFirstSynonim($oMotcle).', id_pere='.$oMotcle->getIdPere().' WHERE id_motcle = '.$id_synonime);
				if ($oMotcle->getIdPere() != 0 ) 
				{
					$this->BDD->exec('UPDATE `motcle` SET id_pere = 0 WHERE id_pere = '.$id_synonime);
				}
			}
		}
		return $id_synonime;
	}
	
	/**
	 * Méthode permettant de supprimer le lien entre un mot cle et un fils
	 * @param $idFils int L'identifiant du fils à détacher
	 * @return void
	 */
	public function unlinkChild($idFils)
	{
		$this->BDD->exec('UPDATE `motcle` SET id_pere = 0 WHERE id_motcle = '.$idFils);
		$idFirstSynonim = $this->getIdFirstSynonimById($idFils);
		$this->BDD->exec('UPDATE `motcle` SET id_pere = 0 WHERE id_synonime = '.$idFirstSynonim);
	}

	/**
	 * Méthode permettant de supprimer le lien entre un mot cle et un fils
	 * @param $idFils int L'identifiant du fils à détacher
	 * @return void
	 */
	public function unlinkChildren($idMotcle)
	{
		$this->BDD->exec('UPDATE `motcle` SET id_pere = 0 WHERE id_pere = '.$idMotcle);
	}

	/**
	 * Méthode retournant un motcle précis
	 * @param $id_motcle int L'identifiant à récupérer
	 * @return Membre le motcle demandé
	 */
	public function getOne($id_motcle)
	{
		$resultat = array();
		$requete = $this->BDD->prepare('SELECT m.*, count(t.id_techquestion) as nombre_tq FROM `motcle` m left join `mc_tq` t on m.id_motcle=t.id_motcle WHERE m.id_motcle = :idMotcle group by m.id_motcle');
		$requete->bindValue(':idMotcle', $id_motcle);
		$requete->execute();
		$resultat = $requete->fetch(PDO::FETCH_ASSOC);
		return new Motcle($resultat);
	}
	
	/**
	 * Méthode retournant un motcle précis
	 * @param $libelle à récupérer
	 * @return Membre le motcle demandé
	 */
	public function getOneByLibelle($libelle)
	{
		$requete = $this->BDD->prepare('SELECT m.*, count(t.id_techquestion) as nombre_tq FROM `motcle` m left join `mc_tq` t on m.id_motcle=t.id_motcle WHERE libelle = :libelle group by m.id_motcle');
		$requete->bindValue(':libelle', $libelle);
		$requete->execute();
		$resultat = $requete->fetch(PDO::FETCH_ASSOC);
		return new Motcle($resultat);
	}	
	
	/**
	 * Méthode renvoyant le nombre de motcles total
	 * @return int
	 */
	public function count()
	{
		return $this->BDD->query('SELECT COUNT(id_motcle) FROM `motcle`')->fetchColumn();
	}
	
	/**
	 * Méthode retournant une liste de motcle demandé
	 * @param $debut int Le premier motcle à sélectionner
	 * @param $limite int Le nombre de motcles à sélectionner
	 * @return array La liste des motcles. Chaque entrée est une instance de Motcle.
	 */
	 public function getList($valide="", $debut = -1, $limite = -1)
	 {
		$listeMotcles = array();
		$sql = 'SELECT m.*, count(t.id_techquestion) as nombre_tq FROM `motcle` m left join `mc_tq` t on m.id_motcle=t.id_motcle ';
		if ($valide != "") $sql .= ' WHERE valide = '.$valide;
		$sql .= ' GROUP BY m.id_motcle ORDER BY libelle ASC';
		// On vérifie l'intégrité des paramètres fournis
		if ($debut != -1 || $limite != -1)
		{
			$sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
		}
		$requete = $this->BDD->query($sql);
		while ($tMotcle = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$id_motcle = $tMotcle['id_motcle'];
			$listeMotcles[$id_motcle] = new Motcle($tMotcle);
		}
		$requete->closeCursor();
		return $listeMotcles;
	}

	/**
	 * Méthode retournant une liste de motcle demandé
	 * @param $id_pere int 
	 * @return array La liste des motcles. Chaque entrée est une instance de Motcle.
	 */
	 public function getListByIdPere($id_pere, $valide)
	 {
		$listeMotcles = array();
		$sql = 'SELECT m.*, count(t.id_techquestion) as nombre_tq FROM `motcle` m left join `mc_tq` t on m.id_motcle=t.id_motcle';
		$sql .= ' WHERE id_pere = '.$id_pere;
		if ($valide != "") $sql .= ' AND valide = '.$valide;
		$sql .= ' GROUP BY m.id_motcle ORDER BY libelle ASC';
		$requete = $this->BDD->query($sql);
		while ($tMotcle = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$id_motcle = $tMotcle['id_motcle'];
			$listeMotcles[$id_motcle] = new Motcle($tMotcle);
		}
		$requete->closeCursor();
		return $listeMotcles;
	}
	
	/**
	 * Méthode retournant une liste des motcle père
	 * @param  
	 * @return array La liste des motcles sous la forme d'un tableau id-libelle
	 */
	 public function getListFathers()
	 {
		$listeMotcles = array();
		$sql = 'SELECT id_motcle, libelle FROM `motcle` WHERE id_pere = 0 ORDER BY libelle ASC';
		$requete = $this->BDD->query($sql);
		while ($tMotcle = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$id_motcle = $tMotcle['id_motcle'];
			$listeMotcles[$id_motcle] = $tMotcle['libelle'];
		}
		$requete->closeCursor();
		return $listeMotcles;
	}

	/**
	 * Méthode retournant la liste des motcle fils d'un motcle
	 * @param  $id_pere int 
	 * @return array La liste des motcles fils sous la forme d'un tableau id-libelle
	 */
	 public function getListChildren($id_pere)
	 {
		$listeMotcles = array();
		$sql = 'SELECT id_motcle, libelle FROM `motcle` WHERE id_pere = '.$id_pere.' ORDER BY libelle ASC';
		$requete = $this->BDD->query($sql);
		while ($tMotcle = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$id_motcle = $tMotcle['id_motcle'];
			$listeMotcles[$id_motcle] = $tMotcle['libelle'];
		}
		$requete->closeCursor();
		return $listeMotcles;
	}
	
	/**
	 * Méthode retournant la liste des synonimes d'un motcle
	 * @param  $id_motcle int 
	 * @return array La liste des motcles synonimes sous la forme d'un tableau id-libelle
	 */
	 public function getListSynonims($id_motcle)
	 {
		$id_synonime = 0;
		$listeMotcles = array();
		$sql = 'SELECT id_synonime FROM `motcle` WHERE id_motcle = '.$id_motcle;
		$requete = $this->BDD->query($sql);
		$donnes = $requete->fetch(PDO::FETCH_ASSOC);
		if ($donnes) $id_synonime = $donnes['id_synonime'];
		$requete->closeCursor();
		if ($id_synonime==0)
		{
			$sql = 'SELECT id_motcle, libelle FROM `motcle` WHERE id_synonime = '.$id_motcle.' ORDER BY libelle ASC';
			$requete = $this->BDD->query($sql);
			while ($tMotcle = $requete->fetch(PDO::FETCH_ASSOC))
			{
				$id = $tMotcle['id_motcle'];
				$listeMotcles[$id] = $tMotcle['libelle'];
			}
			$requete->closeCursor();
		}
		else
		{
			$sql = 'SELECT id_motcle, libelle FROM `motcle` WHERE (id_synonime = '.$id_synonime.' and id_motcle != '.$id_motcle.') or id_motcle = '.$id_synonime.' ORDER BY libelle ASC';
			$requete = $this->BDD->query($sql);
			while ($tMotcle = $requete->fetch(PDO::FETCH_ASSOC))
			{
				$id = $tMotcle['id_motcle'];
				$listeMotcles[$id] = $tMotcle['libelle'];
			}
			$requete->closeCursor();
		}
		return $listeMotcles;
	}
	
	/**
	 * Méthode retournant la liste des mots cles d'un technote
	 * @param $id_techquestion int 
	 * @return array La liste des mots cles. 
	 */
	 public function getListMotcles($id_techquestion)
	 {
		$listeMotcles = array();
		
		$sql = 'SELECT m.* FROM `motcle` m, `mc_tq` mt WHERE m.id_motcle = mt.id_motcle AND mt.origine = 1 AND mt.id_techquestion = '.$id_techquestion;
		$requete = $this->BDD->query($sql);
		while ($tMotcle = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$id_motcle = $tMotcle['id_motcle'];
			$listeMotcles[$id_motcle]=$tMotcle;
		}
		
		$requete->closeCursor();
		return $listeMotcles;		
	}

	/**
	 * Méthode retournant la liste des mots clés du techquestion 
	 * @param $id_techquestion int L'identifiant 
	 * @return String
	 */
	public function getStringMotcles($id_techquestion)
	{
		$resultat="";
		$listeMotcles = $this->getListMotcles($id_techquestion);
		if ($listeMotcles) 
		{
			foreach ($listeMotcles as $k=>$v) 
			{
				$resultat .= $v['libelle'].", ";
			}
		}
		return $resultat;
	}
	
	/**
	 * Méthode liant un mot cle a un technote/question
	 * @param $id_techquestion int
	 * @return void
	 */
	public function linkToTechquestion($id_techquestion , $id_motcle)
	{
		$sql ='INSERT INTO `mc_tq` (id_techquestion , id_motcle , origine) VALUES ( :id_techquestion , :id_motcle , :origine )';
		$requete = $this->BDD->prepare($sql);
		$listeMotcles = $this->getListSynonims($id_motcle);
		if($listeMotcles)
		{
			foreach($listeMotcles as $k=>$v)
			{
				$requete->bindValue(':id_techquestion',$id_techquestion);
				$requete->bindValue(':id_motcle',$k);
				$requete->bindValue(':origine',0);
				$requete->execute();
			}
		}
		$requete->bindValue(':id_techquestion',$id_techquestion);
		$requete->bindValue(':id_motcle',$id_motcle);
		$requete->bindValue(':origine',1);
		$requete->execute();
	}	
	
	/**
	 * Méthode liant un mot cle a un technote/question
	 * @param $id_techquestion int
	 * @return void
	 */
	public function linkMotclesToTechquestion($id_techquestion, $libelleMotcles)
	{
		if ( $id_techquestion!="")
		{
			$this->BDD->exec('DELETE FROM `mc_tq` WHERE id_techquestion = '.(int) $id_techquestion);
			if($libelleMotcles!="")
			{
				$tMotCle_tmp = explode (',', $_POST['motcles']);
				foreach ( $tMotCle_tmp as $mc_libelle)
				{
					if($mc_libelle!= "")
					{
						$id_motcle = $this->isAlreadyExisting($mc_libelle , "");
						if($id_motcle == 0 )
						// CREATION ET AJOUT DU MOT CLE
						{
							$tvaleursMC = array('id_motcle' => "", 'libelle' => $mc_libelle , 'valide' => 0 , 'id_pere' => 0 , 'id_synonime' => 0, 'date_creation' => date('Y-m-d H:i:s'), 'nombre_tq' => 1);
							$motcle = new MotCle($tvaleursMC);
							$this->save($motcle);
							$id_motcle = $motcle->getIdMotcle();
						}
						if($id_motcle != -1 )$this->linkToTechquestion($id_techquestion, $id_motcle);
					}
				}
			}
		}
	}
}
?>