<?php

namespace console\controllers;

use Yii;
use yii\db\Exception;
use yii\helpers\Console;
use yii\console\Controller;
use common\modules\location\models\{CityLang, RegionLang};
use common\modules\sys\modules\translation\models\Message;
use common\modules\catalog\models\{Category,
    CategoryLang,
    ColorsLang,
    SpecificationLang,
    SubTypesLang,
    Types,
    TypesLang,
    Specification,
    Colors,
    Product,
    ItalianProduct
};

/**
 * Class CatalogTranslateController
 *
 * @package console\controllers
 */
class CatalogTranslateController extends Controller
{
    /**
     * @param string $lang
     */
    public function actionCategoryAlias($lang = 'he-IL')
    {
        $this->stdout("CategoryAlias: start. \n", Console::FG_GREEN);

        Yii::$app->language = $lang;

        $models = Category::findBase()->all();

        foreach ($models as $model) {
            /** @var $model Category */
            $model->setScenario('backend');
            $model->alias_he = $model->alias_en;
            $model->save();
        }

        $this->stdout("CategoryAlias: finish. \n", Console::FG_GREEN);
    }

    /**
     * @param string $lang
     */
    public function actionTypesAlias($lang = 'he-IL')
    {
        $this->stdout("TypesAlias: start. \n", Console::FG_GREEN);

        Yii::$app->language = $lang;

        $models = Types::findBase()->all();

        foreach ($models as $model) {
            /** @var $model Types */
            $model->setScenario('backend');
            $model->alias_he = $model->alias_en;
            $model->save();
        }

        $this->stdout("TypesAlias: finish. \n", Console::FG_GREEN);
    }

    /**
     * @param string $lang
     */
    public function actionSpecificationAlias($lang = 'he-IL')
    {
        $this->stdout("SpecificationAlias: start. \n", Console::FG_GREEN);

        Yii::$app->language = $lang;

        $models = Specification::findBase()->all();

        foreach ($models as $model) {
            /** @var $model Specification */
            $model->setScenario('backend');
            $model->alias_he = $model->alias_en;
            $model->save();
        }

        $this->stdout("SpecificationAlias: finish. \n", Console::FG_GREEN);
    }

    /**
     * @param string $lang
     */
    public function actionColorsAlias($lang = 'he-IL')
    {
        $this->stdout("ColorsAlias: start. \n", Console::FG_GREEN);

        Yii::$app->language = $lang;

        $models = Colors::findBase()->all();

        foreach ($models as $model) {
            /** @var $model Colors */
            $model->setScenario('backend');
            $model->alias_he = $model->alias_en;
            $model->save();
        }

        $this->stdout("ColorsAlias: finish. \n", Console::FG_GREEN);
    }

    /**
     * @param string $lang
     */
    public function actionProductAlias($lang = 'he-IL')
    {
        $this->stdout("ProductAlias: start. \n", Console::FG_GREEN);

        Yii::$app->language = $lang;

        $models = Product::findBase()->all();

        foreach ($models as $model) {
            /** @var $model Product */
            $model->setScenario('backend');
            $model->alias_he = $model->alias_en;
            $model->save();
        }

        $this->stdout("ProductAlias: finish. \n", Console::FG_GREEN);
    }

    /**
     * @param string $lang
     */
    public function actionItalianProductAlias($lang = 'he-IL')
    {
        $this->stdout("ItalianProductAlias: start. \n", Console::FG_GREEN);

        Yii::$app->language = $lang;

        $models = ItalianProduct::findBase()->all();

        foreach ($models as $model) {
            /** @var $model ItalianProduct */
            $model->setScenario('backend');
            $model->alias_he = $model->alias_en;
            $model->save();
        }

        $this->stdout("ItalianProductAlias: finish. \n", Console::FG_GREEN);
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

    /**
     * @param string $lang1
     * @param string $lang2
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionTranslateSubTypes($lang1 = 'ru-RU', $lang2 = 'uk-UA')
    {
        $this->stdout("Translate SubTypes: start. \n", Console::FG_GREEN);

        Yii::$app->language = $lang1;

        $models = SubTypesLang::find()->all();

        foreach ($models as $modelLang) {
            Yii::$app->language = $lang2;

            /** @var $modelLang SubTypesLang */
            /** @var $modelLang2 SubTypesLang */

            $modelLang2 = SubTypesLang::find()
                ->where([
                    'rid' => $modelLang->rid,
                    'lang' => Yii::$app->language,
                ])
                ->one();

            if ($modelLang2 == null) {
                $modelLang2 = new SubTypesLang();

                $modelLang2->rid = $modelLang->rid;
                $modelLang2->lang = Yii::$app->language;
            }

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

        $this->stdout("Translate SubTypes: finish. \n", Console::FG_GREEN);
    }

    /**
     * @param string $lang1
     * @param string $lang2
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionTranslateColors($lang1 = 'ru-RU', $lang2 = 'uk-UA')
    {
        $this->stdout("Translate Colors: start. \n", Console::FG_GREEN);

        Yii::$app->language = $lang1;

        $models = ColorsLang::find()->all();

        foreach ($models as $modelLang) {
            Yii::$app->language = $lang2;

            /** @var $modelLang ColorsLang */
            /** @var $modelLang2 ColorsLang */

            $modelLang2 = ColorsLang::find()
                ->where([
                    'rid' => $modelLang->rid,
                    'lang' => Yii::$app->language,
                ])
                ->one();

            if ($modelLang2 == null) {
                $modelLang2 = new ColorsLang();

                $modelLang2->rid = $modelLang->rid;
                $modelLang2->lang = Yii::$app->language;
            }

            $sourceLanguageCode = substr($lang1, 0, 2);
            $targetLanguageCode = substr($lang2, 0, 2);

            $title = (string)Yii::$app->yandexTranslation->getTranslate(
                $modelLang->title,
                $sourceLanguageCode,
                $targetLanguageCode
            );

            $plural_title = (string)Yii::$app->yandexTranslation->getTranslate(
                $modelLang->plural_title != '' ? $modelLang->plural_title : $modelLang->title,
                $sourceLanguageCode,
                $targetLanguageCode
            );

            if ($title != '') {
                $transaction = $modelLang2::getDb()->beginTransaction();
                try {
                    $modelLang2->title = $title;
                    $modelLang2->plural_title = $plural_title;

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

        $this->stdout("Translate SubTypes: finish. \n", Console::FG_GREEN);
    }

    /**
     * @param string $lang1
     * @param string $lang2
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionTranslateSpecification($lang1 = 'ru-RU', $lang2 = 'uk-UA')
    {
        $this->stdout("Translate Specification: start. \n", Console::FG_GREEN);

        Yii::$app->language = $lang1;

        $models = SpecificationLang::find()->all();

        foreach ($models as $modelLang) {
            Yii::$app->language = $lang2;

            /** @var $modelLang SpecificationLang */
            /** @var $modelLang2 SpecificationLang */

            $modelLang2 = SpecificationLang::find()
                ->where([
                    'rid' => $modelLang->rid,
                    'lang' => Yii::$app->language,
                ])
                ->one();

            if ($modelLang2 == null) {
                $modelLang2 = new SpecificationLang();

                $modelLang2->rid = $modelLang->rid;
                $modelLang2->lang = Yii::$app->language;

                $sourceLanguageCode = substr($lang1, 0, 2);
                $targetLanguageCode = substr($lang2, 0, 2);

                $title = (string)Yii::$app->yandexTranslation->getTranslate(
                    $modelLang->title,
                    $sourceLanguageCode,
                    $targetLanguageCode
                );

                if ($title != '') {
                    $transaction = $modelLang2::getDb()->beginTransaction();
                    try {
                        $modelLang2->title = $title;

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

        $this->stdout("Translate Specification: finish. \n", Console::FG_GREEN);
    }

    /**
     * @param string $lang1
     * @param string $lang2
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionTranslateCity($lang1 = 'ru-RU', $lang2 = 'uk-UA')
    {
        $this->stdout("Translate City: start. \n", Console::FG_GREEN);

        Yii::$app->language = $lang1;

        $models = CityLang::find()->all();

        foreach ($models as $modelLang) {
            Yii::$app->language = $lang2;

            /** @var $modelLang CityLang */
            /** @var $modelLang2 CityLang */

            $modelLang2 = CityLang::find()
                ->where([
                    'rid' => $modelLang->rid,
                    'lang' => Yii::$app->language,
                ])
                ->one();

            if ($modelLang2 == null) {
                $modelLang2 = new CityLang();

                $modelLang2->rid = $modelLang->rid;
                $modelLang2->lang = Yii::$app->language;
            }

            $sourceLanguageCode = substr($lang1, 0, 2);
            $targetLanguageCode = substr($lang2, 0, 2);

            $title = (string)Yii::$app->yandexTranslation->getTranslate(
                $modelLang->title,
                $sourceLanguageCode,
                $targetLanguageCode
            );

            $title_where = (string)Yii::$app->yandexTranslation->getTranslate(
                $modelLang->title_where != '' ? $modelLang->title_where : $modelLang->title,
                $sourceLanguageCode,
                $targetLanguageCode
            );

            if ($title != '') {
                $transaction = $modelLang2::getDb()->beginTransaction();
                try {
                    $modelLang2->title = $title;
                    $modelLang2->title_where = $title_where;

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

        $this->stdout("Translate City: finish. \n", Console::FG_GREEN);
    }

    /**
     * @param string $lang1
     * @param string $lang2
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionTranslateRegion($lang1 = 'ru-RU', $lang2 = 'uk-UA')
    {
        $this->stdout("Translate Region: start. \n", Console::FG_GREEN);

        Yii::$app->language = $lang1;

        $models = RegionLang::find()->all();

        foreach ($models as $modelLang) {
            Yii::$app->language = $lang2;

            /** @var $modelLang RegionLang */
            /** @var $modelLang2 RegionLang */

            $modelLang2 = RegionLang::find()
                ->where([
                    'rid' => $modelLang->rid,
                    'lang' => Yii::$app->language,
                ])
                ->one();

            if ($modelLang2 == null) {
                $modelLang2 = new RegionLang();

                $modelLang2->rid = $modelLang->rid;
                $modelLang2->lang = Yii::$app->language;
            }

            $sourceLanguageCode = substr($lang1, 0, 2);
            $targetLanguageCode = substr($lang2, 0, 2);

            $title = (string)Yii::$app->yandexTranslation->getTranslate(
                $modelLang->title,
                $sourceLanguageCode,
                $targetLanguageCode
            );

            if ($title != '') {
                $transaction = $modelLang2::getDb()->beginTransaction();
                try {
                    $modelLang2->title = $title;

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

        $this->stdout("Translate City: finish. \n", Console::FG_GREEN);
    }

    /**
     * @param string $lang1
     * @param string $lang2
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionTranslateMessage($lang1 = 'ru-RU', $lang2 = 'de-DE')
    {
        $this->stdout("Translate Message: start. \n", Console::FG_GREEN);

        Yii::$app->language = $lang1;

        $models = Message::find()->all();

        foreach ($models as $modelLang) {
            Yii::$app->language = $lang2;

            /** @var $modelLang Message */
            /** @var $modelLang2 Message */

            $modelLang2 = Message::find()
                ->where([
                    'rid' => $modelLang->rid,
                    'lang' => Yii::$app->language,
                ])
                ->one();

            if ($modelLang2 == null) {
                $modelLang2 = new Message();

                $modelLang2->rid = $modelLang->rid;
                $modelLang2->lang = Yii::$app->language;
            }

            $sourceLanguageCode = substr($lang1, 0, 2);
            $targetLanguageCode = substr($lang2, 0, 2);

            $translation = (string)Yii::$app->yandexTranslation->getTranslate(
                $modelLang->translation,
                $sourceLanguageCode,
                $targetLanguageCode
            );

            if ($translation != '') {
                $transaction = $modelLang2::getDb()->beginTransaction();
                try {
                    $modelLang2->translation = $translation;

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

        $this->stdout("Translate Message: finish. \n", Console::FG_GREEN);
    }
}
