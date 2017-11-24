<?php

namespace frontend\components;

use Yii;
use yii\imagine\Image;
use Imagine\Image\{
    Box
};

/**
 * Class ImageResize
 *
 * @package frontend\components
 */
class ImageResize
{
    /**
     * @var string
     */
    public $path;

    /**
     * @var string
     */
    public $url;

    /**
     * ImageResize constructor.
     * @param $path
     * @param $url
     */
    public function __construct($path, $url)
    {
        $this->path = $path;
        $this->url = $url;
    }

    /**
     * @param $image
     * @param $width
     * @param $height
     * @param string $prefix
     * @return string
     */
    public static function generateName($image, $width, $height, $prefix = '-{$width}x{$height}')
    {
        $ext = explode(".", strtolower(basename($image)));

        return $ext[0] .
            str_replace(['{$width}', '{$height}'], [$width, $height], $prefix) .
            '.' .$ext[1];
    }

    /**
     * @param $original
     * @param $width
     * @param $height
     * @param string $prefix
     * @return null|string
     */
    public function getThumb($original, $width, $height, $prefix = '-{$width}x{$height}')
    {
        if (is_file($original)) {

            $base = Yii::getAlias($this->path);
            $name = self::generateName($original, $width, $height, $prefix);

//            if (is_file($base . '/' . $name)) {
//                return $this->url . '/' .  $name;
//            }

            list($imageWidth, $imageHeight) = getimagesize($original);
            $image = Image::getImagine()->open($original);

            $height = $width * $imageHeight / $imageWidth;
            $image->resize(new Box($width, $height));

            $image->effects()->sharpen();

            if ($image->save($base . '/' . $name, ['quality' => 100])) {
                return $this->url . '/' . $name;
            }
        }

        return null;
    }
}
