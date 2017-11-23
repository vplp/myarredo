<?php

namespace console\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\console\Controller;
//
use common\modules\catalog\models\{
    Product, ProductLang, Sale
};

/**
 * Class CronController
 *
 * @package console\controllers
 */
class CronController extends Controller
{
    public function actionIndex()
    {
        $this->actionGenerateProductTitle();
    }

    /**
     * Generate product title
     */
    public function actionGenerateProductTitle()
    {
        $models = Product::find()
            ->where(['mark' => '0'])
            ->limit(1000)
            ->orderBy('id ASC')
            ->all();

        foreach ($models as $model) {
            /** @var PDO $transaction */
            /** @var $model Product */
            $transaction = $model::getDb()->beginTransaction();
            try {

                $model->setScenario('setAlias');

                $model->mark = '1';

                if ($model->save()) {
                    $transaction->commit();

                    echo $model->alias . PHP_EOL;

                    $modelLang = ProductLang::findOne([
                        'rid' => $model->id,
                        'lang' => Yii::$app->language,
                    ]);

                    $modelLang->setScenario('backend');
                    $modelLang->save();

                    echo $modelLang->title . PHP_EOL;

                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw new \Exception($e);
            }
        }
    }

    /**
     * Import product gallery image
     */
    public function actionImportProductImages()
    {
        $models = Product::find()
            ->select(['id', 'gallery_id', 'image_link', 'gallery_image', 'picpath'])
            ->limit(1000)
            ->where(['picpath' => '0'])
            ->orderBy('id ASC')
            ->all();

        foreach ($models as $model) {

            if ($model->gallery_id) {

                $photo = (new \yii\db\Query())
                    ->from('c1myarredo_old.photo')
                    ->where(['gallery_id' => $model->gallery_id])
                    ->all();

                /** @var PDO $transaction */
                /** @var $model Product */
                $transaction = $model::getDb()->beginTransaction();
                try {


                    $images = ArrayHelper::map($photo, 'id', 'photopath');

                    $model->gallery_image = implode(',', $images);
                    $model->image_link = array_shift($images);
                    $model->picpath = '1';

                    $model->setScenario('setImages');

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

    /**
     * Import product gallery image
     */
    public function actionImportSaleImages()
    {
        $models = Sale::find()
            ->select(['id', 'gallery_id', 'image_link', 'gallery_image', 'picpath'])
            ->limit(1000)
            ->where(['picpath' => '0'])
            ->orderBy('id ASC')
            ->all();

        foreach ($models as $model) {

            if ($model->gallery_id) {

                $photo = (new \yii\db\Query())
                    ->from('c1myarredo_old.photo')
                    ->where(['gallery_id' => $model->gallery_id])
                    ->all();

                /** @var PDO $transaction */
                /** @var $model Product */
                $transaction = $model::getDb()->beginTransaction();
                try {


                    $images = ArrayHelper::map($photo, 'id', 'photopath');

                    $model->gallery_image = implode(',', $images);
                    $model->image_link = array_shift($images);
                    $model->picpath = '1';

                    $model->setScenario('setImages');

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