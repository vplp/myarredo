<?php

namespace common\modules\catalog\models;

use Yii;
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
 * @property integer $image_link
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
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
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
    public function rules()
    {
        return [
            [['factory_id'], 'required'],
            [['factory_id', 'file_size', 'position', 'created_at', 'updated_at'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['file_type'], 'in', 'range' => [1, 2]],
            [['title', 'image_link'], 'string', 'max' => 255],
            [
                'file_link',
                'file',
                //'extensions' => ['pdf'],
                //'wrongExtension' => 'Only PDF files are allowed for {attribute}.',
                //'wrongMimeType' => 'Only PDF files are allowed for {attribute}.',
                //'skipOnEmpty' => false,
                //'mimeTypes' => ['application/pdf']
            ],
            [['file_link'], 'safe'],
            //[['file_link'], 'string', 'max' => 255],
            ['position', 'default', 'value' => '0'],
            [['discount'], 'double'],
            ['discount', 'default', 'value' => 0.00],
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $this->title = ($this->title == '') ? $this->file_link : $this->title;

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
            'setImage' => ['image_link'],
            'backend' => [
                'factory_id',
                'discount',
                'title',
                'file_link',
                'image_link',
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
            'discount' => Yii::t('app', 'Discount'),
            'title' => Yii::t('app', 'Title'),
            'file_link',
            'image_link',
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
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->orderBy(self::tableName() . '.updated_at DESC');
    }
}
