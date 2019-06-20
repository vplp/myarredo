<?php

namespace console\controllers;

use Yii;
use yii\db\Exception;
use yii\helpers\Console;
use yii\console\Controller;
//
use frontend\modules\sys\models\Language;
use common\modules\catalog\models\{
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
     * Reset mark
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
     */
    public function actionTranslate()
    {
        $this->stdout("Translate: start. \n", Console::FG_GREEN);

        // products
        $models = ItalianProduct::findBase()
            ->andFilterWhere([
                'mark' => '0',
            ])
            ->limit(50)
            ->orderBy(ItalianProduct::tableName() . '.id DESC')
            ->all();

        // languages
        $modelLanguage = new Language();
        $languages = $modelLanguage->getLanguages();

        foreach ($models as $model) {
            /** @var PDO $transaction */
            /** @var $model ItalianProduct */

            $saveLang = [];

            $this->stdout("ID = " . $model->id . " \n", Console::FG_GREEN);

            // Translate with language_editing
            if (isset($model->language_editing) && $model->language_editing != '') {
                Yii::$app->language = $model->language_editing;
                $currentLanguage = Yii::$app->language;

                $this->stdout("language editing " . $model->language_editing . " \n", Console::FG_GREEN);

                /** @var $modelLang ItalianProductLang */
                $modelLang = ItalianProductLang::find()
                    ->where([
                        'rid' => $model->id,
                    ])
                    ->one();

                if ($modelLang != null) {
                    foreach ($languages as $language2) {
                        if ($language2['local'] != $currentLanguage) {
                            Yii::$app->language = $language2['local'];

                            /** @var $modelLang2 ItalianProductLang */
                            $modelLang2 = ItalianProductLang::find()
                                ->where([
                                    'rid' => $model->id,
                                    'lang' => Yii::$app->language,
                                ])
                                ->one();

                            if ($modelLang2 == null) {
                                $modelLang2 = new ItalianProductLang();

                                $modelLang2->rid = $model->id;
                                $modelLang2->lang = Yii::$app->language;
                            }

                            $translateLanguage = substr($currentLanguage, 0, 2) . '-' . substr($language2['local'], 0, 2);

                            $this->stdout("translate " . $translateLanguage . " \n", Console::FG_GREEN);

                            $translateTitle = (string)Yii::$app->yandexTranslator
                                ->getTranslate($modelLang->title, $translateLanguage);

                            $translateDescription = (string)Yii::$app->yandexTranslator
                                ->getTranslate(strip_tags($modelLang->description), $translateLanguage);

                            $translateDefects = (string)Yii::$app->yandexTranslator
                                ->getTranslate(strip_tags($modelLang->defects), $translateLanguage);

                            if ($translateTitle != '') {
                                $transaction = $modelLang2::getDb()->beginTransaction();
                                try {
                                    $modelLang2->title = $translateTitle;
                                    $modelLang2->description = $translateDescription;
                                    $modelLang2->defects = $translateDefects;

                                    $modelLang2->setScenario('backend');

                                    if ($saveLang[] = intval($modelLang2->save())) {
                                        $transaction->commit();
                                        $this->stdout("save " . $translateLanguage . " \n", Console::FG_GREEN);
                                    } else {
                                        foreach ($modelLang2->errors as $attribute => $errors) {
                                            $this->stdout($attribute . ": " . implode('; ', $errors) . " \n", Console::FG_RED);
                                        }
                                    }
                                } catch (Exception $e) {
                                    $transaction->rollBack();
                                    throw new Exception($e);
                                }
                            }
                        }
                    }
                }
            } else {
                foreach ($languages as $language) {
                    Yii::$app->language = $language['local'];
                    $currentLanguage = Yii::$app->language;

                    /** @var $modelLang ItalianProductLang */
                    $modelLang = ItalianProductLang::find()
                        ->where([
                            'rid' => $model->id,
                        ])
                        ->one();

                    if ($modelLang != null) {
                        foreach ($languages as $language2) {
                            if ($language2['local'] != $currentLanguage) {
                                Yii::$app->language = $language2['local'];

                                /** @var $modelLang2 ItalianProductLang */
                                $modelLang2 = ItalianProductLang::find()
                                    ->where([
                                        'rid' => $model->id,
                                        'lang' => Yii::$app->language,
                                    ])
                                    ->one();

                                if ($modelLang2 == null) {
                                    $modelLang2 = new ItalianProductLang();

                                    $modelLang2->rid = $model->id;
                                    $modelLang2->lang = Yii::$app->language;

                                    $translateLanguage = substr($currentLanguage, 0, 2) . '-' . substr($language2['local'], 0, 2);

                                    $this->stdout("translate " . $translateLanguage . " \n", Console::FG_GREEN);

                                    $translateTitle = (string)Yii::$app->yandexTranslator
                                        ->getTranslate($modelLang->title, $translateLanguage);

                                    $translateDescription = (string)Yii::$app->yandexTranslator
                                        ->getTranslate(strip_tags($modelLang->description), $translateLanguage);

                                    $translateDefects = (string)Yii::$app->yandexTranslator
                                        ->getTranslate(strip_tags($modelLang->defects), $translateLanguage);

                                    if ($translateTitle != '') {
                                        $transaction = $modelLang2::getDb()->beginTransaction();
                                        try {
                                            $modelLang2->title = $translateTitle;
                                            $modelLang2->description = $translateDescription;
                                            $modelLang2->defects = $translateDefects;

                                            $modelLang2->setScenario('backend');

                                            if ($saveLang[] = intval($modelLang2->save())) {
                                                $transaction->commit();
                                                $this->stdout("save " . $translateLanguage . " \n", Console::FG_GREEN);
                                            } else {
                                                foreach ($modelLang2->errors as $attribute => $errors) {
                                                    $this->stdout($attribute . ": " . implode('; ', $errors) . " \n", Console::FG_RED);
                                                }
                                            }
                                        } catch (Exception $e) {
                                            $transaction->rollBack();
                                            throw new Exception($e);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $model->setScenario('setMark');
            $model->mark = '1';

            if ($model->save() && !in_array(0, array_values($saveLang))) {
                $this->stdout("translate ID = " . $model->id . " \n", Console::FG_GREEN);
            }

            $this->stdout("-------------------------------" . " \n", Console::FG_GREEN);
        }

        $this->stdout("Translate: finish. \n", Console::FG_GREEN);
    }

//    /**
//     * @param $model
//     * @param $currentLanguage
//     * @throws \yii\base\InvalidConfigException
//     */
//    protected function logicTranslate($model, $currentLanguage)
//    {
//        $languages = Language::findBase()
//            ->orderBy('by_default DESC')
//            ->enabled()
//            ->all();
//
//        /** @var PDO $transaction */
//        /** @var $model ItalianProduct */
//
//        $transaction = $model::getDb()->beginTransaction();
//        try {
//            $save = false;
//            foreach ($languages as $language) {
//                if ($language->local != $currentLanguage) {
//                    /** @var Language $language */
//                    Yii::$app->language = $language->local;
//
//                    $modelLang = ItalianProductLang::find()
//                        ->where([
//                            'rid' => $model->id
//                        ])
//                        ->one();
//
//                    if ($modelLang == null) {
//                        $modelLang = new ItalianProductLang();
//
//                        $modelLang->rid = $model->id;
//                        $modelLang->lang = Yii::$app->language;
//                    }
//
//                    $translateLanguage = substr($currentLanguage, 0, 2) . '-' . substr($language->local, 0, 2);
//
//                    if ($model->lang->title != '') {
//                        $modelLang->title = Yii::$app->yandexTranslator
//                            ->getTranslate($model->lang->title, $translateLanguage);
//                    }
//
//                    if ($model->lang->description != '') {
//                        $modelLang->description = Yii::$app->yandexTranslator
//                            ->getTranslate($model->lang->description, $translateLanguage);
//                    }
//
//                    if ($model->lang->defects != '') {
//                        $modelLang->defects = Yii::$app->yandexTranslator
//                            ->getTranslate($model->lang->defects, $translateLanguage);
//                    }
//
//                    $modelLang->setScenario('backend');
//
//                    if ($save = $modelLang->save() && $modelLang->title != '') {
//                        $this->stdout($translateLanguage . " save: ID=" . $model->id . " \n", Console::FG_GREEN);
//                    } else {
//                        continue;
//                    }
//                }
//            }
//
//            $model->setScenario('setMark');
//            $model->mark = '1';
//
//            if ($model->save() && $save) {
//                $this->stdout("translate ID=" . $model->id . " \n", Console::FG_GREEN);
//                $transaction->commit();
//            } else {
//                $transaction->rollBack();
//            }
//        } catch (\Exception $e) {
//            $transaction->rollBack();
//            throw new \Exception($e);
//        }
//    }
}
