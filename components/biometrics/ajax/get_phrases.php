<?php

try {
	$courseId = $_POST['courseId'];
	$userId   = $_POST['userId'];
	$field    = $_POST['field'];

	switch ($field) {
		case 'secretCode':
			$response = getSecretCode($userId);
			break;
		case 'captcha':
			$response = getCaptcha($userId);
			break;
	}
} catch(Exception $e) {
    $response = $e->getMessage();
}

echo $response;