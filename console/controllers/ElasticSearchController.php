<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
//
use frontend\modules\catalog\models\ElasticSearchProduct;
//
use common\modules\catalog\models\{
    Product, ProductLang
};
use common\modules\sys\models\Language;

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
            ->orderBy(Product::tableName() . '.id ASC')
            ->limit(20)
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

                    /** @var $modelLang ProductLang */
                    $modelLang = ProductLang::find()
                        ->where([
                            'rid' => $model->id,
                        ])
                        ->one();

                    if ($modelLang != null) {
                        $product = $model + $modelLang;

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
