<?php

namespace console\controllers;

use Yii;
use yii\helpers\ArrayHelper;
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
    public function actionIndex()
    {
        // UPDATE `fv_catalog_item` SET `mark`='0' WHERE `mark`='1'

        $this->stdout("ElasticSearch: start. \n", Console::FG_GREEN);

        $models = Product::find()
            ->innerJoinWith(['lang', 'factory', 'types'])
            ->orderBy(Product::tableName() . '.updated_at DESC')
            ->enabled()
            ->andFilterWhere([
                Product::tableName() . '.removed' => '0',
                'mark' => '0',
            ])
            ->limit(1000)
            ->all();

        foreach ($models as $product) {
            /** @var PDO $transaction */
            /** @var $product Product */
            $transaction = $product::getDb()->beginTransaction();
            try {

                $product->setScenario('setMark');

                $product->mark = '1';

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