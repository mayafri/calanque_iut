<?php

require 'class.iCalReader.php';
require 'Cours.php';

class Planning {
	private $ical;
	private $events = array();
	private $timeoffset;
	
	public function Planning($path, $timeoffset=0) {
		$this->ical = new ICal($path);
		$this->events = $this->ical->events();
		$this->timeoffset = $timeoffset;
	}
	
	public function getCours($id) {
		$itemCours = new Cours($this->events[$id], $this->timeoffset);
		return $itemCours;
	}
	
	public function getArrayCours() {
		$arrayCours = array();
		foreach ($this->events as $event) {
			$itemCours = new Cours($event, $this->timeoffset);
			array_push($arrayCours, $itemCours);
		}
		return $arrayCours;
	}
}

?>

