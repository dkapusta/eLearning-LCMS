<?php

function getCSVFromRequest() {
	$rawData = json_decode($_POST['data'], true);

	$data = [];
	foreach($rawData as $input => $attemptsByPhrase) {
		$data[$input] = [];

	    foreach($attemptsByPhrase as $phrase => $keystrokes) {
	        $data[$input][] = new AttemptsByPhrase($phrase, $keystrokes);
	    }
	}

	$csv = $data['secretCode'][0]->getCSV() . "\n";

	return $csv;
}


function getKeydataFromRequest() {
	$rawData = json_decode($_POST['data'], true);

	$data = [];
	foreach($rawData as $input => $attemptsByPhrase) {
		$data[$input] = [];

	    foreach($attemptsByPhrase as $phrase => $keystrokes) {
	        $data[$input][] = new AttemptsByPhrase($phrase, $keystrokes);
	    }
	}
	$result = [
		"keycodes" => "",
		"keystroke_data" => ""
	];

	$result["keystroke_data"] = $data['secretCode'][0]->getAttemptsAsStrings()[0];
	$result["keycodes"]       = $data['secretCode'][0]->getKeyCodesAsString();

	return $result;
}

function getFinalScore() {
	$userId = $_POST['userId'];
	$scores = [
		'genuine' => [
			'positive' => 0,
			'negative' => 0,
			'relation' => 0,
		],
		'test'    => [
			'positive' => 0,
			'negative' => 0,
			'relation' => 0,
		]
	];

	$csv   = getCSVFromDB($userId);
	$scores['genuine']['positive'] = getDistance($csv, 'positive');
	$scores['genuine']['negative'] = getDistance($csv, 'negative');

	$csv    = getCSVFromRequest();
	$scores['test']['positive'] = getDistance($csv, 'positive');
	$scores['test']['negative'] = getDistance($csv, 'negative');

	foreach ($scores as $type => $score) {
		$scores[$type]['relation'] = $score['positive'] / $score['negative'];

		if ($scores[$type]['relation'] > 0.99) {
			$scores[$type]['relation'] = 1;
		}
	}

	$finalScore =  $scores['test']['relation'] * 0.9
				+ ($scores['genuine']['positive'] / $scores['test']['positive']) * 0.1;

	if ($finalScore > 0.99) {
		$finalScore = 1;
	}
	echo (1 - $finalScore) * 100;
}

if (hasNegativeDMOD($_POST['userId'])) {
	$score = getFinalScore();

	echo $score;	
} else {
	$keystrokes_data = getKeydataFromRequest();
	
	storeDelayedAttempt($_POST['userId'],
						$_POST['courseId'],
						$_POST['testId'],
						$keystrokes_data);

	echo -1;
}