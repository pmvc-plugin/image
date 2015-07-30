<?php
namespace PMVC\PlugIn\image;

// \PMVC\l(__DIR__.'/xxx.php');

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\image';

class image extends \PMVC\PlugIn
{
    public function getCenter($w,$h,$cutW=0,$cutH=0)
    {
        $x = round($w / 2);
        $y = round($h / 2);
        $x -= round($cutW/2);
        $y -= round($cutH/2);
        return (object)array('x'=>$x,'y'=>$y);
    }
}
