<?php

require 'class.iCalReader.php';
require 'Cours.php';



class Planning {
	private $ical;
	private $time_offset;
	private $events = array();
	private $groups = array();
	private $cours = array();
	
	/**
	@param string $path Chemin ou URL du fichier ADE
	@param integer $time_offset Décalage horaire (en heures)
	*/

	public function Planning($path, $time_offset=0) {
		$this->ical = new ICal($path);
		$this->events = $this->ical->events();
		$this->time_offset = $time_offset;
		
		foreach ($this->events as $event) {
			$item_cours = new Cours($event, $this->time_offset);
			array_push($this->cours, $item_cours);
		}
		
		function cmp($a, $b) {
			return $a->getStart()[3]*60+$a->getStart()[4] >
				   $b->getStart()[3]*60+$b->getStart()[4];
		}
		
		usort($this->cours, "cmp");
	}
	
	/**
	@param string $group = '' Filtrage possible par groupe
	@param array $array_date Filtrage possible par jour
		via un tableau de chaines (année, mois, jour)
	@return array Liste d'objets de cours
	*/
	
	public function getArrayCours($group='', $array_date=null) {
		$array_cours = array();
		
		foreach ($this->cours as $i) {
			if (($group == '')
			|| ($i->getGroup() == $group)) {
				if (is_null($array_date)
				|| (array_chunk($i->getStart(), 3)[0] == $array_date)) {
					array_push($array_cours, $i);
				}
			}
		}
		
		return $array_cours;
	}
	
	/**
	@return array Liste des groupes ayant des cours
	*/
	
	public function getArrayGroups() {
		$array_groups = array();
		
		foreach ($this->cours as $i) {
			array_push($array_groups, $i->getGroup());
		}
		
		$array_groups = array_unique($array_groups);
		sort($array_groups);
		return $array_groups;
	}
}

?>

