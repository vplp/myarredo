<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
//
use frontend\modules\catalog\models\{
    Sale, SaleLang
};

/**
 * Class CatalogSaleController
 *
 * @package console\controllers
 */
class CatalogSaleController extends Controller
{
    /**
     * @throws \yii\db\Exception
     */
    public function actionResetMark()
    {
        $this->stdout("ResetMark: start. \n", Console::FG_GREEN);

        Yii::$app->db->createCommand()
            ->update(Sale::tableName(), ['mark' => '0'], "`mark`='1'")
            ->execute();

        $this->stdout("ResetMark: finish. \n", Console::FG_GREEN);
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function actionTranslate()
    {
        $this->stdout("Translate: start. \n", Console::FG_GREEN);

        $models = Sale::find()
            ->andFilterWhere([
                'mark' => '0',
            ])
            ->limit(25)
            ->orderBy(Sale::tableName() . '.id DESC')
            ->all();

        foreach ($models as $model) {
            /** @var PDO $transaction */
            /** @var $model Sale */
            $transaction = $model::getDb()->beginTransaction();
            try {
                $model->setScenario('setMark');

                $model->mark = '1';

                Yii::$app->language = 'ru-RU';

                /** @var $modelLangRu SaleLang */
                $modelLangRu = SaleLang::find()
                    ->where([
                        'rid' => $model->id,
                    ])
                    ->one();

                /**
                 * Translate ru-it
                 */

                Yii::$app->language = 'it-IT';

                $modelLangIt = SaleLang::find()
                    ->where([
                        'rid' => $model->id,
                        'lang' => Yii::$app->language,
                    ])
                    ->one();

                if ($modelLangIt == null) {
                    $modelLangIt = new SaleLang();

                    $modelLangIt->rid = $model->id;
                    $modelLangIt->lang = Yii::$app->language;
                }

                $translateTitle = Yii::$app->yandexTranslator
                    ->getTranslate($modelLangRu->title, 'ru-it');

                $translateDescription = Yii::$app->yandexTranslator
                    ->getTranslate(strip_tags($modelLangRu->description), 'ru-it');

                if ($translateTitle != '' && $translateDescription != '') {
                    $modelLangIt->title = $translateTitle;
                    $modelLangIt->description = $translateDescription;

                    $modelLangIt->setScenario('backend');

                    if ($modelLangIt->save()) {
                        $this->stdout("save it: ID=" . $model->id . " \n", Console::FG_GREEN);
                    }
                }

                /**
                 * Translate ru-en
                 */

                Yii::$app->language = 'en-EN';

                $modelLangEn = SaleLang::find()
                    ->where([
                        'rid' => $model->id,
                        'lang' => Yii::$app->language,
                    ])
                    ->one();

                if ($modelLangEn == null) {
                    $modelLangEn = new SaleLang();

                    $modelLangEn->rid = $model->id;
                    $modelLangEn->lang = Yii::$app->language;
                }

                $translateTitle = Yii::$app->yandexTranslator
                    ->getTranslate($modelLangRu->title, 'ru-en');

                $translateDescription = Yii::$app->yandexTranslator
                    ->getTranslate(strip_tags($modelLangRu->description), 'ru-en');

                if ($translateTitle != '' && $translateDescription != '') {
                    $modelLangEn->title = $translateTitle;
                    $modelLangEn->description = $translateDescription;

                    $modelLangEn->setScenario('backend');

                    if ($modelLangEn->save()) {
                        $this->stdout("save en: ID=" . $model->id . " \n", Console::FG_GREEN);
                    }
                }

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

        $this->stdout("Translate: finish. \n", Console::FG_GREEN);
    }
}
