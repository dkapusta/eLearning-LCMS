<?php

class AttemptsByPhrase {
    public $phrase;
    public $keyCodes;
    public $attempts;

    function __construct($phrase, $keystrokes) {
        $this->attempts = [];
        $this->phrase = $phrase;

        foreach($keystrokes as $keystroke) {

            $newAttempt = new Attempt($keystroke);
            $this->attempts[] = $newAttempt;
            
            if (!isset($this->keyCodes)) {
                $this->keyCodes = $newAttempt->getKeyCodes();
            }    
        }
    }

    /*
     * Метод возвращает массив строк с таймингами
     */
    public function getAttemptsAsStrings() {
        $strings = [];
        
        foreach($this->attempts as $attempt) {
            $strings[] = $attempt->getString();
        }

        return $strings;
    }

    public function countAttempts() {
        return count($this->attempts);
    }

    public function getPhrase() {
        return $this->phrase;
    }

    public function getKeyCodesAsString() {
        return implode(",", $this->keyCodes);
    }

    public function getCSV() {
        $result           = "";
        $multipleAttempts = false;
        
        if (count($this->attempts) > 1) {
            $multipleAttempts = true;
            $result .= "repetition,";
        }

        for ($i = 1, $length = count($this->keyCodes); $i < $length; $i++) {
            $result .= "H["  . $this->keyCodes[$i-1] . "]," .
                       "H["  . $this->keyCodes[$i]   . "]," .
                       "DD[" . $this->keyCodes[$i-1] . "-"  . $this->keyCodes[$i] . "]," .
                       "DU[" . $this->keyCodes[$i-1] . "-"  . $this->keyCodes[$i] . "],";
        }

        $result = rtrim($result, ",");
        $strings = $this->getAttemptsAsStrings();
        
        foreach ($strings as $number => $attempt) {                
            $result .= "\n";

            if ($multipleAttempts) {
                $result .= ($number+1) . ",";
            }
            
            $result .= $attempt;
        }
        $result = rtrim($result, ",");
        
        return $result;
    }
}