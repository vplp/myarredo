<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
//
use common\modules\catalog\models\{
    Product, ProductLang
};

/**
 * Class CatalogProductController
 *
 * @package console\controllers
 */
class CatalogProductController extends Controller
{
    /**
     * Reset mark
     */
    public function actionResetMark()
    {
        $this->stdout("ResetMark: start. \n", Console::FG_GREEN);

        Yii::$app->db->createCommand()
            ->update(Product::tableName(), ['mark' => '0'], "`mark`='1'")
            ->execute();

        $this->stdout("ResetMark: finish. \n", Console::FG_GREEN);
    }

    /**
     * Translate
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function actionTranslate()
    {
        $this->stdout("Translate: start. \n", Console::FG_GREEN);

        $models = Product::find()
            ->andFilterWhere([
                'mark' => '0',
            ])
            ->limit(50)
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

                /** @var $modelLangRu ProductLang */
                $modelLangRu = ProductLang::find()
                    ->where([
                        'rid' => $model->id,
                    ])
                    ->one();

                /**
                 * Generate ru title
                 */

                if ($modelLangRu == null) {
                    $modelLangRu = new ProductLang();

                    $modelLangRu->rid = $model->id;
                    $modelLangRu->lang = Yii::$app->language;
                }

                $modelLangRu->title = '';
                $modelLangRu->setScenario('backend');

                if ($modelLangRu->save()) {
                    $this->stdout("save ru ID=" . $model->id . " \n", Console::FG_GREEN);
                    $this->stdout("save ru title=" . $modelLangRu->title . " \n", Console::FG_GREEN);
                }

                /**
                 * Translate ru-it
                 */
                $saveIt = false;
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

                $translateTitle = Yii::$app->yandexTranslator
                    ->getTranslate($modelLangRu->title, 'ru-it');

                $translateDescription = Yii::$app->yandexTranslator
                    ->getTranslate(strip_tags($modelLangRu->description), 'ru-it');

                if ($translateTitle != '' || $translateDescription != '') {
                    $modelLangIt->title = $translateTitle;
                    $modelLangIt->description = $translateDescription;

                    $modelLangIt->setScenario('backend');

                    if ($saveIt = $modelLangIt->save()) {
                        $this->stdout("save it ID=" . $model->id . " \n", Console::FG_GREEN);
                    }
                }

                /**
                 * Translate ru-en
                 */
                $saveEn = false;
                Yii::$app->language = 'en-EN';

                $modelLangEn = ProductLang::find()
                    ->where([
                        'rid' => $model->id,
                        'lang' => Yii::$app->language,
                    ])
                    ->one();

                if ($modelLangEn == null) {
                    $modelLangEn = new ProductLang();

                    $modelLangEn->rid = $model->id;
                    $modelLangEn->lang = Yii::$app->language;
                }

                $translateTitle = Yii::$app->yandexTranslator
                    ->getTranslate($modelLangRu->title, 'ru-en');

                $translateDescription = Yii::$app->yandexTranslator
                    ->getTranslate(strip_tags($modelLangRu->description), 'ru-en');

                if ($translateTitle != '' || $translateDescription != '') {
                    $modelLangEn->title = $translateTitle;
                    $modelLangEn->description = $translateDescription;

                    $modelLangEn->setScenario('backend');

                    if ($saveEn = $modelLangEn->save()) {
                        $this->stdout("save en ID=" . $model->id . " \n", Console::FG_GREEN);
                    }
                }

                if ($model->save() && $saveIt && $saveEn) {
                    $transaction->commit();
                    $this->stdout("translate ID=" . $model->id . " \n", Console::FG_GREEN);
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw new \Exception($e);
            }
        }

        $this->stdout("Translate: finish. \n", Console::FG_GREEN);
    }
}
