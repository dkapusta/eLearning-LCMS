<?php

function getScore($userId, $courseId, $testId) {
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

	$data = getDelayedAttempt($userId, $courseId, $testId);
	$csv  = getCSV($data['keycodes'],
		     	  [$data['keystroke_data']]);

	$scores['genuine']['positive'] = getDistance($csv, 'positive');
	$scores['genuine']['negative'] = getDistance($csv, 'negative');

	$csv   = getCSVFromDB($userId);
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

$userId   = $_POST['userId'];
$courseId = $_POST['courseId'];
$testId   = $_POST['testId'];

if (checkIfUserHasEnoughNegative($userId)) {
	$score = getScore($userId, $courseId, $testId);
	removeDelayedAttempt($userId, $courseId, $testId);

	echo $score;
} else {
	echo -1;
}