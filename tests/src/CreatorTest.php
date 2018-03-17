<?php
namespace PMVC\PlugIn\image;

use PHPUnit_Framework_TestCase;

class CreatorTest extends PHPUnit_Framework_TestCase
{
    function testCreateFromFile()
    {
        $file = __DIR__.'/../resource/demo.jpg';
        $new = \PMVC\plug('image')->create($file);
        $this->assertTrue($new instanceof ImageFile);
        $this->assertEquals('jpg', $new->getExt());
    }

    function testCreateFromSize()
    {
        $size = new ImageSize(500, 500);
        $new = \PMVC\plug('image')->create($size);
        $this->assertTrue($new instanceof ImageCanvas);
        $this->assertTrue(is_resource($new->toGd()));
    }
}
