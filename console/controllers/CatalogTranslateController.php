<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use common\modules\catalog\models\Category;

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
            $model->setScenario('backend');
            $model->alias = $model['lang']['title'];
            $model->save();
        }

        $this->stdout("CategoryAlias: finish. \n", Console::FG_GREEN);
    }
}
