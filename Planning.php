<?php

require_once 'class.iCalReader.php';
require_once 'Cours.php';



class Planning {
	private $ical;
	private $time_offset;
	private $events = [];
	private $groups = [];
	private $cours = [];
	
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
			$this->cours[] = $item_cours;
		}
		
		usort($this->cours, function($a, $b) {
			return $a->getStart()[3]*60+$a->getStart()[4] >
				   $b->getStart()[3]*60+$b->getStart()[4];
		});
	}
	
	/**
	@param string $group = '' Filtrage possible par groupe
	@param integer $timestamp Filtrage possible par jour via timestamp
	@return array Liste d'objets de cours
	*/
	
	public function getArrayCours($group='', $timestamp=null) {
		$array_cours = [];
		
		$Y = date('Y', $timestamp);
		$m = date('m', $timestamp);
		$d = date('d', $timestamp);
		
		$array_date = array($Y, $m, $d);
		
		foreach ($this->cours as $i) {
			if (($group == '')
			|| in_array($group, $i->getGroups())) {
				if (is_null($array_date)
				|| (array_chunk($i->getStart(), 3)[0] == $array_date)) {
					$array_cours[] = $i;
				}
			}
		}
		
		return $array_cours;
	}
	
	/**
	@return array Liste des groupes ayant des cours
	*/
	
	public function getArrayGroups() {
		$groups = [];
		
		foreach ($this->cours as $i) {
			foreach ($i->getGroups() as $group) {
				$groups[$group] = null;
			}
		}
		
		$groups = array_keys($groups);
		sort($groups);
		return $groups;
	}
}

?>

