<?php

namespace console\controllers;

use Yii;
use Imagick;
use yii\log\Logger;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii\console\Controller;
//
use common\modules\catalog\models\{Factory, FactoryFile, FactoryLang};

/**
 * Class CatalogFactoryController
 *
 * @package console\controllers
 */
class CatalogFactoryController extends Controller
{
    /**
     * Generate product it title
     */
    public function actionGeneratePdfPreview()
    {
        $this->stdout("TranslateTitle: start. \n", Console::FG_GREEN);

        $file = Yii::getAlias('@uploads') . '/factoryFileCatalog/bootcamp_2_.pdf[0]';
        $pathToImage = Yii::getAlias('@uploads') . '/factoryFileCatalog';

        var_dump(is_file($file));

        $imagick = new Imagick($file);
        $imagick->setImageFormat('jpg');
        file_put_contents($pathToImage, $imagick);


//        $models = FactoryFile::find()
//            ->andFilterWhere([
//                'image_link' => '',
//            ])
//            ->limit(25)
//            ->orderBy(Factory::tableName() . '.id DESC')
//            ->all();
//
//        foreach ($models as $model) {
//            /** @var PDO $transaction */
//            /** @var $model FactoryFile */
//            $transaction = $model::getDb()->beginTransaction();
//            try {
//                $model->setScenario('setMark');
//
//                $model->image_link = '1';
//
//                if ($model->save()) {
//                    $transaction->commit();
//                } else {
//                    $transaction->rollBack();
//                }
//            } catch (\Exception $e) {
//                $transaction->rollBack();
//                throw new \Exception($e);
//            }
//        }

        $this->stdout("TranslateTitle: finish. \n", Console::FG_GREEN);
    }
}
