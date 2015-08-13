<?php
namespace PMVC\PlugIn\image;

class Coord2D
{
    public $x;
    public $y;
    public function __construct($x,$y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function toString()
    {
        return $this->x.','.$this->y;
    }

    public function __tostring()
    {
        return $this->toString();
    }

    public function getx()
    {
        return round($this->x);
    }

    public function gety()
    {
        return round($this->y);
    }
}
