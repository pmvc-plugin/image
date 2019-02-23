<?php
namespace PMVC\PlugIn\image;

use PHPUnit_Framework_TestCase;

class ImageTest extends PHPUnit_Framework_TestCase
{
    private $_plug='image';
    public function testPlugin()
    {
        ob_start();
        print_r(\PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains($this->_plug,$output);
    }

    public function testFixedFloat()
    {
      $p = \PMVC\plug($this->_plug);
      $this->assertEquals('1.000000', $p->fixedFloat(1));
    }
}
