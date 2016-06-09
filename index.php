<?php

require 'Planning.php';

$edt = new Planning('ADECal.ics', 2);
$cours4 = $edt->getCours(4);

$tout = $edt->getArrayCours();
foreach ($tout as $i) {

	echo 'Jour : '.$i->getStart()[2].'-'.$i->getStart()[1];
	echo '<br>';
	echo 'Heure début : '.$i->getStart()[3].':'.$i->getStart()[4];
	echo '<br>';
	echo 'Heure fin : '.$i->getEnd()[3].':'.$i->getEnd()[4];
	echo '<br>';
	echo 'Groupe : '.$i->getGroup();
	echo '<br>';
	echo 'Prof : '.$i->getTeacher();
	echo '<br>';
	echo 'Matière : '.$i->getSubject();
	echo '<br>';
	echo 'Salle : '.$i->getRoom();
	
	echo "<hr>";
}

?>

