<?php
namespace PMVC\PlugIn\image;

class ImageOutput
{
    public function __construct($im=null)
    {
        $this->im = $im;
    }

    public function setImage(ImageFile $im)
    {
        $this->im = $im->toGd();
    }

    public function png()
    {
        header ('Content-type: image/png');
        imagepng($this->im);
    }

    public static function toGd($object)
    {
        $io = new ImageOutput($object->toGd());
        $io->output();
    }

    public function output()
    {
        ob_start();
        $this->png();
        $output = ob_get_contents();
        ob_end_clean();
        imagedestroy($this->im);
        echo $output;
        flush();
    }
}
