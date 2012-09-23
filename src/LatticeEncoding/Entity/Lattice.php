<?php

namespace LatticeEncoding\Entity;

class Lattice
{
    public $data;

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function loadFromFile($filename)
    {
        $fp = fopen($filename, 'r');
        while ($line = fgets($fp)) {
            $matches = array();
            preg_match_all('/1|0/', $line, $matches, PREG_PATTERN_ORDER);
            $matches = $matches[0];
            if (!empty($matches)) {
                $this->data[] = $matches;
            }
        }
    }

    public function punch($input, $encodedArray)
    {
        $inputCharacterIndex = 0;
        foreach ($this->data as $i => $row) {
            foreach ($row as $y => $hole) {
                if ($hole) {
                    $character = mb_substr($input, $inputCharacterIndex, 1) ?: ' ';
                    $encodedArray[$i][$y] = $character;
                    $inputCharacterIndex++;
                }
            }
        }
        return $encodedArray;
    }

    public function getArea()
    {
        return $this->getYLength() * $this->getXLength();
    }

    public function getXLength()
    {
        return count($this->data[0]);
    }

    public function getYLength()
    {
        return count($this->data);
    }

    public function mirrorVertically()
    {
        for ($y = 0; $y < $this->getYLength(); $y++) {
            for ($x = 0; $x < $this->getXLength() / 2; $x++) {
                $temp = $this->data[$y][$this->getXLength() - $x - 1];
                $this->data[$y][$this->getXLength() - $x - 1] = $this->data[$y][$x];
                $this->data[$y][$x] = $temp;
            }
        }
    }

    public function mirrorHorizontally()
    {
        for ($y = 0; $y < $this->getYLength() / 2; $y++) {
            for ($x = 0; $x < $this->getXLength(); $x++) {
                $temp = $this->data[$this->getYLength() - $y - 1][$x];
                $this->data[$this->getYLength() - $y - 1][$x] = $this->data[$y][$x];
                $this->data[$y][$x] = $temp;
            }
        }
    }

    public function read($input)
    {
        $readString = '';
        foreach ($this->data as $y => $row) {
            foreach ($row as $x => $hole) {
                if ($hole) {
                    $readString .= $input[$y][$x];
                }
            }
        }
        return $readString;
    }

}
