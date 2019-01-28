<?php

namespace console\controllers;

use Yii;
use Imagick;
use yii\log\Logger;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii\console\Controller;
//
use common\modules\catalog\models\{
    Factory, FactoryFile, FactoryCatalogsFiles, FactoryPricesFiles
};

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

//        $pathToImage = Yii::getAlias('@uploads') . '/factoryFileCatalog/thumb';
//
//        if (!is_dir($pathToImage)) {
//            mkdir($pathToImage, 0777, true);
//        }

        $models = FactoryCatalogsFiles::findBase()
            ->andFilterWhere([
                'image_link' => '',
            ])
            ->limit(25)
            ->all();

        foreach ($models as $model) {
            /** @var PDO $transaction */
            /** @var $model FactoryFile */
            $transaction = $model::getDb()->beginTransaction();
            try {
                /** @var Catalog $module */
                $module = Yii::$app->getModule('catalog');

                $path = $module->getFactoryCatalogsFilesUploadPath();

                if (!empty($model->file_link) && is_file($path . '/' . $model->file_link)) {
                    /**
                     * thumb
                     */
                    $pdfFile = $path . '/' . $model->file_link . '[0]';

                    $imageData = new Imagick($pdfFile);

                    $imageData->setImageFormat('jpg');
                    $imageData->resizeImage(
                        200,
                        200,
                        imagick::FILTER_LANCZOS,
                        1,
                        true
                    );

                    $image_link = md5_file($model->file_link);

                    file_put_contents(
                        $path . '/thumb/' . $image_link . '.jpg',
                        $imageData->getImageBlob()
                    );

                    /**
                     * save
                     */
                    $model->setScenario('setMark');

                    $model->image_link = $image_link;

                    if ($model->save()) {
                        $transaction->commit();
                    } else {
                        $transaction->rollBack();
                    }
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw new \Exception($e);
            }
        }

        $this->stdout("TranslateTitle: finish. \n", Console::FG_GREEN);
    }
}
