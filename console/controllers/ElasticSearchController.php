<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
//
use frontend\modules\catalog\models\{
    ElasticSearchProduct, ElasticSearchSale, ElasticSearchItalianProduct
};
//
use common\modules\catalog\models\{
    Product, Sale, ItalianProduct
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
    public function actionResetProductMark()
    {
        $this->stdout("ResetProductMark: start. \n", Console::FG_GREEN);

        Yii::$app->db->createCommand()
            ->update(Product::tableName(), ['mark1' => '0'], "`mark1`='1'")
            ->execute();

        $this->stdout("ResetProductMark: finish. \n", Console::FG_GREEN);
    }

    /**
     * @throws \yii\db\Exception
     */
    public function actionResetSaleMark()
    {
        $this->stdout("ResetSaleMark: start. \n", Console::FG_GREEN);

        Yii::$app->db->createCommand()
            ->update(Sale::tableName(), ['mark1' => '0'], "`mark1`='1'")
            ->execute();

        $this->stdout("ResetSaleMark: finish. \n", Console::FG_GREEN);
    }

    /**
     * @throws \yii\db\Exception
     */
    public function actionResetItalianProductMark()
    {
        $this->stdout("ResetItalianProductMark: start. \n", Console::FG_GREEN);

        Yii::$app->db->createCommand()
            ->update(ItalianProduct::tableName(), ['mark1' => '0'], "`mark1`='1'")
            ->execute();

        $this->stdout("ResetItalianProductMark: finish. \n", Console::FG_GREEN);
    }

    /**
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAddProduct()
    {
        $this->stdout("AddProduct: start. \n", Console::FG_GREEN);

        $models = Product::find()
            ->innerJoinWith(['factory'])
            ->andFilterWhere([
                Product::tableName() . '.mark1' => '0',
            ])
            ->orderBy(Product::tableName() . '.id ASC')
            ->limit(100)
            ->all();

        foreach ($models as $model) {
            /** @var $model Product */

            if ($model->removed == 0 && $model->published == 1 && $model->deleted == 0 &&
                $model->factory->published == 1 && $model->factory->deleted == 0) {
                /** @var PDO $transaction */
                $transaction = $model::getDb()->beginTransaction();
                try {
                    $model->setScenario('setMark1');
                    $model->mark1 = '1';

                    $modelLanguage = new Language();
                    $languages = $modelLanguage->getLanguages();

                    $saveLang = [];

                    foreach ($languages as $lang) {
                        Yii::$app->language = $lang['local'];

                        /** @var $product Product */
                        $product = Product::findByID($model->id);

                        if (!empty($product->lang)) {
                            $saveLang[] = ElasticSearchProduct::addRecord($product);
                        }
                    }

                    if ($model->save() && !in_array(0, array_values($saveLang))) {
                        $transaction->commit();
                        $this->stdout("add ID=" . $model->id . " \n", Console::FG_GREEN);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw new \Exception($e);
                }
            } else {
                $model->setScenario('setMark1');
                $model->mark1 = '1';

                if ($model->save() && ElasticSearchProduct::deleteRecord($model->id)) {
                    $this->stdout("delete ID=" . $model->id . " \n", Console::FG_GREEN);
                }
            }
        }

        $this->stdout("AddProduct: finish. \n", Console::FG_GREEN);
    }

    /**
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAddSale()
    {
        $this->stdout("AddSale: start. \n", Console::FG_GREEN);

        $models = Sale::find()
            ->andFilterWhere([
                Sale::tableName() . '.mark1' => '0',
            ])
            ->orderBy(Sale::tableName() . '.id ASC')
            ->limit(100)
            ->all();

        foreach ($models as $model) {
            /** @var $model Sale */

            if ($model->published == 1 && $model->deleted == 0) {
                /** @var PDO $transaction */
                $transaction = $model::getDb()->beginTransaction();
                try {
                    $model->setScenario('setMark1');
                    $model->mark1 = '1';

                    $modelLanguage = new Language();
                    $languages = $modelLanguage->getLanguages();

                    $saveLang = [];

                    foreach ($languages as $lang) {
                        Yii::$app->language = $lang['local'];

                        /** @var $product Sale */
                        $product = Sale::findByID($model->id);

                        if (!empty($product->lang)) {
                            $saveLang[] = ElasticSearchSale::addRecord($product);
                        }
                    }

                    if ($model->save() && !in_array(0, array_values($saveLang))) {
                        $transaction->commit();
                        $this->stdout("add ID=" . $model->id . " \n", Console::FG_GREEN);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw new \Exception($e);
                }
            } else {
                $model->setScenario('setMark1');
                $model->mark1 = '1';

                if ($model->save() && ElasticSearchSale::deleteRecord($model->id)) {
                    $this->stdout("delete ID=" . $model->id . " \n", Console::FG_GREEN);
                }
            }
        }

        $this->stdout("AddSale: finish. \n", Console::FG_GREEN);
    }

    /**
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAddItalianProduct()
    {
        $this->stdout("AddItalianProduct: start. \n", Console::FG_GREEN);

        $models = ItalianProduct::find()
            ->andFilterWhere([
                ItalianProduct::tableName() . '.mark1' => '0',
            ])
            ->orderBy(ItalianProduct::tableName() . '.id ASC')
            ->limit(100)
            ->all();

        foreach ($models as $model) {
            /** @var $model ItalianProduct */

            if ($model->published == 1 && $model->deleted == 0) {
                /** @var PDO $transaction */
                $transaction = $model::getDb()->beginTransaction();
                try {
                    $model->setScenario('setMark1');
                    $model->mark1 = '1';

                    $modelLanguage = new Language();
                    $languages = $modelLanguage->getLanguages();

                    $saveLang = [];

                    foreach ($languages as $lang) {
                        Yii::$app->language = $lang['local'];

                        /** @var $product ItalianProduct */
                        $product = ItalianProduct::findByID($model->id);

                        if (!empty($product->lang)) {
                            $saveLang[] = ElasticSearchItalianProduct::addRecord($product);
                        }
                    }

                    if ($model->save() && !in_array(0, array_values($saveLang))) {
                        $transaction->commit();
                        $this->stdout("add ID=" . $model->id . " \n", Console::FG_GREEN);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw new \Exception($e);
                }
            } else {
                $model->setScenario('setMark1');
                $model->mark1 = '1';

                if ($model->save() && ElasticSearchItalianProduct::deleteRecord($model->id)) {
                    $this->stdout("delete ID=" . $model->id . " \n", Console::FG_GREEN);
                }
            }
        }

        $this->stdout("AddItalianProduct: finish. \n", Console::FG_GREEN);
    }
}
