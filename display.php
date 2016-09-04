<?php

class DisplayParams {
	public $colorCrcSalt = '';

	private static $DEFAULT = null;
	public static function getDefault() {
		if (is_null(self::$DEFAULT)) {
			self::$DEFAULT = new self();
		}
		return self::$DEFAULT;
	}
}

/**
@param Planning $planning Un objet de type Planning
@param string $group = '' On peut sélectionner un groupe
*/

function ComboboxGroups($planning, $group='') {
	foreach ($planning->getArrayGroups() as $i) {
		$attribut = '';
		if ($group == $i) {
			$attribut = 'selected';
		}
		echo '<option '.$attribut.' value="'.$i.'">'.$i.'</option>';
	}
}

function LengthClass($start, $end) {
	$d = floor(($end - $start) / (60*30.));
	if ($d > 0) {
		return 'm' . (30 * $d);
	}
	return '';
}

/**
@param Planning $planning Un objet de type Planning
@param string $group Le nom du groupe sélectionné
@param integer $timestamp Jour via un timestamp
*/

function DivCoursOfDay($planning, $group, $timestamp, $dparms = null) {
	if (is_null($dparms)) {
		$dparms = DisplayParams::getDefault();
	}

	$oldend = 8*60;
	
	foreach ($planning->getArrayCours($group, $timestamp) as $i) {
	
		$diff = floor((($i->getStart()[3] * 60 + $i->getStart()[4]) - $oldend) / 30.);
		
		while ($diff > 0) {
			if ($diff >= 4) {
				echo '<div class="sep m120"></div>';
				$diff = $diff - 4;
			} elseif ($diff >= 3) {
				echo '<div class="sep m90"></div>';
				$diff = $diff - 3;
			} elseif ($diff >= 2) {
				echo '<div class="sep m60"></div>';
				$diff = $diff - 2;
			} else {
				echo '<div class="sep m30"></div>';
				$diff = $diff - 1;
			}
		}
		
		$hue = crc32($i->getSubject() . $dparms->colorCrcSalt) % 360;
		$lc = LengthClass($i->getStartTimestamp(), $i->getEndTimestamp());
		echo '<div class="cours ' . $lc . '" style="background:hsl('.$hue.', 100%, 93%);box-shadow:inset 0 0 1em hsl('.$hue.', 100%, 60%)">';
			echo '<h4 style="color:hsl('.$hue.', 100%, 40%)">'.$i->getSubject().'</h4>';
				echo '<div class="desc">';
					echo '<p class="icon-location">En salle '.$i->getRoom().'</p>';
					echo '<p class="icon-user">Avec '.implode(', ', $i->getTeachers()).'</p>';
					echo '<p class="icon-clock">'.$i->getStart()[3].':'.$i->getStart()[4].' - '.
					$i->getEnd()[3].':'.$i->getEnd()[4].'</p>';
				echo '</div>';
		echo "</div>";

		$oldend = $i->getEnd()[3] * 60 + $i->getEnd()[4];
	}
}

?>

