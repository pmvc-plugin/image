<?php
namespace PMVC\PlugIn\image;

class ImageSize extends ImageSizeOrPoint
{
    public $w;
    public $h;

    function __construct($w = 0, $h = 0)
    {
        parent::__construct($w, $h);
        $this->w = $this->p1;
        $this->h = $this->p2;
    }

    protected function toString()
    {
        return $this->w . 'x' . $this->h;
    }

    public function toArray()
    {
        return [
            'w' => $this->w,
            'h' => $this->h,
        ];
    }
}
