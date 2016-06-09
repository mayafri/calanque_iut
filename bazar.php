<?php


// CE FICHIER NE FAIT PAS PARTIE DU PROGRAMME ET NE DOIT PAS ÊTRE IMPORTÉ.


function calcDate($offset) {
	return array(date("Y"),
				 date("m"),
				 date("d", mktime(0, 0, 0, 0, date("d")+$offset, 0)));
}


?>
