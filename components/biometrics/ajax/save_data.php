<?php

$rawData   = json_decode($_POST['data'], true);
$timestamp = $_POST['timestamp'];
$userId    = $_POST['userId'];
$type      = $_POST['type'];

$data = [];
$captchasUsers = [];

foreach($rawData as $input => $attemptsByPhrase) {
	$data[$input] = [];

    foreach($attemptsByPhrase as $phrase => $keystrokes) {
        $data[$input][] = new AttemptsByPhrase($phrase, $keystrokes);

        if ($input == 'captcha') {
            $captchasUsers[] = $phrase;
        }
    }
}

try {
    $users = [];
    $sql = "SELECT * from " . $db['tables']['users'] . " WHERE secret_code IN (";

    foreach ($data as $input => $attemptsByInput) {
    	foreach ($attemptsByInput as $attemptsByPhrase) {
    		$users[] = $attemptsByPhrase->getPhrase();
    		$sql .= "?,";
    	}
    }

    $sql = rtrim($sql, ",");
    $sql .= ")";

    $STH = $db['pdo']->prepare($sql);
    for ($i = 1, $length = count($users); $i <= $length; $i++) {
    	$STH->bindParam($i, $users[$i-1]);
    }

    $STH->setFetchMode(PDO::FETCH_ASSOC);
    $STH->execute();
	$users = $STH->fetchAll();

	$ids = [];
	foreach ($users as $user) {
		$ids[$user['secret_code']] = $user['id'];
	}

    foreach($data as $input => $attemptsByInput) {
    	$tableName = '';
    	$numberOfValues = 0;

    	switch ($input) {
    		case 'secretCode':
    			$tableName = $db['tables']['positive_data'];
    			break;
    		case 'captcha':
    			$tableName = $db['tables']['negative_data'];
    			break;
    	}

    	$sql = "INSERT INTO $tableName (user_id, keycodes, keystroke_data) VALUES ";


    	foreach ($attemptsByInput as $attemptsByPhrase) {
    		$phrase   = $attemptsByPhrase->getPhrase();
    		$keyCodes = $attemptsByPhrase->getKeyCodesAsString();
	        $count    = $attemptsByPhrase->countAttempts();

	        for($i = 0; $i < $count; $i++){
	        	$sql .= "(:$i" . $phrase . "id, :$i" . $phrase . "keycodes, :$i" . $phrase . "data),";
	        }

    	}

    	$sql = rtrim($sql, ",");
    	$sth = $db['pdo']->prepare($sql);

    	foreach ($attemptsByInput as $attemptsByPhrase) {
    		$phrase     = $attemptsByPhrase->getPhrase();
	        $keystrokes = $attemptsByPhrase->getAttemptsAsStrings();

    		foreach ($keystrokes as $number => $keystroke) {
				$sth->bindValue(":" . $number . $phrase . "id"      , $ids[$phrase], PDO::PARAM_STR);
				$sth->bindValue(":" . $number . $phrase . "keycodes", $keyCodes,     PDO::PARAM_STR);
				$sth->bindValue(":" . $number . $phrase . "data"    , $keystroke,    PDO::PARAM_STR);
			}
    	}

		if ($sth->execute()) {
            echo "\n$input success\n";
        } else {
            echo "\n$input failure\n";
        }
    }

    if ($type != 'captcha') {
        userHasPDMOD($userId, $type);
        checkIfUserHasEnoughNegative($userId);
    }

    foreach ($captchasUsers as $user) {
        checkIfUserHasEnoughNegative(getUserId($user));
    }

} catch(Exception $e) {
    echo $e->getMessage();
}
