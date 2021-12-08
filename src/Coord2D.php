<?php

namespace PMVC\PlugIn\image;

class Coord2D extends ImageSizeOrPoint
{
    public $x;
    public $y;
    public function __construct($x = 0, $y = 0)
    {
        parent::__construct($x, $y);
        $this->x = $this->p1;
        $this->y = $this->p2;
    }

    protected function toString()
    {
        return $this->x . ',' . $this->y;
    }

    public function toArray()
    {
        return [
            'x' => $this->x,
            'y' => $this->y,
        ];
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
