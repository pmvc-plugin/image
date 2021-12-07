<?php
namespace PMVC\PlugIn\image;

use PMVC\TestCase;

class ImageTest extends TestCase
{
    private $_plug='image';
    public function testPlugin()
    {
        ob_start();
        print_r(\PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->haveString($this->_plug,$output);
    }

    public function testFixedFloat()
    {
      $p = \PMVC\plug($this->_plug);
      $this->assertEquals('1.000000', $p->fixedFloat(1));
    }
}
