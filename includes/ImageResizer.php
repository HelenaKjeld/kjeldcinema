<?php
class ImageResizer{

    protected $image;
    protected $imageType;

    public function load($filename){
        $imageInfo = getimagesize($filename);
        $this->imageType = $imageInfo[2];
        if($this->imageType == IMAGETYPE_JPEG){
            $this->image = imagecreatefromjpeg($filename);
        }elseif($this->imageType == IMAGETYPE_GIF){
            $this->image = imagecreatefromgif($filename);
        }elseif ($this->imageType == IMAGETYPE_PNG){
            $this->image = imagecreatefrompng($filename);
        }
    }

    public function save($filename, $imageType = IMAGETYPE_JPEG, $compression = 100){
        if($imageType == IMAGETYPE_JPEG){
            imagejpeg($this->image, $filename, $compression);
        }elseif($imageType == IMAGETYPE_GIF){
            imagegif($this->image, $filename);
        }elseif ($imageType == IMAGETYPE_PNG){
            imagepng($this->image, $filename);
        }

    }

    protected function getWidth(){
        return imagesx($this->image);
    }
    protected function getHeight(){
        return imagesy($this->image);
    }

    public function resizeToHeight($height){
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize(round($width), round($height));
    }

    public function resizeToWidth($width){
        $ratio = $width / $this->getWidth();
        $height = $this->getHeight() * $ratio;
        $this->resize(round($width), round($height));
    }

    public function resizeToScale($scale){
        $width = $this->getWidth() * $scale / 100;
        $height = $this->getHeight() * $scale / 100;
        $this->resize(round($width), round($height));
    }

    public function resize($width, $height){
        $newImage = imagecreatetruecolor($width, $height);
        imagecopyresampled($newImage, $this->image, 0,0,0,0,
            $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $newImage;
    }


}


function doStuff($value){
    $rSize = new ImageResizer();
    $rSize->load("img.jpg");
    $rSize->resizeToWidth($value);
    $rSize->save("img2.jpg");
}
doStuff(800);