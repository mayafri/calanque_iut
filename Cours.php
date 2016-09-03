<?php

/* TODO Détection nom de groupe/prof par entropie/heuristique
function calculateEntropy(string $entropyString) {
	$characterCounts = [];
	$length = strlen($entropyString);
	for ($i = 0; $i < $length; ++$i) {
		$c = $entropyString[$i];
		if(ctype_space($c)) {
			continue;
		}
		$currentCount = 0;
		if (isset($characterCounts[$c])) {
			$currentCount = $characterCounts[$c];
		}
		$characterCounts[$c] = ++$currentCount;
	}

	$totalEntropy = 0;
	foreach ($characterCounts as $c => $count) {
		$frequency = $count/$length;
		$totalEntropy += -1*$frequency*log($frequency);
	}
	return $totalEntropy;
}
*/

class Cours {
	private $start;
	private $end;
	private $uid;
	private $groups;
	private $subject;
	private $room;
	private $teachers;
	private $time_offset;

	const TEACHER_GROUP_ENTROPY_THRESOLD = 1.74;

	/**
	@param string $event Tableau descriptif du cours dans le fichier iCal
	@param integer $time_offset Décalage horaire
	*/
	
	public function Cours($event, $time_offset) {
		$this->start = $event['DTSTART'];
		$this->end = $event['DTEND'];
		$this->uid = $event['UID'];
		if (isset($event['LOCATION'])) {
			$this->room = stripslashes($event['LOCATION']);
		}
		$this->time_offset = $time_offset;

		$description = explode("\\n", $event['DESCRIPTION']);
		$this->groups = [$description[1]];
		$this->teachers = [implode(', ', array_slice($description, 2, -1))];

		/* TODO Détection nom de groupe/prof par entropie/heuristique
		$this->groups = [];
		$this->teachers = [];
		foreach ($description as $descElm) {
			if ($descElm !== "" && strstr($descElm, "xporté") === false) {
				if (preg_match('/[1-9]/', $descElm) === 1) {
					// Les personnes n'ont pas de chiffre dans leur nom
					$this->groups[] = $descElm;
				} else {
					$entropy = calculateEntropy($descElm);
					if ($entropy > self::TEACHER_GROUP_ENTROPY_THRESOLD) {
						$this->teachers[] = $descElm . $entropy;
					} else {
						$this->groups[] = $descElm . $entropy;
					}
				}
			}
		}
		*/

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
	
	public function getGroups() {
		return $this->groups;
	}
	
	public function getSubject() {
		return $this->subject;
	}
	
	public function getRoom() {
		return $this->room;
	}
	
	public function getTeachers() {
		return $this->teachers;
	}
}

?>

