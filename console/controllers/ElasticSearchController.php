<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
//
use frontend\modules\catalog\models\ElasticSearchProduct;
use common\modules\catalog\models\{
    Product
};

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
     * @param string $lang
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAdd($lang = 'ru-RU')
    {
        $this->stdout("ElasticSearch: start. \n", Console::FG_GREEN);

        Yii::$app->language = $lang;

        $models = Product::find()
            ->andFilterWhere([
                'mark1' => '0',
            ])
//            ->innerJoinWith(['lang', 'factory'])
//            ->andFilterWhere([
//                Product::tableName() . '.removed' => '0',
//                Product::tableName() . '.mark1' => '0',
//            ])
            ->enabled()
            ->orderBy(Product::tableName() . '.id DESC')
            ->limit(100)
            ->all();

        foreach ($models as $product) {
            /** @var PDO $transaction */
            /** @var $product Product */
            $transaction = $product::getDb()->beginTransaction();
            try {
                $product->setScenario('setMark1');

                $product->mark1 = '1';

                $save = ElasticSearchProduct::addRecord($product);

                if ($product->save() && $save) {
                    $transaction->commit();
                    $this->stdout("save: ID=" . $product->id . " \n", Console::FG_GREEN);
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
