<?php

namespace console\controllers;

use Yii;
use yii\db\Exception;
use yii\helpers\Console;
use yii\console\Controller;
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
     * @param string $mark
     * @throws Exception
     */
    public function actionResetItalianProductMark($mark = 'mark')
    {
        $this->stdout("Reset " . $mark . ": start. \n", Console::FG_GREEN);

        Yii::$app->db->createCommand()
            ->update(ItalianProduct::tableName(), [$mark => '0'], $mark . "='1'")
            ->execute();

        $this->stdout("Reset " . $mark . ": finish. \n", Console::FG_GREEN);
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

                                $sourceLanguageCode = substr($currentLanguage, 0, 2);
                                $targetLanguageCode = substr($language2['local'], 0, 2);

                                $this->stdout("targetLanguageCode " . $targetLanguageCode . " \n", Console::FG_GREEN);

                                $translateTitle = (string)Yii::$app->yandexTranslation->getTranslate(
                                    $modelLang->title,
                                    $sourceLanguageCode,
                                    $targetLanguageCode
                                );

                                $translateDescription = (string)Yii::$app->yandexTranslation->getTranslate(
                                    str_replace("&nbsp;", ' ', strip_tags($modelLang->description)),
                                    $sourceLanguageCode,
                                    $targetLanguageCode
                                );

                                $translateDefects = (string)Yii::$app->yandexTranslation->getTranslate(
                                    str_replace("&nbsp;", ' ', strip_tags($modelLang->defects)),
                                    $sourceLanguageCode,
                                    $targetLanguageCode
                                );

                                if ($translateTitle != '') {
                                    $transaction = $modelLang2::getDb()->beginTransaction();
                                    try {
                                        $modelLang2->title = $translateTitle;
                                        $modelLang2->description = $translateDescription;
                                        $modelLang2->defects = $translateDefects;

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
                                } else {
                                    $saveLang[] = 0;
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

                                    $sourceLanguageCode = substr($currentLanguage, 0, 2);
                                    $targetLanguageCode = substr($language2['local'], 0, 2);

                                    $this->stdout("targetLanguageCode " . $targetLanguageCode . " \n", Console::FG_GREEN);

                                    $translateTitle = (string)Yii::$app->yandexTranslation->getTranslate(
                                        $modelLang->title,
                                        $sourceLanguageCode,
                                        $targetLanguageCode
                                    );

                                    $translateDescription = (string)Yii::$app->yandexTranslation->getTranslate(
                                        str_replace("&nbsp;", ' ', strip_tags($modelLang->description)),
                                        $sourceLanguageCode,
                                        $targetLanguageCode
                                    );

                                    $translateDefects = (string)Yii::$app->yandexTranslation->getTranslate(
                                        str_replace("&nbsp;", ' ', strip_tags($modelLang->defects)),
                                        $sourceLanguageCode,
                                        $targetLanguageCode
                                    );

                                    if ($translateTitle != '') {
                                        $transaction = $modelLang2::getDb()->beginTransaction();
                                        try {
                                            $modelLang2->title = $translateTitle;
                                            $modelLang2->description = $translateDescription;
                                            $modelLang2->defects = $translateDefects;

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
                                    } else {
                                        $saveLang[] = 0;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $model->setScenario('mark');
            $model->mark = '1';

            if (!in_array(0, array_values($saveLang))) {
                $model->save();
                $this->stdout("translate ID = " . $model->id . " \n", Console::FG_GREEN);
            }

            $this->stdout("-------------------------------" . " \n", Console::FG_GREEN);
        }

        $this->stdout("Translate: finish. \n", Console::FG_GREEN);
    }

    /**
     * @param string $lang1
     * @param string $lang2
     * @param string $mark
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionTranslateProductFromLangToLang($lang1 = 'ru-RU', $lang2 = 'uk-UA', $mark = 'mark2')
    {
        $this->stdout("Translate ItalianProduct: start. \n", Console::FG_GREEN);

        $models = ItalianProduct::find()
            ->andFilterWhere([
                $mark => '0',
            ])
            ->limit(50)
            ->orderBy(ItalianProduct::tableName() . '.id ASC')
            ->all();

        foreach ($models as $model) {
            /** @var PDO $transaction */
            /** @var $model ItalianProduct */

            Yii::$app->language = $lang1;

            /** @var $modelLang ItalianProductLang */
            $modelLang = ItalianProductLang::find()
                ->where([
                    'rid' => $model->id,
                    'lang' => $lang1,
                ])
                ->one();

            $save = false;

            if ($modelLang != null) {
                Yii::$app->language = $lang2;

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

                    $sourceLanguageCode = substr($lang1, 0, 2);
                    $targetLanguageCode = substr($lang2, 0, 2);

                    $title = (string)Yii::$app->yandexTranslation->getTranslate(
                        $modelLang->title,
                        $sourceLanguageCode,
                        $targetLanguageCode
                    );

                    $description = (string)Yii::$app->yandexTranslation->getTranslate(
                        str_replace("&nbsp;", ' ', strip_tags($modelLang->description)),
                        $sourceLanguageCode,
                        $targetLanguageCode
                    );

                    if ($title != '') {
                        $transaction = $modelLang2::getDb()->beginTransaction();
                        try {
                            $modelLang2->title = $title;
                            $modelLang2->description = $description;

                            $modelLang2->setScenario('backend');

                            if ($save = $modelLang2->save()) {
                                $transaction->commit();
                                $this->stdout("translate ID = " . $model->id . " " . $lang2 . " \n", Console::FG_GREEN);
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
                    $save = true;
                }

                if ($save) {
                    $this->stdout("translate ID = " . $model->id . " \n", Console::FG_GREEN);
                    $model->setScenario($mark);
                    $model->$mark = '1';
                    $model->save();
                }
            }
        }

        $this->stdout("Translate ItalianProduct: finish. \n", Console::FG_GREEN);
    }

    /**
     * @param string $mark
     * @throws Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionGenerateTitle($mark = 'mark3')
    {
        $this->stdout("GenerateTitle ItalianProduct: start. \n", Console::FG_GREEN);

        // products
        $models = ItalianProduct::find()
            ->andFilterWhere([
                $mark => '0',
            ])
            ->limit(200)
            ->orderBy(ItalianProduct::tableName() . '.id ASC')
            ->all();

        // languages
        $modelLanguage = new Language();
        $languages = $modelLanguage->getLanguages();

        foreach ($models as $model) {
            /** @var PDO $transaction */
            /** @var $model ItalianProduct */

            $saveLang = [];

            $this->stdout("ID = " . $model->id . " \n", Console::FG_GREEN);

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
                    $transaction = $modelLang::getDb()->beginTransaction();
                    try {
                        $modelLang->setScenario('frontend');

                        $modelLang->title = '';
                        $modelLang->title_for_list = '';

                        if ($saveLang[] = intval($modelLang->save())) {
                            $transaction->commit();
                            $this->stdout("save " . $modelLang->lang . " \n", Console::FG_GREEN);
                        } else {
                            foreach ($modelLang->errors as $attribute => $errors) {
                                $this->stdout($attribute . ": " . implode('; ', $errors) . " \n", Console::FG_RED);
                            }
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                        throw new Exception($e);
                    }
                }
            }

            $model->setScenario($mark);
            $model->$mark = '1';

            if ($model->save() && !in_array(0, array_values($saveLang))) {
                $this->stdout("generate ID = " . $model->id . " \n", Console::FG_GREEN);
            }

            $this->stdout("-------------------------------" . " \n", Console::FG_GREEN);
        }

        $this->stdout("GenerateTitle ItalianProduct: finish. \n", Console::FG_GREEN);
    }

    /**
     * @param string $mark
     * @throws Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionGenerateAlias()
    {
        $this->stdout("actionGenerateAlias: start. \n", Console::FG_GREEN);

        $models = ItalianProduct::find()
            ->andFilterWhere([
                'mark3' => '0',
            ])
            ->limit(200)
            ->orderBy(ItalianProduct::tableName() . '.id ASC')
            ->all();

        foreach ($models as $model) {
            $model->setScenario('setAlias');
            $model->mark3 = '1';

            if ($model->save()) {
                $this->stdout("generate ID = " . $model->id . " \n", Console::FG_GREEN);
            }
        }

        $this->stdout("actionGenerateAlias: finish. \n", Console::FG_GREEN);
    }
}
