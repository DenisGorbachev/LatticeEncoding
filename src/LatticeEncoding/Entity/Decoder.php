<?php

namespace LatticeEncoding\Entity;

class Decoder
{
    /** @var Lattice */
    public $lattice;

    function __construct($lattice)
    {
        $this->lattice = $lattice;
    }

    public function setLattice($lattice)
    {
        $this->lattice = $lattice;
    }

    public function getLattice()
    {
        return $this->lattice;
    }

    public function decodeString($input)
    {
        $array = array(array());
        $index = 0;
        while ($index < mb_strlen($input)) {
            if (count($array[count($array) - 1]) >= $this->lattice->getXLength()) {
                $array[] = array();
            }
            $array[count($array) - 1][] = mb_substr($input, $index, 1);
            $index++;
        }
        return $this->decodeArray($array);
    }

    public function decodeArray($input)
    {
        $lattice = clone $this->lattice;
        $decodedString = '';
        for ($i = 0; $i < 4; $i++) {
            $decodedString .= $lattice->read($input);
            if ($i % 2 == 0) {
                $lattice->mirrorVertically();
            } else {
                $lattice->mirrorHorizontally();
            }
        }
        return $decodedString;
    }


}
