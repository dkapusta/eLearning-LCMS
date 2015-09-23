<?php

class Attempt {
    public $digraphs;

    function __construct($keystrokes) {
        $this->digraphs = [];
        $this->makeDigraphs($keystrokes);
    }

    public function makeDigraphs($keystrokes) {
        for ($i = 1, $length = count($keystrokes); $i < $length; $i++) {
            $digraph = new Digraph($keystrokes[$i-1], $keystrokes[$i]);
            $this->digraphs[] = $digraph;
        }
    }

    public function getString() {
        $result = "";

        foreach ($this->digraphs as $index => $digraph) {
            $result .= $digraph->getString() . ",";
        }

        $result = rtrim($result, ",");
        return $result;
    }

    public function getKeyCodes() {
        $digraphs = [];

        $digraphs[] = $this->digraphs[0]->firstKeyCode;

        foreach($this->digraphs as $digraph) {
            $digraphs[] = $digraph->secondKeyCode;  
        }
        
        return $digraphs;
    }

    public function getDigraphs() {
        return $this->digraphs;
    }
}