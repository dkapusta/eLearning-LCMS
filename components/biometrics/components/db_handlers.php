<?php

function hasPositiveDMOD($userId) {
	global $db;

	$sql = "SELECT count(*) FROM " . $db['tables']['positive_dmod'] . " WHERE user_id = :user_id";

	$sth = $db['pdo']->prepare($sql);
	$sth->bindParam(":user_id", $userId);
	$sth->setFetchMode(\PDO::FETCH_ASSOC);
	$sth->execute();
	$result = $sth->fetchAll();

	return intval($result[0]['count(*)']) > 0;
}

function hasNegativeDMOD($userId) {
	global $db;

	$sql = "SELECT count(*) FROM " . $db['tables']['negative_dmod'] . " WHERE user_id = :user_id";

	$sth = $db['pdo']->prepare($sql);
	$sth->bindParam(":user_id", $userId);
	$sth->setFetchMode(\PDO::FETCH_ASSOC);
	$sth->execute();
	$result = $sth->fetchAll();

	return intval($result[0]['count(*)']) > 0;
}

function getSecretCode($userId) {
	global $db;

	$sql = "SELECT secret_code FROM " . $db['tables']['users'] . " WHERE id = :user_id";

    $sth = $db['pdo']->prepare($sql);
    $sth->bindParam(":user_id", $userId);
    $sth->setFetchMode(\PDO::FETCH_ASSOC);
    $sth->execute();
 	$result = $sth->fetchAll();

 	return $result[0]['secret_code'];
}

function getCaptcha($userId) {
	$id = getUserWhoNeedNegatives($userId);

	if(!isset($id)) {
		$id = getRandomUserID($userId);
	}

	if(!isset($id)) {
		$captcha = 'helloworld';
	} else {
		$captcha = getSecretCode($id);
	}

	return $captcha;
}

function getUserWhoNeedNegatives($userId) {
    global $db;

    $sql = "SELECT user_id FROM " . $db['tables']['users_requiring_negatives'] . " WHERE user_id <> :user_id ORDER BY RAND() LIMIT 1";

    $sth = $db['pdo']->prepare($sql);
    $sth->bindParam(":user_id", $userId);
    $sth->setFetchMode(\PDO::FETCH_ASSOC);
    $sth->execute();

	$user = $sth->fetchAll();

    return $user[0]['user_id'];
}

function getRandomUserID($userId) {
    global $db;

    $sql = "SELECT id FROM " . $db['tables']['users'] . " WHERE id <> :user_id ORDER BY RAND() LIMIT 1";

    $sth = $db['pdo']->prepare($sql);
    $sth->bindParam(":user_id", $userId);
    $sth->setFetchMode(\PDO::FETCH_ASSOC);
    $sth->execute();

	$id = $sth->fetchAll();

    return $id[0]['id'];
}

function getUserID($secretCode) {
    global $db;

    $sql = "SELECT id FROM " . $db['tables']['users'] . " WHERE secret_code = :secretCode";

    $sth = $db['pdo']->prepare($sql);
    $sth->bindParam(":secretCode", $secretCode);
    $sth->setFetchMode(\PDO::FETCH_ASSOC);
    $sth->execute();

	$id = $sth->fetchAll();

    return $id[0]['id'];
}

function userNeedsNegatives($userId) {
	global $db;

	$sql = "SELECT count(*) FROM " . $db['tables']['users_requiring_negatives'] . " WHERE user_id = :user_id";

	$sth = $db['pdo']->prepare($sql);
	$sth->bindParam(":user_id", $userId);
	$sth->execute();
	$sth->setFetchMode(\PDO::FETCH_ASSOC);
	$result = $sth->fetchAll();

	return $result[0]['count(*)'] > 0;
}

function anyUserNeedsNegatives($userId) {
	global $db;

	$sql = "SELECT count(*) FROM " . $db['tables']['users_requiring_negatives'] .
		   " WHERE user_id <> :user_id";


	$sth = $db['pdo']->prepare($sql);
	$sth->bindParam(":user_id", $userId);
	$sth->execute();
	$sth->setFetchMode(\PDO::FETCH_ASSOC);
	$result = $sth->fetchAll();

	if (intval($result[0]['count(*)']) > 0) {
		return 1;
	}

	return 0;
}

function removeFromRequireNegativesList($userId) {
	global $db;

	$sql = "DELETE FROM " . $db['tables']['users_requiring_negatives'] . " WHERE user_id = :user_id";

	$sth = $db['pdo']->prepare($sql);
	$sth->bindParam(":user_id", $userId);

	if ($sth->execute()) {
		return true;
	}

	return false;
}

function getNumNegatives($userId) {
	global $db;

	$sql = "SELECT count(*) FROM " . $db['tables']['negative_data'] . " WHERE user_id = :user_id";
	$sth = $db['pdo']->prepare($sql);
	$sth->bindParam(":user_id", $userId);
	$sth->execute();
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	$result = $sth->fetchAll();

	return $result[0]['count(*)'];
}

function getTrainingData($userId, $type, $number) {
	global $db;

	switch ($type) {
		case 'positive':
			$table = $db['tables']['positive_data'];
			break;
		case 'negative':
			$table = $db['tables']['negative_data'];
			break;
	}

	$sql = "SELECT * FROM (SELECT * FROM $table WHERE user_id = :user_id ORDER BY id DESC LIMIT $number" . ") sub ORDER BY id ASC";
 	$timing_data = [];

    $sth = $db['pdo']->prepare($sql);
    $sth->bindParam(":user_id", $userId);
    $sth->setFetchMode(\PDO::FETCH_ASSOC);
    $sth->execute();

	while($row = $sth->fetch()) {
		$timing_data[] = $row;
	}

    return $timing_data;
}

function storeDetectionModel($userId, $dmod, $type) {
	global $db;

	switch ($type) {
		case 'positive':
			$table = 'positive_dmod';
			break;
		case 'negative':
			$table = 'negative_dmod';
			break;
	}

	$sql = "INSERT INTO $table (user_id, dmod)" .
		   "VALUES (:user_id, :dmod)";

	$sth = $db['pdo']->prepare($sql);
	$sth->bindParam(":user_id", $userId);
	$sth->bindParam(":dmod", $dmod);

	if ($sth->execute()) {
		return true;
	}

	return false;
}

function updateDetectionModel($userId, $dmod, $type) {
	global $db;

	switch ($type) {
		case 'positive':
			$table = 'positive_dmod';
			break;
		case 'negative':
			$table = 'negative_dmod';
			break;
	}

	$sql = "UPDATE $table SET dmod = :dmod WHERE user_id = :user_id";

	$sth = $db['pdo']->prepare($sql);
	$sth->bindParam(":dmod", $dmod);
	$sth->bindParam(":user_id", $userId);

	if ($sth->execute()) {
		return true;
	}

	return false;
}

function getDetectionModel($userId, $type) {
	global $db;

	switch ($type) {
		case 'positive':
			$table = 'positive_dmod';
			break;
		case 'negative':
			$table = 'negative_dmod';
			break;
	}

	$sql = "SELECT dmod FROM $table" .
			" WHERE user_id = :user_id";

 	$dmod = [];

    $sth = $db['pdo']->prepare($sql);
    $sth->bindParam(":user_id", $userId);
    $sth->setFetchMode(\PDO::FETCH_ASSOC);
    $sth->execute();
 	$dmod = $sth->fetchAll();

 	return $dmod[0]['dmod'];
}

function makeDmod($userId, $type, $action) {
	$data = getTrainingData($userId, $type, 15);

	$keystrokes_strings = [];

	foreach ($data as $keystrokes) {
		$keystrokes_strings[] = $keystrokes['keystroke_data'];
	}
	$csv = getCSV($data[0]['keycodes'], $keystrokes_strings);

	$csv .= "\n";
	$path =  "./components/biometrics/ajax/data/";

	$timestamp = (new DateTime)->getTimestamp();
	$csvName   = $timestamp . '.csv';
	file_put_contents($path . $csvName, $csv);

	exec("Rscript ./components/biometrics/ajax/r/trainer.R" . ' 2>&1 ' . $csvName , $out, $return_status);
	unlink($path . $csvName);

	$dmod = implode("\n", $out);
	switch ($action) {
		case 'create':
			storeDetectionModel($userId, $dmod, $type);
			break;

		case 'update':
			updateDetectionModel($userId, $dmod, $type);
			break;
	}
}

function getCSVFromDB($userId) {
	$data = getTrainingData($userId, 'positive', 1);

	$keystrokes_strings = [];
	foreach ($data as $keystrokes) {
		$keystrokes_strings[] = $keystrokes['keystroke_data'];
	}

	$csv = getCSV($data[0]['keycodes'], $keystrokes_strings);

	return $csv;
}


function storeDelayedAttempt($userId, $courseId, $testId, $data) {
	global $db;

	$sql = "INSERT INTO " . $db['tables']['delayed_auth_attempts'] .
		   " (user_id, course_id, test_id, keycodes, keystroke_data) " .
		   "VALUES (:user_id, :course_id, :test_id, :keycodes, :keystroke_data)";

	$sth = $db['pdo']->prepare($sql);
	$sth->bindParam(":user_id", $userId);
	$sth->bindParam(":course_id", $courseId);
	$sth->bindParam(":test_id", $testId);
	$sth->bindValue(":keycodes", $data['keycodes'], PDO::PARAM_STR);
	$sth->bindValue(":keystroke_data", $data['keystroke_data'], PDO::PARAM_STR);

	if ($sth->execute()) {
		return true;
	}

	return false;
}

function removeDelayedAttempt($userId, $courseId, $testId) {
	global $db;

	$sql = "DELETE FROM " . $db['tables']['delayed_auth_attempts'] .
			" WHERE user_id = :user_id " .
			" AND course_id = :course_id " .
			" AND test_id = :test_id ";

	$sth = $db['pdo']->prepare($sql);
	$sth->bindParam(":user_id", $userId);
	$sth->bindParam(":course_id", $courseId);
	$sth->bindParam(":test_id", $testId);

	if ($sth->execute()) {
		return true;
	}

	return false;
}

function getDelayedAttempt($userId, $courseId, $testId) {
	global $db;

	$sql = "SELECT * FROM " . $db['tables']['delayed_auth_attempts'] .
			" WHERE user_id = :user_id " .
			" AND course_id = :course_id " .
			" AND test_id = :test_id LIMIT 1";

	$sth = $db['pdo']->prepare($sql);
	$sth->bindParam(":user_id", $userId);
	$sth->bindParam(":course_id", $courseId);
	$sth->bindParam(":test_id", $testId);

	$sth->execute();

	$result = $sth->fetchAll();

 	return $result[0];
}
