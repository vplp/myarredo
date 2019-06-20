<?php

namespace console\controllers;

use Yii;
use yii\db\Exception;
use yii\helpers\Console;
use yii\console\Controller;
//
use frontend\modules\sys\models\Language;
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
     */
    public function actionTranslate()
    {
        $this->stdout("Translate: start. \n", Console::FG_GREEN);

        // products
        $models = Product::find()
            ->andFilterWhere([
                'mark' => '0',
            ])
            ->limit(50)
            ->orderBy(Product::tableName() . '.id DESC')
            ->all();

        // languages
        $modelLanguage = new Language();
        $languages = $modelLanguage->getLanguages();

        foreach ($models as $model) {
            /** @var PDO $transaction */
            /** @var $model Product */

            $saveLang = [];

            $this->stdout("ID = " . $model->id . " \n", Console::FG_GREEN);

            // Translate with language_editing
            if (isset($model->language_editing) && $model->language_editing != '') {
                Yii::$app->language = $model->language_editing;
                $currentLanguage = Yii::$app->language;

                $this->stdout("language editing " . $model->language_editing . " \n", Console::FG_GREEN);

                /** @var $modelLang ProductLang */
                $modelLang = ProductLang::find()
                    ->where([
                        'rid' => $model->id,
                    ])
                    ->one();

                if ($modelLang != null) {
                    foreach ($languages as $language2) {
                        if ($language2['local'] != $currentLanguage) {
                            Yii::$app->language = $language2['local'];

                            /** @var $modelLang2 ProductLang */
                            $modelLang2 = ProductLang::find()
                                ->where([
                                    'rid' => $model->id,
                                    'lang' => Yii::$app->language,
                                ])
                                ->one();

                            if ($modelLang2 == null) {
                                $modelLang2 = new ProductLang();

                                $modelLang2->rid = $model->id;
                                $modelLang2->lang = Yii::$app->language;
                            }

                            $translateLanguage = substr($currentLanguage, 0, 2) . '-' . substr($language2['local'], 0, 2);

                            $this->stdout("translate " . $translateLanguage . " \n", Console::FG_GREEN);

                            $translateTitle = (string)Yii::$app->yandexTranslator
                                ->getTranslate($modelLang->title, $translateLanguage);

                            //$this->stdout("title = " . $translateTitle . " \n", Console::FG_GREEN);

                            $translateDescription = (string)Yii::$app->yandexTranslator
                                ->getTranslate(strip_tags($modelLang->description), $translateLanguage);

                            //$this->stdout("description = " . $translateDescription . " \n", Console::FG_GREEN);

                            if ($translateTitle != '') {
                                $transaction = $modelLang2::getDb()->beginTransaction();
                                try {
                                    $modelLang2->title = $translateTitle;
                                    $modelLang2->description = $translateDescription;

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

                    /** @var $modelLang ProductLang */
                    $modelLang = ProductLang::find()
                        ->where([
                            'rid' => $model->id,
                        ])
                        ->one();

                    if ($modelLang != null) {
                        foreach ($languages as $language2) {
                            if ($language2['local'] != $currentLanguage) {
                                Yii::$app->language = $language2['local'];

                                /** @var $modelLang2 ProductLang */
                                $modelLang2 = ProductLang::find()
                                    ->where([
                                        'rid' => $model->id,
                                        'lang' => Yii::$app->language,
                                    ])
                                    ->one();

                                if ($modelLang2 == null) {
                                    $modelLang2 = new ProductLang();

                                    $modelLang2->rid = $model->id;
                                    $modelLang2->lang = Yii::$app->language;

                                    $translateLanguage = substr($currentLanguage, 0, 2) . '-' . substr($language2['local'], 0, 2);

                                    $this->stdout("translate " . $translateLanguage . " \n", Console::FG_GREEN);

                                    $translateTitle = (string)Yii::$app->yandexTranslator
                                        ->getTranslate($modelLang->title, $translateLanguage);

                                    //$this->stdout("title = " . $translateTitle . " \n", Console::FG_GREEN);

                                    $translateDescription = (string)Yii::$app->yandexTranslator
                                        ->getTranslate(strip_tags($modelLang->description), $translateLanguage);

                                    //$this->stdout("description = " . $translateDescription . " \n", Console::FG_GREEN);

                                    if ($translateTitle != '') {
                                        $transaction = $modelLang2::getDb()->beginTransaction();
                                        try {
                                            $modelLang2->title = $translateTitle;
                                            $modelLang2->description = $translateDescription;

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
}
