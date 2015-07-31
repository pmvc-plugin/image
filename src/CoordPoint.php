<?php
namespace PMVC\PlugIn\image;

class CoordPoint
{
    public $x;
    public $y;
    public function __construct($x,$y)
    {
        $this->x = $x;
        $this->y = $y;
    }
}
