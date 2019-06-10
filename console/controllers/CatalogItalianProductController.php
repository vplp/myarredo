<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
//
use frontend\modules\sys\models\Language;
use frontend\modules\catalog\models\{
    ItalianProduct, ItalianProductLang
};

/**
 * Class CatalogItalianProductController
 *
 * @package console\controllers
 */
class CatalogItalianProductController extends Controller
{
    /**
     * @throws \yii\db\Exception
     */
    public function actionResetMark()
    {
        $this->stdout("ResetMark: start. \n", Console::FG_GREEN);

        Yii::$app->db->createCommand()
            ->update(ItalianProduct::tableName(), ['mark' => '0'], "`mark`='1'")
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

        Yii::$app->language = 'ru-RU';

        $models = ItalianProduct::findBase()
            ->andFilterWhere([
                'mark' => '0',
            ])
            ->limit(50)
            ->orderBy(ItalianProduct::tableName() . '.id DESC')
            ->all();

        foreach ($models as $model) {
            /** @var PDO $transaction */
            /** @var $model ItalianProduct */

            Yii::$app->language = 'ru-RU';
            $currentLanguage = Yii::$app->language;

            if (!empty($model->lang)) {
                $this->logicTranslate($model, $currentLanguage);
            } else {
                Yii::$app->language = 'it-IT';
                $currentLanguage = Yii::$app->language;

                $modelIt = ItalianProduct::findByID($model->id);

                $this->logicTranslate($modelIt, $currentLanguage);
            }
        }

        $this->stdout("Translate: finish. \n", Console::FG_GREEN);
    }

    /**
     * @param $model
     * @param $currentLanguage
     * @throws \yii\base\InvalidConfigException
     */
    protected function logicTranslate($model, $currentLanguage)
    {
        $languages = Language::findBase()
            ->orderBy('by_default DESC')
            ->enabled()
            ->all();

        /** @var PDO $transaction */
        /** @var $model ItalianProduct */

        $transaction = $model::getDb()->beginTransaction();
        try {
            foreach ($languages as $language) {
                if ($language->local != $currentLanguage) {
                    /** @var Language $language */
                    Yii::$app->language = $language->local;

                    $modelLang = ItalianProductLang::find()
                        ->where([
                            'rid' => $model->id
                        ])
                        ->one();

                    if ($modelLang == null) {
                        $modelLang = new ItalianProductLang();

                        $modelLang->rid = $model->id;
                        $modelLang->lang = Yii::$app->language;
                    }

                    $translateLanguage = substr($currentLanguage, 0, 2) . '-' . substr($language->local, 0, 2);

                    if ($model->lang->title != '') {
                        $modelLang->title = Yii::$app->yandexTranslator
                            ->getTranslate($model->lang->title, $translateLanguage);
                    }

                    if ($model->lang->description != '') {
                        $modelLang->description = Yii::$app->yandexTranslator
                            ->getTranslate($model->lang->description, $translateLanguage);
                    }

                    if ($model->lang->defects != '') {
                        $modelLang->defects = Yii::$app->yandexTranslator
                            ->getTranslate($model->lang->defects, $translateLanguage);
                    }

                    $modelLang->setScenario('backend');

                    if ($modelLang->save()) {
                        $this->stdout($translateLanguage . " save: ID=" . $model->id . " \n", Console::FG_GREEN);
                    }
                }
            }

            $model->setScenario('setMark');
            $model->mark = '1';

            if ($model->save()) {
                $this->stdout("save: ID=" . $model->id . " \n", Console::FG_GREEN);
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
