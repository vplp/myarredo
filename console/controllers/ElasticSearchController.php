<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
//
use frontend\modules\catalog\models\ElasticSearchProduct;
//
use frontend\modules\catalog\models\{
    Product, ProductLang
};
use frontend\modules\sys\models\Language;

/**
 * Class ElasticSearchController
 *
 * @package console\controllers
 */
class ElasticSearchController extends Controller
{
    /**
     * @throws \yii\db\Exception
     */
    public function actionResetMark()
    {
        $this->stdout("ResetMark: start. \n", Console::FG_GREEN);

        Yii::$app->db->createCommand()
            ->update(Product::tableName(), ['mark1' => '0'], "`mark1`='1'")
            ->execute();

        $this->stdout("ResetMark: finish. \n", Console::FG_GREEN);
    }

    /**
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAdd()
    {
        $this->stdout("ElasticSearch: start. \n", Console::FG_GREEN);

        $models = Product::find()
            ->andFilterWhere([
                Product::tableName() . '.removed' => '0',
                Product::tableName() . '.mark1' => '0',
            ])
            ->enabled()
            ->orderBy(Product::tableName() . '.id DESC')
            ->limit(100)
            ->all();

        foreach ($models as $model) {
            /** @var PDO $transaction */
            /** @var $model Product */
            $transaction = $model::getDb()->beginTransaction();
            try {
                $model->setScenario('setMark1');

                $model->mark1 = '1';

                $modelLanguage = new Language();
                $languages = $modelLanguage->getLanguages();

                $save = false;

                foreach ($languages as $lang) {
                    Yii::$app->language = $lang['local'];

                    /** @var $product Product */
                    $product = Product::findByID($model->id);

                    if (!empty($product->lang)) {
                        $save = ElasticSearchProduct::addRecord($product);
                    }
                }

                if ($model->save() && $save) {
                    $transaction->commit();
                    $this->stdout("save: ID=" . $model->id . " \n", Console::FG_GREEN);
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw new \Exception($e);
            }
        }

        $this->stdout("ElasticSearch: finish. \n", Console::FG_GREEN);
    }
}
