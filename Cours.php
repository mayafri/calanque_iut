<?php

class Cours {
	private $start;
	private $end;
	private $uid;
	private $group;
	private $subject;
	private $room;
	private $teacher;
	private $time_offset;

	/**
	@param string $event Tableau descriptif du cours dans le fichier iCal
	@param integer $time_offset Décalage horaire
	*/
	
	public function Cours($event, $time_offset) {
		$this->start = $event['DTSTART'];
		$this->end = $event['DTEND'];
		$this->uid = $event['UID'];
		$this->room = stripslashes($event['LOCATION']);
		$this->time_offset = $time_offset;
		
		$description = explode("\\n", $event['DESCRIPTION']);
		$this->group = $description[1];
		$this->teacher = implode(', ', array_slice($description, 2, -1));
		
		$summary = explode(" ", stripslashes($event['SUMMARY']));
		$this->subject = implode(' ', array_slice($summary, 1, -1));
	}
	
	private function dateHourToArray($date) {
		return array(substr($date, 0, 4),				// 0. Year
		substr($date, 4, 2),							// 1. Month
		substr($date, 6, 2),							// 2. Day
		substr($date, 9, 2)+$this->time_offset,			// 3. Hour
		substr($date, 11, 2));							// 4. Minute
	}
	
	public function getStart() {
		return $this->dateHourToArray($this->start);
	}
	
	public function getEnd() {
		return $this->dateHourToArray($this->end);
	}
	
	public function getUID() {
		return $this->uid;
	}
	
	public function getGroup() {
		return $this->group;
	}
	
	public function getSubject() {
		return $this->subject;
	}
	
	public function getRoom() {
		return $this->room;
	}
	
	public function getTeacher() {
		return $this->teacher;
	}
}

?>

