<?php

namespace console\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
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

//    /**
//     * Set Product Position
//     */
//    public function actionUpdateUserProfile()
//    {
//        // update pdf_access
//
//        $rows = (new \yii\db\Query())
//            ->from('c1myarredo.user_data')
//            ->where(['pdf_access' => '1'])
//            ->all();
//
//        foreach ($rows as $row) {
//            // UPDATE
//            $connection = Yii::$app->db;
//
//            $connection->createCommand()
//                ->update(
//                    'c1myarredo.fv_user_profile',
//                    ['pdf_access' => '1'],
//                    'user_id = ' . $row['uid']
//                )
//                ->execute();
//        }
//
//        // update possibility_to_answer
//
//        $rows = (new \yii\db\Query())
//            ->from('c1myarredo.user_data')
//            ->where(['possibility_to_answer' => '1'])
//            ->all();
//
//        foreach ($rows as $row) {
//            // UPDATE
//            $connection = Yii::$app->db;
//
//            $connection->createCommand()
//                ->update(
//                    'c1myarredo.fv_user_profile',
//                    ['possibility_to_answer' => '1'],
//                    'user_id = ' . $row['uid']
//                )
//                ->execute();
//        }
//
//        // update city_partner
//
//        $rows = (new \yii\db\Query())
//            ->from('c1myarredo.user_data')
//            ->where(['city_partner' => '1'])
//            ->all();
//
//        foreach ($rows as $row) {
//            // UPDATE
//            $connection = Yii::$app->db;
//
//            $connection->createCommand()
//                ->update(
//                    'c1myarredo.fv_user_profile',
//                    ['partner_in_city' => '1'],
//                    'user_id = ' . $row['uid']
//                )
//                ->execute();
//        }
//    }

//    /**
//     * Generate product title
//     */
//    public function actionGenerateProductTitle()
//    {
//        $models = Product::find()
//            ->where([
//                'mark' => '0',
//                'is_composition' => '1'
//            ])
//            ->limit(500)
//            ->orderBy('id ASC')
//            ->all();
//
//        foreach ($models as $model) {
//            /** @var PDO $transaction */
//            /** @var $model Product */
//            $transaction = $model::getDb()->beginTransaction();
//            try {
//
//                $model->setScenario('setAlias');
//
//                $model->mark = '1';
//
//                if ($model->save()) {
//                    $transaction->commit();
//
//                    $modelLang = ProductLang::findOne([
//                        'rid' => $model->id,
//                        'lang' => Yii::$app->language,
//                    ]);
//
//                    $modelLang->setScenario('backend');
//                    $modelLang->save();
//                } else {
//                    $transaction->rollBack();
//                }
//            } catch (\Exception $e) {
//                $transaction->rollBack();
//                throw new \Exception($e);
//            }
//        }
//    }

//    /**
//     * Import product gallery image
//     */
//    public function actionImportProductImages()
//    {
//        $models = Product::find()
//            ->limit(1000)
//            ->where([
//                //'picpath' => '0',
//                'image_link' => null,
//                'mark' => '0'
//            ])
//            ->orderBy('id ASC')
//            ->all();
//
//        foreach ($models as $model) {
//
//            if ($model->gallery_id) {
//
//                $photo = (new \yii\db\Query())
//                    ->from('c1myarredo_old.photo')
//                    ->where(['gallery_id' => $model->gallery_id])
//                    ->all();
//
//                /** @var PDO $transaction */
//                /** @var $model Product */
//                $transaction = $model::getDb()->beginTransaction();
//                try {
//                    $images = ArrayHelper::map($photo, 'id', 'photopath');
//
//                    $model->gallery_image = implode(',', $images);
//                    $model->image_link = array_shift($images);
//                    $model->mark = '1';
//
//                    $model->setScenario('setImages');
//
//                    if ($model->save()) {
//
//                        echo $model->id . ' ' . $model->image_link . PHP_EOL;
//                        $transaction->commit();
//
//                    } else {
//                        $transaction->rollBack();
//                    }
//                } catch (\Exception $e) {
//                    $transaction->rollBack();
//                    throw new \Exception($e);
//                }
//            }
//        }
//    }
//
//    /**
//     * Import product gallery image
//     */
//    public function actionImportSaleImages()
//    {
//        $models = Sale::find()
//            ->limit(1000)
//            ->where(['picpath' => '0'])
//            ->orderBy('id ASC')
//            ->all();
//
//        foreach ($models as $model) {
//
//            if ($model->gallery_id) {
//
//                $photo = (new \yii\db\Query())
//                    ->from('c1myarredo_old.photo')
//                    ->where(['gallery_id' => $model->gallery_id])
//                    ->all();
//
//                /** @var PDO $transaction */
//                /** @var $model Product */
//                $transaction = $model::getDb()->beginTransaction();
//                try {
//
//
//                    $images = ArrayHelper::map($photo, 'id', 'photopath');
//
//                    $model->gallery_image = implode(',', $images);
//                    $model->image_link = array_shift($images);
//                    $model->picpath = '1';
//
//                    $model->setScenario('setImages');
//
//                    if ($model->save()) {
//                        $transaction->commit();
//
//                    } else {
//                        $transaction->rollBack();
//                    }
//                } catch (\Exception $e) {
//                    $transaction->rollBack();
//                    throw new \Exception($e);
//                }
//            }
//        }
//    }

//    /**
//     * Set Product Position
//     */
//    public function actionSetProductPosition()
//    {
//        $rows = (new \yii\db\Query())
//            ->from('c1myarredo.catalog_item')
//            ->where(['mark' => '0'])
//            ->limit(1000)
//            ->orderBy('id ASC')
//            ->all();
//
//        foreach ($rows as $row) {
//            // UPDATE
//            $connection = Yii::$app->db;
//
//            $connection->createCommand()
//                ->update(
//                    'c1myarredo.catalog_item',
//                    ['mark' => '1'],
//                    'id = ' . $row['id']
//                )
//                ->execute();
//
//            $connection->createCommand()
//                ->update(
//                    'c1myarredo_old.catalog_item',
//                    ['position' => $row['updated']],
//                    'id = ' . $row['id']
//                )
//                ->execute();
//        }
//    }

//    /**
//     * Set Product Position
//     */
//    public function actionSetProductAlias()
//    {
//        $rows = (new \yii\db\Query())
//            ->from('c1myarredo.catalog_item')
//            ->where(['mark' => '0'])
//            ->limit(1000)
//            ->orderBy('id ASC')
//            ->all();
//
//        foreach ($rows as $row) {
//            // UPDATE
//            $connection = Yii::$app->db;
//
//            $connection->createCommand()
//                ->update(
//                    'c1myarredo.catalog_item',
//                    ['mark' => '1'],
//                    'id = ' . $row['id']
//                )
//                ->execute();
//
//            $connection->createCommand()
//                ->update(
//                    'c1myarredo_old.catalog_item',
//                    ['alias' => $row['alias']],
//                    'id = ' . $row['id']
//                )
//                ->execute();
//        }
//    }

    /**
     * Generate product title
     */
    public function actionGenerateProductItTitle()
    {
        // UPDATE `fv_catalog_item` SET `mark`='0'

        $this->stdout("GenerateProductItTitle: start. \n", Console::FG_GREEN);

        $models = Product::find()
            ->where([
                'mark' => '0',
                'is_composition' => '1'
            ])
            ->limit(500)
            ->orderBy('id DESC')
            ->all();

        foreach ($models as $model) {
            /** @var PDO $transaction */
            /** @var $model Product */
            $transaction = $model::getDb()->beginTransaction();
            try {

                $model->setScenario('setMark');

                $model->mark = '1';

                if ($model->save()) {
                    $transaction->commit();

                    Yii::$app->language = 'ru-RU';

                    $modelLangRu = ProductLang::find()
                        ->where([
                            'rid' => $model->id,
                        ])
                        ->one();

                    Yii::$app->language = 'it-IT';

                    $modelLangIt = new ProductLang();

                    $modelLangIt->rid = $model->id;
                    $modelLangIt->lang = Yii::$app->language;

                    $modelLangIt->title = ($modelLangRu != null) ? $modelLangRu->title : '';
                    $modelLangIt->description = ($modelLangRu != null) ? $modelLangRu->description : '';

                    $modelLangIt->setScenario('backend');
                    $modelLangIt->save();

                    $this->stdout("save: ID=" . $model->id . " \n", Console::FG_GREEN);
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw new \Exception($e);
            }
        }

        $this->stdout("GenerateProductItTitle: finish. \n", Console::FG_GREEN);
    }
}