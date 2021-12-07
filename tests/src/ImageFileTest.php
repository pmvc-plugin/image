<?php
namespace PMVC\PlugIn\image;

use PMVC\TestCase;

class ImageFileTest extends TestCase
{
    private $_demo =__DIR__.'/../resource/demo.jpg'; 
    function testGetPixel()
    {
        $img = new ImageFile($this->_demo);
        $color =  $img->getPixel(new Coord2D(0, 0));
        $this->assertEquals('38,101,207', (string)$color);
    }

    function testSetPixel()
    {
        $img = new ImageFile($this->_demo);
        $myColor = \PMVC\plug('color')->getColor(
            255,
            0,
            0
        );
        $point = new Coord2D(0, 0);
        $img->setPixel(
           $point,
           $myColor
        );
        $myPixel = $img->getPixel($point);
        $this->assertEquals((string)$myColor, (string)$myPixel);
    }
}
