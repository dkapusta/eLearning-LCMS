<?php

function getDistance($csv, $type) {
	$pathDmod  =  "./components/biometrics/ajax/dmod/";
	$pathCSV   =  "./components/biometrics/ajax/data/";
	$timestamp = (new DateTime)->getTimestamp();
	$csvName   = $timestamp . '.csv';
	$dmodName  = $timestamp;
	$userId    = $_POST['userId'];
	$timestamp = $_POST['timestamp'];

	userHasPDMOD($userId, $_POST['type']);
	checkIfUserHasEnoughNegative($userId);

	switch ($type) {
		case 'positive':
			$dmod = getDetectionModel($userId, 'positive');
			break;
		
		case 'negative':
			$dmod = getDetectionModel($userId, 'negative');
			break;
	}

	file_put_contents($pathDmod . $dmodName, $dmod);
	file_put_contents($pathCSV  . $csvName,  $csv);

	exec("Rscript ./components/biometrics/ajax/r/authenticator.R" . ' 2>&1 ' . $dmodName . " " . $csvName , $out, $return_status);
	unlink($pathDmod . $dmodName);
	unlink($pathCSV  . $csvName);

	$score = floatval(end($out));

	return $score;
}