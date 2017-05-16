<?php

namespace frontend\modules\seo\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
//
use frontend\components\BaseController;

/**
 * Class RobotsController
 *
 * @package frontend\modules\seo\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class RobotsController extends BaseController
{
    /**
     * @var string
     */
    public $title = "Robots";

    /**
     * @var string
     */
    public $defaultAction = 'index';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @param string $secretKey
     * @throws NotFoundHttpException
     */
    public function actionCreate($secretKey)
    {
//        if ($secretKey !== $this->module->secretKey) {
//            throw new NotFoundHttpException;
//        }
//
//        $filename = Yii::getAlias('@webroot') . '/robots.txt';
//        if (fopen($filename, 'a+')) {
//            set_time_limit(0);
//            $elements = Seo::find();
//            $content = '#Autogen' . "\n";
//
//            $fileContent = file_get_contents($filename);
//            if (strpos($fileContent, '#Autogen')) {
//                $oldContent = substr($fileContent, strpos($fileContent, '#Autogen'));
//                $content = str_replace($oldContent, $content, $fileContent);
//            }
//            file_put_contents($filename, $content);
//        } else {
//            echo 'error open file';
//        }
    }
}
