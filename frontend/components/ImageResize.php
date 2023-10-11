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
    private $path;

    /**
     * @var string
     */
    private $url;

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
            '.' . $ext[1];
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
            $this->path = Yii::getAlias('@uploads') . '/thumb';
            $this->url = '/uploads/thumb';

            $base = Yii::getAlias($this->path);
            $name = self::generateName($original, $width, $height, $prefix);

            // use hash file
            $hash = preg_replace(
                "%^(.{4})(.{4})(.{4})(.{4})(.{4})(.{4})(.{4})(.{4})%ius",
                "$1/$2/$3/$4/$5/$6/$7",
                md5($name)
            );
            $hash_name = $hash . '/' . $name;

            if (is_file($base . '/' . $hash_name)) {
                return $this->url . '/' . $hash_name;
            }

            list($imageWidth, $imageHeight) = getimagesize($original);
            $image = Image::getImagine()->open($original);

            $height = $width * $imageHeight / $imageWidth;
            $image->resize(new Box($width, $height));

            $image->effects()->sharpen();

            $dir = $this->path . '/' . $hash;

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            if ($image->save($base . '/' . $hash_name, ['quality' => 55])) {
                return $this->url . '/' . $hash_name;
            }
        }

        return null;
    }
}
