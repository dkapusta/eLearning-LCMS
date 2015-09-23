<?php

class Digraph {
    public $firstKeyCode;
    public $secondKeyCode;
    public $downToDown;
    public $firstDwell;
    public $secondDwell;
    public $downToUp;

    function __construct($firstKeystroke, $secondKeystroke) {
        $this->firstKeyCode  = $firstKeystroke['keyCode'];
        $this->secondKeyCode = $secondKeystroke['keyCode'];
        $this->getTimings($firstKeystroke, $secondKeystroke);
    }

    public function getTimings($firstKeystroke, $secondKeystroke) {
        $this->downToDown  = $this->msToSec($secondKeystroke['timeDown'] - $firstKeystroke['timeDown']);
        $this->firstDwell  = $this->msToSec($firstKeystroke['timeUp'] - $firstKeystroke['timeDown']);
        $this->secondDwell = $this->msToSec($secondKeystroke['timeUp'] - $secondKeystroke['timeDown']);
        $this->downToUp    = $this->msToSec($secondKeystroke['timeUp'] - $firstKeystroke['timeDown']);
    }

    public function getString() {
        $result = "";
        $result .= $this->firstDwell  . "," .
                   $this->secondDwell . "," .
                   $this->downToDown  . "," .
                   $this->downToUp;

        return $result;
    }

    public function msToSec($ms) {
        return $ms * 0.001;
    }
}