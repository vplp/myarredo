<?php

namespace console\controllers;

use Yii;
use yii\log\Logger;
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
    /**
     * Generate product title
     */
    public function actionProductResetMark()
    {
        Yii::$app->db->createCommand()
            ->update(Product::tableName(), ['mark' => '0'], "`mark`='1'")
            ->execute();
    }

    /**
     * Generate product ru title
     */
    public function actionGenerateProductRuTitle()
    {
        $this->stdout("GenerateProductRuTitle: start. \n", Console::FG_GREEN);

        $models = Product::find()
            ->andFilterWhere([
                'mark' => '0',
            ])
            ->limit(100)
            ->orderBy(Product::tableName() . '.id DESC')
            ->all();

        foreach ($models as $model) {
            /** @var PDO $transaction */
            /** @var $model Product */
            $transaction = $model::getDb()->beginTransaction();
            try {

                $model->setScenario('setMark');

                $model->mark = '1';

                Yii::$app->language = 'ru-RU';

                $modelLangRu = ProductLang::find()
                    ->where([
                        'rid' => $model->id,
                    ])
                    ->one();

                if ($modelLangRu == null) {
                    $modelLangRu = new ProductLang();

                    $modelLangRu->rid = $model->id;
                    $modelLangRu->lang = Yii::$app->language;
                }

                $modelLangRu->title = '';
                $modelLangRu->setScenario('backend');

                if ($model->save()) {
                    $transaction->commit();

                    if ($modelLangRu->save()) {
                        $this->stdout("save: ID=" . $model->id . " \n", Console::FG_GREEN);
                    }

                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw new \Exception($e);
            }
        }

        $this->stdout("GenerateProductRuTitle: finish. \n", Console::FG_GREEN);
    }

    /**
     * Generate product it title
     */
    public function actionGenerateProductItTitle()
    {
        $this->stdout("GenerateProductItTitle: start. \n", Console::FG_GREEN);

        $models = Product::find()
            ->andFilterWhere([
                'mark' => '0',
            ])
            ->limit(100)
            ->orderBy(Product::tableName() . '.id DESC')
            ->all();

        foreach ($models as $model) {
            /** @var PDO $transaction */
            /** @var $model Product */
            $transaction = $model::getDb()->beginTransaction();
            try {

                $model->setScenario('setMark');

                $model->mark = '1';

                Yii::$app->language = 'ru-RU';

                $modelLangRu = ProductLang::find()
                    ->where([
                        'rid' => $model->id,
                    ])
                    ->one();

                Yii::$app->language = 'it-IT';

                $modelLangIt = ProductLang::find()
                    ->where([
                        'rid' => $model->id,
                        'lang' => Yii::$app->language,
                    ])
                    ->one();

                if ($modelLangIt == null) {
                    $modelLangIt = new ProductLang();

                    $modelLangIt->rid = $model->id;
                    $modelLangIt->lang = Yii::$app->language;
                }

                $modelLangIt->title = '';

                $description = ($modelLangRu != null) ? $modelLangRu->description : '';

                $translate = Yii::$app->yandexTranslator->getTranslate($description, 'ru-it');

                if ($model->save() && $translate != '') {
                    $transaction->commit();

                    //var_dump($translate);

                    if ($translate != '') {
                        $modelLangIt->description = $translate;
                    }

                    $modelLangIt->setScenario('backend');

                    if ($modelLangIt->save()) {
                        $this->stdout("save: ID=" . $model->id . " \n", Console::FG_GREEN);
                    }

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