<?php

namespace LatticeEncoding\Entity;

class Encoder
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

    public function encodeAsString($input)
    {
        $encodedString = '';
        foreach ($this->encodeAsArray($input) as $row) {
            foreach ($row as $character) {
                $encodedString .= $character;
            }
        }
        return $encodedString;
    }

    public function encodeAsArray($input)
    {
        $lattice = clone $this->lattice;
        $encodedArray = $lattice->getData();
        for ($i = 0; $i < 4; $i++) {
            $encodedArray = $lattice->punch($input, $encodedArray);
            $input = mb_substr($input, $lattice->getArea() / 4);
            if ($i % 2 == 0) {
                $lattice->mirrorVertically();
            } else {
                $lattice->mirrorHorizontally();
            }
        }
        return $encodedArray;
    }


}
