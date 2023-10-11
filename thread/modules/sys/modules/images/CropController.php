<?php

namespace frontend\modules\catalog\controllers;

use Yii;

/**
 * Class CropController
 *
 * @package frontend\modules\catalog\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class CropController extends \frontend\components\BaseController {

    public $title = "Crop Image into Catalog";
    public $layout = "@app/layouts/column1";
    public $defaultAction = 'index';
    protected $arr_to_optim = [];

    /**
     *
     * METHOD TO ADD IMAGE TO CATALOG
     *
     * START FOLDER
     * Yii::getAlias("@root") . "/imgtosite"
     *
     * OUTPUT FOLDER
     * Yii::$app->getModule('catalog')->getArticleImageBasePath()  ---   TO IMAGE
     * Yii::$app->getModule('catalog')->getArticleGalleryBasePath()  ---   TO GALLERY
     *
     * HOW USES
     *
     * ADD TO CRON METHOD
     *    "* 3 * * * /usr/bin/wget -O - -q -t 1 'http://domain/index?secretKey=thread'"
     *
     * @param string $secretKey
     * @throws \yii\web\NotFoundHttpException
     *
     * /to BASH
     * // MASS RESIZE
     *  for file in *.*; do convert $file -resize 90% $file; done
     *
     */
    public function actionIndex($secretKey) {

        if ($secretKey !== 'thread') {
            throw new \yii\web\NotFoundHttpException;
        }

        set_time_limit(7200);

        // FIND MODELS INTO BASE
        foreach (Article::find()->batch(100) as $list) {
            foreach ($list as $item) {
                // IMAGE
                $img = $item->getImagePath();
                if (is_file($img)) {
                    $this->create_main_thumbs($img);
                }
                // GALLERY
                $g = explode(',', $item->image_gallery);
                $g_path = Yii::$app->getModule('catalog')->getArticleGalleryBasePath();
                foreach ($g as $image) {
                    $image = $g_path . '/' . $image;
                    if (is_file($image)) {
                        $this->create_gallery_thumbs($image);
                    }
                }
            }
            sleep(1);
        }

        if (!empty($this->arr_to_optim)) {
            $this->optimise_images($this->arr_to_optim);
        } else {
            echo "empty file list to convert";
        }

        sleep(1);
        exit();
    }

    /**
     * create_main_thumbs
     */
    protected function create_main_thumbs($img) {

//        $this->optimise_image($img);

        $thumb = Yii::$app->getModule('catalog')->getArticleImageBasePath();

        $img_info = basename($img);
        $img_dir = dirname($img);

        if (!is_file($img_dir . '/thumb-80x107.' . $img_info)) {
            $image = Yii::$app->image->load($img);
            $image->resize(80, 107, 0x05)->crop(80, 107)->save($img_dir . '/thumb-80x107.' . $img_info, ['quality' => 80]);
            $this->arr_to_optim[] = $img_dir . '/thumb-80x107.' . $img_info;
//            $this->optimise_image($img_dir . '/thumb-80x107.' . $img_info);
        }

        if (!is_file($img_dir . '/thumb-304x405.' . $img_info)) {
            $image = Yii::$app->image->load($img);
            $image->resize(304, 405, 0x05)->crop(304, 405)->save($img_dir . '/thumb-304x405.' . $img_info, ['quality' => 80]);
            $this->arr_to_optim[] = $img_dir . '/thumb-304x405.' . $img_info;
//            $this->optimise_image($img_dir . '/thumb-304x405.' . $img_info);
        }

        if (!is_file($img_dir . '/thumb-443x590.' . $img_info)) {
            $image = Yii::$app->image->load($img);
            $image->resize(443, 590, 0x05)->crop(443, 590)->save($img_dir . '/thumb-443x590.' . $img_info, ['quality' => 80]);
            $this->arr_to_optim[] = $img_dir . '/thumb-443x590.' . $img_info;
//            $this->optimise_image($img_dir . '/thumb-443x590.' . $img_info);
        }
    }

    /**
     * create_gallery_thumbs
     */
    protected function create_gallery_thumbs($img) {

        $thumb = Yii::$app->getModule('catalog')->getArticleGalleryBasePath();

        $img_info = basename($img);
        $img_dir = dirname($img);

        if (!is_file($img_dir . '/thumb-80x107.' . $img_info)) {
            $image = Yii::$app->image->load($img);
            $image->resize(80, 107, 0x05)->crop(80, 107)->save($img_dir . '/thumb-80x107.' . $img_info, ['quality' => 80]);
            $this->arr_to_optim[] = $img_dir . '/thumb-80x107.' . $img_info;
//            $this->optimise_image($img_dir . '/thumb-80x107.' . $img_info);
        }

        if (!is_file($thumb . '/thumb-443x590.' . $img_info)) {
            $image = Yii::$app->image->load($img);
            $image->resize(443, 590, 0x05)->crop(443, 590)->save($img_dir . '/thumb-443x590.' . $img_info, ['quality' => 80]);
            $this->arr_to_optim[] = $img_dir . '/thumb-443x590.' . $img_info;
//            $this->optimise_image($img_dir . '/thumb-443x590.' . $img_info);
        }
    }

    /**
     * !!!!
     * sudo apt-get install jpegoptim optipng
     * !!!!
     * http://www.maknesium.de/optimize-your-pngjpeg-images-with-no-quality-in-minutes
     * 
     */
    protected function optimise_image($img) {
        try {
            if (is_file($img))
                system('jpegoptim --strip-all ' . $img);
//                echo 'jpegoptim --strip-all ' . $img;
        } catch (Exception $ex) {
            
        }

        // optimise jpg
        //'find . -iname "*.jpg" | xargs jpegoptim --strip-all'
        // optimise JPG
        //'find . -iname "*.JPG" | xargs jpegoptim --strip-all'        
        // optimise png
        //find . -iname "*.png" | xargs optipng
        // optimise PNG
        //find . -iname "*.PNG" | xargs optipng
    }

    /**
     * 
     * @param array $img
     */
    protected function optimise_images(array $img) {
        try {
//            if (is_file($img))
            system('jpegoptim --strip-all ' . implode(' ', $img));
//            echo 'jpegoptim --strip-all ' . implode(' ', $img);
        } catch (Exception $ex) {
            
        }
    }

}
