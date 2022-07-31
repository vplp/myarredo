<?php

namespace common\modules\catalog\models;

use common\actions\upload\UploadBehavior;
use common\modules\catalog\Catalog;
use yii\helpers\ArrayHelper;
use Yii;

class FactorySamplesFiles extends FactoryFile
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'uploadBehavior' => [
                'class' => UploadBehavior::class,
                'attributes' => [
                    'file_link' => [
                        'path' => Yii::$app->getModule('catalog')->getFactorySamplesFilesUploadPath(),
                        'tempPath' => Yii::getAlias('@temp'),
                        'url' => Yii::$app->getModule('catalog')->getFactorySamplesFilesUploadPath(),
                    ]
                ]
            ],
        ]);
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $this->file_size = self::getFileSize();

        return parent::beforeValidate();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            ['file_type', 'default', 'value' => '3'],
        ]);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->andWhere([self::tableName() . '.file_type' => '3']);
    }

    /**
     * @return null|string
     */
    public function getFileLink()
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getFactorySamplesFilesUploadPath();
        $url = $module->getFactorySamplesFilesUploadUrl();

        $image = null;

        if (!empty($this->file_link) && is_file($path . '/' . $this->file_link)) {
            $image = $url . '/' . $this->file_link;
        }

        return $image;
    }

    /**
     * @return null|string
     */
    public function getFileSize()
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getFactoryCatalogsFilesUploadPath();

        $file_size = 0;

        if (!empty($this->file_link) && is_file($path . '/' . $this->file_link)) {
            $file_size = filesize($path . '/' . $this->file_link);
        }

        return $file_size;
    }

    /**
     * @return null|string
     */
    public function getImageLink(): ?string
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getFactorySamplesFilesUploadPath();
        $url = $module->getFactorySamplesFilesUploadUrl();

        $image = null;

        if (!empty($this->image_link) && is_file($path . '/thumb/' . $this->image_link)) {
            $image = $url . '/thumb/' . $this->image_link;
        }

        return $image;
    }
}