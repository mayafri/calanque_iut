<!DOCTYPE html>
<html>
	<head>
		<title>Calanque</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" media="screen" href="screen.css" />
	</head>
	<body>
		<h1>Emploi du temps</h1>
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

?>

		<div class="menu">
			<form action="index.php" method="GET">
				<select name="g">

<?php
foreach ($edt->getArrayGroups() as $i) {
	$attribut = '';
	if ($g == $i) {
		$attribut = 'selected';
	}
	echo '<label>Groupe : </label><option '.$attribut.' value="'.$i.'">'.$i.'</option>';
}

?>

				</select>


				<label>Jour : </label><input type="number" name="j" value="<?php echo $j ?>"/>
				<label>Mois : </label><input type="number" name="m" value="<?php echo $m ?>"/>
				<label>Année : </label><input type="number" name="a" value="<?php echo $a ?>"/>
				<button>OK</button>
			</form>
		</div>
		
		<div class="jour">
<?php
// La FAMEUSE boucle d'affichage 

foreach ($edt->getArrayCours($g, [$a, $m, $j]) as $i) {
	echo '<div class="cours">';
		echo '<h2>'.$i->getSubject().'</h2>';
			echo '<div class="desc">';
				echo '<p>En salle '.$i->getRoom().'</p>';
				echo '<p>Avec '.$i->getTeacher().'</p>';
				echo '<p>'.$i->getStart()[3].':'.$i->getStart()[4].' - '.$i->getEnd()[3].':'.$i->getEnd()[4].'</p>';
			echo '</div>';
	echo "</div>";
}

?>
		</div>
	</body>
</html>
