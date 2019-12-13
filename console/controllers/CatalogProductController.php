<?php

namespace console\controllers;

use Yii;
use yii\db\Exception;
use yii\helpers\Console;
use yii\console\Controller;
//
use frontend\modules\sys\models\Language;
use common\modules\catalog\models\{
    Product, ProductLang, CategoryLang, TypesLang
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

                                $sourceLanguageCode = substr($currentLanguage, 0, 2);
                                $targetLanguageCode = substr($language2['local'], 0, 2);

                                $this->stdout("targetLanguageCode " . $targetLanguageCode . " \n", Console::FG_GREEN);

                                $translateTitle = (string)Yii::$app->yandexTranslation->getTranslate(
                                    $modelLang->title,
                                    $sourceLanguageCode,
                                    $targetLanguageCode
                                );

                                $translateDescription = (string)Yii::$app->yandexTranslation->getTranslate(
                                    strip_tags($modelLang->description),
                                    $sourceLanguageCode,
                                    $targetLanguageCode
                                );

                                if ($translateTitle != '') {
                                    $transaction = $modelLang2::getDb()->beginTransaction();
                                    try {
                                        $modelLang2->title = $translateTitle;
                                        $modelLang2->description = $translateDescription;

                                        $modelLang2->setScenario('backend');

                                        if ($saveLang[] = intval($modelLang2->save())) {
                                            $transaction->commit();
                                            $this->stdout("save " . $targetLanguageCode . " \n", Console::FG_GREEN);
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
                            } else {
                                $saveLang[] = 1;
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

                                    $sourceLanguageCode = substr($currentLanguage, 0, 2);
                                    $targetLanguageCode = substr($language2['local'], 0, 2);

                                    $this->stdout("targetLanguageCode " . $targetLanguageCode . " \n", Console::FG_GREEN);

                                    $translateTitle = (string)Yii::$app->yandexTranslation->getTranslate(
                                        $modelLang->title,
                                        $sourceLanguageCode,
                                        $targetLanguageCode
                                    );

                                    $translateDescription = (string)Yii::$app->yandexTranslation->getTranslate(
                                        strip_tags($modelLang->description),
                                        $sourceLanguageCode,
                                        $targetLanguageCode
                                    );

                                    if ($translateTitle != '') {
                                        $transaction = $modelLang2::getDb()->beginTransaction();
                                        try {
                                            $modelLang2->title = $translateTitle;
                                            $modelLang2->description = $translateDescription;

                                            $modelLang2->setScenario('backend');

                                            if ($saveLang[] = intval($modelLang2->save())) {
                                                $transaction->commit();
                                                $this->stdout("save " . $targetLanguageCode . " \n", Console::FG_GREEN);
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

    /**
     * @param string $lang1
     * @param string $lang2
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionTranslateCategory($lang1 = 'ru-RU', $lang2 = 'uk-UA')
    {
        $this->stdout("Translate Category: start. \n", Console::FG_GREEN);

        Yii::$app->language = $lang1;

        $models = CategoryLang::find()->all();

        foreach ($models as $modelLang) {
            Yii::$app->language = $lang2;

            /** @var $modelLang CategoryLang */
            /** @var $modelLang2 CategoryLang */

            $modelLang2 = CategoryLang::find()
                ->where([
                    'rid' => $modelLang->rid,
                    'lang' => Yii::$app->language,
                ])
                ->one();

            if ($modelLang2 == null) {
                $modelLang2 = new CategoryLang();

                $modelLang2->rid = $modelLang->rid;
                $modelLang2->lang = Yii::$app->language;

                $sourceLanguageCode = substr($lang1, 0, 2);
                $targetLanguageCode = substr($lang2, 0, 2);

                $title = (string)Yii::$app->yandexTranslation->getTranslate(
                    $modelLang->title,
                    $sourceLanguageCode,
                    $targetLanguageCode
                );

                $composition_title = (string)Yii::$app->yandexTranslation->getTranslate(
                    $modelLang->composition_title,
                    $sourceLanguageCode,
                    $targetLanguageCode
                );

                if ($title != '') {
                    $transaction = $modelLang2::getDb()->beginTransaction();
                    try {
                        $modelLang2->title = $title;
                        $modelLang2->composition_title = $composition_title;

                        $modelLang2->setScenario('backend');

                        if ($saveLang[] = intval($modelLang2->save())) {
                            $transaction->commit();
                            $this->stdout("save " . $targetLanguageCode . " \n", Console::FG_GREEN);
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

        $this->stdout("Translate Category: finish. \n", Console::FG_GREEN);
    }

    /**
     * @param string $lang1
     * @param string $lang2
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionTranslateTypes($lang1 = 'ru-RU', $lang2 = 'uk-UA')
    {
        $this->stdout("Translate Types: start. \n", Console::FG_GREEN);

        Yii::$app->language = $lang1;

        $models = TypesLang::find()->all();

        foreach ($models as $modelLang) {
            Yii::$app->language = $lang2;

            /** @var $modelLang TypesLang */
            /** @var $modelLang2 TypesLang */

            $modelLang2 = TypesLang::find()
                ->where([
                    'rid' => $modelLang->rid,
                    'lang' => Yii::$app->language,
                ])
                ->one();

            if ($modelLang2 == null) {
                $modelLang2 = new TypesLang();

                $modelLang2->rid = $modelLang->rid;
                $modelLang2->lang = Yii::$app->language;

                $sourceLanguageCode = substr($lang1, 0, 2);
                $targetLanguageCode = substr($lang2, 0, 2);

                $title = (string)Yii::$app->yandexTranslation->getTranslate(
                    $modelLang->title,
                    $sourceLanguageCode,
                    $targetLanguageCode
                );

                $plural_name = (string)Yii::$app->yandexTranslation->getTranslate(
                    $modelLang->plural_name,
                    $sourceLanguageCode,
                    $targetLanguageCode
                );

                if ($title != '') {
                    $transaction = $modelLang2::getDb()->beginTransaction();
                    try {
                        $modelLang2->title = $title;
                        $modelLang2->plural_name = $plural_name;

                        $modelLang2->setScenario('backend');

                        if ($saveLang[] = intval($modelLang2->save())) {
                            $transaction->commit();
                            $this->stdout("save " . $targetLanguageCode . " \n", Console::FG_GREEN);
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

        $this->stdout("Translate Types: finish. \n", Console::FG_GREEN);
    }
}
