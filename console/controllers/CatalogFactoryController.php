<?php

namespace console\controllers;

use Yii;
use Imagick;
//
use yii\helpers\Console;
use yii\console\Controller;
//
use common\modules\catalog\models\{
    FactoryFile
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

        $models = FactoryFile::find()
            ->andWhere([
                FactoryFile::tableName() . '.image_link' => null,
                FactoryFile::tableName() . '.file_type' => 1,
                FactoryFile::tableName() . '.factory_id' => 220
            ])
            ->orderBy(FactoryFile::tableName() . '.updated_at DESC')
            ->limit(50)
            ->enabled()
            ->all();

        foreach ($models as $model) {
            /** @var $model FactoryFile */
            /** @var Catalog $module */
            $module = Yii::$app->getModule('catalog');

            if ($model->file_type == 1) {
                $path = $module->getFactoryCatalogsFilesUploadPath();
            } else {
                $path = $module->getFactoryPricesFilesUploadPath();
            }

            if (!is_dir($path . '/thumb')) {
                mkdir($path . '/thumb', 0777, true);
            }

            if (!empty($model->file_link) &&
                is_file($path . '/' . $model->file_link) &&
                intval($model->file_size) < 50525085) {
                /**
                 * thumb
                 */
                $pdfFile = $path . '/' . $model->file_link . '[0]';

                try {
                    $imageData = new Imagick($pdfFile);

                    $imageData->setImageFormat('jpg');
                    $imageData->resizeImage(
                        200,
                        200,
                        imagick::FILTER_LANCZOS,
                        1,
                        true
                    );

                    $image_link = $model->id . '.jpg';

                    @file_put_contents(
                        $path . '/thumb/' . $image_link,
                        $imageData->getImageBlob()
                    );

                    /**
                     * save
                     */
                    /** @var PDO $transaction */
                    $transaction = $model::getDb()->beginTransaction();
                    try {
                        $model->setScenario('setImage');

                        $model->image_link = $image_link;

                        if ($model->save()) {
                            $transaction->commit();
                            $this->stdout("ID=" . $model->id . " \n", Console::FG_GREEN);
                        } else {
                            var_dump($model->errors);
                            $transaction->rollBack();
                        }
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        throw new \Exception($e);
                    }
                } catch (\ImagickException $e) {
                    $this->stdout("ERROR ID=" . $model->id . " " . $e->getMessage() . " \n", Console::FG_GREEN);
                }
            }

        }

        $this->stdout("TranslateTitle: finish. \n", Console::FG_GREEN);
    }
}
