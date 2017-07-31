<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\{
    ArrayHelper
};
use thread\app\base\models\ActiveRecord;
use common\modules\catalog\Catalog;

/**
 * Class FactoryFile
 *
 * @property integer $id
 * @property integer $factory_id
 * @property integer $discount
 * @property integer $title
 * @property integer $file_link
 * @property integer $file_type
 * @property integer $file_size
 * @property integer $position
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @package common\modules\catalog\models
 */
class FactoryFile extends ActiveRecord
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return Catalog::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%catalog_factory_file}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [

        ]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['factory_id', 'title'], 'required'],
            [['factory_id', 'file_size', 'position', 'created_at', 'updated_at'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['file_type'], 'in', 'range' => [1, 2]],
            [['title', 'file_link'], 'string', 'max' => 255],
            ['position', 'default', 'value' => '0'],
            ['file_type', 'default', 'value' => '1'],
            [['discount'], 'double'],
            ['discount', 'default', 'value' => 0.00],
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if ($this->title == '')
            $this->title = $this->file_link;

        return parent::beforeValidate();
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'position' => ['position'],
            'backend' => [
                'factory_id',
                'discount',
                'title',
                'file_link',
                'file_type',
                'file_size',
                'position',
                'published',
                'deleted'
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'factory_id' => Yii::t('app', 'Factory'),
            'discount',
            'title' => Yii::t('app', 'Title'),
            'file_link',
            'file_type',
            'file_size',
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return null|string
     */
    public function getFactoryFileCatalogsImage()
    {
        $module = Yii::$app->getModule('catalog');
        $path = $module->getFactoryFileCatalogsUploadPath();
        $url = $module->getFactoryFileCatalogsUploadUrl();
        $image = null;
        if (!empty($this->file_link) && is_file($path . '/' . $this->file_link)) {
            $image = $url . '/' . $this->file_link;
        }
        return $image;
    }

    /**
     * @return null|string
     */
    public function getFactoryFilePricesImage()
    {
        $module = Yii::$app->getModule('catalog');
        $path = $module->getFactoryFilePricesUploadPath();
        $url = $module->getFactoryFilePricesUploadUrl();
        $image = null;
        if (!empty($this->file_link) && is_file($path . '/' . $this->file_link)) {
            $image = $url . '/' . $this->file_link;
        }
        return $image;
    }
}