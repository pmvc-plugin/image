<?php
namespace PMVC\PlugIn\image;

class ImageSize
{
    public $w;
    public $h;

    function __construct($w=0, $h=0)
    {
        $this->w = $w;
        $this->h = $h;
    }

    function toString()
    {
        return $this->w.'x'.$this->h;
    }

    function toArray()
    {
        return array(
            'w'=>$this->w,
            'h'=>$this->h
        );
    }
}
