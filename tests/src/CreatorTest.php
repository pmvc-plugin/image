<?php
namespace PMVC\PlugIn\image;

use PHPUnit_Framework_TestCase;

class CreatorTest extends PHPUnit_Framework_TestCase
{
    function testCreateFromFile()
    {
        $file = new ImageFile(__DIR__.'/../resource/demo.jpg');
        $new = \PMVC\plug('image')->create($file);
        $this->assertTrue(is_resource($new));
    }

    function testCreateFromSize()
    {
        $size = new ImageSize(500, 500);
        $new = \PMVC\plug('image')->create($size);
        $this->assertTrue(is_resource($new));
    }
}
