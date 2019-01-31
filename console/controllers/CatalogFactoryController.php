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

        $models = FactoryFile::findBase()
            ->where(['image_link' => null])
            //->filterWhere(['image_link' => null])
            //->where(['image_link' => true, 'image_link' => ''])
            //->andWhere(['is', ['image_link' => null]])
            //
            //->andFilterWhere(['in', FactoryFile::tableName() . '.image_link', ['null', '']])
            //->andFilterWhere(['is', 'image_link', new \yii\db\Expression('null')])
            ->limit(20)
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

                $image_link = $model->id . '.jpg';

                file_put_contents(
                    $path . '/thumb/' . $image_link,
                    $imageData->getImageBlob()
                );

                /**
                 * save
                 */
                $model->setScenario('setImage');

                $model->image_link = $image_link;

                if ($model->save()) {
                    $this->stdout("ID=" . $model->id . " \n", Console::FG_GREEN);
                } else {
                    var_dump($model->errors);
                }
            } else {
                $this->stdout("test ID=" . $model->id . " \n", Console::FG_GREEN);
//                $model->setScenario('setImage');
//                $model->image_link = 'test.jpg';
//                $model->save();
            }
        }

        $this->stdout("TranslateTitle: finish. \n", Console::FG_GREEN);
    }
}
