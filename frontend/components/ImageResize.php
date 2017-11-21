<?php

namespace frontend\components;

use Yii;
use yii\imagine\Image;
use Imagine\Image\{
    Box
};
use yii\base\{
    Component
};

/**
 * Class ImageResize
 *
 * @package frontend\components
 */
class ImageResize extends Component
{
    const BASE_PATH_TO_CACHE = '@uploads/thumbs';
    const BASE_URL_TO_CACHE = '/uploads/thumbs/';

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
    public static function getThumb($original, $width, $height, $prefix = '-{$width}x{$height}')
    {
        if (is_file($original)) {

            $base = Yii::getAlias(self::BASE_PATH_TO_CACHE) . '/';
            $name = self::generateName($original, $width, $height, $prefix);

            if (is_file($base . $name)) {
                return self::BASE_URL_TO_CACHE . $name;
            }

            list($imageWidth, $imageHeight) = getimagesize($original);
            $image = Image::getImagine()->open($original);

            $height = $width * $imageHeight / $imageWidth;
            $image->resize(new Box($width, $height));

            if ($image->save($base . $name, ['quality' => 100])) {
                return self::BASE_URL_TO_CACHE . $name;
            }
        }

        return null;
    }
}
