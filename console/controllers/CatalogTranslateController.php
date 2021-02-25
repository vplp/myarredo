<?php

namespace console\controllers;

use common\modules\catalog\models\TypesLang;
use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use common\modules\catalog\models\{
    Category, Types, Specification, Colors, Product, ItalianProduct
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
}
