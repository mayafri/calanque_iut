<?php

// On s'occupe des variables GET

if (isset($_GET['g']))
	$g = $_GET['g'];
else
	$g = '';

if (isset($_GET['t'])) {
	$lundi = strtotime("last Monday", $_GET['t']+86400);
}
else {
	$lundi = strtotime("last Monday");
}

// On parse le timestamp pour l'affichage

$Y = date('Y', $lundi);
$m = date('m', $lundi);
$d = date('d', $lundi);

// On crée l'emploi du temps

require 'Planning.php';

$edt = new Planning('ADECal.ics', 2);

// On affiche l'interface

require 'display.php';

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Calanque</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" media="screen" href="screen.css" />
	</head>
	<body>
		<h1>Emploi du temps Calanque pour l'IUT Lyon 1
		sous licence libre AGPL</h1>
		<h2>Semaine du <?php echo $d ?>/<?php echo $m ?>/<?php echo $Y ?></h2>

		<form action="index.php" method="GET">
			<select name="g">
				<?php ComboboxGroups($edt, $g); ?>
			</select>
			<button name="t" value="<?php echo $lundi-604800 ?>">-</button>
			<button name="t" value="<?php echo $lundi+604800 ?>">+</button>
		</form>
		
		<div class="semaine">
			<div class="jour lundi">
				<h3>Lundi <?php echo date('d', $lundi) ?></h3>
				<?php DivCoursOfDay($edt, $g, $lundi); ?>
			</div>
			<div class="jour mardi">
				<h3>Mardi <?php echo date('d', $lundi+86400) ?></h3>
				<?php DivCoursOfDay($edt, $g, $lundi+86400); ?>
			</div>
			<div class="jour mercredi">
				<h3>Mercredi <?php echo date('d', $lundi+86400*2) ?></h3>
				<?php DivCoursOfDay($edt, $g, $lundi+86400*2); ?>
			</div>
			<div class="jour jeudi">
				<h3>Jeudi <?php echo date('d', $lundi+86400*3) ?></h3>
				<?php DivCoursOfDay($edt, $g, $lundi+86400*3); ?>
			</div>
			<div class="jour vendredi">
				<h3>Vendredi <?php echo date('d', $lundi+86400*4) ?></h3>
				<?php DivCoursOfDay($edt, $g, $lundi+86400*4); ?>
			</div>
		</div>
	</body>
</html>
