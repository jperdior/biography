<?php

namespace App\Service;

use Imagine\Imagick\Imagine;
use Imagine\Image\Box;

class ImageService{

    const THUMB_MAX_WIDTH = 150;
    const THUMB_MAX_HEIGHT = 200;

    private $imagine;

    public function __construct()
    {
        $this->imagine = new Imagine();
    }

    public function resizeImage(string $imagePath, string $privateDirectory){
        $this->resizeImageThumb($imagePath, $privateDirectory);
    }

    private function resizeImageThumb(string $imagePath, string $privateDirectory){
        list($iwidth, $iheight) = getimagesize($privateDirectory.$imagePath);
        $ratio = $iwidth / $iheight;
        $width = self::THUMB_MAX_WIDTH;
        $height = self::THUMB_MAX_HEIGHT;
        if ($width / $height > $ratio) {
            $width = $height * $ratio;
        } else {
            $height = $width / $ratio;
        }
        $image = $this->imagine->open($privateDirectory.$imagePath);
        $image->resize(new Box($width, $height));
        // dump($privateDirectory.'thumb/'.$imagePath);die;
        $image->save($privateDirectory.'thumb/'.$imagePath);

    }

}