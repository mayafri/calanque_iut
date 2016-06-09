<?php

// On s'occupe des variables GET

if (isset($_GET['a']))
	$a = $_GET['a'];
else
	$a = date('Y');
	
if (isset($_GET['m']))
	$m = $_GET['m'];
else
	$m = date('m');

if (isset($_GET['j']))
	$j = $_GET['j'];
else
	$j = date('d');

if (isset($_GET['g']))
	$g = $_GET['g'];
else
	$g = '';

// On crée l'emploi du temps

require 'Planning.php';

$edt = new Planning('ADECal.ics', 2);

// Interface provisoire immonde

echo '<form action="index.php" method="GET"><select name="g">';
foreach ($edt->getArrayGroups() as $i) {
	$attribut = '';
	if ($g == $i) {
		$attribut = 'selected';
	}
	echo '<label>Groupe : </label><option '.$attribut.' value="'.$i.'">'.$i.'</option>';
}
echo '</select>';
echo '<label>Jour : </label><input type="number" name="j" value="'.$j.'"/>';
echo '<label>Mois : </label><input type="number" name="m" value="'.$m.'"/>';
echo '<label>Année : </label><input type="number" name="a" value="'.$a.'"/>';
echo "<button>OK</button></form>";


// La FAMEUSE boucle d'affichage 

foreach ($edt->getArrayCours($g, [$a, $m, $j]) as $i) {
	echo 'Groupe : '.$i->getGroup();
	echo '<br>';
	echo 'Jour : '.$i->getStart()[2].'-'.$i->getStart()[1];
	echo '<br>';
	echo 'Heure début : '.$i->getStart()[3].':'.$i->getStart()[4];
	echo '<br>';
	echo 'Heure fin : '.$i->getEnd()[3].':'.$i->getEnd()[4];
	echo '<br>';
	echo 'Prof : '.$i->getTeacher();
	echo '<br>';
	echo 'Matière : '.$i->getSubject();
	echo '<br>';
	echo 'Salle : '.$i->getRoom();
	echo "<hr>";
}

?>

