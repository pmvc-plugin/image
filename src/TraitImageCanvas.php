<?php

namespace PMVC\PlugIn\image;
use PMVC\PlugIn\color\BaseColor;

trait TraitImageCanvas 
{
    public function __destruct()
    {
        if (\PMVC\plug('image')->isGd($this->_gd)) {
            ImageDestroy($this->_gd);
            $this->_gd = null;
            unset($this->_gd);
        }
    }

    public function getPixel(Coord2D $point)
    {
        $natGd = $this->toGd();
        $rgbInt = imagecolorat(
            $natGd,
            $point->x,
            $point->y
        );
        $rgbArr = imagecolorsforindex($natGd, $rgbInt);
        $color = \PMVC\plug('color');
        return $color->getColor($rgbArr['red'], $rgbArr['green'], $rgbArr['blue'], $rgbArr['alpha']);
    }
        
    public function setPixel(Coord2D $point, BaseColor $color)
    {
        imagesetpixel(
            $this->toGd(),
            $point->x, $point->y,
            $color->toGd($this->toGd())
        );
    }
}
