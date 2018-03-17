<?php
namespace PMVC\PlugIn\image;

class ImageFile extends ImageCanvas 
{
    const gif='gif';
    const jpg='jpg';
    const png='png';
    private $_path;

    public function __construct($file)
    {
       $this->_path = \PMVC\realpath($file); 
       if (empty($this->_path)) {
            return trigger_error('[ImageFile] file not exists');
       }
    }

    public function getExt()
    {
        $info = \PMVC\plug('image')
            ->info();
        return $info->getExt($this); 
    }

    public function getSize()
    {
        $info = \PMVC\plug('image')
            ->info();
        return $info->getSize($this); 
    }

    public function getPath()
    {
        return $this->_path;
    }

    public function toGd()
    {
       if (!$this->_gd) {
            $ext = $this->getExt(); 
            $path = $this->getPath();
            switch($ext){
            case self::gif:
                $gdImage = imagecreatefromgif($path);
                break;
            case self::jpg:
                $gdImage = imagecreatefromjpeg($path);
                break;
            case self::png:
                $gdImage = imagecreatefrompng($path);
                break;
            }
            $this->_gd = $gdImage;
       }
       return $this->_gd; 
    } 
}
