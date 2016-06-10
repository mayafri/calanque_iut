<?php

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

/**
@param Planning $planning Un objet de type Planning
@param string $group Le nom du groupe sélectionné
@param array $array_date Jour via un tableau de chaines (année, mois, jour)
*/

function DivCoursOfDay($planning, $group, $array_date) {
	foreach ($planning->getArrayCours($group, $array_date) as $i) {
		echo '<div class="cours">';
			echo '<h4>'.$i->getSubject().'</h4>';
				echo '<div class="desc">';
					echo '<p>En salle '.$i->getRoom().'</p>';
					echo '<p>Avec '.$i->getTeacher().'</p>';
					echo '<p>'.$i->getStart()[3].':'.$i->getStart()[4].' - '.$i->getEnd()[3].':'.$i->getEnd()[4].'</p>';
				echo '</div>';
		echo "</div>";
	}
}

?>

