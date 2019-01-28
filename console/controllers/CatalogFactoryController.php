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

        $pdfFile = Yii::getAlias('@uploads') . '/factoryFileCatalog/02_day_pdf.pdf[0]';

        $pathToImage = Yii::getAlias('@uploads') . '/factoryFileCatalog/img';

        if (!is_dir($pathToImage)) {
            mkdir($pathToImage, 0777, true);
        }

        var_dump(is_file($pdfFile));

        $imageData = new Imagick($pdfFile);

        $size = $imageData->getImageSize();
        var_dump($size);

        //$imageData->setResolution(200, 200);

        $imageData->setImageFormat('jpg');

        //$imageData->setbackgroundcolor('rgb(64, 64, 64)');
        $imageData->resizeImage(200, 200, imagick::FILTER_LANCZOS, 1, true);
        //$imagick->thumbnailImage(100, 100, true, true);
        //header("Content-Type: image/jpg");
        //echo $imageData->getImageBlob();

        file_put_contents($pathToImage . '/test.jpg', $imageData->getImageBlob());


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
