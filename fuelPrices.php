<?php
	/**
	 * Simple webscrapper script for retrieving average
	 * current fuel prizes in Poland from autocentrum.pl
	 */

	$url = 'https://www.autocentrum.pl/paliwa/ceny-paliw/';
	$urlData = file($url);

	$fuelTypes = ['PB95', 'PB98', 'ON', 'ON+', 'LPG'];
	$scrappedData = [];

	for ($i=0; $i < count($urlData); $i++){
		if (!strpos($urlData[$i], '<div class="fuels-wrapper choose-petrol">')){
			continue;
		}

		# if line is found
		$j = $i;
		while (!strpos($urlData[$j], '<div class="petrols-wrapper">')){
			$line = ltrim(rtrim($urlData[$j]));
			if (strlen($line) == 4 && $line[0] != '<'){
				array_push($scrappedData, $line);				
			}
			$j++;
		}
		break;
	}

	echo "\n";
	for ($i=0; $i < count($fuelTypes); $i++){
		echo "{$fuelTypes[$i]} : {$scrappedData[$i]} zł\n";
	}

	$currentDateTime = date('d/m/Y H:i');
	echo "\nsrc: autocentrum.pl ({$currentDateTime} UTC)\n";