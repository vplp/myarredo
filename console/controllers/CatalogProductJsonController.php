<?php

namespace console\controllers;

use Yii;
use yii\db\Exception;
use yii\helpers\Console;
use yii\console\Controller;
use frontend\modules\sys\models\Language;
use common\modules\catalog\models\{Product, ProductJson, ProductLang};

/**
 * Class CatalogProductJsonController
 *
 * @package console\controllers
 */
class CatalogProductJsonController extends Controller
{
    /**
     * @param string $mark
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAdd($mark = 'mark3')
    {
        $this->stdout("AddJson: start. \n", Console::FG_GREEN);

        // products
        $models = Product::find()
            ->andFilterWhere([
                $mark => '0',
            ])
            ->limit(200)
            ->all();

        // languages
//        $modelLanguage = new Language();
//        $languages = $modelLanguage->getLanguages();

        foreach ($models as $model) {
            /** @var PDO $transaction */
            /** @var $model Product */

            $this->stdout("ID = " . $model->id . " \n", Console::FG_GREEN);

//            foreach ($languages as $language) {
//                Yii::$app->language = $language['local'];
//                ProductJson::add($model->id);
//            }

            ProductJson::add($model->id);

            $model->setScenario($mark);
            $model->$mark = '1';
            $model->save();
        }

        $this->stdout("AddJson: finish. \n", Console::FG_GREEN);
    }

    /**
     *
     */
    public function actionDeleteAll()
    {
        ProductJson::deleteAll();
    }
}
