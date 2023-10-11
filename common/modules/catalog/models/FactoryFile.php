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
 * @property integer $mark
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
            [['published', 'deleted', 'mark'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['file_type'], 'in', 'range' => [1, 2, 3]],
            [['title', 'image_link'], 'string', 'max' => 255],
            [['file_link'], 'string', 'max' => 255],
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
            'unlinkFile' => ['mark', 'file_link', 'file_size', 'image_link'],
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
                'deleted',
                'mark',
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
            'file_link' => Yii::t('app', 'File'),
            'image_link' => Yii::t('app', 'Image link'),
            'file_type',
            'file_size',
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'mark',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (in_array($this->scenario, ['backend'])) {
            $this->mark = '0';
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->orderBy(self::tableName() . '.updated_at DESC');
    }

    public function getFactory()
    {
        return $this->hasOne(Factory::class, ['id' => 'factory_id']);
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
            'Каталог мебели - ',
            'Прайс-лист-',
            'Прайс-лист - ',
            'Прайс-лист -',
            'Прайс-лист ',
            'Прайс-лист',
        ];
        $replace = '';

        $lang = substr(Yii::$app->language, 0, 2);

        return $lang == 'ru' ? $this->title : str_replace($search, $replace, $this->title);
    }

    /**
     * @return array|int|string|string[]
     */
    public static function getStaticTitle($model)
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
            'Каталог мебели - ',
            'Прайс-лист-',
            'Прайс-лист - ',
            'Прайс-лист -',
            'Прайс-лист ',
            'Прайс-лист',
        ];
        $replace = '';

        $lang = substr(Yii::$app->language, 0, 2);

        return $lang == 'ru' ? $model->title : str_replace($search, $replace, $model->title);
    }
}
