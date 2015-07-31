<?php
namespace PMVC\PlugIn\image;

// \PMVC\l(__DIR__.'/xxx.php');

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\image';

class image extends \PMVC\PlugIn
{
    private $_info;
    private $_creator;

    public function getCenter(ImageSize $size, ImageSize $cut=null)
    {
        $aSize = $size->toArray();
        if (is_null($cut)){
            $cut = new ImageSize();
        }
        $aCut = $cut->toArray();
        $x = round($aSize['w'] / 2);
        $y = round($aSize['h'] / 2);
        $x -= round($aCut['w'] / 2);
        $y -= round($aCut['h'] / 2);
        return new CoordPoint($x,$y);
    }

    public function distanceCalculator(
        CoordPoint $a,
        CoordPoint $b
    )
    {
        $d = sqrt ( 
             pow(($b->x - $a->x),2) +
             pow(($b->y - $a->y),2)
        );
        return $d;
    }

    public function getImageInfoObject() {
        if (empty($this->_info)) {
            $this->_info = new ImageInfo(); 
        }
        return $this->_info;
    }

    public function getImageCreator() {
        if (empty($this->_creator)) {
            $this->_creator = new ImageCreate(); 
        }
        return $this->_creator;
    }
}
