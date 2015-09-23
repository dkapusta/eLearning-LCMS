<?php
require('./components/biometrics/config.php');
require('./components/biometrics/components/csv.php');
require('./components/biometrics/components/db_handlers.php');
require('./components/biometrics/classes/Digraph.class.php');
require('./components/biometrics/classes/Attempt.class.php');
require('./components/biometrics/classes/AttemptsByPhrase.class.php');
require('./components/biometrics/ajax/calc_dmod.php');
require('./components/biometrics/ajax/match.php');

global $db;
$db = $db_array;

switch ($_POST['type']) {
    // button in progress table
    case 'get_score':
        include './components/biometrics/ajax/get_score.php';
        break;

    // trainer.js, captcha.js
    case 'save_data':
        include './components/biometrics/ajax/save_data.php';
        break;

    // all modals
    case 'get_phrase':
        include './components/biometrics/ajax/get_phrases.php';
        break;

    // authenticate.js
    case 'authenticate':
        include './components/biometrics/ajax/authenticate.php';
        break;

    // captcha.js
    case 'captcha':
        include './components/biometrics/ajax/save_data.php';
        break;

    case 'users-need-negatives':
        echo anyUserNeedsNegatives($_POST['userId']);
        break;

    case 'user-has-dmod':
        if (hasPositiveDMOD($_POST['userId'])) {
            echo 1;
        } else {
            echo 0;
        }
        break;

    // type: view
    case 'view':
        switch($_POST['mode']) {
            case 'train':
                include './components/biometrics/view/trainer.php';
                break;
            case 'authenticate';
                include './components/biometrics/view/authenticator.php';
                break;
            case 'captcha';
                include './components/biometrics/view/captcha.php';
                break;
        }

        break;
}
