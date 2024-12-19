<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Storage;

class ImagePreview extends Component
{
    public $imagePath;
    public $maxWidth;

    public function __construct($imagePath, $maxWidth = '200px')
    {
        $this->imagePath = $imagePath;
        $this->maxWidth = $maxWidth;
    }

    public function getImageSizeInfo()
    {
       if (!$this->imagePath) {
           return null;
       }
       
       $path = public_path($this->imagePath);
       if(!file_exists($path))
       {
          return null;
       }

       list($width, $height) = getimagesize($path);
       $filesize = filesize($path);
       return [
            'width' => $width,
            'height' => $height,
        ];
    }

    public function render()
    {
        return view('components.image-preview');
    }
}