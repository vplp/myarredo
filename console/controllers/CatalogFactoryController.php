<?php

namespace console\controllers;

use Yii;
use Imagick;
use yii\helpers\Console;
use yii\console\Controller;
use common\modules\catalog\models\{
    FactoryFile, Factory, FactoryLang
};
use frontend\modules\sys\models\Language;

/**
 * Class CatalogFactoryController
 *
 * @package console\controllers
 */
class CatalogFactoryController extends Controller
{
    /**
     * @param string $folder factoryFileCatalog|factoryFilePrice
     */
    public function actionClearPdfInFolder($folder = 'factoryFileCatalog')
    {
        $this->stdout("ClearPdfInFolder: start. \n", Console::FG_GREEN);

        $handle = scandir('web/uploads/' . $folder);
        $path = Yii::getAlias('@uploads') . '/' . $folder;

        foreach ($handle as $key => $file) {
            if (is_file($path . '/' . $file)) {
                $model = FactoryFile::find()
                    ->andFilterWhere([
                        'file_link' => $file,
                    ])
                    ->asArray()
                    ->one();

                if ($model == null) {
                    unlink($path . '/' . $file);
                    $this->stdout("unlink " . $file . "\n", Console::FG_GREEN);
                }
            }
        }

        $this->stdout("ClearPdfInFolder: start. \n", Console::FG_GREEN);
    }

    /**
     * Delete pdf from database
     */
    public function actionClearPdf()
    {
        $this->stdout("ClearPdf: start. \n", Console::FG_GREEN);

        // find deleted items
        $models = FactoryFile::find()
            ->andFilterWhere([
                'mark' => '0',
            ])
            ->limit(100)
            ->deleted()
            ->all();

        foreach ($models as $model) {
            /** @var $model FactoryFile */

            /** @var Catalog $module */
            $module = Yii::$app->getModule('catalog');

            // path
            if ($model->file_type == 1) {
                $path = $module->getFactoryCatalogsFilesUploadPath();
            } else {
                $path = $module->getFactoryPricesFilesUploadPath();
            }

            $this->stdout($model->id . "\n", Console::FG_GREEN);

            $model->setScenario('unlinkFile');

            // delete file_link
            if (!empty($model->file_link) && is_file($path . '/' . $model->file_link)) {
                unlink($path . '/' . $model->file_link);

                $this->stdout("unlink " . $path . '/' . $model->file_link . "\n", Console::FG_GREEN);
            }

            $model->file_link = '';
            $model->file_size = 0;

            // delete image_link
            if (!empty($model->image_link) && is_file($path . '/thumb/' . $model->image_link)) {
                unlink($path . '/thumb/' . $model->image_link);
                $this->stdout("unlink " . $path . '/thumb/' . $model->image_link . "\n", Console::FG_GREEN);
            }

            $model->image_link = '';

            // save
            $model->mark = '1';
            $model->save();
        }

        $this->stdout("ClearPdf: start. \n", Console::FG_GREEN);
    }

    /**
     * Generate product it title
     */
    public function actionGeneratePdfPreview()
    {
        $this->stdout("GeneratePdfPreview: start. \n", Console::FG_GREEN);

        $models = FactoryFile::find()
            ->andWhere([
                FactoryFile::tableName() . '.image_link' => null,
                FactoryFile::tableName() . '.file_type' => 1,
                //FactoryFile::tableName() . '.factory_id' => 220
            ])
            ->orderBy(FactoryFile::tableName() . '.id DESC')
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

        $this->stdout("GeneratePdfPreview: finish. \n", Console::FG_GREEN);
    }

    /**
     * @param string $mark
     * @throws \yii\db\Exception
     */
    public function actionResetMark($mark = 'mark')
    {
        $this->stdout("Reset " . $mark . ": start. \n", Console::FG_GREEN);

        Yii::$app->db->createCommand()
            ->update(Factory::tableName(), [$mark => '0'], $mark . "='1'")
            ->execute();

        $this->stdout("Reset " . $mark . ": finish. \n", Console::FG_GREEN);
    }

    /**
     * Translate
     */
    public function actionTranslate()
    {
        $this->stdout("Translate: start. \n", Console::FG_GREEN);

        // Factory
        $models = Factory::find()
            ->andFilterWhere([
                'mark' => '0',
            ])
            ->limit(3)
            ->orderBy(Factory::tableName() . '.id DESC')
            ->all();

        // languages
        $modelLanguage = new Language();
        $languages = $modelLanguage->getLanguages();

        foreach ($models as $model) {
            /** @var PDO $transaction */
            /** @var $model Factory */

            $saveLang = [];

            $this->stdout("ID = " . $model->id . " \n", Console::FG_GREEN);

            foreach ($languages as $language) {
                Yii::$app->language = $language['local'];
                $currentLanguage = Yii::$app->language;

                /** @var $modelLang FactoryLang */
                $modelLang = FactoryLang::find()
                    ->where([
                        'rid' => $model->id,
                    ])
                    ->one();

                if ($modelLang != null) {
                    foreach ($languages as $language2) {
                        if ($language2['local'] != $currentLanguage) {
                            Yii::$app->language = $language2['local'];

                            /** @var $modelLang2 FactoryLang */
                            $modelLang2 = FactoryLang::find()
                                ->where([
                                    'rid' => $model->id,
                                    'lang' => Yii::$app->language,
                                ])
                                ->one();

                            if ($modelLang2 == null) {
                                $modelLang2 = new FactoryLang();
                                $modelLang2->rid = $model->id;
                                $modelLang2->lang = Yii::$app->language;

                                $sourceLanguageCode = substr($currentLanguage, 0, 2);
                                $targetLanguageCode = substr($language2['local'], 0, 2);

                                $content = (string)Yii::$app->yandexTranslation->getTranslate(
                                    $modelLang->content,
                                    $sourceLanguageCode,
                                    $targetLanguageCode
                                );

                                if ($content != '') {
                                    $transaction = $modelLang2::getDb()->beginTransaction();
                                    try {
                                        $content = str_replace(
                                            ['& ', ' / ', ' & ', '< p >', '< ', ' >', '&quot ', '&quot>', '# ', ' #', ' = '],
                                            ['&', '/', '&', '<p>', '<', '>', '&quot:', '&quot;>', '#', '#', '='],
                                            $content
                                        );
                                        $content = html_entity_decode($content);
                                        $content = str_replace(
                                            ['< p >', '< ', ' >'],
                                            ['<p>', '<', '>'],
                                            $content
                                        );

                                        $modelLang2->content = $content;

                                        $modelLang2->setScenario('backend');

                                        if ($saveLang[] = intval($modelLang2->save())) {
                                            $transaction->commit();
                                            $this->stdout("save " . $targetLanguageCode . " \n", Console::FG_GREEN);
                                        } else {
                                            foreach ($modelLang2->errors as $attribute => $errors) {
                                                $this->stdout($attribute . ": " . implode('; ', $errors) . " \n", Console::FG_RED);
                                            }
                                        }
                                    } catch (Exception $e) {
                                        $transaction->rollBack();
                                        throw new Exception($e);
                                    }
                                } else {
                                    $saveLang[] = 0;
                                }
                            }
                        }
                    }
                }
            }

            $model->setScenario('mark');
            $model->mark = '1';

            if (!in_array(0, array_values($saveLang))) {
                $model->save();
                $this->stdout("translate ID = " . $model->id . " \n", Console::FG_GREEN);
            } else if (!in_array(1, array_values($saveLang))) {
                $model->save();
                $this->stdout("no translate ID = " . $model->id . " \n", Console::FG_GREEN);
            }


            $this->stdout("-------------------------------" . " \n", Console::FG_GREEN);
        }

        $this->stdout("Translate: finish. \n", Console::FG_GREEN);
    }
}
