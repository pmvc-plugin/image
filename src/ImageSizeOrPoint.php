<?php

namespace PMVC\PlugIn\image;

class ImageSizeOrPoint
{
     protected $p1;
     protected $p2;

    function __construct($p1 = 0, $p2 = 0)
    {
        if (is_array($p1)) {
            $this->p1 = $p1[0] ? $p1[0] : 0;
            $this->p2 = $p1[1] ? $p1[1] : 0;
        } elseif ($p1 instanceof ImageSize) {
            $this->p1 = $p1->w;
            $this->p2 = $p1->h;
        } elseif ($p1 instanceof Coord2D) {
            $this->p1 = $p1->x;
            $this->p2 = $p2->y;
        } else {
            $this->p1 = $p1;
            $this->p2 = $p2;
        }
    }

    function toPoint()
    {
        return new Coord2D($this->p1, $this->p2);
    }

    function toImageSize()
    {
        return new ImageSize($this->p1, $this->p2);
    }

    public function __toString()
    {
        return $this->toString();
    }
}
