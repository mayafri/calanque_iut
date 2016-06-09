<?php

class Cours {
	private $start;
	private $end;
	private $uid;
	private $group;
	private $subject;
	private $room;
	private $teacher;
	private $timeoffset;

	public function Cours($event, $timeoffset) {
		$this->start = $event['DTSTART'];
		$this->end = $event['DTEND'];
		$this->uid = $event['UID'];
		$this->room = $event['LOCATION'];
		$this->timeoffset = $timeoffset;
		
		$description = explode("\\n", $event['DESCRIPTION']);
		$this->group = $description[1];
		$this->teacher = implode(', ', array_slice($description, 2, -1));
		
		$summary = explode(" ", $event['SUMMARY']);
		$this->subject = implode(' ', array_slice($summary, 1, -1));
	}
	
	private function dateToArray($date) {
		return array(substr($date, 0, 4),				// Year
		substr($date, 4, 2),							// Month
		substr($date, 6, 2),							// Day
		substr($date, 9, 2)+$this->timeoffset,			// Hour
		substr($date, 11, 2));							// Minute
	}
	
	public function getStart() {
		return $this->dateToArray($this->start);
	}
	
	public function getEnd() {
		return $this->dateToArray($this->end);
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

