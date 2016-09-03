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

$dparms = new DisplayParams();
if (isset($_GET['ccs'])) {
	$dparms->colorCrcSalt = $_GET['ccs'];
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Calanque</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" media="screen" href="screen.css" />
		<link rel="stylesheet" media="screen" href="css/euqnalac.css" />
	</head>
	<body>
		<form action="index.php" method="GET">
			<header><button name="t" value="<?php echo $lundi-604800 ?>"><i class="icon-left-open"></i></button><h1>Semaine du <?php echo $d ?>/<?php echo $m ?>/<?php echo $Y ?></h1><button name="t" value="<?php echo $lundi+604800 ?>"><i class="icon-right-open"></i></button></header>

			<select name="g">
				<?php ComboboxGroups($edt, $g); ?>
			</select>
			<button name="t" value="<?php echo $lundi ?>">OK</button>
		</form>
		
		<div class="semaine">
			<div class="jour lundi">
				<h3>Lundi <?php echo date('d', $lundi) ?></h3>
				<?php DivCoursOfDay($edt, $g, $lundi, $dparms); ?>
			</div>
			<div class="jour mardi">
				<h3>Mardi <?php echo date('d', $lundi+86400) ?></h3>
				<?php DivCoursOfDay($edt, $g, $lundi+86400, $dparms); ?>
			</div>
			<div class="jour mercredi">
				<h3>Mercredi <?php echo date('d', $lundi+86400*2) ?></h3>
				<?php DivCoursOfDay($edt, $g, $lundi+86400*2, $dparms); ?>
			</div>
			<div class="jour jeudi">
				<h3>Jeudi <?php echo date('d', $lundi+86400*3) ?></h3>
				<?php DivCoursOfDay($edt, $g, $lundi+86400*3, $dparms); ?>
			</div>
			<div class="jour vendredi">
				<h3>Vendredi <?php echo date('d', $lundi+86400*4) ?></h3>
				<?php DivCoursOfDay($edt, $g, $lundi+86400*4, $dparms); ?>
			</div>
		</div>

		<footer>Emploi du temps Calanque pour l'IUT Lyon 1 sous <a href="https://www.gnu.org/licenses/agpl-3.0.html">licence libre AGPLv3</a>. <a href="https://git.thgros.fr/hyakosm/calendrier">Git</a>.</footer>
	</body>
</html>
