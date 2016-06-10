<?php

// On récupère le lundi en cours

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

$a = date('Y', $lundi);
$m = date('m', $lundi);
$j = date('d', $lundi);

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
		<h1>Emploi du temps</h1>
		<h2>Semaine du <?php echo $j ?>/<?php echo $m ?>/<?php echo $a ?></h2>
		<div class="menu">
			<form action="index.php" method="GET">
				<select name="g">
					<?php ComboboxGroups($edt, $g); ?>
				</select>
				<button name="t" value="<?php echo $lundi-604800 ?>">-</button>
				<button name="t" value="<?php echo $lundi+604800 ?>">+</button>
			</form>
		</div>
		
		<div class="lundi">
			<h3>Lundi <?php echo $j ?></h3>
			<?php DivCoursOfDay($edt, $g, [$a, $m, $j]); ?>
		</div>
		<div class="mardi">
			<h3>Mardi <?php echo $j+1 ?></h3>
			<?php DivCoursOfDay($edt, $g, [$a, $m, $j+1]); ?>
		</div>
		<div class="mercredi">
			<h3>Mercredi <?php echo $j+3 ?></h3>
			<?php DivCoursOfDay($edt, $g, [$a, $m, $j+2]); ?>
		</div>
		<div class="jeudi">
			<h3>Jeudi <?php echo $j+4 ?></h3>
			<?php DivCoursOfDay($edt, $g, [$a, $m, $j+3]); ?>
		</div>
		<div class="vendredi">
			<h3>Vendredi <?php echo $j+5 ?></h3>
			<?php DivCoursOfDay($edt, $g, [$a, $m, $j+4]); ?>
		</div>
	</body>
</html>
