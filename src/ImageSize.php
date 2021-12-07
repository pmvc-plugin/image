<?php
namespace PMVC\PlugIn\image;

class ImageSize
{
    public $w;
    public $h;

    function __construct($w = 0, $h = 0)
    {
        if (is_array($w)) {
            $this->w = $w[0] ?? 0;
            $this->h = $w[1] ?? 0;
        } else if ($w instanceof ImageSize) {
            $this->w = $w->w;
            $this->h = $w->h;
        } else {
            $this->w = $w;
            $this->h = $h;
        }
    }

    function toPoint()
    {
        return new Coord2D($this->w, $this->h);  
    }

    function toString()
    {
        return $this->w . 'x' . $this->h;
    }

    function toArray()
    {
        return [
            'w' => $this->w,
            'h' => $this->h,
        ];
    }
}
