<?php

namespace console\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\console\Controller;
use common\modules\catalog\models\{
    Product
};


/**
 * Class CronController
 *
 * @package console\controllers
 */
class CronController extends Controller
{

    /**
     * Import product gallery image
     */
    public function actionImportProductGalleryImage()
    {
        $models = Product::find()
            ->limit(1000)
            ->where(['picpath' => '0'])
            ->all();

        foreach ($models as $model) {

            echo $model->id . PHP_EOL;

            if ($model->gallery_id) {

                $photo = (new \yii\db\Query())
                    ->from('c1myarredo_old.photo')
                    ->where(['gallery_id' => $model->gallery_id])
                    ->all();

                /** @var PDO $transaction */
                /** @var $model Product */
                $transaction = $model::getDb()->beginTransaction();
                try {
                    $model->setScenario('gallery_image');

                    $images = ArrayHelper::map($photo, 'id', 'photopath');

                    $model->image_link = array_shift($images);
                    $model->gallery_image = implode(',', $images);
                    $model->picpath = '1';

                    if ($model->save()) {
                        $transaction->commit();

                    } else {
                        $transaction->rollBack();
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw new \Exception($e);
                }
            }
        }
    }
}