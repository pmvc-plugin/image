<?php
namespace PMVC\PlugIn\image;

use PHPUnit_Framework_TestCase;

class ImageTest extends PHPUnit_Framework_TestCase
{
    private $_plug='image';
    function testPlugin()
    {
        ob_start();
        print_r(\PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains($this->_plug,$output);
    }

    function testToImage()
    {
        $f = __DIR__.'/resource/demo.jpg';
        $pImage = \PMVC\plug($this->_plug); 
        $image = $pImage->toImage($f);
        $this->assertEquals('jpg', $image->getExt());
    }
}
