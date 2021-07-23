<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\actions\upload\UploadBehavior;

/**
 * Class FactoryCatalogsFiles
 *
 * @package common\modules\catalog\models
 */
class FactoryCatalogsFiles extends FactoryFile
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'uploadBehavior' => [
                'class' => UploadBehavior::class,
                'attributes' => [
                    'file_link' => [
                        'path' => Yii::$app->getModule('catalog')->getFactoryCatalogsFilesUploadPath(),
                        'tempPath' => Yii::getAlias('@temp'),
                        'url' => Yii::$app->getModule('catalog')->getFactoryCatalogsFilesUploadPath(),
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
            ['file_type', 'default', 'value' => '1'],
        ]);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->andWhere([self::tableName() . '.file_type' => '1']);
    }

    /**
     * @return null|string
     */
    public static function getStaticFileLink($model)
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getFactoryCatalogsFilesUploadPath();
        $url = $module->getFactoryCatalogsFilesUploadUrl();

        $image = null;

        if (!empty($model->file_link) && is_file($path . '/' . $model->file_link)) {
            $image = $url . '/' . $model->file_link;
        }

        return $image;
    }

    /**
     * @return null|string
     */
    public function getFileLink()
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getFactoryCatalogsFilesUploadPath();
        $url = $module->getFactoryCatalogsFilesUploadUrl();

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
    public function getImageLink()
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getFactoryCatalogsFilesUploadPath();
        $url = $module->getFactoryCatalogsFilesUploadUrl();

        $image = null;

        if (!empty($this->image_link) && is_file($path . '/thumb/' . $this->image_link)) {
            $image = $url . '/thumb/' . $this->image_link;
        }

        return $image;
    }

    /**
     * @return array|int|string|string[]
     */
    public function getTitle()
    {
        $search = [
            'Каталог товаров-',
            'Каталог товаров_',
            'Каталог_',
            'Каталог тканей и отделок - ',
            'Каталог и отделок тканей - ',
            'Каталог отделок - ',
            'Каталог тканей - ',
            'Каталог тканей-',
            'Каталог мебели-',
            'Каталог мебели - '
        ];
        $replace = '';

        $lang = substr(Yii::$app->language, 0, 2);

        return $lang == 'ru' ? $this->title : str_replace($search, $replace, $this->title);
    }
}
