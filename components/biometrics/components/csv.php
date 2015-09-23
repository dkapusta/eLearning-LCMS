<?php

function getCSV($keycodes_string, $attempts) {
	$keycodes = explode(",", $keycodes_string);

	$result           = "";
    $multipleAttempts = false;
    
    if (count($attempts) > 1) {
        $multipleAttempts = true;
        $result .= "repetition,";
    }

    for ($i = 1, $length = count($keycodes); $i < $length; $i++) {
        $result .= "H["  . $keycodes[$i-1] . "]," .
                   "H["  . $keycodes[$i]   . "]," .
                   "DD[" . $keycodes[$i-1] . "-"  . $keycodes[$i] . "]," .
                   "DU[" . $keycodes[$i-1] . "-"  . $keycodes[$i] . "],";
    }

    $result = rtrim($result, ",");
    
    foreach ($attempts as $number => $attempt) {                
        $result .= "\n";

        if ($multipleAttempts) {
            $result .= ($number+1) . ",";
        }
        
        $result .= $attempt;
    }
    $result = rtrim($result, ",");
    
    return $result;
}