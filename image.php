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

    public function getDistance(CoordPoint $a, CoordPoint $b)
    {
        $d = sqrt ( 
             pow(($b->x - $a->x),2) +
             pow(($b->y - $a->y),2)
        );
        return $d;
    }

    public function absAngle($angle)
    {
        if ($angle<0) {
            $angle = 360 + $angle;
        }
        return round($angle);
    }

    public function getAngle(CoordPoint $a, CoordPoint $b)
    {
        $Opposite = $b->y - $a->y;
        $Adjacent = $b->x - $a->x;
        $Angle = rad2deg(atan2($Opposite,$Adjacent));
        if (!(0>=$Opposite && 0>=$Adjacent)
            && !(0<=$Opposite && 0<=$Adjacent)
           ) {
           $Angle+=180;
        }
        return $this->absAngle($Angle);
    }

    public function flot($flot){
        return sprintf("%' 9.6f",$flot);
    }

    /**
     * get geo point "a", angle "angle", and dis "m"
     * return geo point "b"
     */
    public function getPointByDistance(CoordPoint $pa, $angle, $len)
    {
        $angle = deg2rad($angle);
        $x2 = $len * $this->flot(cos($angle)) + $pa->x;
        $y2 = $len * $this->flot(sin($angle)) + $pa->y; 
        $pb = new CoordPoint($x2,$y2);
        return $pb;
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
