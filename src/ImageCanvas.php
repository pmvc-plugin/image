<?php
namespace PMVC\PlugIn\image;

use InvalidArgumentException;

class ImageCanvas 
{
    private $_size;
    protected $_gd;
    use TraitImageCanvas;

    public function __construct($input)
    {
       if (!($input instanceof ImageSize)) {
           throw new InvalidArgumentException(
            json_encode([
                '[Image]'=>'input not a ImageSize',
                'input'=>$input
             ])
           );
       }
       $this->_size = $input;
    }

    public function getSize()
    {
        return $this->_size;
    }

    public function toGd()
    {
       if (!$this->_gd) {
            $this->_gd = imagecreatetruecolor(
                $this->_size->w,
                $this->_size->h
            );
       }
       return $this->_gd; 
    }
}
